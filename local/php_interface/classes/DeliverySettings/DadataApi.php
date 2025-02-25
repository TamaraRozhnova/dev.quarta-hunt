<?php

namespace Classes;

use Bitrix\Main\Diag\Debug;
use Bitrix\Main\LoaderException;
use Local\Util\HighloadblockManager;
use Matrix\Exception;

/**
 * Класс по обращению к сервису Dadata
 */
class DadataApi
{
    /**
     * Функция по получению ZIP кода с помощью сервиса Dadata
     *
     * @param string $cityName
     * @param string $userSelectedCityId
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws LoaderException
     */
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

        try {
            $dadata = new \Dadata\DadataClient($dadataIntegrationInfo['TOKEN'], $dadataIntegrationInfo['SECRET_KEY']);
            $resultDadata = $dadata->clean("address", $cityName);

            if (
                is_array($resultDadata) &&
                $resultDadata['postal_code']
            ) {
                static::addHlZipItem($cityName, $userSelectedCityId, $resultDadata['postal_code']);
                return $resultDadata['postal_code'];
            }
        } catch (\Exception $error) {
            Debug::dumpToFile(var_export($error->getMessage(), true), 'ERROR MESSAGE ' . __FILE__, 'deliverySettings.log');
        }

        return '';
    }

    /**
     * Проверяем, есть ли запись с такими данными в HL блоке
     *
     * @param string $cityName
     * @param string $userSelectedCityId
     * @return array
     */
    private static function checkInfoInBD(string $cityName, string $userSelectedCityId) : array
    {
        if (
            !$cityName ||
            !$userSelectedCityId
        ) {
            return [];
        }

        $zipCodes = new HighloadblockManager(QUARTA_HL_DADATA_DELIVERY_DATES_BLOCK_CODE);

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

    /**
     * Добавление элемента в HL при запросе к сервису Dadata
     *
     * @param string $cityName
     * @param string $userSelectedCityId
     * @param string $zipCode
     * @return void
     */
    private static function addHlZipItem(string $cityName, string $userSelectedCityId, string $zipCode) : void
    {
        $zipCodes = new HighloadblockManager(QUARTA_HL_DADATA_DELIVERY_DATES_BLOCK_CODE);

        $fields = [
            'UF_CITY_ID' => $userSelectedCityId,
            'UF_CITY_NAME' => $cityName,
            'UF_ZIP_CODE' => $zipCode
        ];

        try {
            $zipCodes->add($fields);
        } catch (\Exception $error) {
            Debug::dumpToFile(var_export($error->getMessage(), true), 'ERROR MESSAGE ' . __FILE__, 'deliverySettings.log');
        }
    }
}