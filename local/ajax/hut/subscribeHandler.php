<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Context;
use Form\MailSubscribe;

$APPLICATION->RestartBuffer();

$request = Context::getCurrent()->getRequest();
$email = $request->get("sf_EMAIL");

if (!empty($email)) {
    echo MailSubscribe::subcribeEmailHandler($email);
} else {
    echo json_encode(['status' => 'nothing']);
}
