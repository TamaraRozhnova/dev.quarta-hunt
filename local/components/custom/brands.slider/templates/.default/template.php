<?php 

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
/** @var CBitrixComponent $component */?>

<section class="bg-light">
	<div class="brands-slider__wrapper">
		<div class="brands-slider__inner">
			<div class="brands-slider">
				<div class="brands-slider-container">
					<div class="swiper-container swiper-container-brands">
						<div class="base-slider__arrow-prev-wrapper">
							<div class="base-slider__prev" role="button"></div>
						</div>

						<div class="swiper-wrapper">
							<? foreach ($arResult['BRANDS_SLIDER_ITEMS'] as $arBrandSlider): ?>
								<div class="swiper-slide">
									<div class="brands-slider-item">
										<a href="<?=$arBrandSlider['URL']?>" class="brands-slider-item-img">
											<img src="<?=$arBrandSlider['IMAGE']['src']?>">
										</a>
									</div>
								</div>
							<? endforeach; ?>
						</div>
						<div class="base-slider__arrow-next-wrapper">
							<div class="base-slider__next" role="button"></div>
						</div>

					</div>
				</div>
				<div class="brands-slider__btn">
					<a href="/brendy/">
						Все бренды
					</a>
				</div>
			</div>
		</div>
	</div>
</section>


