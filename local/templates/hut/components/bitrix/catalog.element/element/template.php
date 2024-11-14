<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$templateLibrary = array('popup', 'fx', 'ui.fonts.opensans');
$currencyList = '';

if (!empty($arResult['CURRENCIES'])) {
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$haveOffers = !empty($arResult['OFFERS']);

$templateData = [
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList,
	'ITEM' => [
		'ID' => $arResult['ID'],
		'IBLOCK_ID' => $arResult['IBLOCK_ID'],
	],
];
if ($haveOffers) {
	$templateData['ITEM']['OFFERS_SELECTED'] = $arResult['OFFERS_SELECTED'];
	$templateData['ITEM']['JS_OFFERS'] = $arResult['JS_OFFERS'];
}
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId . '_dsc_pict',
	'STICKER_ID' => $mainId . '_sticker',
	'BIG_SLIDER_ID' => $mainId . '_big_slider',
	'BIG_IMG_CONT_ID' => $mainId . '_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId . '_slider_cont',
	'OLD_PRICE_ID' => $mainId . '_old_price',
	'PRICE_ID' => $mainId . '_price',
	'DESCRIPTION_ID' => $mainId . '_description',
	'DISCOUNT_PRICE_ID' => $mainId . '_price_discount',
	'PRICE_TOTAL' => $mainId . '_price_total',
	'SLIDER_CONT_OF_ID' => $mainId . '_slider_cont_',
	'QUANTITY_ID' => $mainId . '_quantity',
	'QUANTITY_DOWN_ID' => $mainId . '_quant_down',
	'QUANTITY_UP_ID' => $mainId . '_quant_up',
	'QUANTITY_MEASURE' => $mainId . '_quant_measure',
	'QUANTITY_LIMIT' => $mainId . '_quant_limit',
	'BUY_LINK' => $mainId . '_buy_link',
	'ADD_BASKET_LINK' => $mainId . '_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId . '_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId . '_not_avail',
	'COMPARE_LINK' => $mainId . '_compare_link',
	'TREE_ID' => $mainId . '_skudiv',
	'DISPLAY_PROP_DIV' => $mainId . '_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId . '_main_sku_prop',
	'OFFER_GROUP' => $mainId . '_set_group_',
	'BASKET_PROP_DIV' => $mainId . '_basket_prop',
	'SUBSCRIBE_LINK' => $mainId . '_subscribe',
	'TABS_ID' => $mainId . '_tabs',
	'TAB_CONTAINERS_ID' => $mainId . '_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId . '_small_card_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

if ($haveOffers) {
	$actualItem = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] ?? reset($arResult['OFFERS']);
	$showSliderControls = false;

	foreach ($arResult['OFFERS'] as $offer) {
		if ($offer['MORE_PHOTO_COUNT'] > 1) {
			$showSliderControls = true;
			break;
		}
	}
} else {
	$actualItem = $arResult;
	$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

if ($arParams['SHOW_SKU_DESCRIPTION'] === 'Y') {
	$skuDescription = false;
	foreach ($arResult['OFFERS'] as $offer) {
		if ($offer['DETAIL_TEXT'] != '' || $offer['PREVIEW_TEXT'] != '') {
			$skuDescription = true;
			break;
		}
	}
	$showDescription = $skuDescription || !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
} else {
	$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}

$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);
$productType = $arResult['PRODUCT']['TYPE'];

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');

if ($arResult['MODULES']['catalog'] && $arResult['PRODUCT']['TYPE'] === ProductTable::TYPE_SERVICE) {
	$arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE_SERVICE']
		?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE_SERVICE');
	$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE_SERVICE']
		?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE_SERVICE');
} else {
	$arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE']
		?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
	$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE']
		?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
}

$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])) {
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos) {
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
	}
}

