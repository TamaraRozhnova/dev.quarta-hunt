<?php

use Bitrix\Main\Event;
use \Bitrix\Sale\Order;

class User
{
    private static array $lastOrderInfo = [];
    private static array $userInfo = [];

    public static function getUserPhone() : string
    {
        if (empty(static::$userInfo)) {
            static::getUser();
        }

        if (
            !empty(static::$userInfo) &&
            static::$userInfo['PERSONAL_PHONE']
        ) {
            return static::$userInfo['PERSONAL_PHONE'];
        }

        if (empty($lastOrderInfo)) {
            static::getInfoFromLastOrder();
        }

        if (static::$lastOrderInfo['PHONE']) {
            return static::$lastOrderInfo['PHONE'];
        }

        return '';
    }

    public static function getUserEmail() : string
    {
        if (empty(static::$userInfo)) {
            static::getUser();
        }

        if (
            !empty(static::$userInfo) &&
            static::$userInfo['EMAIL']
        ) {
            return static::$userInfo['EMAIL'];
        }

        if (empty($lastOrderInfo)) {
            static::getInfoFromLastOrder();
        }

        if (static::$lastOrderInfo['EMAIL']) {
            return static::$lastOrderInfo['EMAIL'];
        }

        return '';
    }

    private static function haveUserField(string $fieldCode) : bool
    {
        if (!$fieldCode) {
            return false;
        }

        if (empty(static::$userInfo)) {
            static::getUser();
        }

        if (static::$userInfo[$fieldCode]) {
            return true;
        }

        return false;
    }

    private static function writeUserField(string $userId, array $fields) : void
    {
        if (
            !$userId ||
            empty($fields)
        ) {
            return;
        }

        $user = new CUser;
        $user->Update($userId, $fields);
    }

    public static function saleOrderSaved(Event $event) : void
    {
        $entity = $event->getParameter("ENTITY");

        if (!$entity->isNew()) {
            return;
        }

        $arPropertyCollection = $entity->getPropertyCollection()->getArray();

        if ($arPropertyCollection) {
            global $USER;
            $updateFields = [];

            foreach ($arPropertyCollection['properties'] as $arProp) {
                if ($arProp['VALUE'] && $arProp['VALUE'][0]) {
                    if (
                        $arProp['CODE'] == 'EMAIL' &&
                        !static::haveUserField('EMAIL')
                    ) {
                        $updateFields['EMAIL'] = $arProp['VALUE'][0];
                    } elseif (
                        $arProp['CODE'] == 'PHONE' &&
                        !static::haveUserField('PERSONAL_PHONE')
                    ) {
                        $updateFields['PERSONAL_PHONE'] = $arProp['VALUE'][0];
                    }
                }
            }

            if (!empty($updateFields)) {
                static::writeUserField($USER->GetID(), $updateFields);
            }
        }
    }

    private static function getUser() : void
    {
        global $USER;

        if (!$USER->IsAuthorized()) {
            return;
        }

        static::$userInfo = CUser::GetByID($USER->GetID())->Fetch();
    }

    private static function getInfoFromLastOrder() : void
    {
        global $USER;

        if (!$USER->IsAuthorized()) {
            return;
        }

        $orderId = Order::getList([
            'select' => ['ID'],
            'filter' => [
                '=USER_ID' => $USER->GetID()
            ],
            'order' => [
                'ID' => 'DESC'
            ],
            'limit' => 1
        ])->fetch();

        $order = Order::load($orderId['ID']);

        if ($order) {
            $propertyCollection = $order->getPropertyCollection();

            foreach ($propertyCollection as $orderProperty) {
                if ($orderProperty->getField('CODE') == 'EMAIL') {
                    static::$lastOrderInfo['EMAIL'] = $orderProperty->getValue();
                } elseif ($orderProperty->getField('CODE') == 'PHONE') {
                    static::$lastOrderInfo['PHONE'] = $orderProperty->getValue();
                }
            }
        }
    }
}