<?php

?>

<div class="modal-search-modern__wrapper <?= $isMobile ? 'mobile' : '' ?>">
    <div class="modal-search-modern__inner">
        <div class="modal-search-modern">
            <div class="modal-search-modern__sections">
                <div class="modal-search-modern__section">
                    <div class="modal-search-modern__section-name">
                        <span>Каталог товаров</span>
                    </div>
                    <div class="modal-search-modern__section-links">
                        <? foreach ($arResult['CATALOG_SECTIONS'] as $arCatalogSection): ?>
                            <a href="<?= $arCatalogSection['SECTION_URL'] ?>" class="modal-search-modern__section-link">
                                <?= $arCatalogSection['NAME'] ?>
                            </a>
                        <? endforeach; ?>
                    </div>
                    <a class="modal-search-modern__all-catalog" href="/catalog/">
                        Смотреть все
                        <svg width="8" height="10" viewBox="0 0 8 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M-4.47924e-07 1.23883L4.23077 5L-6.33365e-08 8.76117L1.3935 10L7.01777 5L1.3935 -5.2078e-08L-4.47924e-07 1.23883Z" fill="#004989" />
                        </svg>
                    </a>
                </div>
                <div class="modal-search-modern__section">
                    <div class="modal-search-modern__section-name">
                        <span>Новости и статьи</span>
                    </div>
                    <div class="modal-search-modern__section-links">
                        <? foreach ($arResult['BLOG_SECTIONS'] as $arBlogItem): ?>
                            <a href="<?= $arBlogItem['SECTION_URL'] ?>" class="modal-search-modern__section-link">
                                <?= $arBlogItem['NAME'] ?>
                            </a>
                        <? endforeach; ?>
                    </div>
                </div>
                <div class="modal-search-modern__section">
                    <div class="modal-search-modern__section-name">
                        <span>Популярные запросы</span>
                    </div>
                    <div class="modal-search-modern__section-links non-redirect">
                        <? foreach ($popularRequests as $popularItem): ?>
                            <a href="" class="modal-search-modern__section-link">
                                <?= $popularItem ?>
                            </a>
                        <? endforeach; ?>
                    </div>
                </div>
                <div class="modal-search-modern__section history">
                    <div class="modal-search-modern__section-name">
                        <span>История запросов</span>
                    </div>
                    <div class="modal-search-modern__section-links non-redirect">
                        <? foreach ($arResult["SEARCH_HISTORY"] as $historyItem): ?>
                            <a href="" class="modal-search-modern__section-link">
                                <?= $historyItem ?>
                            </a>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
            <a href="#" class="modal-search-modern__clear-history">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18" stroke="#004989" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6 6L18 18" stroke="#004989" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Очистить историю запросов
            </a>
            <span class="modal-search-modern__hr"></span>
            <div class="modal-search-modern__promo">
                <!-- news.list promo -->
                <? $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "modern_search_slider",
                    array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "N",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array("", "*", ""),
                        "FILTER_NAME" => "",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => "37",
                        "IBLOCK_TYPE" => "1c_catalog",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "20",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => "",
                        "PAGER_TITLE" => "Новости",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array("", "*", ""),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "DESC",
                        "SORT_ORDER2" => "ASC",
                        "STRICT_SECTION_CHECK" => "N"
                    ),
                    $component
                ); ?>
            </div>
        </div>
    </div>
    <div class="modal-search-modern__overlay"></div>
</div>