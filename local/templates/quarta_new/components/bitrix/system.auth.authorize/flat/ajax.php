<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use \Bitrix\Main\Loader,
	\Targetsms\Sms\Sender,
	\Bitrix\Main\Engine\CurrentUser,
	\Bitrix\Main\UserTable;

	Loader::includeModule('targetsms.sms');


const TYPES_USER = [
	'retail' => 'Розничный',
	'wholesale' => 'Оптовый'
];

$currentUser = CurrentUser::get();
$userObj = new CUser();

if ($_REQUEST['PROCESS_QUICK_REGISTER'] == 'Y') {

	/**
	 * Начинаем быструю регистрацию
	 */

	if (empty($_REQUEST['FIELDS'])) {
		die('Не заполнены обязательные поля');
	}

	if (empty($_REQUEST['SMS_CODE'])) {
		die('Пустой проверочный код');
	}

	$userSaveSms = $_REQUEST['SMS_CODE'];
	$userSms = $_REQUEST['FIELDS']['SMS_CODE'];

	if ((int) $userSaveSms !== (int) $userSms) {
		die('Неправильный проверочный код');
	}

	$rsGroupTable = Bitrix\Main\GroupTable::getList([
		'select' => [
			'ID',
			'NAME',
			'STRING_ID'
		],
		'filter' => [
			'STRING_ID' => 'REGISTERED_USERS'
		]
	])->fetch();

	$groupRegUsersId = $rsGroupTable['ID'];

	$arFieldsNewUser = [
		'NAME' => htmlspecialchars($_REQUEST['FIELDS']['NAME']),
		'LAST_NAME' => htmlspecialchars($_REQUEST['FIELDS']['LAST_NAME']),
		'PASSWORD' => htmlspecialchars($_REQUEST['FIELDS']['PASSWORD']),
		'CONFIRM_PASSWORD' => htmlspecialchars($_REQUEST['FIELDS']['CONFIRM_PASSWORD']),
		'LOGIN' => $_REQUEST['PERSONAL_PHONE'],
		'ACTIVE' => 'Y',
		'GROUP' => [$groupRegUsersId], /** Группа зарег.пользователи */
	];

	$idUser = $userObj->Add($arFieldsNewUser);

	ob_end_clean();

	header('Content-Type: application/json; charset=utf-8');

	die(Bitrix\Main\Web\Json::encode([
		'ID_USER' => $idUser,
		'STATUS' => 'SUCCESS',
		'ERR' => $userObj->LAST_ERROR
	]));

	if (intval($idUser) > 0) {
		$userObj->Authorize($idUser, true);
	}

}

