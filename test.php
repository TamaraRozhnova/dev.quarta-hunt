<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");

// Получение Даты доставки с помощью СДЭКА
global $USER;

include_once 'api/sdek/CalculatePriceDeliverySdek.php';

$sdek_calc = new CalculatePriceDeliverySdek();

$sdek_calc->setAuth('XOlAxGCIfVdenTUIIjS4rHfjup5tviyx', 'ATttW2E6ACWWyXd75R1L6nL52eKP2UIV');
$sdek_calc->setSenderCityId(137);
$sdek_calc->setReceiverCityId(44);
$sdek_calc->setTariffId(136);
$sdek_calc->addGoodsItemBySize(1, 20, 30, 40);
$sdek_calc->setServices([['id' => '2', 'param' => '1000']]);

$result['sdek'] = $sdek_calc->calculate();
$result['error'] = $sdek_calc->getError();
$result['result'] = $sdek_calc->getResult();

echo "<pre>"; var_dump($result['result']['result']); echo "</pre>";

// Получение Даты доставки с помощью СДЭКА

//Тесты Модуля Аммина Регионс

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

    echo "<pre>"; var_dump($fullInfo); echo "</pre>";
//    echo "<pre>"; var_dump($cityId); echo "</pre>";

//Тесты Модуля Аммина Регионс

// Получение Даты доставки с помощью Почты России

include_once 'api/russianPost/Request.php';

$russianPostRequest = new \Lib\Russianpost\Post\Request();

$params = [
    'ZIP' => '190000',
    'WEIGHT' => 200,
    'ADDRESS' => 'Сантк-Петербург',
    'PRICE' => 150900
];

$res = $russianPostRequest->PickUpCalculateSimple($params);

echo "<pre>"; var_dump($res[0]['delivery_interval']); echo "</pre>";

// Получение Даты доставки с помощью Почты России

// dadata tests

$token = "554dae973e9d3b7007a9d787bc1e8744432f9bfc";
$secret = "57f6f72d10837c78b8ade0e60ecbed2be3503cb5";
$dadata = new \Dadata\DadataClient($token, $secret);
$resultDadata = $dadata->clean("address", "Санкт-Петербург");
echo "<pre>"; var_dump($resultDadata['postal_code']); echo "</pre>";
// dadata tests

// запрос к бд на получение id города сдэка

global $DB;
$cityMoskId = 92;
$results = $DB->Query("SELECT * FROM `ipol_sdekcities` WHERE BITRIX_ID = " . $cityMoskId);

while($row = $results->Fetch()){
    echo '<pre>';
    var_dump($row['SDEK_ID']);
    echo '</pre>';
}

$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();
echo "<pre>"; var_dump($arUser['UF_SELECTED_USER_CITY']); echo "</pre>";
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>