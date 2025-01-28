<?php

namespace Classes;

use Local\Util\HighloadblockManager;

class DadataApi
{
    public static function getZipCityCode(string $cityName, string $userSelectedCityId) : string
    {
        if (!$cityName) {
            return '';
        }

        $checkInfoInBD = static::checkInfoInBD($cityName, $userSelectedCityId);

        if (!empty($checkInfoInBD)) {
            return $checkInfoInBD['UF_ZIP_CODE'];
        }

        $dadataIntegrationInfo = IblockDeliverySettings::getDadataIntegrationInfo();

        $dadata = new \Dadata\DadataClient($dadataIntegrationInfo['TOKEN'], $dadataIntegrationInfo['SECRET_KEY']);
        $resultDadata = $dadata->clean("address", $cityName);

        if (
            is_array($resultDadata) &&
            $resultDadata['postal_code']
        ) {
            static::addHlZipItem($cityName, $userSelectedCityId, $resultDadata['postal_code']);
            return $resultDadata['postal_code'];
        }

        return '';
    }

    private static function checkInfoInBD(string $cityName, string $userSelectedCityId) : array
    {
        if (
            !$cityName ||
            !$userSelectedCityId
        ) {
            return [];
        }

        $zipCodes = new HighloadblockManager('ZipCodes');

        $zipCodes->prepareParamsQuery(
            [
                'ID',
                'UF_ZIP_CODE'
            ],
            [],
            [
                'UF_CITY_NAME' => $cityName,
                'UF_CITY_ID' => $userSelectedCityId
            ]
        );

        $zip = $zipCodes->getData();

        if (
            empty($zip) ||
            !$zip['UF_ZIP_CODE']
        ) {
            return [];
        }

        return $zip;
    }

    private static function addHlZipItem(string $cityName, string $userSelectedCityId, string $zipCode) : void
    {
        $zipCodes = new HighloadblockManager('ZipCodes');

        $fields = [
            'UF_CITY_ID' => $userSelectedCityId,
            'UF_CITY_NAME' => $cityName,
            'UF_ZIP_CODE' => $zipCode
        ];

        $zipCodes->add($fields);
    }
}