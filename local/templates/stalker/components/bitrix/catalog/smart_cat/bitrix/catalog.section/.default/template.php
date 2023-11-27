<?php if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global \CMain $APPLICATION */
/** @global \CUser $USER */
/** @global \CDatabase $DB */
/** @var \CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var array $templateData */
/** @var \CBitrixComponent $component */
$this->setFrameMode( true );
/*echo '<pre>';
print_r($arResult);
echo '</pre>';*/

echo_j($arParams);
?>
<div class="inner__hero">
	<? if($arResult['DETAIL_PICTURE']['SRC']):?>
		<div class="inner__hero-img">
			<picture>
				<source media="(max-width: 743px)" srcset="<?=$arResult['BACKGROUND_IMAGE']['SRC']?>">
				<img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>">
			</picture>
		</div>
	<?endif?>
	<? if($arResult['DESCRIPTION']):?>
		<div class="inner__hero-desc">
			<?=$arResult['DESCRIPTION']?>
		</div>
	<?endif?>
</div>
<div class="inner__catalog catalog">
	<div class="catalog__list">
		<? foreach ($arResult['ITEMS'] as $index => $arItem)
		{
			$APPLICATION->IncludeComponent( 'bitrix:catalog.item',
                'catalog.item',
//                'catalog.item',
                [
				'RESULT' => [
					'ITEM' => $arItem,
					'SHOW_PROPS' => $arResult['SHOW_PROPS'],
				],
			] );
		} ?>
	</div>
</div>
