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
$this->setFrameMode(true);
?>
<marquee class="header__string">
	<div class="header__string-inner">
		<? for ($n = 0; $n <= 50; $n++) { ?>
			<? foreach ($arResult["ITEMS"] as $arItem) { ?>
				<span class="header__string-item">
					<?= $arItem["NAME"] ?>
				</span>
			<? } ?>
		<? } ?>
	</div>
</marquee>