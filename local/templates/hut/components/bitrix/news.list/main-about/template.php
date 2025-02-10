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

use Helpers\IblockHelper;

$this->setFrameMode(true);
?>
<div class="main-about__inner">
	<div class="main-about__top">
		<div class="main-about__title"><?= CIBlock::GetArrayByID(IblockHelper::getIdByCode("mainabout"), "DESCRIPTION") ?></div>
		<a class="main-section__link main-about__link" href="<?= $arParams['LINK_VALUE'] ?>"><?= $arParams['LINK_TEXT'] ?></a>
	</div>
	<div class="main-about__list">
		<? foreach ($arResult["ITEMS"] as $arItem): ?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<div class="main-about__item" style="<?= $arItem['PROPERTIES']['BACK_COLOR']['VALUE'] ? 'background-color:' . $arItem['PROPERTIES']['BACK_COLOR']['VALUE'] . ';' . 'border-color:' . $arItem['PROPERTIES']['BACK_COLOR']['VALUE'] . ';' : '' ?>">
				<? if ($arItem['PREVIEW_PICTURE']) { ?>
					<div class="main-about__back" style="<?= $arItem['PREVIEW_PICTURE'] ? 'background-image: url(' . $arItem['PREVIEW_PICTURE']['SRC'] . ');' : '' ?>"></div>
				<? } ?>
				<img src="<?= CFile::GetPath($arItem['PROPERTIES']['ICON']['VALUE']) ?>" alt="">
				<div class="main-about__item-text"><?= $arItem['PREVIEW_TEXT'] ?></div>
			</div>
		<? endforeach; ?>
	</div>
</div>