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
$this->setFrameMode(true);
$themeClass = isset($arParams['TEMPLATE_THEME']) ? ' bx-' . $arParams['TEMPLATE_THEME'] : '';
CUtil::InitJSCore(['fx', 'ui.fonts.opensans']);
$allSections = [];
$resAllSections = CIBlockSection::GetList([], ['IBLOCK_ID' => $arParams['IBLOCK_ID']]);
while ($ar_result = $resAllSections->GetNext()) {
    $allSections[$ar_result['ID']] = ['ID' => $ar_result['ID'], 'NAME' => $ar_result['NAME']];
}


?>
<div class="news-detail<?= $themeClass ?>" itemscope itemtype="http://schema.org/Article">
    <div class="news-detail__title-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3 col-lg-4">
                    <div class="h1" itemprop="headline"><?= $APPLICATION->GetTitle() ?></div>
                </div>
                <div class="col-12 col-md-9 pb-lg-5 col-lg-8">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section.list",
                        "newslist",
                        array(
                            "ADDITIONAL_COUNT_ELEMENTS_FILTER" => "additionalCountFilter",
                            "ADD_SECTIONS_CHAIN" => "Y",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "COUNT_ELEMENTS" => "N",
                            "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                            "FILTER_NAME" => "sectionsFilter",
                            "HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N",
                            "IBLOCK_ID" => "1",
                            "IBLOCK_TYPE" => "news",
                            "SECTION_CODE" => "",
                            "SECTION_FIELDS" => array(
                                0 => "",
                                1 => "",
                            ),
                            "CURRENT_SECTION_CODE" => $arParams["ELEMENT_IBLOCK_SECTION_CODE"],
                            "SECTION_URL" => "",
                            "PARENT_URL" => "/blog/",
                            "SECTION_USER_FIELDS" => array(
                                0 => "",
                                1 => "",
                            ),
                            "SHOW_PARENT_NAME" => "Y",
                            "TOP_DEPTH" => "2",
                            "VIEW_MODE" => "TEXT",
                            "COMPONENT_TEMPLATE" => ".default"
                        ),
                        $component
                    ); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 news-detail-background-wrapper" id="<? echo $this->GetEditAreaId($arResult['ID']) ?>">

        <? if ($arParams["DISPLAY_PICTURE"] != "N"): ?>
            <? if ($arResult["VIDEO"]) {
                ?>
                <div class="mb-5 news-detail-youtube embed-responsive embed-responsive-16by9" style="display: block;">
                    <iframe src="<?
                    echo $arResult["VIDEO"] ?>" frameborder="0" allowfullscreen=""></iframe>
                </div>
                <?
            } else if ($arResult["SOUND_CLOUD"]) {
                ?>
                <div class="mb-5 news-detail-audio">
                    <iframe width="100%" height="166" scrolling="no" frameborder="no"
                            src="https://w.soundcloud.com/player/?url=<?
                            echo urlencode($arResult["SOUND_CLOUD"]) ?>&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false"></iframe>
                </div>
                <?
            } else if ($arResult["SLIDER"] && count($arResult["SLIDER"]) > 1) {
                ?>
                <div class="mb-5 news-detail-slider">
                    <div class="news-detail-slider-container"
                         style="width: <? echo count($arResult["SLIDER"]) * 100 ?>%;left: 0%;">
                        <? foreach ($arResult["SLIDER"] as $file): ?>
                            <div style="width: <? echo 100 / count($arResult["SLIDER"]) ?>%;"
                                 class="news-detail-slider-slide">
                                <img src="<?= $file["SRC"] ?>" alt="<?= $file["DESCRIPTION"] ?>">
                            </div>
                        <? endforeach ?>
                        <div style="clear: both;"></div>
                    </div>
                    <div class="news-detail-slider-arrow-container-left">
                        <div class="news-detail-slider-arrow"><i class="fa fa-angle-left"></i></div>
                    </div>
                    <div class="news-detail-slider-arrow-container-right">
                        <div class="news-detail-slider-arrow"><i class="fa fa-angle-right"></i></div>
                    </div>
                    <ul class="news-detail-slider-control">
                        <? foreach ($arResult["SLIDER"] as $i => $file): ?>
                            <li rel="<?= ($i + 1) ?>" <? if (!$i)
                                echo 'class="current"' ?>><span></span></li>
                        <? endforeach ?>
                    </ul>
                </div>
                <?
            } else if ($arResult["SLIDER"]) {
                ?>
                <div class="mb-5 news-detail-img">
                    <img
                            class="card-img-top"
                            src="<?= $arResult["SLIDER"][0]["SRC"] ?>"
                            alt="<?= $arResult["SLIDER"][0]["ALT"] ?>"
                            title="<?= $arResult["SLIDER"][0]["TITLE"] ?>"
                    />
                </div>
                <?
            } else if (is_array($arResult["DETAIL_PICTURE"])) {
                ?>
                <div class="news-detail__header-wrapper">
                    <div class="news-detail__header-title">
                        <div class="container">
                            <div class="col-12 col-md-4">
                                <? if ($arParams["DISPLAY_DATE"] != "N" && $arResult["DISPLAY_ACTIVE_FROM"]):
                                    ?>
                                    <div class="news-detail-date">
                                        <span class="news-detail-param" itemprop="dateModified" ><? echo FormatDate('d F Y', strtotime($arResult["DISPLAY_ACTIVE_FROM"]));
                                            ?></span>
                                        <? if (false && $arResult['IBLOCK_SECTION_ID'] != null): ?>
                                            <span class="news-list-item__section-name">
                                            <?= $allSections[$arResult['IBLOCK_SECTION_ID']]['NAME']; ?>
                                            </span>
                                        <? endif; ?>
                                    </div>
                                <? endif ?>
                                <? if ($arParams["DISPLAY_NAME"] != "N" && $arResult["NAME"]): ?>
                                    <h1 class="news-detail-title"><?= $arResult["NAME"] ?></h1>
                                <? endif; ?>
                                <div class="preview-text"><? echo $arResult["PREVIEW_TEXT"]; ?></div>
                            </div>
                            <div class="included__sharing">
                                <?php
                                    $APPLICATION->IncludeComponent(
                                        "bitrix:news.list", 
                                        "services.sharing", 
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
                                            "FIELD_CODE" => array(
                                                0 => "",
                                                1 => "*",
                                                2 => "",
                                            ),
                                            "FILTER_NAME" => "",
                                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                            "IBLOCK_ID" => "31",
                                            "IBLOCK_TYPE" => "content",
                                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                            "INCLUDE_SUBSECTIONS" => "Y",
                                            "MESSAGE_404" => "",
                                            "NEWS_COUNT" => "5",
                                            "PAGER_BASE_LINK_ENABLE" => "N",
                                            "PAGER_DESC_NUMBERING" => "N",
                                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                            "PAGER_SHOW_ALL" => "N",
                                            "PAGER_SHOW_ALWAYS" => "N",
                                            "PAGER_TEMPLATE" => ".default",
                                            "PAGER_TITLE" => "Новости",
                                            "PARENT_SECTION" => "",
                                            "PARENT_SECTION_CODE" => "",
                                            "PREVIEW_TRUNCATE_LEN" => "",
                                            "PROPERTY_CODE" => array(
                                                0 => "SS_LINK",
                                                1 => "*",
                                                2 => "",
                                            ),
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
                                            "STRICT_SECTION_CHECK" => "N",
                                            "COMPONENT_TEMPLATE" => "services.sharing"
                                        ),
                                        $component
                                    );
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5 news-detail-img">
                        <img
                                class="card-img-top"
                                src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>"
                                alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>"
                                title="<?= $arResult["DETAIL_PICTURE"]["TITLE"] ?>"
                                itemprop="image"
                        >
                    </div>
                </div>
                <?
            }
            ?>
        <? endif ?>

        <div class="news-detail-body">

            <div class="news-detail-content container">
                <div class="row">
                    <div class="col-12 col-lg-8" itemprop="articleBody">
                        <? if ($arResult["NAV_RESULT"]): ?>
                        <? if ($arParams["DISPLAY_TOP_PAGER"]): ?><?= $arResult["NAV_STRING"] ?><br/><? endif; ?>
                        <? echo $arResult["NAV_TEXT"]; ?>
                        <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?><br/><?= $arResult["NAV_STRING"] ?><? endif; ?>
                        <? elseif ($arResult["DETAIL_TEXT"] <> ''): ?>
                            <? echo $arResult["DETAIL_TEXT"]; ?>
                        <? else: ?>
                            <? echo $arResult["PREVIEW_TEXT"]; ?>
                        <? endif ?>
                        <p><a class="btn btn-light px-4 bg-gray-200" href="<?=$arParams["RETURN_PATH"]?>"><?=GetMessage("T_NEWS_DETAIL_BACK")?></a></p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    BX.ready(function () {
        var slider = new JCNewsSlider('<?=CUtil::JSEscape($this->GetEditAreaId($arResult['ID']));?>', {
            imagesContainerClassName: 'news-detail-slider-container',
            leftArrowClassName: 'news-detail-slider-arrow-container-left',
            rightArrowClassName: 'news-detail-slider-arrow-container-right',
            controlContainerClassName: 'news-detail-slider-control'
        });
    });
</script>
