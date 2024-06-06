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
?>
<?php foreach ($arResult['ITEMS'] as $index => $arItem): ?>
	<div class="popular-questions accordion" data-accordion>
		<div class="accordion__item-head" data-accordion-head>
			<?=$arItem['NAME']?>
			<div class="accordion__item-plus"></div>
		</div>
		<div class="accordion__item-body" data-accordion-body>
			<div class="accordion__item-content">
				<?=$arItem['PREVIEW_TEXT']?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
