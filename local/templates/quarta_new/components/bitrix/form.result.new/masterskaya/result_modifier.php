<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

foreach ($arResult['arAnswers'] as $answer) {
    $arResult['CONTROLS'][] = $answer[0];
}