?>
<div class="bx-catalog-element" id="<?= $itemIds['ID'] ?>"
	itemscope itemtype="http://schema.org/Product">
	<div class="element__top container-no-padding">
		<div class="element__galery">
			<?/*<div class="product-item-detail-slider-container" id="<?= $itemIds['BIG_SLIDER_ID'] ?>">
				<span class="product-item-detail-slider-close" data-entity="close-popup"></span>
				<div class="product-item-detail-slider-block
						<?= ($arParams['IMAGE_RESOLUTION'] === '1by1' ? 'product-item-detail-slider-block-square' : '') ?>"
					data-entity="images-slider-block">
					<span class="product-item-detail-slider-left" data-entity="slider-control-left" style="display: none;"></span>
					<span class="product-item-detail-slider-right" data-entity="slider-control-right" style="display: none;"></span>
				</div>
				<?php
				if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y') {
					if ($haveOffers) {
				?>
						<div class="product-item-label-ring <?= $discountPositionClass ?>" id="<?= $itemIds['DISCOUNT_PERCENT_ID'] ?>"
							style="display: none;">
						</div>
						<?php
					} else {
						if ($price['DISCOUNT'] > 0) {
						?>
							<div class="product-item-label-ring <?= $discountPositionClass ?>" id="<?= $itemIds['DISCOUNT_PERCENT_ID'] ?>"
								title="<?= -$price['PERCENT'] ?>%">
								<span><?= -$price['PERCENT'] ?>%</span>
							</div>
				<?php
						}
					}
				}
				?>
				<div class="product-item-detail-slider-images-container" data-entity="images-container">
					<?php
					if (!empty($actualItem['MORE_PHOTO'])) {
						foreach ($actualItem['MORE_PHOTO'] as $key => $photo) {
					?>
							<div class="product-item-detail-slider-image<?= ($key == 0 ? ' active' : '') ?>" data-entity="image" data-id="<?= $photo['ID'] ?>">
								<img src="<?= $photo['SRC'] ?>" alt="<?= $alt ?>" title="<?= $title ?>" <?= ($key == 0 ? ' itemprop="image"' : '') ?>>
							</div>
						<?php
						}
					}

					if ($arParams['SLIDER_PROGRESS'] === 'Y') {
						?>
						<div class="product-item-detail-slider-progress-bar" data-entity="slider-progress-bar" style="width: 0;"></div>
					<?php
					}
					?>
				</div>
			</div>
			<?php
			if ($showSliderControls) {
				if ($haveOffers) {
					foreach ($arResult['OFFERS'] as $keyOffer => $offer) {
						if (!isset($offer['MORE_PHOTO_COUNT']) || $offer['MORE_PHOTO_COUNT'] <= 0)
							continue;

						$strVisible = $arResult['OFFERS_SELECTED'] == $keyOffer ? '' : 'none';
			?>
						<div class="product-item-detail-slider-controls-block" id="<?= $itemIds['SLIDER_CONT_OF_ID'] . $offer['ID'] ?>" style="display: <?= $strVisible ?>;">
							<?php
							foreach ($offer['MORE_PHOTO'] as $keyPhoto => $photo) {
							?>
								<div class="product-item-detail-slider-controls-image<?= ($keyPhoto == 0 ? ' active' : '') ?>"
									data-entity="slider-control" data-value="<?= $offer['ID'] . '_' . $photo['ID'] ?>">
									<img src="<?= $photo['SRC'] ?>">
								</div>
							<?php
							}
							?>
						</div>
					<?php
					}
				} else {
					?>
					<div class="product-item-detail-slider-controls-block" id="<?= $itemIds['SLIDER_CONT_ID'] ?>">
						<?php
						if (!empty($actualItem['MORE_PHOTO'])) {
							foreach ($actualItem['MORE_PHOTO'] as $key => $photo) {
						?>
								<div class="product-item-detail-slider-controls-image<?= ($key == 0 ? ' active' : '') ?>"
									data-entity="slider-control" data-value="<?= $photo['ID'] ?>">
									<img src="<?= $photo['SRC'] ?>">
								</div>
						<?php
							}
						}
						?>
					</div>
			<?php
				}
			}
			?>*/ ?>
			<? if (!empty($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])) { ?>
				<div class="element__galery-list">
					<? foreach ($actualItem['MORE_PHOTO'] as $key => $photo) {
					?>
						<a class="element__galery-item" data-fancybox="gallery" href="<?= $photo['SRC'] ?>">
							<img src="<?= $photo['SRC'] ?>">
						</a>
					<?	} ?>
					<? if ($arResult['PROPERTIES']['VIDEO']['VALUE']) { ?>
						<a class="element__galery-item element__galery-item--video" data-fancybox="gallery" data-thumb-src="<?= $arResult['PROPERTIES']['VIDEO_POSTER']['VALUE'] ? CFile::GetPath($arResult['PROPERTIES']['VIDEO_POSTER']['VALUE']) : '' ?>" href="<?= CFile::GetPath($arResult['PROPERTIES']['VIDEO']['VALUE']) ?>">
							<video src="<?= CFile::GetPath($arResult['PROPERTIES']['VIDEO']['VALUE']) ?>" <?= $arResult['PROPERTIES']['VIDEO_POSTER']['VALUE'] ? 'poster="' . CFile::GetPath($arResult['PROPERTIES']['VIDEO_POSTER']['VALUE']) . '"' : '' ?> muted></video>
							<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
								<rect width="40" height="40" rx="20" fill="white" />
								<path d="M15 12V28L28 20L15 12Z" fill="#354052" />
							</svg>
						</a>
					<? } ?>
					<button class="button element__galery-close" type="button">
						<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
							<rect width="36" height="36" rx="18" fill="white" />
							<path fill-rule="evenodd" clip-rule="evenodd" d="M12.2929 12.2929C12.6834 11.9024 13.3166 11.9024 13.7071 12.2929L18 16.5858L22.2929 12.2929C22.6834 11.9024 23.3166 11.9024 23.7071 12.2929C24.0976 12.6834 24.0976 13.3166 23.7071 13.7071L19.4142 18L23.7071 22.2929C24.0976 22.6834 24.0976 23.3166 23.7071 23.7071C23.3166 24.0976 22.6834 24.0976 22.2929 23.7071L18 19.4142L13.7071 23.7071C13.3166 24.0976 12.6834 24.0976 12.2929 23.7071C11.9024 23.3166 11.9024 22.6834 12.2929 22.2929L16.5858 18L12.2929 13.7071C11.9024 13.3166 11.9024 12.6834 12.2929 12.2929Z" fill="#354052" />
						</svg>
					</button>
				</div>
			<? } elseif ($arResult['DETAIL_PICTURE']['SRC']) { ?>
				<div class="element__no-gallery">
					<img src="<?= $arResult['DETAIL_PICTURE']['SRC'] ?>" alt="">
				</div>
			<? } else { ?>
				<div class="element__no-gallery">
					<img src="<?= $arResult['PREVIEW_PICTURE']['SRC'] ?>" alt="">
				</div>
			<? } ?>
		</div>
		<div class="element__info">
			<div class="col-sm-6">
				<div class="product-item-detail-info-section">
					<?php
					if ($arParams['DISPLAY_NAME'] === 'Y') {
					?>
						<h1 class="element__title"><?= $name ?></h1>
					<?php
					}
					?>
					<div class="element__rating">
						<div class="element__stars-block">
							<div class="element__stars--color" <?= $arResult['PROPERTIES']['AVERAGE_RATING']['VALUE'] ? 'style="width:' . (floatval($arResult['PROPERTIES']['AVERAGE_RATING']['VALUE']) / 5 * 100) . '%"' : '' ?>>
								<div class="element__stars">
									<?= buildSVG('star', SITE_TEMPLATE_PATH . ICON_PATH) ?>
									<?= buildSVG('star', SITE_TEMPLATE_PATH . ICON_PATH) ?>
									<?= buildSVG('star', SITE_TEMPLATE_PATH . ICON_PATH) ?>
									<?= buildSVG('star', SITE_TEMPLATE_PATH . ICON_PATH) ?>
									<?= buildSVG('star', SITE_TEMPLATE_PATH . ICON_PATH) ?>
								</div>
							</div>
							<div class="element__stars">
								<?= buildSVG('star-gray', SITE_TEMPLATE_PATH . ICON_PATH) ?>
								<?= buildSVG('star-gray', SITE_TEMPLATE_PATH . ICON_PATH) ?>
								<?= buildSVG('star-gray', SITE_TEMPLATE_PATH . ICON_PATH) ?>
								<?= buildSVG('star-gray', SITE_TEMPLATE_PATH . ICON_PATH) ?>
								<?= buildSVG('star-gray', SITE_TEMPLATE_PATH . ICON_PATH) ?>
							</div>
						</div>
						<a href="#" class="element__rating-link">0 оценок</a>
					</div>
					<div class="element__price">
						<div class="element__price-container">
							<div class="product-item-detail-price-current <?= floatval($price['BASE_PRICE']) !== floatval($price['PRICE']) && $arParams['SHOW_OLD_PRICE'] === 'Y' ? 'with-old' : '' ?>" id="<?= $itemIds['PRICE_ID'] ?>">
								<?= $price['PRINT_RATIO_PRICE'] ?>
							</div>
							<?php
							if ($arParams['SHOW_OLD_PRICE'] === 'Y') {
							?>
								<div class="product-item-detail-price-old" id="<?= $itemIds['OLD_PRICE_ID'] ?>"
									style="display: <?= ($showDiscount ? '' : 'none') ?>;">
									<?= ($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '') ?>
								</div>
							<?php
							}
							?>
						</div>
					</div>
					<?php
					foreach ($arParams['PRODUCT_INFO_BLOCK_ORDER'] as $blockName) {
						switch ($blockName) {
							case 'sku':
								if ($haveOffers && !empty($arResult['OFFERS_PROP'])) {
					?>
									<div class="element__sku" id="<?= $itemIds['TREE_ID'] ?>">
										<?php
										foreach ($arResult['SKU_PROPS'] as $skuProperty) {
											if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
												continue;

											$propertyId = $skuProperty['ID'];
											$skuProps[] = array(
												'ID' => $propertyId,
												'SHOW_MODE' => $skuProperty['SHOW_MODE'],
												'VALUES' => $skuProperty['VALUES'],
												'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
											);
										?>
											<div class="element__sku-item" data-entity="sku-line-block">
												<div class="element__skup-prop-title-wrap">
													<span class="element__sku-prop-title"><?= htmlspecialcharsEx($skuProperty['NAME']) ?></span>
													<? if ($skuProperty['CODE'] == 'CLOTHES_SIZE') { ?>
														<div class="element__sku-switchers">
															<a href="#" class="element__sku-switcher active" aim="<?= $skuProperty['CODE'] ?>">EU</a>
															<a href="#" class="element__sku-switcher rus" aim="<?= $skuProperty['CODE'] ?>">RUS</a>
														</div>
														<a href="#" class="element__size-table-link element__rating-link"><?= Loc::getMessage('SIZE_TABLE_LINK_TEXT') ?></a>
													<? } ?>
												</div>
												<div class="product-item-scu-container">
													<div class="product-item-scu-block">
														<div class="product-item-scu-list">
															<ul class="product-item-scu-item-list <?= $skuProperty['CODE'] ?>" code="<?= $skuProperty['CODE'] ?>">
																<?php
																foreach ($skuProperty['VALUES'] as &$value) {
																	$value['NAME'] = htmlspecialcharsbx($value['NAME']);

																	if ($skuProperty['SHOW_MODE'] === 'PICT') {
																?>
																		<li class="product-item-scu-item-color-container" title="<?= $value['NAME'] ?>"
																			data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
																			data-onevalue="<?= $value['ID'] ?>">
																			<div class="product-item-scu-item-color-block">
																				<div class="product-item-scu-item-color" title="<?= $value['NAME'] ?>"
																					style="background-image: url('<?= $value['PICT']['SRC'] ?>');">
																				</div>
																			</div>
																		</li>
																	<?php
																	} else {
																	?>
																		<li class="product-item-scu-item-text-container" title="<?= $value['NAME'] ?>" <?= $value['RUS_SIZE'] ? 'alternate="' . $value['RUS_SIZE'] . '"' : '' ?>
																			data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
																			data-onevalue="<?= $value['ID'] ?>">
																			<div class="product-item-scu-item-text-block">
																				<div class="product-item-scu-item-text"><?= $value['NAME'] ?></div>
																			</div>
																		</li>
																<?php
																	}
																}
																?>
															</ul>
															<div style="clear: both;"></div>
														</div>
													</div>
												</div>
											</div>
										<?php
										}
										?>
									</div>
								<?php
								}

								break;

							case 'props':
								if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']) {
								?>
									<div class="product-item-detail-info-container">
										<?php
										if (!empty($arResult['DISPLAY_PROPERTIES'])) {
										?>
											<dl class="product-item-detail-properties">
												<?php
												foreach ($arResult['DISPLAY_PROPERTIES'] as $property) {
													if (isset($arParams['MAIN_BLOCK_PROPERTY_CODE'][$property['CODE']])) {
												?>
														<dt><?= $property['NAME'] ?></dt>
														<dd><?= (is_array($property['DISPLAY_VALUE'])
																? implode(' / ', $property['DISPLAY_VALUE'])
																: $property['DISPLAY_VALUE']) ?>
														</dd>
												<?php
													}
												}
												unset($property);
												?>
											</dl>
										<?php
										}

										if ($arResult['SHOW_OFFERS_PROPS']) {
										?>
											<dl class="product-item-detail-properties" id="<?= $itemIds['DISPLAY_MAIN_PROP_DIV'] ?>"></dl>
										<?php
										}
										?>
									</div>
					<?php
								}

								break;
						}
					}
					?>
					<div class="delivery__buttons">
						<div class="delivery__buttons-list">
							<div id="<?= $itemIds['BASKET_ACTIONS_ID'] ?>" style="display: <?= ($actualItem['CAN_BUY'] ? '' : 'none') ?>;">
								<?php
								if ($showAddBtn) {
								?>
									<a class="btn <?= $showButtonClassName ?> product-item-detail-buy-button" id="<?= $itemIds['ADD_BASKET_LINK'] ?>"
										href="javascript:void(0);">
										<span><?= $arParams['MESS_BTN_ADD_TO_BASKET'] ?></span>
									</a>
								<?php
								}

								if ($showBuyBtn) {
								?>
									<a class="btn <?= $buyButtonClassName ?> product-item-detail-buy-button" id="<?= $itemIds['BUY_LINK'] ?>"
										href="javascript:void(0);">
										<span><?= $arParams['MESS_BTN_BUY'] ?></span>
									</a>
								<?php
								}
								?>
							</div>
							<?php
							if ($showSubscribe) {
							?>
								<div class="element__subscribe">
									<?php
									$APPLICATION->IncludeComponent(
										'bitrix:catalog.product.subscribe',
										'',
										array(
											'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
											'PRODUCT_ID' => $arResult['ID'],
											'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
											'BUTTON_CLASS' => 'btn btn-default product-item-detail-buy-button',
											'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
											'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
										),
										$component,
										array('HIDE_ICONS' => 'Y')
									);
									?>
								</div>
							<?php
							}
							?>
						</div>
						<div class="element__faforite">
							<button data-product-id="<?= $arResult['ID'] ?>" class="button element__favorite-button" type="button">
								<?= buildSVG('favorite', SITE_TEMPLATE_PATH . ICON_PATH) ?>
							</button>
						</div>
						<a class="btn btn-link product-item-detail-not-available" id="<?= $itemIds['NOT_AVAILABLE_MESS'] ?>"
							href="javascript:void(0)"
							rel="nofollow" style="display: none;">
						</a>
					</div>
					<div class="element__delivery">
						<?= buildSVG('lorry', SITE_TEMPLATE_PATH . ICON_PATH) ?>
						<ul class="element__delivery-list">
							<li class="element__delivery-time"><?= Loc::getMessage('DELIVERY_TIME', ['DATE' => FormatDate('d F', MakeTimeStamp((new \Bitrix\Main\Type\DateTime())->add("+1 weeks")))]) ?></li>
							<li class="element__delivery-price"><?= Loc::getMessage('DELIVERY_POINT') . CurrencyFormat($arResult['HUT_SETTINGS']['FREE_POINT_DELIVERY_VALUE'], 'RUB') ?></li>
							<li class="element__delivery-price"><?= Loc::getMessage('DELIVERY_COURIER') . CurrencyFormat($arResult['HUT_SETTINGS']['FREE_COURIER_DELIVERY_VALUE'], 'RUB') ?></li>
						</ul>
					</div>
					<div class="element__share">
						<p class="element__shave-title"><?= Loc::getMessage('SHARE') ?></p>
						<ul class="element__share-list">
							<li>
								<a href="https://vk.com/share.php?url=https://<?= $_SERVER['HTTP_HOST'] . $APPLICATION->getCurPage() ?>" target="_blank">
									<?= buildSVG('vk', SITE_TEMPLATE_PATH . ICON_PATH) ?>
								</a>
							</li>
							<li>
								<a href="https://telegram.me/share/url?url=https://<?= $_SERVER['HTTP_HOST'] . $APPLICATION->getCurPage() ?>">
									<?= buildSVG('tg', SITE_TEMPLATE_PATH . ICON_PATH) ?>
								</a>
							</li>
							<li class="element__share-item">
								<a href="https://<?= $_SERVER['HTTP_HOST'] . $APPLICATION->getCurPage() ?>" class="copy-link">
									<?= buildSVG('link', SITE_TEMPLATE_PATH . ICON_PATH) ?>
								</a>
								<span class="element__tooltip" style="display: none">
									<?= Loc::getMessage('LINK_COPYED') ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="27" height="4" viewBox="0 0 27 4" fill="none">
										<path d="M11.058 1.06005C11.9614 -0.363418 14.0386 -0.363417 14.942 1.06005L15.924 2.60747C16.4743 3.47462 17.4299 4 18.457 4H18.5L7.5 4H7.54304C8.57007 4 9.52572 3.47462 10.076 2.60747L11.058 1.06005Z" fill="#354052" />
									</svg>
								</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="product-item-detail-pay-block">
					<?php
					foreach ($arParams['PRODUCT_PAY_BLOCK_ORDER'] as $blockName) {
						switch ($blockName) {
							case 'rating':
								if ($arParams['USE_VOTE_RATING'] === 'Y') {
					?>
									<div class="product-item-detail-info-container">
										<?php
										$APPLICATION->IncludeComponent(
											'bitrix:iblock.vote',
											'stars',
											array(
												'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
												'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
												'IBLOCK_ID' => $arParams['IBLOCK_ID'],
												'ELEMENT_ID' => $arResult['ID'],
												'ELEMENT_CODE' => '',
												'MAX_VOTE' => '5',
												'VOTE_NAMES' => array('1', '2', '3', '4', '5'),
												'SET_STATUS_404' => 'N',
												'DISPLAY_AS_RATING' => $arParams['VOTE_DISPLAY_AS_RATING'],
												'CACHE_TYPE' => $arParams['CACHE_TYPE'],
												'CACHE_TIME' => $arParams['CACHE_TIME']
											),
											$component,
											array('HIDE_ICONS' => 'Y')
										);
										?>
									</div>
								<?php
								}

								break;

							case 'priceRanges':
								if ($arParams['USE_PRICE_COUNT']) {
									$showRanges = !$haveOffers && count($actualItem['ITEM_QUANTITY_RANGES']) > 1;
									$useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';
								?>
									<div class="product-item-detail-info-container"
										<?= $showRanges ? '' : 'style="display: none;"' ?>
										data-entity="price-ranges-block">
										<div class="product-item-detail-info-container-title">
											<?= $arParams['MESS_PRICE_RANGES_TITLE'] ?>
											<span data-entity="price-ranges-ratio-header">
												(<?= (Loc::getMessage(
														'CT_BCE_CATALOG_RATIO_PRICE',
														array('#RATIO#' => ($useRatio ? $measureRatio : '1') . ' ' . $actualItem['ITEM_MEASURE']['TITLE'])
													)) ?>)
											</span>
										</div>
										<dl class="product-item-detail-properties" data-entity="price-ranges-body">
											<?php
											if ($showRanges) {
												foreach ($actualItem['ITEM_QUANTITY_RANGES'] as $range) {
													if ($range['HASH'] !== 'ZERO-INF') {
														$itemPrice = false;

														foreach ($arResult['ITEM_PRICES'] as $itemPrice) {
															if ($itemPrice['QUANTITY_HASH'] === $range['HASH']) {
																break;
															}
														}

														if ($itemPrice) {
											?>
															<dt>
																<?php
																echo Loc::getMessage(
																	'CT_BCE_CATALOG_RANGE_FROM',
																	array('#FROM#' => $range['SORT_FROM'] . ' ' . $actualItem['ITEM_MEASURE']['TITLE'])
																) . ' ';

																if (is_infinite($range['SORT_TO'])) {
																	echo Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
																} else {
																	echo Loc::getMessage(
																		'CT_BCE_CATALOG_RANGE_TO',
																		array('#TO#' => $range['SORT_TO'] . ' ' . $actualItem['ITEM_MEASURE']['TITLE'])
																	);
																}
																?>
															</dt>
															<dd><?= ($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']) ?></dd>
											<?php
														}
													}
												}
											}
											?>
										</dl>
									</div>
									<?php
									unset($showRanges, $useRatio, $itemPrice, $range);
								}

								break;

							case 'quantityLimit':
								if ($arParams['SHOW_MAX_QUANTITY'] !== 'N') {
									if ($haveOffers) {
									?>
										<div class="product-item-detail-info-container" id="<?= $itemIds['QUANTITY_LIMIT'] ?>" style="display: none;">
											<div class="product-item-detail-info-container-title">
												<?= $arParams['MESS_SHOW_MAX_QUANTITY'] ?>:
												<span class="product-item-quantity" data-entity="quantity-limit-value"></span>
											</div>
										</div>
										<?php
									} else {
										if (
											$measureRatio
											&& (float)$actualItem['PRODUCT']['QUANTITY'] > 0
											&& $actualItem['CHECK_QUANTITY']
										) {
										?>
											<div class="product-item-detail-info-container" id="<?= $itemIds['QUANTITY_LIMIT'] ?>">
												<div class="product-item-detail-info-container-title">
													<?= $arParams['MESS_SHOW_MAX_QUANTITY'] ?>:
													<span class="product-item-quantity" data-entity="quantity-limit-value">
														<?php
														if ($arParams['SHOW_MAX_QUANTITY'] === 'M') {
															if ((float)$actualItem['PRODUCT']['QUANTITY'] / $measureRatio >= $arParams['RELATIVE_QUANTITY_FACTOR']) {
																echo $arParams['MESS_RELATIVE_QUANTITY_MANY'];
															} else {
																echo $arParams['MESS_RELATIVE_QUANTITY_FEW'];
															}
														} else {
															echo $actualItem['PRODUCT']['QUANTITY'] . ' ' . $actualItem['ITEM_MEASURE']['TITLE'];
														}
														?>
													</span>
												</div>
											</div>
									<?php
										}
									}
								}

								break;

							case 'quantity':
								if ($arParams['USE_PRODUCT_QUANTITY']) {
									?>
									<div class="product-item-detail-info-container" style="<?= (!$actualItem['CAN_BUY'] ? 'display: none;' : '') ?>"
										data-entity="quantity-block">
										<div class="product-item-detail-info-container-title"><?= Loc::getMessage('CATALOG_QUANTITY') ?></div>
										<div class="product-item-amount">
											<div class="product-item-amount-field-container">
												<span class="product-item-amount-field-btn-minus no-select" id="<?= $itemIds['QUANTITY_DOWN_ID'] ?>"></span>
												<input class="product-item-amount-field" id="<?= $itemIds['QUANTITY_ID'] ?>" type="number"
													value="<?= $price['MIN_QUANTITY'] ?>">
												<span class="product-item-amount-field-btn-plus no-select" id="<?= $itemIds['QUANTITY_UP_ID'] ?>"></span>
												<span class="product-item-amount-description-container">
													<span id="<?= $itemIds['QUANTITY_MEASURE'] ?>">
														<?= $actualItem['ITEM_MEASURE']['TITLE'] ?>
													</span>
													<span id="<?= $itemIds['PRICE_TOTAL'] ?>"></span>
												</span>
											</div>
										</div>
									</div>
						<?php
								}

								break;
						}
					}

					if ($arParams['DISPLAY_COMPARE']) {
						?>
						<div class="product-item-detail-compare-container">
							<div class="product-item-detail-compare">
								<div class="checkbox">
									<label id="<?= $itemIds['COMPARE_LINK'] ?>">
										<input type="checkbox" data-entity="compare-checkbox">
										<span data-entity="compare-title"><?= $arParams['MESS_BTN_COMPARE'] ?></span>
									</label>
								</div>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="container element__middle">
		<div class="element__detail-info">
			<div class="element__tab-togglers" id="<?= $itemIds['TABS_ID'] ?>">
				<ul class="product-item-detail-tabs-list">
					<li class="product-item-detail-tab active" data-entity="tab" data-value="description">
						<a href="javascript:void(0);" class="product-item-detail-tab-link">
							<span><?= $arParams['MESS_DESCRIPTION_TAB'] ?></span>
						</a>
					</li>
					<li class="product-item-detail-tab" data-entity="tab" data-value="comments">
						<a href="javascript:void(0);" class="product-item-detail-tab-link">
							<span><?= $arParams['MESS_COMMENTS_TAB'] ?></span>
							<span class="element__reviews-count"></span>
						</a>
					</li>
					<li class="product-item-detail-tab" data-entity="tab" data-value="properties">
						<a href="javascript:void(0);" class="product-item-detail-tab-link">
							<span><?= $arParams['MESS_PROPERTIES_TAB'] ?></span>
						</a>
					</li>
				</ul>
			</div>
			<div class="element__tab-content" id="<?= $itemIds['TAB_CONTAINERS_ID'] ?>">
				<div class="product-item-detail-tab-content active" data-entity="tab-container" data-value="description"
					itemprop="description" id="<?= $itemIds['DESCRIPTION_ID'] ?>">
					<div class="element__tab-inner">
						<div class="element__desc-block">
							<p class="element__tab-title"><?= $arParams['MESS_DESCRIPTION_TAB'] ?></p>
							<div class="element__tab-desc">
								<?php
								if (
									$arResult['PREVIEW_TEXT'] != ''
									&& (
										$arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'S'
										|| ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'E' && $arResult['DETAIL_TEXT'] == '')
									)
								) {
									echo $arResult['PREVIEW_TEXT_TYPE'] === 'html' ? $arResult['PREVIEW_TEXT'] : '<p>' . $arResult['PREVIEW_TEXT'] . '</p>';
								}

								if ($arResult['DETAIL_TEXT'] != '') {
									echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ? $arResult['DETAIL_TEXT'] : '<p>' . $arResult['DETAIL_TEXT'] . '</p>';
								}
								?>
							</div>
							<? if ($arResult['PROPERTIES']['TAGS']['VALUE']) { ?>
								<ul class="element__tags">
									<? foreach ($arResult['PROPERTIES']['TAGS']['VALUE'] as $tag) { ?>
										<li><?= $tag ?></li>
									<?	} ?>
								</ul>
							<? } ?>
							<?php
							if (!empty($arResult['DISPLAY_PROPERTIES'])) {
							?>
								<div class="element__chars">
									<?php
									foreach ($arResult['DISPLAY_PROPERTIES'] as $property) {
									?>
										<div class="element__chars-element">
											<span class="element__chars-title"><?= $property['NAME'] ?></span>
											<span class="element__chars-delimiter"></span>
											<span class="element__chars-value">
												<?= (
													is_array($property['DISPLAY_VALUE'])
													? implode(' / ', $property['DISPLAY_VALUE'])
													: $property['DISPLAY_VALUE']
												) ?>
											</span>
										</div>
									<?php
									}
									unset($property);
									?>
								</div>
							<?php
							}

							if ($arResult['SHOW_OFFERS_PROPS']) {
							?>
								<dl class="product-item-detail-properties" id="<?= $itemIds['DISPLAY_PROP_DIV'] ?>"></dl>
							<?php
							}
							?>
							<?
							$propNotNull = false;
							$segmentProps = [
								'STRETCHABILITY',
								'MOISTURE_WICKING',
								'WIND_PROTECTION',
								'THERMOREGULATION',
								'STRENGTH',
								'WATER_RESISTANCE',
								'FABRIC_NOISE'
							];
							foreach ($segmentProps as $prop) {
								if ($arResult['PROPERTIES'][$prop]['VALUE'] != '') {
									$propNotNull = true;
								}
							}
							if ($propNotNull) { ?>
								<div class="element__props">
									<p class="element__props-title"><?= Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB') ?></p>
									<?
									foreach ($segmentProps as $key => $prop) {
										if ($arResult['PROPERTIES'][$prop]['VALUE'] != '') { ?>
											<div class="element__props-item">
												<img src="<?= SITE_TEMPLATE_PATH . '/img/icons/' . $arResult['PROPERTIES'][$prop]['CODE'] . '.svg' ?>" alt="">
												<span class="element__props-item-title"><?= $arResult['PROPERTIES'][$prop]['NAME'] ?></span>
												<div class="element__props-values">
													<? for ($i = 1; $i < 11; $i++) { ?>
														<span class="element__props-segment <?= $arResult['PROPERTIES'][$prop]['VALUE'] >= $i ? 'active' : '' ?>"></span>
													<? } ?>
												</div>
											</div>
									<? }
									} ?>

								</div>
							<? } ?>
							<? if ($arResult['TEMP_IMG']) { ?>
								<div class="element__temperature-wrap">
									<div class="element__temperature">
										<span class="corner top-left"></span>
										<span class="corner top-right"></span>
										<span class="corner bottom-right"></span>
										<span class="corner bottom-left"></span>
										<p class="element__temperature-title"><?= $arResult['PROPERTIES']['TEMPERATURE']['NAME'] ?></p>
										<img src="<?= $arResult['TEMP_IMG'] ?>" alt="">
									</div>
									<div class="element__detail-img element__detail-img--mob">
										<? if ($arResult['DETAIL_PICTURE']['SRC']) { ?>
											<img src="<?= $arResult['DETAIL_PICTURE']['SRC'] ?>" alt="Фото товара" width="531">
										<? } ?>
									</div>
								</div>
							<? } ?>
						</div>
						<div class="element__detail-img element__detail-img--desc">
							<? if ($arResult['DETAIL_PICTURE']['SRC']) { ?>
								<img src="<?= $arResult['DETAIL_PICTURE']['SRC'] ?>" alt="Фото товара" width="531">
							<? } ?>
						</div>
					</div>
				</div>

				<div class="product-item-detail-tab-content" data-entity="tab-container" data-value="comments" style="display: none;">
					<div class="element__tab-inner element-tab-inner--comment">
						<div class="element__comment-left">
							<p class="element__tab-title"><?= $arParams['MESS_COMMENTS_TAB'] ?></p>
							<div class="element__comments-list">
								<?php
								$APPLICATION->IncludeComponent(
									'addamant:product.comments',
									'',
									[
										'BLOG_URL' => $arParams['BLOG_URL'],
										'IBLOCK_ID' => $arParams['IBLOCK_ID'],
										'ELEMENT_ID' => $arResult['ID'],
										'BLOG_GROUP_ID' => $arParams['BLOG_GROUP_ID'],
										'ELEMENT_COUNT' => $arParams['COMMENTS_COUNT'],
										'USER_ID' => $arParams['USER_ID'],
									],
									$component,
								);
								?>
							</div>
						</div>
						<div class="element__comment-right">
							<?php
							$APPLICATION->IncludeComponent(
								'addamant:product.rating',
								'thanks_catalog_detail',
								[
									'IBLOCK_ID' => $arParams['IBLOCK_ID'],
									'ELEMENT_ID' => $arResult['ID'],
									'USER_ID' => $arParams['USER_ID'],
								],
								$component,
							);
							?>
						</div>
					</div>
				</div>

				<div class="product-item-detail-tab-content" data-entity="tab-container" data-value="properties">
					<p class="element__tab-title"><?= $arParams['MESS_PROPERTIES_TAB'] ?></p>
					<div class="element__size-talbe-wrap">
						<p class="element__size-table-title"><?= $arResult['SIZE_TABLE']['NAME'] ?></p>
						<div class="element__size-table">
							<? if ($arResult['SIZE_TABLE']) {
								echo ($arResult['SIZE_TABLE']['DETAIL_TEXT']);
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php
			if ($arResult['CATALOG'] && $actualItem['CAN_BUY'] && \Bitrix\Main\ModuleManager::isModuleInstalled('sale')) {
				$APPLICATION->IncludeComponent(
					'bitrix:sale.prediction.product.detail',
					'.default',
					array(
						'BUTTON_ID' => $showBuyBtn ? $itemIds['BUY_LINK'] : $itemIds['ADD_BASKET_LINK'],
						'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
						'POTENTIAL_PRODUCT_TO_BUY' => array(
							'ID' => $arResult['ID'] ?? null,
							'MODULE' => $arResult['MODULE'] ?? 'catalog',
							'PRODUCT_PROVIDER_CLASS' => $arResult['~PRODUCT_PROVIDER_CLASS'] ?? \Bitrix\Catalog\Product\Basket::getDefaultProviderName(),
							'QUANTITY' => $arResult['QUANTITY'] ?? null,
							'IBLOCK_ID' => $arResult['IBLOCK_ID'] ?? null,

							'PRIMARY_OFFER_ID' => $arResult['OFFERS'][0]['ID'] ?? null,
							'SECTION' => array(
								'ID' => $arResult['SECTION']['ID'] ?? null,
								'IBLOCK_ID' => $arResult['SECTION']['IBLOCK_ID'] ?? null,
								'LEFT_MARGIN' => $arResult['SECTION']['LEFT_MARGIN'] ?? null,
								'RIGHT_MARGIN' => $arResult['SECTION']['RIGHT_MARGIN'] ?? null,
							),
						)
					),
					$component,
					array('HIDE_ICONS' => 'Y')
				);
			}

			if ($arResult['CATALOG'] && $arParams['USE_GIFTS_DETAIL'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale')) {
			?>
				<div data-entity="parent-container">
					<?php
					if (!isset($arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y') {
					?>
						<div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
							<?= ($arParams['GIFTS_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFT_BLOCK_TITLE_DEFAULT')) ?>
						</div>
					<?php
					}

					CBitrixComponent::includeComponentClass('bitrix:sale.products.gift');
					$APPLICATION->IncludeComponent(
						'bitrix:sale.products.gift',
						'.default',
						array(
							'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
							'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
							'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],

							'PRODUCT_ROW_VARIANTS' => "",
							'PAGE_ELEMENT_COUNT' => 0,
							'DEFERRED_PRODUCT_ROW_VARIANTS' => \Bitrix\Main\Web\Json::encode(
								SaleProductsGiftComponent::predictRowVariants(
									$arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
									$arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT']
								)
							),
							'DEFERRED_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],

							'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
							'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
							'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
							'PRODUCT_DISPLAY_MODE' => 'Y',
							'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],
							'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
							'SLIDER_INTERVAL' => $arParams['GIFTS_SLIDER_INTERVAL'] ?? '',
							'SLIDER_PROGRESS' => $arParams['GIFTS_SLIDER_PROGRESS'] ?? '',

							'TEXT_LABEL_GIFT' => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],

							'LABEL_PROP_' . $arParams['IBLOCK_ID'] => array(),
							'LABEL_PROP_MOBILE_' . $arParams['IBLOCK_ID'] => array(),
							'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],

							'ADD_TO_BASKET_ACTION' => ($arParams['ADD_TO_BASKET_ACTION'] ?? ''),
							'MESS_BTN_BUY' => $arParams['~GIFTS_MESS_BTN_BUY'],
							'MESS_BTN_ADD_TO_BASKET' => $arParams['~GIFTS_MESS_BTN_BUY'],
							'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
							'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
							'MESS_BTN_COMPARE' => $arParams['~MESS_BTN_COMPARE'],
							'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE'],
							'MESS_SHOW_MAX_QUANTITY' => $arParams['~MESS_SHOW_MAX_QUANTITY'],
							'MESS_RELATIVE_QUANTITY_MANY' => $arParams['~MESS_RELATIVE_QUANTITY_MANY'],
							'MESS_RELATIVE_QUANTITY_FEW' => $arParams['~MESS_RELATIVE_QUANTITY_FEW'],

							'SHOW_PRODUCTS_' . $arParams['IBLOCK_ID'] => 'Y',
							'PROPERTY_CODE_' . $arParams['IBLOCK_ID'] => [],
							'PROPERTY_CODE_MOBILE' . $arParams['IBLOCK_ID'] => [],
							'PROPERTY_CODE_' . $arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
							'OFFER_TREE_PROPS_' . $arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
							'CART_PROPERTIES_' . $arResult['OFFERS_IBLOCK'] => $arParams['OFFERS_CART_PROPERTIES'],
							'ADDITIONAL_PICT_PROP_' . $arParams['IBLOCK_ID'] => ($arParams['ADD_PICT_PROP'] ?? ''),
							'ADDITIONAL_PICT_PROP_' . $arResult['OFFERS_IBLOCK'] => ($arParams['OFFER_ADD_PICT_PROP'] ?? ''),

							'HIDE_NOT_AVAILABLE' => 'Y',
							'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
							'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
							'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
							'PRICE_CODE' => $arParams['PRICE_CODE'],
							'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
							'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
							'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
							'BASKET_URL' => $arParams['BASKET_URL'],
							'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
							'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
							'PARTIAL_PRODUCT_PROPERTIES' => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
							'USE_PRODUCT_QUANTITY' => 'N',
							'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
							'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
							'POTENTIAL_PRODUCT_TO_BUY' => array(
								'ID' => $arResult['ID'] ?? null,
								'MODULE' => $arResult['MODULE'] ?? 'catalog',
								'PRODUCT_PROVIDER_CLASS' => $arResult['~PRODUCT_PROVIDER_CLASS'] ?? \Bitrix\Catalog\Product\Basket::getDefaultProviderName(),
								'QUANTITY' => $arResult['QUANTITY'] ?? null,
								'IBLOCK_ID' => $arResult['IBLOCK_ID'] ?? null,

								'PRIMARY_OFFER_ID' => $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'] ?? null,
								'SECTION' => array(
									'ID' => $arResult['SECTION']['ID'] ?? null,
									'IBLOCK_ID' => $arResult['SECTION']['IBLOCK_ID'] ?? null,
									'LEFT_MARGIN' => $arResult['SECTION']['LEFT_MARGIN'] ?? null,
									'RIGHT_MARGIN' => $arResult['SECTION']['RIGHT_MARGIN'] ?? null,
								),
							),

							'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
							'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
							'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
						),
						$component,
						array('HIDE_ICONS' => 'Y')
					);
					?>
				</div>
			<?php
			}

			if ($arResult['CATALOG'] && $arParams['USE_GIFTS_MAIN_PR_SECTION_LIST'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale')) {
			?>
				<div data-entity="parent-container">
					<?php
					if (!isset($arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y') {
					?>
						<div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
							<?= ($arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFTS_MAIN_BLOCK_TITLE_DEFAULT')) ?>
						</div>
					<?php
					}

					$APPLICATION->IncludeComponent(
						'bitrix:sale.gift.main.products',
						'.default',
						array(
							'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
							'PAGE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
							'LINE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
							'HIDE_BLOCK_TITLE' => 'Y',
							'BLOCK_TITLE' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],

							'OFFERS_FIELD_CODE' => $arParams['OFFERS_FIELD_CODE'],
							'OFFERS_PROPERTY_CODE' => $arParams['OFFERS_PROPERTY_CODE'],

							'AJAX_MODE' => $arParams['AJAX_MODE'] ?? '',
							'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
							'IBLOCK_ID' => $arParams['IBLOCK_ID'],

							'ELEMENT_SORT_FIELD' => 'ID',
							'ELEMENT_SORT_ORDER' => 'DESC',
							'FILTER_NAME' => 'searchFilter',
							'SECTION_URL' => $arParams['SECTION_URL'],
							'DETAIL_URL' => $arParams['DETAIL_URL'],
							'BASKET_URL' => $arParams['BASKET_URL'],
							'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
							'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
							'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],

							'CACHE_TYPE' => $arParams['CACHE_TYPE'],
							'CACHE_TIME' => $arParams['CACHE_TIME'],

							'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
							'SET_TITLE' => $arParams['SET_TITLE'],
							'PROPERTY_CODE' => $arParams['PROPERTY_CODE'],
							'PRICE_CODE' => $arParams['PRICE_CODE'],
							'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
							'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],

							'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
							'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
							'CURRENCY_ID' => $arParams['CURRENCY_ID'],
							'HIDE_NOT_AVAILABLE' => 'Y',
							'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
							'TEMPLATE_THEME' => ($arParams['TEMPLATE_THEME'] ?? ''),
							'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],

							'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
							'SLIDER_INTERVAL' => $arParams['GIFTS_SLIDER_INTERVAL'] ?? '',
							'SLIDER_PROGRESS' => $arParams['GIFTS_SLIDER_PROGRESS'] ?? '',

							'ADD_PICT_PROP' => ($arParams['ADD_PICT_PROP'] ?? ''),
							'LABEL_PROP' => ($arParams['LABEL_PROP'] ?? ''),
							'LABEL_PROP_MOBILE' => ($arParams['LABEL_PROP_MOBILE'] ?? ''),
							'LABEL_PROP_POSITION' => ($arParams['LABEL_PROP_POSITION'] ?? ''),
							'OFFER_ADD_PICT_PROP' => ($arParams['OFFER_ADD_PICT_PROP'] ?? ''),
							'OFFER_TREE_PROPS' => ($arParams['OFFER_TREE_PROPS'] ?? ''),
							'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] ?? ''),
							'DISCOUNT_PERCENT_POSITION' => ($arParams['DISCOUNT_PERCENT_POSITION'] ?? ''),
							'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] ?? ''),
							'MESS_BTN_BUY' => ($arParams['~MESS_BTN_BUY'] ?? ''),
							'MESS_BTN_ADD_TO_BASKET' => ($arParams['~MESS_BTN_ADD_TO_BASKET'] ?? ''),
							'MESS_BTN_DETAIL' => ($arParams['~MESS_BTN_DETAIL'] ?? ''),
							'MESS_NOT_AVAILABLE' => ($arParams['~MESS_NOT_AVAILABLE'] ?? ''),
							'ADD_TO_BASKET_ACTION' => ($arParams['ADD_TO_BASKET_ACTION'] ?? ''),
							'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] ?? ''),
							'DISPLAY_COMPARE' => ($arParams['DISPLAY_COMPARE'] ?? ''),
							'COMPARE_PATH' => ($arParams['COMPARE_PATH'] ?? ''),
						)
							+ array(
								'OFFER_ID' => empty($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'])
									? $arResult['ID']
									: $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'],
								'SECTION_ID' => $arResult['SECTION']['ID'],
								'ELEMENT_ID' => $arResult['ID'],

								'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
								'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
								'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
							),
						$component,
						array('HIDE_ICONS' => 'Y')
					);
					?>
				</div>
			<?php
			}
			?>
		</div>
	</div>
</div>

<?
if ($arResult['PROPERTIES']['COMPLECT']['VALUE']) {
	$GLOBALS['elementComplectFilter'] = ['ID' => $arResult['PROPERTIES']['COMPLECT']['VALUE']];
	$APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		"main-page",
		array(
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"ADD_PICT_PROP" => $arParams['ADD_PICT_PROP'] ?? '',
			"ADD_PROPERTIES_TO_BASKET" => ($arParams["ADD_PROPERTIES_TO_BASKET"] ?? ''),
			"ADD_SECTIONS_CHAIN" => 'N',
			"ADD_TO_BASKET_ACTION" => "ADD",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"BACKGROUND_IMAGE" => "-",
			"BASKET_URL" => $arParams["BASKET_URL"],
			"BROWSER_TITLE" => "-",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"COMPATIBLE_MODE" => ($arParams['COMPATIBLE_MODE'] ?? ''),
			"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
			"CUSTOM_FILTER" => "",
			"DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
			"DISABLE_INIT_JS_IN_COMPONENT" => "N",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
			"DISPLAY_TOP_PAGER" => "N",
			"ELEMENT_SORT_FIELD" => $arParams["TOP_ELEMENT_SORT_FIELD"],
			"ELEMENT_SORT_ORDER" => $arParams["TOP_ELEMENT_SORT_ORDER"],
			"ELEMENT_SORT_FIELD2" => $arParams["TOP_ELEMENT_SORT_FIELD2"],
			"ELEMENT_SORT_ORDER2" => $arParams["TOP_ELEMENT_SORT_ORDER2"],
			"ENLARGE_PRODUCT" => $arParams['TOP_ENLARGE_PRODUCT'],
			"FILTER_NAME" => "elementComplectFilter",
			'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
			"HIDE_NOT_AVAILABLE_OFFERS" => "N",
			"IBLOCK_ID" => $arParams['IBLOCK_ID'],
			"IBLOCK_TYPE" => "hut",
			"INCLUDE_SUBSECTIONS" => "Y",
			"LABEL_PROP" => $arParams['LABEL_PROP'] ?? '',
			"LABEL_PROP_MOBILE" => $arParams['LABEL_PROP_MOBILE'] ?? '',
			"LABEL_PROP_POSITION" => $arParams['LABEL_PROP_POSITION'] ?? '',
			"LAZY_LOAD" => "N",
			"LINE_ELEMENT_COUNT" => "3",
			"LOAD_ON_SCROLL" => "N",
			"MESSAGE_404" => "",
			"MESS_BTN_ADD_TO_BASKET" => $arParams['~MESS_BTN_ADD_TO_BASKET'],
			"MESS_BTN_BUY" => $arParams['~MESS_BTN_BUY'],
			"MESS_BTN_DETAIL" => $arParams['~MESS_BTN_DETAIL'],
			"MESS_BTN_LAZY_LOAD" => "Показать ещё",
			"MESS_BTN_SUBSCRIBE" => $arParams['~MESS_BTN_SUBSCRIBE'],
			'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE'] ?? '',
			'MESS_NOT_AVAILABLE_SERVICE' => $arParams['~MESS_NOT_AVAILABLE_SERVICE'] ?? '',
			"META_DESCRIPTION" => "-",
			"META_KEYWORDS" => "-",
			"OFFERS_CART_PROPERTIES" => ($arParams["OFFERS_CART_PROPERTIES"] ?? []),
			"OFFERS_FIELD_CODE" => $arParams["TOP_OFFERS_FIELD_CODE"] ?? [],
			"OFFERS_LIMIT" => ($arParams["TOP_OFFERS_LIMIT"] ?? 0),
			"OFFERS_PROPERTY_CODE" => ($arParams["TOP_OFFERS_PROPERTY_CODE"] ?? []),
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"PAGER_BASE_LINK_ENABLE" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => ".default",
			"PAGER_TITLE" => "Товары",
			"PAGE_ELEMENT_COUNT" => "24",
			"PARTIAL_PRODUCT_PROPERTIES" => ($arParams["PARTIAL_PRODUCT_PROPERTIES"] ?? ''),
			"PRICE_CODE" => $arParams["~PRICE_CODE"],
			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"PRODUCT_BLOCKS_ORDER" => $arParams['TOP_PRODUCT_BLOCKS_ORDER'],
			"PRODUCT_DISPLAY_MODE" => $arParams['PRODUCT_DISPLAY_MODE'],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"PRODUCT_PROPERTIES" => ($arParams["PRODUCT_PROPERTIES"] ?? []),
			"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"PRODUCT_ROW_VARIANTS" => $arParams['TOP_PRODUCT_ROW_VARIANTS'],
			"PRODUCT_SUBSCRIPTION" => $arParams['PRODUCT_SUBSCRIPTION'],
			"PROPERTY_CODE" => ($arParams["TOP_PROPERTY_CODE"] ?? []),
			"PROPERTY_CODE_MOBILE" => $arParams["TOP_PROPERTY_CODE_MOBILE"] ?? [],
			"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
			"RCM_TYPE" => "personal",
			"SECTION_CODE" => "",
			"SECTION_ID" => $sectionId,
			"SECTION_ID_VARIABLE" => "SECTION_ID",
			"SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
			"SECTION_USER_FIELDS" => array(
				0 => "",
				1 => "",
			),
			"SEF_MODE" => "N",
			"SET_BROWSER_TITLE" => "N",
			"SET_LAST_MODIFIED" => "N",
			"SET_META_DESCRIPTION" => "N",
			"SET_META_KEYWORDS" => "N",
			"SET_STATUS_404" => "N",
			"SET_TITLE" => "N",
			"SHOW_404" => "N",
			"SHOW_ALL_WO_SECTION" => "N",
			"SHOW_CLOSE_POPUP" => $arParams['COMMON_SHOW_CLOSE_POPUP'] ?? '',
			"SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
			"SHOW_FROM_SECTION" => "N",
			"SHOW_MAX_QUANTITY" => "N",
			"SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
			"SHOW_SLIDER" => 'N',
			"SLIDER_INTERVAL" => $arParams['TOP_SLIDER_INTERVAL'] ?? '',
			"SLIDER_PROGRESS" => $arParams['TOP_SLIDER_PROGRESS'] ?? '',
			"TEMPLATE_THEME" => ($arParams['TEMPLATE_THEME'] ?? ''),
			"USE_ENHANCED_ECOMMERCE" => "N",
			"USE_MAIN_ELEMENT_SECTION" => "N",
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
			"COMPONENT_TEMPLATE" => "main-catalog",
			"BLOCK_TITLE" => GetMessage('CATALOG_RECOMMENDED_BY_LINK'),
		),
		$component,
		false
	);
}
?>

<meta itemprop="name" content="<?= $name ?>" />
<meta itemprop="category" content="<?= $arResult['CATEGORY_PATH'] ?>" />
<?php
if ($haveOffers) {
	foreach ($arResult['JS_OFFERS'] as $offer) {
		$currentOffersList = array();

		if (!empty($offer['TREE']) && is_array($offer['TREE'])) {
			foreach ($offer['TREE'] as $propName => $skuId) {
				$propId = (int)mb_substr($propName, 5);

				foreach ($skuProps as $prop) {
					if ($prop['ID'] == $propId) {
						foreach ($prop['VALUES'] as $propId => $propValue) {
							if ($propId == $skuId) {
								$currentOffersList[] = $propValue['NAME'];
								break;
							}
						}
					}
				}
			}
		}

		$offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
?>
		<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<meta itemprop="sku" content="<?= htmlspecialcharsbx(implode('/', $currentOffersList)) ?>" />
			<meta itemprop="price" content="<?= $offerPrice['RATIO_PRICE'] ?>" />
			<meta itemprop="priceCurrency" content="<?= $offerPrice['CURRENCY'] ?>" />
			<link itemprop="availability" href="http://schema.org/<?= ($offer['CAN_BUY'] ? 'InStock' : 'OutOfStock') ?>" />
		</span>
	<?php
	}

	unset($offerPrice, $currentOffersList);
} else {
	?>
	<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
		<meta itemprop="price" content="<?= $price['RATIO_PRICE'] ?>" />
		<meta itemprop="priceCurrency" content="<?= $price['CURRENCY'] ?>" />
		<link itemprop="availability" href="http://schema.org/<?= ($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock') ?>" />
	</span>
<?php
}
?>
</div>
<?php
if ($haveOffers) {
	$offerIds = array();
	$offerCodes = array();

	$useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

	foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer) {
		$offerIds[] = (int)$jsOffer['ID'];
		$offerCodes[] = $jsOffer['CODE'];

		$fullOffer = $arResult['OFFERS'][$ind];
		$measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

		$strAllProps = '';
		$strMainProps = '';
		$strPriceRangesRatio = '';
		$strPriceRanges = '';

		if ($arResult['SHOW_OFFERS_PROPS']) {
			if (!empty($jsOffer['DISPLAY_PROPERTIES'])) {
				foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property) {
					$current = '<dt>' . $property['NAME'] . '</dt><dd>' . (
						is_array($property['VALUE'])
						? implode(' / ', $property['VALUE'])
						: $property['VALUE']
					) . '</dd>';
					$strAllProps .= $current;

					if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']])) {
						$strMainProps .= $current;
					}
				}

				unset($current);
			}
		}

		if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1) {
			$strPriceRangesRatio = '(' . Loc::getMessage(
				'CT_BCE_CATALOG_RATIO_PRICE',
				array('#RATIO#' => ($useRatio
					? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
					: '1'
				) . ' ' . $measureName)
			) . ')';

			foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range) {
				if ($range['HASH'] !== 'ZERO-INF') {
					$itemPrice = false;

					foreach ($jsOffer['ITEM_PRICES'] as $itemPrice) {
						if ($itemPrice['QUANTITY_HASH'] === $range['HASH']) {
							break;
						}
					}

					if ($itemPrice) {
						$strPriceRanges .= '<dt>' . Loc::getMessage(
							'CT_BCE_CATALOG_RANGE_FROM',
							array('#FROM#' => $range['SORT_FROM'] . ' ' . $measureName)
						) . ' ';

						if (is_infinite($range['SORT_TO'])) {
							$strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
						} else {
							$strPriceRanges .= Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_TO',
								array('#TO#' => $range['SORT_TO'] . ' ' . $measureName)
							);
						}

						$strPriceRanges .= '</dt><dd>' . ($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']) . '</dd>';
					}
				}
			}

			unset($range, $itemPrice);
		}

		$jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
		$jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
		$jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
		$jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
	}

	$templateData['OFFER_IDS'] = $offerIds;
	$templateData['OFFER_CODES'] = $offerCodes;
	unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null,
			'SHOW_SKU_DESCRIPTION' => $arParams['SHOW_SKU_DESCRIPTION'],
			'DISPLAY_PREVIEW_TEXT_MODE' => $arParams['DISPLAY_PREVIEW_TEXT_MODE']
		),
		'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
		'VISUAL' => $itemIds,
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'NAME' => $arResult['~NAME'],
			'CATEGORY' => $arResult['CATEGORY_PATH'],
			'DETAIL_TEXT' => $arResult['DETAIL_TEXT'],
			'DETAIL_TEXT_TYPE' => $arResult['DETAIL_TEXT_TYPE'],
			'PREVIEW_TEXT' => $arResult['PREVIEW_TEXT'],
			'PREVIEW_TEXT_TYPE' => $arResult['PREVIEW_TEXT_TYPE']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $skuProps
	);
} else {
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties) {
?>
		<div id="<?= $itemIds['BASKET_PROP_DIV'] ?>" style="display: none;">
			<?php
			if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])) {
				foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo) {
			?>
					<input type="hidden" name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]" value="<?= htmlspecialcharsbx($propInfo['ID']) ?>">
				<?php
					unset($arResult['PRODUCT_PROPERTIES'][$propId]);
				}
			}

			$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
			if (!$emptyProductProperties) {
				?>
				<table>
					<?php
					foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo) {
					?>
						<tr>
							<td><?= $arResult['PROPERTIES'][$propId]['NAME'] ?></td>
							<td>
								<?php
								if (
									$arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
									&& $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
								) {
									foreach ($propInfo['VALUES'] as $valueId => $value) {
								?>
										<label>
											<input type="radio" name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]"
												value="<?= $valueId ?>" <?= ($valueId == $propInfo['SELECTED'] ? '"checked"' : '') ?>>
											<?= $value ?>
										</label>
										<br>
									<?php
									}
								} else {
									?>
									<select name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]">
										<?php
										foreach ($propInfo['VALUES'] as $valueId => $value) {
										?>
											<option value="<?= $valueId ?>" <?= ($valueId == $propInfo['SELECTED'] ? '"selected"' : '') ?>>
												<?= $value ?>
											</option>
										<?php
										}
										?>
									</select>
								<?php
								}
								?>
							</td>
						</tr>
					<?php
					}
					?>
				</table>
			<?php
			}
			?>
		</div>
