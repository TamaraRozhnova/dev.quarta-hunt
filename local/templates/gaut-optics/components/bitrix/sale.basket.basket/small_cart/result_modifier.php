<?php if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global \CMain $APPLICATION */
/** @global \CUser $USER */
/** @global \CDatabase $DB */
/** @var CBitrixComponentTemplate $this */

foreach ($arResult["ITEMS"]["AnDelCanBuy"] as &$item){
    $arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_CML2_ARTICLE");
    $arFilter = Array("ID" => $item["PRODUCT_ID"],"IBLOCK_ID"=>CATALOG_IBLOCK_ID);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arProps = $ob->GetProperties();
        $item["arProps"][$arProps["CML2_ARTICLE"]["CODE"]] = $arProps["CML2_ARTICLE"];
    }

}