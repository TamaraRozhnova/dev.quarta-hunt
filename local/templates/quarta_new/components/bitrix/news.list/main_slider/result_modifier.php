<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

foreach ($arResult['ITEMS'] as $slider) {
    $arResult['SLIDER_IMAGES'][] =
        [
            'IMAGE' => $slider['FIELDS']['DETAIL_PICTURE']['SRC'],
            'IMAGE_MOBILE' => $slider['FIELDS']['PREVIEW_PICTURE']['SRC'],
        ];
}