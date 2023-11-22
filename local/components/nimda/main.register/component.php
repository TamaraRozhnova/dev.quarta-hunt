<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @global CUserTypeManager $USER_FIELD_MANAGER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponent $this
 */

if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)
	die();

global $USER_FIELD_MANAGER;

// apply default param values
$arDefaultValues = array(
	"SHOW_FIELDS" => array(),
	"REQUIRED_FIELDS" => array(),
	"AUTH" => "Y",
	"USE_BACKURL" => "Y",
	"SUCCESS_PAGE" => "",
);

foreach ($arDefaultValues as $key => $value)
{
	if (!is_set($arParams, $key))
		$arParams[$key] = $value;
}
if(!is_array($arParams["SHOW_FIELDS"]))
	$arParams["SHOW_FIELDS"] = array();
if(!is_array($arParams["REQUIRED_FIELDS"]))
	$arParams["REQUIRED_FIELDS"] = array();

// if user registration blocked - return auth form
if (COption::GetOptionString("main", "new_user_registration", "N") == "N")
	$APPLICATION->AuthForm(array());

$arResult["PHONE_REGISTRATION"] = (COption::GetOptionString("main", "new_user_phone_auth", "N") == "Y");

//$arResult["PHONE_REQUIRED"] = ($arResult["PHONE_REGISTRATION"] && COption::GetOptionString("main", "new_user_phone_required", "N") == "Y");
//$arResult["EMAIL_REGISTRATION"] = (COption::GetOptionString("main", "new_user_email_auth", "Y") <> "N");
//$arResult["EMAIL_REQUIRED"] = ($arResult["EMAIL_REGISTRATION"] && COption::GetOptionString("main", "new_user_email_required", "Y") <> "N");
//$arResult["USE_EMAIL_CONFIRMATION"] = (COption::GetOptionString("main", "new_user_registration_email_confirmation", "N") == "Y" && $arResult["EMAIL_REQUIRED"]? "Y" : "N");


//$arResult["PHONE_REGISTRATION"] = ($arResult["PHONE_REGISTRATION"] && COption::GetOptionString("main", "new_user_phone_required", "N") == "Y");
$arResult["PHONE_REGISTRATION"] = false;
$arResult["PHONE_REQUIRED"] = "Y";
$arResult["EMAIL_REGISTRATION"] = "Y";
$arResult["EMAIL_REQUIRED"] = "Y";
$arResult["USE_EMAIL_CONFIRMATION"] = "Y";

$arResult["PHONE_CODE_RESEND_INTERVAL"] = CUser::PHONE_CODE_RESEND_INTERVAL;

// apply core fields to user defined
$arDefaultFields = array(
	"LOGIN",
);
if($arResult["EMAIL_REQUIRED"])
{
	$arDefaultFields[] = "EMAIL";
}
if($arResult["PHONE_REQUIRED"])
{
	$arDefaultFields[] = "PERSONAL_PHONE";
}
$arDefaultFields[] = "PASSWORD";
$arDefaultFields[] = "CONFIRM_PASSWORD";

$def_group = COption::GetOptionString("main", "new_user_registration_def_group", "");
if($def_group <> "")
	$arResult["GROUP_POLICY"] = CUser::GetGroupPolicy(explode(",", $def_group));
else
	$arResult["GROUP_POLICY"] = CUser::GetGroupPolicy(array());

$arResult["SHOW_FIELDS"] = array_unique(array_merge($arDefaultFields, $arParams["SHOW_FIELDS"]));
$arResult["REQUIRED_FIELDS"] = array_unique(array_merge($arDefaultFields, $arParams["REQUIRED_FIELDS"]));

// use captcha?
$arResult["USE_CAPTCHA"] = COption::GetOptionString("main", "captcha_registration", "N") == "Y" ? "Y" : "N";

// start values
$arResult["VALUES"] = array();
$arResult["ERRORS"] = array();
$arResult["SHOW_SMS_FIELD"] = false;
$register_done = false;

// register user
$process = false;
if($arParams["FORM_ID"] != ''){
    if($_REQUEST["form_id"] != '' and $arParams["FORM_ID"] == $_REQUEST["form_id"]){
        $process = true;
    }
}else{
    $process = true;
}

