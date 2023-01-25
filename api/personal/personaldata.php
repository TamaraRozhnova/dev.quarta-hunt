<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

$arResult = [];
$arResult['error'] = false;
$arResult['message'] = 'Данные успешно сохранены';

if (preg_grep('/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', [$_REQUEST['phone']]) === false) {
	$arResult['error'] = true;
	$arResult['message'] = 'Неверный номер телефона';
	$arResult['phone'] = $_REQUEST['phone'];
}

if (mb_strlen($_REQUEST['firstName']) < 2) {
	$arResult['error'] = true;
	$arResult['message'] = 'Имя должно иметь длину более 2 символов';
	$arResult['firstName'] = $_REQUEST['firstName'];
}

if (mb_strlen($_REQUEST['secondName']) < 2) {
	$arResult['error'] = true;
	$arResult['message'] = 'Фамилия должна иметь длину более 2 символов';
	$arResult['secondName'] = $_REQUEST['secondName'];
}

if (preg_grep('/^([a-z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/', [$_REQUEST['email']]) === false) {
	$arResult['error'] = true;
	$arResult['message'] = 'Неверный email';
	$arResult['email'] = $_REQUEST['email'];
}

if ($arResult['error'] === false) {
	$fields = 	[
		'PERSONAL_PHONE' => $_REQUEST['phone'],
		'NAME' => $_REQUEST['firstName'],
		'LAST_NAME' => $_REQUEST['secondName'],
		'EMAIL' => $_REQUEST['email']
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
