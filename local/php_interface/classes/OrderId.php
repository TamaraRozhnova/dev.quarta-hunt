<?php

use Bitrix\Sale;

class OrderId
{
    public static function getInfoOrderUser($orderId){
        if (empty($orderId)) {
            exit();
        }
        return array_merge(OrderId::getSectionProductId($orderId), OrderId::getPaymentAndDeliveryId($orderId));
    }

    public static function getClothesShoesLicenseOnlyPickup($orderId) {
        return OrderId::getSectionProductId($orderId);
    }

    public static function getOrderBasket($orderId, $orderField = '') {
        return OrderId::getProductIdBasket($orderId, $orderField);
    }

    private static function getSectionProductId($orderId) {
        $clothes = false;
        $shoes = false;
        $only_pickup = false;
        $product_license = false;
        if (CModule::IncludeModule("iblock")) {
            $arrayProductID = OrderId::getProductIdBasket($orderId);
            $getElementsSection = CIBlockElement::GetElementGroups($arrayProductID, true);
            while ($res = $getElementsSection->Fetch()) {
                if (
                    $res['IBLOCK_SECTION_ID'] == OrderId::getSectionsId()['IBLOCK_SECTION_ODEZHDA']
                    || $res['ID'] == OrderId::getSectionsId()['IBLOCK_SECTION_ODEZHDA']
                ) {
                    $clothes = true;
                }
                if (
                    $res['IBLOCK_SECTION_ID'] == OrderId::getSectionsId()['IBLOCK_SECTION_OBUV']
                    || $res['ID'] == OrderId::getSectionsId()['IBLOCK_SECTION_OBUV']
                ) {
                    $shoes = true;
                }
                if (in_array($res['IBLOCK_SECTION_ID'], OrderId::getSectionUF())) {
                    $product_license = true;
                }
            }
        }
        if ($clothes || $shoes || $product_license){
            $only_pickup = true;
        }

        return [
            'CLOTHES' => $clothes,
            'SHOES' => $shoes,
            'PRODUCT_LICENSE' => $product_license,
            'ONLY_PICKUP' => $only_pickup,
        ];
    }

    private static function getSectionUF() {
        if (!CModule::IncludeModule('iblock')) {
            return;
        }
        $result = [];
        $arFilter = ['IBLOCK_ID' => 16, 'GLOBAL_ACTIVE' => 'Y'];
        $dbList = CIBlockSection::GetList(['timestamp_x' => 'DESC'], $arFilter, false, ['UF_LISENCE_PRODUCTS']);
        while ($ufValue = $dbList->GetNext()) {
            if (!empty($ufValue['UF_LISENCE_PRODUCTS'])) {
                $result[] = $ufValue['ID'];
            }
        }
        return $result;
    }

    private static function getSectionsId() {
        $sectionsName = ['odezhda', 'obuv'];
        $sectionsID = [];
        if (CModule::IncludeModule("iblock")) {
            $getIdSection = CIBlockSection::GetList(["SORT"=>"ASC"], ['IBLOCK_ID' => 16, 'CODE' => $sectionsName], false, ['ID','CODE']);
            while ($item = $getIdSection->Fetch()) {
                $sectionsID[strtoupper('IBLOCK_SECTION_' . $item['CODE'])] = $item['ID'];
            }
        }
        return $sectionsID;
    }

    private static function getProductIdBasket($orderId, $orderField = '') {
        if (!CModule::IncludeModule('sale')) {
            return;
        }
        $res = [];
        $order = Sale\Order::load($orderId);
        $basket = $order->getBasket();
        foreach ($basket as $basketItem) {
            if (CModule::IncludeModule("catalog")) {
                $mxResult = CCatalogSku::GetProductInfo($basketItem->getProductId());

                if (is_array($mxResult)) {
                    $res[] = $mxResult['ID'];
                }
            }
            
            if (!empty($orderField)) {

                $orderIdCurr = $basketItem->getProductId();
                $orderFieldCurr = $basketItem->getField($orderField);

                $res[$orderIdCurr]['ID'] = $orderIdCurr;
                $res[$orderIdCurr][$orderField] = $orderFieldCurr;

            } else {
                $res[] = $basketItem->getProductId();
            }

        }
        return $res;
    }

    private static function getPaymentAndDeliveryId($orderId) {
        if (!CModule::IncludeModule('sale')) {
            return;
        }
        $res = [];
        $order = Sale\Order::load($orderId);
        $paymentIds = $order->getPaymentSystemId();
        $deliveryIds = $order->getDeliverySystemId();
        $res['payment_and_delivery'] = [
            'PAYMENT'=>$paymentIds,
            'DELIVERY'=>$deliveryIds,
        ];
        return $res;
    }
}