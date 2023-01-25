<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

global $USER;

if (!$USER->IsAuthorized()) {

	$filter = ['PERSONAL_PHONE' => $_REQUEST['PHONE']];
	$select = ['SELECT' => ['UF_BONUS_POINTS', 'UF_TYPE', 'UF_PROMO', 'UF_SMS_CODE']];

	$rsUsers = CUser::GetList(($by="id"), ($order="desc"), $filter, $select);

	if ($user = $rsUsers->GetNext()) {

		if (empty($_REQUEST['CODE'])) {
			\Bitrix\Main\Loader::includeModule('targetsms.sms');
	
			$sms = new \Targetsms\Sms\Sender();
	
			$phone = $user['PERSONAL_PHONE'];
			$message = rand(1111, 9999);
	
			$u = new CUser();
			$u->Update($user['ID'], ['UF_SMS_CODE' => $message]);
	
			$resp = $sms->sendSms($phone, $message, '', 'quarta-hunt', 'quartahunt-login');
	
			if (!$resp->error) {
				$result['error'] = false;
				$result['message'] = 'Сообщение с кодом авторизации успешно отправлено';
			} else {
				$result['error'] = true;
				$result['message'] = 'Ошибка отправки кода авторизации';
			}
		} else {
			if ($user['UF_SMS_CODE'] === $_REQUEST['CODE']) {
				$USER->Authorize($user['ID']);
				$result['error'] = false;
				$result['message'] = 'Вы успешно авторизовались';
				$result['user'] = ['ID' => $USER->GetID(), 'LOGIN' => $USER->GetLogin(), 'EMAIL' => $USER->GetEmail(), 'FIRST_NAME' => $USER->GetFirstName(), 'LAST_NAME' => $USER->GetLastName()];
			} else {
				$result['error'] = true;
				$result['message'] = 'Неверный код';
			}
		}

	} else {
		$result['error'] = true;
		$result['message'] = 'Такого номера не существует';
		$result['phone'] = $_REQUEST['PHONE'];
	}

} else {

/*
	$filter = ['PERSONAL_PHONE' => '+7 (999) 111-11-11', 'WORK_PHONE' => $_REQUEST['PHONE']];

	$select = ['SELECT' => ['UF_BONUS_POINTS', 'UF_TYPE', 'UF_PROMO', 'UF_SMS_CODE']];

	$rsUsers = CUser::GetList(($by="id"), ($order="desc"), $filter, $select);

	$user = $rsUsers->GetNext();

	$u = new CUser();

	$u->Update($user['ID'], ['UF_SMS_CODE' => '1111']);

	$result['u'] = $user;
*/

	$result['error'] = true;
    $result['message'] = 'Вы уже авторизованы';
    $result['user'] = ['ID' => $USER->GetID(), 'LOGIN' => $USER->GetLogin(), 'EMAIL' => $USER->GetEmail(), 'FIRST_NAME' => $USER->GetFirstName(), 'LAST_NAME' => $USER->GetLastName()];

}

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($result);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>


