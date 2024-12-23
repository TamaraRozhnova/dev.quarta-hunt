<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
?><div style="height: 500px; background-color: white;">
	 <?$APPLICATION->IncludeComponent(
	"ammina:regions.selector",
	"template1",
	Array(
		"ALLOW_REDIRECT" => "N",
		"CACHE_TIME" => "86400",
		"CACHE_TYPE" => "A",
		"CHANGE_CITY_MANUAL" => "Y",
		"CITY_VERIFYCATION" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"COUNT_SHOW_CITY" => "24",
		"INCLUDE_JQUERY" => "Y",
		"IP" => "",
		"MOBILE_CHANGE_CITY_MANUAL" => "Y",
		"MOBILE_CITY_VERIFYCATION" => "N",
		"MOBILE_COUNT_SHOW_CITY" => "24",
		"MOBILE_SEARCH_CITY_TYPE" => "Q",
		"MOBILE_SHOW_CITY_TYPE" => "R",
		"MOBILE_USE_GPS" => "Y",
		"PRIORITY_DOMAIN" => "N",
		"SEARCH_CITY_TYPE" => "Q",
		"SEPARATE_SETTINGS_MOBILE" => "N",
		"SHOW_CITY_TYPE" => "R",
		"USE_GPS" => "Y"
	)
);?> <?php

    CModule::IncludeModule('ammina.regions');

    // получить город из кеша
    $cityId = false;
    $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
    $cityId = intval($request->getCookie("ARG_CITY"));

    // если города в кеше нет, можно получить его по ip
    if ($cityId <= 0) {
        $cityId = \Ammina\Regions\BlockTable::getCityIdByIP();
    }

    // получение фулл информации о городе по id
    $fullInfo = \Ammina\Regions\BlockTable::getCityFullInfoByID($cityId);

//    echo "<pre>"; var_dump($fullInfo); echo "</pre>";
//    echo "<pre>"; var_dump($cityId); echo "</pre>";
    ?><br>
 <br>
	 <?$APPLICATION->IncludeComponent(
	"ammina:regions.geocontent",
	"",
	Array(
		"CACHE_TIME" => "86400",
		"CACHE_TYPE" => "A",
		"CONTENT_TYPE" => "1",
		"IP" => "",
		"SET_TAG_IDENT" => "Y",
		"SET_TAG_TYPE" => "div"
	)
);?>
</div>
<div class="geo_content" id="geo_content">
	 Select Omsk
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>