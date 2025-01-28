<?php

namespace Local\Util;

class HelperMethods
{
    public static function numberWords($n, $titles) {
        $cases = array(2, 0, 1, 1, 1, 2);
        return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
    }
}