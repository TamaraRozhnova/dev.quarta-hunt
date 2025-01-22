<?php

namespace Classes\DeliverySettings;

use CModule;
use \Bitrix\Main\Application;
use CUser;
use \Ammina\Regions\BlockTable;

class DeliverySettings
{
    public static function getDeliveryMethods(string $productId) : array
    {
        if (!$productId) {
            return [];
        }

        $userSelectedCityId = static::getUserSelectedCity();

        if (!$userSelectedCityId) {
            return [];
        }

        $senderCity = IblockDeliverySettings::getSenderCityId();
    }

    private static function getUserSelectedCity() : string
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
}