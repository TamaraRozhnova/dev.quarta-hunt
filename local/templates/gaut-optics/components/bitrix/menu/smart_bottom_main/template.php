<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

if (empty($arResult))
	return;
?>
<div class="footer-head">
            <div class="logo footer-logo">
	            <?
				$APPLICATION->IncludeFile('/_includes/logo_ft.php', false, array('SHOW_BORDER'=>false));
				?>
            </div>

<nav class="footer__nav">
		<?foreach($arResult as $itemIdex => $arItem):?>
			<?if ($arItem["DEPTH_LEVEL"] == "1"):?>
<div class="footer__nav-item">
<a href="<?=htmlspecialcharsbx($arItem["LINK"])?>" class="footer__nav-link ui-link ui-link--underline ui-link ui-link--underline--underline"><?=htmlspecialcharsbx($arItem["TEXT"], ENT_COMPAT, false)?></a>
  </div>
			<?endif?>
		<?endforeach;?>
</nav>
</div>
