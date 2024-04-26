<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$domain = 'https://'.$_SERVER['SERVER_NAME'];


// категории
$arFilter = array('IBLOCK_ID' => 1, 'ACTIVE_DATE'=>'Y', 'ACTIVE'=>'Y');
$arSelect = array('ID', 'NAME', 'DESCRIPTION', 'CODE', 'SECTION_PAGE_URL', 'IBLOCK_SECTION_ID');
$rsSections = CIBlockSection::GetList(array('SORT' => 'ASC'), $arFilter, '', $arSelect);
$arSections = array();
while ($arSection = $rsSections->GetNext()){
    $arSections[$arSection['ID']] = $arSection;
    if(!empty($arSection['IBLOCK_SECTION_ID'])) $arSectionsParents[$arSection['IBLOCK_SECTION_ID']][] = $arSection['ID']; // родители
}


// товары
$arFilterSection = array('IBLOCK_ID' => 1, 'ACTIVE_DATE'=>'Y', 'ACTIVE'=>'Y');
$arSelect =array('ID','PROPERTY_*');
$arSelect =array();
$arSelect = Array('ID', 'NAME', 'CODE', 'DETAIL_PAGE_URL', 'IBLOCK_SECTION_ID', 'PREVIEW_TEXT', 'DETAIL_PICTURE', 'DETAIL_TEXT');
$rsItems = CIBlockElement::GetList(array('SORT' => 'ASC'), $arFilterSection, '', '', $arSelect);
while ($arItem = $rsItems->GetNext()){
    $arItem['IMG'] = CFile::GetFileArray($arItem["DETAIL_PICTURE"]);
    $arTovs[$arItem['ID']] = $arItem;

    //echo '<pre>';print_r($arItem);echo '</pre>';
}

foreach($arTovs AS $item){ ?>

    <item turbo="true">
        <link><?=$domain.$item['DETAIL_PAGE_URL']?></link>
        <turbo:content>
            <![CDATA[


            <header>
                <h1><?=$item['NAME']?></h1>
                <? if(!empty($item['IMG']['SRC'])) { ?>
                    <figure>
                        <img src="<?=$item['IMG']['SRC']?>">
                    </figure>
                <? } ?>
                <div data-block="breadcrumblist">
                    <a href="<?=$domain?>">Главная</a>
                    <a href="<?=$domain?>/blog/">Блог</a>
                </div>
            </header>

            <?
            $item['~DETAIL_TEXT'] = str_replace('src="/upload/', 'src="'.$domain.'/upload/', $item['~DETAIL_TEXT']);
            ?>
            <?=$item['~PREVIEW_TEXT']?>
            <?=$item['~DETAIL_TEXT']?>

            ]]>
        </turbo:content>
    </item>
    <?
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>