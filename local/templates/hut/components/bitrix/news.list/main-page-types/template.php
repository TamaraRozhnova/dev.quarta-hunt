<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

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

$this->setFrameMode(true); ?>

<div class="main-sections__wrap">
	<?php  if (count($arResult['ITEMS']) > 0) : ?>
		<ul class="main-sections__list">
			<?php foreach ($arResult['ITEMS'] as $item) : ?>
            <li class="parent"
                <?= $item['DETAIL_PICTURE'] && $item['DETAIL_PICTURE']['SRC'] ?
                    'style="background-image:url(' . $item['DETAIL_PICTURE']['SRC'] . ')"' :
                    ''
                ?>
            >
					<div class="main-sections__title">
						<a href="<?= $item['PROPERTIES']['LINK']['VALUE'] ?>">
                            <?= $item['NAME']; ?>
						</a>
					</div>
            </li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>