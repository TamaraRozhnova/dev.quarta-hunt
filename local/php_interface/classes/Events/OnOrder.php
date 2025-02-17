<?php

namespace CustomEvents;

use Bitrix\Main\Application;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Sale\Order;
use \Bitrix\Main\Event;
use CUser;

class OnOrder
{
    /**
     * Функция для округления суммы заказа до целых рублей при оплате заказа наличными
     * @param array &$result Массив данных для ответа ajax'ом. 
     */
    public static function OnSaleComponentOrderShowAjaxAnswer(&$result){
        $paySystemId = ($result->getPaySystemIdList())[0];
        $basket = &$result->getBasket();
        if($paySystemId === 1 && $result->getField('PRICE') !== floor($result->getField('PRICE'))){
            $discount = $result->getField('PRICE') - floor($result->getField('PRICE'));

            $basket = &$result->getBasket();
            foreach($basket as &$basketItem){
                $oldPrice = $basketItem->getField('PRICE');
                $basePrice = $basketItem->getField('BASE_PRICE');
                $addDiscount = $oldPrice - ceil($oldPrice);
                $basketItem->setFields([
                    "PRICE" => $oldPrice - $addDiscount,
                    "CUSTOM_PRICE" => "Y",
                    "DISCOUNT_PRICE" => $basketItem->getField('DISCOUNT_PRICE') + $addDiscount,    
                ]);
            }
            $basket->refresh();
        }
    }
    
    
    public static function OnSalePaymentEntitySaved(Event $event){
        $payment = $event->getParameter("ENTITY");
        $orderId = $payment->getField('ORDER_ID');
        
        $paySystemId = $payment->getPaymentSystemId();
        if($paySystemId == 28 && ($payment->getField('PAID') === "Y")){
            self::applyManualDiscountToAllItems($orderId);
           
        }
    }

    /**
     * Функция для установки ручной скидки при оплате в кредит, согласно данным от платежной системы.
     * @param int $orderId - номер заказа. 
     */
    public static function applyManualDiscountToAllItems(int $orderId){
            $order = \Bitrix\Sale\Order::load($orderId);
            $payment = $order->getPaymentCollection()[0];
        
            $paySystemId = $payment->getPaymentSystemId();
        
                    $paySystemSum = $payment->getField('PS_SUM');
                    $paymentSum = $payment->getSum();
        
                    $payment->setPaid("N");
                    $order->save();
                    
                    $basket = $order->getBasket();
                    
                    $totalBasketPrice = 0;
        
                    foreach($basket as $basketItem){
                        $totalBasketPrice += +$basketItem->getField('PRICE') * $basketItem->getField('QUANTITY');
                    }
        
                    $discountPercent = ($paymentSum - $paySystemSum) / $totalBasketPrice * 100;
        
                    foreach($basket as &$basketItem){
                        $newPrice = round($basketItem->getField('PRICE') * (1 - $discountPercent / 100), 2);
                        $basketItem->setFields([
                            "PRICE" => $newPrice,
                            "CUSTOM_PRICE" => "Y",    
                        ]);
                    }
        
                    
                    $payment->setField('SUM', $paySystemSum);
                    $payment->setPaid("Y");
                    $payment->doFinalAction(true);
                    $order->save();
    }
}