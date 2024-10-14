<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

/* hints */
$arResult["HINTS"] = array();
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
$VOICE_ID = $CONTAINER_ID . "_voice_item";

if ($arParams["SHOW_INPUT"] !== "N"): ?>
	<div id="search-title__wrap" class="search-title__wrap">
		<div id="<? echo $CONTAINER_ID ?>" class="container-no-padding">
			<div id="search-title__inner" class="search-title__inner">
				<form action="<? echo $arResult["FORM_ACTION"] ?>">
					<div class="bx-input-group">
						<div class="search-title__input-wrap">
							<span class="search-title__search-icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M8.33333 3.5C5.66396 3.5 3.5 5.66396 3.5 8.33333C3.5 11.0027 5.66396 13.1667 8.33333 13.1667C11.0027 13.1667 13.1667 11.0027 13.1667 8.33333C13.1667 5.66396 11.0027 3.5 8.33333 3.5ZM1.5 8.33333C1.5 4.55939 4.55939 1.5 8.33333 1.5C12.1073 1.5 15.1667 4.55939 15.1667 8.33333C15.1667 9.85959 14.6663 11.269 13.8206 12.4064L18.2071 16.7929C18.5976 17.1834 18.5976 17.8166 18.2071 18.2071C17.8166 18.5976 17.1834 18.5976 16.7929 18.2071L12.4064 13.8206C11.269 14.6663 9.85959 15.1667 8.33333 15.1667C4.55939 15.1667 1.5 12.1073 1.5 8.33333Z" fill="#354052" />
								</svg>
							</span>
							<input id="<? echo $INPUT_ID ?>" placeholder="<?= $arParams["INPUT_PLACEHOLDER"] ?>" type="text" name="q" value="<?= htmlspecialcharsbx($_REQUEST["q"]) ?>" autocomplete="off" class="bx-form-control" />
							<span class="bx-searchtitle-clear" id="<? echo $CLEAR_ID ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M4.29289 4.29289C4.68342 3.90237 5.31658 3.90237 5.70711 4.29289L10 8.58579L14.2929 4.29289C14.6834 3.90237 15.3166 3.90237 15.7071 4.29289C16.0976 4.68342 16.0976 5.31658 15.7071 5.70711L11.4142 10L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L10 11.4142L5.70711 15.7071C5.31658 16.0976 4.68342 16.0976 4.29289 15.7071C3.90237 15.3166 3.90237 14.6834 4.29289 14.2929L8.58579 10L4.29289 5.70711C3.90237 5.31658 3.90237 4.68342 4.29289 4.29289Z" fill="#354052" />
								</svg>
							</span>
						</div>
						<span class="bx-input-group-btn">
							<span class="bx-searchtitle-preloader <? if ($arParams["SHOW_LOADING_ANIMATE"] == 'Y') echo 'view'; ?>" id="<? echo $PRELOADER_ID ?>"></span>
							<? if ($arParams['VOICE_INPUT'] == 'Y'): ?>
								<span class="bx-searchtitle-voice" id="<? echo $VOICE_ID ?>"></span>
							<? endif; ?>
							<button class="button search-title__submit" type="submit" name="s"><?= GetMessage('BUTTON_SEARCH') ?></button>
							<button class="button search-title__close" type="button">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289Z" fill="#354052" />
								</svg>
							</button>
						</span>
					</div>
				</form>
				<div class="search-title__start">
					<? if ($arResult['POPULAR_SECTIONS']) { ?>
						<div class="search-title__popular-wrap">
							<p class="search-title__start-subtitle"><?= GetMessage('POPULAR_SECTIONS') ?></p>
							<ul class="search-title__popular">
								<? foreach ($arResult['POPULAR_SECTIONS'] as $popSect) { ?>
									<li><a href="<?= $popSect['SECTION_PAGE_URL'] ?>"><?= $popSect['NAME'] ?></a></li>
								<? } ?>
							</ul>
						</div>
					<? } ?>
					<div class="search-title__popular-wrap search-title__popular-wrap--history" style="display: none">
						<p class="search-title__start-subtitle">
							<?= GetMessage('HISTORY') ?>
							<button type="button" class="button search-title__remove-history">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M8.49967 3.5V4.83333H11.4997V3.5H8.49967ZM13.4997 4.83333V3.33333C13.4997 2.8471 13.3065 2.38079 12.9627 2.03697C12.6189 1.69315 12.1526 1.5 11.6663 1.5H8.33301C7.84678 1.5 7.38046 1.69315 7.03665 2.03697C6.69283 2.38079 6.49967 2.8471 6.49967 3.33333V4.83333H4.17804C4.171 4.83326 4.16395 4.83326 4.15688 4.83333H3.33301C2.78072 4.83333 2.33301 5.28105 2.33301 5.83333C2.33301 6.35627 2.7344 6.78545 3.2459 6.82959L4.00008 15.8798C4.01209 16.5702 4.29158 17.2298 4.78072 17.719C5.28082 18.219 5.9591 18.5 6.66634 18.5H13.333C14.0403 18.5 14.7185 18.219 15.2186 17.719C15.7078 17.2298 15.9873 16.5702 15.9993 15.8798L16.7535 6.82959C17.2649 6.78545 17.6663 6.35627 17.6663 5.83333C17.6663 5.28105 17.2186 4.83333 16.6663 4.83333H15.8425C15.8354 4.83326 15.8284 4.83326 15.8213 4.83333H13.4997ZM12.4997 6.83333H7.49967H5.25314L5.99622 15.7503C5.99852 15.7779 5.99967 15.8056 5.99967 15.8333C5.99967 16.0101 6.06991 16.1797 6.19494 16.3047C6.31996 16.4298 6.48953 16.5 6.66634 16.5H13.333C13.5098 16.5 13.6794 16.4298 13.8044 16.3047C13.9294 16.1797 13.9997 16.0101 13.9997 15.8333C13.9997 15.8056 14.0008 15.7779 14.0031 15.7503L14.7462 6.83333H12.4997ZM8.33301 8.16667C8.88529 8.16667 9.33301 8.61438 9.33301 9.16667V14.1667C9.33301 14.719 8.88529 15.1667 8.33301 15.1667C7.78072 15.1667 7.33301 14.719 7.33301 14.1667V9.16667C7.33301 8.61438 7.78072 8.16667 8.33301 8.16667ZM11.6663 8.16667C12.2186 8.16667 12.6663 8.61438 12.6663 9.16667V14.1667C12.6663 14.719 12.2186 15.1667 11.6663 15.1667C11.1141 15.1667 10.6663 14.719 10.6663 14.1667V9.16667C10.6663 8.61438 11.1141 8.16667 11.6663 8.16667Z" fill="#9B9EA9" />
								</svg>
							</button>
						</p>
					</div>
				</div>

				<? $frame = $this->createFrame()->begin(''); ?>
				<? if ($arParams['SHOW_HISTORY_POPUP'] != 'Y' && is_array($arResult["SEARCH_HISTORY"]) && count($arResult["SEARCH_HISTORY"]) > 0): ?>
					<div class="bx-searchtitle-history">
						<?= GetMessage("CT_BST_SEARCH_HISTORY") ?>
						<? foreach ($arResult["SEARCH_HISTORY"] as $k => $v):
							if ($k > 0) echo ', '; ?>
							<a href="<?= $arParams["PAGE"] ?>?q=<?= $v ?>"><?= $v ?></a>
						<? endforeach ?>
					</div>
				<? endif; ?>
				<? $frame->end(); ?>
			</div>
		</div>
	</div>
	<div class="search-title__overlay"></div>
