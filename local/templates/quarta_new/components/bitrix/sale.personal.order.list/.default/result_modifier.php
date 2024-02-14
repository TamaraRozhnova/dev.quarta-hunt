<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Sale\Order;

global $USER;


if (!empty($arResult['ORDERS'])) {

    $entSections = \Bitrix\Iblock\Model\Section::compileEntityByIblock(CATALOG_IBLOCK_ID);

    foreach ($arResult['ORDERS'] as $arOrderIndex => $arOrder) {

        if (empty($arOrder['ORDER']['ID'])) {
            continue;
        }

        $order = Order::loadByAccountNumber($arOrder['ORDER']['ID']);
        $propertyCollection = $order->getPropertyCollection();

        foreach ($propertyCollection as $arPropertyValue) {

            $arPropertyValues = $arPropertyValue?->getFields()?->getValues();

            if (empty($arPropertyValues)) {
                continue;
            }

            if ($arPropertyValues['CODE'] == 'LOGICTIM_ADD_BONUS') {
                $arResult['ORDERS'][$arOrderIndex]['ADD_BONUSES'] = $arPropertyValues['VALUE'];
            }

        }

        /**
         * Закрываем кнопку оплаты
         * для Юкассы, если сумма оплаты
         * более 700 000
         */

        if (
            $arOrder['ORDER']['PRICE'] > 700000
            && $arOrder['ORDER']['PAY_SYSTEM_ID'] == UKASSA_ID
        ) {
            $arResult['ORDERS'][$arOrderIndex]['HIDE_BUTTON_PAYMENT'] = 'Y';
            continue;
        }

        if ($arOrder['ORDER']['PERSON_TYPE_ID'] == 2) {
            $arResult['ORDERS'][$arOrderIndex]['HIDE_BUTTON_PAYMENT'] = 'Y';
            continue;
        }

        if (!empty($arOrder['BASKET_ITEMS'])) {
            foreach ($arOrder['BASKET_ITEMS'] as $arBasketItem) {
                
                $rsSectionsEl = CIBlockElement::GetElementGroups($arBasketItem['PRODUCT_ID'], true)->fetch();

                if (empty($rsSectionsEl)) {

                    /**
                     * Проверка на торговое предложение
                     */
        
                    $productInfo = CCatalogSku::GetProductInfo(
                        $arBasketItem['PRODUCT_ID']
                    );
        
                    $rsSectionsEl = CIBlockElement::GetElementGroups($productInfo['ID'], true)->fetch();
                }

                $rsPath = CIBlockSection::GetNavChain(false, $rsSectionsEl['ID']); 

                while ($arPath = $rsPath->GetNext()) {                     
                    $sectionIds[$arOrderIndex][$arPath['ID']] = $arPath['ID']; 
                }
            }

            $rsSections = $entSections::getList(array(
                "filter" => array(
                    "IBLOCK_ID" => CATALOG_IBLOCK_ID, 
                    "ACTIVE" => "Y",
                    "GLOBAL_ACTIVE" => "Y",
                    "ID" => $sectionIds[$arOrderIndex]
                ),
                "select" => array("NAME", "CODE"),
            ))->fetchAll();            
    
            if (!empty($rsSections)) {
                foreach ($rsSections as $arSection) {    
                    if (
                        $arSection['CODE'] == 'odezhda'
                        ||
                        $arSection['CODE'] == 'obuv'
                        ||
                        $arSection['CODE'] == 'oruzhie_i_patrony'
                    ) {
                        $arResult['ORDERS'][$arOrderIndex]['HIDE_BUTTON_PAYMENT'] = 'Y';

                        //break;
                    }

                    if ($arSection['CODE'] == 'pnevmaticheskoe_oruzhie') {
                        $arResult['ORDERS'][$arOrderIndex]['HIDE_BUTTON_PAYMENT'] = 'N';
                    }
    
                    //continue;
    
                }
            }

        }
    }
}



