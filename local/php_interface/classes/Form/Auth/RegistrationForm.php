<?php

namespace Form\Auth;

use CDatabase;
use CEvent;
use CMain;
use General\User;

class RegistrationForm
{
    const USER_INFO_EVENT_CODE = 'USER_INFO';
    const REGISTRATION_EVENT_CODE = 'NEW_USER';

    /** @var CDatabase */
    private CDatabase $DB;

    /** @var string */
    private string $company;

    /** @var string */
    private string $address;

    /** @var string */
    private string $marketPlace;

    /** @var string */
    private string $contact;

    /** @var string */
    private string $position;

    /** @var string */
    private string $phone;

    /** @var string */
    private string $email;

    /** @var string */
    private string $password;

    /** @var bool */
    private bool $promo;

    /**
     * @var array - ассоциативный массив, где: ключ - input name, значение - сообщение об ошибке
     */
    private array $errors = [];


    public function __construct()
    {
        global $DB;
        $this->DB = $DB;
    }


    /**
     * @param array $data - ассоциативный массив, где:
     * ключ — input name, значение — input value
     * @return array|bool - возвращает true, если регитсрация прошла успешно, иначе
     * ассоциативный массив с ключом 'errors' и значением - текст ошибки
     */
    public function registerUser(array $data)
    {
        $this->readData($data);
        $this->validateData();

        if (!empty($this->errors)) {
            return ['errors' => $this->errors];
        }

        $dataForNewUser = $this->createDataForNewUser();
        $result = User::register($dataForNewUser);

        if (!intval($result)) {
            $this->errors['message'] = $result;
            return ['errors' => $this->errors];
        }

        $data['USER_ID'] = $result;
        $this->sendEmail($data);

        return true;
    }


    private function sendEmail($data): void
    {
        $event = new CEvent;
        $event->SendImmediate(RegistrationForm::USER_INFO_EVENT_CODE, SITE_ID, $data);
        $event->SendImmediate(RegistrationForm::REGISTRATION_EVENT_CODE, SITE_ID, $data);
    }


    private function createDataForNewUser(): array {
        return [
            'PERSONAL_PHONE' => $this->phone,
            'EMAIL' => $this->email,
            'NAME' => $this->contact,
            'LOGIN' => $this->email,
            'WORK_COMPANY' => $this->company,
            'WORK_STREET' => $this->address,
            'WORK_DEPARTMENT' => $this->marketPlace,
            'WORK_POSITION' => $this->position,
            'WORK_PHONE' => $this->phone,
            'LID' => SITE_ID,
            'ACTIVE' => 'N',
            'GROUP_ID' => [User::USER_GROUP_OPT_ID],
            'PASSWORD' => $this->password,
            'CHECKWORD' => md5(CMain::GetServerUniqID().uniqid()),
            '~CHECKWORD_TIME' => $this->DB->CurrentTimeFunction(),
            'UF_TYPE' => 'wholesale',
            'UF_PROMO' => $this->promo,
            'UF_BONUS_POINTS' => 0,
            'USER_TYPE'	=> 'Оптовый',
        ];
    }


    /**
     * @param array $data - ассоциативный массив, где:
     * ключ — input name, значение — input value
     */
    private function readData(array $data): void
    {
        $this->company = $data['company'];
        $this->address = $data['address'];
        $this->marketPlace = $data['marketPlace'];
        $this->contact = $data['contact'];
        $this->position = $data['position'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->promo = $data['promo'];
    }


    /**
     * Валидирует поля формы с фронта и, в случае ошибок, заполняет массив $errors
     */
    private function validateData(): void
    {
        $minPasswordLength = 8;
        if (!$this->company) {
            $this->errors['company'] = 'Поле обязательно к заполнению';
        }
        if (!$this->marketPlace) {
            $this->errors['marketPlace'] = 'Поле обязательно к заполнению';
        }
        if (!$this->contact) {
            $this->errors['contact'] = 'Поле обязательно к заполнению';
        }
        if (!$this->position) {
            $this->errors['position'] = 'Поле обязательно к заполнению';
        }
        if (!$this->phone || !preg_grep('/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', [$this->phone])) {
            $this->errors['phone'] = 'Некорректный номер телефона';
        }
        if (!$this->email || !preg_grep('/^([a-z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/', [$this->email])) {
            $this->errors['email'] = 'Неверный email';
        }
        if (!$this->password || strlen($this->password) < $minPasswordLength) {
            $this->errors['password'] = 'Пароль должен содержать не менее 8 символов';
        }
    }

}