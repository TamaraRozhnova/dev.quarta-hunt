<?php 

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

use Bitrix\Main\Loader,
	Bitrix\Main\Engine\CurrentUser,
	Bitrix\Main\UserTable,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Web\Json,
	Targetsms\Sms\Sender,
	Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

if(!check_bitrix_sessid()){
    die("ACCESS_DENIED");
}

if (!Loader::includeModule('targetsms.sms')) {
	die(Loc::getMessage('TARGET_SMS_ISNT_INIT'));
}	

define('TYPES_USER', [
	'retail' => Loc::getMessage('TYPE_USER_RETAIL'),
	'wholesale' => Loc::getMessage('TYPE_USER_OPT')
]);

define('ENCRYPTION_KEY', 'VPTDI1JY5fLMPunFcTIZ3X-W-e4');

$currentUser = CurrentUser::get();
$userObj = new CUser();

if (isset($_POST['captcha']) && !checkCustomCaptcha($_POST['captcha'])) {
	die(Json::encode([
		'captcha_error' => true,
		'message' => Loc::getMessage('WRONG_CARTCHA')	
	]));
}

if ($_REQUEST['PROCESS_QUICK_REGISTER'] == 'Y') {

	/**
	 * Начинаем быструю регистрацию
	 */

	if (empty($_REQUEST['FIELDS'])) {
		die(Json::encode([
			'STATUS' => 'ERROR',
			'ERR' => Loc::getMessage('EMPTY_FIELDS_W')
		]));
	}

	if (empty($_REQUEST['SMS_CODE'])) {
		die(Json::encode([
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
		die(Json::encode([
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
		'GROUP_ID' => [$groupRegUsersId],
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
	
			die(Json::encode([
				'ID_USER' => $idUser,
				'STATUS' => 'SUCCESS',
			]));
	
		}

	}

	die(Json::encode([
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

	if (empty($rsUsers) && !isset($_REQUEST['IS_BYU_ONE_CLICK'])) {

		$smsObj = new Sender();
		$smsCode = rand(1111, 9999);
	
		$rsSendSms = $smsObj->sendSms(
			$_REQUEST['USER']['PERSONAL_PHONE'], 
			implode(' ', [
				Loc::getMessage('TEXT_SMS'),
				$smsCode
			]), 
			'', 
			'quarta-hunt', 
			'quartahunt-login'
		);

		die(
			Json::encode([
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

		die(Json::encode($arAjaxParams));

	
	} else {

		if (isset($_REQUEST['IS_BYU_ONE_CLICK'])) {									
			die(Json::encode(['data' => 'ok']));			
		}

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
				implode(' ', [
					Loc::getMessage('TEXT_SMS'),
					$smsCode
				]), 
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

			die(Json::encode($result));

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

			die(Json::encode($result));

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

	die(Json::encode($result));

}