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

}