<?php if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global \CMain $APPLICATION */
/** @global \CUser $USER */
/** @global \CDatabase $DB */
/** @var CBitrixComponentTemplate $this */

$arPropsShow = [
    4 => "BLOUBEK_PNEVMATIKA",
    5 => "VES_PULKI",
    6 => "BREND_1",
    7 => "CML2_ARTICLE",
//    8 => "CML2_MANUFACTURER",
    9 => "KALIBR",
    10 => "DULNAYA_ENERGIYA_PNEVMATIKA/",
    11 => "MATERIAL_PNEVMATIKA",
//    12 => "NACHALNAYA_SKOROST_PULI_PNEVMATIKA",
    13 => "KOLICHESTVO_V_BANKE",
    14 => "TSVET_LINZ_STRELKOVYE_OCHKI",
];

foreach ($arResult["ITEMS"]["AnDelCanBuy"] as &$item){
    $arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_*");
    $arFilter = Array("ID" => $item["PRODUCT_ID"],"IBLOCK_ID"=>CATALOG_IBLOCK_ID);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arProps = $ob->GetProperties();
        foreach ($arProps as $prop){
            if(in_array($prop["CODE"], $arPropsShow)){
                $item["arProps"][$prop["CODE"]] = $prop;
            }
        }

    }

}