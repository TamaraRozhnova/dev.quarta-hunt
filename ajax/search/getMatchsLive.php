<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Web\Json;
use Bitrix\Main\Loader;
use SearchSphinx\ProductTable;
use SearchSphinx\BlogTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\SystemException;
use Helpers\Translit;

if (!Loader::includeModule('iblock')) {
    throw new SystemException('Iblock is not initialized');
}

$request = mb_strtolower(htmlspecialchars($_GET['q']));

if (empty($request)) {
    echo Json::encode([
        'STATUS' => 'ERROR'
    ]);
}

$rsParamsQuery = [
    'select' => [
        '*',
    ],
    'match' => $request,
    'count_total' => false,
    'option' => [
        'max_matches' => 5,
    ],
];

$rsProduct = ProductTable::getList(
    $rsParamsQuery
)->fetchAll();

$rsBlog = BlogTable::getList(
    $rsParamsQuery
)->fetchAll();

$translitQueryRu = Translit::getTranslitRU($request);
$simpleWord = Translit::getChangeSimpleWordRU($request);
$advancedWord = Translit::getChangeAdvancedWordRU($request);
$extendedWord = Translit::getChangeExtendedWordRU($request);

if (empty($rsProduct)) {

    $rsParamsQuery['match'] = $translitQueryRu;

    $rsProduct = ProductTable::getList(
        $rsParamsQuery
    );

    $rsParamsQuery['match'] =  $simpleWord;
    
    $rsProductSimple = ProductTable::getList(
        $rsParamsQuery
    );

    $rsParamsQuery['match'] =  $advancedWord;

    $rsProductAdvanced = ProductTable::getList(
        $rsParamsQuery
    );

    $rsParamsQuery['match'] =  $extendedWord;

    $rsProductExtended = ProductTable::getList(
        $rsParamsQuery
    );

    $arProcessProducts = [
        $rsProduct,
        $rsProductSimple,
        $rsProductAdvanced,
        $rsProductExtended
    ];

    $rsProduct = array_merge(
        $rsProduct->fetchAll(), 
        $rsProductSimple->fetchAll(), 
        $rsProductAdvanced->fetchAll(),
        $rsProductExtended->fetchAll()
    );

}

if (empty($rsBlog)) {
    $rsParamsQuery['match'] = $translitQueryRu;

    $rsBlog = BlogTable::getList(
        $rsParamsQuery
    )->fetchAll();

}

if (
    !empty($rsProduct)
    ||
    !empty($rsBlog)
) {

    if (!empty($rsProduct)) {
        foreach ($rsProduct as $arProduct) {
            $sectionIds[ (int) $arProduct['iblock_section_id']] = (int) $arProduct['iblock_section_id'];
        }
    }

    if (!empty($rsBlog)) {
        foreach ($rsBlog as $arBlog) {
            $sectionIds[ (int) $arBlog['iblock_section_id']] = (int) $arBlog['iblock_section_id'];
        }
    }

    $rsSections = SectionTable::getList([
        'select' => ['*'],
        'filter' => [
            '=ID' => $sectionIds
        ]
    ])->fetchAll();

    foreach ($rsSections as $arSection) {

        $iblockParams = IblockTable::getList([
            'select' => [
                '*'
            ],
            'filter' => [
                '=ID' => $arSection['IBLOCK_ID']
            ]
        ])->fetch();

        if (!empty($rsProduct)) {

            foreach ($rsProduct as $arProductIndex => $arProduct) {

                if ($arProduct['iblock_section_id'] == $arSection['ID']) {
                    $arProducts[$arProductIndex] = $arProduct;
    
                    $arProducts[$arProductIndex]['detail_page'] = CIBlock::ReplaceDetailUrl(
                        $iblockParams['DETAIL_PAGE_URL'],
                        [
                            'ID' => $arProduct['id'],
                            'ELEMENT_ID' => $arProduct['id'],
                            'CODE' => $arProduct['code'],
                            'ELEMENT_CODE' => $arProduct['code'],
                        ],
                        false,
                        'E'
                    );
    
                    $arProducts[$arProductIndex]['section_name'] = $arSection['NAME'];
    
                    $sectionPathResult = GetIBlockSectionPath($arSection['IBLOCK_ID'], $arSection['ID']);
    
                    while ($res = $sectionPathResult->GetNextElement()) {
                        $arProducts[$arProductIndex]['section_detail_page'] = $res->getFields()['SECTION_PAGE_URL'];
                    }
                    
                }
            }

        }


        if (!empty($rsBlog)) {

            foreach ($rsBlog as $arBlogIndex => $arBlog) {

                if ($arBlog['iblock_section_id'] == $arSection['ID']) {
                    $arBlogs[$arBlogIndex] = $arBlog;
    
                    $arBlogs[$arBlogIndex]['detail_page'] = CIBlock::ReplaceDetailUrl(
                        $iblockParams['DETAIL_PAGE_URL'],
                        [
                            'SECTION_CODE' => $arSection['CODE'],
                            'ELEMENT_CODE' => $arBlog['code'],
                        ],
                        false,
                        ''
                    );
    
                    $arBlogs[$arBlogIndex]['section_name'] = $arSection['NAME'];
    
                    $sectionPathResult = GetIBlockSectionPath($arSection['IBLOCK_ID'], $arSection['ID']);
    
                    while ($res = $sectionPathResult->GetNextElement()) {
                        $arBlogs[$arBlogIndex]['section_detail_page'] = $res->getFields()['SECTION_PAGE_URL'];
                    }
                    
                }
            }

        }


    }

}

echo Json::encode([
    'STATUS' => 'SUCCESS',
    'PRODUCTS' => $arProducts ?? [],
    'ARTICLES' => $arBlogs ?? [],
]);
