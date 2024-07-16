<?php

namespace Upload;

use Bitrix\Main\UserTable;
use Bitrix\Main\GroupTable;
use Bitrix\Main\UserGroupTable;
use CUser;

/**
 * Обработка информации из файла по пользователям из 1С.
 */
class UserUploadForm1c
{
    const FILE_CONTENT = [];
    const USER_GROUPS = [];
    const USER_GROUPS_IDS = [];

    /** @var CUser */
    private $user;

    public function __construct()
    {
        $this->getUserGroups();

        global $USER;
        $this->user = $USER;
    }

    /**
     * Загружает пользовательские группы для скидок
     */
    private function getUserGroups()
    {
        $gprous = GroupTable::getList([
            'select'  => ['NAME', 'ID', 'STRING_ID'],
            'filter'  => ['%STRING_ID' => 'DISCOUNT_']
        ])->fetchAll();

        foreach ($gprous as $group) {
            $this->USER_GROUPS[substr($group['STRING_ID'], 9)] = $group;
            $this->USER_GROUPS_IDS[] = $group['ID'];
        }
    }

    /**
     * Запускает цепочку действий
     * @return array
     */
    public function handleUserFile(): void
    {
        $this->parseFile();
        $this->handleUsers();
    }

    /**
     * Читает файл из 1С
     * @return void
     */
    private function parseFile(): void
    {
        $z = new \XMLReader;
        $z->open($_SERVER['DOCUMENT_ROOT'] . USER_FILE_PATH_FROM_1C);

        while ($z->nodeType != \XMLReader::ELEMENT) {
            if (!$z->read()) {
                $z->close();
                return;
            }
        }
        if ($z->localName == 'Клиенты') {
            $str = $z->readOuterXML();
            $sxml = simplexml_load_string($str);
            $this->FILE_CONTENT = (array)$sxml;
        }
    }

    /**
     * Итератор пользователей
     * @return void
     */
    private function handleUsers(): void
    {
        if (!empty($this->FILE_CONTENT)) {
            foreach ($this->FILE_CONTENT['Клиент'] as $key => $client) {
                $this->handleUser((array)$client);
            }
        }
    }

    /**
     * Обрабатывает одного пользователя
     * @param array $client
     * @return void
     */
    private function handleUser($client = []): void
    {
        if (!empty($client)) {
            $phone = $this->formatPhone($client['Штрихкод']);
            if ($phone != '') {
                $users = UserTable::getList(array(
                    'filter' => array(
                        'PERSONAL_PHONE' => $phone,
                    ),
                    'select' => array('*'),
                ))->fetchAll();
                if (!empty($users)) {
                    $this->updateUser($users, $client);
                } else {
                    $this->addUser($phone, $client);
                }
            }
        }
    }

    /**
     * Обновляет пользователя
     * @return void
     * @param array $users
     * @param array $client
     */
    private function updateUser($users, $client): void
    {
        foreach ($users as $user) {
            $groups = UserTable::getUserGroupIds($user['ID']);

            if (isset($this->USER_GROUPS[$client['Процент']]) && array_search($this->USER_GROUPS[$client['Процент']]['ID'], $groups) === false) {
                // Сначала проверим, принадлежит ли пользователь к другим скидочным группам. Если да, удаляем его из этих групп
                $currentDiscountuserGroups = array_intersect($groups, $this->USER_GROUPS_IDS);
                if (!empty($currentDiscountuserGroups)) {
                    foreach ($currentDiscountuserGroups as $delGroup) {
                        $this->deleteUserFromGroup($user['ID'], $delGroup);
                    }
                }

                if ($client['Процент'] != 0) {
                    $this->addUserToGroup($user['ID'], $this->USER_GROUPS[$client['Процент']]['ID']);
                }
            }
        }
    }

    /**
     * Удаляет пользователя из скидочных групп
     * @param string $userId
     * @param string $groupId
     * @return void
     */
    private function deleteUserFromGroup($userId, $groupId): void
    {
        UserGroupTable::delete([
            "USER_ID" => $userId,
            "GROUP_ID" => $groupId,
        ]);
    }

    /**
     * Добавляет пользователя в скидочную группу
     * @param string $userId
     * @param string $groupId
     * @return void
     */
    private function addUserToGroup($userId, $groupId): void
    {
        UserGroupTable::add([
            "USER_ID" => $userId,
            "GROUP_ID" => $groupId,
        ]);
    }

    /**
     * Добавляет пользователя
     * @param string $phone
     * @param array $client
     * @return void
     */
    private function addUser($phone, $client): void
    {
        $fio = explode(' ', $client['Наименование']);
        $password = uniqid();
        $groups[] = REGISTERED_USER_GROUP_ID;
        if (isset($this->USER_GROUPS[$client['Процент']]) && $client['Процент'] != 0) {
            $groups[] = $this->USER_GROUPS[$client['Процент']]['ID'];
        }
        $user = new CUser;
        $user->Add(
            [
                'LOGIN' => $phone,
                'PERSONAL_PHONE' => $phone,
                'NAME' => $fio[0],
                'LAST_NAME' => $fio[1],
                'SECOND_NAME' => $fio[3] ? $fio[3] : '',
                'PASSWORD' => $password,
                'CONFIRM_PASSWORD' => $password,
                'GROUP_ID' => $groups
            ]
        );
    }

    /**
     * Преобразует номер телефона в формат сайта
     * @param string $phone
     * @return string
     */
    private function formatPhone($phone = ''): string
    {
        if ($phone != '') {
            $arPhone = str_split($phone);
            return '+7 (' . $arPhone[0] . $arPhone[1] . $arPhone[2] . ') ' . $arPhone[3] . $arPhone[4] . $arPhone[5] . '-' . $arPhone[6] . $arPhone[7] . '-' . $arPhone[8] . $arPhone[9];
        }

        return '';
    }
}
