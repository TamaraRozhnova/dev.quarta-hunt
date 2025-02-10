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
<?php if ($arResult['ITEMS']): ?>
	<div class="section__body recomm">
		<div class="swiper swiper-slider1">
            <div class="section__slider-navigation">
                <button class="swiper-button-prev ui-swiper-button">
                    <? \Spro\Image::showSVG( 'arrow-prev' ) ?>
                </button>
                <div class="section__title">Популярные товары</div>
                <button class="swiper-button-next ui-swiper-button">
                    <? \Spro\Image::showSVG( 'arrow-next' ) ?>
                </button>
            </div>
            <p class="recomm__text">Самые любимые товары наших клиентов! Не пропустите возможность открыть для себя их преимущества.</p>
			<div class="swiper-wrapper">
				<?php foreach ($arResult['ITEMS'] as $index => $arItem): ?>
					<div class="swiper-slide catalog__item-slide">
						<? $APPLICATION->IncludeComponent( 'bitrix:catalog.item', 'catalog.similar', [
							'RESULT' => [ 'ITEM' => $arItem ],
						] );?>

					</div>
				<?php endforeach; ?>
			</div>
        </div>
	</div>
<?php endif ?>
