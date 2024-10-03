<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

<section class="contacts">
	<div class="contacts__wrap">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
		<div class="contacts__card" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="contacts__info">
				<div class="contacts__icon">
					<img src="/img/map.svg" alt="">
				</div>
				<div class="contacts__inf">
					<div class="contacts__addr">Санкт-Петербург, Московский проспект, д.222</div>
					<?if(isset($arItem['PROPERTIES']['PHONE']['VALUE']) && !empty($arItem['PROPERTIES']['PHONE']['VALUE'])):?>
					<a href="tel:<?=$arItem['PROPERTIES']['PHONE']['VALUE']?>" class="contacts__link"><?=$arItem['PROPERTIES']['PHONE']['VALUE']?></a>
					<?endif?>

					<?if(isset($arItem['PROPERTIES']['MAIL']['VALUE']) && !empty($arItem['PROPERTIES']['MAIL']['VALUE'])):?>
					<a href="mailto:<?=$arItem['PROPERTIES']['MAIL']['VALUE']?>" class="contacts__link"><?=$arItem['PROPERTIES']['MAIL']['VALUE']?></a>
					<?endif?>
				</div>
			</div>

			<?if(isset($arItem['PROPERTIES']['MAP']['VALUE']) && !empty($arItem['PROPERTIES']['MAP']['VALUE'])):?>
			<?=$arItem['PROPERTIES']['MAP']['~VALUE']?>
			<?endif?>
		</div>
		<?endforeach?>
	</div>
</section>
