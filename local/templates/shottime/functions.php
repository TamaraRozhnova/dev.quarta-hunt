<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if(!function_exists('getUserFullNameOrEmail')){
    function getUserFullNameOrEmail(): string {
        global $USER;
        $fullName = $USER->GetFullName();

        if ($fullName) {
            return $fullName;
        }

        return $USER->GetEmail();
    }
}

if(!function_exists('getSearchString')){
    function getSearchString(): string {
        if (CSite::InDir('/search/')) {
            return filter_var($_GET['q'], FILTER_SANITIZE_STRING);
        }
        return '';
    }
}

if(!function_exists('refreshPage')){
    function refreshPage() {
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

}

if(!function_exists('checkRequestLogout')){
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
}


if(!function_exists('runLogout')){
    function runLogout() {
        global $USER;
        $USER->Logout();

        refreshPage();
    }

}
if(!function_exists('showBreadcrumb')){
    function showBreadcrumb(): bool {
        $notAllowedUrls = [
//        '/catalog/index.php'
        ];
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
            '/cart/',
            '/personal/'
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
}


