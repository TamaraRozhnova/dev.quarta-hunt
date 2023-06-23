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

function refreshPage() {
    header('Location: '.$_SERVER['REQUEST_URI']);
}

function checkRequestLogout() {
    global $USER;
    if (
        $_GET['logout'] == 'yes'
        &&
        !empty($USER->GetId())
    ) {
        runLogout();
    }
    
}

function runLogout() {
    global $USER;
    $USER->Logout();

    refreshPage();
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
        '/about/oferta/',
        '/cabinet/reviews/',
        '/cabinet/addresses/',
        '/cabinet/personal/',
        '/cabinet/orders',
        '/cart/'
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