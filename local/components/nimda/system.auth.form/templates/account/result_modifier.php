<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

global $APPLICATION;

$process = false;
if($arParams["FORM_ID"] != ''){
    if($_REQUEST["form_id"] != '' and $arParams["FORM_ID"] == $_REQUEST["form_id"]){
        $process = true;
    }
}else{
    $process = true;
}

if (isset($_POST['AJAX-ACTION-AUTH']) && $_POST['AJAX-ACTION-AUTH'] == 'Y' && $process) {
    $APPLICATION->RestartBuffer();

    header('Content-type: application/json');

    if (
        (
            isset($arResult['ERROR'])
            && $arResult['ERROR'] === true
        )
        ||
        (
            !empty($arResult['ERROR_MESSAGE'])
            && isset($arResult['ERROR_MESSAGE']['TYPE'])
            && $arResult['ERROR_MESSAGE']['TYPE'] == 'ERROR'
        )
    ) {
        $response = array(
            'STATUS' => 'ERROR',
            'MESSAGES' => array(
                strip_tags($arResult['ERROR_MESSAGE']['MESSAGE'])
            ),
            'dbg' => "spec",
        );
    } else {
        $response = array(
            'STATUS' => 'OK',
        );
    }

    $response["template"] = $arParams["FORM_ID"];
    $response["arParams"] = $arParams;
    $response["arResult"] = $arResult;


    echo \Bitrix\Main\Web\Json::encode($response);

    die();
}