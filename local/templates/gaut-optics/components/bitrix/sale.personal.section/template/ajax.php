<?php
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $USER;

if (!CModule::IncludeModule('main') || !CModule::IncludeModule("sale"))
    return;

$userID = $USER->getid();
$result = [];

$currentPassword = $_POST['CURRENT_PASSWORD'];
$newPassword = $_POST['NEW_PASSWORD'];
$confirmPassword = $_POST['NEW_PASSWORD_CONFIRM'];
if ($currentPassword == '') {
    $error['CURRENT_PASSWORD'] = 'ERROR_EMPTY_FIELD';
} elseif (strlen($currentPassword) < 6) {
    $error['CURRENT_PASSWORD'] = 'ERROR_PASS_LENGTH';
} else {
    $rsUser = CUser::GetByID($userID);
    $checkUserPassword = false;
    if ($arUser = $rsUser->Fetch()) {
        $hashLength = strlen($arUser["PASSWORD"]);
        if ($hashLength > 100) {
            $salt = substr($arUser["PASSWORD"], 3, 16);
            $hashPassword = crypt($currentPassword, "$6$" . $salt . "$");
        } else if ($hashLength > 32) {
            $salt = substr($arUser["PASSWORD"], 0, $hashLength - 32);
            $hashPassword = $salt . md5($salt . $currentPassword);
        } else {
            $salt = "";
            $hashPassword = $arUser["PASSWORD"];
        }
        if ($hashPassword != $arUser["PASSWORD"]) {
            $error['CURRENT_PASSWORD'] = 'ERROR_PASS_INVALID';
        }
    } else {
        $error['CURRENT_PASSWORD'] = 'ERROR_USER_NOT_FOUND';
    }
}
$passInvalid = false;
if ($newPassword == '') {
    $error['NEW_PASSWORD'] = 'ERROR_EMPTY_FIELD';
    $passInvalid = true;
} elseif (strlen($newPassword) < 6) {
    $error['NEW_PASSWORD'] = 'ERROR_PASS_LENGTH';
    $passInvalid = true;
}
if ($confirmPassword == '') {
    $error['NEW_PASSWORD_CONFIRM'] = 'ERROR_EMPTY_FIELD';
    $passInvalid = true;
} elseif (strlen($confirmPassword) < 6) {
    $error['NEW_PASSWORD_CONFIRM'] = 'ERROR_PASS_LENGTH';
    $passInvalid = true;
}
if ($newPassword != $confirmPassword && !$passInvalid) {
    $error['NEW_PASSWORD'] = 'ERROR_PASS_NOT_EQ';
    $error['NEW_PASSWORD_CONFIRM'] = 'ERROR_PASS_NOT_EQ';
}
if (count($error)) {
    $result['success'] = false;
    $result['error'] = $error;
} else {
    $fields = array(
        "PASSWORD" => $newPassword,
        "CONFIRM_PASSWORD" => $confirmPassword
    );
    $changePassResult = $USER->Update($userID, $fields);
    if (!$changePassResult) {
        $result['success'] = false;
        $result['error'] = [
            'NEW_PASSWORD' => 'ERROR_PASS_NOT_SAVE',
            'CONFIRM_PASSWORD' => 'ERROR_PASS_NOT_SAVE',
        ];
    } else {
        $result['success'] = true;
    }
}

echo json_encode($result);