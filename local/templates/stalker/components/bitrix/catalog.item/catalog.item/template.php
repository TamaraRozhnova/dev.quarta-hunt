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

//use \Bitrix\Sale\Basket;
use Bitrix\Sale;

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

//echo_j($arItem, '$arItem');
?>
<div class="catalog__item">
	<div class="catalog__item-img">
		<?php if ($arItem['DETAIL_PICTURE']['SRC']): ?>
        <a class="catalog__item-name" href="<?=$arItem['DETAIL_PAGE_URL']?>">
			<picture>
				<img data-src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="" class="lazy"/>
			</picture>
        </a>
		<?php endif ?>
		<? if ($arPrice['DISCOUNT']): ?>
			<div class="tip tip-sale">
				-<?=$arPrice['PERCENT']?>%
			</div>
		<? endif; ?>
        <??>
        <div class="tip tip-fav <?=(in_array($arItem["ID"], (array)$_SESSION['favourites'])?'is-active':'')?>" data-id="<?=$arItem["ID"]?>"></div>
        <??>
	</div>
	<div class="catalog__item-description">
		<div class="catalog__item-column">

			<div><a class="catalog__item-name" href="<?=$arItem['DETAIL_PAGE_URL']?>">
				<?=$arItem['NAME']?>
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
					<?php foreach ($arItem["DISPLAY_PROPERTIES"] as $property): ?>
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
				<? if ($arPrice['DISCOUNT']): ?>
					<div class="price-new"><span class="value"><?=priceFormat( $arPrice['PRICE'] )?></span> ₽</div>
					<div class="price-old"><span class="value"><?=priceFormat( $arPrice['BASE_PRICE'] )?></span> ₽</div>
				<? else: ?>
					<div class="price-new"><span class="value"><?=priceFormat( $arPrice['PRICE'] )?></span> ₽</div>
				<? endif; ?>

			</div>

			<div class="catalog__item-buttons">
                <?if($arItem['CAN_BUY']){?>
                    <button class="ui-button ui-button--dark" data-add-basket="<?=$arItem['ID']?>">
                        в корзину
                    </button>
                <?}else{?>
                    <button class="ui-button ui-button--light" disabled="disabled">
                        нет в наличии
                    </button>
                <?}?>
				<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="ui-button ui-button--light">
					подробнее
				</a>
				<a href="#" class="ui-button ui-button--light add2compare tip-compare" data-id="<?=$arItem["ID"]?>">
					<span class="nactive">Сравнить</span>
                    <span class="active">Добавлено для сравнения</span>
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
                                <label id="<?=$arItem['COMPARE_LINK']?>">
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
