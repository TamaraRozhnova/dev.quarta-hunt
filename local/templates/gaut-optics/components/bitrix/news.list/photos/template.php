<?php use Spro\Image;

if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
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

<?php if ($arResult['ITEMS']):
	$first = array_shift($arResult['ITEMS']);
	$second = array_shift($arResult['ITEMS']);
	?>
	<div class="photos">
		<div class="photos__big">
			<picture>
				<img class="lazy" data-src="<?=$first['PREVIEW_PICTURE']['SRC']?>" alt=""/>
			</picture>
			<?php if ($second): ?>
				<picture>
					<img class="lazy" data-src="<?=$second['PREVIEW_PICTURE']['SRC']?>" alt=""/>
				</picture>
			<?php endif ?>
		</div>
		<div class="photos__min">
			<?php foreach ($arResult['ITEMS'] as $index => $arItem): ?>
				<picture>
					<img class="lazy" data-src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt=""/>
				</picture>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif ?>
