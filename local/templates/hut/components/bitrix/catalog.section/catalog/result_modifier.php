<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

global $APPLICATION;
$cp = $this->__component;
if (is_object($cp)) {
    foreach ($arResult['ITEMS'] as $item) {
        $itemIds[] = $item['ID'];
    }
    $cp->arResult['ITEM_IDS'] = $itemIds;
    $cp->SetResultCacheKeys(array('ITEM_IDS'));
}
