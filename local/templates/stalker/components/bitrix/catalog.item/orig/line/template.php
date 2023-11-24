<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var string $discountPositionClass
 * @var string $labelPositionClass
 * @var CatalogSectionComponent $component
 */

if ($haveOffers)
{
	$showDisplayProps = !empty($item['DISPLAY_PROPERTIES']);
	$showProductProps = $arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $item['OFFERS_PROPS_DISPLAY'];
	$showPropsBlock = $showDisplayProps || $showProductProps;
	$showSkuBlock = $arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && !empty($item['OFFERS_PROP']);
}
else
{
	$showDisplayProps = !empty($item['DISPLAY_PROPERTIES']);
	$showProductProps = $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !empty($item['PRODUCT_PROPERTIES']);
	$showPropsBlock = $showDisplayProps || $showProductProps;
	$showSkuBlock = false;
}
?>

<div class="catalog__item">
    <div class="catalog__item-img">
        <?php if ($item['DETAIL_PICTURE']['SRC']): ?>
            <picture>
                <img data-src="<?=$item['DETAIL_PICTURE']['SRC']?>" alt="" class="lazy"/>
            </picture>
        <?php endif ?>
        <? if ($price['DISCOUNT']): ?>
            <div class="tip tip-sale">
                -<?=$price['PERCENT']?>%
            </div>
        <? endif; ?>
        <??>
        <div class="tip tip-like <?=(in_array($item["ID"], $_SESSION['favourites'])?'is-active':'')?>" data-id="<?=$item["ID"]?>"></div>
        <??>
    </div>
    <div class="catalog__item-description">
        <div class="catalog__item-column">

            <div><a class="catalog__item-name" href="<?=$item['DETAIL_PAGE_URL']?>">
                    <?=$productTitle?>
                </a>
            </div>

            <div class="catalog__item-code">
                АРТ <?=$arProps['CML2_ARTICLE']['VALUE']?:$arProps['ARTNUMBER']['VALUE']?>
            </div>


            <?/*div class="catalog__item-characteristic characteristic">
				<ul class="characteristic__list">
					<?php foreach ($showProperties as $property): ?>
						<?php if($arProps[$property]['VALUE']):?>
							<li class="characteristic__item">
								<div class="characteristic__name">
									<?=$arProps[$property]['NAME']?>
								</div>
								<div class="characteristic__empty"></div>
								<div class="characteristic__value"><?=$arProps[$property]['VALUE']?></div>
							</li>
						<? endif; ?>
					<?php endforeach; ?>
				</ul>
			</div*/?>
            <div class="catalog__item-characteristic characteristic">
                <ul class="characteristic__list">
                    <?php foreach ($item["DISPLAY_PROPERTIES"] as $property): ?>
                        <?php if($property['VALUE']):?>
                            <li class="characteristic__item">
                                <div class="characteristic__name">
                                    <?=$property['NAME']?>
                                </div>
                                <div class="characteristic__empty"></div>
                                <div class="characteristic__value"><?=$property['VALUE']?></div>
                            </li>
                        <? endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="catalog__item-column catalog__item-column_price">
            <div class="price">
                <? if ($price['DISCOUNT']): ?>
                    <div class="price-new"><span class="value"><?=priceFormat( $price['PRICE'] )?></span> ₽</div>
                    <div class="price-old"><span class="value"><?=priceFormat( $price['BASE_PRICE'] )?></span> ₽</div>
                <? else: ?>
                    <div class="price-new"><span class="value"><?=priceFormat( $price['PRICE'] )?></span> ₽</div>
                <? endif; ?>

            </div>

            <div class="catalog__item-buttons">
                <button class="ui-button ui-button--dark" data-add-basket="<?=$item['ID']?>">
                    в корзину
                </button>
                <a href="<?=$item['DETAIL_PAGE_URL']?>" class="ui-button ui-button--light">
                    подробнее
                </a>
                <?
                if (
                    $arParams['DISPLAY_COMPARE']
                    && (!$haveOffers || $arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
                )
                {
                    ?>
                    <div class="product-item-compare-container">
                        <div class="product-item-compare">
                            <div class="checkbox">
                                <label id="<?=$itemIds['COMPARE_LINK']?>">
                                    <input type="checkbox" data-entity="compare-checkbox">
                                    <span data-entity="compare-title"><?=$arParams['MESS_BTN_COMPARE']?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <?
                }
                ?>
            </div>
        </div>
    </div>
    <div class="dot dot--top-left"></div>
    <div class="dot dot--top-right"></div>
    <div class="dot dot--bottom-left"></div>
    <div class="dot dot--bottom-right"></div>
</div>
