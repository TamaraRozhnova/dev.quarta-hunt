<?php

namespace Helpers;

/**
 * Класс для работы с транслитерацией.
 */
class Translit
{
    /**
     * @var array Русские буквы для замены с неправильной раскладки.
     */
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

    /**
     * @var array Английские буквы для замены с неправильной раскладки.
     */
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

    /**
     * @var array Массив с буквами для транслитерации первой версии
     */
    private static $rusLettersChangeSimple = [
        "а" => "a",
        "б" => "b",
        "с" => "s",
        "д" => "d",
        "е" => "e",
        "ф" => "f",
        "г" => "g",
        "х" => "h",
        "и" => "i",
        "ж" => "j",
        "к" => "c",
        "л" => "l",
        "м" => "m",
        "н" => "n",
        "о" => "o",
        "п" => "p",
        "р" => "r",
        "с" => "s",
        "т" => "t",
        "у" => "u",
        "в" => "v",
        "в" => "w",
        "х" => "x",
        "ю" => "y",
        "з" => "z",
    ];

    /**
     * @var array Массив с буквами для транслитерации расширенной версии
     */
    private static $rusLettersChangeAdvanced = [
        "а" => "a",
        "б" => "b",
        "в" => "v",
        "г" => "g",
        "д" => "d",
        "е" => "e",
        "ё" => "yo",
        "ж" => "zh",
        "з" => "z",
        "и" => "i",
        "й" => "y",
        "к" => "k",
        "л" => "l",
        "м" => "m",
        "н" => "n",
        "о" => "o",
        "п" => "p",
        "р" => "r",
        "с" => "s",
        "т" => "t",
        "у" => "u",
        "ф" => "f",
        "х" => "kh",
        "ц" => "ts",
        "ч" => "ch",
        "ш" => "sh",
        "щ" => "sch",
        "ъ" => "",
        "ы" => "y",
        "ь" => "",
        "э" => "e",
        "ю" => "yu",
        "я" => "ya",
    ];

    /**
     * @var array Массив с буквами для транслитерации большей расширенной версии
     */
    private static $rusLettersChangeExtended = [
        "а" => "a",
        "б" => "b",
        "в" => "v",
        "г" => "g",
        "д" => "d",
        "е" => "e",
        "ё" => "yo",
        "ж" => "zh",
        "з" => "z",
        "и" => "i",
        "й" => "y",
        "к" => "k",
        "л" => "l",
        "м" => "m",
        "н" => "n",
        "о" => "o",
        "п" => "p",
        "р" => "r",
        "с" => "s",
        "т" => "t",
        "у" => "u",
        "ф" => "f",
        "х" => "ch",
        "ц" => "ts",
        "ч" => "ch",
        "ш" => "sh",
        "щ" => "sch",
        "ъ" => "",
        "ы" => "y",
        "ь" => "",
        "э" => "e",
        "ю" => "yu",
        "я" => "ya",
    ];

    /**
     * Получить массив русских букв для замены с неправильной раскладки.
     *
     * @return array
     */
    public static function getRuChars(): array
    {
        return self::$rusLetters;
    }

    /**
     * Получить массив русских букв для простой транслитерации.
     *
     * @return array
     */
    public static function getRuCharsChangeSimple(): array
    {
        return self::$rusLettersChangeSimple;
    }

    /**
     * Получить массив русских букв для расширенной транслитерации.
     *
     * @return array
     */
    public static function getRuCharsChangeAdvanced(): array
    {
        return self::$rusLettersChangeAdvanced;
    }

    /**
     * Получить массив русских букв для большей расширенной транслитерации.
     *
     * @return array
     */
    public static function getRuCharsChangeExtended(): array
    {
        return self::$rusLettersChangeExtended;
    }

    /**
     * Получить массив английских букв для замены с неправильной раскладки.
     *
     * @return array
     */
    public static function getEngChars(): array
    {
        return self::$engLetters;
    }

    /**
     * Транслитерировать строку из русского в английский с использованием массива русских букв для замены.
     *
     * @param string $str
     * @return string
     */
    public static function getTranslitRU(string $str): string
    {
        return strtr($str, self::getRuChars());
    }

    /**
     * Транслитерировать строку из английского в русский с использованием массива английских букв для замены.
     *
     * @param string $str
     * @return string
     */
    public static function getTranslitEN(string $str): string
    {
        return strtr($str, self::getEngChars());
    }

    /**
     * Транслитерировать строку из русского в английский с использованием массива русских букв для простой транслитерации.
     *
     * @param string $str
     * @return string
     */
    public static function getChangeSimpleWordRU(string $str): string
    {
        return strtr($str, self::getRuCharsChangeSimple());
    }

    /**
     * Транслитерировать строку из русского в английский с использованием массива русских букв для расширенной транслитерации.
     *
     * @param string $str
     * @return string
     */
    public static function getChangeAdvancedWordRU(string $str): string
    {
        return strtr($str, self::getRuCharsChangeAdvanced());
    }

    /**
     * Транслитерировать строку из русского в английский с использованием массива русских букв для большей расширенной транслитерации.
     *
     * @param string $str
     * @return string
     */
    public static function getChangeExtendedWordRU(string $str): string
    {
        return strtr($str, self::getRuCharsChangeExtended());
    }

}
