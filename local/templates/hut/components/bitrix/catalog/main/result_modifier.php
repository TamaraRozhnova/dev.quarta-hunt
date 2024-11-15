<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;

/** @var array $arParams */
/** @var array $arResult */

Loader::includeModule("asd.iblock");

$arResult['IBLOCK_UF_PROPS'] = CASDiblockTools::GetIBUF(HUT_CATALOG_IBLOCK_ID);

$entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(HUT_CATALOG_IBLOCK_ID);
$arSections = $entity::getList(array(
    "order" => ['SORT' => 'ASC'],
    "select" => ["ID", "NAME", "PICTURE", 'SECTION_PAGE_URL_RAW' => 'IBLOCK.SECTION_PAGE_URL', 'UF_*'],
    "filter" => ["IBLOCK_ID" => HUT_CATALOG_IBLOCK_ID, "ACTIVE" => "Y", "UF_SHOW_ON_MAIN" => 1, 'DEPTH_LEVEL' => 2]
))->fetchAll();

foreach ($arSections as $section) {
    $section['SECTION_PAGE_URL'] = \CIBlock::ReplaceDetailUrl($section['SECTION_PAGE_URL_RAW'], $section, true, 'S');
    $arResult['DOING_SECTIONS'][] = $section;
}
