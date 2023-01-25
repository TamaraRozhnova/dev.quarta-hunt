<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

$result['error'] = false;
$result['message'] = '';


if (empty($_REQUEST['name'])) {
    $result['error'] = true;
    $result['message'] = 'Имя не может быть пустой строкой';
}

if (!preg_grep('/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', [$_REQUEST['phone']])) {
    $result['error'] = true;
    $result['message'] = 'Неверный номер телефона';
	$result['phone'] = $_REQUEST['phone'];
}

if (!preg_grep('/^([a-z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/', [$_REQUEST['email']])) {
    $result['error'] = true;
    $result['message'] = 'Неверный email';
}

if (empty($_REQUEST['text'])) {
    $result['error'] = true;
    $result['message'] = 'Вопрос не может быть пустой строкой';
}

if (!$result['error']) {

	$arEventFields = [
		'NAME' => $_REQUEST['name'],
		'PHONE' => $_REQUEST['phone'],
		'EMAIL' => $_REQUEST['email'],
		'TEXT' => $_REQUEST['text'],
	];
	
	$result['event'] = $arEventFields;
	
	$event = new CEvent;
	$event->SendImmediate("CONTACTS_QUESTION", SITE_ID, $arEventFields);
	
	$result['error'] = false;
	$result['message'] = 'Ваше сообщение обрабатывается';

}


ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($result);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>