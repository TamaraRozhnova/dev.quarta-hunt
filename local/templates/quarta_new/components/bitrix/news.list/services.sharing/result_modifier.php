<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */

if (!empty($arResult['ITEMS'])) {

    $currentURL = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $currentURL = explode('?', $currentURL);
    $currentURL = $currentURL[0];

    foreach ($arResult['ITEMS'] as $arItemIndex => $arItem) {
        if (
            !empty($arItem['PROPERTIES']['SS_LINK_S']['VALUE']) 
        ) {
            
            $arResult['ITEMS'][$arItemIndex]['LINK_SERVICE'] = $arItem['PROPERTIES']['SS_LINK_S']['VALUE'];

            $arResult['ITEMS'][$arItemIndex]['LINK_SERVICE'] .= '?url=' . $currentURL;

            if (!empty($arItem['PREVIEW_TEXT'])) {
                $arResult['ITEMS'][$arItemIndex]['LINK_SERVICE'] .= '&text=' . $arItem['PREVIEW_TEXT'];
            }

            if ($arItem['PROPERTIES']['SS_LINK_S']['VALUE'] == 'COPY_LINK') {
                $arResult['ITEMS'][$arItemIndex]['LINK_SERVICE'] = 'COPY_LINK';

                $arResult['ITEMS'][$arItemIndex]['COPY_ATTR'] = $currentURL;
            }

        }
    }
}
