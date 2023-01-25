<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

global $USER;
global $DB;

$type = strip_tags($_POST['type']); // тип пользователя - retail, wholesale
$promo = strip_tags($_POST['promo']); // отправлять акции и предложения по email

// пользователь
$phone = strip_tags($_POST['phone']); // телефон
$email = strip_tags($_POST['email']); // email
$firstname = strip_tags($_POST['firstName']); // имя
$lastname = strip_tags($_POST['secondName']); // фамилия
$password = strip_tags($_POST['password']); // пароль
$password_confirm = strip_tags($_POST['password']); // подтверждение пароля

// оптовик
$company = strip_tags($_POST['company']); // компания
$address = strip_tags($_POST['address']); // адрес
$marketplace = strip_tags($_POST['marketplace']); // торговая площадка
$contactperson = strip_tags($_POST['contactPerson']); // контактное лицо
$position = strip_tags($_POST['position']); // должность
$contactphone = strip_tags($_POST['phone']); // телефон
$site = strip_tags($_POST['site']); // сайт

if (empty($firstname)) $firstname = $contactperson;
if (empty($phone)) $phone = $contactphone;

/*
$phone = '+7 (999) 999-88-77';
$email = 'anastasiya_petrova@mail.ru';
$firstname = 'Анастасия';
$lastname = 'Петрова';
$password = 'anastasiya1111';
$password_confirm = 'anastasiya1111';
*/

$bConfirmReq = (COption::GetOptionString("main", "new_user_registration_email_confirmation", "N")) == "Y";

$arFields = Array(
	"PERSONAL_PHONE"	=> $phone,
	"EMAIL"             => $email,
	"NAME"              => $firstname,
	"LAST_NAME"         => $lastname,
	"LOGIN"             => $email,
	"WORK_COMPANY"      => $company,
	"WORK_STREET"		=> $address,
	"WORK_DEPARTMENT"	=> $marketplace,
	"WORK_POSITION"     => $position,
	"WORK_PHONE"        => $contactphone,
	"WORK_WWW"			=> $site,
	"LID"               => SITE_ID,
	"ACTIVE"            => $type === "wholesale" ? "N" : "Y",
	"GROUP_ID"          => $type === "wholesale" ? array(9) : array(6),
	"PASSWORD"          => $password,
	"CONFIRM_PASSWORD"  => $password_confirm,
	"CHECKWORD" 		=> md5(CMain::GetServerUniqID().uniqid()),
	"~CHECKWORD_TIME" 	=> $DB->CurrentTimeFunction(),
	"CONFIRM_CODE" 		=> $bConfirmReq ? randString(8): "",
	"UF_TYPE"			=> $type,
	"UF_PROMO"			=> $promo,
	"UF_BONUS_POINTS"	=> 0,
	"USER_TYPE"			=> $type === "wholesale" ? "Оптовый" : "Розничный",
);

$CUser = new CUser;
$USER_ID = $CUser->Add($arFields);

if (intval($USER_ID) > 0) {
	$USER->Authorize($USER_ID);

	$result['error'] = false;
	$result['message'] = 'Вы успешно зарегистрировались, Вам отправлено писмо для потверждения';

	$arFields['USER_ID'] = $USER_ID;
	$arEventFields = $arFields;
	$event = new CEvent;

	if ($bConfirmReq) {
		$event->SendImmediate("NEW_USER_CONFIRM", SITE_ID, $arEventFields);
	} else {
		$event->SendImmediate("USER_INFO", SITE_ID, $arEventFields);
	}

	$event->SendImmediate("NEW_USER", SITE_ID, $arEventFields);
} else {
	$result['error'] = true;
	$result['message'] = $CUser->LAST_ERROR;
}

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($result);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

