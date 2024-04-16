<?php 

namespace CustomEvents;

use \Bitrix\Main\Event;
use \Bitrix\Main\Mail\Event as MailEvent;
use \Bitrix\Main\EventResult;

class SaleOrderAjaxEventsO2K
{

    static function eventNewOrder(Event $event)
    {
        $entity = $event->getParameter("ENTITY");  

        if (!$entity->isNew()) {
            return;
        }

        $arValues = $entity->getFields()->getValues();
        $arPropertyCollection = $entity->getPropertyCollection()->getArray();

        $basket = $entity->getBasket();
        $basketItems = $basket->getBasketItems();

        $arProducts = [];

        foreach ($basketItems as $basketItemIndex => $basketItem) {

            $quantity = $basketItem->getQuantity();
            $price = $basketItem->getPrice();

            $name = $basketItem->getField('NAME');

            $basketPropertyCollection = $basketItem->getPropertyCollection();

            foreach ($basketPropertyCollection as $propertyItem) {

                if ($propertyItem->getField('CODE') == 'CML2_ARTICLE') {
                    $arProducts[$basketItemIndex]['CML2_ARTICLE'] = $propertyItem->getField('VALUE');
                }

            }

            $arProducts[$basketItemIndex]['NAME'] = $name;
            $arProducts[$basketItemIndex]['QUANTITY'] = $quantity;
            $arProducts[$basketItemIndex]['PRICE'] = $price;

        }


        $arPropsValues = [];

        foreach ($arPropertyCollection['properties'] as $arProp) {

            if (count($arProp['VALUE']) > 1) {

                foreach ($arProp['VALUE'] as $arPropValue) {
                    $arPropsValues[$arProp['CODE']] .= implode(' ', $arPropValue);
                }

            } else {
                $arPropsValues[$arProp['CODE']] = reset($arProp['VALUE']);
            }

        }

        $htmlOrderList = function($products) {

            $htmlBegin = 
                '
                <table class="qhm-table" style="border-collapse: collapse;">
                    <tbody>
                        <tr style = "background: transparent;padding: 15px; font-weight: 700;text-align: center;border-bottom: 1px solid grey;" class = "qhm-table-header">
                            <td style = "background: transparent;padding: 15px; font-size: 15px">N</td>
                            <td style = "background: transparent;padding: 15px; font-size: 15px">Артикул</td>
                            <td style = "background: transparent;padding: 15px; font-size: 15px">Наименование</td>
                            <td style = "background: transparent;padding: 15px; font-size: 15px">Количество</td>
                            <td style = "background: transparent;padding: 15px; font-size: 15px">Цена</td>
                        </tr>
                        ';

            $htmlContent = '';

            $iterator = 0;

            foreach ($products as $productIndex => $product) { 

                $iterator++;

                $htmlContent .= 
                '
                    <tr style = "background: transparent;padding: 15px;" class = "qhm-table-content">
                        <td style = "background: transparent;padding: 15px; font-size: 14px">
                            ' . $iterator . '
                        </td>
                        <td style = "background: transparent;padding: 15px; font-size: 14px">
                            ' . $product['CML2_ARTICLE'] . '
                        </td>
                        <td style = "background: transparent;padding: 15px; font-size: 14px"">
                            ' . $product['NAME'] . '
                        </td>
                        <td style = "background: transparent;padding: 15px; font-size: 14px"">
                            ' . $product['QUANTITY'] . '
                        </td>
                        <td style = "background: transparent;padding: 15px; font-size: 14px"">
                            ' . $product['PRICE'] . '
                        </td>
                    </tr>
                ';
            } 

            $htmlEnd = 
                '
                    </tbody>
                </table>
                ';

            return implode(' ', 
                [
                    $htmlBegin,
                    $htmlContent,
                    $htmlEnd
                ]
            );
            
        };

            switch ($arValues['PERSON_TYPE_ID']) {
                case 2:
                    $typeEvent = 'SALE_NEW_ORDER_WHOLESALE';
    
                    $arCFields = [
                        "USER_ID" => $arValues['USER_ID'],
                        "ORDER_ID" => $arValues['ID'],
                        "ORDER_DATE" => $arValues['DATE_STATUS']->toString(),
                        "ORDER_FIO" => $arPropsValues['FIO'],
                        "ORDER_PHONE" => $arPropsValues['PHONE'],
                        "ORDER_EMAIL" => $arPropsValues['EMAIL'],
                        "EMAIL" => $arPropsValues['EMAIL'],
                        "ORDER_ZIP" => $arPropsValues['ZIP'],
                        "ORDER_CITY" => $arPropsValues['CITY'],
                        // "ORDER_ADDRESS" => $arPropsValues['ADDRESS'],
                        "ORDER_PRICE" => $arValues['PRICE'],
    
                        "ORDER_LIST" => $htmlOrderList($arProducts),
    
                        "SALE_EMAIL" => 'sale@quarta-hunt.ru',
                        "COMPANY" => $arPropsValues['COMPANY'],

                        "PERSON_TYPE_ID" => $arValues['PERSON_TYPE_ID'],
    
                        "BANK_INN" => $arPropsValues['INN'],
                        "BANK_KPP" => $arPropsValues['KPP'],
                        "BANK_ORGN" => $arPropsValues['OGRN'],
                        "BANK_PAYMENT_ACCOUNT" => $arPropsValues['RAS_SCHET'],
                        "BANK_NAME" => $arPropsValues['BANK'],
                        "BANK_BIK" => $arPropsValues['BIK'],
                        "BANK_CORRESCPONDENT_ACCOUNT" => $arPropsValues['KORR_SCHET'],
                        "BANK_PHONE" => $arPropsValues['PHONE_COMPANY'],
                        "BANK_CEO" => $arPropsValues['GEN_DIRECTOR'],
                    ];
    
                    break;
                case 1:
                    $typeEvent = 'SALE_NEW_ORDER_RETAIL';
    
                    $arCFields = [
                        "USER_ID" => $arValues['USER_ID'],
                        "ORDER_ID" => $arValues['ID'],
                        "ORDER_DATE" => $arValues['DATE_STATUS']->toString(),
                        "ORDER_FIO" => $arPropsValues['FIO'],
                        "ORDER_PHONE" => $arPropsValues['PHONE'],
                        "ORDER_CITY" => $arPropsValues['CITY'],
                        "ORDER_EMAIL" => $arPropsValues['EMAIL'],
                        "EMAIL" => $arPropsValues['EMAIL'],
                        "ORDER_ADDRESS" => $arPropsValues['ADDRESS'],
                        "ORDER_PRICE" => $arValues['PRICE'],
                        "ORDER_LIST" => $htmlOrderList($arProducts),
                        "SALE_EMAIL" => 'sale@quarta-hunt.ru',
                        "PERSON_TYPE_ID" => $arValues['PERSON_TYPE_ID'],
    
                    ];
    
                    break;
                
                default:
                    break;
            }

            MailEvent::sendImmediate(array(
                "EVENT_NAME" => $typeEvent, 
                "LID" => "s1", 
                "C_FIELDS" => $arCFields,
                "DUPLICATE" => "Y"
            ));

    }

