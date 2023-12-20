<?php

namespace CustomEvents;

use Bitrix\Main\Application;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Sale\Order;
use CUser;

class OnDiscount
{
    const COUPON_CODE = 'ZAKAZ';

    public static function onManagerCouponAddHandler($event)
    {
        $couponData = $event->getParameters();

        $session = Application::getInstance()->getSession();
        $session->remove('couponNotFirstOrder');
        if ($couponData['COUPON'] == self::COUPON_CODE) {
            $isExistOrders = self::getUserOrderList();

            if ($isExistOrders) {
                DiscountCouponsManager::delete($couponData["COUPON"]);

                if (!$session->has('couponNotFirstOrder')) {
                    $session->set('couponNotFirstOrder', true);
                }
            }
        }
    }

    private static function getUserOrderList()
    {
        Loader::includeModule('sale');

        $userOrderList = Order::getList([
            'select' => ['ID'],
            'filter' => ['USER_ID' => (new CUser())->GetID()]
        ])->fetch();

        if ($userOrderList) {
            return true;
        }

        return false;
    }
}
