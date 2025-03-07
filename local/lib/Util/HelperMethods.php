<?php

namespace Local\Util;

/**
 * Класс для мелких функий - помощников
 */
class HelperMethods
{
    /**
     * Функция по определению правильного окончания слова [яблоко, яблока, яблок]
     *
     * @param $n
     * @param $titles
     * @return mixed
     */
    public static function numberWords($n, $titles) : mixed
    {
        $cases = [2, 0, 1, 1, 1, 2];
        return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
    }
}