if (!$currentUser->getId()) {

	$defaultParamsUsers = [
		'select' => [
			'ID',
			'NAME',
			'LAST_NAME',
			'EMAIL',
			'PERSONAL_PHONE',
			'UF_TYPE', 
			'UF_PROMO', 
			'UF_SMS_CODE'
		],
		'filter' => [
			'PERSONAL_PHONE' => $_REQUEST['USER']['PERSONAL_PHONE'], 
			'ACTIVE' => 'Y'
		]
	];

	if ($_REQUEST['USER_SELECTED'] == 'Y') {
		$defaultParamsUsers['filter'] = array_merge(
			$defaultParamsUsers['filter'],
			[
				'ID' => $_REQUEST['USER']['ID'],
				'PERSONAL_PHONE' => $_REQUEST['USER']['PERSONAL_PHONE'],
			]
		);
	}

	$rsUsers = UserTable::getList(
		$defaultParamsUsers
	)->fetchAll();

	if (empty($rsUsers)) {

		// $smsObj = new Sender();
		$smsCode = rand(1111, 9999);
	
		// $rsSendSms = $smsObj->sendSms(
		// 	$_REQUEST['USER']['PERSONAL_PHONE'], 
		// 	$smsCode, 
		// 	'', 
		// 	'quarta-hunt', 
		// 	'quartahunt-login'
		// );

		ob_end_clean();

		header('Content-Type: application/json; charset=utf-8');

		die(
			Bitrix\Main\Web\Json::encode([
				'SHOW_MODAL_QUICK_REGISTER' => 'Y',
				'SMS_CODE' => $smsCode,
				'PERSONAL_PHONE' => $_REQUEST['USER']['PERSONAL_PHONE']
			])
		);

	}
	
	if (count($rsUsers) > 1) {
	
		/**
		 * У пользователя несколько аккаунтов
		 * открываем ему модальное окно с выбором аккаунта
		 */

		foreach($rsUsers as $arUserIndex => $arUser) {
			$arAjaxParams['USERS'][$arUserIndex] = $arUser;

			$arAjaxParams['USERS'][$arUserIndex]['NAME_DISPLAY'] = implode(
				' ', 
				[
					$arUser['NAME'], 
					$arUser['LAST_NAME']
				]
			);

			$arAjaxParams['USERS'][$arUserIndex]['TYPE_DISPLAY'] = implode(
				' ',
				[
					TYPES_USER[$arUser['UF_TYPE']],
					'покупатель'
				]
			);

			$arAjaxParams['MULTI_USER'] = 'Y';

		}

		ob_end_clean();

		header('Content-Type: application/json; charset=utf-8');

		echo Bitrix\Main\Web\Json::encode($arAjaxParams);

	
	} else {

		/** 
		 * Аккаунт один или пользователь 
		 * выбран через модальное окно 
		 * */
		
		$currentUser = reset($rsUsers);

		if (empty($_REQUEST['USER']['userCode'])) {
		
			$smsObj = new Sender();
	
			$smsCode = rand(1111, 9999);

			if ($_REQUEST['USER_SELECTED'] == 'Y') {

				$userObj->Update($_REQUEST['USER']['ID'], [
					'UF_SMS_CODE' => $smsCode
				]);

			} else {

				$userObj->Update($currentUser['ID'], [
					'UF_SMS_CODE' => $smsCode
				]);

			}

			$rsSendSms = $smsObj->sendSms(
				$_REQUEST['USER']['PERSONAL_PHONE'], 
				$smsCode, 
				'', 
				'quarta-hunt', 
				'quartahunt-login'
			);
	
			if (!$rsSendSms->error) {
				$result['error'] = false;
				$result['message'] = 'Сообщение с кодом авторизации успешно отправлено';
			}  else {
				 $result['error'] = true;
				 $result['message'] = 'Ошибка отправки кода авторизации';
			 }

			ob_end_clean();

			header('Content-Type: application/json; charset=utf-8');

			echo Bitrix\Main\Web\Json::encode($result);

		} else {

			$smsVerify = $currentUser['UF_SMS_CODE'] === $_REQUEST['USER']['userCode'];

			if ($_REQUEST['USER_SELECTED'] == 'Y') {
				$smsVerify = $currentUser['UF_SMS_CODE'] === $_REQUEST['USER']['userCode'];
			}

			if ($smsVerify) {

				$USER->Authorize($currentUser['ID']);
				$result['error'] = false;
				$result['message'] = 'Вы успешно авторизовались';
				$result['user'] = [
					'ID' => $USER->GetID(), 
					'LOGIN' => $USER->GetLogin(), 
					'EMAIL' => $USER->GetEmail(), 
					'FIRST_NAME' => $USER->GetFirstName(), 
					'LAST_NAME' => $USER->GetLastName()
				];
			} else {
				$result['error'] = true;
				$result['message'] = 'Неверный код';
			}

			ob_end_clean();

			header('Content-Type: application/json; charset=utf-8');

			echo Bitrix\Main\Web\Json::encode($result);

		}

	}

} else {

	$result['error'] = true;
    $result['message'] = 'Вы уже авторизованы';
    $result['user'] = [
		'ID' => $USER->GetID(), 
		'LOGIN' => $USER->GetLogin(), 
		'EMAIL' => $USER->GetEmail(), 
		'FIRST_NAME' => $USER->GetFirstName(), 
		'LAST_NAME' => $USER->GetLastName()
	];

	ob_end_clean();

	header('Content-Type: application/json; charset=utf-8');

	echo Bitrix\Main\Web\Json::encode($result);

}