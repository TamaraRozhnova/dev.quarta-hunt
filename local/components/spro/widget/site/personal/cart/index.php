<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
$APPLICATION->IncludeFile('/_includes/cart/_cart.php', false, array('SHOW_BORDER' => false));

?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
