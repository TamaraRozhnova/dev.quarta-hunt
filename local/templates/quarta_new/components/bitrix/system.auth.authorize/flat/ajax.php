<?php 

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

use \Bitrix\Main\Loader,
	\Targetsms\Sms\Sender,
	\Bitrix\Main\Engine\CurrentUser,
	\Bitrix\Main\UserTable,
	\Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

define('TYPES_USER', [
	'retail' => Loc::getMessage('TYPE_USER_RETAIL'),
	'wholesale' => Loc::getMessage('TYPE_USER_OPT')
]);

define('ENCRYPTION_KEY', 'VPTDI1JY5fLMPunFcTIZ3X-W-e4');

$encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB", ENCRYPTION_KEY);
$decrypted_string=openssl_decrypt($encrypted_string,"AES-128-ECB", ENCRYPTION_KEY);

if (!Loader::includeModule('targetsms.sms')) {
	die(Loc::getMessage('TARGET_SMS_ISNT_INIT'));
}	

$currentUser = CurrentUser::get();
$userObj = new CUser();

if ($_REQUEST['PROCESS_QUICK_REGISTER'] == 'Y') {

	/**
	 * Начинаем быструю регистрацию
	 */

	if (empty($_REQUEST['FIELDS'])) {
		die(Bitrix\Main\Web\Json::encode([
			'STATUS' => 'ERROR',
			'ERR' => Loc::getMessage('EMPTY_FIELDS_W')
		]));
	}

	if (empty($_REQUEST['SMS_CODE'])) {
		die(Bitrix\Main\Web\Json::encode([
			'STATUS' => 'ERROR',
			'ERR' => Loc::getMessage('EMPTY_VEIRIFY_CODE')
		]));
	}

	$userSaveSms = openssl_decrypt(
		$_REQUEST['SMS_CODE'],
		'AES-128-ECB', 
		ENCRYPTION_KEY
	);

	$userSms = $_REQUEST['FIELDS']['SMS_CODE'];

	if ((int) $userSaveSms !== (int) $userSms) {
		die(Bitrix\Main\Web\Json::encode([
			'STATUS' => 'ERROR',
			'ERR' => Loc::getMessage('WRONG_VEIRIFY_CODE')
		]));
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

	$randomPass = \Bitrix\Main\Security\Random::getString(10);

	$arFieldsNewUser = [
		'NAME' => htmlspecialchars($_REQUEST['FIELDS']['NAME']),
		'LAST_NAME' => htmlspecialchars($_REQUEST['FIELDS']['LAST_NAME']),
		'PASSWORD' => $randomPass,
		'CONFIRM_PASSWORD' => $randomPass,
		'LOGIN' => $_REQUEST['PERSONAL_PHONE'],
		'ACTIVE' => 'Y',
		'GROUP' => [$groupRegUsersId],
	];

	$arFieldsUpdateUser = [
		'UF_TYPE' => 'retail',
		'PERSONAL_PHONE' => $_REQUEST['PERSONAL_PHONE'],
	];

	$idUser = $userObj->Add($arFieldsNewUser);

	if (intval($idUser) > 0) {

		$userObj->Update($idUser, $arFieldsUpdateUser);
		$userObj->Authorize($idUser);
	
		if (intval($idUser) > 0) {
	
			die(Bitrix\Main\Web\Json::encode([
				'ID_USER' => $idUser,
				'STATUS' => 'SUCCESS',
			]));
	
		}

	}

	die(Bitrix\Main\Web\Json::encode([
		'STATUS' => 'ERROR',
		'ERR' => $userObj->LAST_ERROR
	]));

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

		$smsObj = new Sender();
		$smsCode = rand(1111, 9999);
	
		$rsSendSms = $smsObj->sendSms(
			$_REQUEST['USER']['PERSONAL_PHONE'], 
			$smsCode, 
			'', 
			'quarta-hunt', 
			'quartahunt-login'
		);

		die(
			Bitrix\Main\Web\Json::encode([
				'SHOW_MODAL_QUICK_REGISTER' => 'Y',
				'SMS_CODE' => openssl_encrypt(
					$smsCode,
					'AES-128-ECB', 
					ENCRYPTION_KEY
				),
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
					Loc::getMessage('BUYER')
				]
			);

			$arAjaxParams['MULTI_USER'] = 'Y';

		}

		die(Bitrix\Main\Web\Json::encode($arAjaxParams));

	
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
				$result['message'] = Loc::getMessage('SMS_CODE_SENDED');
			}  else {
				$result['error'] = true;
				$result['message'] = Loc::getMessage('SMS_CODE_NOT_SENDED');
		 	}

			die(Bitrix\Main\Web\Json::encode($result));

		} else {

			$smsVerify = $currentUser['UF_SMS_CODE'] === $_REQUEST['USER']['userCode'];

			if ($_REQUEST['USER_SELECTED'] == 'Y') {
				$smsVerify = $currentUser['UF_SMS_CODE'] === $_REQUEST['USER']['userCode'];
			}

			if ($smsVerify) {

				$USER->Authorize($currentUser['ID']);
				$result['error'] = false;
				$result['message'] = Loc::getMessage('YOU_GET_AUTH');
				$result['user'] = [
					'ID' => $USER->GetID(), 
					'LOGIN' => $USER->GetLogin(), 
					'EMAIL' => $USER->GetEmail(), 
					'FIRST_NAME' => $USER->GetFirstName(), 
					'LAST_NAME' => $USER->GetLastName()
				];
			} else {
				$result['error'] = true;
				$result['message'] = Loc::getMessage('WRONG_VEIRIFY_CODE');
			}

			die(Bitrix\Main\Web\Json::encode($result));

		}

	}

} else {

	$result['error'] = true;
    $result['message'] = Loc::getMessage('YOU_HAVE_AUTH');
    $result['user'] = [
		'ID' => $USER->GetID(), 
		'LOGIN' => $USER->GetLogin(), 
		'EMAIL' => $USER->GetEmail(), 
		'FIRST_NAME' => $USER->GetFirstName(), 
		'LAST_NAME' => $USER->GetLastName()
	];

	die(Bitrix\Main\Web\Json::encode($result));

}