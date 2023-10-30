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
$media = [];
$mediaMain = [];

?>

<?
$arSelect = [
	"ID",
	"IBLOCK_ID",
	"CODE",
	"NAME",
	"PROPERTY_SUBTITLE",
	"DETAIL_PICTURE",
	"PROPERTY_LINK",
	"DETAIL_TEXT",
	"PROPERTY_MAIN_",
];
$arFilter = [
	"IBLOCK_ID" => $arParams['IBLOCK_ID'],
	"ACTIVE_DATE" => "Y",
	"ACTIVE" => "Y",
];
$res = CIblockElement::GetList(
	[ "propertysort_MAIN" => "asc,nulls" ],
	$arFilter,
	false,
	[ 'nTopCount' => 4 ],
	$arSelect );
while ($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();


	$item['NAME'] = $arFields['NAME'];
	$item['PROPERTY_SUBTITLE'] = $arFields['PROPERTY_SUBTITLE_VALUE'];
	$item['DETAIL_PICTURE'] = $arFields['ETAIL_PICTURE'];
	$item['LINK'] = $arFields['PROPERTY_LINK_VALUE'];
	$item['DETAIL_TEXT'] = $arFields['DETAIL_TEXT'];
	$item['MAIN'] = $arFields['PROPERTY_MAIN_VALUE'];

	if ($item['MAIN'] == "Да")
	{
		$mediaMain = $item;
	}
	else
	{
		$media[ $arFields['ID'] ] = $item;
	}
}
?>

<?php if ($mediaMain || count( $media )): ?>
	<section class="section section-media">
		<div class="container">
			<div class="section-media__head">
				<h2 class="section__title"><? $APPLICATION->IncludeFile( '/_includes/main/media_title.php' ); ?> </h2>
				<a href="/media/" class="section-media__link ui-link">
					<span class="ui-underline ui-underline--full"> Все медиа </span>
					<svg class="icon icon-chevron-right">
						<use xlink:href="/bitrix/templates/stalker/img/sprite.svg#icon-chevron-right"></use>
					</svg>
				</a>
			</div>

			<?php
			if ($mediaMain)
			{ ?>
				<div class="section-media__body">
					<div class="section-media__video video">
						<div class="video-block">
							<img class="lazy" data-src="<?=CFile::GetPath( $mediaMain['DETAIL_PICTURE'] );?>" alt=""/>
						</div>
						<div class="video-btn">
							<svg class="icon icon-play">
								<use xlink:href="/bitrix/templates/stalker/img/sprite.svg#icon-play"></use>
							</svg>
						</div>
					</div>
					<div class="section-media__description">
						<div class="play">
							<svg class="icon icon-play">
								<use xlink:href="/bitrix/templates/stalker/img/sprite.svg#icon-play"></use>
							</svg>
						</div>
						<h3 class="section__title"> <?=$mediaMain['NAME'];?> </h3>
						<div class="section__text"><?=$mediaMain['DETAIL_TEXT'];?></div>
						<a href="<?=$mediaMain['LINK'];?>" class="ui-button ui-button--dark"> Смотреть </a>
					</div>
				</div>
				<?
			}
			?>
			<?php if (count( $media )): ?>
				<div class="section-media__list">
					<div class="swiper">
						<div class="swiper-wrapper">
							<? foreach ($media as $arFields)
							{
								?>
								<div class="section-media__item swiper-slide">
									<div class="video">
										<div class="video-block">
											<img class="lazy" data-src="<?=CFile::GetPath( $arFields['DETAIL_PICTURE'] );?>" alt=""/>
										</div>
										<div class="video-btn">
											<svg class="icon icon-play">
												<use xlink:href="/bitrix/templates/stalker/img/sprite.svg#icon-play"></use>
											</svg>
										</div>
									</div>
									<div class="section-media__item-title"> <?=$arFields['NAME'];?></div>
								</div>
								<?
							} ?>
						</div>
					</div>
				</div>
			<?php endif ?>

		</div>
	</section>
<?php endif ?>
