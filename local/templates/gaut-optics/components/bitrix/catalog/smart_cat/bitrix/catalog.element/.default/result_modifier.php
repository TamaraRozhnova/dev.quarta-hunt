<?php use Bitrix\Iblock\Model\PropertyFeature;

if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */


$obElList = CIBlockElement::GetList(
	[
		'ID' => 'DESC'
	],
	[
		'IBLOCK_ID' => IBLOCKS['ib-review'],
		'PROPERTY_PRODUCT' => $arResult['ID'],
		'ACTIVE' => 'Y',
	],
	false,
	false,
	[
		'NAME',
		'PREVIEW_PICTURE',
		'PREVIEW_TEXT',
		'ACTIVE_FROM',
        'PROPERTY_STARS'
	]
);

$arResult['REVIEWS'] = [];
while ($item = $obElList->GetNext())
{
	$arResult['REVIEWS'][] = $item;
}

$arResult['SHOW_PROPS'] = PropertyFeature::getDetailPageShowPropertyCodes(
	$arParams['IBLOCK_ID'],
	['CODE' => 'Y']
);

if(!empty($arResult['DISPLAY_PROPERTIES'])) foreach ($arResult['DISPLAY_PROPERTIES'] as $v) {
    $k++;
    if ($k % 2 != 0) {
        $arResult['PROPERTIES_CHANK'][1][] = $v;
        continue;
    }
    $arResult['PROPERTIES_CHANK'][2][] = $v;

}

//echo '<pre>';print_r($arResult['PROPERTIES_CHANK']);echo '</pre>';
