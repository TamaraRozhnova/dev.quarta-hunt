<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);

if (empty($arResult))
	return;
?>
	 <? CModule::IncludeModule("iblock");
$list_1=array();

$arFilter = [
  'IBLOCK_ID' => COption::GetOptionString( 'spro.wizard', 'ib-catalog',  '', SITE_ID )
];

$arOrder = [
  'LEFT_MARGIN' => 'ASC'
];

$arSelect = [
  'ID',
  'LEFT_MARGIN',
  'DEPTH_LEVEL',
  'NAME'
];

$resSections = \CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);

while( $arSection = $resSections->fetch() )
{
if ($arSection['DEPTH_LEVEL'] ==1){
	$list_1[$arSection['ID']]['NAME'] = $arSection['NAME'];
	$list_1[$arSection['ID']]['ID'] = $arSection['ID'];
$i = $arSection['ID'];
}
}
?>

<?foreach ($list_1 as $main){?>
 <a href="<?=$main['ID'];?>" class="ui-link ui-link--underline"><?=$main['NAME'];?></a>
			  <?}?>

