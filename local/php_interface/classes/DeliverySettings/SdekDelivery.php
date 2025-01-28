<?php

namespace Classes;

use DateTime;
use Local\Util\HighloadblockManager;
use Local\Util\HelperMethods;

class SdekDelivery
{
    private static array $productInfo = [];
    private static string $userSelectedCityId = '';
    private static string $senderCity = '';

    public static function getDelivery(string $userSelectedCityId, array $productInfo) : string
    {
        static::$productInfo = $productInfo;
        static::$userSelectedCityId = $userSelectedCityId;

        $senderCity = IblockDeliverySettings::getSenderCityId();
        static::$senderCity = $senderCity;

        $info = static::getSdekApiInfo();

        if (!empty($info)) {
            $days = $info['MIN'] == $info['MAX'] ? $info['MIN'] . ' ' . HelperMethods::numberWords($info['MIN'], ['рабочий', 'рабочих', 'рабочих']) . ' ' . HelperMethods::numberWords($info['MIN'], ['день', 'дня', 'дней']) : $info['MIN'] . ' - ' . $info['MAX'] . ' рабочих ' . HelperMethods::numberWords($info['MAX'], ['день', 'дня', 'дней']);

            return 'в ПВЗ и постаматах СДЭК - ' . $days;
        }

        return '';
    }

    private static function getInfoFromBD(string $productId, string $senderCity, string $reservedCity) : array
    {
        $sdekDeliveryDates = new HighloadblockManager('SdekDeliveryDates');

        $sdekDeliveryDates->prepareParamsQuery(
            [
                'ID',
                'UF_DELIVERY_PERIOD_MAX',
                'UF_DELIVERY_PERIOD_MIN',
                'UF_LAST_UPDATE_DATE'
            ],
            [],
            [
                'UF_PRODUCT_ID' => $productId,
                'UF_SENDER_CITY_ID' => $senderCity,
                'UF_REVEIVER_CITY_ID' => $reservedCity
            ]
        );

        $dates = $sdekDeliveryDates->getData();

        if (
            empty($dates) ||
            !$dates['UF_DELIVERY_PERIOD_MAX'] ||
            !$dates['UF_DELIVERY_PERIOD_MIN']
        ) {
            return [];
        }

        if (static::checkLastUpdateDate($dates['UF_LAST_UPDATE_DATE'])) {
            static::updateHlInfo($dates['ID']);
        }

        return $sdekDeliveryDates->getData();
    }

    private static function getSdekApiInfo() : array
    {
        if (
            empty(static::$productInfo) ||
            !static::$userSelectedCityId ||
            !static::$senderCity
        ) {
            return [];
        }

        $result = [];

        $infoFromBd = static::getInfoFromBD(static::$productInfo['ID'], static::$senderCity, static::$userSelectedCityId);

        if (empty($infoFromBd)) {
            $infoFromBd = SdekApi::getSdekApiDates(static::$senderCity, static::$userSelectedCityId);
            static::addHlItem($infoFromBd);

            if ($infoFromBd['deliveryPeriodMin'] && $infoFromBd['deliveryPeriodMax']) {
                $result = [
                    'MIN' => $infoFromBd['deliveryPeriodMin'],
                    'MAX' => $infoFromBd['deliveryPeriodMax']
                ];
            }
        }

        if ($infoFromBd['UF_DELIVERY_PERIOD_MAX'] && $infoFromBd['UF_DELIVERY_PERIOD_MIN']) {
            $result = [
                'MIN' => $infoFromBd['UF_DELIVERY_PERIOD_MIN'],
                'MAX' => $infoFromBd['UF_DELIVERY_PERIOD_MAX']
            ];
        }

        return $result;
    }

    private static function updateHlInfo(string $id) : void
    {
        if (!$id) {
            return;
        }

        $sdekInfo = SdekApi::getSdekApiDates(static::$senderCity, static::$userSelectedCityId);

        if (empty($sdekInfo)) {
            return;
        }

        $sdekDeliveryDates = new HighloadblockManager('SdekDeliveryDates');

        $fields = [
            'UF_LAST_UPDATE_DATE' => date('d.m.Y'),
            'UF_PRODUCT_ID' => static::$productInfo['ID'],
            'UF_SENDER_CITY_ID' => static::$senderCity,
            'UF_REVEIVER_CITY_ID' => static::$userSelectedCityId,
            'UF_DELIVERY_PERIOD_MAX' => $sdekInfo['deliveryPeriodMax'],
            'UF_DELIVERY_PERIOD_MIN' => $sdekInfo['deliveryPeriodMin']
        ];

        $sdekDeliveryDates->update($id, $fields);
    }

    private static function addHlItem(array $sdekInfo) : void
    {
        if (empty($sdekInfo)) {
            return;
        }

        $sdekDeliveryDates = new HighloadblockManager('SdekDeliveryDates');

        $fields = [
            'UF_LAST_UPDATE_DATE' => date('d.m.Y'),
            'UF_PRODUCT_ID' => static::$productInfo['ID'],
            'UF_SENDER_CITY_ID' => static::$senderCity,
            'UF_REVEIVER_CITY_ID' => static::$userSelectedCityId,
            'UF_DELIVERY_PERIOD_MAX' => $sdekInfo['deliveryPeriodMax'],
            'UF_DELIVERY_PERIOD_MIN' => $sdekInfo['deliveryPeriodMin']
        ];

        $sdekDeliveryDates->add($fields);
    }

    private static function checkLastUpdateDate(string $date) : bool
    {
        if (!$date) {
            return false;
        }

        $dateObject = DateTime::createFromFormat('d.m.Y', $date);
        $currentDate = new DateTime();
        $interval = $currentDate->diff($dateObject);

        if ($interval->days > 7) {
            return true;
        }

        return false;
    }
}