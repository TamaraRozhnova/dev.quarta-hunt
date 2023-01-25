<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?
CModule::IncludeModule('iblock');

$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 24], false, false, ['ID', 'CODE', 'NAME']);

while ($landing = $res->GetNextElement()) {
	$f = $landing->GetFields();
	$f['REST_API_URL'] = '/api/landing/?ID=' . $f['ID'];
	$f['URL'] = '/landing/' . $f['CODE'] . '/';
	$arResult[] = $f;
}

$arResult = modify_result($arResult);

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>