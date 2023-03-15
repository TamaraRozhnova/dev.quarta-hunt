<?php

namespace Helpers;

use Bitrix\Bizproc\Workflow\Template\Packer\Result\Pack;

class NumWordHelper
{
    public static function getNumWord($value, $words, $show = true)
    {
        $num = $value % 100;
        if($num > 19) {
            $num = $num % 10;
        }

        $out = ($show) ? $value . ' ' : '';
        switch ($num) {
            case 1: $out .= $words[0]; break;
            case 2:
            case 3:
            case 4: $out .= $words[1]; break;
            default: $out .= $words[2]; break;
        }

        return $out;
    }
}