<?php

use Spro\Image;

if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global \CMain $APPLICATION */
/** @global \CUser $USER */
/** @global \CDatabase $DB */
/** @var \CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var array $templateData */
/** @var \CBitrixComponent $component */
$this->setFrameMode( true );

$arItem = $arResult['ITEM'];
$arProps = $arItem['PROPERTIES'];
$arPrice = reset($arItem['ITEM_PRICES']);
?>
<div class="catalog__item">
	<div class="catalog__item-img">
		<?
        $img = [];
        if(isset($arItem['DETAIL_PICTURE']) && isset($arItem['DETAIL_PICTURE']['ID']))
            $img = Image::ResizeImageGet($arItem['DETAIL_PICTURE']['ID']??0,  [ 'width' => 421, 'height' => 280 ]);
		if(!$img['src'])
		{
			$img['src'] = SITE_TEMPLATE_PATH . '/img/no-photo.png';
		}
?>

		<?php if ($img['src']): ?>
            <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                <picture>
                    <img data-src="<?=$img['src']?>" alt="" class="lazy"/>
                </picture>
            </a>
		<?php endif ?>

		<?if($arPrice['DISCOUNT']):?>
			<div class="tip tip-sale">
				-<?=$arPrice['PERCENT']?>%
			</div>
		<?endif;?>
	</div>
	<div class="catalog__item-description">
		<div class="catalog__item-column">
				<div class="catalog__item-code">
				арт <?=$arProps['CML2_ARTICLE']['VALUE']?:$arProps['ARTNUMBER']['VALUE']?>
			</div>

			<a class="catalog__item-name" href="<?=$arItem['DETAIL_PAGE_URL']?>">
				<?=$arItem['NAME']?>
			</a>
		</div>
		<div class="catalog__item-column catalog__item-column_price">
			<div class="price">
				<?if($arPrice['DISCOUNT']):?>
					<div class="price-new"><span class="value"><?=priceFormat($arPrice['PRICE'])?></span> ₽</div>
					<div class="price-old"><span class="value"><?=priceFormat($arPrice['BASE_PRICE'])?></span> ₽</div>
				<?else:?>
					<div class="price-new"><span class="value"><?=priceFormat($arPrice['PRICE'])?></span> ₽</div>
				<?endif;?>
			</div>

			<div class="catalog__item-buttons">
				<button class="ui-button ui-button--dark" data-add-basket="<?=$arItem['ID']?>">
					в корзину
				</button>
				<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="ui-button ui-button--transparent">
                    Подробнее о товаре
				</a>
			</div>
		</div>
	</div>

</div>
