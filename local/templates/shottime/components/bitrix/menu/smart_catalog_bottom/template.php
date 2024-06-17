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
  'IBLOCK_ID' => CATALOG_IBLOCK_ID
];

$arOrder = [
  'LEFT_MARGIN' => 'ASC'
];

$arSelect = [
    'ID',
    'LEFT_MARGIN',
    'DEPTH_LEVEL',
    'NAME',
    'SECTION_PAGE_URL'
];

$resSections = \CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);

while( $arSection = $resSections->GetNext() )
{
    if ($arSection['DEPTH_LEVEL'] ==1){
        $list_1[$arSection['ID']]['NAME'] = $arSection['NAME'];
        $list_1[$arSection['ID']]['ID'] = $arSection['ID'];
        $list_1[$arSection['ID']]['SECTION_PAGE_URL'] = $arSection['SECTION_PAGE_URL'];
        $i = $arSection['ID'];
    }
}
?>

<?foreach ($list_1 as $main){?>
 <a href="<?=$main['SECTION_PAGE_URL'];?>" class="ui-link ui-link--underline"><?=$main['NAME'];?></a>
<?}?>

