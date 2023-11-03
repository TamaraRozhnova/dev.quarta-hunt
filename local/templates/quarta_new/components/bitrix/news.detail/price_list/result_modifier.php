<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\IO,
    Helpers\FileSizeHelper,
    Bitrix\Main\Application;

$documentRoot = Application::getDocumentRoot();

$dirPriceList = new IO\Directory(
    implode('/', [
        $documentRoot,
        'upload',
        'price_list'
    ])
);

if ($dirPriceList->isExists()) {

    $arFiles = $dirPriceList->getChildren();

    if (!empty($arFiles)) {
        foreach ($arFiles as $arFileIndex => $arFile) {

            $pathFile = $arFile->getPath();

            $obFileData = new IO\File(
                $pathFile
            );

            $arResult['FILES'][$arFileIndex]['NAME'] = $obFileData->getName();
            $arResult['FILES'][$arFileIndex]['SIZE'] = FileSizeHelper::getFormattedSize($obFileData->getSize());
            $arResult['FILES'][$arFileIndex]['SRC'] = str_replace(
                $documentRoot,
                '',
                $pathFile
            );

        }
    }

}