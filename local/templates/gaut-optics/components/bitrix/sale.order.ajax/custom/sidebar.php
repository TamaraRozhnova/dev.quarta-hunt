<?php
$resultQuality = 0;
foreach ($arResult['BASKET_ITEMS'] as $item)
{
	$resultQuality += $item[ "QUANTITY" ];
}
?>
<div class="checkout__right">
	<div class="checkout__info">
		<div class="section__title">
			В заказе
		</div>

		<div class="checkout__info-block">
			<div class="checkout__total">
				<div class="checkout__total-text">
					В заказе <?=$resultQuality?> товара
				</div>
				<div class="checkout__total-value">
					<span class="value"><?=priceFormat($arResult[ "ORDER_PRICE" ])?></span> руб
				</div>
			</div>

			<?php foreach ($arResult['BASKET_ITEMS'] as $index => $item): ?>
				<div class="checkout__product">
					<div class="checkout__product-name">
						<?=$item['NAME']?>
					</div>
					<div class="checkout__product-info">
						<?=$item[ "QUANTITY" ]?> шт. x <?=priceFormat($item[ "PRICE" ])?> ₽
						<?php if ($item[ "DISCOUNT_PRICE" ]): ?>
							<span class="price-old"><?=priceFormat($item[ "BASE_PRICE" ])?> ₽ </span>
						<?php endif ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
