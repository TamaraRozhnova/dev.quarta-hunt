<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php'); ?>

<section class="bg-white" style="padding: 20px 0;">
    <div class="container">
        <? $APPLICATION->IncludeComponent(
            "arturgolubev:search.title",
            "",
            array(
                "ANIMATE_HINTS" => array(""),
                "ANIMATE_HINTS_SPEED" => "1",
                "CATEGORY_0" => array("iblock_1c_catalog", "iblock_content"),
                "CATEGORY_0_TITLE" => "",
                "CATEGORY_0_iblock_1c_catalog" => array("16", "27"),
                "CATEGORY_0_iblock_content" => array("all"),
                "CATEGORY_0_iblock_news" => array("1"),
                "CHECK_DATES" => "N",
                "CONTAINER_ID" => "smart-title-search",
                "CONVERT_CURRENCY" => "N",
                "FILTER_NAME" => "",
                "INPUT_ID" => "smart-title-search-input",
                "INPUT_PLACEHOLDER" => "",
                "NUM_CATEGORIES" => "1",
                "ORDER" => "rank",
                "PAGE" => "#SITE_DIR#testsearch/detail/index.php",
                "PREVIEW_HEIGHT_NEW" => "34",
                "PREVIEW_WIDTH_NEW" => "34",
                "PRICE_CODE" => array(),
                "PRICE_VAT_INCLUDE" => "Y",
                "SHOW_HISTORY" => "N",
                "SHOW_INPUT" => "Y",
                "SHOW_LOADING_ANIMATE" => "Y",
                "SHOW_PREVIEW" => "Y",
                "SHOW_PREVIEW_TEXT" => "N",
                "SHOW_PROPS" => array(""),
                "SHOW_QUANTITY" => "N",
                "TOP_COUNT" => "5",
                "USE_LANGUAGE_GUESS" => "Y"
            )
        ); ?>
    </div>
</section>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