    /**
     * Убирает скидку из цены товара
     * если платежная система в рассрочку / кредит
     */
    static function disableDiscountIntoCreditPayment(
        $order, 
        &$arUserResult, 
        $request, 
        &$arParams, 
        &$arResult, 
        &$arDeliveryServiceAll, 
        &$arPaySystemServiceAll
    ) 
    {

        $basket = $order->getBasket();
 
        if ($arUserResult['PAY_SYSTEM_ID'] == UKASSA_CREDIT_ID) {

            $GLOBALS['UNSET_CALCULATE_BONUS_INTO_CREDIT'] = true;

            $arUserResult['ADD_BONUS'] = 0;
            $arResult['ADD_BONUS'] = 0;

            $propertyCollection = $order->getPropertyCollection();
            $bonusesPropValue = $propertyCollection->getItemByOrderPropertyId(3);
            $bonusesPropValue->setValue(0);

            foreach ($basket as $basketItem) {

                $item = $basketItem->getFields();
                $arItem = $item->getValues();

                $basketItem->setField('CUSTOM_PRICE', 'Y');
                $basketItem->setField('PRICE', $arItem["PRICE"] + $arItem['DISCOUNT_PRICE']);
                $basketItem->setField('BASE_PRICE', $arItem["BASE_PRICE"]);
                $basketItem->setField('DISCOUNT_PRICE', 0);


            }
            
        }

    }

    /**
     * Отменяет расчет бонусов если
     * платежная система в рассрочку / кредит
     * 
     * Ограничение на начисление бонусов
     * настраиваются через модуль logictim,
     * но этот метод был реализован для того,
     * чтобы в каждом способе начисления не 
     * настраивать одно и тоже ограничение
     */
    static function disableBallsIntoCreditPayment(Event $event)
    {

        if (empty($GLOBALS['UNSET_CALCULATE_BONUS_INTO_CREDIT'])) {
            return false;
        }

        if ((bool) !$GLOBALS['UNSET_CALCULATE_BONUS_INTO_CREDIT']) {
            return false;
        }

        $arBonus = $event->getParameters();
    
        $arBonus['BONUS'] = 0;

        $result = new EventResult($event->getEventType(), $arBonus);

        return $result;

    }
    
}
