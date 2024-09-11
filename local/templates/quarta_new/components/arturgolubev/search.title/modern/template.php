<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$this->setFrameMode(true);

$this->addExternalCss('/local/templates/quarta_new/components/bitrix/catalog.item/search_title/style.css');
/** @var  $arParams */
/** @var  $arResult */



/* hints */
$arResult["HINTS"] = [];
if (is_array($arParams["ANIMATE_HINTS"])) {
	foreach ($arParams["ANIMATE_HINTS"] as $k => $v) {
		$v = trim($v);
		if ($v) {
			$arResult["HINTS"][] = $v;
		}
	}
}

if (count($arResult["HINTS"])) {
	CJSCore::Init(array("ag_smartsearch_type"));
	$arParams["INPUT_PLACEHOLDER"] = '';
	$arParams["ANIMATE_HINTS_SPEED"] = (intval($arParams["ANIMATE_HINTS_SPEED"]) ? intval($arParams["ANIMATE_HINTS_SPEED"]) : 1);
}
/* end hints */

$INPUT_ID = trim($arParams["~INPUT_ID"]);
if (strlen($INPUT_ID) <= 0)
	$INPUT_ID = "smart-title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);

if (strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "smart-title-search";

$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

$PRELOADER_ID = $CONTAINER_ID . "_preloader_item";
$CLEAR_ID = $CONTAINER_ID . "_clear_item";

if ($arParams["SHOW_INPUT"] !== "N"): ?>
	<div id="<?php echo $CONTAINER_ID ?>" class="bx-searchtitle search-live__wrapper <?= $arResult["VISUAL_PARAMS"]["THEME_CLASS"] ?>">
		<form action="<?php echo $arResult["FORM_ACTION"] ?>">
			<input id="<?php echo $INPUT_ID ?>" placeholder="<?= $arParams["INPUT_PLACEHOLDER"] ?>" type="text" name="q" value="<?= htmlspecialcharsbx($_REQUEST["q"]) ?>" autocomplete="off" class="form-control border-primary bg-white bx-form-control" />
			<span class="bx-searchtitle-preloader <?php if ($arParams["SHOW_LOADING_ANIMATE"] == 'Y') echo 'view'; ?>" id="<?php echo $PRELOADER_ID ?>"></span>
			<span class="bx-searchtitle-clear" id="<?php echo $CLEAR_ID ?>"></span>
			<button class="btn btn-primary bx-searchtitle-btn-search" type="submit" name="s">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M14.2939 12.5786L13.1504 11.4351L13.0703 12.2699C14.191 10.9663 14.8656 9.27387 14.8656 7.43282C14.8656 3.32762 11.538 0 7.43282 0C3.32762 0 0 3.32762 0 7.43282C0 11.538 3.32762 14.8656 7.43282 14.8656C9.27387 14.8656 10.9663 14.191 12.2699 13.0703L11.4351 13.1504L12.5786 14.2939L18.2962 20L20 18.2962L14.2939 12.5786ZM7.43282 12.5786C4.58548 12.5786 2.28702 10.2802 2.28702 7.43282C2.28702 4.58548 4.58548 2.28702 7.43282 2.28702C10.2802 2.28702 12.5786 4.58548 12.5786 7.43282C12.5786 10.2802 10.2802 12.5786 7.43282 12.5786Z" fill="white"></path>
				</svg>
			</button>
            <?php if ($arParams['MOBILE'] == 'Y'): ?>
				<div class="bx-searchtitle-mobile-close-btn">
					<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M30 10L10 30" stroke="#808D9A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M10 10L30 30" stroke="#808D9A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</div>
            <?php endif; ?>
		</form>

		<?php
		$APPLICATION->IncludeFile(
			$templateFolder . "/search_modal.php",
			[
				'arResult' => $arResult,
				'popularRequests' => $arParams['POPULAR_REQUESTS'],
				'isMobile' => $arParams['MOBILE'] == 'Y' ? true : false,
				'component' => $component
			],
			['SHOW_BORDER' => false]
		);
		?>

	</div>
<?php endif ?>

<?/*php if($arParams["NUM_CATEGORIES"] > 1):?>
	<?global $USER; if($USER->IsAdmin()):?>
		<div style="color: red; font-size: 13px;">
			<?=GetMessage("AG_SMARTIK_CATEGORY_WARRING", array("#NUM_VAL#" => $arParams["NUM_CATEGORIES"]));?>
		</div>
	<?endif;?>
<?endif; */ ?>

<?php if ($arResult["VISUAL_PARAMS"]["THEME_COLOR"]): ?>
	<style>
		.bx-searchtitle .bx-input-group .bx-form-control,
		.bx_smart_searche .bx_item_block.all_result .all_result_button,
		.bx-searchtitle .bx-input-group-btn button,
		.bx_smart_searche .bx_item_block_hrline {
			border-color: <?= $arResult["VISUAL_PARAMS"]["THEME_COLOR"] ?> !important;
		}

		.bx_smart_searche .bx_item_block.all_result .all_result_button,
		.bx-searchtitle .bx-input-group-btn button {
			background-color: <?= $arResult["VISUAL_PARAMS"]["THEME_COLOR"] ?> !important;
		}

		.bx_smart_searche .bx_item_block_href_category_name,
		.bx_smart_searche .bx_item_block_item_name b,
		.bx_smart_searche .bx_item_block_item_simple_name b {
			color: <?= $arResult["VISUAL_PARAMS"]["THEME_COLOR"] ?> !important;
		}
	</style>
<?php endif; ?>

<script>
	BX.ready(function() {
		new JCTitleSearchAG({
			// 'AJAX_PAGE' : '/your-path/fast_search.php',
			'AJAX_PAGE': '<?php echo CUtil::JSEscape(POST_FORM_ACTION_URI) ?>',
			'CONTAINER_ID': '<?php echo $CONTAINER_ID ?>',
			'INPUT_ID': '<?php echo $INPUT_ID ?>',
			'PRELODER_ID': '<?php echo $PRELOADER_ID ?>',
			'CLEAR_ID': '<?php echo $CLEAR_ID ?>',
			'MIN_QUERY_LEN': 2
		});

		new ModernModalSearch({
			'CONTAINER_ID': '<?php echo $CONTAINER_ID ?>',
			'INPUT_ID': '<?php echo $INPUT_ID ?>',
		})

        <?php if (count($arResult["HINTS"])): ?>
			new Typed('#<?php echo $INPUT_ID ?>', {
				strings: <?= CUtil::PhpToJSObject($arResult["HINTS"]); ?>,
				typeSpeed: <?= $arParams["ANIMATE_HINTS_SPEED"] * 20 ?>,
				backSpeed: <?= $arParams["ANIMATE_HINTS_SPEED"] * 10 ?>,
				backDelay: 500,
				startDelay: 1000,
				// smartBackspace: true,
				bindInputFocusEvents: true,
				attr: 'placeholder',
				loop: true
			});
        <?php endif; ?>
	});
</script>
