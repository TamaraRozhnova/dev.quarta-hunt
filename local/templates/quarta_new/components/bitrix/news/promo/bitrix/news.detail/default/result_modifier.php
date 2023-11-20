<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\SystemException;
use Bitrix\Conversion\Internals\MobileDetect;
use General\User;

if (!Loader::includeModule('conversion')) {
    throw new SystemException('Module conversion is not initialized');
}

$mobileDetectObj = new MobileDetect();

if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arResult["DETAIL_PICTURE"])) {
    if (!$mobileDetectObj->isMobile()) {
        $arResult['PICTURE'] = $arResult["DETAIL_PICTURE"]["SRC"];
    } else {
        if (!empty($arResult['PROPERTIES']['MOB_IMAGE_DETAIL']['VALUE'])) {
            $arResult['PICTURE'] = CFile::getPath($arResult['PROPERTIES']['MOB_IMAGE_DETAIL']['VALUE']);
        } else {
            $arResult['PICTURE'] = $arResult["DETAIL_PICTURE"]["SRC"];
        }
    }
}

//цены пользователя
$user = new User();
$arResult['PRICE_CODE'] = $user->getUserPriceCode();
