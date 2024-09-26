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
    <div class="filters-sort">

        <button class="filters-sort__btn">
            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 2.57143H15.3643C15.0429 1.09286 13.7571 0 12.2143 0C10.6714 0 9.38571 1.09286 9.06429 2.57143H0V3.85714H9.06429C9.38571 5.33571 10.6714 6.42857 12.2143 6.42857C13.7571 6.42857 15.0429 5.33571 15.3643 3.85714H18V2.57143ZM12.2143 5.14286C11.1214 5.14286 10.2857 4.30714 10.2857 3.21429C10.2857 2.12143 11.1214 1.28571 12.2143 1.28571C13.3071 1.28571 14.1429 2.12143 14.1429 3.21429C14.1429 4.30714 13.3071 5.14286 12.2143 5.14286Z" fill="#333333" />
                <path d="M0 12.8571H2.63571C2.95714 14.3357 4.24286 15.4286 5.78571 15.4286C7.32857 15.4286 8.61429 14.3357 8.93571 12.8571H18V11.5714H8.93571C8.61429 10.0929 7.32857 9 5.78571 9C4.24286 9 2.95714 10.0929 2.63571 11.5714H0V12.8571ZM5.78571 10.2857C6.87857 10.2857 7.71429 11.1214 7.71429 12.2143C7.71429 13.3071 6.87857 14.1429 5.78571 14.1429C4.69286 14.1429 3.85714 13.3071 3.85714 12.2143C3.85714 11.1214 4.69286 10.2857 5.78571 10.2857Z" fill="#333333" />
            </svg>
        </button>
    </div>

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
