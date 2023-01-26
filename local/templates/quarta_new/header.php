<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;

$asset = Asset::getInstance();

?>

<head>
    <title><? $APPLICATION->ShowTitle(); ?></title>
    <?
        $APPLICATION->ShowHead();
        $asset->addCss(SITE_TEMPLATE_PATH . "/assets/fonts/stylesheet.css");
    ?>
</head>