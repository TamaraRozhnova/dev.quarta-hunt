<?/*?>
<script src="https://api-maps.yandex.ru/2.1/?apikey=f8d1318f-e2d1-48cd-b79a-2f0bfe1543f6&lang=ru_RU" type="text/javascript"></script>
<?*/?>
<?php foreach ($arResult['STORE_LIST'] as $index => $arStore): ?>
	<div class="checkout__map">
		<div class="checkout__map-left">
			<div class="checkout__map-title">
				<label class="checkout__label" for="BUYER_STORE-<?=$arStore['ID']?>">
					<input id="BUYER_STORE-<?=$arStore['ID']?>" type="radio" value="<?=$arStore['ID']?>"
						<?php if ($arResult['BUYER_STORE'] == $arStore['ID']): ?> checked<?php endif ?> name="BUYER_STORE"/>
					<span class="ui-radio"></span>
					<span class="checkout__choose-delivery__text">
						<?=$arStore['ADDRESS']?>
					</span>
				</label>
			</div>

			<div class="checkout__map-block">
				<div class="checkout__map-block__name">Время работы магазина:</div>
				<div class="checkout__map-block__desc">
					<?=$arStore['SCHEDULE']?>
				</div>
			</div>

			<div class="checkout__map-block">
				<div class="checkout__map-block__name">Телефон:</div>
				<div class="checkout__map-block__desc">
					<?=$arStore['PHONE']?>
				</div>
			</div>
		</div>
		<div class="checkout__map-right" style="margin-bottom: 30px;">
			<div class="map">
				<?$APPLICATION->IncludeFile(
					'/_includes/order/self_map.php',
					[
						'ID' => $arStore['ID'],
						'GPS_N' => $arStore['GPS_N'],
						'GPS_S' => $arStore['GPS_S'],
						'ADDRESS' => $arStore['ADDRESS'],
					],
					[
						'SHOW_BORDER' => false,
					]
				);?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
