<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

$arResult = [];
$arResult['error'] = false;
$arResult['message'] = 'Пароль успешно изменен';

if (mb_strlen($_REQUEST['PASSWORD']) <= 8) {
    $arResult['error'] = true;
    $arResult['message'] = 'Пароль должен иметь длину не менне 8 символов';
}

if ($arResult['error'] === false) {
    $fields =     [
        'PASSWORD' => $_REQUEST['PASSWORD'],
        'CONFIRM_PASSWORD' => $_REQUEST['PASSWORD'],
    ];

    $USER->Update($USER->GetID(), $fields);

    $arResult['error'] = mb_strlen($USER->LAST_ERROR) > 0;
    $arResult['message'] = mb_strlen($USER->LAST_ERROR) > 0 ? $USER->LAST_ERROR : 'Пароль успешно изменен';
}

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>