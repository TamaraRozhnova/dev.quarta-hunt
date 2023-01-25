<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


$arResult = modify_result($arResult);

$basketItemProductId = [];
foreach ($arResult['ORDERS'] as $i => $arOrder) {
    $arResult['ORDERS'][$i]['PROPERTIES_OF_GOODS_FROM_THE_CLASS'] = OrderId::getClothesShoesLicenseOnlyPickup($arOrder['ORDER']['ID']);
	foreach ($arOrder['BASKET_ITEMS'] as $j => $arItem) {
		$item = CIBlockElement::GetByID($arItem['PRODUCT_ID']);
		$elem = $item->GetNext();
        $basketItemProductId[$i] = [$arItem['PRODUCT_ID']];
		$arResult['ORDERS'][$i]['BASKET_ITEMS'][$j]['DETAIL_PICTURE'] = CFile::GetPath($elem['DETAIL_PICTURE']);
	}
}