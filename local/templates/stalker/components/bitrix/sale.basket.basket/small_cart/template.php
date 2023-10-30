<? if ( !defined( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true) die();

$q = 0;
?>

<div class="modal__inner" data-modal-inner="cart">
	<div class="modal__header">
		<div class="section__title"> Корзина</div>
		<div class="modal__header-close" data-modal-close="cart">
			<svg class="icon icon-close">
				<use xlink:href="/bitrix/templates/stalker/img/sprite.svg#icon-close"></use>
			</svg>
		</div>
	</div>
	<div class="modal-cart__content">
		<div class="modal-cart__list">
			<?php foreach ($arResult['ITEMS']['AnDelCanBuy'] as $index => $arItem):
				$q+= $arItem['QUANTITY'];
				?>
				<div class="modal-cart__item">
					<div class="modal-cart__item-img">
						<picture>
							<img src="<?=$arItem['DETAIL_PICTURE_SRC']?>" alt="">
						</picture>
						<div class="dot dot--top-left"></div>
						<div class="dot dot--top-right"></div>
						<div class="dot dot--bottom-right"></div>
						<div class="dot dot--bottom-left"></div>
					</div>
					<div class="modal-cart__item-content">
						<div class="modal-cart__item-name"><?=$arItem['NAME']?></div>
						<div class="modal-cart__item-price">
							<div class="price">
								<?if($arItem['DISCOUNT_PRICE']):?>
									<div class="price-new">
										<span class="value"><?=priceFormat($arItem['PRICE'])?></span> ₽
									</div>
									<div class="price-old">
										<span class="value"><?=priceFormat($arItem['FULL_PRICE'])?></span> ₽
									</div>
								<?else:?>
									<div class="price-new">
										<span class="value"><?=priceFormat($arItem['PRICE'])?></span> ₽
									</div>
								<?endif;?>
							</div>
						</div>
					</div>
					<div class="modal-cart__remove" data-delete-basket="<?=$arItem['ID']?>">
						<svg class="icon icon-close">
							<use xlink:href="/bitrix/templates/stalker/img/sprite.svg#icon-close"></use>
						</svg>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="modal-cart__total">
		<div class="modal-cart__total-content">
			<div class="modal-cart__total-text">Итого к оплате:</div>
			<div class="modal-cart__total-value">
				<div class="price-new">
					<span class="value"><?=priceFormat($arResult['allSum'])?></span> ₽
				</div>
			</div>
		</div>
		<a href="/personal/cart/" class="ui-button ui-button--red"> Перейти к оформлению</a>
	</div>
</div>

<? $this->SetViewTarget( 'BASKET_PRODUCT_COUNT' ); ?>
<?= $q ?>
<? $this->EndViewTarget(); ?>
