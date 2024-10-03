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

<section class="guarantees guarantees--pb">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
	 <div class="guarantees__card" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<h2 class="guarantees__name"><?=$arItem['NAME']?></h2>
		<div class="guarantees__text">
		   <?=$arItem['PREVIEW_TEXT']?>
	
			<?if(isset($arItem['PROPERTIES']['GALERY']['VALUE']) && !empty($arItem['PROPERTIES']['GALERY']['VALUE'])):?>
			<div class="gal">
				<?foreach($arItem['PROPERTIES']['GALERY']['VALUE'] as $item):?>
					<img src="<?=CFile::GetPath($item)?>" alt="">
				<?endforeach;?>
			</div>
			<?endif?>
		</div>
	 </div>
	<?endforeach;?>
</section>

