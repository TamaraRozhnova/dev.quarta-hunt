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


<div class="swiper">
	<div class="swiper-wrapper">
		<?
		$arSelect = [ "ID", "IBLOCK_ID", "CODE", "NAME", "PROPERTY_SUBTITLE", "DETAIL_PICTURE", "PROPERTY_LINK", "DETAIL_TEXT" ];
		$arFilter = [ "IBLOCK_ID" => $arParams['IBLOCK_ID'], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y" ];
		$res = CIblockElement::GetList( [ "DATE_CREATE" => "DESC" ], $arFilter, false, $arPages, $arSelect );
		while ($ob = $res->GetNextElement())
		{
			$arFields = $ob->GetFields();

//            $arFields['DETAIL_PICTURE'] = $arFields['DETAIL_PICTURE']);
			?>
			<div class="swiper-slide section__slide">
				<div class="section__slide-background">
					<picture>
						<source data-srcset="<?=str_replace(" ", "%20", CFile::GetPath( $arFields['DETAIL_PICTURE'] ));?>"/>
						<img class="lazy" data-src="<?=str_replace(" ", "%20", CFile::GetPath($arFields['DETAIL_PICTURE']));?>" alt=""/>
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


