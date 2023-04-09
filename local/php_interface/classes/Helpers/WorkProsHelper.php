<?php

namespace Helpers;

use CFile;
use CIBlockElement;

/**
 * Класс по работе с разделом "Работа в компании Quarta".
 */
class WorkProsHelper
{
    const IBLOCK_ID = 15;
    const SECTION_ID = 484;

    public static function getData(): array
    {
        $filter = ['IBLOCK_ID' => WorkProsHelper::IBLOCK_ID, 'SECTION_ID' => WorkProsHelper::SECTION_ID];
        $workProsResource = CIBlockElement::GetList([], $filter, ['NAME', 'PREVIEW_PICTURE', 'PREVIEW_TEXT']);
        $result = [];

        while ($workPros = $workProsResource->GetNextElement()) {
            $fields = $workPros->GetFields();
            $result[] = [
                'NAME' => $fields['NAME'],
                'PICTURE' => CFile::GetPath($fields['PREVIEW_PICTURE']),
                'TEXT' => $fields['PREVIEW_TEXT']
            ];
        }

        return $result;
    }
}