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
	'IBLOCK_ID' => CATALOG_IBLOCK_ID,
];

$arOrder = [
	'LEFT_MARGIN' => 'ASC',
];

$arSelect = [
	'ID',
	'LEFT_MARGIN',
	'DEPTH_LEVEL',
	'IBLOCK_SECTION_ID',
	'NAME',
	'PICTURE',
	'UF_SVG',
	'SECTION_PAGE_URL'
];

$resSections = \CIBlockSection::GetList( $arOrder, $arFilter, true, $arSelect );

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
	elseif ($arSection['DEPTH_LEVEL'] == 3)
	{
		$list_1[ $arSection['IBLOCK_SECTION_ID'] ]['UNDER'][ $arSection['ID'] ] = $arSection;

	}
}
?>

<div class="nav-catalog-cont2">
	<div class="left">
		<? foreach($list_1 AS $arItem) {  if($arItem['DEPTH_LEVEL'] != 1) continue;?>
			<div class="nav-catalog-cont2__tab <? if(empty($k)) echo 'active';?>" data-id="<?=$arItem['ID']?>">

				<span class="ico">
					<? if(!empty($arItem['UF_SVG'])) { ?>
						<img src="<?=CFile::GetPath($arItem['UF_SVG'])?>" alt="<?=$arItem['NAME']?>">
					<? } ?>
				</span>
				<?=$arItem['NAME']?>
			</div>
		<? $k++; ?>
		<? } ?>
	</div>

    <? $k = ''; ?>
	<div class="right">
        <div class="right_cont">
            <? foreach($list_1 AS $arItem) { if($arItem['DEPTH_LEVEL'] != 1) continue; ?>
            <div class="nav-catalog-cont2__tab_cont tab_cont_<?=$arItem['ID']?> <? if(empty($k)) echo 'active';?>">

                <div class="nav-catalog-cont2__tab-mob nav-catalog-cont2__tab <? if(empty($k)) echo 'active';?>" data-id="<?=$arItem['ID']?>">

                    <span class="ico">
                        <? if(!empty($arItem['UF_SVG'])) { ?>
                            <img src="<?=CFile::GetPath($arItem['UF_SVG'])?>" alt="<?=$arItem['NAME']?>">
                        <? } ?>
                    </span>
                    <?=$arItem['NAME']?>
                </div>
                <div class="nav-catalog-cont2__mob">
                    <div class="title"><span><?=$arItem['NAME']?></span> <?=$arItem['ELEMENT_CNT']?> товаров</div>
                    <div class="menu_block">
                        <? foreach($arItem['UNDER'] as $v) { ?>
                            <div class="menu_block__item">
                                <a href="<?=$v['SECTION_PAGE_URL']?>"><?=$v['NAME']?></a>
                                <? if(!empty($list_1[ $v['ID'] ]['UNDER'])) { ?>
                                    <ul>
                                        <? foreach($list_1[ $v['ID'] ]['UNDER'] AS $item3) { ?>
                                            <li>
                                                <a href="<?=$item3['SECTION_PAGE_URL']?>"><?=$item3['NAME']?></a>
                                            </li>
                                        <? } ?>
                                    </ul>
                                <? } ?>
                            </div>
                        <? } ?>
                    </div>
                </div>

            </div>
            <? $k++; ?>
            <? } ?>

        </div>
	</div>

</div>
