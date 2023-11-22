<?
if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
?>
<? CModule::IncludeModule( "iblock" );
$list_1 = [];

$arFilter = [
	'IBLOCK_ID' => CATALOG_IBLOCK_ID,
];

$arOrder = [
	'LEFT_MARGIN' => 'ASC',
];

$arSelect = [
	'ID',
	'LEFT_MARGIN',
	'DEPTH_LEVEL',
	'NAME',
	'SECTION_PAGE_URL',
];

$resSections = \CIBlockSection::GetList( $arOrder, $arFilter, false, $arSelect );

while ($arSection = $resSections->GetNext())
{
	if ($arSection['DEPTH_LEVEL'] == 1)
	{
		$list_1[ $arSection['ID'] ]['NAME'] = $arSection['NAME'];
		$list_1[ $arSection['ID'] ]['ID'] = $arSection['ID'];
		$list_1[ $arSection['ID'] ]['SECTION_PAGE_URL'] = $arSection['SECTION_PAGE_URL'];
		$i = $arSection['ID'];

	}
	elseif ($arSection['DEPTH_LEVEL'] == 2)
	{
		$list_1[ $i ]['UNDER'][ $arSection['ID'] ] = [
			'NAME' => $arSection['NAME'],
			'LINK' => $arSection['SECTION_PAGE_URL'],
		];
	}

}
?>
<h1 class="section__title"> Продукция </h1>
<div class="inner__navigation navigation">
	<? foreach ($list_1 as $main) { ?>
		<div class="navigation__item accordion accordion__item">
			<div class="accordion__item-head" data-accordion-head><?=$main['NAME']?>
				<svg class="icon icon-triangle-down">
					<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-triangle-down"></use>
				</svg>
			</div>
			<div class="accordion__item-body" data-accordion-body>
				<div class="accordion__item-content">
					<ul>
						<? foreach ($main['UNDER'] as $key => $under) { ?>
							<li><a href="<?=$under['LINK']?>"><?=$under['NAME']?></a></li>
						<? } ?>
					</ul>
				</div>
			</div>
		</div>
	<? } ?>
</div>

