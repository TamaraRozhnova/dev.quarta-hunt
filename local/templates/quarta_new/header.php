<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;

$asset = Asset::getInstance();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><? $APPLICATION->ShowTitle(); ?></title>
    <?
        $APPLICATION->ShowHead();
        $asset->addCss(SITE_TEMPLATE_PATH . "/assets/fonts/stylesheet.css");
        $asset->addCss(SITE_TEMPLATE_PATH . "/assets/styles/libs/swiper.min.css");
        $asset->addJs(SITE_TEMPLATE_PATH . "/assets/scripts/libs/swiper.min.js");
        $asset->addJs(SITE_TEMPLATE_PATH . "/assets/scripts/baseSlider.js");

    ?>
</head>

<body>
<? $APPLICATION->ShowPanel() ?>
