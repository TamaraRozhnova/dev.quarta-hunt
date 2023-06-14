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

function getSearchString(): string {
    if (CSite::InDir('/search/')) {
        return filter_var($_GET['q'], FILTER_SANITIZE_STRING);
    }
    return '';
}

function showBreadcrumb(): bool {
    $notAllowedUrls = ['/catalog/index.php'];
    $allowedUrls = [
        '/catalog/', 
        '/search/', 
        '/blog/', 
        '/favorites/', 
        '/compare/', 
        '/jobs/',
        '/cabinet/reviews/',
        '/cabinet/addresses/'
    ];

    foreach ($notAllowedUrls as $url) {
        if (CSite::InDir($url)) {
            return false;
        }
    }

    foreach ($allowedUrls as $url) {
        if (CSite::InDir($url)) {
            return true;
        }
    }

    return false;
}