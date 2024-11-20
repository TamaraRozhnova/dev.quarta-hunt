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
$open = false;
?>
<div class="media__grid">
	<?php foreach ($arResult['ITEMS'] as $index => $item):
		if ($index % 3 == 0)
		{
			echo '<div class="media__row">';
			$open = true;
		}
		?>
		<div class="media__item">
			<div class="media__item-picture">
				<img class="lazy" data-src="<?=$item['PREVIEW_PICTURE']['SRC']?>"/>
				<a href="<?=$item['PROPERTIES']['LINK']['VALUE']?>" data-fancybox="<?=$item['ID']?>"
				   class="media__item-play">
					<?php Image::showSvg('play')?>
				</a>
			</div>
			<div class="media__item-description">
				<?=$item['NAME']?>
			</div>
		</div>
		<?php
		if ($index % 3 == 2)
		{
			$open = false;
			echo '</div>';
		}
		?>
	<?php endforeach; ?>
	<?php
	if($open)
	{
		echo '</div>';
	}
	?>
</div>
