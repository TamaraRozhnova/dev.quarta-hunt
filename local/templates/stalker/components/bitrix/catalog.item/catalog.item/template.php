<?php if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
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
$showProperties = $arResult['SHOW_PROPS'];
$arProps = $arItem['PROPERTIES'];
if ($arItem['ITEM_PRICES'] )
{
	$arPrice = reset( $arItem['ITEM_PRICES'] );
}
if (!$arItem['DETAIL_PICTURE']['SRC'])
{
	$arItem['DETAIL_PICTURE']['SRC'] = SITE_TEMPLATE_PATH . '/img/no-photo.png';
}
?>
<div class="catalog__item">
	<div class="catalog__item-img">
		<?php if ($arItem['DETAIL_PICTURE']['SRC']): ?>
			<picture>
				<img data-src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="" class="lazy"/>
			</picture>
		<?php endif ?>
		<? if ($arPrice['DISCOUNT']): ?>
			<div class="tip tip-sale">
				-<?=$arPrice['PERCENT']?>%
			</div>
		<? endif; ?>
	</div>
	<div class="catalog__item-description">
		<div class="catalog__item-column">
				<div class="catalog__item-code">
				арт <?=$arProps['CML2_ARTICLE']['VALUE']?:$arProps['ARTNUMBER']['VALUE']?>
			</div>

			<a class="catalog__item-name" href="<?=$arItem['DETAIL_PAGE_URL']?>" style="color:#2a2b2b">
				<?=$arItem['NAME']?>
			</a>

			<div class="catalog__item-characteristic characteristic">
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
			</div>
		</div>
		<div class="catalog__item-column catalog__item-column_price">
			<div class="price">
				<? if ($arPrice['DISCOUNT']): ?>
					<div class="price-new"><span class="value"><?=priceFormat( $arPrice['PRICE'] )?></span> ₽</div>
					<div class="price-old"><span class="value"><?=priceFormat( $arPrice['BASE_PRICE'] )?></span> ₽</div>
				<? else: ?>
					<div class="price-new"><span class="value"><?=priceFormat( $arPrice['PRICE'] )?></span> ₽</div>
				<? endif; ?>

			</div>

			<div class="catalog__item-buttons">
				<button class="ui-button ui-button--dark" data-add-basket="<?=$arItem['ID']?>">
					в корзину
				</button>
				<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="ui-button ui-button--transparent">
					подробнее
				</a>
			</div>
		</div>
	</div>
	<div class="dot dot--top-left"></div>
	<div class="dot dot--top-right"></div>
	<div class="dot dot--bottom-left"></div>
	<div class="dot dot--bottom-right"></div>
</div>
