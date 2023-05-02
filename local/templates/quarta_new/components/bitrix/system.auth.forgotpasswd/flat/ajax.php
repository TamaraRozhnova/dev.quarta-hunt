<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');

\Bitrix\Main\Loader::includeModule('targetsms.sms');
$sms = new \Targetsms\Sms\Sender();

global $USER;

if (!$USER->isAuthorized()) {

	$filter = ['PERSONAL_PHONE' => $_REQUEST['userPhone']];
    $select = ['SELECT' => ['UF_BONUS_POINTS', 'UF_TYPE', 'UF_PROMO', 'UF_SMS_CODE', 'EMAIL', 'LOGIN']];

    $rsUsers = CUser::GetList(($by="id"), ($order="desc"), $filter, $select);

    if ($user = $rsUsers->GetNext()) {

		if (!empty($_REQUEST['userPhone'])) {

			$phone = $user['PERSONAL_PHONE'];

			if (empty($_REQUEST['userCode'])) {
				
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
				if ($user['UF_SMS_CODE'] === $_REQUEST['userCode']) {
					$newPass = random_number();

					$u = new CUser();
					$u->Update($user['ID'], ['PASSWORD' => $newPass]);
					$u->Update($user['ID'], ['CONFIRM_PASSWORD' => $newPass]);

					$newPassSMS = $newPass." - Ваш новый пароль";

					$resp = $sms->sendSms($phone, $newPassSMS, '', 'quarta-hunt', 'quartahunt-login');

					$arEventFields = array("EMAIL" => $user['EMAIL'], "USER_ID" => $user['ID'], "LOGIN" => $user['LOGIN'], 'CHECKWORD'=> $newPass);
					Bitrix\Main\Mail\Event::SendImmediate(array(
						"EVENT_NAME" => "FORGOT_PASSWORD",
						"LID" => "s1",
						"C_FIELDS" => $arEventFields
					));

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
			$result['message'] = 'Неверные данные';
		}
	} else {
		$result['error'] = true;
		$result['message'] = 'Такого пользователя не существует';
	}

} else {
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

