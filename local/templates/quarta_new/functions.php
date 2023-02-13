<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

function getUserFullNameOrEmail(): string {
    global $USER;
    $fullName = $USER->GetFullName();

    if ($fullName) {
        return $fullName;
    }

    return $USER->GetEmail();
}