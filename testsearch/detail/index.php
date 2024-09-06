<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php'); ?>

<section class="bg-white">
    <div class="container">

        <? $APPLICATION->IncludeComponent(
            "arturgolubev:search.page",
            "",
            array(
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "N",
                "DEFAULT_SORT" => "rank",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FILTER_NAME" => "",
                "INPUT_PLACEHOLDER" => "",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Название результатов поиска",
                "PAGE_RESULT_COUNT" => "15",
                "PREVIEW_TEXT" => "",
                "SHOW_HISTORY" => "N",
                "SHOW_PROPS" => array("74", "75"),
                "SHOW_WHEN" => "Y",
                "SHOW_WHERE" => "N",
                "USE_LANGUAGE_GUESS" => "Y",
                "arrFILTER" => array("iblock_1c_catalog", "iblock_news"),
                "arrFILTER_iblock_1c_catalog" => array("16", "27"),
                "arrFILTER_iblock_about" => array("all"),
                "arrFILTER_iblock_news" => array("1"),
                "arrWHERE" => array()
            )
        ); ?>

    </div>
</section>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
