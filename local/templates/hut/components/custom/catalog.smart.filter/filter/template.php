<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use Bitrix\Iblock\SectionPropertyTable;

$this->setFrameMode(true);

//debug($arResult);

?>
<form id="smartfilter" name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>" method="get" class="smartfilter bx-filter">
	<div class="bx-filter-title"><? echo GetMessage("CT_BCSF_FILTER_TITLE") ?></div>
	<? foreach ($arResult["HIDDEN"] as $arItem): ?>
		<input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>" value="<? echo $arItem["HTML_VALUE"] ?>" />
	<? endforeach; ?>
	<div class="filter-inner">
		<? foreach ($arResult["ITEMS"] as $key => $arItem) //prices
		{
			$key = $arItem["ENCODED_ID"];
			if (isset($arItem["PRICE"])):
				if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
					continue;

				$precision = 0;
				$step_num = 4;
				$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
				$prices = array();
				if (Bitrix\Main\Loader::includeModule("currency")) {
					for ($i = 0; $i < $step_num; $i++) {
						$prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
					}
					$prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
				} else {
					$precision = $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0;
					for ($i = 0; $i < $step_num; $i++) {
						$prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i, $precision, ".", "");
					}
					$prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
				}
		?>
				<div class="bx-filter-parameters-box bx-active filter-price">
					<span class="bx-filter-container-modef"></span>
					<div class="bx-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)"><span><?= $arItem["NAME"] ?> <span data-role="prop_angle" class="fa-angle-<? if (isset($arItem["DISPLAY_EXPANDED"]) && $arItem["DISPLAY_EXPANDED"] == "Y"): ?>up<? else: ?>down<? endif ?>"></span></span></div>
					<div class="bx-filter-block" data-role="bx_filter_block">
						<div class="row bx-filter-parameters-box-container">
							<div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
								<i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_FROM") ?></i>
								<div class="bx-filter-input-container">
									<input
										class="min-price"
										type="text"
										name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
										id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
										value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
										size="5"
										onkeyup="smartFilter.keyup(this)" />
								</div>
							</div>
							<div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
								<i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_TO") ?></i>
								<div class="bx-filter-input-container">
									<input
										class="max-price"
										type="text"
										name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
										id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
										value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
										size="5"
										onkeyup="smartFilter.keyup(this)" />
								</div>
							</div>

							<div class="col-xs-10 col-xs-offset-1 bx-ui-slider-track-container">
								<div class="bx-ui-slider-track" id="drag_track_<?= $key ?>">
									<? for ($i = 0; $i <= $step_num; $i++): ?>
										<div class="bx-ui-slider-part p<?= $i + 1 ?>"><span><?= $prices[$i] ?></span></div>
									<? endfor; ?>

									<div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?= $key ?>"></div>
									<div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?= $key ?>"></div>
									<div class="bx-ui-slider-pricebar-v" style="left: 0;right: 0;" id="colorAvailableActive_<?= $key ?>"></div>
									<div class="bx-ui-slider-range" id="drag_tracker_<?= $key ?>" style="left: 0%; right: 0%;">
										<a class="bx-ui-slider-handle left" style="left:0;" href="javascript:void(0)" id="left_slider_<?= $key ?>"></a>
										<a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?= $key ?>"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?
				$arJsParams = array(
					"leftSlider" => 'left_slider_' . $key,
					"rightSlider" => 'right_slider_' . $key,
					"tracker" => "drag_tracker_" . $key,
					"trackerWrap" => "drag_track_" . $key,
					"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
					"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
					"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
					"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
					"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
					"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
					"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"],
					"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
					"precision" => $precision,
					"colorUnavailableActive" => 'colorUnavailableActive_' . $key,
					"colorAvailableActive" => 'colorAvailableActive_' . $key,
					"colorAvailableInactive" => 'colorAvailableInactive_' . $key,
				);
				?>
				<script type="text/javascript">
					BX.ready(function() {
						window['trackBar<?= $key ?>'] = new BX.Iblock.SmartFilter(<?= CUtil::PhpToJSObject($arJsParams) ?>);
					});
				</script>
			<? endif;
		}

		//not prices
		foreach ($arResult["ITEMS"] as $key => $arItem) {
			if (
				empty($arItem["VALUES"])
				|| isset($arItem["PRICE"])
			)
				continue;

			if (
				$arItem["DISPLAY_TYPE"] === SectionPropertyTable::NUMBERS_WITH_SLIDER
				&& ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
			)
				continue;
			?>
			<div class="bx-filter-parameters-box <? if ($arItem["DISPLAY_EXPANDED"] == "Y"): ?>bx-active<? endif ?> <?= $arItem['CODE'] ?>">
				<span class="bx-filter-container-modef"></span>
				<div class="bx-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)">
					<span class="bx-filter-parameters-box-hint">
						<?= $arItem["NAME"] ?>
						<?
						$isChecked = false;
						foreach ($arItem["VALUES"] as $val => $ar):
							if ($ar["CHECKED"]) {
								$isChecked = true;
								break;
							}
						endforeach;
						?>
						<button onclick="smartFilter.clearCurrent(event)" type="button" class="button filter-clear-current" <?= $isChecked ? 'style="display: flex"' : '' ?>>
							<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
								<rect x="0.5" y="0.5" width="31" height="31" rx="15.5" stroke="#DCDCDF" />
								<path fill-rule="evenodd" clip-rule="evenodd" d="M12.4697 12.4697C12.7626 12.1768 13.2374 12.1768 13.5303 12.4697L16 14.9393L18.4697 12.4697C18.7626 12.1768 19.2374 12.1768 19.5303 12.4697C19.8232 12.7626 19.8232 13.2374 19.5303 13.5303L17.0607 16L19.5303 18.4697C19.8232 18.7626 19.8232 19.2374 19.5303 19.5303C19.2374 19.8232 18.7626 19.8232 18.4697 19.5303L16 17.0607L13.5303 19.5303C13.2374 19.8232 12.7626 19.8232 12.4697 19.5303C12.1768 19.2374 12.1768 18.7626 12.4697 18.4697L14.9393 16L12.4697 13.5303C12.1768 13.2374 12.1768 12.7626 12.4697 12.4697Z" fill="#354052" />
							</svg>
						</button>
						<span data-role="prop_angle" class="filter-drop fa-angle-<? if ($arItem["DISPLAY_EXPANDED"] == "Y"): ?>up<? else: ?>down<? endif ?>"></span>
					</span>
				</div>

				<div class="bx-filter-block" data-role="bx_filter_block">
					<div class="row bx-filter-parameters-box-container">
						<?
						$arCur = current($arItem["VALUES"]);
						switch ($arItem["DISPLAY_TYPE"]) {
							case SectionPropertyTable::NUMBERS_WITH_SLIDER: //NUMBERS_WITH_SLIDER
						?>
								<div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
									<i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_FROM") ?></i>
									<div class="bx-filter-input-container">
										<input
											class="min-price"
											type="text"
											name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
											id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
											value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
											size="5"
											onkeyup="smartFilter.keyup(this)" />
									</div>
								</div>
								<div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
									<i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_TO") ?></i>
									<div class="bx-filter-input-container">
										<input
											class="max-price"
											type="text"
											name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
											id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
											value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
											size="5"
											onkeyup="smartFilter.keyup(this)" />
									</div>
								</div>

								<div class="col-xs-10 col-xs-offset-1 bx-ui-slider-track-container">
									<div class="bx-ui-slider-track" id="drag_track_<?= $key ?>">
										<?
										$precision = $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0;
										$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
										$value1 = number_format($arItem["VALUES"]["MIN"]["VALUE"], $precision, ".", "");
										$value2 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step, $precision, ".", "");
										$value3 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 2, $precision, ".", "");
										$value4 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 3, $precision, ".", "");
										$value5 = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
										?>
										<div class="bx-ui-slider-part p1"><span><?= $value1 ?></span></div>
										<div class="bx-ui-slider-part p2"><span><?= $value2 ?></span></div>
										<div class="bx-ui-slider-part p3"><span><?= $value3 ?></span></div>
										<div class="bx-ui-slider-part p4"><span><?= $value4 ?></span></div>
										<div class="bx-ui-slider-part p5"><span><?= $value5 ?></span></div>

										<div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?= $key ?>"></div>
										<div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?= $key ?>"></div>
										<div class="bx-ui-slider-pricebar-v" style="left: 0;right: 0;" id="colorAvailableActive_<?= $key ?>"></div>
										<div class="bx-ui-slider-range" id="drag_tracker_<?= $key ?>" style="left: 0;right: 0;">
											<a class="bx-ui-slider-handle left" style="left:0;" href="javascript:void(0)" id="left_slider_<?= $key ?>"></a>
											<a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?= $key ?>"></a>
										</div>
									</div>
								</div>
								<?
								$arJsParams = array(
									"leftSlider" => 'left_slider_' . $key,
									"rightSlider" => 'right_slider_' . $key,
									"tracker" => "drag_tracker_" . $key,
									"trackerWrap" => "drag_track_" . $key,
									"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
									"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
									"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
									"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
									"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
									"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
									"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"],
									"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
									"precision" => $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0,
									"colorUnavailableActive" => 'colorUnavailableActive_' . $key,
									"colorAvailableActive" => 'colorAvailableActive_' . $key,
									"colorAvailableInactive" => 'colorAvailableInactive_' . $key,
								);
								?>
								<script type="text/javascript">
									BX.ready(function() {
										window['trackBar<?= $key ?>'] = new BX.Iblock.SmartFilter(<?= CUtil::PhpToJSObject($arJsParams) ?>);
									});
								</script>
							<?
								break;
							case SectionPropertyTable::NUMBERS: //NUMBERS
							?>
								<div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
									<i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_FROM") ?></i>
									<div class="bx-filter-input-container">
										<input
											class="min-price"
											type="text"
											name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
											id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
											value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
											size="5"
											onkeyup="smartFilter.keyup(this)" />
									</div>
								</div>
								<div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
									<i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_TO") ?></i>
									<div class="bx-filter-input-container">
										<input
											class="max-price"
											type="text"
											name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
											id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
											value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
											size="5"
											onkeyup="smartFilter.keyup(this)" />
									</div>
								</div>
							<?
								break;
							case SectionPropertyTable::CHECKBOXES_WITH_PICTURES: //CHECKBOXES_WITH_PICTURES
							?>
								<div class="bx-filter-param-btn-inline">
									<? foreach ($arItem["VALUES"] as $val => $ar): ?>
										<input
											class="visually-hidden"
											style="display: none"
											type="checkbox"
											name="<?= $ar["CONTROL_NAME"] ?>"
											id="<?= $ar["CONTROL_ID"] ?>"
											value="<?= $ar["HTML_VALUE"] ?>"
											<? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?> />
										<?
										$class = "";
										if ($ar["CHECKED"])
											$class .= " bx-active";
										if ($ar["DISABLED"])
											$class .= " disabled";
										?>
										<label for="<?= $ar["CONTROL_ID"] ?>" data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx-filter-param-label <?= $class ?>" onclick="smartFilter.keyup(BX('<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')); BX.toggleClass(this, 'bx-active');">
											<span class="bx-filter-param-btn bx-color-sl">
												<? if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
													<span class="bx-filter-btn-color-icon" style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
												<? endif ?>
											</span>
										</label>
									<? endforeach ?>
								</div>
							<?
								break;
							case SectionPropertyTable::CHECKBOXES_WITH_PICTURES_AND_LABELS: //CHECKBOXES_WITH_PICTURES_AND_LABELS
							?>
								<div class="bx-filter-pictures">
									<? foreach ($arItem["VALUES"] as $val => $ar): ?>
										<input
											class="visually-hidden"
											style="display: none"
											type="checkbox"
											name="<?= $ar["CONTROL_NAME"] ?>"
											id="<?= $ar["CONTROL_ID"] ?>"
											value="<?= $ar["HTML_VALUE"] ?>"
											<? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?> />
										<?
										$class = "";
										if ($ar["CHECKED"])
											$class .= " bx-active";
										if ($ar["DISABLED"])
											$class .= " disabled";
										?>
										<label for="<?= $ar["CONTROL_ID"] ?>" data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx-filter-param-label<?= $class ?>" onclick="smartFilter.keyup(BX('<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')); BX.toggleClass(this, 'bx-active');">
											<span class="bx-filter-param-btn bx-color-sl">
												<? if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
													<span title="<?= $ar["VALUE"] ?>" class="bx-filter-btn-color-icon" style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
												<? endif ?>
											</span>
										</label>
									<? endforeach ?>
								</div>
							<?
								break;
							case SectionPropertyTable::DROPDOWN: //DROPDOWN
								$checkedItemExist = false;
							?>
								<div class="bx-filter-select-container">
									<div class="bx-filter-select-block" onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
										<div class="bx-filter-select-text" data-role="currentOption">
											<?
											foreach ($arItem["VALUES"] as $val => $ar) {
												if ($ar["CHECKED"]) {
													echo $ar["VALUE"];
													$checkedItemExist = true;
												}
											}
											if (!$checkedItemExist) {
												echo GetMessage("CT_BCSF_FILTER_ALL");
											}
											?>
										</div>
										<div class="bx-filter-select-arrow"></div>
										<input
											style="display: none"
											type="radio"
											name="<?= $arCur["CONTROL_NAME_ALT"] ?>"
											id="<? echo "all_" . $arCur["CONTROL_ID"] ?>"
											value="" />
										<? foreach ($arItem["VALUES"] as $val => $ar): ?>
											<input
												style="display: none"
												type="radio"
												name="<?= $ar["CONTROL_NAME_ALT"] ?>"
												id="<?= $ar["CONTROL_ID"] ?>"
												value="<? echo $ar["HTML_VALUE_ALT"] ?>"
												<? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?> />
										<? endforeach ?>
										<div class="bx-filter-select-popup" data-role="dropdownContent" style="display: none;">
											<ul>
												<li>
													<label for="<?= "all_" . $arCur["CONTROL_ID"] ?>" class="bx-filter-param-label" data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>" onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape("all_" . $arCur["CONTROL_ID"]) ?>')">
														<? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
													</label>
												</li>
												<?
												foreach ($arItem["VALUES"] as $val => $ar):
													$class = "";
													if ($ar["CHECKED"])
														$class .= " selected";
													if ($ar["DISABLED"])
														$class .= " disabled";
												?>
													<li>
														<label for="<?= $ar["CONTROL_ID"] ?>" class="bx-filter-param-label<?= $class ?>" data-role="label_<?= $ar["CONTROL_ID"] ?>" onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')"><?= $ar["VALUE"] ?></label>
													</li>
												<? endforeach ?>
											</ul>
										</div>
									</div>
								</div>
							<?
								break;
							case SectionPropertyTable::DROPDOWN_WITH_PICTURES_AND_LABELS: //DROPDOWN_WITH_PICTURES_AND_LABELS
							?>
								<div class="bx-filter-select-container">
									<div class="bx-filter-select-block" onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
										<div class="bx-filter-select-text fix" data-role="currentOption">
											<?
											$checkedItemExist = false;
											foreach ($arItem["VALUES"] as $val => $ar):
												if ($ar["CHECKED"]) {
											?>
													<? if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
														<span class="bx-filter-btn-color-icon" style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
													<? endif ?>
													<span class="bx-filter-param-text">
														<?= $ar["VALUE"] ?>
													</span>
												<?
													$checkedItemExist = true;
												}
											endforeach;
											if (!$checkedItemExist) {
												?><span class="bx-filter-btn-color-icon all"></span> <?
																										echo GetMessage("CT_BCSF_FILTER_ALL");
																									}
																										?>
										</div>
										<div class="bx-filter-select-arrow"></div>
										<input
											style="display: none"
											type="radio"
											name="<?= $arCur["CONTROL_NAME_ALT"] ?>"
											id="<? echo "all_" . $arCur["CONTROL_ID"] ?>"
											value="" />
										<? foreach ($arItem["VALUES"] as $val => $ar): ?>
											<input
												style="display: none"
												type="radio"
												name="<?= $ar["CONTROL_NAME_ALT"] ?>"
												id="<?= $ar["CONTROL_ID"] ?>"
												value="<?= $ar["HTML_VALUE_ALT"] ?>"
												<? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?> />
										<? endforeach ?>
										<div class="bx-filter-select-popup" data-role="dropdownContent" style="display: none">
											<ul>
												<li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
													<label for="<?= "all_" . $arCur["CONTROL_ID"] ?>" class="bx-filter-param-label" data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>" onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape("all_" . $arCur["CONTROL_ID"]) ?>')">
														<span class="bx-filter-btn-color-icon all"></span>
														<? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
													</label>
												</li>
												<?
												foreach ($arItem["VALUES"] as $val => $ar):
													$class = "";
													if ($ar["CHECKED"])
														$class .= " selected";
													if ($ar["DISABLED"])
														$class .= " disabled";
												?>
													<li>
														<label for="<?= $ar["CONTROL_ID"] ?>" data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx-filter-param-label<?= $class ?>" onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')">
															<? if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
																<span class="bx-filter-btn-color-icon" style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
															<? endif ?>
															<span class="bx-filter-param-text">
																<?= $ar["VALUE"] ?>
															</span>
														</label>
													</li>
												<? endforeach ?>
											</ul>
										</div>
									</div>
								</div>
							<?
								break;
							case SectionPropertyTable::RADIO_BUTTONS: //RADIO_BUTTONS
							?>
								<div class="radio">
									<label class="bx-filter-param-label" for="<? echo "all_" . $arCur["CONTROL_ID"] ?>">
										<span class="bx-filter-input-checkbox">
											<input
												type="radio"
												value=""
												name="<? echo $arCur["CONTROL_NAME_ALT"] ?>"
												id="<? echo "all_" . $arCur["CONTROL_ID"] ?>"
												onclick="smartFilter.click(this)" />
											<span class="bx-filter-param-text"><? echo GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
										</span>
									</label>
								</div>
								<? foreach ($arItem["VALUES"] as $val => $ar): ?>
									<div class="radio">
										<label data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx-filter-param-label" for="<? echo $ar["CONTROL_ID"] ?>">
											<span class="bx-filter-input-checkbox <? echo $ar["DISABLED"] ? 'disabled' : '' ?>">
												<input
													type="radio"
													value="<? echo $ar["HTML_VALUE_ALT"] ?>"
													name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
													id="<? echo $ar["CONTROL_ID"] ?>"
													<? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
													onclick="smartFilter.click(this)" />
												<span class="bx-filter-param-text" title="<?= $ar["VALUE"]; ?>"><?= $ar["VALUE"]; ?><?
																																	if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
																																	?>&nbsp;(<span data-role="count_<?= $ar["CONTROL_ID"] ?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
																																																									endif; ?></span>
											</span>
										</label>
									</div>
								<? endforeach; ?>
							<?
								break;
							case SectionPropertyTable::CALENDAR: //CALENDAR
							?>
								<div class="bx-filter-parameters-box-container-block">
									<div class="bx-filter-input-container bx-filter-calendar-container">
										<? $APPLICATION->IncludeComponent(
											'bitrix:main.calendar',
											'',
											array(
												'FORM_NAME' => $arResult["FILTER_NAME"] . "_form",
												'SHOW_INPUT' => 'Y',
												'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="' . FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]) . '" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
												'INPUT_NAME' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"],
												'INPUT_VALUE' => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
												'SHOW_TIME' => 'N',
												'HIDE_TIMEBAR' => 'Y',
											),
											null,
											array('HIDE_ICONS' => 'Y')
										); ?>
									</div>
								</div>
								<div class="bx-filter-parameters-box-container-block">
									<div class="bx-filter-input-container bx-filter-calendar-container">
										<? $APPLICATION->IncludeComponent(
											'bitrix:main.calendar',
											'',
											array(
												'FORM_NAME' => $arResult["FILTER_NAME"] . "_form",
												'SHOW_INPUT' => 'Y',
												'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="' . FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]) . '" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
												'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
												'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
												'SHOW_TIME' => 'N',
												'HIDE_TIMEBAR' => 'Y',
											),
											null,
											array('HIDE_ICONS' => 'Y')
										); ?>
									</div>
								</div>
							<?
								break;
							default: //CHECKBOXES
							?>
								<? foreach ($arItem["VALUES"] as $val => $ar): ?>
									<div class="checkbox">
										<label data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx-filter-param-label <? echo $ar["DISABLED"] ? 'disabled' : '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">
											<span class="bx-filter-input-checkbox">
												<input
													<?= $ar["DISABLED"] ? 'readonly ' : '' ?>
													class="visually-hidden"
													type="checkbox"
													value="<? echo $ar["HTML_VALUE"] ?>"
													name="<? echo $ar["CONTROL_NAME"] ?>"
													id="<? echo $ar["CONTROL_ID"] ?>"
													<? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
													onclick="smartFilter.click(this)" />
												<span class="bx-filter-param-text" title="<?= $ar["VALUE"]; ?>"><?= $ar["VALUE"]; ?><?
																																	if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
																																	?>&nbsp;(<span data-role="count_<?= $ar["CONTROL_ID"] ?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
																																																									endif; ?></span>
											</span>
										</label>
									</div>
								<? endforeach; ?>
						<?
						}
						?>
					</div>
				</div>
			</div>
		<?
		}
		?>
	</div>
	<div class="bx-filter-button-box">
		<input
			class="btn btn-themes button"
			type="submit"
			id="set_filter"
			name="set_filter"
			value="<?= GetMessage("CT_BCSF_SET_FILTER") ?>" />
		<input
			class="btn btn-link button"
			type="submit"
			id="del_filter"
			name="del_filter"
			value="<?= GetMessage("CT_BCSF_DEL_FILTER") ?>" />
		<div class="bx-filter-popup-result" id="modef" <? if (!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"'; ?> style="display: inline-block;">
			<? echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">' . (int)($arResult["ELEMENT_COUNT"] ?? 0) . '</span>')); ?>
			<span class="arrow"></span>
			<br />
			<a href="<? echo $arResult["FILTER_URL"] ?>" target=""><? echo GetMessage("CT_BCSF_FILTER_SHOW") ?></a>
		</div>
	</div>
</form>
<script type="text/javascript">
	var smartFilter = new JCSmartFilter('<? echo CUtil::JSEscape($arResult["FORM_ACTION"]) ?>', <?= CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"]) ?>);
</script>