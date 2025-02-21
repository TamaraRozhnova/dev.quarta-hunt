<?php

namespace Classes;

use \Bitrix\Main\Loader;
use \Bitrix\Iblock\Elements\ElementBaseSettingsTable;
use Bitrix\Main\LoaderException;
use Local\Util\IblockHelper;
use CIBlockElement;

/**
 * Класс по получению настроек из ИБ
 */
class IblockDeliverySettings
{
    private static string $defaultSenderCityId = '2978';

    private static array $defaultSdekAccess = [
        'LOGIN' => 'XOlAxGCIfVdenTUIIjS4rHfjup5tviyx',
        'PASSWORD' => 'ATttW2E6ACWWyXd75R1L6nL52eKP2UIV'
    ];

    private static array $defaultDadataAccess = [
        'TOKEN' => '554dae973e9d3b7007a9d787bc1e8744432f9bfc',
        'SECRET_KEY' => '57f6f72d10837c78b8ade0e60ecbed2be3503cb5'
    ];

    private static string $defaultCourierDeliveryDate = '2 - 3';

    /**
     * Получение города - отправителя (для СДЭКа нужен)
     *
     * @return string
     * @throws LoaderException
     */
    public static function getSenderCityId() : string
    {
        if (!Loader::IncludeModule('iblock')) {
            return static::$defaultSenderCityId;
        }

        $settingElement = ElementBaseSettingsTable::getList([
            'select' => [
                'DEFAULT_SENDER_CITY'
            ],
            'filter' => [
                'ACTIVE' => 'Y'
            ]
        ])?->fetchObject();

        if ($settingElement &&
            $settingElement->getDefaultSenderCity() &&
            $settingElement->getDefaultSenderCity()->getValue()) {
            return $settingElement->getDefaultSenderCity()->getValue();
        }

        return static::$defaultSenderCityId;
    }

    /**
     * Получение данный для интеграции с СДЭКом
     *
     * @return array|string[]
     * @throws LoaderException
     */
    public static function getSdekIntegrationInfo() : array
    {
        if (!Loader::IncludeModule('iblock')) {
            return static::$defaultSdekAccess;
        }

        $settingElement = ElementBaseSettingsTable::getList([
            'select' => [
                'SDEK_LOGIN',
                'SDEK_PASSWORD'
            ],
            'filter' => [
                'ACTIVE' => 'Y'
            ]
        ])?->fetchObject();

        if (
            $settingElement &&
            $settingElement->getSdekLogin() &&
            $settingElement->getSdekLogin()->getValue() &&
            $settingElement->getSdekPassword() &&
            $settingElement->getSdekPassword()->getValue()
        ) {
            return [
                'LOGIN' => $settingElement->getSdekLogin()->getValue(),
                'PASSWORD' => $settingElement->getSdekPassword()->getValue()
            ];
        }

        return static::$defaultSdekAccess;
    }

    /**
     * Получение данный для интеграции с Dadata
     *
     * @return array|string[]
     * @throws LoaderException
     */
    public static function getDadataIntegrationInfo() : array
    {
        if (!Loader::IncludeModule('iblock')) {
            return static::$defaultDadataAccess;
        }

        $settingElement = ElementBaseSettingsTable::getList([
            'select' => [
                'DADATA_TOKEN',
                'DADATA_SECRET_KEY'
            ],
            'filter' => [
                'ACTIVE' => 'Y'
            ]
        ])?->fetchObject();

        if (
            $settingElement &&
            $settingElement->getDadataToken() &&
            $settingElement->getDadataToken()->getValue() &&
            $settingElement->getDadataSecretKey() &&
            $settingElement->getDadataSecretKey()->getValue()
        ) {
            return [
                'TOKEN' => $settingElement->getDadataToken()->getValue(),
                'SECRET_KEY' => $settingElement->getDadataSecretKey()->getValue()
            ];
        }

        return static::$defaultDadataAccess;
    }

    /**
     * Получение стандартной информации о времени курьерской доставки
     *
     * @return string
     * @throws LoaderException
     */
    public static function getCourierDeliveryDate() : string
    {
        if (!Loader::IncludeModule('iblock')) {
            return static::$defaultCourierDeliveryDate;
        }

        $settingElement = ElementBaseSettingsTable::getList([
            'select' => [
                'COURIER_DELIVERY'
            ],
            'filter' => [
                'ACTIVE' => 'Y'
            ]
        ])?->fetchObject();

        if ($settingElement &&
            $settingElement->getCourierDelivery() &&
            $settingElement->getCourierDelivery()->getValue()) {
            return $settingElement->getCourierDelivery()->getValue();
        }

        return static::$defaultCourierDeliveryDate;
    }

    /**
     * Полчение, какие склады отображать пользователю стандартно
     *
     * @return array
     * @throws LoaderException
     */
    public static function getStoreDefaultView() : array
    {
        if (!Loader::IncludeModule('iblock')) {
            return [];
        }

        $settingElement = ElementBaseSettingsTable::getList([
            'select' => [
                'ID'
            ],
            'filter' => [
                'ACTIVE' => 'Y'
            ]
        ])?->fetchObject();

        if ($settingElement &&
            $settingElement->getId()) {

            $iblockBaseSettingsId = IblockHelper::getIdByCode('baseSettings');

            if ($iblockBaseSettingsId) {
                $storeIds = [];

                $dbPropsStoreId = CIBlockElement::GetProperty($iblockBaseSettingsId, $settingElement->getId(), [], ['CODE' => 'STORE_VIEW_DEFAULT']);

                if ($dbPropsStoreId && is_array($dbPropsStoreId->arResult)) {
                    foreach ($dbPropsStoreId->arResult as $storeId) {
                        $storeIds[] = $storeId['VALUE'];
                    }
                }

                return $storeIds;
            }
        }

        return [];
    }
}