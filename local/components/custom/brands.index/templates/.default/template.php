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

?>

<section class="bg-white">
	<div class="brands-index__wrapper container">
		<div class="brands-index__inner">
			<div class="brands-index">
				<div class="brands-index__header">
					<div class="brands-index__title">
						<h1>Все бренды</h1>
					</div>
					<div class="brands-index__search">
						<div class="input--lg">
							<input placeholder="Хочу найти..." type="text" class="form-control" maxlength="255" value="" inputmode="text">
						</div>
					</div>
					<div class="brands-index__alph">

					<?if (!empty($arResult['BRANDS_SLIDER_ALPHABET'])):?>
						<div class="brands-index__alph-words">
							<?if (!empty($arResult['BRANDS_SLIDER_ALPHABET']['ENG_WORDS'])):?>
								<?foreach ($arResult['BRANDS_SLIDER_ALPHABET']['ENG_WORDS'] as $engWordKey => $endWord):?>
									<div class="brands-index__alph-word">
										<a href="#<?=$engWordKey?>">
											<?=$engWordKey?>
										</a>
									</div>
								<?endforeach;?>

							<?endif;?>
							<?if (!empty($arResult['BRANDS_SLIDER_ALPHABET']['RUS_WORDS'])):?>
								<div class="brands-index__alph-word">
									<a href="#А-Я">
										А-Я
									</a>
								</div>
							<?endif;?>
							<?if (!empty($arResult['BRANDS_SLIDER_ALPHABET']['NUMERIC'])):?>
								<div class="brands-index__alph-word">
									<a href="#0-9">
										0-9
									</a>
								</div>
							<?endif;?>
						</div>
					<?endif;?>
					</div>
				</div>

				<div class="brands-index__list-brands">

					<?foreach ($arResult['BRANDS_SLIDER_ALPHABET'] as $typeWord => $arWords):?>
						<div class="brands-index__list-brand">
							<div class="brands-index__list-brand-items">
								<?foreach ($arWords as $arWordKey => $arWord):?>
									<div class="brands-index__list-brand-main-word">
										<?if ($typeWord == 'RUS_WORDS'):?>
											<h2>А-Я</h2>
										<?elseif($typeWord == 'ENG_WORDS'):?>
											<h2><?=$arWordKey?></h2>
										<?elseif($typeWord == 'NUMERIC'):?>
											<h2>0-9</h2>
										<?endif;?>
									</div>
									<?foreach ($arWord as $brand):?>
										<div class="brands-index__list-brand-item">
											<a href="">
												<?=$brand?>
											</a>
										</div>
									<?endforeach;?>
								<?endforeach;?>
							</div>
						</div>
					<?endforeach;?>


				</div>

			</div>
		</div>
	</div>
</section>


