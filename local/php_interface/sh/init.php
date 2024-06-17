<?
//auto_prepend_file = '/var/www/www-root/data/www/dev.stalker.ru/bitrix/modules/security/tools/start.php';

use \Bitrix\Main\Loader;
use \Bitrix\Main;
use Bitrix\Sale;
use Bitrix\Sale\Location;

include_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/sh/constants.php');

//Loader::registerAutoLoadClasses(null, [
//    'Spro\Image' => '/local/lib/Spro/Image.php',
//    'Spro\Dom' => '/local/lib/Spro/Dom.php',
//    'Spro\Events' => '/local/lib/Spro/Events.php',
//    'Spro\Options' => '/local/lib/Spro/Options.php',
//]);

function priceFormat( $value )
{
	if ( !$value ) return 0;
	$arValue = explode( '.', $value );
	if ( $arValue[ 1 ] > 0 ) return number_format( $value, 2, '.', ' ' );

	return number_format( $value, 0, '', ' ' );
}

/* output php array in js console
 * dima-vas@yandex.ru
 * */
function echo_j($data, $name = false){
//    if($name !== false){
//        $data = [$name => $data];
//    }
    $str = json_encode(unserialize(str_replace(array('NAN;','INF;'),'-1666;',serialize($data))));
    echo "<script>console.groupCollapsed('".$name."');console.dir(".$str.");console.groupEnd();</script>";
}


include_once $_SERVER['DOCUMENT_ROOT'].'/local/lib/Spro/Image.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/local/lib/Spro/Dom.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/local/lib/Spro/Events.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/local/lib/Spro/Options.php';
//include_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/wsrubi.smtp/classes/general/wsrubismtp.php');
//die();

function AddBonusPoints($order_id, $status) {
    $order = \Bitrix\Sale\Order::load($order_id);
    $user = new CUser;
    $u = $user->GetByID($order->getUserId());
    $res = [];
    $res['user'] = $u->GetNext();

    if ($order !== null && $status === 'F' && !empty($res['user']) && $res['user']['UF_TYPE'] === 'retail') {
        $basket = $order->getBasket();
        $res['total_bonus_by_order'] = 0;
        $res['user_bonus_points'] = floatval($res['user']['UF_BONUS_POINTS']);

        foreach($basket as $bsk_item) {
            $notes = $bsk_item->getField('NOTES');
            if ($notes !== 'nobonus') {
                $res['total_bonus_by_order'] += intval(mb_substr($notes, 7));
            }
        }

        if ($res['total_bonus_by_order'] > 0) {
            $bonus = $res['total_bonus_by_order'] + $res['user_bonus_points'];
            $res['upd'] = $user->Update($res['user']['ID'], ['UF_BONUS_POINTS' => intval($bonus)]);
            $res['bonus'] = $bonus;
        }
    }
}
function num_declension($number, $titles) {
    $abs = abs($number);
    $cases = array (2, 0, 1, 1, 1, 2);
    return $number." ".$titles[ ($abs%100 > 4 && $abs %100 < 20) ? 2 : $cases[min($abs%10, 5)] ];
}

//Main\EventManager::getInstance()->addEventHandler('sale', 'OnSaleComponentOrderOneStepOrderProps', 'OnSaleComponentOrderOneStepOrderProps');
//function OnSaleComponentOrderOneStepOrderProps(&$arResult, &$arUserResult, &$arParams)
//{
//    file_put_contents($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/sh/events.txt', print_r([$arResult, $arUserResult, $arParams]));
//    $arUserResult['DELIVERY_LOCATION'] = 269; // id Санкт-Петербурга
//}

//\Bitrix\Main\EventManager::getInstance()->addEventHandlerCompatible(
//    'sale',
//    'OnSaleComponentOrderProperties',
//    'SaleOrderEvents::fillLocation'
//);
//
//class SaleOrderEvents
//
//{
//
////    function fillLocation(&$arUserResult, $request, &$arParams, &$arResult)
////
////    {
////
////        $registry = \Bitrix\Sale\Registry::getInstance(\Bitrix\Sale\Registry::REGISTRY_TYPE_ORDER);
////        $orderClassName = $registry->getOrderClassName();
////        $order = $orderClassName::create(\Bitrix\Main\Application::getInstance()->getContext()->getSite());
////        $propertyCollection = $order->getPropertyCollection();
////
////        foreach ($propertyCollection as $property)
////        {
////            if ($property->isUtil())
////                continue;
////
////            $arProperty = $property->getProperty();
////            if(
////                $arProperty['TYPE'] === 'LOCATION'
////                && array_key_exists($arProperty['ID'],$arUserResult["ORDER_PROP"])
////                && !$request->getPost("ORDER_PROP_".$arProperty['ID'])
////                && (
////                    !is_array($arOrder=$request->getPost("order"))
////                    || !$arOrder["ORDER_PROP_".$arProperty['ID']]
////                )
////            ) {
////                $arUserResult["ORDER_PROP"][$arProperty['ID']] = 269;
////            }
////        }
////    }
//}


Main\EventManager::getInstance()->addEventHandler('sale', 'OnSaleComponentOrderProperties', ['OnSale','OnSaleComponentOrderProperties']);
//function OnSaleComponentOrderProperties(&$arUserResult, $request, &$arParams, &$arResult)
//{
//    file_put_contents($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/sh/events.txt', print_r([$arUserResult, $arResult, $arParams], 1));
//    $arUserResult['DELIVERY_LOCATION'] = 269; // id Санкт-Петербурга
//}

