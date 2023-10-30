<div class="checkout__personal">
	<div class="checkout__block-title">
		Укажите контакты получателя
	</div>
	<div class="checkout__block-subtitle">
		Пожалуйста, введите свою контактную информацию для доставки
	</div>

	<div class="checkout__personal-grid">
		<? foreach ($arResult['JS_DATA']["ORDER_PROP"]["properties"] as $index => $field): ?>
			<?
			if ($field['PROPS_GROUP_ID'] == 10)
			{
				\Spro\Dom::showField( $field);
			}
			?>
		<?php endforeach; ?>
	</div>
</div>
