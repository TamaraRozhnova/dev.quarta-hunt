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

<ul class="social">
	<?php foreach ($arResult as $item): ?>
		<li class="social__item">
			<a href="<?=$item['UF_LINK']?>" target="_blank" class="social__link">
				<? Image::showSVG($item['UF_SVG']);?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>
