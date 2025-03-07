<?php

namespace Classes;

use RussianPostApi\Request;

/**
 * Класс по обращению к api Почты России
 */
class RussianPostApi
{
    private static array $defaultProductInfo = [
        'WEIGHT' => 200,
        'PRICE' => 5000
    ];

    /**
     * Функция по получению данных с помощью api Почты России
     *
     * @param array $productInfo
     * @param array $cityInfo
     * @return array
     */
    public static function getRussianPostApiDates(array $productInfo, array $cityInfo) : array
    {
        if (
            empty($productInfo) ||
            empty($cityInfo) ||
            !$cityInfo['NAME'] ||
            !$cityInfo['ZIP']
        ) {
            return [];
        }

        $russianPostRequest = new Request();

        $params = [
            'ZIP' => $cityInfo['ZIP'],
            'WEIGHT' => $productInfo['WEIGHT'] ?: static::$defaultProductInfo['WEIGHT'],
            'ADDRESS' => $cityInfo['NAME'],
            'PRICE' => $productInfo['PRICE'] ?: static::$defaultProductInfo['PRICE']
        ];

        $res = $russianPostRequest->PickUpCalculateSimple($params);

        if (
            is_array($res) &&
            $res[0]['delivery_interval']
        ) {
            return $res[0]['delivery_interval'];
        }

        return [];
    }
}