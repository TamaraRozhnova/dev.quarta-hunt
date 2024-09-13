<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<?if (!empty($arParams['OTHER_DATA']['OTHER_DATA_SLIDER'])):?>
    <div class="wide-promotion__wrapper bg-gray-200">
        <div class="wide-promotion">
            <div
                class="wide-promotion__image"
                style="background-image: url(<?=reset($arParams['OTHER_DATA']['OTHER_DATA_SLIDER'])['SECTION_PICTURE']?>">

            </div>
            <div class="wide-promotion__content-backdrop"></div>

            <div class="wide-promotion__body">
                <div class="container">
                    <div class="row">
                        <a href="<?=reset($arParams['OTHER_DATA']['OTHER_DATA_SLIDER'])['SECTION_PAGE_URL']?>" class="col-12 col-md-6" >
                            <div  class="promo-wide-image-text promo-wide-image-text--light">
                                <p></p>
                            </div>
                        </a>
                        <div class="col-12 col-md-6 pt-4">
                            <div class="base-slider" >
                                <div class="">
                                    <div class="swiper swiper-container swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">
                                        <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                                            <?foreach ($arParams['OTHER_DATA']['OTHER_DATA_SLIDER'] as $arSlide):?>
                                                <div class="swiper-slide swiper-slide-active" style="width: 640px; margin-right: 20px;">
                                                    <div class="promo-product-slide">
                                                        <div class="row promo-product-slide__top">
                                                            <div class="col-6">
                                                                <h3 class="promo-product-slide__title">
                                                                    <?=$arSlide['NAME']?>
                                                                    <b>
                                                                        <?=$arSlide['NAME_BOLD']?>
                                                                    </b>
                                                                </h3>
                                                                <p>
                                                                    <?=$arSlide['PREVIEW_TEXT']?>
                                                                </p>
                                                            </div>
                                                            <div class="col-6 promo-product-slide__image">
                                                                <figure>
                                                                    <img loading="lazy" src="<?=\CHTTP::urnEncode(CFile::ResizeImageGet($arSlide['PREVIEW_PICTURE_ID'], array('width' => 255, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true)['src'], 'UTF-8')?>" alt="<?=$arSlide['NAME']?>" >
                                                                </figure>
                                                            </div>
                                                        </div>
                                                        <div class="row promo-product-slide__bottom">
                                                            <div class="col-6 promo-product-slide__actions">
                                                                <a href="<?=$arSlide['URL']?>" class="btn btn-primary btn-lg px-5">
                                                                    Подробнее
                                                                </a>
                                                            </div>
                                                            <div class="col-6 promo-product-slide__price">
                                                                <div class="promo-product-slide__price-new">
                                                                    <?=$arSlide['PRODUCT_PRICE']?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?endforeach;?>
                                        </div>
                                        <div class="swiper-scrollbar" style="display: none;">
                                            <div class="swiper-scrollbar-drag" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms; width: 0px;"></div>
                                        </div>
                                        <div class="base-slider__arrows">
                                            <div class="base-slider__prev"></div>
                                            <div class="base-slider__next"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
<?endif;?>

<section class="promo-grid">
    <div class="container">

        <div class="row">
            <?if (!empty($arParams['OTHER_DATA']['OTHER_DATA_PROMO'])):?>
                <div class = "promo-grid__banner col-12 col-md-6">
                    <a href="<?=$arParams['OTHER_DATA']['OTHER_DATA_PROMO']['URL']?>" class="promo-card promo-card--background-image promo-card--large promo-card--stretch">
                        <figure style='background-image: url("<?=$arParams['OTHER_DATA']['OTHER_DATA_PROMO']['PICTURE']?>");'>

                        </figure>
                        <h3>
                            <?=$arParams['OTHER_DATA']['OTHER_DATA_PROMO']['MB_TITLE_FOR_PROMO']?>
                        </h3>
                        <p>
                            <?=$arParams['OTHER_DATA']['OTHER_DATA_PROMO']['MB_DESC_FOR_PROMO']?>
                        </p>
                    </a>
                </div>
            <?endif;?>

            <?if (!empty($arResult['ITEMS'])):?>
                <?$counter;?>
                <?foreach ($arResult['ITEMS'] as $arItemIndex => $arItem):?>

                        <? $APPLICATION->IncludeComponent(
                            'bitrix:catalog.item',
                            'main',
                            array(
                                'RESULT' => array(
                                    'ITEM' => $arItem,
                                    'PARAMS' => $arParams
                                ),
                            ),
                            $component
                        ); ?>

                    <?$counter++?>

                    <?if ($counter % 2 == 0 && $counter > 0 && $counter < 3):?>
                        </div>
                        <div class="row">
                    <?endif;?>

                <?endforeach;?>
            <?endif;?>

            <?if (!empty($arParams['OTHER_DATA']['OTHER_DATA_SECTION_CATALOG'])):?>
                <div class="promo-grid__banner col-12 col-md-6">
                    <a  href="<?=$arParams['OTHER_DATA']['OTHER_DATA_SECTION_CATALOG']['URL']?>" class="promo-card promo-card--large">
                        <figure>
                            <img loading="lazy" src="<?=$arParams['OTHER_DATA']['OTHER_DATA_SECTION_CATALOG']['PICTURE']?>" alt="PICTURE">
                        </figure>
                        <h3>
                            <?=$arParams['OTHER_DATA']['OTHER_DATA_SECTION_CATALOG']['MB_TITLE_FOR_SECTION_CATALOG']?>
                        </h3>
                        <p>
                            <?=$arParams['OTHER_DATA']['OTHER_DATA_SECTION_CATALOG']['MB_DESC_FOR_SECTION_CATALOG']?>
                        </p>
                    </a>
                </div>

            <?endif;?>
        </div>

    </div>
</section>
