<?php

namespace General;

use CUser;

/**
 * Класс по работе с данными пользователя.
 */
class User
{
    const USER_GROUP_OPT_ID = 9;

    /** @var CUser */
    private $user;

    public function __construct()
    {
        global $USER;
        $this->user = $USER;
    }


    /**
     * Регистрирует пользователя
     * @param array $fields - ассоциативный массив cо свойствами нового пользователя
     * @return int|string - возвращает id нового пользователя, иначе строку с ошибкой регистрации
     */
    public static function register(array $fields)
    {
        $user = new CUser;
        $userId = $user->Add($fields);
        if (intval($userId) > 0) {
            $user->Authorize($userId);
            return intval($userId);
        }
        return $user->LAST_ERROR;
    }


    public function getById(int $id)
    {
        $userResource = CUser::GetByID($id);
        if ($user = $userResource->Fetch()) {
            return $user;
        }
        return false;
    }


    public function getId(): ?string
    {
        return $this->user->GetID();
    }


    public function isAuthorized(): bool
    {
        return $this->user->isAuthorized();
    }


    public function isWholesaler(): bool
    {
        if ($this->isAuthorized()) {
            return in_array(User::USER_GROUP_OPT_ID, $this->user->GetUserGroup($this->GetID()));
        }

        return false;
    }


    public function getUserPriceId(): string {
        if ($this->isWholesaler()) {
            return OPT_PRICE_ID;
        }
        return BASE_PRICE_ID;
    }


    public function getUserPriceCodeId(): string {
        if ($this->isWholesaler()) {
            return OPT_PRICE_CODE_ID;
        }
        return BASE_PRICE_CODE_ID;
    }


    public function getUserPriceCode(): string {
        if ($this->isWholesaler()) {
            return OPT_PRICE_CODE;
        }
        return BASE_PRICE_CODE;
    }

}