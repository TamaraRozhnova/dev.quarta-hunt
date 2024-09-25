<?php

use Bitrix\Main\UI\Extension;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

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

Extension::load('ui.fonts.opensans');

$resAllSections = CIBlockSection::GetList([], ['IBLOCK_ID' => $arParams['IBLOCK_ID']]);
$allSections = [];
while ($ar_result = $resAllSections->GetNext()) {
    $allSections[$ar_result['ID']] = ['ID' => $ar_result['ID'], 'NAME' => $ar_result['NAME']];
}

?>
<div class="col">
    <div class="news-list">

        <?php if ($arParams["DISPLAY_TOP_PAGER"]): ?>
            <?= $arResult["NAV_STRING"] ?><br/>
        <?php endif; ?>

        <div class="row news-list-items-wrapper">

            <?php foreach ($arResult["ITEMS"] as $arItemIndex => $arItem): ?>
            <?php $arItemIterator = $arItemIndex + 1 ?>

            <?php if ($arItemIterator != 0 && $arItemIterator % 13 == 0): ?>
        </div>
        <div class="row">
            <?php endif; ?>

            <?php
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
            <div class="news-list-item col-12 col-sm-6 col-lg-4" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                <div class="card">
                    <?php if ($arParams["DISPLAY_PICTURE"] != "N"): ?>

                        <?php
                        if ($arItem["VIDEO"]) {
                            ?>
                            <div class="news-list-item-embed-video embed-responsive embed-responsive-16by9">
                                <iframe
                                        class="embed-responsive-item"
                                        src="<?php echo $arItem["VIDEO"] ?>"
                                        frameborder="0"
                                        allowfullscreen=""
                                ></iframe>
                            </div>
                        <?php
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
                                        src="https://w.soundcloud.com/player/?url=<?php echo urlencode($arItem["SOUND_CLOUD"]) ?>&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false"
                                ></iframe>
                            </div>
                        <?php
                        }
                        else if ($arItem["SLIDER"] && count($arItem["SLIDER"]) > 1)
                        {
                        ?>
                            <div class="news-list-item-embed-slider">
                                <div class="news-list-slider-container" style="width: <?php
                                echo count($arItem["SLIDER"]) * 100 ?>%;left: 0;">
                                    <?php
                                    foreach ($arItem["SLIDER"] as $file):?>
                                        <div class="news-list-slider-slide">
                                            <img src="<?= $file["SRC"] ?>" alt="<?= $file["DESCRIPTION"] ?>">
                                        </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="news-list-slider-arrow-container-left">
                                    <div class="news-list-slider-arrow"><i class="fa fa-angle-left"></i></div>
                                </div>
                                <div class="news-list-slider-arrow-container-right">
                                    <div class="news-list-slider-arrow"><i class="fa fa-angle-right"></i></div>
                                </div>
                                <ul class="news-list-slider-control">
                                    <?php
                                    foreach ($arItem["SLIDER"] as $i => $file):?>
                                        <li rel="<?= ($i + 1) ?>" <?php
                                        if (!$i)
                                            echo 'class="current"' ?>><span></span></li>
                                    <?php endforeach ?>
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
                        <?php
                        }
                        else if ($arItem["SLIDER"])
                        {
                        ?>
                            <div class="news-list-item-embed-img">
                                <?php if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])) {
                                    ?>
                                    <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                                        <img
                                                class="card-img-top"
                                                src="<?= $arItem["SLIDER"][0]["SRC"] ?>"
                                                width="<?= $arItem["SLIDER"][0]["WIDTH"] ?>"
                                                height="<?= $arItem["SLIDER"][0]["HEIGHT"] ?>"
                                                alt="<?= $arItem["SLIDER"][0]["ALT"] ?>"
                                                title="<?= $arItem["SLIDER"][0]["TITLE"] ?>"
                                        >
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <img
                                            class="card-img-top"
                                            src="<?= $arItem["SLIDER"][0]["SRC"] ?>"
                                            width="<?= $arItem["SLIDER"][0]["WIDTH"] ?>"
                                            height="<?= $arItem["SLIDER"][0]["HEIGHT"] ?>"
                                            alt="<?= $arItem["SLIDER"][0]["ALT"] ?>"
                                            title="<?= $arItem["SLIDER"][0]["TITLE"] ?>"
                                    >
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
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
                                        >
                                    </picture>
                                </a>
                            </figure>
                            <?php
                        }
                        else {
                            ?>
                        <img
                                src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                class="card-img-top"
                                alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                        >
                            <?php
                        }
                        }
                        ?>

                    <?php endif; ?>

                    <div class="card-body">
                        <?php if ($arParams["DISPLAY_DATE"] != "N" && $arItem["DISPLAY_ACTIVE_FROM"]):
                            ?>
                            <div class="news-list-view news-list-post-params">
                                            <span class="news-list-param"><?php echo FormatDate('d F Y', strtotime($arItem["DISPLAY_ACTIVE_FROM"]));//date('d F Y', strtotime($arItem["DISPLAY_ACTIVE_FROM"]))
                                                ?></span>
                                <?php if ($arItem['IBLOCK_SECTION_ID'] != null): ?>
                                    <span class="news-list-item__section-name">
                                                <?= $allSections[$arItem['IBLOCK_SECTION_ID']]['NAME']; ?>
                                                </span>
                                <?php endif; ?>
                            </div>
                        <?php endif ?>

                        <?php if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
                            <h4 class="card-title">
                                <?php if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                                    <a href="<?php echo $arItem["DETAIL_PAGE_URL"] ?>"><?php echo $arItem["NAME"] ?></a>
                                <?php else: ?>
                                    <?php echo $arItem["NAME"] ?>
                                <?php endif; ?>
                            </h4>
                        <?php endif; ?>

                        <?php if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
                            <p class="card-text"><?php echo $arItem["PREVIEW_TEXT"]; ?></p>
                        <?php endif; ?>

                        <div class="news-list-item__btn-wrapper"><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
                                                                    class="btn btn-primary">Читать</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($arItemIterator != 0 && $arItemIterator % 13 == 0): ?>
        </div>
        <div class="row news-list-items-wrapper">
            <?php endif; ?>

            <?php endforeach; ?>

            <?php if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
                <div class="list__pagination col-12">
                    <div class="container">
                        <?= $arResult["NAV_STRING"] ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>


    </div>
</div>