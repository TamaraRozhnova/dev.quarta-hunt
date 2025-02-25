<?php

namespace Classes;

use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use Bitrix\Main\LoaderException;
use CUser;
use \Ammina\Regions\BlockTable;
use \Bitrix\Catalog\ProductTable;
use CCatalogProduct;
use \Bitrix\Main\Engine\CurrentUser;

/**
 * Класс собирающий информацию о времени доставки
 * товара в город клиента
 */
class DeliverySettings
{
    /**
     * Получение информации о доставке
     *
     * @param string $productId
     * @return array
     * @throws \Bitrix\Main\Db\SqlQueryException
     */
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

    /**
     * Получение выбранного города пользователя
     *
     * @return string
     * @throws LoaderException
     */
    public static function getUserSelectedCity(): string
    {
        if (!Loader::includeModule('ammina.regions')) {
            throw new LoaderException('Не удалось подключить модуль ammina.');
        }

        $request = Application::getInstance()->getContext()->getRequest();
        $cityId = intval($request->getCookie('ARG_CITY'));

        if ($cityId > 0) {
            return (string)$cityId;
        } elseif (CurrentUser::get()->getId()) {
            $rsUser = CUser::GetByID(CurrentUser::get()->getId());
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

        // По умолчанию возвращать Питер
        return '2978';
    }

    /**
     * Получение полной информации о товаре
     *
     * @param string $productId
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
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