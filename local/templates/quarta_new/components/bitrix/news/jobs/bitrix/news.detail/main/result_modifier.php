<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\WorkProsHelper;

$arResult['WORK_PROS'] = WorkProsHelper::getData();
