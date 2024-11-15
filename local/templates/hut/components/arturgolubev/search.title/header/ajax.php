<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

IncludeTemplateLangFile(__FILE__);

$arParams["SHOW_PREVIEW_TEXT"] = ($arParams["SHOW_PREVIEW_TEXT"]) ? $arParams["SHOW_PREVIEW_TEXT"] : 'Y';

$preview = ($arParams["SHOW_PREVIEW"] != 'N');

$image_style = '';
$info_style = '';

if ($preview) {
	if ($arParams["PREVIEW_WIDTH_NEW"]) {
		$image_style .= 'width: ' . $arParams["PREVIEW_WIDTH_NEW"] . 'px;';
		$info_style .= 'padding-left: ' . ($arParams["PREVIEW_WIDTH_NEW"] + 5) . 'px;';
	}
	if ($arParams["PREVIEW_HEIGHT_NEW"]) {
		$image_style .= 'height: ' . $arParams["PREVIEW_HEIGHT_NEW"] . 'px;';
	}
	if ($info_style) $info_style = 'style="' . $info_style . '"';
}
?>

<div class="bx_smart_searche bx_searche <?= $arResult["VISUAL_PARAMS"]["THEME_CLASS"] ?>">
	<?
	if ($arResult["DEBUG"]["SHOW"] == 'Y') {
		echo '<pre>Debug Info: ';
		print_r($arResult["DEBUG"]);
		echo '</pre>';
	}
	?>
	<? if (!empty($arResult["ELEMENTS"])): ?>
		<? foreach ($arResult["CATEGORIES"] as $category_id => $arCategory): ?>
			<?/* if ($arParams['NUM_CATEGORIES'] > 1 && count($arCategory["ITEMS"]) && $arCategory['TITLE']): ?>
				<div class="js_search_href bx_item_block_title"><?= $arCategory['TITLE'] ?></div>
			<? endif; */ ?>

			<?/* foreach ($arCategory["ITEMS"] as $i => $arItem): ?>
				<? if (isset($arResult["SECTIONS"][$arItem["ITEM_ID"]])):
					$arElement = $arResult["SECTIONS"][$arItem["ITEM_ID"]];

					if (is_array($arElement["PICTURE"]))
						$image_url = $arElement["PICTURE"]["src"];
					else
						$image_url = '/bitrix/components/arturgolubev/search.title/templates/.default/images/noimg.png';
				?>
					<a class="js_search_href bx_item_block_href bx_item_block_section" href="<? echo $arItem["URL"] ?>">
						<? if ($preview): ?>
							<span class="bx_item_block_item_image" style="<?= $image_style ?>"><img src="<?= $image_url ?>" alt=""></span>
						<? endif; ?>
						<span class="bx_item_block_href_category_title"><?= ($arElement["PATH"]) ? $arElement["PATH"] : GetMessage("AG_SMARTIK_SECTION_TITLE"); ?></span><br>
						<span class="bx_item_block_href_category_name"><? echo strip_tags($arItem["NAME"]) ?></span>
						<span class="bx_item_block_item_clear"></span>
					</a>
					<div class="bx_item_block_hrline"></div>
				<? endif; ?>
			<? endforeach; */ ?>

			<? foreach ($arCategory["ITEMS"] as $i => $arItem): ?>

				<? if (isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):
					$arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];
					$arElement["PREVIEW_TEXT"] = strip_tags($arElement["PREVIEW_TEXT"]);
					if ($arItem['IS_HINT']) {
						$image_url = '/bitrix/components/arturgolubev/search.title/templates/.default/images/search-icon.svg';
					} elseif (is_array($arElement["PICTURE"])) {
						$image_url = $arElement["PICTURE"]["src"];
					} else {
						$image_url = '/bitrix/components/arturgolubev/search.title/templates/.default/images/noimg.png';
					}
				?>

					<a class="js_search_href bx_item_block_href bx_item_block_element" href="<? echo $arItem["URL"] ?>">
						<div class="bx_item_block_item_info">
							<div class="search-item__top">
								<? foreach ($arElement["PROPS"] as $prop) {
									if ($prop['CODE'] == 'TYPE' && $prop['VALUE'] != '') { ?>
										<div class="search-item__label">
											<?= $prop['VALUE_XML_ID'] ? buildSVG($prop['VALUE_XML_ID'], SITE_TEMPLATE_PATH . ICON_PATH) : '' ?>
											<span><?= $prop['VALUE'] ?></span>
										</div>
								<? }
								} ?>
								<button type="button" class="button search-item__favorites"><?= buildSVG('product-favorite', SITE_TEMPLATE_PATH . ICON_PATH) ?></button>
							</div>
							<? if ($preview): ?>
								<? foreach ($arElement["PROPS"] as $prop) {
									$isFull = false;
									if ($prop['CODE'] == 'FULL_PREVIEW' && $prop['VALUE'] != '') {
										$isFull = true;
									}
								} ?>
								<span class="bx_item_block_item_image <?= $isFull ? 'full' : '' ?>"><img src="<?= CFile::GetPath($arElement["PREVIEW_PICTURE"]) ?>" alt=""></span>
							<? endif; ?>

							<span class="bx_item_block_item_info_wrap <? if ($preview) echo 'wpic'; ?>" <?= $info_style ?>>
								<?
								foreach ($arElement["PRICES"] as $code => $arPrice) {
									if ($arPrice["MIN_PRICE"] != "Y")
										continue;

									if ($arPrice["CAN_ACCESS"]) {
										if ($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]): ?>
											<span class="bx_item_block_item_price">
												<span class="bx_price_new discount">
													<?= $arPrice["PRINT_DISCOUNT_VALUE"] ?>
												</span>
												<span class="bx_price_old"><?= $arPrice["PRINT_VALUE"] ?></span>
											</span>
										<? else: ?>
											<span class="bx_item_block_item_price bx_item_block_item_price_only_one">
												<span class="bx_price_new"><?= $arPrice["PRINT_VALUE"] ?></span>
											</span>
								<? endif;
									}
									if ($arPrice["MIN_PRICE"] == "Y")
										break;
								}
								?>

								<span class="bx_item_block_item_name">
									<span class="bx_item_block_item_name_flex_align">
										<? echo $arItem["NAME"] ?>
									</span>
								</span>
							</span>
						</div>
					</a>
				<? endif; ?>
			<? endforeach; ?>

			<?/* foreach ($arCategory["ITEMS"] as $i => $arItem): ?>
				<? if (isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]]) || isset($arResult["SECTIONS"][$arItem["ITEM_ID"]])):
					continue;
				elseif ($category_id === "all"): ?>
					<div class="js_search_href bx_item_block all_result">
						<div class="js_search_href bx_item_element bx_item_element_all_result">
							<a class="js_search_href all_result_button" href="<? echo $arItem["URL"] ?>"><? echo $arItem["NAME"] ?></a>
						</div>
						<div style="clear:both;"></div>
					</div>
				<? else: ?>
					<a class="js_search_href bx_item_block_href bx_item_block_other" href="<? echo $arItem["URL"] ?>">
						<span class="bx_item_block_item_simple_name"><? echo $arItem["NAME"] ?></span>
					</a>
				<? endif; ?>
			<? endforeach; */ ?>
		<? endforeach; ?>
	<? else: ?>
		<div class="bx_smart_no_result_find">
			<?= GetMessage("AG_SMARTIK_NO_RESULT"); ?>
		</div>
	<? endif; ?>
</div>