<? endif ?>

<script>
	BX.ready(function() {
		new JCTitleSearchAG({
			// 'AJAX_PAGE' : '/your-path/fast_search.php',
			'AJAX_PAGE': '<? echo CUtil::JSEscape(POST_FORM_ACTION_URI) ?>',
			'WRAP_ID': 'search-title__wrap',
			'INNER_ID': 'search-title__inner',
			'CONTAINER_ID': '<? echo $CONTAINER_ID ?>',
			'INPUT_ID': '<? echo $INPUT_ID ?>',
			'PRELODER_ID': '<? echo $PRELOADER_ID ?>',
			'CLEAR_ID': '<? echo $CLEAR_ID ?>',
			'VOICE_ID': '<?= ($arParams['VOICE_INPUT'] == 'Y') ? $VOICE_ID : '' ?>',
			'POPUP_HISTORY': '<?= ($arParams['SHOW_HISTORY'] == 'Y') ? $arParams['SHOW_HISTORY_POPUP'] : 'N' ?>',
			'POPUP_HISTORY_TITLE': '<?= GetMessage("CT_BST_SEARCH_HISTORY") ?>',
			'PAGE': '<?= $arParams["PAGE"] ?>',
			'MIN_QUERY_LEN': 2
		});

		<? if (count($arResult["HINTS"])): ?>
			new Typed('#<? echo $INPUT_ID ?>', {
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
		<? endif; ?>
	});
</script>