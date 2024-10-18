<?php

$cache = \Bitrix\Main\Data\Cache::createInstance();  
$cacheTtl = 36000; 
$cacheKey = 'getpicture'; 
if ($cache->initCache($cacheTtl, $cacheKey)){

    $arResult = $cache->getVars(); 
    $cache->output();

}elseif ($cache->startDataCache()){

    foreach ($arResult['ORDERS'] as $key => &$order){

        foreach($order['BASKET_ITEMS'] as &$item){
            //ElementHutcatalogTable

            $element = \Bitrix\Iblock\Elements\ElementCatalog1cTable::getByPrimary($item['PRODUCT_ID'], [
                'select' => ['PREVIEW_PICTURE'],
            ])->fetch();
            
            $renderImage = CFile::ResizeImageGet($element["PREVIEW_PICTURE"], Array("width" => 75, "height" => 82), BX_RESIZE_IMAGE_EXACT, false);    
            $item['PREVIEW_PICTURE'] = $renderImage["src"];
        }
    }  

    echo date("d.m.Y H:i:s");
    
    $cache->endDataCache($arResult);
}