$noauth = false;
if($arParams["WOAUTH"] == 'Y' || !$USER->IsAuthorized()){
    $noauth = true;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && $_REQUEST["register_submit_button"] <> '' && $process && $noauth)
{
	if(COption::GetOptionString('main', 'use_encrypted_auth', 'N') == 'Y')
	{
		//possible encrypted user password
		$sec = new CRsaSecurity();
		if(($arKeys = $sec->LoadKeys()))
		{
			$sec->SetKeys($arKeys);
			$errno = $sec->AcceptFromForm(array('REGISTER'));
			if($errno == CRsaSecurity::ERROR_SESS_CHECK)
				$arResult["ERRORS"][] = GetMessage("main_register_sess_expired");
			elseif($errno < 0)
				$arResult["ERRORS"][] = GetMessage("main_register_decode_err", array("#ERRCODE#"=>$errno));
		}
	}

    if(strlen($_REQUEST["REGISTER"]["PERSONAL_PHONE"])){
        $phoneNumber = preg_replace("/[^0-9+]/", "", $_REQUEST["REGISTER"]["PERSONAL_PHONE"]);
        $_REQUEST["REGISTER"]["PERSONAL_PHONE"] = $phoneNumber;
//        $_REQUEST["PERSONAL_PHONE"] = $phoneNumber;
    }

	// check emptiness of required fields
	foreach ($arResult["SHOW_FIELDS"] as $key)
	{
		if ($key != "PERSONAL_PHOTO" && $key != "WORK_LOGO")
		{
			$arResult["VALUES"][$key] = $_REQUEST["REGISTER"][$key];
			if (in_array($key, $arResult["REQUIRED_FIELDS"]) && trim($arResult["VALUES"][$key]) == '')
				$arResult["ERRORS"][$key] = GetMessage("REGISTER_FIELD_REQUIRED");
		}
		else
		{
			$_FILES["REGISTER_FILES_".$key]["MODULE_ID"] = "main";
			$arResult["VALUES"][$key] = $_FILES["REGISTER_FILES_".$key];
			if (in_array($key, $arResult["REQUIRED_FIELDS"]) && !is_uploaded_file($_FILES["REGISTER_FILES_".$key]["tmp_name"]))
				$arResult["ERRORS"][$key] = GetMessage("REGISTER_FIELD_REQUIRED");
		}
	}

	if(isset($_REQUEST["REGISTER"]["TIME_ZONE"]))
		$arResult["VALUES"]["TIME_ZONE"] = $_REQUEST["REGISTER"]["TIME_ZONE"];

//    $phoneNumber = Main\UserPhoneAuthTable::normalizePhoneNumber($_REQUEST["REGISTER"]["PERSONAL_PHONE"]);


    /**
     * Логика со специалистами
     */
    if(isset($_REQUEST["ACCOUNT_TYPE"])) {
        if (isset($_REQUEST["SPEC"])) {
            $arResult['VALUES_SPEC']["SPEC"] = $_REQUEST["SPEC"];
        }
    }

	//this is a part of CheckFields() to show errors about user defined fields
    $check = $USER_FIELD_MANAGER->CheckFields("USER", 0, $arResult["VALUES"]);
	if (!$check)
	{
		$e = $APPLICATION->GetException();
		$arResult["ERRORS"][] = mb_substr($e->GetString(), 0, -4).' hello'; //cutting "<br>"
		$APPLICATION->ResetException();
	}

	// check captcha
	if ($arResult["USE_CAPTCHA"] == "Y")
	{
		if (!$APPLICATION->CaptchaCheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_sid"]))
			$arResult["ERRORS"][] = GetMessage("REGISTER_WRONG_CAPTCHA");
	}

	// check EMAIL
	if ($_REQUEST["REGISTER"]["EMAIL"])
	{
        $filter = ["EMAIL" => $_REQUEST["REGISTER"]["EMAIL"]];

        $rsUsers = CUser::GetList(($by="id"), ($order="desc"), $filter); // выбираем пользователей
        if($arUser = $rsUsers->Fetch()){

            $accountType = 'bride';
            if(isset($_REQUEST["ACCOUNT_TYPE"])){
                if(isset($_REQUEST["SPEC"])){
                    $accountType = 'spec';
                }
            }

            $arGroups = CUser::GetUserGroup($arUser["ID"]);

            $rsGroups = CGroup::GetList ($by = "c_sort", $order = "asc", Array ("STRING_ID" => USER_GROUP_BRIDES_CODE));
            $arUserGroup = $rsGroups->Fetch();
            $GROUP_BRIDES = $arUserGroup["ID"];

            $rsGroups = CGroup::GetList ($by = "c_sort", $order = "asc", Array ("STRING_ID" => USER_GROUP_SPECS_CODE));
            $arUserGroup = $rsGroups->Fetch();
            $GROUP_SPECS = $arUserGroup["ID"];

            $typeError = false;
            if(in_array($GROUP_BRIDES, $arGroups) and $accountType != 'bride'){
                $typeError = true;
            }
            if(in_array($GROUP_SPECS, $arGroups) and $accountType != 'spec'){
                $typeError = true;
            }

            if($typeError){
                $arResult["ERRORS"][] = GetMessage("REGISTER_USER_WITH_EMAIL_EXIST_TYPE_ERROR");
            }else{
                $arResult["ERRORS"][] = GetMessage("REGISTER_USER_WITH_EMAIL_EXIST");
            }

        }

	}

	// check PHONE
	if ($_REQUEST["REGISTER"]["PERSONAL_PHONE"])
	{
//        $phone = '+'.preg_replace("/[^0-9+]/", "", $_REQUEST["REGISTER"]["PERSONAL_PHONE"]);

        $filter = ["PERSONAL_PHONE" => $_REQUEST["REGISTER"]["PERSONAL_PHONE"]." | ".$phone];

        $rsUsers = CUser::GetList(($by="id"), ($order="desc"), $filter); // выбираем пользователей
        if($arUser = $rsUsers->Fetch()){
            $accountType = 'bride';
            if(isset($_REQUEST["ACCOUNT_TYPE"])){
                if(isset($_REQUEST["SPEC"])){
                    $accountType = 'spec';
                }
            }

            $arGroups = CUser::GetUserGroup($arUser["ID"]);

            $rsGroups = CGroup::GetList ($by = "c_sort", $order = "asc", Array ("STRING_ID" => USER_GROUP_BRIDES_CODE));
            $arUserGroup = $rsGroups->Fetch();
            $GROUP_BRIDES = $arUserGroup["ID"];

            $rsGroups = CGroup::GetList ($by = "c_sort", $order = "asc", Array ("STRING_ID" => USER_GROUP_SPECS_CODE));
            $arUserGroup = $rsGroups->Fetch();
            $GROUP_SPECS = $arUserGroup["ID"];

            $typeError = false;
            if(in_array($GROUP_BRIDES, $arGroups) and $accountType != 'bride'){
                $typeError = true;
            }
            if(in_array($GROUP_SPECS, $arGroups) and $accountType != 'spec'){
                $typeError = true;
            }

            if($typeError){
                $arResult["ERRORS"][] = GetMessage("REGISTER_USER_WITH_PHONE_EXIST_TYPE_ERROR");
            }else{
                $arResult["ERRORS"][] = GetMessage("REGISTER_USER_WITH_PHONE_EXIST");
            }

        }

	}

	if(count($arResult["ERRORS"]) > 0)
	{
		if(COption::GetOptionString("main", "event_log_register_fail", "N") === "Y")
		{
			$arError = $arResult["ERRORS"];
			foreach($arError as $key => $error)
				if(intval($key) == 0 && $key !== 0) 
					$arError[$key] = str_replace("#FIELD_NAME#", '"'.$key.'"', $error);
			CEventLog::Log("SECURITY", "USER_REGISTER_FAIL", "main", false, implode("<br>", $arError));
		}
	}
	else // if there's no any errors - create user
	{
		$arResult['VALUES']["GROUP_ID"] = array();
		$def_group = COption::GetOptionString("main", "new_user_registration_def_group", "");
		if($def_group != "")
			$arResult['VALUES']["GROUP_ID"] = explode(",", $def_group);

        $company = $_REQUEST["REGISTER"]["NAME"]." ".$_REQUEST["REGISTER"]["LAST_NAME"];

        if($_REQUEST["REGISTER"]){
            foreach ($_REQUEST["REGISTER"] as $key => $val){
                switch ($key){
                    case "NAME":
                        $name = $val;
                        break;
                    case "LAST_NAME":
                        $last_name = $val;
                        break;
                    case "PERSONAL_PHONE":
//                        $phone = '+'.preg_replace("/[^0-9+]/", "", $val);
//                        $phone = Main\UserPhoneAuthTable::normalizePhoneNumber($val);

//                        $arResult['VALUES']["PHONE_NUMBER"] = $val;
                        $arResult['VALUES']["PERSONAL_PHONE"] = $val;
                        $arResult['VALUES']["WORK_PHONE"] = $val;
                        break;
                    case "COMPANY":
                        if(strlen($val) < 1){
                            $arResult['VALUES']["WORK_COMPANY"] = $company;
                        }else{
                            $arResult['VALUES']["WORK_COMPANY"] = $val;
                        }
                        break;
                    default:
                        $arResult['VALUES'][$key] = $val;
                        break;
                }
            }
        }


        /**
         * Логика со специалистами
         */
        $G_SV_CODE = false;
        if(isset($_REQUEST["ACCOUNT_TYPE"])){
            if(isset($_REQUEST["SPEC"])){
                $arResult['VALUES_SPEC']["SPEC"] = $_REQUEST["SPEC"];
            }

            if($_REQUEST["ACCOUNT_TYPE"] == "SPEC"){
                $G_SV_CODE = "sv_specs";

                $arResult['VALUES']["UF_SPEC"] = "Y";
                $arResult['VALUES']["UF_PROFILE_SPEC"] = "Y";


                if(isset($_REQUEST["SPEC"]["SERVICES"])){
                    $arSpecServices = $_REQUEST["SPEC"]["SERVICES"];

                    $iBlockId = false;
                    $iBlockType = IBLOCK_TYPE_SV;
                    if (!empty($iBlockType)){
                        $iblock = CIBlock::GetList([], ['=TYPE' => IBLOCK_TYPE_SV, '=CODE' => IBLOCK_CATALOG_SPECS_TYPES_CODE])->Fetch();
                        $iBlockId = $iblock['ID'];
                    }

                    $arSelect = Array("ID", "IBLOCK_ID", "NAME");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
                    $arFilter = Array("IBLOCK_ID"=>$iBlockId, "ID"=>$arSpecServices, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                    $res = CIBlockElement::GetList(Array('NAME'=>"ASC"), $arFilter, false, false, $arSelect);

                    $userServiceTypes = [];
                    while($ob = $res->GetNextElement()){
                        $arFields = $ob->GetFields();
//                        $arProps = $ob->GetProperties();

                        $userServiceTypes[] = $arFields["NAME"];
                    }

                    if(count($userServiceTypes) > 0){
                        $userServiceTypesList = implode(", ",  $userServiceTypes);
                        $arResult['VALUES']["WORK_PROFILE"] = $userServiceTypesList;
                    }
                }


            }else{
                $G_SV_CODE = "sv_brides";
            }

            $arResult['VALUES']["UF_LOGIN_GROUP_CODE"] = $G_SV_CODE;

//            $arResult['VALUES']["LOGIN"] = $arResult['VALUES']["EMAIL"]."_".$G_SV_CODE;
        }

        if($G_SV_CODE !== false and strlen($G_SV_CODE)>1){
            $rsGroups = CGroup::GetList ($by = "c_sort", $order = "asc", Array ("STRING_ID" => $G_SV_CODE));
            $arUserGroup = $rsGroups->Fetch();
            $gId = $arUserGroup["ID"];

            if($gId > 0){
                $arResult['VALUES']["GROUP_ID"][] = $gId;
            }
        }

        $arResult["DBG"] = [
            "G_SV_CODE" => $G_SV_CODE,
            "arUserGroup" => $arUserGroup
        ];

        $bConfirmReq = ($arResult["USE_EMAIL_CONFIRMATION"] === "Y");
		$active = ($bConfirmReq || $arResult["PHONE_REQUIRED"]? "N": "Y");

		$arResult['VALUES']["CHECKWORD"] = md5(CMain::GetServerUniqID().uniqid());
		$arResult['VALUES']["~CHECKWORD_TIME"] = $DB->CurrentTimeFunction();
		$arResult['VALUES']["ACTIVE"] = $active;
		$arResult['VALUES']["CONFIRM_CODE"] = ($bConfirmReq? randString(8): "");
		$arResult['VALUES']["LID"] = SITE_ID;
		$arResult['VALUES']["LANGUAGE_ID"] = LANGUAGE_ID;

		$arResult['VALUES']["USER_IP"] = $_SERVER["REMOTE_ADDR"];
		$arResult['VALUES']["USER_HOST"] = @gethostbyaddr($_SERVER["REMOTE_ADDR"]);
		
		if($arResult["VALUES"]["AUTO_TIME_ZONE"] <> "Y" && $arResult["VALUES"]["AUTO_TIME_ZONE"] <> "N")
			$arResult["VALUES"]["AUTO_TIME_ZONE"] = "";

        $arResult["DBG23"] = $arResult['VALUES'];

        $bOk = true;

		$events = GetModuleEvents("main", "OnBeforeUserRegister", true);

        $arResult["DBGevents"][] = $events;

//        print_r($arResult["DBGevents"]);

        foreach($events as $arEvent)
		{
            $arResult["DBG6"][] = $arEvent;
//            if($arEvent["TO_MODULE_ID"] != "aspro.max"){
                if(ExecuteModuleEventEx($arEvent, array(&$arResult['VALUES'])) === false)
                {
                    if($err = $APPLICATION->GetException())
                        $arResult['ERRORS'][] = $err->GetString();

                    $bOk = false;
                    break;
                }
//            }
		}

        $arResult["DBG24"] = $arResult['VALUES'];

        /**
         * Логика со специалистами
         */
        if(isset($_REQUEST["ACCOUNT_TYPE"])){
//            $arResult['VALUES']["LOGIN"] = $arResult['VALUES']["EMAIL"]."_".$G_SV_CODE;
        }

		$userID = 0;
		$user = new CUser();
		if ($bOk)
		{
            $arResult["user_load"] = $arResult["VALUES"];

//            print_r($arResult["VALUES"]);

            $userID = $user->Add($arResult["VALUES"]);
		}

		if (intval($userID) > 0)
		{
			if($arResult["PHONE_REGISTRATION"] === true && $arResult['VALUES']["PERSONAL_PHONE"] <> '')
			{
				//added the phone number for the user, now sending a confirmation SMS
				list($code, $phoneNumber) = CUser::GeneratePhoneCode($userID);

				$sms = new \Bitrix\Main\Sms\Event(
					"SMS_USER_CONFIRM_NUMBER",
					[
						"USER_PHONE" => $phoneNumber,
						"CODE" => $code,
					]
				);
				$smsResult = $sms->send(true);

				if(!$smsResult->isSuccess())
				{
					$arResult["ERRORS"] = array_merge($arResult["ERRORS"], $smsResult->getErrorMessages())." herro";
				}

				$arResult["SHOW_SMS_FIELD"] = true;
				$arResult["SIGNED_DATA"] = \Bitrix\Main\Controller\PhoneAuth::signData(['phoneNumber' => $phoneNumber]);
			}
			else
			{
				$register_done = true;

				// authorize user
				if ($arParams["AUTH"] == "Y" && $arResult["VALUES"]["ACTIVE"] == "Y")
				{
					if (!$arAuthResult = $USER->Login($arResult["VALUES"]["LOGIN"], $arResult["VALUES"]["PASSWORD"]))
						$arResult["ERRORS"][] = $arAuthResult;
				}
			}

			$arResult['VALUES']["USER_ID"] = $userID;

			$arEventFields = $arResult['VALUES'];
			unset($arEventFields["PASSWORD"]);
			unset($arEventFields["CONFIRM_PASSWORD"]);

			$event = new CEvent;
			$event->SendImmediate("NEW_USER", SITE_ID, $arEventFields);
			if($bConfirmReq) {
//				$event->SendImmediate("NEW_USER_CONFIRM", SITE_ID, $arEventFields);
            }


            /**
             * Логика со специалистами
             */
            if($G_SV_CODE == "sv_specs"){

                $SPEC_PROP = array();
                $SPEC_PROP["USER_ID"] = $userID;

                if(strlen($_REQUEST["SPEC"]["CITY"]) > 0){
                    $spec_cityId = $_REQUEST["SPEC"]["CITY"];
                    $SPEC_PROP["GEO"] = $spec_cityId;
                }

                if(strlen($_REQUEST["SPEC"]["SERVICES"]) > 0){
                    $arSpecServices = $_REQUEST["SPEC"]["SERVICES"];
                    $SPEC_PROP["TYPES"] = $arSpecServices;
                }

                if(strlen($_REQUEST["SPEC"]["SITE"]) > 0){
                    $SPEC_PROP["SITE"] = $_REQUEST["SPEC"]["SITE"];
                }

                if(strlen($_REQUEST["SPEC"]["VK"]) > 0){
                    $SPEC_PROP["VK"] = $_REQUEST["SPEC"]["VK"];
                }

                if(strlen($_REQUEST["REGISTER"]["COMPANY"]) > 0){
                    $SPEC_PROP["COMPANY"] = $_REQUEST["REGISTER"]["COMPANY"];
                }

                $arSPECS_IBLOCK = CIBlock::GetList([], ['=TYPE' => IBLOCK_TYPE_SV, '=CODE' => IBLOCK_CATALOG_SPECS_CODE])->Fetch();
                $SPECS_IBID = $arSPECS_IBLOCK['ID'];

                if($SPECS_IBID > 0){
                    $arSpecLoad = Array(
                        "MODIFIED_BY"    => $userID, // элемент изменен текущим пользователем
                        "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                        "IBLOCK_ID"      => $SPECS_IBID,
                        "PROPERTY_VALUES"=> $SPEC_PROP,
                        "NAME"           => $company,
                        "CODE"           => 's'.$userID,
                        "ACTIVE"         => "Y",            // активен
                        "PREVIEW_TEXT"   => "",
                        "DETAIL_TEXT"    => "",
                        //        "DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image.gif")
                    );


                    $el = new CIBlockElement;
                    if($uID = $el->Add($arSpecLoad)) {
                        $created = true;
                    }else{
                        $error = true;
                        $error_text = "Ошибка при создании профиля: ".$el->LAST_ERROR;
                    }

                    $arResult["DBG_arSpecLoad"] = $arSpecLoad;
                }
            }
		}
		else
		{
			$arResult["ERRORS"][] = $user->LAST_ERROR;
		}

		if(count($arResult["ERRORS"]) <= 0)
		{
			if(COption::GetOptionString("main", "event_log_register", "N") === "Y")
				CEventLog::Log("SECURITY", "USER_REGISTER", "main", $userID);
		}
		else
		{
			if(COption::GetOptionString("main", "event_log_register_fail", "N") === "Y")
				CEventLog::Log("SECURITY", "USER_REGISTER_FAIL", "main", $userID, implode("<br>", $arResult["ERRORS"]));
		}

		$events = GetModuleEvents("main", "OnAfterUserRegister", true);

//        print_r($events);

        foreach ($events as $arEvent)
			ExecuteModuleEventEx($arEvent, array(&$arResult['VALUES']));


	}
}

// verify phone code
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_REQUEST["code_submit_button"] <> '' && !$USER->IsAuthorized() )
{
	if($_REQUEST["SIGNED_DATA"] <> '')
	{
		if(($params = \Bitrix\Main\Controller\PhoneAuth::extractData($_REQUEST["SIGNED_DATA"])) !== false)
		{
			if(($userId = CUser::VerifyPhoneCode($params['phoneNumber'], $_REQUEST["SMS_CODE"])))
			{
				$register_done = true;

				if($arResult["PHONE_REQUIRED"])
				{
					//the user was added as inactive, now phone number is confirmed, activate them
					$user = new CUser();
					$user->Update($userId, ["ACTIVE" => "Y"]);
				}

				// authorize user
				if ($arParams["AUTH"] == "Y")
				{
					//here should be login
					$USER->Authorize($userId);
				}
			}
			else
			{
				$arResult["ERRORS"][] = GetMessage("main_register_error_sms");
				$arResult["SHOW_SMS_FIELD"] = true;
				$arResult["SMS_CODE"] = $_REQUEST["SMS_CODE"];
				$arResult["SIGNED_DATA"] = $_REQUEST["SIGNED_DATA"];
			}
		}
	}
}
// if user is registered - redirect him to backurl or to success_page; currently added users too
if($register_done)
{
	if($arParams["USE_BACKURL"] == "Y" && $_REQUEST["backurl"] <> '')
		LocalRedirect($_REQUEST["backurl"]);
	elseif($arParams["SUCCESS_PAGE"] <> '')
		LocalRedirect($arParams["SUCCESS_PAGE"]);
}

$arResult["VALUES"] = htmlspecialcharsEx($arResult["VALUES"]);

// redefine required list - for better use in template
$arResult["REQUIRED_FIELDS_FLAGS"] = array();
foreach ($arResult["REQUIRED_FIELDS"] as $field)
	$arResult["REQUIRED_FIELDS_FLAGS"][$field] = "Y";

// check backurl existance
$arResult["BACKURL"] = htmlspecialcharsbx($_REQUEST["backurl"]);

// get countries list
if (in_array("PERSONAL_COUNTRY", $arResult["SHOW_FIELDS"]) || in_array("WORK_COUNTRY", $arResult["SHOW_FIELDS"])) 
	$arResult["COUNTRIES"] = GetCountryArray();

// get date format
if (in_array("PERSONAL_BIRTHDAY", $arResult["SHOW_FIELDS"])) 
	$arResult["DATE_FORMAT"] = CLang::GetDateFormat("SHORT");

// ********************* User properties ***************************************************
$arResult["USER_PROPERTIES"] = array("SHOW" => "N");
$arUserFields = $USER_FIELD_MANAGER->GetUserFields("USER", 0, LANGUAGE_ID);
if (is_array($arUserFields) && count($arUserFields) > 0)
{
	if (!is_array($arParams["USER_PROPERTY"]))
		$arParams["USER_PROPERTY"] = array($arParams["USER_PROPERTY"]);

	foreach ($arUserFields as $FIELD_NAME => $arUserField)
	{
		if (!in_array($FIELD_NAME, $arParams["USER_PROPERTY"]) && $arUserField["MANDATORY"] != "Y")
			continue;

		$arUserField["EDIT_FORM_LABEL"] = $arUserField["EDIT_FORM_LABEL"] <> '' ? $arUserField["EDIT_FORM_LABEL"] : $arUserField["FIELD_NAME"];
		$arUserField["EDIT_FORM_LABEL"] = htmlspecialcharsEx($arUserField["EDIT_FORM_LABEL"]);
		$arUserField["~EDIT_FORM_LABEL"] = $arUserField["EDIT_FORM_LABEL"];
		$arResult["USER_PROPERTIES"]["DATA"][$FIELD_NAME] = $arUserField;
	}
}
if (!empty($arResult["USER_PROPERTIES"]["DATA"]))
{
	$arResult["USER_PROPERTIES"]["SHOW"] = "Y";
	$arResult["bVarsFromForm"] = (count($arResult['ERRORS']) <= 0) ? false : true;
}
// ******************** /User properties ***************************************************

// initialize captcha
if ($arResult["USE_CAPTCHA"] == "Y")
	$arResult["CAPTCHA_CODE"] = htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

// set title
if ($arParams["SET_TITLE"] == "Y") 
	$APPLICATION->SetTitle(GetMessage("REGISTER_DEFAULT_TITLE"));

//time zones
$arResult["TIME_ZONE_ENABLED"] = CTimeZone::Enabled();
if($arResult["TIME_ZONE_ENABLED"])
	$arResult["TIME_ZONE_LIST"] = CTimeZone::GetZones();

$arResult["SECURE_AUTH"] = false;
if(!CMain::IsHTTPS() && COption::GetOptionString('main', 'use_encrypted_auth', 'N') == 'Y')
{
	$sec = new CRsaSecurity();
	if(($arKeys = $sec->LoadKeys()))
	{
		$sec->SetKeys($arKeys);
		$sec->AddToForm('regform', array('REGISTER[PASSWORD]', 'REGISTER[CONFIRM_PASSWORD]'));
		$arResult["SECURE_AUTH"] = true;
	}
}

// all done
$this->IncludeComponentTemplate();
