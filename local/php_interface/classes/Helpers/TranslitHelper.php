<?php

namespace Helpers;

/**
 * Класс по работе с транслитом.
 */

class Translit
{
    private static $rusLetters = [
        "a" => "ф",
        "b" => "и",
        "c" => "с",
        "d" => "в",
        "e" => "у",
        "f" => "а",
        "g" => "п",
        "h" => "р",
        "i" => "ш",
        "j" => "о",
        "k" => "л",
        "l" => "д",
        "m" => "ь",
        "n" => "т",
        "o" => "о",
        "p" => "з",
        "q" => "й",
        "r" => "к",
        "s" => "ы",
        "t" => "е",
        "u" => "г",
        "v" => "м",
        "w" => "ц",
        "x" => "ч",
        "y" => "н",
        "z" => "я",
    ];

    private static $engLetters = [
        "а" => "f",
        "б" => ",",
        "в" => "d",
        "г" => "u",
        "д" => "l",
        "е" => "t",
        "ё" => "`",
        "ж" => ";",
        "з" => "p",
        "и" => "b",
        "к" => "r",
        "л" => "k",
        "м" => "v",
        "н" => "y",
        "о" => "j",
        "п" => "g",
        "р" => "h",
        "с" => "c",
        "т" => "n",
        "у" => "e",
        "ф" => "a",
        "х" => "[",
        "ц" => "w",
        "ч" => "x",
        "ш" => "i",
        "щ" => "o",
        "ъ" => "]",
        "ы" => "s",
        "ь" => "m",
        "э" => "'",
        "ю" => ".",
        "я" => "z",
    ];

    public static function getRuChars()
    {
        return self::$rusLetters;
    }

    public static function getEngChars()
    {
        return self::$engLetters;
    }
    

    public static function getTranslitRU($str)
    {
        return strtr($str, self::getRuChars());
    }

    public static function getTranslitEN($str)
    {
        return strtr($str, self::getEngChars());
    }
}