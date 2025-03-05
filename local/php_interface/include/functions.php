<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Skyweb24\YandexCaptcha\YandexCaptcha;
use Skyweb24\YandexCaptcha\YandexCaptchaOption;
use Webprostor\hCaptcha;

function getUserFullNameOrEmail(): string
{
    global $USER;
    $fullName = $USER->GetFullName();

    if ($fullName) {
        return $fullName;
    }

    return $USER->GetEmail();
}

function getSearchString(): string
{
    if (CSite::InDir('/search/')) {
        return filter_var($_GET['q'], FILTER_SANITIZE_STRING);
    }
    return '';
}

function refreshPage()
{
    header('Location: ' . $_SERVER['REQUEST_URI']);
}

function checkRequestLogout()
{
    global $USER;
    if (
        $_GET['logout'] == 'yes'
        &&
        !empty($USER->GetId())
    ) {
        runLogout();
    }
}

function runLogout()
{
    global $USER;
    $USER->Logout();

    refreshPage();
}

function showBreadcrumb(): bool
{
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
        '/cart/',
        '/brendy/',
        '/about/',
        '/delivery/',
        '/payment/',
        '/warranty/',
        '/promo/',
        '/landing/masterskaya/',
        '/contacts/'
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

function getRootProductSection($iblockId, $sectionId)
{
    $arSections = [];
    while ($sectionId) {
        if ($arSection = \Bitrix\Iblock\SectionTable::getList([
            'filter' => ['IBLOCK_ID' => $iblockId, 'ID' => $sectionId],
            'select' => ['ID', 'IBLOCK_SECTION_ID', 'CODE'],
            'cache' => ['ttl' => 36000000]
        ])->fetch()) {
            $arSections[] = $arSection;
        }
        $sectionId = $arSection['IBLOCK_SECTION_ID'];
    }
    $arSections = array_reverse($arSections);
    return $arSections;
}

function checkCustomCaptcha($post)
{
    if (Loader::includeModule('twim.recaptchafree')) {
        parse_str($post, $output);

        //yandex
        Loader::includeModule('skyweb24.yandexcaptcha');
        $optionCaptcha = new YandexCaptchaOption();

        return (new YandexCaptcha($output['smart-token'], $optionCaptcha->getServerKey()))->checkCaptcha();
        //google
        //        $moduleParams = unserialize(Option::get("twim.recaptchafree", "settings", false, SITE_ID));
        //        $word = ReCaptchaTwoGoogle::checkBxCaptcha($output, $moduleParams);
        //        $captcha = new CCaptcha();
        //        return $captcha->CheckCode($word, $_REQUEST["captcha_sid"]);
    } else {
        return false;
    }
}

function checkCustomHCaptcha($captchaCode)
{
    if (
        Loader::includeModule('webprostor.core') &&
        Loader::includeModule('webprostor.hcaptcha') &&
        $captchaCode &&
        $captchaCode !== ''
    ) {
        $siteCode = strtoupper(SITE_ID)."_";
        $params['SECRETKEY'] = Option::get('webprostor.hcaptcha', "{$siteCode}SECRETKEY");

        return hCaptcha::CheckHCaptcha($captchaCode, $params);
    } else {
        return false;
    }
}

/**
 * Функция добавления svg файла в html
 *
 * @param string $svg_name Название файла.
 * @param string $base     Папка с фалом относительно корня сайта.
 * @return string Добавление содержимого файла.
 */
function buildSVG(string $svg_name, string $base = 'image')
{
    return file_get_contents($_SERVER['DOCUMENT_ROOT'] . $base . '/' . $svg_name . '.svg');
}
