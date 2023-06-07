<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

\Bitrix\Main\UI\Extension::load([
	'ui.design-tokens',
	'ui.fonts.opensans',
	'clipboard',
	'fx',
]);

Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");
Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/style.css");
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");

Loc::loadMessages(__FILE__);
?>
<div class="personal-order">
	<div class="container">
		<h2>
			<svg width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon" data-v-0dd65cb5="">
				<path d="M13.5 1.78a.78.78 0 00-.785-.78h-9.93A.78.78 0 002 1.78v12.44a.78.78 0 00.785.78h.26V2.035H13.5V1.78z" fill="currentColor" data-v-0dd65cb5=""></path><path d="M14.75 3h-10a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h10a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75z" fill="currentColor" data-v-0dd65cb5="">
				</path>
			</svg> 
			<?= getMessage('SPOL_HISTORY_ORDER');?>
		</h2>
		<div class="main-profile-orders__filter">
		    <a class="btn btn-primary btn-lg px-5 history-order__body-btn" href="/cabinet/orders/"><?= getMessage('SPOL_ORDER');?></a>
		    <a class="btn btn-primary btn-lg px-5 history-order__body-btn" href="/cabinet/orders/?filter_history=Y&?filter_status=F"><?= getMessage('SPOL_F_ORDER');?></a>
		    <a class="btn btn-primary btn-lg px-5 history-order__body-btn" href="/cabinet/orders/?filter_history=Y&show_canceled=Y&filter_canceled=Y"><?= getMessage('SPOL_C_ORDER');?></a>
		</div>
		<?if (!empty($arResult['ERRORS']['NONFATAL']))
					{
						foreach($arResult['ERRORS']['NONFATAL'] as $error)
						{
							ShowError($error);
						}
					}
					if (!count($arResult['ORDERS'])) 
					{
						if ($_REQUEST["filter_history"] == 'Y')
						{
							if ($_REQUEST["show_canceled"] == 'Y')
							{
								?>
								<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_CANCELED_ORDER')?></h3>
								<?
							}
							else
							{
								?>
								<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_HISTORY_ORDER_LIST')?></h3>
								<?
							}
						}
						else
						{
							?>
							<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST')?></h3>
							<?
						}
				}?>
	    <?$paymentChangeData = array();
		$orderHeaderStatus = null;
		foreach ($arResult['ORDERS'] as $key => $order){
			$orderHeaderStatus = $order['ORDER']['STATUS_ID'];?>
			
			<div class="history-order" id="<?= $order['ORDER']['ACCOUNT_NUMBER'];?>">
				<div class="history-order__header">
					<div class="row">
						<div class="col-6"><?= getMessage('SPOL_NUMDER_ORDER');?></div> 
						<div class="col-2"><?= getMessage('SPOL_DATE_ORDER');?></div>
					 	<div class="col-2"><?= getMessage('SPOL_SUM_ORDER');?></div> 
					 	<div class="col-2"><?= getMessage('SPOL_STATUS_ORDER');?></div>
					</div>
				</div>
				
				<div class="history-order__summary">
					<div class="row">
						<div class="col-6 history-order__main-item">
							<span>
								<b><?=Loc::getMessage('SPOL_TPL_NUMBER_SIGN').$order['ORDER']['ACCOUNT_NUMBER']?></b><br> 
								<? foreach ($order['SHIPMENT'] as $shipment){?>
									<b><?=Loc::getMessage('SPOL_TPL_DELIVERY_SERVICE')?>:</b>
									<?=$arResult['INFO']['DELIVERY'][$shipment['DELIVERY_ID']]['NAME']?><br> 
								<?}?>
								<b><?=Loc::getMessage('SPOL_TPL_DELIVERY_COST')?>:</b> 
								<?= $shipment['FORMATED_DELIVERY_PRICE'];?>
							</span>
						</div> 
						<div class="col-2 history-order__column">
							<span>
								<div class="history-order__descr"><?= getMessage('SPOL_DATE_ORDER');?></div>
								<b><?=$order['ORDER']['DATE_INSERT_FORMATED']?></b>
							</span>
						</div> 
						<div class="col-2 history-order__column">
							<span> 
								<div class="history-order__descr"><?= getMessage('SPOL_SUM_ORDER');?></div>
								<b> <?=$order['ORDER']['FORMATED_PRICE']?> </b>
							</span>
						</div> 
						<div class="col-2 history-order__column">
							<span>
								<div class="history-order__descr"><?= getMessage('SPOL_STATUS_ORDER');?></div>
								<b><?=htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME'])?></b>
							</span>
						</div>
					</div>
				</div>
				<div class="history-order__body">
					<h6><?= getMessage('SPOL_ITEM_ORDER');?></h6>
					<? foreach ($order['BASKET_ITEMS'] as $item) { ?>
						<div class="row history-order__item">
							<div class="col-6 history-order__item-card">
							<? $CIBlockElement = CIBlockElement::GetByID($item['PRODUCT_ID']);
								$image = $templateFolder . '/images/no_photo.png';
								if ($arResultElement = $CIBlockElement->GetNext()) {
									if ($arResultElement['PREVIEW_PICTURE']) {
										$image = CFile::GetPath($arResultElement['PREVIEW_PICTURE']);
									} elseif ($arResultElement['DETAIL_PICTURE']) {
										$image = CFile::GetPath($arResultElement['DETAIL_PICTURE']);
									}
								
									if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $image)) {
										$image = $templateFolder . '/images/no_photo.png';
									}
								} ?>
								<figure style="background-image: url(&quot;<?=$image;?>&quot;);"></figure> 
								<span > <?= $item['NAME']?>
						      		<span class="history-order__item-mob">
									  	<?= $item['QUANTITY']?> <br >
										<?= $item['PRICE']?> <br >
						        		0 баллов
						      		</span>
								</span>
							</div> 
							<div class="col-2"><?= $item['QUANTITY']?> <?= $item['MEASURE_TEXT']?></div> 
							<div class="col-2"><?= CurrencyFormat($item['PRICE'], 'RUB');?></div> 
							<div class="col-2">0 баллов</div>
						</div>  
	                <? } ?>
					<div class="history-order__body-btns">
						<a href="/cabinet/reviews/?order_id=<?= $order['ORDER']['ACCOUNT_NUMBER'];?>" class="btn btn-primary btn-lg px-5 history-order__body-btn">Оставить отзыв</a> 
						<a href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>" class="btn btn-primary btn-lg px-5 history-order__body-btn sale-order-list-repeat-link">
							<span ><?= getMessage('SPOL_REPEAT_ORDER');?></span>
						</a> 
						<?
						$showDelimeter = false;
						foreach ($order['PAYMENT'] as $payment){
							if ($order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'){
								$paymentChangeData[$payment['ACCOUNT_NUMBER']] = array(
									"order" => htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']),
									"payment" => htmlspecialcharsbx($payment['ACCOUNT_NUMBER']),
									"allow_inner" => $arParams['ALLOW_INNER'],
									"refresh_prices" => $arParams['REFRESH_PRICES'],
									"path_to_payment" => $arParams['PATH_TO_PAYMENT'],
									"only_inner_full" => $arParams['ONLY_INNER_FULL'],
									"return_url" => $arResult['RETURN_URL'],
								);
							}?>
							<div class="sale-order-list-inner-row">
								<div class="sale-order-list-inner-row-body">
									<?if ($payment['PAID'] === 'N' && $payment['IS_CASH'] !== 'Y' && $payment['ACTION_FILE'] !== 'cash'){?>
										<div class="sale-order-list-button-container">
											<a class="sale-order-list-button ajax_reload btn btn-secondary btn-lg px-5 history-order__body-btn text-white" href="<?=htmlspecialcharsbx($payment['PSA_ACTION_FILE'])?>">
												<?=Loc::getMessage('SPOL_TPL_PAY')?>
											</a>
										</div>
									<?}?>
								</div>
								<div class="sale-order-list-inner-row-template">
								</div>
							</div>
						<?}?>
					</div>
				</div>
			</div>		
		<?}?>
	
		<div class="clearfix"></div>
		<?
		echo $arResult["NAV_STRING"];
		if ($_REQUEST["filter_history"] !== 'Y'){
			$javascriptParams = array(
				"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
				"templateFolder" => CUtil::JSEscape($templateFolder),
				"templateName" => $this->__component->GetTemplateName(),
				"paymentList" => $paymentChangeData,
				"returnUrl" => CUtil::JSEscape($arResult["RETURN_URL"]),
			);
			$javascriptParams = CUtil::PhpToJSObject($javascriptParams);?>
			<script>
				BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?=$javascriptParams?>);
			</script>
		<?}?>
	</div>
</div>
	
