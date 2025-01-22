<?php

namespace Classes\DeliverySettings;

use CModule;
use \Bitrix\Iblock\Elements\ElementBaseSettingsTable;

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

    public static function getSenderCityId() : string
    {
        if (!CModule::IncludeModule('iblock')) {
            return static::$defaultSenderCityId;
        }

        $settingElement = ElementBaseSettingsTable::getList([
            'select' => [
                'DEFAULT_SENDER_CITY'
            ],
            'filter' => [
                'ACTIVE' => 'Y'
            ]
        ])->fetchObject();

        if ($settingElement &&
            $settingElement->getDefaultSenderCity() &&
            $settingElement->getDefaultSenderCity()->getValue()) {
            return $settingElement->getDefaultSenderCity()->getValue();
        }

        return static::$defaultSenderCityId;
    }

    public static function getSdekIntegrationInfo() : array
    {
        if (!CModule::IncludeModule('iblock')) {
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
        ])->fetchObject();

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

    public static function getDadataIntegrationInfo() : array
    {
        if (!CModule::IncludeModule('iblock')) {
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
        ])->fetchObject();

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

    public static function getCourierDeliveryDate() : string
    {
        if (!CModule::IncludeModule('iblock')) {
            return static::$defaultCourierDeliveryDate;
        }

        $settingElement = ElementBaseSettingsTable::getList([
            'select' => [
                'COURIER_DELIVERY'
            ],
            'filter' => [
                'ACTIVE' => 'Y'
            ]
        ])->fetchObject();

        if ($settingElement &&
            $settingElement->getCourierDelivery() &&
            $settingElement->getCourierDelivery()->getValue()) {
            return $settingElement->getCourierDelivery()->getValue();
        }

        return static::$defaultCourierDeliveryDate;
    }

    public static function getStoreView() : array
    {
        if (!CModule::IncludeModule('iblock')) {
            return [];
        }

        $settingElement = ElementBaseSettingsTable::getList([
            'select' => [
                'STORE_VIEW_DEFAULT'
            ],
            'filter' => [
                'ACTIVE' => 'Y'
            ]
        ])->fetchObject();

        if ($settingElement &&
            $settingElement->getCourierDelivery() &&
            $settingElement->getCourierDelivery()->getAll()) {
            $storeIds = [];

            foreach ($settingElement->getCourierDelivery()->getAll() as $id) {
                $storeIds[] = $id->getValue();
            }

            return $storeIds;
        }

        return [];
    }
}