<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var $APPLICATION */
/** @var $arParams */

/** @var $component */

use Bitrix\Iblock\SectionElementTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Application;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use General\User;

$this->setFrameMode(true);

Loader::includeModule("arturgolubev.smartsearch");

/** Тип цены пользователя */
$user = new User();
$priceCode = $user->getUserPriceCode();
$userPriceId = $user->getUserPriceId();

$context = Application::getInstance()->getContext();
$request = $context->getRequest();
$uriString = $request->getRequestUri();
?>

<div class="category">

    <section class="category__header">
        <div class="container">
            <h1 class="category__header-title">
                <?= Loc::getMessage('CT_BCSE_TITLE'); ?>
            </h1>
        </div>
    </section>

    <div class="container category__main">
        <div class="row">

            <?php

            $tab = $request->get("tab");
            if ($tab == 'blog') {
                $arParams["IBLOCK_TYPE"] = 'news';
                $arParams["IBLOCK_ID"] = 1;
            }
            if ($tab == 'sales') {
                $arParams["IBLOCK_TYPE"] = '1c_catalog';
                $arParams["IBLOCK_ID"] = 37;
            }

            $bx_search_limit = COption::GetOptionString('search', 'max_result_size', 999);
            $arElements = $APPLICATION->IncludeComponent(
                "arturgolubev:search.page",
                "catalog",
                array(
                    "RESTART" => 'Y',
                    "NO_WORD_LOGIC" => 'Y',
                    "USE_LANGUAGE_GUESS" => 'N',
                    "CHECK_DATES" => 'Y',
                    "arrFILTER" => array("iblock_" . $arParams["IBLOCK_TYPE"]),
                    "arrFILTER_iblock_" . $arParams["IBLOCK_TYPE"] => [$arParams["IBLOCK_ID"]],
                    "USE_TITLE_RANK" => "Y",
                    "DEFAULT_SORT" => "rank",
                    "FILTER_NAME" => "",
                    "SHOW_WHERE" => "N",
                    "arrWHERE" => [],
                    "SHOW_WHEN" => "N",
                    "PAGE_RESULT_COUNT" => $bx_search_limit,
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "N",
                    "INPUT_PLACEHOLDER" => $arParams["INPUT_PLACEHOLDER"],
                    "SHOW_HISTORY" => $arParams["SHOW_HISTORY"],
                ),
                $component,
                ['HIDE_ICONS' => 'Y']
            );


            ?>
                <div class="tabs">
                    <a class="<?=($tab == null || $tab == 'catalog') ? 'active' : ''?>" href="<?=$uriString?>&tab=catalog"><?=Loc::getMessage('TAB_CATALOG')?></a>
                    <a class="<?=($tab == 'blog') ? 'active' : ''?>" href="<?=$uriString?>&tab=blog"><?=Loc::getMessage('TAB_BLOG')?></a>
                    <a class="<?=($tab == 'sales') ? 'active' : ''?>" href="<?=$uriString?>&tab=sales"><?=Loc::getMessage('TAB_SALES')?></a>
                </div>
            <?php

            if (!empty($arElements) && is_array($arElements)) {
                foreach ($arElements as $k => $v) {
                    if (substr($v, 0, 1) == 'S')
                        unset($arElements[$k]);
                }

                $arElements = array_values($arElements);

                if ($arParams["ELEMENT_SORT_FIELD"] == 'rank') {
                    $arParams["ELEMENT_SORT_FIELD"] = "ID";
                    $arParams["ELEMENT_SORT_ORDER"] = $arElements;
                }

                $uriString = $request->getRequestUri();

                $uriString = parse_url($uriString);
                parse_str($uriString['query'], $output);
                if (isset($output['categoryid'])) {
                    unset($output['categoryid']);
                }
                $uriString = $uriString['path'] . '?' . http_build_query($output);

                $sort = $request->get("sort");
                $categoryId = (int)$request->get("categoryid");
                $onlyAvailable = $request->get("onlyAvailable");
                $arParams["PAGE_ELEMENT_COUNT"] = (int)$request->get("itemsPerPage") ?? 20;

                /* основной фильтр секции */
                global $searchFilter;
                $searchFilter = ['ID' => $arElements];

                if ($categoryId > 0) {
                    $searchFilter = array_merge($searchFilter, ['SECTION_ID' => $categoryId]);
                }

                /* доступные */
                if ($onlyAvailable === 'true') {
                    $arParams["HIDE_NOT_AVAILABLE"] = 'Y';
                    $arParams["HIDE_NOT_AVAILABLE_OFFERS"] = 'Y';
                }

                /* сортировки */
                switch ($sort) {
                    case 'price_desc':
                        $sortField = 'SCALED_' . $userPriceId;
                        $sortOrder = 'DESC';
                        break;

                    case 'price_asc':
                        $sortField = 'SCALED_' . $userPriceId;
                        $sortOrder = 'ASC';
                        break;

                    case 'discount_desc':
                        $sortField = 'PROPERTY_SIZE_DISCOUNT';
                        $sortOrder = 'DESC';
                        break;

                    case 'discount_asc':
                        $sortField = 'PROPERTY_SIZE_DISCOUNT';
                        $sortOrder = 'ASC';
                        break;

                    case 'relevante':
                        $sortField = 'SHOWS';
                        $sortOrder = 'DESC';
                        break;

                    case 'alphabet_asc':
                        $sortField = 'NAME';
                        $sortOrder = 'ASC';
                        break;

                    case 'alphabet_desc':
                        $sortField = 'NAME';
                        $sortOrder = 'DESC';
                        break;

                    case 'available':
                        $sortField = 'CATALOG_AVAILABLE';
                        $sortOrder = 'DESC';
                        break;

                    case 'rating_desc':
                        $sortField = 'property_RATING';
                        $sortOrder = 'DESC';
                        break;

                    case 'rating_asc':
                        $sortField = 'property_RATING';
                        $sortOrder = 'ASC';
                        break;

                    default:
                        break;
                }

                /* список разделов товаров из поиска */
                $arProductCategories = SectionElementTable::query()
                    ->addSelect('IBLOCK_SECTION_ID')
                    ->whereIn('IBLOCK_ELEMENT_ID', $arElements)
                    ->fetchAll();

                $arProductCategories = array_column($arProductCategories, 'IBLOCK_SECTION_ID');
                $arProductCategories = array_unique($arProductCategories);

                /* данные о разделах товаро */
                $sectionList = SectionTable::query()
                    ->addSelect('ID')
                    ->addSelect('NAME')
                    ->addSelect('IBLOCK_SECTION_ID')
                    ->whereIn('ID', $arProductCategories)
                    ->fetchAll();

                /* родительские разделы */
                $arSectionParentsIds = array_column($sectionList, 'IBLOCK_SECTION_ID');

                if (is_array($arSectionParentsIds) && count($arSectionParentsIds) > 0 && $arSectionParentsIds[0] != null) {
                    $arSectionParentsIds = array_unique($arSectionParentsIds);

                    $arSectionParents = SectionTable::query()
                        ->addSelect('ID')
                        ->addSelect('NAME')
                        ->whereIn('ID', $arSectionParentsIds)
                        ->fetchAll();


                    /* формируем конечный массив для вывода в фильтр */
                    foreach ($arSectionParents as &$parent) {
                        $childKey = array_search($parent['ID'], array_column($sectionList, 'IBLOCK_SECTION_ID'));
                        $parent['CHILDREN'][] = $sectionList[$childKey];
                    }
                    unset($parent);
                } else {
                    $arSectionParents = $sectionList;
                }
                ?>

                <div class="category category__filter-wrap">
                    <div class="filters category__filter">
                        <section class="filters__header">
                            <h6><?= Loc::getMessage('CT_BCSE_CATEGORIES') ?></h6>
                            <div class="filters__clear"><a
                                        href="<?= $uriString ?>"><?= Loc::getMessage('CT_BCSE_CLEAR') ?></a></div>
                        </section>

                        <span class="filters__wr">

                            <?php foreach ($arSectionParents as $arSection) {
                                $isActive = false;
                                $withCldren = $arSection['CHILDREN'] ? true : false;
                                if ($categoryId > 0 && $withCldren) {
                                    $isActive = in_array($categoryId, array_column($arSection['CHILDREN'], 'ID'));
                                }
                                if ($categoryId > 0 && !$withCldren) {
                                    $isActive = $categoryId == $arSection['ID'];
                                }

                                ?>

                                <div class="filters-section  <?= (!$withCldren) ? 'single-section' : '' ?> <?= ($isActive) ? 'filters-section--expanded' : '' ?>">
                                    <div class="filters-section__header">
                                        <?php if ($withCldren) {?>
                                            <h6><?= $arSection['NAME'] ?></h6>
                                        <?php } else { ?>
                                            <h6><a href="<?= $uriString ?>&categoryid=<?= $arSection['ID'] ?>"><?= $arSection['NAME'] ?></a></h6>
                                        <?php } ?>
                                    </div>
                                    <?php if ($withCldren) { ?>
                                        <div class="filters-section__body">
                                        <?php foreach ($arSection['CHILDREN'] as $itemSection) { ?>
                                            <div>
                                                <div class="filters-item <?= $isActive ? 'active' : '' ?>">
                                                    <a href="<?= $uriString ?>&categoryid=<?= $itemSection['ID'] ?>"><?= $itemSection['NAME'] ?></a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>

                            <?php } ?>

                        </span>

                    </div>
                </div>

                <?php
                if ($tab == null || $tab == 'catalog') {
                    $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        "search_page",
                        array(
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],

                            "ELEMENT_SORT_FIELD" => $sortField ?? '',
                            "ELEMENT_SORT_FIELD2" => "",
                            "ELEMENT_SORT_ORDER" => $sortDirection ?? '',
                            "ELEMENT_SORT_ORDER2" => "",

                            "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                            "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                            "PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
                            "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                            "OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
                            "OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
                            "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                            "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                            "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                            "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                            "OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
                            "SECTION_URL" => $arParams["SECTION_URL"],
                            "DETAIL_URL" => $arParams["DETAIL_URL"],
                            "BASKET_URL" => $arParams["BASKET_URL"],
                            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                            "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                            "DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
                            "PRICE_CODE" => [$priceCode],
                            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                            "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
                            "USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
                            "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
                            "CURRENCY_ID" => $arParams["CURRENCY_ID"],
                            "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
                            "HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
                            "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                            "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                            "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                            "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                            "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                            "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                            "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                            "FILTER_NAME" => "searchFilter",
                            "SECTION_ID" => "",
                            "SECTION_CODE" => "",
                            "SECTION_USER_FIELDS" => array(),
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "SHOW_ALL_WO_SECTION" => "Y",
                            "META_KEYWORDS" => "",
                            "META_DESCRIPTION" => "",
                            "BROWSER_TITLE" => "",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "SET_TITLE" => "N",
                            "SET_STATUS_404" => "N",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "N",
                            "COMPATIBLE_MODE" => "Y",
                        ),
                        $component,
                        ['HIDE_ICONS' => 'Y']
                    );
                }

                if ($tab == 'blog') {
                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "modern_searchpage_blog",
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
                            "CACHE_TYPE" => "N",
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "",
                            "DISPLAY_BOTTOM_PAGER" => "N",
                            "DISPLAY_DATE" => "Y",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "Y",
                            "DISPLAY_PREVIEW_TEXT" => "Y",
                            "DISPLAY_TOP_PAGER" => "N",
                            "FIELD_CODE" => array("", "*", ""),
                            "FILTER_NAME" => "searchFilter",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "IBLOCK_ID" => "1",
                            "IBLOCK_TYPE" => "news",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "MESSAGE_404" => "",
                            "NEWS_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
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
                        false
                    );
                }

                if ($tab == 'sales') {

                }


                ?>

                <?php

            } elseif (is_array($arElements)) {
                echo Loc::getMessage("CT_BCSE_NOT_FOUND");
            }
            ?>
        </div>
    </div>
</div>
