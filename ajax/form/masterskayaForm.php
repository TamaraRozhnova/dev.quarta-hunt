<?php

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

use Form\WebForm;
use Bitrix\Main\Config\Option;

$data = array_merge($_POST, $_FILES);

$webForm = new WebForm($data['formId']);

unset($data['formId']);

$captcha = new CCaptcha();

$arSettings = unserialize(Option::get("twim.recaptchafree", "settings", false, SITE_ID));

$isCheck = $captcha->CheckCode($data['captcha_word'], $_REQUEST["captcha_sid"]);

if ($isCheck) {
    $response = $webForm->saveResult($data);
} else {
    die();
}

echo json_encode($response);




