<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

CModule::IncludeModule("sale");

if (CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID())) {
    $arResult['error'] = false;
    $arResult['message'] = 'Товары удалены из корзины';
} else {
    $arResult['error'] = true;
    $arResult['message'] = 'Ошибка удаления товаров из корзины';
}

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();


?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>