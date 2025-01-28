<?php

namespace Classes;

use Ammina\Regions\BlockTable;
use DateTime;
use Local\Util\HelperMethods;
use Local\Util\HighloadblockManager;

class RussianPostDelivery
{
    private static string $userSelectedCityId = '';
    private static array $productInfo = [];
    private static array $fullCityInfo = [];

    public static function getDelivery(string $userSelectedCityId, array $productInfo) : string
    {
        if (
            empty($productInfo) ||
            !$userSelectedCityId
        ) {
            return '';
        }

        static::$productInfo = $productInfo;
        static::$userSelectedCityId = $userSelectedCityId;

        $info = static::getRussianPostApiInfo();

        if (!empty($info)) {
            $days = $info['MIN'] == $info['MAX'] ? $info['MIN'] . ' ' . HelperMethods::numberWords($info['MIN'], ['рабочий', 'рабочих', 'рабочих']) . ' ' . HelperMethods::numberWords($info['MIN'], ['день', 'дня', 'дней']) : $info['MIN'] . ' - ' . $info['MAX'] . ' рабочих ' . HelperMethods::numberWords($info['MAX'], ['день', 'дня', 'дней']);

            return 'пунктах выдачи Почты России - ' . $days;
        }

        return '';
    }

    private static function getRussianPostApiInfo() : array
    {
        $result = [];

        $fullCityInfo = static::getFullAddressInfo();

        if (
            !$fullCityInfo['NAME'] ||
            !$fullCityInfo['ZIP']
        ) {
            return $result;
        }

        static::$fullCityInfo = [
            'NAME' => $fullCityInfo['NAME'],
            'ZIP' => $fullCityInfo['ZIP']
        ];

        $infoFromBd = static::getInfoFromBD(static::$productInfo['ID'], static::$fullCityInfo['NAME'], static::$fullCityInfo['ZIP']);

        if (empty($infoFromBd)) {
            $infoFromBd = RussianPostApi::getRussianPostApiDates(static::$productInfo, static::$fullCityInfo);
            static::addHlItem($infoFromBd);

            if ($infoFromBd['min_days'] && $infoFromBd['max_days']) {
                $result = [
                    'MIN' => $infoFromBd['min_days'],
                    'MAX' => $infoFromBd['max_days']
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

    private static function getInfoFromBD(string $productId, string $cityName, string $cityZip) : array
    {
        if (!$productId) {
            return [];
        }

        $russianPostDeliveryDates = new HighloadblockManager('RussianPostDeliveryDates');

        $russianPostDeliveryDates->prepareParamsQuery(
            [
                'ID',
                'UF_DELIVERY_PERIOD_MAX',
                'UF_DELIVERY_PERIOD_MIN',
                'UF_LAST_UPDATE_DATE'
            ],
            [],
            [
                'UF_PRODUCT_ID' => $productId,
                'UF_CITY_NAME' => $cityName,
                'UF_ZIP_CODE' => $cityZip
            ]
        );

        $dates = $russianPostDeliveryDates->getData();

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

        return $russianPostDeliveryDates->getData();
    }

    private static function getFullAddressInfo() : array
    {
        $cityInfo = [];

        $fullCityInfo = BlockTable::getCityFullInfoByID(static::$userSelectedCityId);

        if (
            is_array($fullCityInfo) &&
            is_array($fullCityInfo['CITY']) &&
            $fullCityInfo['CITY']['NAME']
        ) {
            $cityInfo['NAME'] = $fullCityInfo['CITY']['NAME'];
            $cityInfo['ZIP'] = DadataApi::getZipCityCode($cityInfo['NAME'], static::$userSelectedCityId);
        }

        return $cityInfo;
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

    private static function updateHlInfo(string $id) : void
    {
        if (!$id) {
            return;
        }

        $russianPostInfo = RussianPostApi::getRussianPostApiDates(static::$productInfo, static::$fullCityInfo);

        if (empty($russianPostInfo)) {
            return;
        }

        $russianPostDeliveryDates = new HighloadblockManager('RussianPostDeliveryDates');

        $fields = [
            'UF_LAST_UPDATE_DATE' => date('d.m.Y'),
            'UF_PRODUCT_ID' => static::$productInfo['ID'],
            'UF_CITY_NAME' => static::$fullCityInfo['NAME'],
            'UF_ZIP_CODE' => static::$fullCityInfo['ZIP'],
            'UF_DELIVERY_PERIOD_MAX' => $russianPostInfo['max_days'],
            'UF_DELIVERY_PERIOD_MIN' => $russianPostInfo['min_days']
        ];

        $russianPostDeliveryDates->update($id, $fields);
    }

    private static function addHlItem(array $russianPostInfo) : void
    {
        if (empty($russianPostInfo)) {
            return;
        }

        $russianPostDeliveryDates = new HighloadblockManager('RussianPostDeliveryDates');

        $fields = [
            'UF_LAST_UPDATE_DATE' => date('d.m.Y'),
            'UF_PRODUCT_ID' => static::$productInfo['ID'],
            'UF_CITY_NAME' => static::$fullCityInfo['NAME'],
            'UF_ZIP_CODE' => static::$fullCityInfo['ZIP'],
            'UF_DELIVERY_PERIOD_MAX' => $russianPostInfo['max_days'],
            'UF_DELIVERY_PERIOD_MIN' => $russianPostInfo['min_days']
        ];

        $russianPostDeliveryDates->add($fields);
    }
}