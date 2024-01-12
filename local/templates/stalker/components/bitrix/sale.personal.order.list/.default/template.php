<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);

//echo_j($arResult, '$arResult order.list');

if (!empty($arResult['ERRORS']['FATAL']))
{
}
else
{
	if (!empty($arResult['ERRORS']['NONFATAL']))
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
				<?php
			}
			else
			{
				?>
				<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_HISTORY_ORDER_LIST')?></h3>
				<?php
			}
		}
		else
		{
			?>
			<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST')?></h3>
			<?php
		}
	}
	?>
	<div class="row mb-3 filter__history">
			<?php
			$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);
			$clearFromLink = array("filter_history","filter_status","show_all", "show_canceled");

			if ($nothing || $_REQUEST["filter_history"] == 'N')
			{
				?>
                    <div class="col">
				<a class="mr-4" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false)?>"><?php echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY")?></a>
                    </div>
				<?php
			}
			if ($_REQUEST["filter_history"] == 'Y')
			{
				?>
                    <div class="col">
				<a class="mr-4" href="<?=$APPLICATION->GetCurPageParam("", $clearFromLink, false)?>"><?php echo Loc::getMessage("SPOL_TPL_CUR_ORDERS")?></a>
                    </div>
				<?php
				if ($_REQUEST["show_canceled"] == 'Y')
				{
					?>
                        <div class="col">
					<a class="mr-4" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false)?>"><?php echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY")?></a>
                        </div>
					<?php
				}
				else
				{
					?><div class="col">
					<a class="mr-4" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y&show_canceled=Y", $clearFromLink, false)?>"><?php echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_CANCELED")?></a>
                    </div>
					<?php
				}
			}
			?>
	</div>
	<?php
	if (!count($arResult['ORDERS']))
	{/*
		?>
		<div class="row mb-3">
			<div class="col">
				<a href="<?=htmlspecialcharsbx($arParams['PATH_TO_CATALOG'])?>" class="mr-4"><?=Loc::getMessage('SPOL_TPL_LINK_TO_CATALOG')?></a>
			</div>
		</div>
		<?php
    */
	}
	foreach ($arResult['ORDERS'] as $key => $order)
	{
		?>
		<div class="order__item">
			<div class="order__head">
				<div class="order__number">
					Заказ <?=Loc::getMessage('SPOL_TPL_NUMBER_SIGN').$order['ORDER']['ACCOUNT_NUMBER'].' ('.$arResult['INFO']['STATUS'][$order['ORDER']['STATUS_ID']]['NAME'].')'?>
				</div>

				<div class="order__date">
					<?=Loc::getMessage('SPOL_TPL_FROM_DATE')?>
					<?=$order['ORDER']['DATE_INSERT_FORMATED']?>,
				</div>
			</div>
			<div class="order__body">
				<div class="order__goods">
					<?php foreach ($order['BASKET_ITEMS'] as $index => $item): ?>
						<div class="order__good">
							<div class="order__good-img">
								<picture>
									<img class="lazy" data-src="<?=$item['IMAGE']?>" alt=""/>
								</picture>
								<div class="dot dot--top-left"></div>
								<div class="dot dot--top-right"></div>
								<div class="dot dot--bottom-right"></div>
								<div class="dot dot--bottom-left"></div>
							</div>
							<div class="order__good-chars">
								<div class="order__good-name">
									<?=$item['NAME']?>
								</div>
								<div class="order__good-price">
									<div class="price-new">
										<span class="value"><?=priceFormat($item['PRICE'])?></span> руб
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="order__total">
					<div class="order__total-price">
						Итого: <span class="price-new"><span class="value"><?=priceFormat($order['ORDER']['PRICE'])?></span> руб</span>
					</div>
					<div class="order__total-count">
						Товаров <?=count($order['BASKET_ITEMS']);?> шт
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	echo $arResult["NAV_STRING"];

	if ($_REQUEST["filter_history"] !== 'Y')
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
			BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?=$javascriptParams?>);
		</script>
		<?php
	}
}
?>
