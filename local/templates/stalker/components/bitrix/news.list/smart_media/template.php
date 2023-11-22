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
$this->setFrameMode( true );
CModule::IncludeModule( 'iblock' );
?>
<section class="section section-slider">
	<div class="container">
		<div class="section__wrapper">
			<div class="section__content">
				<div class="section__title"> Пистолеты Stalker</div>
				<div class="section__description"> GAZelle NEXT is not just a commercial vehicle, it is a truly professional tool designed to increase business profitability for
					its owner.....
				</div>
				<div class="section__slider-navigation">
					<button class="swiper-button-prev ui-swiper-button">
						<svg class="icon icon-arrow-prev">
							<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-arrow-prev"></use>
						</svg>
					</button>
					<button class="swiper-button-next ui-swiper-button">
						<svg class="icon icon-arrow-next">
							<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-arrow-next"></use>
						</svg>
					</button>
				</div>
			</div>
			<div class="section__slider">
				<div class="swiper">
					<div class="swiper-wrapper">
						<?
						$arSelect = [ "ID", "IBLOCK_ID", "CODE", "NAME", "PROPERTY_SUBTITLE", "DETAIL_PICTURE", "PROPERTY_LINK", "DETAIL_TEXT" ];
						$arFilter = [ "IBLOCK_ID" =>  IBLOCKS['ib-pistol'], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y" ];
						$res = CIblockElement::GetList( [ "DATE_CREATE" => "DESC" ], $arFilter, false, $arPages, $arSelect );
						while ($ob = $res->GetNextElement())
						{
							$arFields = $ob->GetFields();
							?>
							<div class="swiper-slide section__slide">
								<div class="section__slide-background">
									<picture>
										<source data-srcset="<?=CFile::GetPath( $arFields['DETAIL_PICTURE'] );?>"/>
										<img class="lazy" data-src="<?=CFile::GetPath( $arFields['DETAIL_PICTURE'] );?>" alt=""/>
									</picture>
								</div>
								<div class="section__slide-content">
									<div class="section__slide-title"> <?=$arFields['PROPERTY_SUBTITLE_VALUE'];?>
										<div class="section__slide-title__name"><?=$arFields['NAME'];?></div>
									</div>
									<div class="section__slide-description"><?=$arFields['DETAIL_TEXT'];?></div>
									<a href="<?=$arFields['PROPERTY_LINK_VALUE'];?>" class="section__slide-link">
										<span class="ui-underline ui-underline--full"> Подробнее </span>
										<svg class="icon icon-chevron-right">
											<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-chevron-right"></use>
										</svg>
									</a>
								</div>
							</div>
						<? } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
