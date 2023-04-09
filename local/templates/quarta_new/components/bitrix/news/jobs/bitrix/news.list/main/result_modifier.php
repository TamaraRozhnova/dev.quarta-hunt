<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$scheduleOptions = [];

foreach ($arResult['ITEMS'] as $item) {
    $scheduleOptions[] = $item['PROPERTIES']['SCHEDULE']['VALUE'];
}

$arResult['SCHEDULE_OPTIONS'] = array_unique($scheduleOptions);