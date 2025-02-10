<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

\Bitrix\Main\UI\Extension::load(['ui.design-tokens']);

$this->setFrameMode(true);

if (!$arResult["NavShowAlways"]) {
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}
?>
<div class="modern-page-navigation">
	<?

	$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
	$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");
	?>
	<?
	$bFirst = true;

	if ($arResult["NavPageNomer"] > 1):
		if ($arResult["bSavePage"]):
	?>
			<a class="modern-page modern-page-previous" href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"><?= GetMessage("nav_prev") ?></a>
			<?
		else:
			if ($arResult["NavPageNomer"] > 2) {
			?>
				<a class="modern-page modern-page-previous" href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7.70711 6.29289C8.09763 6.68342 8.09763 7.31658 7.70711 7.70711L1.70711 13.7071C1.31658 14.0976 0.683417 14.0976 0.292893 13.7071C-0.0976311 13.3166 -0.0976311 12.6834 0.292893 12.2929L5.58579 7L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z" fill="#354052" />
					</svg>
				</a>
			<?
			} else {
			?>
				<a class="modern-page modern-page-previous" href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7.70711 6.29289C8.09763 6.68342 8.09763 7.31658 7.70711 7.70711L1.70711 13.7071C1.31658 14.0976 0.683417 14.0976 0.292893 13.7071C-0.0976311 13.3166 -0.0976311 12.6834 0.292893 12.2929L5.58579 7L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z" fill="#354052" />
					</svg>
				</a>
			<? }

		endif;

		if ($arResult["nStartPage"] > 1):
			$bFirst = false;
			if ($arResult["bSavePage"]):
			?>
				<a class="modern-page modern-page-first" href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1">1</a>
			<?
			else:
			?>
				<a class="modern-page modern-page-first" href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">1</a>
			<?
			endif;
			if ($arResult["nStartPage"] > 2):
			?>
				<a class="modern-page modern-page-dots" href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= round($arResult["nStartPage"] / 2) ?>">...</a>
		<?
			endif;
		endif;
	else: ?>
		<span class="modern-page modern-page-previous disabled">
			<svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7.70711 6.29289C8.09763 6.68342 8.09763 7.31658 7.70711 7.70711L1.70711 13.7071C1.31658 14.0976 0.683417 14.0976 0.292893 13.7071C-0.0976311 13.3166 -0.0976311 12.6834 0.292893 12.2929L5.58579 7L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z" fill="#354052" />
			</svg>
		</span>
		<? endif;

	do {
		if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
		?>
			<span class="modern-page <?= ($bFirst ? "modern-page-first " : "") ?>modern-page-current"><?= $arResult["nStartPage"] ?></span>
		<?
		elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
		?>
			<a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>" class="modern-page <?= ($bFirst ? "modern-page-first" : "") ?>"><?= $arResult["nStartPage"] ?></a>
		<?
		else:
		?>
			<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>" <?
																																			?> class="modern-page <?= ($bFirst ? "modern-page-first" : "") ?>"><?= $arResult["nStartPage"] ?></a>
			<?
		endif;
		$arResult["nStartPage"]++;
		$bFirst = false;
	} while ($arResult["nStartPage"] <= $arResult["nEndPage"]);

	if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
		if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
			if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
			?>
				<a class="modern-page modern-page-dots" href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2) ?>">...</a>
			<?
			endif;
			?>
			<a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>"><?= $arResult["NavPageCount"] ?></a>
		<?
		endif;
		?>
		<a class="modern-page modern-page-next" href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7.70711 6.29289C8.09763 6.68342 8.09763 7.31658 7.70711 7.70711L1.70711 13.7071C1.31658 14.0976 0.683417 14.0976 0.292893 13.7071C-0.0976311 13.3166 -0.0976311 12.6834 0.292893 12.2929L5.58579 7L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z" fill="#354052" />
			</svg>
		</a>
	<?
	else: ?>
		<span class="modern-page modern-page-next disabled">
			<svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7.70711 6.29289C8.09763 6.68342 8.09763 7.31658 7.70711 7.70711L1.70711 13.7071C1.31658 14.0976 0.683417 14.0976 0.292893 13.7071C-0.0976311 13.3166 -0.0976311 12.6834 0.292893 12.2929L5.58579 7L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z" fill="#354052" />
			</svg>
		</span>
	<? endif;
	?>
</div>