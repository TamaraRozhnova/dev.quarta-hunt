<?php

foreach ($arResult['BASKET'] as &$basketItem){
    $resElemGroups = CIBlockElement::GetElementGroups($basketItem['PRODUCT_ID'], false, ['NAME']);
    
    if($arElemGroups = $resElemGroups->Fetch()){
        $basketItem['SECTION_NAME'] = $arElemGroups['NAME'];
    }
}