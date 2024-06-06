<div class="checkout__composition characteristic">
	<ul class="characteristic__list">
		<li class="characteristic__item">
			<div class="characteristic__name"> Товары</div>
			<div class="characteristic__empty"></div>
			<div class="characteristic__value"><?=priceFormat($arResult[ "JS_DATA" ][ "TOTAL" ][ "PRICE_WITHOUT_DISCOUNT_VALUE" ])?> ₽</div>
		</li>
		<li class="characteristic__item">
			<div class="characteristic__name">Скидка</div>
			<div class="characteristic__empty"></div>
			<div class="characteristic__value"><?=priceFormat($arResult[ "JS_DATA" ][ "TOTAL" ][ "DISCOUNT_PRICE" ])?> ₽</div>
		</li>
		<li class="characteristic__item">
			<div class="characteristic__name">Доставка</div>
			<div class="characteristic__empty"></div>
			<div class="characteristic__value"><?=priceFormat($arResult[ "JS_DATA" ][ "DELIVERY" ][ $deliveryChecked ][ "PRICE" ])?> ₽</div>
		</li>
	</ul>

	<div class="checkout__total">
		<div class="checkout__total-text">
			Итого к оплате
		</div>
		<div class="checkout__total-value">
			<span class="value"><?=priceFormat($arResult[ "ORDER_TOTAL_PRICE" ])?></span> ₽
		</div>
	</div>
</div>

<button class="ui-button ui-button--red make-order" type="button" data-create-order>
	Сделать заказ
</button>

<div class="policy">
	Завершая оформление заказа, я даю свое согласие <a href="/politic/">на обработку персональных
		данных</a> и
	подтверждаю ознакомление со сроками хранения товара в соответствии с указанными здесь
	условиями.
</div>
