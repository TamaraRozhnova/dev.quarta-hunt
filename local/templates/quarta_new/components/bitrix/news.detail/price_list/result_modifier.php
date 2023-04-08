<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\FileSizeHelper;

$fileIds = $arResult['PROPERTIES']['PRICE_LIST']['VALUE'];
$arResult['FILES'] = [];

if (!empty($fileIds)) {
    foreach ($fileIds as $fileId) {
        $fileResource = CFile::GetByID($fileId);
        if ($file = $fileResource->GetNext()) {
            $arResult['FILES'][] = [
                'NAME' => $file['ORIGINAL_NAME'],
                'SIZE' => FileSizeHelper::getFormattedSize($file['FILE_SIZE']),
                'SRC' => $file['SRC']
            ];
        }
    }
}