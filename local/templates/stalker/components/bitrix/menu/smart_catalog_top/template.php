<?
if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
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

if (empty( $arResult ))
{
	return;
}
?>
<? CModule::IncludeModule( "iblock" );
$list_1 = [];

$arFilter = [
	'IBLOCK_ID' => COption::GetOptionString( 'spro.wizard', 'ib-catalog',  '', SITE_ID ),
];

$arOrder = [
	'LEFT_MARGIN' => 'ASC',
];

$arSelect = [
	'ID',
	'LEFT_MARGIN',
	'DEPTH_LEVEL',
	'NAME',
	'PICTURE',
	'SECTION_PAGE_URL'
];

$resSections = \CIBlockSection::GetList( $arOrder, $arFilter, false, $arSelect );

while ($arSection = $resSections->GetNext())
{
	if ($arSection['DEPTH_LEVEL'] == 1)
	{
		$i = $arSection['ID'];
		$list_1[ $i  ] = $arSection;

	}
	elseif ($arSection['DEPTH_LEVEL'] == 2)
	{
		$list_1[ $i ]['UNDER'][ $arSection['ID'] ] = $arSection;
	}
}
?>
	<? foreach ($list_1 as $main) { ?>
		<div class="nav-catalog__item">
			<div class="nav-catalog__item-img">
				<picture>
					<img class="lazy" data-src="<?=CFile::GetPath($main['PICTURE'])?>" alt=""/>
				</picture>
				<div class="dot dot--top-left"></div>
				<div class="dot dot--top-right"></div>
				<div class="dot dot--bottom-left"></div>
				<div class="dot dot--bottom-right"></div>
			</div>
			<div class="nav-catalog__item-inner">
				<a href="<?=$main['SECTION_PAGE_URL']?>" class="nav-catalog__item-title"><?=$main['NAME']?></a>
				<ul>
					<? foreach ($main['UNDER'] as $key => $under) { ?>
						<li>
							<a href="<?=$under['SECTION_PAGE_URL']?>" class="ui-link ui-link--underline"><?=$under['NAME']?></a>
						</li>
					<? } ?>
				</ul>
			</div>
		</div>
	<? } ?>
