<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

$arComponentDescription = array(
    "NAME" => 'Избранные товары',
    "DESCRIPTION" => 'Выводит список избранных товаров',
    "PATH" => array(
        "ID" => "content",
        "CHILD" => array(
            "ID" => "personal",
            "NAME" => "Персональные данные"
        )
    ),
);