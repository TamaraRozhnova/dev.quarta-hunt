<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset,
	\Bitrix\Main\UI\Extension,
	Bitrix\Main\Context;

Extension::load([
	'ui.design-tokens',
	'ui.fonts.opensans',
	'clipboard',
	'fx',
]);

Asset::getInstance()->addJs(
	"/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js"
);

Asset::getInstance()->addCss(
	"/bitrix/components/bitrix/sale.order.payment.change/templates/.default/style.css"
);

$obRequest = Context::getCurrent()->getRequest();

Loc::loadMessages(__FILE__);?>

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
			
			<div class="history-order hided" id="<?= $order['ORDER']['ACCOUNT_NUMBER'];?>">
				<div class="history-order__header">
					<div class="row">
						<div class="col-6"><?= getMessage('SPOL_NUMDER_ORDER');?></div> 
						<div class="col-2"><?= getMessage('SPOL_DATE_ORDER');?></div>
					 	<div class="col-2"><?= getMessage('SPOL_SUM_ORDER');?></div> 
					 	<div class="col-2"><?= getMessage('SPOL_STATUS_ORDER');?></div>
					</div>

					<div class="history-order__arrow hided">
						<svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M7.42981 1.14955C7.74711 0.832293 8.26153 0.832313 8.57881 1.1496L15.5436 8.11435C15.8609 8.43165 15.8609 8.94609 15.5436 9.26339C15.2263 9.5807 14.7118 9.5807 14.3945 9.26339L8.00424 2.87312L1.61293 9.26344C1.29561 9.58072 0.78116 9.58068 0.463883 9.26335C0.146607 8.94602 0.146647 8.43158 0.463973 8.1143L7.42981 1.14955Z" fill="#4E4E4E"/>
						</svg>
					</div>

				</div>

				<div class="history-order__summary-body">
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
									<?= $shipment['FORMATED_DELIVERY_PRICE'];?> <br> 

									<?if (!empty($order['ADD_BONUSES'])):?>
										<b>Начислено бонусов:</b>
										<?=$order['ADD_BONUSES']?>
									<?endif;?>

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
										</span>
									</span>
								</div> 
								<div class="col-2"><?= $item['QUANTITY']?> <?= $item['MEASURE_TEXT']?></div> 
								<div class="col-2"><?= CurrencyFormat($item['PRICE'], 'RUB');?></div> 
							</div>  
						<? } ?>
						<div class="history-order__body-btns">
							<? if ($order['ORDER']['STATUS_ID'] == 'F'): ?>
								<a href="/cabinet/reviews/?order_id=<?= $order['ORDER']['ACCOUNT_NUMBER'];?>" class="btn btn-primary btn-lg px-5 history-order__body-btn">Оставить отзыв</a> 
							<? endif; ?>

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
										<?if (
											$payment['PAID'] === 'N' 
											&& 
											$payment['IS_CASH'] !== 'Y' 
											&& 
											$payment['ACTION_FILE'] !== 'cash'
											&&
											$order['HIDE_BUTTON_PAYMENT'] != 'Y'
											&&
											$order['ORDER']['CANCELED'] !== 'Y'
										) { ?>
											<div class="sale-order-list-button-container">
												<a class="sale-order-list-button ajax_reload btn btn-secondary btn-lg px-5 history-order__body-btn text-white" href="<?=htmlspecialcharsbx($payment['PSA_ACTION_FILE'])?>">
													<?=Loc::getMessage('SPOL_TPL_PAY')?>
												</a>
											</div>
										<?}?>
										<?php 
										/**
										 * Если не оплачен заказ
										 * и не выполнен
										 * и выбран тип оплаты наличные или банковский
										 * и заказ не отменен
										 * перевод (при получении),
										 * то добавляем кнопку "отменить заказ"
										 */
										?>
										<? if (
											$payment['PAID'] === 'N' 
											&&
											$order['ORDER']['CANCELED'] !== 'Y'
										): ?>
											<?$APPLICATION->IncludeComponent("bitrix:sale.personal.order.cancel","order.cancel",Array(
													"PATH_TO_LIST" => "",
													"PATH_TO_DETAIL" => "",
													"ID" => $order['ORDER']['ID'],
													"SET_TITLE" => "N"
												)
											);?>
										<? endif; ?>
									</div>
									<div class="sale-order-list-inner-row-template">
									</div>
								</div>
							<?}?>
						</div>
					</div>
					<div class="history-order__arrow hided">
						<svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M7.42981 1.14955C7.74711 0.832293 8.26153 0.832313 8.57881 1.1496L15.5436 8.11435C15.8609 8.43165 15.8609 8.94609 15.5436 9.26339C15.2263 9.5807 14.7118 9.5807 14.3945 9.26339L8.00424 2.87312L1.61293 9.26344C1.29561 9.58072 0.78116 9.58068 0.463883 9.26335C0.146607 8.94602 0.146647 8.43158 0.463973 8.1143L7.42981 1.14955Z" fill="#4E4E4E"/>
						</svg>
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

