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

use Bitrix\Main\Page\Asset;

$this->setFrameMode(true);

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/modules/scrollbar/overlayscrollbars.min.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/modules/scrollbar/overlayscrollbars.browser.es5.js");
?>
<div class="sections-top">
	<div class="sections-top__ul-wrap">
		<ul class="sections-top__list">
			<li>
				<a class="sections-top__title" href="<?= $arResult['ALL_URL'] ? $arResult['ALL_URL'] : $arResult['SECTION']['SECTION_PAGE_URL'] ?>">
					<span>Все</span>
				</a>
			</li>
			<?
			foreach ($arResult['SECTIONS'] as &$arSection) {
				$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
				$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams); ?>
				<li id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
					<a class="sections-top__title" href="<? echo $arSection['SECTION_PAGE_URL']; ?>">

						<span><? echo $arSection['NAME']; ?></span>
					</a>
				</li>
			<?
			}
			unset($arSection);
			?>
		</ul>
	</div>
</div>