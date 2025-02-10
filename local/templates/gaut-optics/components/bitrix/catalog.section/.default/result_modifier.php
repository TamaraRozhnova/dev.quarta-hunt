<?php use Bitrix\Iblock\Model\PropertyFeature;

if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global \CMain $APPLICATION */
/** @global \CUser $USER */
/** @global \CDatabase $DB */
/** @var CBitrixComponentTemplate $this */


$arResult['SHOW_PROPS'] = PropertyFeature::getListPageShowPropertyCodes(
	$arParams['IBLOCK_ID'],
	['CODE' => 'Y']
);
