<?php

namespace Classes;

use Bitrix\Main\Db\SqlQueryException;
use Bitrix\Main\Diag\Debug;
use DateTime;
use Local\Util\HighloadblockManager;
use Local\Util\HelperMethods;

/**
 * Класс по получению и форматированию информации
 * о времени доставки товара с помощью СДЭКа
 */
class SdekDelivery
{
    private static array $productInfo = [];
    private static string $userSelectedCityId = '';
    private static string $senderCity = '';

    /**
     * Собирающий и обрабатывающий итог метод
     *
     * @param string $userSelectedCityId
     * @param array $productInfo
     * @return string
     * @throws SqlQueryException
     */
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

    /**
     * Получение информации из HL блока
     *
     * @param string $productId
     * @param string $senderCity
     * @param string $reservedCity
     * @return array
     * @throws SqlQueryException
     */
    private static function getInfoFromBD(string $productId, string $senderCity, string $reservedCity) : array
    {
        $sdekDeliveryDates = new HighloadblockManager(QUARTA_HL_SDEK_DELIVERY_DATES_BLOCK_CODE);

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

    /**
     * Получение и обработка информации из api СДЭКа
     *
     * @return array
     * @throws \Bitrix\Main\Db\SqlQueryException
     */
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


    /**
     * Обновление информации в HL блоке
     * если записи не обновлялась больше недели
     *
     * @param string $id
     * @return void
     * @throws \Bitrix\Main\Db\SqlQueryException
     */
    private static function updateHlInfo(string $id) : void
    {
        if (!$id) {
            return;
        }

        $sdekInfo = SdekApi::getSdekApiDates(static::$senderCity, static::$userSelectedCityId);

        if (empty($sdekInfo)) {
            return;
        }

        $sdekDeliveryDates = new HighloadblockManager(QUARTA_HL_SDEK_DELIVERY_DATES_BLOCK_CODE);

        $fields = [
            'UF_LAST_UPDATE_DATE' => date('d.m.Y'),
            'UF_PRODUCT_ID' => static::$productInfo['ID'],
            'UF_SENDER_CITY_ID' => static::$senderCity,
            'UF_REVEIVER_CITY_ID' => static::$userSelectedCityId,
            'UF_DELIVERY_PERIOD_MAX' => $sdekInfo['deliveryPeriodMax'],
            'UF_DELIVERY_PERIOD_MIN' => $sdekInfo['deliveryPeriodMin']
        ];

        try {
            $sdekDeliveryDates->update($id, $fields);
        } catch (\Exception $error) {
            Debug::dumpToFile(var_export($error->getMessage(), true), 'ERROR MESSAGE ' . __FILE__, 'deliverySettings.log');
        }
    }

    /**
     * Добавление элемент в HL блок
     *
     * @param array $sdekInfo
     * @return void
     */
    private static function addHlItem(array $sdekInfo) : void
    {
        if (empty($sdekInfo)) {
            return;
        }

        $sdekDeliveryDates = new HighloadblockManager(QUARTA_HL_SDEK_DELIVERY_DATES_BLOCK_CODE);

        $fields = [
            'UF_LAST_UPDATE_DATE' => date('d.m.Y'),
            'UF_PRODUCT_ID' => static::$productInfo['ID'],
            'UF_SENDER_CITY_ID' => static::$senderCity,
            'UF_REVEIVER_CITY_ID' => static::$userSelectedCityId,
            'UF_DELIVERY_PERIOD_MAX' => $sdekInfo['deliveryPeriodMax'],
            'UF_DELIVERY_PERIOD_MIN' => $sdekInfo['deliveryPeriodMin']
        ];

        try {
            $sdekDeliveryDates->add($fields);
        } catch (\Exception $error) {
            Debug::dumpToFile(var_export($error->getMessage(), true), 'ERROR MESSAGE ' . __FILE__, 'deliverySettings.log');
        }
    }

    /**
     * Проверка даты обновления записи в HL блоке
     *
     * @param string $date
     * @return bool
     */
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