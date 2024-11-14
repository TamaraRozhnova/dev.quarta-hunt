<?php

foreach ($arResult['ORDERS'] as $key => &$order) {

    foreach ($order['BASKET_ITEMS'] as &$item) {
        //ElementHutcatalogTable

        $element = \Bitrix\Iblock\Elements\ElementHutCatalogTable::getByPrimary($item['PRODUCT_ID'], [
            'select' => ['PREVIEW_PICTURE'],
        ])->fetch();

        $renderImage = CFile::ResizeImageGet($element["PREVIEW_PICTURE"], array("width" => 75, "height" => 82), BX_RESIZE_IMAGE_EXACT, false);
        $item['PREVIEW_PICTURE'] = $renderImage["src"];
    }
}