<?php

namespace Classes;

use CModule;
use \Bitrix\Iblock\Elements\ElementLinkCityToStoreTable;
use \Bitrix\Catalog\StoreProductTable;
use Local\Util\IblockHelper;
use CIBlockElement;

class LinkCityToStore
{
    private static string $availableProductText = '1 рабочий день';
    private static string $unavailableProductText = 'доставка товара в точку выдачи может занять до 4х дней, если он приедет раньше - мы уведомим Вас';
    private static string $defaultStoreName = 'Оружейный квартал';
    private static string $defaultCourierDeliveryInCityShop = '1 - 2';

    public static function getLinkCityToStore(string $selectedUserCity, array $productInfo) : array
    {
        $result = [];

        if (!$selectedUserCity || empty($productInfo)) {
            return $result;
        }

        $linkElement = static::getIblockLinkElement($selectedUserCity);

        if (empty($linkElement)) {
            return $result;
        }

        $haveProductInStore = static::haveProductInStore($productInfo, $linkElement);
        $storeName = $linkElement['STORE_NAME'] ?: static::$defaultStoreName;

        if ($haveProductInStore) {
            $result['USER_IN_SHOP_CITY'] = 'в магазинах «' . $storeName . '» - ' . static::$availableProductText;
        } else {
            $result['USER_IN_SHOP_CITY'] = 'в магазинах «' . $storeName . '» - ' . static::$unavailableProductText;
        }

        $courierDelivery = $linkElement['COURIER_DELIVERY'] ?: static::$defaultCourierDeliveryInCityShop;
        $result['COURIER_DELIVERY'] = 'и курьерской доставкой – ' . $courierDelivery . ' рабочих дня';

        return $result;
    }

    public static function getIblockLinkElement(string $selectedUserCity) : array
    {
        if (!CModule::IncludeModule('iblock') || !$selectedUserCity) {
            return [];
        }

        $element = ElementLinkCityToStoreTable::getList([
            'order' => [
                'ID' => 'DESC'
            ],
            'select' => [
                'ID',
                'STORE_NAME',
                'CITY',
                'COURIER_DELIVERY'
            ],
            'filter' => [
                'ACTIVE' => 'Y',
                'CITY.VALUE' => $selectedUserCity
            ],
            'limit' => 1
        ])->fetchObject();

        if (!$element) {
            return [];
        }

        $elementInfo = [];

        $iblockLinkId = IblockHelper::getIdByCode('linkCityToStore');

        if ($element->getId()) {
            $elementInfo['ID'] = $element->getId();
        }

        if ($element->getStoreName() && $element->getStoreName()->getValue()) {
            $elementInfo['STORE_NAME'] = $element->getStoreName()->getValue();
        }

        if ($element->getCity() && $element->getCity()->getValue()) {
            $elementInfo['CITY'] = $element->getCity()->getValue();
        }

        if ($element->getCourierDelivery() && $element->getCourierDelivery()->getValue()) {
            $elementInfo['COURIER_DELIVERY'] = $element->getCourierDelivery()->getValue();
        }

        if ($elementInfo['ID'] && $iblockLinkId) {
            $dbPropsStoreId = CIBlockElement::GetProperty($iblockLinkId, $elementInfo['ID'], [], ['CODE' => 'STORE_ID']);

            if ($dbPropsStoreId && is_array($dbPropsStoreId->arResult)) {
                foreach ($dbPropsStoreId->arResult as $storeId) {
                    $elementInfo['STORE_ID'][] = $storeId['VALUE'];
                }
            }

            $dbPropsStoreView = CIBlockElement::GetProperty($iblockLinkId, $elementInfo['ID'], [], ['CODE' => 'STORE_VIEW']);

            if ($dbPropsStoreView && is_array($dbPropsStoreView->arResult)) {
                foreach ($dbPropsStoreView->arResult as $storeId) {
                    $elementInfo['STORE_VIEW'][] = $storeId['VALUE'];
                }
            }

            $dbDeliveries = CIBlockElement::GetProperty($iblockLinkId, $elementInfo['ID'], [], ['CODE' => 'DELIVERY_LIST']);

            if ($dbDeliveries && is_array($dbDeliveries->arResult)) {
                foreach ($dbDeliveries->arResult as $deliveryId) {
                    $elementInfo['DELIVERIES'][] = $deliveryId['VALUE'];
                }
            }
        }

        return $elementInfo;
    }

    private static function haveProductInStore(array $productInfo, array $linkElement) : bool
    {
        if (empty($productInfo) || empty($linkElement) || !$linkElement['STORE_ID']) {
            return false;
        }

        foreach ($linkElement['STORE_ID'] as $item) {
            $storeInfo = StoreProductTable::getList([
                'filter' => [
                    'PRODUCT_ID' => $productInfo['ID'],
                    'STORE_ID' => $item
                ],
                'select' => [
                    'AMOUNT'
                ]
            ])->fetch();

            if (
                $storeInfo &&
                $storeInfo['AMOUNT'] &&
                $storeInfo['AMOUNT'] > 0
            ) {
                return true;
            }
        }

        return false;
    }
}