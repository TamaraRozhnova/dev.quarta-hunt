<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

CModule::IncludeModule('iblock');

/*

['ID', 'NAME', 'CODE', 'XML_ID', 'PRICE_1', 'PRICE_2', 'PRICE_3', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL', 
		'PROPERTY_CML2_ARTICLE', 'PROPERTY_CML2_TAXES', 'PROPERTY_CML2_TRAITS', 'PROPERTY_CML2_MANUFACTURER']



$base_pr_res = CIBlockElement::GetList([], ['ID' => 26090], false, false, 
	['ID', 'NAME', 'CODE', 'XML_ID', 'PRICE_1', 'PRICE_2', 'PRICE_3', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL', 
		'PROPERTY_CML2_ARTICLE', 'PROPERTY_CML2_TAXES', 'PROPERTY_CML2_TRAITS', 'PROPERTY_CML2_MANUFACTURER', 'PROPERTY_CML2_BASE_UNIT']);

$arResult['product'] = $base_pr_res->GetNext();
*/


$sections = CIBlockSection::GetList([], ['IBLOCK_ID' => 16], false, ['UF_*']);
$sections_ind = 0;
$sids = [];

while ($s = $sections->GetNext()) {
    $arSections[$sections_ind]['IBLOCK_ID'] = $s['IBLOCK_ID'];
    $arSections[$sections_ind]['IBLOCK_SECTION_ID'] = $s['IBLOCK_SECTION_ID'];
    $arSections[$sections_ind]['XML_ID'] = $s['XML_ID'];
    $arSections[$sections_ind]['ID'] = $s['ID'];
    $arSections[$sections_ind]['NAME'] = $s['NAME'];
    $arSections[$sections_ind]['CODE'] = $s['CODE'];
    $arSections[$sections_ind]['SECTION_PAGE_URL'] = $s['SECTION_PAGE_URL'];
    $arSections[$sections_ind]['UF_BONUS_SYSTEM_ACTIVE'] = $s['UF_BONUS_SYSTEM_ACTIVE'];
    $arSections[$sections_ind]['UF_LISENCE_PRODUCTS'] = $s['UF_LISENCE_PRODUCTS'];
    $sections_ind++;
}

$arResult['SECTIONS'] = $arSections;


ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();


?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

