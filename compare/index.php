<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Сравнение товаров на сайте");
$APPLICATION->SetTitle("Сравнение товаров на сайте");

use General\User;

$APPLICATION->AddChainItem('Сравнение');

$user = new User();
$priceCode = $user->getUserPriceCode();

$compareList = $_SESSION[COMPARE_LIST_NAME][CATALOG_IBLOCK_ID]['ITEMS'];

?>

<div class="compare">
    <div class="container compare__container">
        <h2>Сравнение</h2>
        <p class="compare__count my-4"></p>
            <? if (!empty($compareList)) {
               $APPLICATION->IncludeComponent (
                    "bitrix:catalog.compare.result",
                    "main",
                    array(
                        "AJAX_MODE" => "Y",
                        "IBLOCK_ID" => "16",
                        "IBLOCK_TYPE" => "1c_catalog",
                        "NAME" => COMPARE_LIST_NAME,
                        "FIELD_CODE" => array('PREVIEW_PICTURE'),
                        "PROPERTY_CODE" => array('CML2_ARTICLE'),
                        "OFFERS_FIELD_CODE" => array('CML2_ARTICLE'),
                        "OFFERS_PROPERTY_CODE" => array(),
                        "ELEMENT_SORT_FIELD" => "sort",
                        "ELEMENT_SORT_ORDER" => "asc",
                        "DETAIL_URL" => "/catalog/#ELEMENT_ID#/#ELEMENT_CODE#/",
                        "BASKET_URL" => "/personal/basket.php",
                        "ACTION_VARIABLE" => "action",
                        "PRODUCT_ID_VARIABLE" => "id",
                        "SECTION_ID_VARIABLE" => "SECTION_ID",
                        "PRICE_CODE" => array($priceCode),
                        "DISPLAY_ELEMENT_SELECT_BOX" => "Y",
                        "ELEMENT_SORT_FIELD_BOX" => "name",
                        "ELEMENT_SORT_ORDER_BOX" => "asc",
                        "ELEMENT_SORT_FIELD_BOX2" => "id",
                        "ELEMENT_SORT_ORDER_BOX2" => "desc",
                        "HIDE_NOT_AVAILABLE" => "N",
                        "AJAX_OPTION_SHADOW" => "Y",
                        "AJAX_OPTION_JUMP" => "Y",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "Y",
                        "ON_COMPARE_PAGE" => "Y"
                    )
                );
            } ?>

            <div class="compare__empty" style="display: <?= empty($compareList) ? 'block' : 'none' ?>">
                <p class="text-dark fs-6">Нет товаров для сравнения</p>
                <a href="/catalog" class="btn btn-primary px-4">Продолжить покупки</a>
            </div>
    </div>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
