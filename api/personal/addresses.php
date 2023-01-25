<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

$arResult = [];
$arResult['error'] = false;
$arResult['message'] = 'Данные успешно сохранены';

if (mb_strlen($_REQUEST['locality']) === 0) {
    $arResult['error'] = true;
    $arResult['message'] = 'Не выбран город';
    $arResult['firstName'] = $_REQUEST['locality'];
}

if (mb_strlen($_REQUEST['street']) === 0) {
    $arResult['error'] = true;
    $arResult['message'] = 'Не выбрана улица';
    $arResult['firstName'] = $_REQUEST['street'];
}

if (mb_strlen($_REQUEST['house']) === 0) {
    $arResult['error'] = true;
    $arResult['message'] = 'Не выбран номер дома';
    $arResult['firstName'] = $_REQUEST['house'];
}

if (mb_strlen($_REQUEST['apartment']) === 0) {
    $arResult['error'] = true;
    $arResult['message'] = 'Не выбран номер квартиры';
    $arResult['firstName'] = $_REQUEST['apartment'];
}

if ($arResult['error'] === false) {
    $fields =     [
        'PERSONAL_CITY' => $_REQUEST['locality'],
        'PERSONAL_STREET' => $_REQUEST['street'] . ', ' . $_REQUEST['house'] . ', ' . $_REQUEST['apartment']
    ];

    $USER->Update($USER->GetID(), $fields);

    $arResult['error'] = mb_strlen($USER->LAST_ERROR) > 0;
    $arResult['message'] = mb_strlen($USER->LAST_ERROR) > 0 ? $USER->LAST_ERROR : 'Данные успешно сохранены';
}

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>