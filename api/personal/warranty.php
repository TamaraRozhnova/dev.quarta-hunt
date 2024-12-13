<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

$result['error'] = false;
$result['message'] = '';


if (empty($_REQUEST['name'])) {
    $result['error'] = true;
    $result['message'] = '��� �� ����� ���� ������ �������';
}

if (!preg_grep('/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', [$_REQUEST['phone']])) {
    $result['error'] = true;
    $result['message'] = '�������� ����� ��������';
	$result['phone'] = $_REQUEST['phone'];
}

if (!preg_grep('/^([a-zA-Z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/', [$_REQUEST['email']])) {
    $result['error'] = true;
    $result['message'] = '�������� email';
}

if (empty($_REQUEST['address'])) {
    $result['error'] = true;
    $result['message'] = '����� �� ����� ���� ������ �������';
}

if (!$result['error']) {
	$arFiles = [];
	
	foreach ($_FILES['IMAGES'] as $img) {
/*		
		$data = [
			'name' => $img['name'],
			'size' => $img['size'],
			'tmp_name' => $img['tmp_name'],
			'type' => $img['type']
		];
*/
		$arFiles[] = $img['tmp_name'];
	}
	
	$arEventFields = [
		'NAME' => $_REQUEST['name'],
		'PHONE' => $_REQUEST['phone'],
		'EMAIL' => $_REQUEST['email'],
		'ADDRESS' => $_REQUEST['address'],
		'PRODUCT' => $_REQUEST['product'],
		'COMPLECT' => $_REQUEST['complect'],
		'COMMENT' => $_REQUEST['comment'],
	];
	
	$result['event'] = $arEventFields;
	
	$event = new CEvent;
	$event->SendImmediate("WARRANTY", SITE_ID, $arEventFields, "Y", "", $arFiles, "");
	
	$result['error'] = false;
	$result['message'] = '���� ��������� ��������������';

}


ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($result);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>