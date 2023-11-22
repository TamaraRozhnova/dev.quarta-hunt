<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */


//print_r($arResult);

$arr = [];

if(isset($arResult["SEARCH_ITEMS"]) && is_array($arResult["SEARCH_ITEMS"])){
    foreach($arResult["SEARCH_ITEMS"] as $arItem){
        $item = array(
            "ID" => $arItem["ID"],
//            "NAME" => iconv("windows-1251", "utf-8", $arItem["NAME"]),
//            "ARTICLE" => iconv("windows-1251", "utf-8", $arItem["PROPERTIES"]["ARTICLE"]["VALUE"]),
            "NAME" => $arItem["NAME"],
            "CML2_ARTICLE" => $arItem["PROPERTIES"]["CML2_ARTICLE"]["VALUE"],
        );
        $arr[] = $item;
    }
}

//echo_r($arr);
//$json = html_entity_decode(json_encode($arr));

$res = [
    "ajaxid"=>$arResult["AJAXID"],
    "items"=>$arr,
    "dbg"=>$arResult["dbg"],
];

echo(_json_encode($res  ));
