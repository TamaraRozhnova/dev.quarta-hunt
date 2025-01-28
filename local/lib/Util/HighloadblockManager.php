<?php

namespace Local\Util;

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use \Bitrix\Main\SystemException;

/**
 * Класс HighloadblockManager
 *
 * @package Local\HighloadBlock
 */
class HighloadblockManager
{
    /**
     * @var string|null Код справочника.
     */
    private $codeHl;

    /**
     * @var HL\Entity|null Entity object справочника.
     */
    private $entityHl;

    /**
     * @var HL\DataManager|null Сущность для взаимодействия со справочником.
     */
    public static $entityDataClass;

    /**
     * @var array Параметры для управления выборкой из справочника.
     */
    private $paramsQuery = [];

    /**
     * HighloadblockManager конструктор.
     *
     * @param string|null $codeHl Код справочника.
     *
     * @throws SystemException Системная ошибка в случае отсутствия модуля.
     */
    public function __construct(?string $codeHl = null)
    {
        if (!Loader::includeModule('highloadblock')) {
            throw new SystemException('Module highloadblock is not initialized');
        }

        if ($codeHl === null) {
            throw new SystemException('Empty code highloadblock');
        }

        $this->codeHl = $codeHl;
        $this->compilationHighloadblock();
    }

    /**
     * Метод компиляции HL сущности
     * и получение класса для работы со справочником
     *
     * @return void
     */
    private function compilationHighloadblock(): void
    {
        $this->compileEntityHl();
        $this->getCompileDataClassHl();
    }

    /**
     * Компиляция HL Entity
     *
     * @return HL\Entity|null
     */
    private function compileEntityHl()
    {
        return $this->entityHl = HL\HighloadBlockTable::compileEntity($this->codeHl);
    }

    /**
     * Получение класса справочника для работы из Entity HL
     *
     * @return HL\DataManager|null
     */
    private function getCompileDataClassHl()
    {
        return $this->entityDataClass = $this->entityHl->getDataClass();
    }

    /**
     * Обработка параметров для запроса.
     *
     * @param array $select Поля выборки.
     * @param array $order  Сортировка.
     * @param array $filter Фильтр.
     *
     * @return array Обработанные параметры запроса.
     */
    public function prepareParamsQuery(array $select = ['*'], array $order = [], array $filter = []): array
    {
        $this->paramsQuery['select'] = $select;
        $this->paramsQuery['order'] = $order;
        $this->paramsQuery['filter'] = $filter;

        if (!empty($select) || reset($select) === '*') {
            $this->paramsQuery['select'] = $select;
        }

        if (!empty($order)) {
            $this->paramsQuery['order'] = $order;
        }

        if (!empty($filter)) {
            $this->paramsQuery['filter'] = $filter;
        }

        return $this->paramsQuery;
    }

    /**
     * Получение параметров для запроса
     *
     * @return array Параметры запроса.
     */
    public function getParamsQuery(): array
    {
        return $this->paramsQuery;
    }

    /**
     * Получение одной записи из справочника
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->entityDataClass::getList($this->paramsQuery)->fetch();
    }

    /**
     * Получение всех записей из справочника
     *
     * @return mixed
     */
    public function getDataAll()
    {
        return $this->entityDataClass::getList($this->paramsQuery)->fetchAll();
    }

    /**
     * Удаление записи из справочника
     *
     * @param integer $id ID записи.
     *
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->entityDataClass::delete($id);
    }

    /**
     * Добавление записи в справочник
     *
     * @param array $fields Поля для записи элемента в справочник.
     *
     * @return mixed
     */
    public function add(array $fields)
    {
        return $this->entityDataClass::add($fields);
    }

    /**
     * Обновление записи в справочник
     *
     * @param int $primary ID записи
     * @param array $fields Поля для записи элемента в справочник.
     *
     * @return mixed
     */
    public function update(int $primary, array $fields)
    {
        return $this->entityDataClass::update($primary, $fields);
    }
}
