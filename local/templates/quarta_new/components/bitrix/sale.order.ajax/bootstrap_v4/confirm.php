<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Sale;
use Bitrix\Main\Loader;

Loader::includeModule('sale');

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y"){
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}

/**
 * Получаем заказ, корзину пользователя
 * Проверяем каждый товар на 
 * принадлежность к разделам "Обувь" и "Одежда"
 * 
 * В случае если принадлежит - убираем кнопку оплаты
 */

if (!empty($arResult['ORDER_ID'])) {
	$rsBasket = Sale\Order::load($arResult['ORDER_ID'])->getBasket()->getBasketItems();

	foreach ($rsBasket as $arProductIndex => $arProduct) { 

		$rsSectionsEl = CIBlockElement::GetElementGroups($arProduct->getProductId(), true)->fetch();

		if (empty($rsSectionsEl)) {

			/**
			 * Проверка на торговое предложение
			 */

			$productInfo = CCatalogSku::GetProductInfo(
				$arProduct->getProductId()
			);

			$rsSectionsEl = CIBlockElement::GetElementGroups($productInfo['ID'], true)->fetch();
		}

		$rsPath = CIBlockSection::GetNavChain(false, $rsSectionsEl['ID']); 

		while ($arPath = $rsPath->GetNext()) {
			$sectionIds[$arPath['ID']] = $arPath['ID']; 
		}
		
	}



	if (!empty($sectionIds)) {

		$entSections = \Bitrix\Iblock\Model\Section::compileEntityByIblock(CATALOG_IBLOCK_ID);

		$rsSections = $entSections::getList(array(
			"filter" => array(
				"IBLOCK_ID" => CATALOG_IBLOCK_ID, 
				"ACTIVE" => "Y",
				"GLOBAL_ACTIVE" => "Y",
				"ID" => $sectionIds
			),
			"select" => array("NAME", "CODE"),
		))->fetchAll();

		if (!empty($rsSections)) {
			foreach ($rsSections as $arSection) {

				if (
					$arSection['CODE'] == 'odezhda'
					||
					$arSection['CODE'] == 'obuv'
					||
					$arSection['CODE'] == 'oruzhie_i_patrony'
				) {
					$arResult['HIDE_BUTTON_PAYMENT'] = 'Y';
					break;
				}

				continue;

			}
		}

	}

}

?>
<div id="bx-soa-order-form">
<div class="container">
<div class="bx-soa-section confirm"> 
<? if (!empty($arResult["ORDER"])): ?>

	<div class="mb-5">
		<div class="col">
			<p><?=Loc::getMessage("SOA_ORDER_SUC", array(
				"#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i'),
				"#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
			))?>
			<? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
				<?=Loc::getMessage("SOA_PAYMENT_SUC", array(
					"#PAYMENT_ID#" => $arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER']
				))?></p>
			<? endif ?>
		</div>
	</div>

	<? if ($arParams['NO_PERSONAL'] !== 'Y'): ?>
		<div class="mb-3">
			<div class="col">
			<p><?=Loc::getMessage('SOA_ORDER_SUC1', ['#LINK#' => $arParams['PATH_TO_PERSONAL']])?></p>
			</div>
		</div>
	<? endif; ?>

	<?

	if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y')
	{
		if (!empty($arResult["PAYMENT"]))
		{
			foreach ($arResult["PAYMENT"] as $payment)
			{
				if ($payment["PAID"] != 'Y')
				{
					if (!empty($arResult['PAY_SYSTEM_LIST'])
						&& array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
					)
					{
						$arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

						if (empty($arPaySystem["ERROR"]))
						{
							?>

							<div class="mb-3">
								<div class="col">
									<h3 class="pay_name"><?=Loc::getMessage("SOA_PAY") ?></h3>
								</div>
							</div>
							<div class="mb-4 align-items-center payment-info">
								<span><?=CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px\"", "", false) ?></span>
								<span><p><?=$arPaySystem["NAME"] ?></p></span>
							</div>
							<?php 
							/** 
							 * Если заказ оформлен от юр.лица
							 * Закрываем ссылку на оплату
							 */
							?>
							<? if ($arResult['ORDER']['PERSON_TYPE_ID'] != 2): ?>
								<div class="">
									<div class="col">
										<? if ($arPaySystem["ACTION_FILE"] <> '' && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
										<?
											$orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
											$paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
										?>
										<script>
											window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
										</script>
										<p><?=Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&PAYMENT_ID=".$paymentAccountNumber))?></p>
										<? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
										<br/>
										<p><?=Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&pdf=1&DOWNLOAD=Y"))?></p>
										<? endif ?>
										<? else: ?>

											<? if ($arResult['HIDE_BUTTON_PAYMENT'] != 'Y'): ?>
												<?=$arPaySystem["BUFFERED_OUTPUT"]?>
											<? else: ?>
												<p class = "text-color-orange">
													<?= Loc::getMessage("CAN_PAY_LATER"); ?>
												</p>
											<? endif; ?>
											
										<? endif ?>
									</div>
								</div>
							<? endif; ?>

							<?
						}
						else
						{
							?>
							<div class="alert alert-danger" role="alert"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></div>
							<?
						}
					}
					else
					{
						?>
						<div class="alert alert-danger" role="alert"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></div>
						<?
					}
				}
			}
		}
	}
	else
	{
		?>
		<div class="alert alert-danger" role="alert"><?=$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']?></div>
		<?
	}
	?>

<? else: ?>


	<div class="mb-2">
		<div class="col">
			<div class="alert alert-danger" role="alert"><strong><?=Loc::getMessage("SOA_ERROR_ORDER")?></strong><br />
			<p><?=Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])])?><br />
			<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?></p></div>
		</div>
	</div>

<? endif ?>
</div>
</div>
</div>