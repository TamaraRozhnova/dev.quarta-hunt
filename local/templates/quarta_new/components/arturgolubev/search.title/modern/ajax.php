<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (empty($arResult["CATEGORIES"]) && $arResult["DEBUG"]["SHOW"] != 'Y') return;

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
		// echo '<pre>'; print_r($arResult["CATEGORIES"]); echo '</pre>';
	}
	?>

	<? if (!empty($arResult["CATEGORIES"])): ?>
		<? foreach ($arResult["CATEGORIES"] as $category_id => $arCategory): ?>
			<? if ($arParams['NUM_CATEGORIES'] > 1 && count($arCategory["ITEMS"]) && $arCategory['TITLE']): ?>
				<div class="js_search_href bx_item_block_title"><?= $arCategory['TITLE'] ?></div>
			<? endif; ?>

			<? foreach ($arCategory["ITEMS"] as $i => $arItem): ?>
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
						<?/* <span class="bx_item_block_href_category_title"><?=GetMessage("AG_SMARTIK_SECTION_TITLE");?></span><br> */ ?>
						<span class="bx_item_block_href_category_title"><?= ($arElement["PATH"]) ? $arElement["PATH"] : GetMessage("AG_SMARTIK_SECTION_TITLE"); ?></span><br>
						<span class="bx_item_block_href_category_name"><? echo strip_tags($arItem["NAME"]) ?></span>
						<span class="bx_item_block_item_clear"></span>
					</a>
					<div class="bx_item_block_hrline"></div>
				<? endif; ?>
			<? endforeach; ?>

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
						<span class="bx_item_block_item_info">
							<? if ($preview): ?>
								<? if ($arItem['IS_HINT']): ?>
									<span class="bx_item_block_item_image" style="<?= $image_style ?>">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30px" height="30px">
											<path fill="currentColor" d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z" />
										</svg>
									</span>
								<? else: ?>
									<span class="bx_item_block_item_image" style="<?= $image_style ?>"><img src="<?= $image_url ?>" alt=""></span>
								<? endif; ?>
							<? endif; ?>

							<span class="bx_item_block_item_info_wrap <? if ($preview) echo 'wpic'; ?>" <?= $info_style ?>>
								<?
								foreach ($arElement["PRICES"] as $code => $arPrice) {
									if ($arPrice["MIN_PRICE"] != "Y")
										continue;

									if ($arPrice["CAN_ACCESS"]) {
										if ($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]): ?>
											<span class="bx_item_block_item_price">
												<span class="bx_price_new">
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

									<?/* if($arResult["DEBUG"]["SHOW_DEBUG"] == 'Y'):?>
										&nbsp;<span class="bx_item_block_item_name_flex_align">
											(<?echo $arItem["NAME_S"]?>)
										</span>
									<?endif; */ ?>
								</span>

								<? if ($arParams['SHOW_QUANTITY'] == 'Y' && $arElement['CATALOG_TYPE'] != 3 && strlen($arElement['CATALOG_QUANTITY']) > 0):
									// echo '<pre>'; print_r($arResult['MEASURES']); echo '</pre>';
									// echo '<pre>'; print_r($arElement); echo '</pre>';
								?>
									<span class="bx_item_block_item_props">
										<?= GetMessage('AG_SMARTIK_CATALOG_QUANTITY') ?>: <?= $arElement['CATALOG_QUANTITY'] ?>
										<? if ($arElement['CATALOG_MEASURE'] && is_array($arResult['MEASURES'][$arElement['CATALOG_MEASURE']])) echo $arResult['MEASURES'][$arElement['CATALOG_MEASURE']]['SYMBOL']; ?>
									</span>
								<? endif; ?>

								<? if (!empty($arElement["PROPS"])): ?>
									<span class="bx_item_block_item_props">
										<? foreach ($arElement["PROPS"] as $prop):
											if (empty($prop["VALUE"])) continue;
										?>
											<span class="bx_item_block_item_prop_item"><span class="bx_item_block_item_prop_item_name"><?= $prop["NAME"] ?>:</span> <span class="bx_item_block_item_prop_item_value"><?
																																																					if (is_array($prop["VALUE"])) {
																																																						echo implode(', ', $prop["VALUE"]);
																																																					} else {
																																																						echo $prop["VALUE"];
																																																					}
																																																					?></span></span>
										<? endforeach; ?>
									</span>
								<? endif; ?>

								<? if ($arParams["SHOW_PREVIEW_TEXT"] == 'Y' && $arElement["PREVIEW_TEXT"]): ?>
									<span class="bx_item_block_item_text"><?= $arElement["PREVIEW_TEXT"] ?></span>
								<? endif; ?>
							</span>
							<span class="bx_item_block_item_clear"></span>
						</span>
					</a>
				<? endif; ?>
			<? endforeach; ?>

			<? foreach ($arCategory["ITEMS"] as $i => $arItem): ?>
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
			<? endforeach; ?>
		<? endforeach; ?>
	<? else: ?>
		<div class="bx_smart_no_result_find">
			<?= GetMessage("AG_SMARTIK_NO_RESULT"); ?>
		</div>
	<? endif; ?>
</div>