<?php /** Модальное окно об успешной отмене заказа */ ?>
<div id="cancel-md-form-success" class="modal">
	<div class="modal-content">
		<div class="modal-body">
			<h3>Заказ успешно отменен!</h3>
		</div>
		<div class="modal__close">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
					class="bi bi-x" viewBox="0 0 16 16">
				<path
					d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
			</svg>
		</div>
	</div>	
</div>

<?php /** Модальное окно об отмене заказа */ ?>
<div id="cancel-md-form" class="modal">
	<div class="modal-content">
		<div class="modal-body">
			<h3>Вы действительно хотите отменить заказ?</h3>
			<div class="modal-body__btns">
			</div>
		</div>

		<div class="modal__close">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
					class="bi bi-x" viewBox="0 0 16 16">
				<path
					d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
			</svg>
		</div>
	</div>	
</div>

<script>
	window.addEventListener('load', () => {
		/**
		 * Стрелки - анимация заказов
		 */

		/**
		 * Функция анимации заказа
		 */
		function toggleAnimationOrder(cardBody, arrow) {
			BX.toggleClass(arrow, ['', 'hided'])
			$(cardBody).slideToggle('slow')
		}

		const orders = document.querySelectorAll('.history-order')
		const modalCancel = document.querySelector('#cancel-md-form')
		const modalBtns = document.querySelector('#cancel-md-form .modal-body__btns')
		
		const modalSuccessCancelOrder = document.querySelector('#cancel-md-form-success')

		if (modalSuccessCancelOrder) {

			if (sessionStorage.getItem('order_canceled_modal')) {
				const modalSuccessCancel = new Modal({
					modalSelector: "#cancel-md-form-success",
				});

				modalSuccessCancel.open()

				sessionStorage.removeItem('order_canceled_modal')

			}

		}

		/**
		 * Обработчики для самих заказов
		 */
		if (orders.length > 0) {

			orders.forEach((order) => {

				const cardArrows = order.querySelectorAll('.history-order__arrow');
				const cardBody = order.querySelector('.history-order__body')
				const wrapperCardBody = order.querySelector('.history-order__summary-body')
				const cardBodyBtnsClass = '.history-order__body-btns'

				const btnCancel = order.querySelector('.cancel-order')

				/**
				 * Стрелки
				 */
				if (cardArrows.length > 0) {
					cardArrows.forEach((arrow) => {

						if (window.innerWidth <= 1024) {

							wrapperCardBody.onclick = (e) => {

								if (!e.target.closest(cardBodyBtnsClass)) {
									toggleAnimationOrder(cardBody, arrow)
								}

							}
						} else {

							BX.bind(arrow, 'click', () => {
								toggleAnimationOrder(cardBody, arrow)
							})
						}

					})
				}

				/**
				 * Кнопка отмены
				 */
				if (btnCancel) {
					btnCancel.addEventListener('click', (e) => {

						e.preventDefault();

						const currentFormCancel = btnCancel.closest('form').cloneNode(true)

						modalBtns.innerHTML = '';
						modalBtns.appendChild(currentFormCancel);

						sessionStorage.setItem('order_canceled_modal', 'Y')

						const cancelModal = new Modal({
							modalSelector: "#cancel-md-form",
							modalOpenElementSelector: `.history-order[id = "${order.getAttribute('id')}"] .cancel-order`
						});

						cancelModal.onClose = () => {
							if (sessionStorage.getItem('order_canceled_modal')) {
								sessionStorage.removeItem('order_canceled_modal')
							}
						}

						cancelModal.open()

					})
				}

			})
		}
	})
</script>

	
