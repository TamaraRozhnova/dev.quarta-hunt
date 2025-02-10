<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(HUT_CATALOG_IBLOCK_ID);
$arSections = $entity::getList(array(
    "order" => ['SORT' => 'ASC'],
    "select" => ["ID", "NAME", "IBLOCK_SECTION_ID", 'SECTION_PAGE_URL_RAW' => 'IBLOCK.SECTION_PAGE_URL'],
    "filter" => ["IBLOCK_ID" => HUT_CATALOG_IBLOCK_ID, "ACTIVE" => "Y", "IBLOCK_SECTION_ID" => array($arParams['SECTION_ID'])]
))->fetchAll();

foreach ($arSections as $section) {
    $section['SECTION_PAGE_URL'] = \CIBlock::ReplaceDetailUrl($section['SECTION_PAGE_URL_RAW'], $section, true, 'S');
    $arResult['INNER_SECTIONS'][] = $section;
}

global $APPLICATION;
$cp = $this->__component;
if (is_object($cp)) {
    foreach ($arResult['ITEMS'] as $item) {
        $itemIds[] = $item['ID'];
    }
    $cp->arResult['ITEM_IDS'] = $itemIds;
    $cp->SetResultCacheKeys(array('ITEM_IDS'));
}
