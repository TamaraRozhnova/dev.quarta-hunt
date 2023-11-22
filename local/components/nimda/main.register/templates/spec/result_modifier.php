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

if (isset($_POST['AJAX-ACTION']) && $_POST['AJAX-ACTION'] == 'REGISTER' && $process) {
    $APPLICATION->RestartBuffer();

    header('Content-type: application/json');

    if (sizeof($arResult['ERRORS']) > 0) {
        $errors = [];
        foreach ($arResult['ERRORS'] as $err){
            $errors[] = strip_tags($err);
        }

        $response = array(
            'STATUS' => 'ERROR',
            'MESSAGES' => $errors,
        );
        //strip_tags(str_replace('логином', 'таким E-mail', $arResult['ERRORS'][0]))
    } else {
        $response = array(
            'STATUS' => 'OK',
        );
    }

    $response["from"] = "spec/resmod";
    $response["arResult"] = $arResult;

    echo \Bitrix\Main\Web\Json::encode($response);

    die();
}