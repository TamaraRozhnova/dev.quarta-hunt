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


$log = date('Y-m-d H:i:s') . ' ' . print_r('попытка авторизации', true);
file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);

$currentUser = CurrentUser::get();

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
		

		//  $userCode = 

		$currentUser = reset($rsUsers);

		if (empty($_REQUEST['USER']['userCode'])) {
		
			$smsObj = new Sender();
			$userObj = new CUser();
	
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

			$log = date('Y-m-d H:i:s') . ' ' . print_r($result, true);
			file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);


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

	$log = date('Y-m-d H:i:s') . ' ' . print_r($result, true);
	file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);

	ob_end_clean();

	header('Content-Type: application/json; charset=utf-8');

	echo Bitrix\Main\Web\Json::encode($result);

}