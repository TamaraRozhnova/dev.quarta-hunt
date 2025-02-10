<?php

namespace Classes;

use CModule;
use \Bitrix\Main\Application;
use CUser;
use \Ammina\Regions\BlockTable;
use \Bitrix\Catalog\ProductTable;
use CCatalogProduct;

class DeliverySettings
{
    public static function getDeliveryMethods(string $productId): array
    {
        if (!$productId) {
            return [];
        }

        $userSelectedCityId = static::getUserSelectedCity();

        if (!$userSelectedCityId) {
            return [];
        }

        $result = [];

        $productInfo = static::getProductInfo($productId);

        $sdekDelivery = SdekDelivery::getDelivery($userSelectedCityId, $productInfo);

        if ($sdekDelivery) {
            $result['SDEK_DELIVERY'] = $sdekDelivery;
        }

        $russianPostDelivery = RussianPostDelivery::getDelivery($userSelectedCityId, $productInfo);

        if ($russianPostDelivery) {
            $result['RUSSIAN_POST_DELIVERY'] = $russianPostDelivery;
        }

        $linkCityToStore = LinkCityToStore::getLinkCityToStore($userSelectedCityId, $productInfo);

        if (!empty($linkCityToStore)) {
            $result['USER_IN_SHOP_CITY'] = $linkCityToStore['USER_IN_SHOP_CITY'];
            $result['COURIER_DELIVERY'] = $linkCityToStore['COURIER_DELIVERY'];
        }

        if (!$result['COURIER_DELIVERY']) {
            $courierDelivery = IblockDeliverySettings::getCourierDeliveryDate();
            $result['COURIER_DELIVERY'] = 'и курьерской доставкой – ' . $courierDelivery . ' рабочих дня';
        }

        if ($result['USER_IN_SHOP_CITY']) {
            $userInShopValue = $result['USER_IN_SHOP_CITY'];
            unset($result['USER_IN_SHOP_CITY']);

            $result = ['USER_IN_SHOP_CITY' => $userInShopValue] + $result;
        }

        return $result;
    }

    public static function getUserSelectedCity(): string
    {
        if (!CModule::IncludeModule('ammina.regions')) {
            return '';
        }

        $request = Application::getInstance()->getContext()->getRequest();
        $cityId = intval($request->getCookie('ARG_CITY'));

        global $USER;

        if ($cityId > 0) {
            return (string)$cityId;
        } elseif ($USER->IsAuthorized()) {
            $rsUser = CUser::GetByID($USER->GetID());
            $arUser = $rsUser->Fetch();

            if ($arUser['UF_SELECTED_USER_CITY']) {
                return (string)$arUser['UF_SELECTED_USER_CITY'];
            }
        } else {
            $cityId = BlockTable::getCityIdByIP();

            if ($cityId > 0) {
                return (string)$cityId;
            }
        }

        return '';
    }

    private static function getProductInfo(string $productId): array
    {
        if (!$productId) {
            return [];
        }

        $productInfo = [];
        $product = ProductTable::getList([
            'filter' => [
                'ID' => $productId
            ]
        ]);

        if ($fetchProduct = $product->fetch()) {
            $productInfo = $fetchProduct;
        }

        $price = CCatalogProduct::GetOptimalPrice((int)$productId, 1);

        $defaultOptimalPrice = 0;

        if (is_array($price) && !empty($price) && $price['PRICE'] && $price['PRICE']['PRICE']) {
            $defaultOptimalPrice = $price['PRICE']['PRICE'];
        }

        $productInfo['PRICE'] = $defaultOptimalPrice;

        return $productInfo;
    }
}