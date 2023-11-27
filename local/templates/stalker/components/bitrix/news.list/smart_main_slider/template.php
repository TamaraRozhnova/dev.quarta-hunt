<? if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
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

CModule::IncludeModule( 'iblock' );
?>
<section class="hero">
	<div class="container">
		<div class="swiper hero__slider">
			<div class="swiper-wrapper" style="height: auto !important;">
				<?
				$arSelect = [
					"ID",
					"IBLOCK_ID",
					"CODE",
					"NAME",
					"PROPERTY_SUBTITLE",
					"PROPERTY_LONG",
					"PROPERTY_LONG_GUN",
					"PROPERTY_BALLOON",
					"PROPERTY_CALIBER",
					"DETAIL_PICTURE",
					"PROPERTY_TITLE_2",
					"PROPERTY_SUBTITLE_2",
					"PROPERTY_LINK",
				];
				$arFilter = [
					"IBLOCK_ID" => $arParams['IBLOCK_ID'],
					"ACTIVE_DATE" => "Y",
					"ACTIVE" => "Y",
				];
				$res = CIblockElement::GetList( [ "DATE_CREATE" => "DESC" ],
					$arFilter,
					false,
					false,
					$arSelect );
				while ($ob = $res->GetNextElement())
				{
					$arFields = $ob->GetFields();
					$img = CFile::GetPath( $arFields['DETAIL_PICTURE'] );
					?>
					<div class="swiper-slide hero__slide">

						<div class="hero__slide-background">
							<img src="<?=$img?>" alt=""/>
						</div>
						<div class="hero__slide-content">
							<div class="hero__slide-title"><?/*=$arFields['NAME'];?></br><?=$arFields['PROPERTY_TITLE_2_VALUE'];*/?></div>
							<div class="hero__slide-subtitle"><?/*=$arFields['PROPERTY_SUBTITLE_VALUE'];?></br><?=$arFields['PROPERTY_SUBTITLE_2_VALUE'];*/?></div>
							<div class="hero__slide-characteristic">
								<? /*<div class="hero__slide-characteristic__item">
									<div class="hero__slide-characteristic__title">Длина, мм</div>
									<div class="hero__slide-characteristic__value"><?=$arFields['PROPERTY_LONG_VALUE'];?></div>
								</div>
								<div class="hero__slide-characteristic__item">
									<div class="hero__slide-characteristic__title">Длина ствола, мм</div>
									<div class="hero__slide-characteristic__value"><?=$arFields['PROPERTY_LONG_GUN_VALUE'];?></div>
								</div>
								<div class="hero__slide-characteristic__item">
									<div class="hero__slide-characteristic__title"> Балон СО2, гр</div>
									<div class="hero__slide-characteristic__value"><?=$arFields['PROPERTY_BALLOON_VALUE'];?></div>
								</div>
								<div class="hero__slide-characteristic__item">
									<div class="hero__slide-characteristic__title"> Калибр, мм</div>
									<div class="hero__slide-characteristic__value"><?=$arFields['PROPERTY_CALIBER_VALUE'];?></div>
								</div>*/?>
							</div>
							<a href="<?=$arFields['PROPERTY_LINK_VALUE'];?>" class="ui-button ui-button--red" style="min-width: 217px"> Смотреть </a>
						</div>
						<a href="<?=$arFields['PROPERTY_LINK_VALUE'];?>" class="hero__slide-link">
							<span class="ui-underline ui-underline--full"> Смотреть </span>
							<svg class="icon icon-chevron-right">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-chevron-right"></use>
							</svg>
						</a>
					</div>
				<? } ?>

			</div>
			<div class="swiper-pagination"></div>
		</div>
	</div>
</section>

