<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

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
use Bitrix\Main\Loader;

$this->setFrameMode(true);

?>
<div class="category__filter-wrap bx-filter <?php if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL") echo "bx-filter-horizontal" ?>">
    <div class="bx-filter-section container-fluid filters">
        <div class="bx-filter-title-wrapper">
            <div class="bx-filter-title">
                <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.0722 17.3597C12.9691 17.4532 12.8505 17.5 12.7165 17.5C12.5825 17.5 12.4639 17.4532 12.3608 17.3597L5.15464 10.8226C5.05155 10.7291 5 10.6216 5 10.5C5 10.3784 5.05155 10.2709 5.15464 10.1774L12.3608 3.64028C12.4639 3.54676 12.5825 3.5 12.7165 3.5C12.8505 3.5 12.9691 3.54676 13.0722 3.64028L13.8454 4.34168C13.9485 4.4352 14 4.54275 14 4.66433C14 4.78591 13.9485 4.89345 13.8454 4.98697L7.76804 10.5L13.8454 16.013C13.9485 16.1065 14 16.2141 14 16.3357C14 16.4572 13.9485 16.5648 13.8454 16.6583L13.0722 17.3597Z" fill="#A8BEC9"/>
                </svg>
                <span><?= GetMessage("CT_BCSF_FILTER_TITLE") ?></span>
            </div>
            <input
                    class="btn btn-link reset-filters filters__clear"
                    type="submit"
                    id="del_filter"
                    name="del_filter"
                    value="<?= GetMessage("CT_BCSF_DEL_FILTER") ?>"/>
        </div>
        <form name="<?php echo $arResult["FILTER_NAME"] . "_form" ?>" action="<?php echo $arResult["FORM_ACTION"] ?>"
              method="get" class="smartfilter bx-filter-catalog-form-wrapper">
            <?php foreach ($arResult["HIDDEN"] as $arItem): ?>
                <input type="hidden" name="<?php echo $arItem["CONTROL_NAME"] ?>"
                       id="<?php echo $arItem["CONTROL_ID"] ?>" value="<?php echo $arItem["HTML_VALUE"] ?>"/>
            <?php endforeach; ?>
            <div class="row">
                <?php foreach ($arResult["ITEMS"] as $key => $arItem) //prices
                {
                    $key = $arItem["ENCODED_ID"];
                    if (isset($arItem["PRICE"])):
                        if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0) {
                            continue;
                        }

                        $precision = 0;
                        $step_num = 1;
                        $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
                        $prices = [];
                        if (Loader::includeModule("currency")) {
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
                        <div class="<?php if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL"): ?>col-sm-6 col-md-4<?php else: ?>col-lg-12<?php endif ?> bx-filter-parameters-box bx-active">
                            <span class="bx-filter-container-modef"></span>
                            <div class="bx-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)">
								<span>
									<h6><?= $arItem["NAME"] ?></h6>
									<i data-role="prop_angle"
                                       class="fa fa-angle-<?php if (isset($arItem["DISPLAY_EXPANDED"]) && $arItem["DISPLAY_EXPANDED"] == "Y"): ?>up<?php else: ?>down<?php endif ?>">
									</i>
								</span>
                            </div>
                            <div class="bx-filter-block" data-role="bx_filter_block">
                                <div class="bx-filter-parameters-box-container">
                                    <div class="col-xs-10 bx-ui-slider-track-container">
                                        <div class="bx-ui-slider-track" id="drag_track_<?= $key ?>">
                                            <?php for ($i = 0; $i <= $step_num; $i++): ?>
                                                <div class="bx-ui-slider-part p<?= $i + 1 ?>">
                                                    <span><?= $prices[$i] ?></span></div>
                                            <?php endfor; ?>

                                            <div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;"
                                                 id="colorUnavailableActive_<?= $key ?>"></div>
                                            <div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;"
                                                 id="colorAvailableInactive_<?= $key ?>"></div>
                                            <div class="bx-ui-slider-pricebar-v" style="left: 0;right: 0;"
                                                 id="colorAvailableActive_<?= $key ?>"></div>
                                            <div class="bx-ui-slider-range" id="drag_tracker_<?= $key ?>"
                                                 style="left: 0%; right: 0%;">
                                                <a class="bx-ui-slider-handle left" style="left:0;"
                                                   href="javascript:void(0)" id="left_slider_<?= $key ?>"></a>
                                                <a class="bx-ui-slider-handle right" style="right:0;"
                                                   href="javascript:void(0)" id="right_slider_<?= $key ?>"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="price-flex-block">
                                        <div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
                                            <div class="bx-filter-input-container input">
                                                <input
                                                        class="min-price form-control"
                                                        type="text"
                                                        name="<?php echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                                        id="<?php echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                                        value="<?php echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                                        placeholder="от #MinPrice"
                                                        size="5"
                                                        onkeyup="smartFilter.keyup(this)"/>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
                                            <div class="bx-filter-input-container input">
                                                <input
                                                        class="max-price form-control"
                                                        type="text"
                                                        name="<?php echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                                        id="<?php echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                                        value="<?php echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                                        placeholder="до #MaxPrice"
                                                        size="5"
                                                        onkeyup="smartFilter.keyup(this)"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
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
                            BX.ready(function () {
                                window['trackBar<?= $key ?>'] = new BX.Iblock.SmartFilter(<?= CUtil::PhpToJSObject($arJsParams) ?>);
                            });
                        </script>
                    <?php endif;
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
                    <div class="<?php if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL"): ?>col-sm-6 col-md-4<?php else: ?>col-lg-12<?php endif ?> bx-filter-parameters-box <?php if ($arItem["DISPLAY_EXPANDED"] == "Y"): ?>bx-active<?php endif ?>">
                        <span class="bx-filter-container-modef"></span>
                        <div class="bx-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)">
							<span class="bx-filter-parameters-box-hint">
								<h6><?= $arItem["NAME"] ?></h6>
								<?php if ($arItem["FILTER_HINT"] <> ""): ?>
                                    <i id="item_title_hint_<?php echo $arItem["ID"] ?>"
                                       class="fa fa-question-circle"></i>
                                    <script type="text/javascript">
										new top.BX.CHint({
                                            parent: top.BX("item_title_hint_<?php echo $arItem["ID"] ?>"),
                                            show_timeout: 10,
                                            hide_timeout: 200,
                                            dx: 2,
                                            preventHide: true,
                                            min_width: 250,
                                            hint: '<?= CUtil::JSEscape($arItem["FILTER_HINT"]) ?>'
                                        });
									</script>
                                <?php endif ?>
								<i data-role="prop_angle"
                                   class="fa fa-angle-<?php if ($arItem["DISPLAY_EXPANDED"] == "Y"): ?>up<?php else: ?>down<?php endif ?>"></i>
							</span>
                        </div>

                        <div class="bx-filter-block" data-role="bx_filter_block">
                            <div class="row bx-filter-parameters-box-container">
                                <?php
                                $arCur = current($arItem["VALUES"]);
                                switch ($arItem["DISPLAY_TYPE"]) {
                                case SectionPropertyTable::NUMBERS_WITH_SLIDER: //NUMBERS_WITH_SLIDER
                                    ?>
                                    <div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
                                        <i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_FROM") ?></i>
                                        <div class="bx-filter-input-container input">
                                            <input
                                                    class="min-price form-control"
                                                    type="text"
                                                    name="<?php echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                                    id="<?php echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                                    value="<?php echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                                    size="5"
                                                    onkeyup="smartFilter.keyup(this)"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
                                        <i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_TO") ?></i>
                                        <div class="bx-filter-input-container input">
                                            <input
                                                    class="max-price form-control"
                                                    type="text"
                                                    name="<?php echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                                    id="<?php echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                                    value="<?php echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                                    size="5"
                                                    onkeyup="smartFilter.keyup(this)"/>
                                        </div>
                                    </div>

                                    <div class="col-xs-10 bx-ui-slider-track-container">
                                        <div class="bx-ui-slider-track" id="drag_track_<?= $key ?>">
                                            <?php
                                            $precision = $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0;
                                            $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
                                            ?>
                                            <div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;"
                                                 id="colorUnavailableActive_<?= $key ?>"></div>
                                            <div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;"
                                                 id="colorAvailableInactive_<?= $key ?>"></div>
                                            <div class="bx-ui-slider-pricebar-v" style="left: 0;right: 0;"
                                                 id="colorAvailableActive_<?= $key ?>"></div>
                                            <div class="bx-ui-slider-range" id="drag_tracker_<?= $key ?>"
                                                 style="left: 0;right: 0;">
                                                <a class="bx-ui-slider-handle left" style="left:0;"
                                                   href="javascript:void(0)" id="left_slider_<?= $key ?>"></a>
                                                <a class="bx-ui-slider-handle right" style="right:0;"
                                                   href="javascript:void(0)" id="right_slider_<?= $key ?>"></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php
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
                                        BX.ready(function () {
                                            window['trackBar<?= $key ?>'] = new BX.Iblock.SmartFilter(<?= CUtil::PhpToJSObject($arJsParams) ?>);
                                        });
                                    </script>
                                <?php
                                break;
                                case SectionPropertyTable::NUMBERS: //NUMBERS
                                ?>
                                    <div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
                                        <i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_FROM") ?></i>
                                        <div class="bx-filter-input-container input">
                                            <input
                                                    class="min-price form-control"
                                                    type="text"
                                                    name="<?php echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                                    id="<?php echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                                    value="<?php echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                                    size="5"
                                                    onkeyup="smartFilter.keyup(this)"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
                                        <i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_TO") ?></i>
                                        <div class="bx-filter-input-container input">
                                            <input
                                                    class="max-price form-control"
                                                    type="text"
                                                    name="<?php echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                                    id="<?php echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                                    value="<?php echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                                    size="5"
                                                    onkeyup="smartFilter.keyup(this)"/>
                                        </div>
                                    </div>
                                <?php
                                break;
                                case SectionPropertyTable::CHECKBOXES_WITH_PICTURES: //CHECKBOXES_WITH_PICTURES
                                ?>
                                    <div class="col-xs-12">
                                        <div class="bx-filter-param-btn-inline">
                                            <?php foreach ($arItem["VALUES"] as $val => $ar): ?>
                                                <input
                                                        style="display: none"
                                                        type="checkbox"
                                                        name="<?= $ar["CONTROL_NAME"] ?>"
                                                        id="<?= $ar["CONTROL_ID"] ?>"
                                                        value="<?= $ar["HTML_VALUE"] ?>"
                                                    <?php echo $ar["CHECKED"] ? 'checked="checked"' : '' ?> />
                                                <?php
                                                $class = "";
                                                if ($ar["CHECKED"])
                                                    $class .= " bx-active";
                                                if ($ar["DISABLED"])
                                                    $class .= " disabled";
                                                ?>
                                                <label for="<?= $ar["CONTROL_ID"] ?>"
                                                       data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                       class="bx-filter-param-label <?= $class ?>"
                                                       onclick="smartFilter.keyup(BX('<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')); BX.toggleClass(this, 'bx-active');">
														<span class="bx-filter-param-btn bx-color-sl">
															<?php if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
                                                                <span class="bx-filter-btn-color-icon"
                                                                      style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                                            <?php endif ?>
														</span>
                                                </label>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                <?php
                                break;
                                case SectionPropertyTable::CHECKBOXES_WITH_PICTURES_AND_LABELS: //CHECKBOXES_WITH_PICTURES_AND_LABELS
                                ?>
                                    <div class="col-xs-12">
                                        <div class="bx-filter-param-btn-block">
                                            <?php foreach ($arItem["VALUES"] as $val => $ar): ?>
                                                <input
                                                        style="display: none"
                                                        type="checkbox"
                                                        name="<?= $ar["CONTROL_NAME"] ?>"
                                                        id="<?= $ar["CONTROL_ID"] ?>"
                                                        value="<?= $ar["HTML_VALUE"] ?>"
                                                    <?php echo $ar["CHECKED"] ? 'checked="checked"' : '' ?> />
                                                <?php
                                                $class = "form-check-input";
                                                if ($ar["CHECKED"])
                                                    $class .= " bx-active checked";
                                                if ($ar["DISABLED"])
                                                    $class .= " disabled";
                                                ?>
                                                <label for="<?= $ar["CONTROL_ID"] ?>"
                                                       data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                       class="form-check-label bx-filter-param-label<?= $class ?>"
                                                       onclick="smartFilter.keyup(BX('<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')); BX.toggleClass(this, 'bx-active');">
														<span class="bx-filter-param-btn bx-color-sl">
															<?php if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
                                                                <span class="bx-filter-btn-color-icon"
                                                                      style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                                            <?php endif ?>
														</span>
                                                    <span class="bx-filter-param-text"
                                                          title="<?= $ar["VALUE"]; ?>"><?= $ar["VALUE"]; ?><?php
                                                        if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                            ?> (<span
                                                                data-role="count_<?= $ar["CONTROL_ID"] ?>"><?php echo $ar["ELEMENT_COUNT"]; ?></span>)<?php
                                                        endif; ?></span>
                                                </label>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                <?php
                                break;
                                case SectionPropertyTable::DROPDOWN: //DROPDOWN
                                $checkedItemExist = false;
                                ?>
                                    <div class="col-xs-12">
                                        <div class="bx-filter-select-container">
                                            <div class="bx-filter-select-block"
                                                 onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                                                <div class="bx-filter-select-text" data-role="currentOption">
                                                    <?php
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
                                                        id="<?php echo "all_" . $arCur["CONTROL_ID"] ?>"
                                                        value=""/>
                                                <?php foreach ($arItem["VALUES"] as $val => $ar): ?>
                                                    <input
                                                            style="display: none"
                                                            type="radio"
                                                            name="<?= $ar["CONTROL_NAME_ALT"] ?>"
                                                            id="<?= $ar["CONTROL_ID"] ?>"
                                                            value="<?php echo $ar["HTML_VALUE_ALT"] ?>"
                                                        <?php echo $ar["CHECKED"] ? 'checked="checked"' : '' ?> />
                                                <?php endforeach ?>
                                                <div class="bx-filter-select-popup" data-role="dropdownContent"
                                                     style="display: none;">
                                                    <ul>
                                                        <li>
                                                            <label for="<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                                   class="bx-filter-param-label"
                                                                   data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                                   onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape("all_" . $arCur["CONTROL_ID"]) ?>')">
                                                                <?php echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
                                                            </label>
                                                        </li>
                                                        <?php
                                                        foreach ($arItem["VALUES"] as $val => $ar):
                                                            $class = "";
                                                            if ($ar["CHECKED"])
                                                                $class .= " selected";
                                                            if ($ar["DISABLED"])
                                                                $class .= " disabled";
                                                            ?>
                                                            <li>
                                                                <label for="<?= $ar["CONTROL_ID"] ?>"
                                                                       class="bx-filter-param-label<?= $class ?>"
                                                                       data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                                       onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')"><?= $ar["VALUE"] ?></label>
                                                            </li>
                                                        <?php endforeach ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                break;
                                case SectionPropertyTable::DROPDOWN_WITH_PICTURES_AND_LABELS: //DROPDOWN_WITH_PICTURES_AND_LABELS
                                ?>
                                    <div class="col-xs-12">
                                        <div class="bx-filter-select-container">
                                            <div class="bx-filter-select-block"
                                                 onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                                                <div class="bx-filter-select-text fix" data-role="currentOption">
                                                    <?php
                                                    $checkedItemExist = false;
                                                    foreach ($arItem["VALUES"] as $val => $ar):
                                                        if ($ar["CHECKED"]) {
                                                            ?>
                                                            <?php if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
                                                                <span class="bx-filter-btn-color-icon"
                                                                      style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                                            <?php endif ?>
                                                            <span class="bx-filter-param-text">
																	<?= $ar["VALUE"] ?>
																</span>
                                                            <?php
                                                            $checkedItemExist = true;
                                                        }
                                                    endforeach;
                                                    if (!$checkedItemExist) {
                                                        ?><span class="bx-filter-btn-color-icon all"></span> <?php
                                                        echo GetMessage("CT_BCSF_FILTER_ALL");
                                                    }
                                                    ?>
                                                </div>
                                                <div class="bx-filter-select-arrow"></div>
                                                <input
                                                        style="display: none"
                                                        type="radio"
                                                        name="<?= $arCur["CONTROL_NAME_ALT"] ?>"
                                                        id="<?php echo "all_" . $arCur["CONTROL_ID"] ?>"
                                                        value=""/>
                                                <?php foreach ($arItem["VALUES"] as $val => $ar): ?>
                                                    <input
                                                            style="display: none"
                                                            type="radio"
                                                            name="<?= $ar["CONTROL_NAME_ALT"] ?>"
                                                            id="<?= $ar["CONTROL_ID"] ?>"
                                                            value="<?= $ar["HTML_VALUE_ALT"] ?>"
                                                        <?php echo $ar["CHECKED"] ? 'checked="checked"' : '' ?> />
                                                <?php endforeach ?>
                                                <div class="bx-filter-select-popup" data-role="dropdownContent"
                                                     style="display: none">
                                                    <ul>
                                                        <li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
                                                            <label for="<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                                   class="bx-filter-param-label"
                                                                   data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                                   onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape("all_" . $arCur["CONTROL_ID"]) ?>')">
                                                                <span class="bx-filter-btn-color-icon all"></span>
                                                                <?php echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
                                                            </label>
                                                        </li>
                                                        <?php
                                                        foreach ($arItem["VALUES"] as $val => $ar):
                                                            $class = "";
                                                            if ($ar["CHECKED"])
                                                                $class .= " selected";
                                                            if ($ar["DISABLED"])
                                                                $class .= " disabled";
                                                            ?>
                                                            <li>
                                                                <label for="<?= $ar["CONTROL_ID"] ?>"
                                                                       data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                                       class="bx-filter-param-label<?= $class ?>"
                                                                       onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')">
                                                                    <?php if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
                                                                        <span class="bx-filter-btn-color-icon"
                                                                              style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                                                    <?php endif ?>
                                                                    <span class="bx-filter-param-text">
																			<?= $ar["VALUE"] ?>
																		</span>
                                                                </label>
                                                            </li>
                                                        <?php endforeach ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                break;
                                case SectionPropertyTable::RADIO_BUTTONS: //RADIO_BUTTONS
                                ?>
                                    <div class="col-xs-12">
                                        <div class="radio">
                                            <label class="bx-filter-param-label"
                                                   for="<?php echo "all_" . $arCur["CONTROL_ID"] ?>">
													<span class="bx-filter-input-checkbox">
														<input
                                                                type="radio"
                                                                value=""
                                                                name="<?php echo $arCur["CONTROL_NAME_ALT"] ?>"
                                                                id="<?php echo "all_" . $arCur["CONTROL_ID"] ?>"
                                                                onclick="smartFilter.click(this)"/>
														<span class="bx-filter-param-text"><?php echo GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
													</span>
                                            </label>
                                        </div>
                                        <?php foreach ($arItem["VALUES"] as $val => $ar): ?>
                                            <div class="radio">
                                                <label data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                       class="bx-filter-param-label"
                                                       for="<?php echo $ar["CONTROL_ID"] ?>">
														<span class="bx-filter-input-checkbox <?php echo $ar["DISABLED"] ? 'disabled' : '' ?>">
															<input
                                                                    type="radio"
                                                                    value="<?php echo $ar["HTML_VALUE_ALT"] ?>"
                                                                    name="<?php echo $ar["CONTROL_NAME_ALT"] ?>"
                                                                    id="<?php echo $ar["CONTROL_ID"] ?>"
																<?php echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
																onclick="smartFilter.click(this)"/>
															<span class="bx-filter-param-text"
                                                                  title="<?= $ar["VALUE"]; ?>"><?= $ar["VALUE"]; ?><?php
                                                                if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                                    ?>&nbsp;(<span
                                                                        data-role="count_<?= $ar["CONTROL_ID"] ?>"><?php echo $ar["ELEMENT_COUNT"]; ?></span>)<?php
                                                                endif; ?></span>
														</span>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php
                                break;
                                case SectionPropertyTable::CALENDAR: //CALENDAR
                                ?>
                                    <div class="col-xs-12">
                                        <div class="bx-filter-parameters-box-container-block">
                                            <div class="bx-filter-input-container input bx-filter-calendar-container">
                                                <?php $APPLICATION->IncludeComponent(
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
                                            <div class="bx-filter-input-container input bx-filter-calendar-container">
                                                <?php $APPLICATION->IncludeComponent(
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
                                    </div>
                                <?php
                                break;
                                default: //CHECKBOXES
                                ?>
                                    <div class="col-xs-12">
                                        <?php foreach ($arItem["VALUES"] as $val => $ar): ?>
                                            <div class="checkbox filters-item">
                                                <label data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                       class="bx-filter-param-label <?php echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                                       for="<?php echo $ar["CONTROL_ID"] ?>">
														<span class="bx-filter-input-checkbox">
															<input
                                                                    class="form-check-input"
                                                                    type="checkbox"
                                                                    value="<?php echo $ar["HTML_VALUE"] ?>"
                                                                    name="<?php echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<?php echo $ar["CONTROL_ID"] ?>"
																<?php echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
																onclick="smartFilter.click(this)"/>
															<span class="bx-filter-param-text form-check-label"
                                                                  title="<?= $ar["VALUE"]; ?>"><?= $ar["VALUE"]; ?><?php
                                                                if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                                    ?>&nbsp;<span
                                                                        class="elems-count"
                                                                        data-role="count_<?= $ar["CONTROL_ID"] ?>">[<?php echo $ar["ELEMENT_COUNT"]; ?> шт.]</span><?php
                                                                endif; ?></span>
														</span>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div style="clear: both"></div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <!--//row-->
            <div class="row bx-catalog-btn-submit-filter-wrapper">
                <div class="col-xs-12 bx-filter-button-box">
                    <div class="bx-filter-block">
                        <div class="bx-filter-parameters-box-container">
                            <input
                                    class="btn btn-primary bx-catalog-btn-submit-filter"
                                    type="submit"
                                    id="set_filter"
                                    name="set_filter"
                                    value="<?= GetMessage("CT_BCSF_SET_FILTER") ?>"/>
                            <input class="btn btn-link reset-filters filters__clear" type="button" id="del_filter_bottom" name="del_filter" value="Сбросить">

                            <div class="bx-filter-popup-result <?php if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL") echo $arParams["POPUP_POSITION"] ?>"
                                 id="modef"
                                 <?php if (!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"'; ?>style="display: none;">
                                <div style="display: none;"><?php echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num" style="display: none;">' . (int)($arResult["ELEMENT_COUNT"] ?? 0) . '</span>')); ?></div>
                                <span class="arrow">
                                    <svg width="22" height="44" viewBox="0 0 22 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.5 5C16.5 2.23858 18.7386 0 21.5 0H22V44H21.5C18.7386 44 16.5 41.7614 16.5 39V34.1051C16.5 33.4174 16.1466 32.7779 15.5643 32.4119L1.69384 23.6933C0.446298 22.9091 0.446301 21.0909 1.69384 20.3067L15.5643 11.5881C16.1466 11.2221 16.5 10.5826 16.5 9.89485V5Z" fill="#DEEEFF"/>
                                    </svg>
                                </span>
                                <a href="<?php echo $arResult["FILTER_URL"] ?>"
                                   target=""><?php echo GetMessage("CT_BCSF_FILTER_SHOW") ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clb"></div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var smartFilter = new JCSmartFilter('<?php echo CUtil::JSEscape($arResult["FORM_ACTION"]) ?>', '<?= CUtil::JSEscape($arParams["FILTER_VIEW_MODE"]) ?>', <?= CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"]) ?>);
</script>
