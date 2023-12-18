<?php 

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\SystemException;
use Bitrix\Sale\Internals\DiscountCouponTable;

if (!Loader::includeModule('sale')) {
    throw new SystemException('Module sale is not initialized');
}

if ($arResult["VIEW_REF_COUPON"] !== 'Y') {
    return false;
}

if (!empty($arResult['COUPON'])) {
    $rsDiscountTable = DiscountCouponTable::getList([
        'select' => ['*'],
        'filter' => [
            'COUPON' => $arResult['COUPON']
        ]
    ])->fetch();

    if (!empty($rsDiscountTable['USE_COUNT'])) {
        $arResult['USE_COUNT_COUPON'] = $rsDiscountTable['USE_COUNT'];
    } else {
        $arResult['USE_COUNT_COUPON'] = 0;
    }

}



