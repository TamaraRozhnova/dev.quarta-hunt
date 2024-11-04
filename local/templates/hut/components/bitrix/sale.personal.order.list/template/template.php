<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}

/** @var CBitrixPersonalOrderListComponent $component */
/** @var array $arParams */
/** @var array $arResult */

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

\Bitrix\Main\UI\Extension::load([
	'ui.design-tokens',
	'ui.fonts.opensans',
	'clipboard',
	'fx',
]);


Loc::loadMessages(__FILE__);

if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach($arResult['ERRORS']['FATAL'] as $error)
	{
		ShowError($error);
	}
	$component = $this->__component;
	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
	{
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}

}
else
{
	$filterHistory = ($_REQUEST['filter_history'] ?? '');
	$filterShowCanceled = ($_REQUEST["show_canceled"] ?? '');

	if (!empty($arResult['ERRORS']['NONFATAL']))
	{
		foreach($arResult['ERRORS']['NONFATAL'] as $error)
		{
			ShowError($error);
		}
	}
	if (empty($arResult['ORDERS']) && $_REQUEST["filter_id"] === NULL)
	{?>
		<div class="sale-no-order">
			<?= buildSVG('no-orders', SITE_TEMPLATE_PATH . IMG_PATH) ?>
			<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST')?></h3>
			<p><?= Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST_DESC')?></p>
			<a href="<?= htmlspecialcharsbx($arParams['PATH_TO_CATALOG'])?>" class="sale-order-history-link">
				<?= Loc::getMessage('SPOL_TPL_LINK_TO_CATALOG')?>
			</a>
		</div>
	<?php }else{?>

		<form action="/orders/" method="get" class="sale-order-search">
			<input class="input" type="text" name="filter_id" value="<?= $_REQUEST["filter_id"]? $_REQUEST["filter_id"]: ''?>" placeholder="<?= GetMessage('SPOL_TPL_SEARCH')?>">
			<button type="submit"><?= buildSVG('search', SITE_TEMPLATE_PATH . IMG_PATH) ?></button>
		</form>

		<?php if(empty($arResult['ORDERS']) && $_REQUEST["filter_id"]) {?>
			<div class="sale-no-order">
				<?= buildSVG('no-order-search', SITE_TEMPLATE_PATH . IMG_PATH) ?>
				<h3><?= Loc::getMessage('SPOL_TPL_NO_ORDER')?></h3>
				<p><?= Loc::getMessage('SPOL_TPL_NO_ORDER_DESC')?></p>
			</div>
		<?php }else{

			foreach ($arResult['ORDERS'] as $key => $order)
			{ ?>
				<div class="sale-order-container" onclick="location.href='<?=htmlspecialcharsbx($order['ORDER']['URL_TO_DETAIL'])?>';">
					<div class="sale-order-left-half">
						<div class="sale-order-status-wrap">
							<div class="sale-order-status-color" style="background-color: <?= $arParams['STATUS_COLOR_'.$order['ORDER']['STATUS_ID']]?>;"></div>
							<div class="sale-order-status-name"><?= htmlspecialcharsbx($arResult['INFO']['STATUS'][$order['ORDER']['STATUS_ID']]['NAME'])?></div>
						</div>
						<div class="sale-order-number">
							<?= Loc::getMessage('SPOL_TPL_NUMBER_SIGN').$order['ORDER']['ACCOUNT_NUMBER']?>
						</div>
					</div>
					<div class="sale-order-products-half">
						<?php 	
							$count = 0;
							$countItem = count($order['BASKET_ITEMS']);
							$countVisible = true;

							foreach($order['BASKET_ITEMS'] as $item){
								$count++;	
								if($count > 3){
									$countVisible = false;
									continue;
								}?>
								<div class="sale-order-product">
									<a href="<?= $item['DETAIL_PAGE_URL']?>">
										<img src="<?= $item['PREVIEW_PICTURE']?>"  alt="product">
									</a>
								</div>
							<?php }

							if($countVisible == false){?>
								<div class="sale-order-product">
									<?= $countItem - 3;?>+
								</div>
							<?php }

							unset($countVisible);
						?>
					</div>
					<div class="sale-order-right-half">
					<div class="sale-order-date">
						<p><?= GetMessage('SPOL_TPL_DATE')?></p>
						<?= $order['ORDER']['DATE_INSERT_FORMATED']?>
					</div>
					<div class="sale-order-sum">
						<p><?= GetMessage('SPOL_TPL_SUMOF')?></p>
						<?= $order['ORDER']['FORMATED_PRICE']?>
					</div>
					</div>
				</div>
			<?php }?>
			<div class="clearfix"></div>

			<?php 
			echo $arResult["NAV_STRING"];
									
			if ($filterHistory !== 'Y')
			{
				$javascriptParams = array(
					"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
					"templateFolder" => CUtil::JSEscape($templateFolder),
					"templateName" => $this->__component->GetTemplateName(),
					"paymentList" => $paymentChangeData,
					"returnUrl" => CUtil::JSEscape($arResult["RETURN_URL"]),
				);
				$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
				?>
				<script>
					BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?= $javascriptParams?>);
				</script>
				<?php 
			}

		}
	}
}