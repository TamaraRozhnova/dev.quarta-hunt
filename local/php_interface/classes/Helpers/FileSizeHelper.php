<?php

namespace Helpers;

class FileSizeHelper
{
    public static function getFormattedSize(int $sizeInBytes): string
    {
        $type = ['b', 'Kb', 'Mb'];
        $count = 0;
        while (($sizeInBytes / 1000 | 0) && $count < count($type) - 1) {
            $sizeInBytes /= 1024;
            $count++;
        }

        return round($sizeInBytes, 2) . ' ' . $type[$count];
    }
}