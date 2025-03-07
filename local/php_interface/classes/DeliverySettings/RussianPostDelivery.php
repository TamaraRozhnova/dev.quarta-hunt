<?php

namespace Classes;

use Ammina\Regions\BlockTable;
use Bitrix\Main\Diag\Debug;
use DateTime;
use GuzzleHttp\Exception\GuzzleException;
use Local\Util\HelperMethods;
use Local\Util\HighloadblockManager;

/**
 * Класс по получению и форматированию информации
 *  о времени доставки товара с помощью Почты России
 */
class RussianPostDelivery
{
    private static string $userSelectedCityId = '';
    private static array $productInfo = [];
    private static array $fullCityInfo = [];

    /**
     * Собирающий и обрабатывающий итог метод
     *
     * @param string $userSelectedCityId
     * @param array $productInfo
     * @return string
     * @throws GuzzleException
     */
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

    /**
     * Получение и обработка информации из api Почты России
     *
     * @return array
     * @throws GuzzleException
     */
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

    /**
     * Получение информации из HL блока
     *
     * @param string $productId
     * @param string $cityName
     * @param string $cityZip
     * @return array
     */
    private static function getInfoFromBD(string $productId, string $cityName, string $cityZip) : array
    {
        if (!$productId) {
            return [];
        }

        $russianPostDeliveryDates = new HighloadblockManager(QUARTA_HL_RUSSIAN_POST_DELIVERY_DATES_BLOCK_CODE);

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

    /**
     * Получение полной информации о адрессе пользователя
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
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

    /**
     * Обновление информации в HL блоке
     *  если записи не обновлялась больше недели
     *
     * @param string $id
     * @return void
     */
    private static function updateHlInfo(string $id) : void
    {
        if (!$id) {
            return;
        }

        $russianPostInfo = RussianPostApi::getRussianPostApiDates(static::$productInfo, static::$fullCityInfo);

        if (empty($russianPostInfo)) {
            return;
        }

        $russianPostDeliveryDates = new HighloadblockManager(QUARTA_HL_RUSSIAN_POST_DELIVERY_DATES_BLOCK_CODE);

        $fields = [
            'UF_LAST_UPDATE_DATE' => date('d.m.Y'),
            'UF_PRODUCT_ID' => static::$productInfo['ID'],
            'UF_CITY_NAME' => static::$fullCityInfo['NAME'],
            'UF_ZIP_CODE' => static::$fullCityInfo['ZIP'],
            'UF_DELIVERY_PERIOD_MAX' => $russianPostInfo['max_days'],
            'UF_DELIVERY_PERIOD_MIN' => $russianPostInfo['min_days']
        ];

        try {
            $russianPostDeliveryDates->update($id, $fields);
        } catch (\Exception $error) {
            Debug::dumpToFile(var_export($error->getMessage(), true), 'ERROR MESSAGE ' . __FILE__, 'deliverySettings.log');
        }
    }

    /**
     * Добавление элемент в HL блок
     *
     * @param array $russianPostInfo
     * @return void
     */
    private static function addHlItem(array $russianPostInfo) : void
    {
        if (empty($russianPostInfo)) {
            return;
        }

        $russianPostDeliveryDates = new HighloadblockManager(QUARTA_HL_RUSSIAN_POST_DELIVERY_DATES_BLOCK_CODE);

        $fields = [
            'UF_LAST_UPDATE_DATE' => date('d.m.Y'),
            'UF_PRODUCT_ID' => static::$productInfo['ID'],
            'UF_CITY_NAME' => static::$fullCityInfo['NAME'],
            'UF_ZIP_CODE' => static::$fullCityInfo['ZIP'],
            'UF_DELIVERY_PERIOD_MAX' => $russianPostInfo['max_days'],
            'UF_DELIVERY_PERIOD_MIN' => $russianPostInfo['min_days']
        ];

        try {
            $russianPostDeliveryDates->add($fields);
        } catch (\Exception $error) {
            Debug::dumpToFile(var_export($error->getMessage(), true), 'ERROR MESSAGE ' . __FILE__, 'deliverySettings.log');
        }
    }
}