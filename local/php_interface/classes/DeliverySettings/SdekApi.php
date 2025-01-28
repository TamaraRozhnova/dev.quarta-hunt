<?php

namespace Classes;

use Sdek\CalculatePriceDeliverySdek;
use \Ammina\Regions\BlockTable;

class SdekApi
{
    private static int $sdekTariffId = 136;
    private static array $sdekServices = [['id' => '2', 'param' => '1000']];
    private static array $defaultProductInfo = [
        'WEIGHT' => 1,
        'LENGTH' => 20,
        'WIDTH' => 30,
        'HEIGHT' => 40
    ];

    public static function getSdekApiDates(string $senderCity, string $userSelectedCityId) : array
    {
        $sdekAuth = IblockDeliverySettings::getSdekIntegrationInfo();

        if (
            empty($sdekAuth) ||
            !$sdekAuth['LOGIN'] ||
            !$sdekAuth['PASSWORD'] ||
            !$userSelectedCityId
        ) {
            return [];
        }

        $senderCity = static::getSdekCityIdFromBitrixId($senderCity);
        $userSelectedCityId = static::getSdekCityIdFromBitrixId($userSelectedCityId);

        $sdek = new CalculatePriceDeliverySdek();

        $sdek->setAuth($sdekAuth['LOGIN'], $sdekAuth['PASSWORD']);
        $sdek->setSenderCityId((int)$senderCity);
        $sdek->setReceiverCityId((int)$userSelectedCityId);
        $sdek->setTariffId(static::$sdekTariffId);
        $sdek->addGoodsItemBySize(static::$defaultProductInfo['WEIGHT'], static::$defaultProductInfo['LENGTH'], static::$defaultProductInfo['WIDTH'], static::$defaultProductInfo['HEIGHT']);
        $sdek->setServices(static::$sdekServices);

        $result['sdek'] = $sdek->calculate();
        $result['error'] = $sdek->getError();
        $result['result'] = $sdek->getResult();

        if (
            !$result['result'] ||
            $result['result']['error'] ||
            !$result['result']['result']
        ) {
            return [];
        }

        return $result['result']['result'];
    }

    public static function getSdekCityIdFromBitrixId(string $amminaId) : string
    {
        if (!$amminaId) {
            return '';
        }

        $bitrixId = static::getBitrixCityIdFromAmminaId($amminaId);

        if ($bitrixId) {
            global $DB;
            $sdekId = '';
            $result = $DB->Query("SELECT * FROM `ipol_sdekcities` WHERE BITRIX_ID = " . $bitrixId);

            while($row = $result->Fetch()) {
                $sdekId = $row['SDEK_ID'];
            }

            return $sdekId;
        }

        return '';
    }

    public static function getBitrixCityIdFromAmminaId(string $amminaId) : string
    {
        if (!$amminaId) {
            return '';
        }

        $fullInfo = BlockTable::getCityFullInfoByID($amminaId);

        if (
            is_array($fullInfo) &&
            is_array($fullInfo['CITY']) &&
            $fullInfo['CITY']['LOCATION_ID']
        ) {
            return $fullInfo['CITY']['LOCATION_ID'];
        }

        return '';
    }
}