<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}

/** @global CMain $APPLICATION */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $templateFolder */

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

\Bitrix\Main\UI\Extension::load([
	'ui.design-tokens',
	'ui.fonts.opensans',
	'clipboard',
	'fx',
]);

if ($arParams['GUEST_MODE'] !== 'Y')
{
	Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");
	Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/style.css");
}

$APPLICATION->SetTitle("");

if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach ($arResult['ERRORS']['FATAL'] as $error)
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
	if (!empty($arResult['ERRORS']['NONFATAL']))
	{
		foreach ($arResult['ERRORS']['NONFATAL'] as $error)
		{
			ShowError($error);
		}
	}
	?>
	<div class="sale-order-detail">
		
		<?php
		if ($arParams['GUEST_MODE'] !== 'Y'){
			?>
			<a class="sale-order-detail-back-to-list-link" href="<?= htmlspecialcharsbx($arResult["URL_TO_LIST"]) ?>">
				<?= buildSVG('order-arrow', SITE_TEMPLATE_PATH . IMG_PATH) ?><?= Loc::getMessage('SPOD_RETURN_LIST_ORDERS') ?>
			</a>
			<?php
		} 
		
		?>
		<div class="sale-order-detail-general">
			<div class="sale-order-detail-general-head">
				<div class="sale-order-detail-general-head-left">
					<div class="sale-order-detail-title">
						<?= Loc::getMessage('SPOD_SUB_ORDER_TITLE', array("#ACCOUNT_NUMBER#"=> htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])))?>
					</div>
					<div class="sale-order-detail-status-date">
						<div class="sale-order-detail-status-wrap">
							<div class="sale-order-status-color" style="background-color: <?= $arParams['STATUS_COLOR_'.$arResult['STATUS_ID']]?>;"></div>
							<div class="sale-order-status-name"><?= htmlspecialcharsbx($arResult['STATUS']['NAME'])?></div>
						</div>
						<div class="sale-order-status-date"><?= $arResult["DATE_INSERT_FORMATED"]?></div>
					</div>
				</div>
				<div class="sale-order-detail-general-head-right">
					<?php if ($arParams['GUEST_MODE'] !== 'Y') {?>
						<div class="sale-order-detail-about-order-inner-container-repeat">
							<a href="<?=$arResult["URL_TO_COPY"]?>" class="sale-order-detail-about-order-inner-container-repeat-button">
								<?= buildSVG('repeat', SITE_TEMPLATE_PATH . IMG_PATH) ?><?= Loc::getMessage('SPOD_ORDER_REPEAT') ?>
							</a>
							<?php
							if ($arResult["CAN_CANCEL"] === "Y"){
								?>
								<a href="<?=$arResult["URL_TO_CANCEL"]?>" class="sale-order-detail-about-order-inner-container-repeat-cancel">
									<?= buildSVG('cancel', SITE_TEMPLATE_PATH . IMG_PATH) ?><?= Loc::getMessage('SPOD_ORDER_CANCEL') ?>
								</a>
								<?php
							}?>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="sale-order-detail-order-item-table">
				<?php
				$countProduct = 0;
				foreach ($arResult['BASKET'] as $basketItem){	
					$countProduct++;
					?>
					<div class="sale-order-detail-order-item-block">
						<div class="sale-order-detail-order-item-img-block">
							<a href="<?=$basketItem['DETAIL_PAGE_URL']?>">
								<?php
								if (is_array($basketItem['PICTURE'])){
									$imageSrc = $basketItem['PICTURE']['SRC'];
								}else{
									$imageSrc = $this->GetFolder().'/images/no_photo.png';
								}?>
								<img src="<?=$imageSrc?>" alt="<?=htmlspecialcharsbx($basketItem['NAME'])?>">
							</a>
						</div>
						<div class="sale-order-detail-order-item-content">
							<div class="sale-order-detail-order-item-title">
								<a href="<?=$basketItem['DETAIL_PAGE_URL']?>">
									<?=htmlspecialcharsbx($basketItem['NAME'])?>
								</a>
							</div>
							<div class="sale-order-detail-order-item-section">
								<?=htmlspecialcharsbx($basketItem['SECTION_NAME'])?>
							</div>
							<?php
							if (isset($basketItem['PROPS']) && is_array($basketItem['PROPS'])){
								foreach ($basketItem['PROPS'] as $itemProps){
									?>
									<div class="sale-order-detail-order-item-props">
										<span class="sale-order-detail-order-item-props-name">
											<?=htmlspecialcharsbx($itemProps['NAME'])?>:
										</span>
										<span class="sale-order-detail-order-item-props-value">
											<?=htmlspecialcharsbx($itemProps['VALUE'])?>
										</span>
									</div>
							<?php }
							}?>
						</div>
					</div>
				<?php
				}
				?>
			</div>
			<div class="row sale-order-detail-total">
				<div class="sale-order-detail-total-container">
					<ul class="sale-order-detail-total-list">
							<li class="sale-order-detail-total-quantity">
								<span><?= Loc::getMessage('SPOD_QUANTITY')?></span><span></span>
								<span><?= Loc::getMessage('SPOD_MEASURENS', array("#QUANTITY#"=> htmlspecialcharsbx($countProduct)))?></span>
							</li>
						<?php
						if ($arResult['BASE_PRODUCT_SUM_FORMATED'] != $arResult['PRICE_FORMATED'] && !empty($arResult['BASE_PRODUCT_SUM_FORMATED']))
						{
							?>
							<li class="sale-order-detail-total-product-sum">
								<span><?= Loc::getMessage('SPOD_COMMON_SUM')?></span><span></span>
								<span><?=$arResult['BASE_PRODUCT_SUM_FORMATED']?></span>
							</li>
							<?php
						}

						if ($arResult['PRODUCT_SUM_DISCOUNT_FORMATED'] != $arResult['PRICE_FORMATED'] && !empty($arResult['PRODUCT_SUM_DISCOUNT_FORMATED']))
						{
							?>
							<li class="sale-order-detail-total-discount">
								<span><?= Loc::getMessage('SPOD_DISCOUNT')?></span><span></span>
								<span>-<?=$arResult['PRODUCT_SUM_DISCOUNT_FORMATED']?></span>
							</li>
							<?php
						}

						if($arResult["PRICE_DELIVERY_FORMATED"] <> '')
						{
							?>
							<li class="sale-order-detail-total-shipment">
								<span><? foreach($arResult['SHIPMENT'] as $shipment) {echo $shipment['DELIVERY_NAME'];}?></span><span></span>
								<span><?= $arResult["PRICE_DELIVERY_FORMATED"] ?></span>
							</li>
							<?php
						}
						?>
						<li class="sale-order-detail-total-sum">
							<span><?= Loc::getMessage('SPOD_SUMMARY')?></span><span></span>
							<span><?=$arResult['PRICE_FORMATED']?></span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php
	$javascriptParams = array(
		"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
		"templateFolder" => CUtil::JSEscape($templateFolder),
		"templateName" => $this->__component->GetTemplateName(),
		"paymentList" => $paymentData,
		"returnUrl" => $arResult['RETURN_URL'],
	);
	$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
	?>
	<script>
		BX.Sale.PersonalOrderComponent.PersonalOrderDetail.init(<?=$javascriptParams?>);
	</script>
<?php
}
