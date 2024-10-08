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

<section class="addr">
	<div class="addr__wrap">
		<div class="addr__btns">
			<?foreach($arResult["ITEMS"] as $key => $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
			<button class="addr__btn <?=$key == 0 ? 'active' : ''?>" data-btn="<?=$key?>">
				<div class="addr__btnName"><?=$arItem['NAME']?></div>
				<?if(isset($arItem['PREVIEW_TEXT']) && !empty($arItem['PREVIEW_TEXT'])):?>
				<div class="addr__btnDescr">
					<?=$arItem['PREVIEW_TEXT']?>
				</div>
				<?endif?>
			</button>
			<?endforeach;?>
		</div>

		<div class="addr__map">
			<?foreach($arResult["ITEMS"] as $key => $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
			<div data-id="<?=$key?>" <?=$key == 0 ? 'class="active"' : ''?>>
				<?=$arItem["PROPERTIES"]['MAP']['~VALUE']?>
			</div>
			<?endforeach?>
		</div>
	</div>
</section>