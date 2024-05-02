<?php

use Bitrix\Iblock\BizprocType\ECrm;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
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

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

?>

<section class="bg-white">
	<div class="brands-index__wrapper container">
		<div class="brands-index__inner">
			<div class="brands-index">

				<div class="brands-index__header">
					<div class="brands-index__title">
						<h1><?=Loc::getMessage('BRAND_TITLE')?></h1>
					</div>
					<div class="brands-index__search">
						<div class="input--lg">
							<input placeholder="<?=Loc::getMessage('SEARCH_PLACEHOLDER')?>" type="text" class="form-control search-brand-panel" maxlength="255" value="">
						</div>
						<div class="brands-index__search-result hide"></div>
					</div>
					<div class="brands-index__alph">
						<?php include 'alphabet_line.php' ?>
					</div>
				</div>

				<div class="brands-index__list-brands">
					<?foreach ($arResult['BRANDS_ALPHABET'] as $typeWord => $arWords):?>
						<div class="brands-index__list-brand">
							<div class="brands-index__list-brand-items">
								<?foreach ($arWords as $arWordKey => $arWord):?>
									<div data-word-anchor = '<?=$arWordKey?>' class="brands-index__list-brand-main-wrapper">
										<div class="brands-index__list-brand-main-word">
											<h2><?=$arWordKey?></h2>
										</div>
										<div class="brands-index__list-brand-item-wrapper">
											<?foreach ($arWord as $brand):?>
												<div class="brands-index__list-brand-item">
													<a href="<?=$arResult['BRANDS_FILTERS'][$brand] ?? '#'?>">
														<?=$brand?>
													</a>
												</div>
											<?endforeach;?>
										</div>
									</div>
								<?endforeach;?>
							</div>
						</div>
					<?endforeach;?>
				</div>

				<div class="brands-index__footer">
					<div class="brands-index__alph">
						<?php include 'alphabet_line.php' ?>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>

<script>
	const brandsForSearch = <?= json_encode($arResult['BRANDS_SEARCH']); ?>;
	const brandsFilters = <?= json_encode($arResult['BRANDS_FILTERS']); ?>;
</script>


