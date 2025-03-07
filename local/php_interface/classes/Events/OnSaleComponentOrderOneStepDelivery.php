<?php

namespace CustomEvents;

use Bitrix\Main\Diag\Debug;
use \Classes\LinkCityToStore;
use \Classes\DeliverySettings;

/**
 * Класс обработчик события OnSaleComponentOrderOneStepDelivery
 */
class OnSaleComponentOrderOneStepDelivery
{
    /**
     * Функция убирающая лишние варианты доставки,
     * если выбран самовывоз
     *
     * @param $arResult
     * @param $arUserResult
     * @param $arParams
     * @return void
     * @throws \Bitrix\Main\LoaderException
     */
    public static function removeDeliveriesMethods(&$arResult, $arUserResult, $arParams) : void
    {
        $selectedUserCity = DeliverySettings::getUserSelectedCity();

        if ($selectedUserCity) {
            $settingElement = LinkCityToStore::getIblockLinkElement($selectedUserCity);

            if (
                !empty($settingElement) &&
                is_array($settingElement['DELIVERIES']) &&
                !empty($settingElement['DELIVERIES']) &&
                $arResult['DELIVERY'] &&
                is_array($_SESSION['PRODUCTS_IN_ORDER']) &&
                !empty($_SESSION['PRODUCTS_IN_ORDER']) &&
                in_array($_SESSION['PRODUCTS_IN_ORDER'][0]['STORE_ID'][0], $settingElement['STORE_ID'])
            ) {
                foreach ($arResult['DELIVERY'] as $key => $delivery) {
                    if (!in_array($delivery['ID'], $settingElement['DELIVERIES'])) {
                        unset($arResult['DELIVERY'][$key]);
                    }
                }
            }
        }
    }
}