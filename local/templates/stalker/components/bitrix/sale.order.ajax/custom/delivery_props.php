<div class="checkout__personal">
	<div class="checkout__block-title">
		Укажите адрес доставки
	</div>
	<div class="checkout__block-subtitle">
		Пожалуйста, введите свою контактную информацию для доставки
	</div>

	<div class="checkout__personal-grid">
		<? foreach ($arResult['JS_DATA']["ORDER_PROP"]["properties"] as $index => $field): ?>
			<?
			if ($field['PROPS_GROUP_ID'] == 12)
			{
				\Spro\Dom::showField( $field );
			}
			?>
		<?php endforeach; ?>

		<div class="ui-block">
			<div class="ui-block__placeholder">
				Комментарий к адресу
			</div>
			<label class="ui-label">
				<textarea class="ui-input" name="ORDER_DESCRIPTION" placeholder="Укажите дополнительную информацию, чтобы курьеру было проще найти ваш адрес"></textarea>
			</label>
		</div>
	</div>
</div>