<?php
	}

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'VISUAL' => $itemIds,
		'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'PICT' => reset($arResult['MORE_PHOTO']),
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
			'ITEM_PRICES' => $arResult['ITEM_PRICES'],
			'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
			'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
			'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
			'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
			'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
			'MAX_QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
			'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
			'CATEGORY' => $arResult['CATEGORY_PATH']
		),
		'BASKET' => array(
			'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	unset($emptyProductProperties);
}

if ($arParams['DISPLAY_COMPARE']) {
	$jsParams['COMPARE'] = array(
		'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
		'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
		'COMPARE_PATH' => $arParams['COMPARE_PATH']
	);
}

$jsParams["IS_FACEBOOK_CONVERSION_CUSTOMIZE_PRODUCT_EVENT_ENABLED"] =
	$arResult["IS_FACEBOOK_CONVERSION_CUSTOMIZE_PRODUCT_EVENT_ENABLED"];

?>
<script>
	BX.message({
		ECONOMY_INFO_MESSAGE: '<?= GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2') ?>',
		TITLE_ERROR: '<?= GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
		TITLE_BASKET_PROPS: '<?= GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
		BASKET_UNKNOWN_ERROR: '<?= GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
		BTN_SEND_PROPS: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS') ?>',
		BTN_MESSAGE_DETAIL_BASKET_REDIRECT: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT') ?>',
		BTN_MESSAGE_CLOSE: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE') ?>',
		BTN_MESSAGE_DETAIL_CLOSE_POPUP: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP') ?>',
		TITLE_SUCCESSFUL: '<?= GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK') ?>',
		COMPARE_MESSAGE_OK: '<?= GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK') ?>',
		COMPARE_UNKNOWN_ERROR: '<?= GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
		COMPARE_TITLE: '<?= GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE') ?>',
		BTN_MESSAGE_COMPARE_REDIRECT: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
		PRODUCT_GIFT_LABEL: '<?= GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL') ?>',
		PRICE_TOTAL_PREFIX: '<?= GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX') ?>',
		RELATIVE_QUANTITY_MANY: '<?= CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY']) ?>',
		RELATIVE_QUANTITY_FEW: '<?= CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW']) ?>',
		SITE_ID: '<?= CUtil::JSEscape($component->getSiteId()) ?>'
	});

	var <?= $obName ?> = new JCCatalogElement(<?= CUtil::PhpToJSObject($jsParams, false, true) ?>);
</script>
<?php
unset($actualItem, $itemIds, $jsParams);
