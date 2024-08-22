<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

global $USER; ?>

<? if ($arParams["AJAX"] == 'Y'): ?>

	<script type="text/javascript">
		BX.ready(function() {
			var arBonus_<?= $arParams["RAND"] ?> = <?= CUtil::PhpToJSObject($arResult, false, true) ?>;
			BX.ajax({
				url: '<?= $componentPath ?>/ajax.php',
				method: 'POST',
				data: arBonus_<?= $arParams["RAND"] ?>,
				dataType: 'json',
				onsuccess: function(result) {
					console.log(result);
					for (id in result.ITEMS) {
						var item = result.ITEMS[id];
						if (BX('lb_ajax_' + id) && item.ADD_BONUS > 0)
							BX.adjust(BX('lb_ajax_' + id), {
								text: '+' + item.ADD_BONUS + ' ' + result.TEXT.TEXT_BONUS_FOR_ITEM
							});
					}
				}
			});
		});
	</script>

<? else: ?>

	<script>
		BX.ready(function() {

			const isAuth = '<?= $USER->isAuthorized() ?: false; ?>';

			let bonusText,
				bonusValue;

			if (isAuth) {
				bonusText = '<?= GetMessage("BONUS_INFO") ?>';
			} else {
				bonusText = '<?= GetMessage("BONUS_INFO_NOAUTH") ?>';
				bonusValue = '<?= GetMessage("BONUS_INFO_NOAUTH_VALUE") ?>';
			}

			var arBonus_<?= $arParams["RAND"] ?> = <?= CUtil::PhpToJSObject($arResult["ITEMS_BONUS"], false, true) ?>;

			for (id in arBonus_<?= $arParams["RAND"] ?>) {
				var item = arBonus_<?= $arParams["RAND"] ?>[id];
				if (BX('lb_ajax_' + id) && item.VIEW_BONUS > 0) {

					if (isAuth) {
						bonusValue = `+${item.VIEW_BONUS} <?= COption::GetOptionString("logictim.balls", "TEXT_BONUS_FOR_ITEM", '') ?>`
					}

					BX.adjust(BX('lb_ajax_' + id), {
						html: `
							<span class="product__bonus-balls">${bonusValue}</span>
							<span class="product__bonus-text">${bonusText}</span>
							<div class="bonus-catalog-icon__wrapper ${!isAuth ? 'active' : null}">
								<span class="bonus-catalog-icon__text">
									<?=GetMessage('BONUS_CALCULATE_NOAUTH')?>
								</span>
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
									<path d="M8 16C10.1217 16 12.1566 15.1571 13.6569 13.6569C15.1571 12.1566 16 10.1217 16 8C16 5.87827 15.1571 3.84344 13.6569 2.34315C12.1566 0.842855 10.1217 0 8 0C5.87827 0 3.84344 0.842855 2.34315 2.34315C0.842855 3.84344 0 5.87827 0 8C0 10.1217 0.842855 12.1566 2.34315 13.6569C3.84344 15.1571 5.87827 16 8 16ZM8.93 6.588L7.93 11.293C7.86 11.633 7.959 11.826 8.234 11.826C8.428 11.826 8.721 11.756 8.92 11.58L8.832 11.996C8.545 12.342 7.912 12.594 7.367 12.594C6.664 12.594 6.365 12.172 6.559 11.275L7.297 7.807C7.361 7.514 7.303 7.408 7.01 7.337L6.559 7.256L6.641 6.875L8.931 6.588H8.93ZM8 5.5C7.73478 5.5 7.48043 5.39464 7.29289 5.20711C7.10536 5.01957 7 4.76522 7 4.5C7 4.23478 7.10536 3.98043 7.29289 3.79289C7.48043 3.60536 7.73478 3.5 8 3.5C8.26522 3.5 8.51957 3.60536 8.70711 3.79289C8.89464 3.98043 9 4.23478 9 4.5C9 4.76522 8.89464 5.01957 8.70711 5.20711C8.51957 5.39464 8.26522 5.5 8 5.5Z" fill="#808D9A"/>
								</svg>
							</div>
						`
					});
				}
			}

		});
	</script>


<? endif; ?>