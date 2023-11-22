<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>

<?
CModule::IncludeModule("catalog");
Add2BasketByProductID( $_REQUEST['ID'], $_REQUEST['Q'], $arRewriteFields = array(), $arProductParams = false);?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
