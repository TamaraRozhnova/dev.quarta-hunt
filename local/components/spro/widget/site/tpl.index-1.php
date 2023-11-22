<?
require( $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php" );
$APPLICATION->SetTitle( "Интернет-магазин \"Одежда\"" );

$APPLICATION->IncludeFile('/_includes/main_page.php', false, array('SHOW_BORDER'=>false));
?>
<? require( $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php" ); ?>
