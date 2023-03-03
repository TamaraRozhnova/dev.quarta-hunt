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

\Bitrix\Main\UI\Extension::load('ui.fonts.opensans');

$themeClass = isset($arParams['TEMPLATE_THEME']) ? ' bx-' . $arParams['TEMPLATE_THEME'] : '';
$resAllSections = CIBlockSection::GetList([], ['IBLOCK_ID' => $arParams['IBLOCK_ID']]);
$allSections = [];
while ($ar_result = $resAllSections->GetNext()) {
    $allSections[$ar_result['ID']] = ['ID' => $ar_result['ID'], 'NAME' => $ar_result['NAME']];
}

?>
<div class="" style="padding-right: 10px;">
    <div class="row news-list<?= $themeClass ?>">
        <div class="col">
            <? if ($arParams["DISPLAY_TOP_PAGER"]): ?>
                <?= $arResult["NAV_STRING"] ?><br/>
            <? endif; ?>
            <?
            //        $itemsChunks = array_chunk($arResult["ITEMS"], 4);
            //        foreach($itemsChunks as $itemsChunk):
            //        foreach($arResult["ITEMS"] as $itemsChunk):
            //            $lineElement = [];
            //            if (count($itemsChunk) == 4) {
            //                $lineElement = $itemsChunk[count($itemsChunk)-1];
            //                unset($itemsChunk[count($itemsChunk)-1]);
            //            }
            ?>
            <!--            <div class="container">-->
            <div class="row">
                <? foreach ($arResult["ITEMS"] as $arItem): ?>
                    <?
                    $this->AddEditAction(
                        $arItem['ID'],
                        $arItem['EDIT_LINK'],
                        CIBlock::GetArrayByID(
                            $arItem["IBLOCK_ID"],
                            "ELEMENT_EDIT"
                        )
                    );
                    $this->AddDeleteAction(
                        $arItem['ID'],
                        $arItem['DELETE_LINK'],
                        CIBlock::GetArrayByID(
                            $arItem["IBLOCK_ID"],
                            "ELEMENT_DELETE"),
                        array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))
                    );
                    ?>
                    <div class="news-list-item col-12 col-sm-6 col-lg-4"
                         id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                        <div class="card">
                            <? if ($arParams["DISPLAY_PICTURE"] != "N"): ?>

                                <?
                                if ($arItem["VIDEO"]) {
                                    ?>
                                    <div class="news-list-item-embed-video embed-responsive embed-responsive-16by9">
                                        <iframe
                                                class="embed-responsive-item"
                                                src="<? echo $arItem["VIDEO"] ?>"
                                                frameborder="0"
                                                allowfullscreen=""
                                        ></iframe>
                                    </div>
                                <?
                                }
                                else if ($arItem["SOUND_CLOUD"])
                                {
                                ?>
                                    <div class="news-list-item-embed-audio embed-responsive embed-responsive-16by9">
                                        <iframe
                                                class="embed-responsive-item"
                                                width="100%"
                                                scrolling="no"
                                                frameborder="no"
                                                src="https://w.soundcloud.com/player/?url=<? echo urlencode($arItem["SOUND_CLOUD"]) ?>&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false"
                                        ></iframe>
                                    </div>
                                <?
                                }
                                else if ($arItem["SLIDER"] && count($arItem["SLIDER"]) > 1)
                                {
                                ?>
                                    <div class="news-list-item-embed-slider">
                                        <div class="news-list-slider-container" style="width: <?
                                        echo count($arItem["SLIDER"]) * 100 ?>%;left: 0;">
                                            <?
                                            foreach ($arItem["SLIDER"] as $file):?>
                                                <div class="news-list-slider-slide">
                                                    <img src="<?= $file["SRC"] ?>" alt="<?= $file["DESCRIPTION"] ?>">
                                                </div>
                                            <? endforeach ?>
                                        </div>
                                        <div class="news-list-slider-arrow-container-left">
                                            <div class="news-list-slider-arrow"><i class="fa fa-angle-left"></i></div>
                                        </div>
                                        <div class="news-list-slider-arrow-container-right">
                                            <div class="news-list-slider-arrow"><i class="fa fa-angle-right"></i></div>
                                        </div>
                                        <ul class="news-list-slider-control">
                                            <?
                                            foreach ($arItem["SLIDER"] as $i => $file):?>
                                                <li rel="<?= ($i + 1) ?>" <?
                                                if (!$i)
                                                    echo 'class="current"' ?>><span></span></li>
                                            <? endforeach ?>
                                        </ul>
                                    </div>
                                    <script type="text/javascript">
                                        BX.ready(function () {
                                            new JCNewsSlider('<?=CUtil::JSEscape($this->GetEditAreaId($arItem['ID']));?>', {
                                                imagesContainerClassName: 'news-list-slider-container',
                                                leftArrowClassName: 'news-list-slider-arrow-container-left',
                                                rightArrowClassName: 'news-list-slider-arrow-container-right',
                                                controlContainerClassName: 'news-list-slider-control'
                                            });
                                        });
                                    </script>
                                <?
                                }
                                else if ($arItem["SLIDER"])
                                {
                                ?>
                                    <div class="news-list-item-embed-img">
                                        <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])) {
                                            ?>
                                            <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                                                <img
                                                        class="card-img-top"
                                                        src="<?= $arItem["SLIDER"][0]["SRC"] ?>"
                                                        width="<?= $arItem["SLIDER"][0]["WIDTH"] ?>"
                                                        height="<?= $arItem["SLIDER"][0]["HEIGHT"] ?>"
                                                        alt="<?= $arItem["SLIDER"][0]["ALT"] ?>"
                                                        title="<?= $arItem["SLIDER"][0]["TITLE"] ?>"
                                                />
                                            </a>
                                            <?
                                        } else {
                                            ?>
                                            <img
                                                    class="card-img-top"
                                                    src="<?= $arItem["SLIDER"][0]["SRC"] ?>"
                                                    width="<?= $arItem["SLIDER"][0]["WIDTH"] ?>"
                                                    height="<?= $arItem["SLIDER"][0]["HEIGHT"] ?>"
                                                    alt="<?= $arItem["SLIDER"][0]["ALT"] ?>"
                                                    title="<?= $arItem["SLIDER"][0]["TITLE"] ?>"
                                            />
                                            <?
                                        }
                                        ?>
                                    </div>
                                    <?
                                }
                                else if (is_array($arItem["PREVIEW_PICTURE"])) {
                                    if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])) {
                                        ?>
                                        <figure class="news-card__image">
                                            <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="">
                                                <picture>
                                                    <source srcset="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                                            media="(max-width: 990px)">
                                                    <img
                                                            class="card-img-top"
                                                            src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                                            alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                                            title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                                                    />
                                                </picture>
                                            </a>
                                        </figure>
                                        <?
                                    }
                                    else {
                                        ?>
                                    <img
                                            src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                            class="card-img-top"
                                            alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                            title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                                    />
                                        <?
                                    }
                                }
                                ?>

                            <? endif; ?>

                            <div class="card-body">
                                <? if ($arParams["DISPLAY_DATE"] != "N" && $arItem["DISPLAY_ACTIVE_FROM"]):
                                    ?>
                                    <div class="news-list-view news-list-post-params">
                                        <span class="news-list-param"><? echo FormatDate('d F Y', strtotime($arItem["DISPLAY_ACTIVE_FROM"]));//date('d F Y', strtotime($arItem["DISPLAY_ACTIVE_FROM"]))
                                            ?></span>
                                        <? if ($arItem['IBLOCK_SECTION_ID'] != null): ?>
                                            <span class="news-list-item__section-name">
                                            <?= $allSections[$arItem['IBLOCK_SECTION_ID']]['NAME']; ?>
                                            </span>
                                        <? endif; ?>
                                    </div>
                                <? endif ?>

                                <? if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
                                    <h4 class="card-title">
                                        <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                                            <a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>"><? echo $arItem["NAME"] ?></a>
                                        <? else: ?>
                                            <? echo $arItem["NAME"] ?>
                                        <? endif; ?>
                                    </h4>
                                <? endif; ?>

                                <? if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
                                    <p class="card-text"><? echo $arItem["PREVIEW_TEXT"]; ?></p>
                                <? endif; ?>

                                <div class="news-list-item__btn-wrapper"><a href="" class="btn btn-primary">Читать</a></div>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
            <!--            </div>-->
            <!--        --><? // endforeach; ?>

            <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
                <?= $arResult["NAV_STRING"] ?>
            <? endif; ?>
        </div>
    </div>
</div>