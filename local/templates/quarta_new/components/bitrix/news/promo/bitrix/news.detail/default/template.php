<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>

<div class="promo-detail">
    <div class="promo-detail__top-wrapper">
        <div class="detail_picture__wrapper">
            <? if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arResult["DETAIL_PICTURE"])): ?>
                <div class="detail_picture__element"
                     style="background-image: url('<?= $arResult["PICTURE"] ?>')"></div>
            <? endif ?>
        </div>
        <div class="deteil_title__wrapper">

        </div>
        <div class="detail_title__body">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="promo-detail__title-top-inner"></div>
                        <? if ($arParams["DISPLAY_DATE"] != "N" && $arResult["DISPLAY_ACTIVE_FROM"]): ?>
                            <span class="promo-date-time">с <?= $arResult["DISPLAY_ACTIVE_FROM"] ?> по <?= date('d.m.Y', strtotime($arResult["DATE_ACTIVE_TO"])) ?></span>
                        <? endif; ?>
                        <? if ($arParams["DISPLAY_NAME"] != "N" && $arResult["NAME"]): ?>
                            <h1 class="mb-2 mb-sm-4"><?= $arResult["NAME"] ?></h1>
                        <? endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="promo-detail__body-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-6">
                    <? if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arResult["FIELDS"]["PREVIEW_TEXT"]): ?>
                        <p><?= $arResult["FIELDS"]["PREVIEW_TEXT"];
                            unset($arResult["FIELDS"]["PREVIEW_TEXT"]); ?></p>
                    <? endif; ?>
                    <? if ($arResult["NAV_RESULT"]): ?>
                        <? if ($arParams["DISPLAY_TOP_PAGER"]): ?><?= $arResult["NAV_STRING"] ?><br/><? endif; ?>
                        <? echo $arResult["NAV_TEXT"]; ?>
                        <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?><br/><?= $arResult["NAV_STRING"] ?><? endif; ?>
                    <? elseif ($arResult["DETAIL_TEXT"] <> ''): ?>
                        <? echo $arResult["DETAIL_TEXT"]; ?>
                    <? else: ?>
                        <? echo $arResult["PREVIEW_TEXT"]; ?>
                    <? endif ?>
                    <div style="clear:both"></div>
                    <br/>
                    <? foreach ($arResult["FIELDS"] as $code => $value):
                        if ($code === 'DATE_ACTIVE_TO')
                            continue;
                        if ('PREVIEW_PICTURE' == $code || 'DETAIL_PICTURE' == $code) {
                            ?><?= GetMessage("IBLOCK_FIELD_" . $code) ?>:&nbsp;<?
                            if (!empty($value) && is_array($value)) {
                                ?><img border="0" src="<?= $value["SRC"] ?>" width="<?= $value["WIDTH"] ?>"
                                       height="<?= $value["HEIGHT"] ?>"><?
                            }
                        } else {
                            ?><?= GetMessage("IBLOCK_FIELD_" . $code) ?>:&nbsp;<?= $value; ?><?
                        }
                        ?><br/>
                    <?endforeach;
                    
                    if (array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y") {
                        ?>
                        <div class="news-detail-share">
                            <noindex>
                                <?
                                $APPLICATION->IncludeComponent("bitrix:main.share", "", array(
                                    "HANDLERS" => $arParams["SHARE_HANDLERS"],
                                    "PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
                                    "PAGE_TITLE" => $arResult["~NAME"],
                                    "SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
                                    "SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                                    "HIDE" => $arParams["SHARE_HIDE"],
                                ),
                                    $component,
                                    array("HIDE_ICONS" => "Y")
                                );
                                ?>
                            </noindex>
                        </div>
                        <?
                    }
                    ?>
                    <p><a class="btn btn-light px-4 bg-gray-200" href="<?=$arParams['RETURN_PATH']?>"><?=GetMessage("T_NEWS_DETAIL_BACK")?></a></p>
                </div>
                <div class="col-12 col-md-12 col-lg-6">
                <?php
                    global $arrFilterActionProduct;
                    $arrFilterActionProduct = [
                        '=ID' => $arResult['PROPERTIES']['PRODUCTS']['VALUE']
                    ];
                    ?>
                <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        "products.promo.action",
                        array(
                            "ACTION_VARIABLE" => "action",
                            "ADD_PICT_PROP" => "-",
                            "ADD_PROPERTIES_TO_BASKET" => "Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "ADD_TO_BASKET_ACTION" => "ADD",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "BACKGROUND_IMAGE" => "-",
                            "BASKET_URL" => "/personal/basket.php",
                            "BROWSER_TITLE" => "-",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "N",
                            "COMPATIBLE_MODE" => "Y",
                            "CONVERT_CURRENCY" => "N",
                            "CUSTOM_FILTER" => "",
                            "DETAIL_URL" => "",
                            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "Y",
                            "DISPLAY_COMPARE" => "N",
                            "DISPLAY_TOP_PAGER" => "N",
                            "ELEMENT_SORT_FIELD" => "sort",
                            "ELEMENT_SORT_FIELD2" => "id",
                            "ELEMENT_SORT_ORDER" => "asc",
                            "ELEMENT_SORT_ORDER2" => "desc",
                            "ENLARGE_PRODUCT" => "STRICT",
                            "FILTER_NAME" => "arrFilterActionProduct",
                            "HIDE_NOT_AVAILABLE" => "N",
                            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                            "IBLOCK_ID" => "16",
                            "IBLOCK_TYPE" => "1c_catalog",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "LABEL_PROP" => array(),
                            "LAZY_LOAD" => "N",
                            "LINE_ELEMENT_COUNT" => "",
                            "LOAD_ON_SCROLL" => "N",
                            "MESSAGE_404" => "",
                            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                            "MESS_BTN_BUY" => "Купить",
                            "MESS_BTN_DETAIL" => "Подробнее",
                            "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                            "MESS_BTN_SUBSCRIBE" => "Подписаться",
                            "MESS_NOT_AVAILABLE" => "Нет в наличии",
                            "MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
                            "META_DESCRIPTION" => "-",
                            "META_KEYWORDS" => "-",
                            "OFFERS_CART_PROPERTIES" => array(""),
                            "OFFERS_FIELD_CODE" => array(""),
                            "OFFERS_LIMIT" => "0",
                            "OFFERS_PROPERTY_CODE" => array(""),
                            "OFFERS_SORT_FIELD" => "sort",
                            "OFFERS_SORT_FIELD2" => "id",
                            "OFFERS_SORT_ORDER" => "asc",
                            "OFFERS_SORT_ORDER2" => "desc",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => ".default",
                            "PAGER_TITLE" => "Товары",
                            "PAGE_ELEMENT_COUNT" => "10",
                            "PARTIAL_PRODUCT_PROPERTIES" => "N",
                            "PRICE_CODE" => [$arResult['PRICE_CODE']],
                            "PRICE_VAT_INCLUDE" => "Y",
                            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                            "PRODUCT_DISPLAY_MODE" => "N",
                            "PRODUCT_ID_VARIABLE" => "id",
                            "PRODUCT_PROPERTIES" => array(0 => 'CML2_ARTICLE'),
                            "PRODUCT_PROPS_VARIABLE" => "prop",
                            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                            "PRODUCT_SUBSCRIPTION" => "Y",
                            "PROPERTY_CODE" => array(0 => 'CML2_ARTICLE'),
                            "PROPERTY_CODE_MOBILE" => array(""),
                            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                            "RCM_TYPE" => "personal",
                            "SECTION_CODE" => "",
                            "SECTION_ID" => "",
                            "SECTION_ID_VARIABLE" => "SECTION_ID",
                            "SECTION_URL" => "",
                            "SECTION_USER_FIELDS" => array("", ""),
                            "SEF_MODE" => "N",
                            "SET_BROWSER_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SHOW_ALL_WO_SECTION" => "N",
                            "SHOW_CLOSE_POPUP" => "N",
                            "SHOW_DISCOUNT_PERCENT" => "N",
                            "SHOW_FROM_SECTION" => "N",
                            "SHOW_MAX_QUANTITY" => "N",
                            "SHOW_OLD_PRICE" => "N",
                            "SHOW_PRICE_COUNT" => "1",
                            "SHOW_SLIDER" => "Y",
                            "SLIDER_INTERVAL" => "3000",
                            "SLIDER_PROGRESS" => "N",
                            "TEMPLATE_THEME" => "blue",
                            "USE_ENHANCED_ECOMMERCE" => "N",
                            "USE_MAIN_ELEMENT_SECTION" => "N",
                            "USE_PRICE_COUNT" => "N",
                            "USE_PRODUCT_QUANTITY" => "N",
                        ),
                        $component
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>