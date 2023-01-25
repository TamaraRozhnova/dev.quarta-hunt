<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>


<?

CModule::IncludeModule('socialservices');

$oAuthManager = new CSocServAuthManager();

//$arAllServices = $oAuthManager->GetAuthServices([]);
$arActiveServices = $oAuthManager->GetActiveAuthServices([]);
//$arSettings = $oAuthManager->GetSettings();


//$arResult['ALL_AUTH_SERVICES'] = $arAllServices;
$arResult['ACTIVE'] = $arActiveServices;
//$arResult['SETTINGS'] = $arSettings;


//$arSettingsByService = $oAuthManager->GetSettingByServiceId('GoogleOAuth');

//$arResult['GoogleOAuth'] = $arSettingsByService;




ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();


//echo '<pre>';
//print_r($arResult);
//echo '</pre>';

?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>


