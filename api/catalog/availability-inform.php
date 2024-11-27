<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

CModule::IncludeModule("catalog");

$result['error'] = false;
$result['message'] = '';

if (empty($_REQUEST['productId'])) {
    $result['error'] = true;
    $result['message'] = 'Неверный идентификатор товара';
}

if (empty($_REQUEST['name'])) {
    $result['error'] = true;
    $result['message'] = 'Имя не может быть пустой строкой';
}

if (!preg_grep('/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', [$_REQUEST['phone']])) {
    $result['error'] = true;
    $result['message'] = 'Неверный номер телефона';
	$result['phone'] = $_REQUEST['phone'];
}

if (!preg_grep('/^([a-zA-Z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/', [$_REQUEST['email']])) {
    $result['error'] = true;
    $result['message'] = 'Неверный email';
}

if ($result['error']) {
	ob_end_clean();
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($result);
	die();
}

if ($USER) {
	$userId = $USER->GetID();
	$userEmail = $USER->getEmail();
} else {
	$userId = false;
	$userEmail = false;
}

$userEmail = $_REQUEST['email'];

$subscribeManager = new \Bitrix\Catalog\Product\SubscribeManager;
$contactTypes = $subscribeManager->contactTypes;

$subscribeData = array(
    'USER_CONTACT' => $userEmail,
    'ITEM_ID' => $_REQUEST['productId'], //ID товара
    'SITE_ID' => 's1',
    'CONTACT_TYPE' => \Bitrix\Catalog\SubscribeTable::CONTACT_TYPE_EMAIL,
    'USER_ID' => $userId,
);

$subscribeId = $subscribeManager->addSubscribe($subscribeData);

if($subscribeId) {

} else {
    $errorObject = current($subscribeManager->getErrors());
    $errors = array('error' => true);
    if($errorObject)
    {
        $errors['message'] = $errorObject->getMessage();
        if($errorObject->getCode() == $subscribeManager::ERROR_ADD_SUBSCRIBE_ALREADY_EXISTS)
        {
            $errors['setButton'] = true;
        }
    }
}


$product_art = '';
$product_name = '';

CModule::IncludeModule('iblock');

$pr1 = CIBlockElement::GetByID($_REQUEST['productId']);

if ($pr2 = $pr1->GetNextElement()) {
	$f = $pr2->GetFields();
	$p = $pr2->GetProperties();
	$product_art = $p['CML2_ARTICLE']['VALUE'];
	$product_name = $f['NAME'];
}

$arEventFields = [
	//'PRODUCT_ART' => $product_art,
	//'PRODUCT_NAME' => $product_name,
	//'NAME' => $_REQUEST['name'],
	//'PHONE' => $_REQUEST['phone'],
	//'EMAIL' => $_REQUEST['email'],

	'USER_NAME' => $_REQUEST['name'],
	'EMAIL_TO' => $_REQUEST['email'],
	'NAME' => $product_name,
	'PAGE_URL' => '',
	'CHECKOUT_URL' => '',
	'CHECKOUT_URL_PARAMETERS' => '',
	'PRODUCT_ID' => $_REQUEST['productId'],
	'UNSUBSCRIBE_URL' => '',
	'UNSUBSCRIBE_URL_PARAMETERS' => '',

];

$result['event'] = $arEventFields;

$event = new CEvent;
$id = $event->SendImmediate("CATALOG_PRODUCT_SUBSCRIBE_NOTIFY_REPEATED", SITE_ID, $arEventFields);

$result['error'] = false;
$result['message'] = 'Ваше сообщение обрабатывается';
$result['id'] = $id;



ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($result);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>