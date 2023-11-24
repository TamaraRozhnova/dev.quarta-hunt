<div class="cart-page">
	<div class="cart-page__finish">
		<div class="order-finish">
			<div class="order-finish__content">
				<div class="order-finish__content-inner">
					<h2 class="order-finish__title">Благодарим Вас, за выбор<br> нашего интернет&#8209;магазина!</h2>
					<div class="order-finish__num">Номер вашего заказа:
						<b><?=$arResult['ORDER']['ACCOUNT_NUMBER']?></b></div>
					<?php
					if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y')
					{
					if ( !empty( $arResult["PAYMENT"] ))
					{
					foreach ($arResult["PAYMENT"] as $payment)
					{
					if ($payment["PAID"] != 'Y')
					{
					if ( !empty( $arResult['PAY_SYSTEM_LIST'] )
						&& array_key_exists( $payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'] )
					)
					{
						$arPaySystem = $arResult['PAY_SYSTEM_LIST'][ $payment["PAY_SYSTEM_ID"] ];

					if (empty( $arPaySystem["ERROR"] ))
					{
						?>

						<?php if (mb_strlen( $arPaySystem["ACTION_FILE"] ) > 0 && $arPaySystem["NEW_WINDOW"] == "Y" &&
						$arPaySystem["IS_CASH"] != "Y"): ?>
						<?php
						$orderAccountNumber = urlencode( urlencode( $arResult["ORDER"]["ACCOUNT_NUMBER"] ) );
						$paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
						?>
						<script>window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');</script>
					<?=Loc::getMessage( "SOA_PAY_LINK", [
						"#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&PAYMENT_ID=" . $paymentAccountNumber,
					] )?>
					<?php if ( CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF'] ): ?>
					<br/>
					<?=Loc::getMessage( "SOA_PAY_PDF", [
						"#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&pdf=1&DOWNLOAD=Y",
					] )?>
					<?php endif ?>
					<?php else: ?>
						<?=$arPaySystem["BUFFERED_OUTPUT"]?>
					<?php endif ?>

					<?php
					} else
					{
					?>
						<span style="color:red;"><?=Loc::getMessage( "SOA_ORDER_PS_ERROR" )?></span>
					<?php
					}
					} else
					{
					?>
						<span style="color:red;"><?=Loc::getMessage( "SOA_ORDER_PS_ERROR" )?></span>
					<?php
					}
					}
					}
					}
					} else
					{
					?>
					<br/><strong><?=$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']?></strong>
						<?php
					}
					?>
					<style>
						.order-finish__content-inner{
							font-family: sans-serif;
							/*font-size: 15;*/
						}
						.order-finish__content-inner [type="submit"],
						.order-finish__content-inner button{
							font-family: "Micra",sans-serif;
							display: flex;
							justify-content: center;
							align-items: center;
							width: 100%;
							font-size: 11px;
							line-height: 1.1;
							letter-spacing: -.05em;
							transition: background-color .35s ease,color .15s ease;
							color: #fff;
							border: 0;
							border-radius: 0 !important;
							background-color: #b20e04;
							max-width: 300px;
							height: 57px;
							margin-top: 30px;
							margin-bottom: 30px;
						}
					</style>
				</div>
			</div>
		</div>
	</div>
</div>