class OnSale{
    const PROP_LOCATION = 6;
    const PROP_ZIP = 4;
    const PROP_LOCATION_NAME = 5;
    const defaultCity = 269;
    const defaultUserCity = 'Санкт-Петербург';

    const DELIVERY_DEFAULT = 3;


    public static function OnSaleComponentOrderProperties(&$arFields)
    {
//        file_put_contents($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/sh/events.txt', print_r($arFields, 1), FILE_APPEND);

        $cityId = self::defaultCity;
        if(isset($_COOKIE['cityId'])){
            $cityId = $_COOKIE['cityId'];
        }

        $userCity = self::defaultUserCity;
        if(isset($_COOKIE['userCity'])){
            $userCity = $_COOKIE['userCity'];
        }

        $rsLocaction = CSaleLocation::GetLocationZIP($cityId);
        $arLocation = $rsLocaction->Fetch();

        if(!isset($arFields['ORDER_PROP'][self::PROP_ZIP])){
            $arFields['ORDER_PROP'][self::PROP_ZIP] = $arLocation['ZIP'];
        }
        if(!isset($arFields['ORDER_PROP'][self::PROP_LOCATION_NAME])){
            $arFields['ORDER_PROP'][self::PROP_LOCATION_NAME] = $userCity;
        }
        if(!isset($arFields['ORDER_PROP'][self::PROP_LOCATION])){
            $arFields['ORDER_PROP'][self::PROP_LOCATION] = CSaleLocation::getLocationCODEbyID($cityId);
        }
        if(!isset($arFields["DELIVERY_ID"]) || intval($arFields["DELIVERY_ID"]) < 1){
            $arFields["DELIVERY_ID"] = self::DELIVERY_DEFAULT;
            $arFields['ORDER_PROP'][self::PROP_ZIP] = $arLocation['ZIP'];
            $arFields['ORDER_PROP'][self::PROP_LOCATION_NAME] = $userCity;
            $arFields['ORDER_PROP'][self::PROP_LOCATION] = CSaleLocation::getLocationCODEbyID($cityId);
        }

//        file_put_contents($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/sh/events.txt', print_r([
//            'loc' => CSaleLocation::getLocationCODEbyID($cityId),
//            'cityId' => $cityId,
//            ], 1), FILE_APPEND);
//        file_put_contents($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/sh/events.txt', print_r($arFields, 1), FILE_APPEND);

    }
}

function _json_encode($val)
{
    if (is_string($val)) return '"'.addslashes($val).'"';
    if (is_numeric($val)) return $val;
    if ($val === null) return 'null';
    if ($val === true) return 'true';
    if ($val === false) return 'false';

    $assoc = false;
    $i = 0;
    foreach ($val as $k=>$v){
        if ($k !== $i++){
            $assoc = true;
            break;
        }
    }
    $res = array();
    foreach ($val as $k=>$v){
        $v = _json_encode($v);
        if ($assoc){
            $k = '"'.addslashes($k).'"';
            $v = $k.':'.$v;
        }
        $res[] = $v;
    }
    $res = implode(',', $res);
    return ($assoc)? '{'.$res.'}' : '['.$res.']';
}


AddEventHandler('main', 'OnEpilog', '_Check404Error', 1);
function _Check404Error(){
    if (defined('ERROR_404') && ERROR_404 == 'Y') {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/404.php';
        include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php';
    }
}


Main\EventManager::getInstance()->addEventHandler("main", "OnBeforeUserAdd", "OnBeforeUserRegisterHandler");
Main\EventManager::getInstance()->addEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserRegisterHandler");
function OnBeforeUserRegisterHandler(&$arFields)
{
    file_put_contents($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/sh/events_OnBeforeUser.txt', print_r($arFields, 1), FILE_APPEND);

    if(isset($arFields["EMAIL"]) && strpos($arFields["EMAIL"], "@") !== false){
        if($arFields["LOGIN"] !== $arFields["EMAIL"]){
            $arFields["LOGIN"] = $arFields["EMAIL"];
        }
    }
}


Main\EventManager::getInstance()->addEventHandler("main", "OnAfterUserAdd", "OnAfterUserRegisterHandler");
Main\EventManager::getInstance()->addEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");
Main\EventManager::getInstance()->addEventHandler("main", "OnAfterUserSimpleRegister", "OnAfterUserRegisterHandler");
function OnAfterUserRegisterHandler(&$arFields)
{
    file_put_contents($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/sh/events_OnAfterUser.txt', print_r($arFields, 1), FILE_APPEND);

    if (intval($arFields["ID"])>0)
    {
        $toSend = Array();
        $toSend["PASSWORD"] = $arFields["CONFIRM_PASSWORD"];
        $toSend["EMAIL"] = $arFields["EMAIL"];
        $toSend["USER_ID"] = $arFields["ID"];
        $toSend["USER_IP"] = $arFields["USER_IP"];
        $toSend["USER_HOST"] = $arFields["USER_HOST"];
        $toSend["LOGIN"] = $arFields["LOGIN"];
        $toSend["NAME"] = (trim ($arFields["NAME"]) == "") ? '' : $arFields["NAME"];
        $toSend["LAST_NAME"] = (trim ($arFields["LAST_NAME"]) == "") ? '' : $arFields["LAST_NAME"];
        CEvent::SendImmediate ("STALKER_USER_INFO", SITE_ID, $toSend);
    }
    return $arFields;
}