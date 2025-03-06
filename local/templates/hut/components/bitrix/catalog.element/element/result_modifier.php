<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;
use Bitrix\Iblock\Elements\ElementHutMainCatalogTable;
use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Query\Join;

Loader::includeModule('highloadblock');

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

foreach ($arResult['SKU_PROPS'] as &$prop) {
    if ($prop['CODE'] == OFFERS_CLOTHES_SIZE_PROP_CODE) {
        $entity =  HighloadBlockTable::compileEntity(CLOTHES_SIZE_HL_ENTITY)->getDataClass();

        $query =  $entity::query()
            ->addSelect('ID')
            ->addSelect('UF_DESCRIPTION')
            ?->fetchAll();

        if (count($query)) {
            foreach ($query as $row) {
                $rusSizes[$row['ID']] = $row['UF_DESCRIPTION'];
            }

            foreach ($prop['VALUES'] as &$value) {
                $value['RUS_SIZE'] = $rusSizes[$value['ID']];
            }
        }
    }
}

// Получаем данные из элемента инфоблока настроек сайта (суммы для бесплатной доставки)
Loader::includeModule('iblock');
$arResult['HUT_SETTINGS'] = \Bitrix\Iblock\Elements\ElementHutsettingsTable::getList([
    'select' => ['ID', 'FREE_POINT_DELIVERY_' => 'FREE_POINT_DELIVERY', 'FREE_COURIER_DELIVERY_' => 'FREE_COURIER_DELIVERY'],
    'filter' => ['=ACTIVE' => 'Y'],
])->fetch();

// Температурный режим
if ($arResult['PROPERTIES']['TEMPERATURE']['VALUE']) {
    $entity =  HighloadBlockTable::compileEntity(TEMPERATURE_HL_ENTITY)->getDataClass();

    $query =  $entity::query()
        ->addSelect('UF_FILE')
        ->where('UF_XML_ID', $arResult['PROPERTIES']['TEMPERATURE']['VALUE'])
        ?->fetch();

    if (!empty($query)) {
        $arResult['TEMP_IMG'] = CFile::GetPath($query['UF_FILE']);
    }
}

// Таблица размеров
if ($arResult['PROPERTIES']['SIZE_TABLE']['VALUE']) {
    $arResult['SIZE_TABLE'] = \Bitrix\Iblock\Elements\ElementHutsizesTable::getByPrimary($arResult['PROPERTIES']['SIZE_TABLE']['VALUE'], [
        'select' => ['ID', 'NAME', 'DETAIL_TEXT'],
    ])->fetch();
}

// Ищем товары с одинаковой первой чать артикула
if ($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']) {
    $searchValue = explode('-', $arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'])[0];
    if ($searchValue) {
        $entity =  HighloadBlockTable::compileEntity(HUT_OFFERS_COLOR_HL_CODE_ONE_C)->getDataClass();

        $similarElements = ElementHutMainCatalogTable::getList([
            'select' => [
                'NAME',
                'ID',
                'FILE' => 'HL_PROPERTY.UF_FILE',
                'COLOR_NAME' => 'HL_PROPERTY.UF_NAME',
                'COLOR_VALUE' => 'TSVET.VALUE',
                'DETAIL_PAGE_URL' => 'IBLOCK.DETAIL_PAGE_URL',
                'IBLOCK_ID',
                'CODE',
                'IBLOCK_SECTION_ID',
            ],
            'order' => ['SORT' => 'ASC'],
            'filter' => ['%CML2_ARTICLE.VALUE' => $searchValue],
            'runtime' => [
                new Entity\ReferenceField(
                    'HL_PROPERTY',
                    $entity,
                    Join::on('this.COLOR_VALUE', 'ref.UF_XML_ID')
                )
            ]
        ]);

        while ($arItem = $similarElements->fetch()) {
            $arItem['DETAIL_PAGE_URL'] = CIBlock::ReplaceDetailUrl($arItem['DETAIL_PAGE_URL'], $arItem, false, 'E');
            if ($arItem['ID'] == $arResult['ID']) {
                $arItem['CURRENT'] = 'Y';
            }
            $arResult['SIMILAR_PRODS'][] = $arItem;
        }
    }
}
