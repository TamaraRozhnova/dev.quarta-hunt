<?php

$isSelf = true;
$firstDelivery = $deliveryChecked = $selfId = 3;

?>
<? foreach ($arResult["DELIVERY"] as $arDelivery):
	$selfId = !empty( $arDelivery['STORE'] )?$arDelivery["ID"]:$selfId;
	$firstDelivery = empty( $arDelivery['STORE'] )?$arDelivery["ID"]:$firstDelivery;
	if ($arDelivery["CHECKED"] == "Y"):
		$deliveryChecked = $arDelivery["ID"];
		$isSelf = !empty( $arDelivery['STORE'] );
		?>
		<input type="hidden" name="DELIVERY_ID" class="delivery_id" value="<?=$arDelivery["ID"]?>">
	<? endif;
endforeach ?>
<?php
$activeTab = ( $deliveryChecked == $selfId )?'self':'delivery';

?>

<div class="checkout__block-title">
	Где и как вы хотите получить заказ?
</div>

<?
//echo_j([$selfId, $arResult['DELIVERY'][ $selfId ]]);
?>

<div class="checkout__tabs tabs" data-tabs>
	<div class="tabs__head" data-tabs-head>
		<? if ($selfId): ?>
			<?
			$arDelivery = $arResult['DELIVERY'][ $selfId ];
			?>
			<label class="tabs__item<?php if ($activeTab == 'self'): ?> is-active<?php endif ?>" data-tabs-item="self">
				<input type="radio" value="self" name="delivery" <?php if ($activeTab == 'self'): ?> checked<?php endif ?> data-delivery="<?=$arDelivery['ID']?>"/>
				<span class="ui-radio"></span>
				<span class="ui-radio__content">
					<span class="ui-radio__name">
						<?=$arDelivery['NAME'];?>
					</span>
					<span class="ui-radio__desc">
						<?=$arDelivery['DESCRIPTION'];?>
					</span>
				</span>
			</label>
		<? endif; ?>
		<?php if ($selfId && count( $arResult['DELIVERY'] ) > 1): ?>
			<label class="tabs__item<?php if ($activeTab == 'delivery'): ?> is-active<?php endif ?>" data-tabs-item="delivery">
				<input type="radio" value="delivery" name="delivery" <?php if ($activeTab == 'delivery'): ?> checked<?php endif ?> data-delivery="<?=$firstDelivery?>"/>
				<span class="ui-radio"></span>
				<span class="ui-radio__content">
					<span class="ui-radio__name">
						Доставка
					</span>
					<span class="ui-radio__desc"></span>
				</span>
			</label>
		<?php endif ?>
	</div>
	<div class="tabs__body" data-tabs-body>
		<div class="tabs__content<?php if ($activeTab == 'self'): ?> is-active<?php endif ?>" data-tabs-content="self">
			<?php include 'store_list.php' ?>
		</div>
		<div class="tabs__content<?php if ($activeTab == 'delivery'): ?> is-active<?php endif ?>" data-tabs-content="delivery">
			<div class="checkout__choose-delivery">

				<?php foreach ($arResult['DELIVERY'] as $index => $arDelivery): ?>
					<? if ($arDelivery['ID'] == $selfId)
					{
						continue;
					} ?>
					<label class="checkout__label">
						<input type="radio" name="del" value="<?=$arDelivery['ID']?>"
							<?php if ($arDelivery["CHECKED"] == "Y"): ?> checked<?php endif ?> data-delivery-id="<?=$arDelivery['ID']?>"/>
						<span class="ui-radio"></span>
						<span class="checkout__choose-delivery__text">
    						<?=$arDelivery['NAME'];?>
    					</span>
					</label>
				<?php endforeach; ?>
			</div>
			<?php include 'delivery_props.php' ?>

		</div>
	</div>
</div>
<script>

</script>
