<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Sale\Fuser;
use Classes\DeliverySettings;
use Classes\LinkCityToStore;
use Local\Util\HighloadblockManager;
use \Bitrix\Catalog\StoreTable;
use \Bitrix\Catalog\ProductTable;
use \Bitrix\Catalog\StoreProductTable;
use \Bitrix\Iblock\Elements\ElementCatalog1cTable;

class CustomBasketComponent extends CBitrixComponent
{
    private array $hlProductsInfo = [];
    private array $result =[];

    private function getUserBasket() : void
    {
        global $USER;

        $userId = 0;
        $fUserId = 0;

        if ($USER->IsAuthorized()) {
            $userId = $USER->GetID();
        } else {
            $fUserId = Fuser::getId();
        }

        $customBasketsHl = new HighloadblockManager('CustomBaskets');

        $customBasketsHl->prepareParamsQuery(
            [
                'ID',
                'UF_QUANTITY',
                'UF_STORE_ID',
                'UF_PRODUCT_ID'
            ],
            [],
            [
                'UF_FUSER' => $fUserId,
                'UF_ORDER_ID' => 0,
                'UF_USER_ID' => $userId
            ]
        );

        $this->hlProductsInfo = $customBasketsHl->getDataAll();
    }

    private function splitIntoGroupsBasketItems() : void
    {
        if (empty($this->hlProductsInfo)) {
            return;
        }

        $selectedUserCity = DeliverySettings::getUserSelectedCity();
        $linkCityList = LinkCityToStore::getIblockLinkElement($selectedUserCity);
        $groupItems = [];

        if (empty($linkCityList)) {
            foreach ($this->hlProductsInfo as $product) {
                if (!is_array($groupItems[$product['UF_PRODUCT_ID']]['UF_STORE_ID'])) {
                    $product['UF_STORE_ID'] = [$product['UF_STORE_ID']];
                }

                if (isset($groupItems[$product['UF_PRODUCT_ID']])) {
                    $groupItems[$product['UF_PRODUCT_ID']]['UF_QUANTITY'] += $product['UF_QUANTITY'];
                    $groupItems[$product['UF_PRODUCT_ID']]['UF_STORE_ID'][] = $product['UF_STORE_ID'];
                } else {
                    $groupItems[$product['UF_PRODUCT_ID']] = $product;
                }
            }

            $this->result['STORE_TEXT'][] = 'Товары для доставки';
            $this->result['ITEMS']['all'] = $groupItems;
            $this->result['COUNT_PRODUCTS'] = count($groupItems);
        } else {
            foreach ($this->hlProductsInfo as $product) {
                $groupItems[$product['UF_STORE_ID']][] = $product;
            }

            $pickupStoreId = [];

            foreach ($linkCityList['STORE_ID'] as $storeId) {
                $pickupStoreId[] = $storeId;
            }

            $result = [];

            foreach ($groupItems as $storeId => $groupItem) {
                if (in_array($storeId, $pickupStoreId)) {
                    $result[$storeId] = $groupItem;
                } else {
                    if (!isset($result['all'])) {
                        $result['all'] = [];
                    }

                    $result['all'] = array_merge($result['all'], $groupItem);
                }
            }

            if (
                is_array($result['all']) &&
                !empty($result['all'])
            ) {
                $resultAll = [];

                foreach ($result['all'] as $product) {
                    if (!is_array($resultAll[$product['UF_PRODUCT_ID']]['UF_STORE_ID'])) {
                        $product['UF_STORE_ID'] = [$product['UF_STORE_ID']];
                    }

                    if (isset($resultAll[$product['UF_PRODUCT_ID']])) {
                        $resultAll[$product['UF_PRODUCT_ID']]['UF_QUANTITY'] += $product['UF_QUANTITY'];
                        $resultAll[$product['UF_PRODUCT_ID']]['UF_STORE_ID'][] = $product['UF_STORE_ID'];
                    } else {
                        $resultAll[$product['UF_PRODUCT_ID']] = $product;
                    }
                }

                $result['all'] = $resultAll;
            }

            $countProducts = 0;
            foreach ($result as $key => $item) {
                if ($key == 'all') {
                    $this->result['STORE_TEXT'][] = 'Товары для доставки';
                } else {
                    $store = StoreTable::getById($key)->fetch();

                    if ($store) {
                        $this->result['STORE_TEXT'][] = 'Самовывоз: ' . $store['TITLE'] . ', ' . $store['ADDRESS'];
                    }
                }

                $countProducts += count($item);
            }

            $this->result['COUNT_PRODUCTS'] = $countProducts;
            $this->result['ITEMS'] = $result;
        }
    }

    private function getProductsInfo() : void
    {
        if (empty($this->result['ITEMS'])) {
            return;
        }

        foreach ($this->result['ITEMS'] as $key => $items) {
            $allStore = false;

            if ($key == 'all') {
                $allStore = true;
            }

            if (is_array($items)) {
                foreach ($items as $num => $item) {
                    $productInfo = [];

                    if ($allStore) {
                        $product = ProductTable::getList([
                            'select' => [
                                'ID',
                                'QUANTITY'
                            ],
                            'filter' => [
                                'ID' => $item['UF_PRODUCT_ID']
                            ]
                        ])->fetch();

                        if ($product) {
                            $productInfo['AMOUNT'] = $product['QUANTITY'];
                        }
                    } else {
                        $store = StoreProductTable::getList([
                            'select' => ['*'],
                            'filter' => [
                                'PRODUCT_ID' => $item['UF_PRODUCT_ID'],
                                'STORE.ACTIVE' => 'Y',
                                'STORE.ID' => $key
                            ]
                        ])->fetch();

                        if ($store) {
                            $productInfo['AMOUNT'] = $store['AMOUNT'];
                        }
                    }

                    $productInfo['QUANTITY'] = $item['UF_QUANTITY'];
                    $productInfo['STORE_ID'] = $item['UF_STORE_ID'];
                    $productInfo['ID'] = $item['UF_PRODUCT_ID'];

                    $productInfo['CAN_BUY'] = true;

                    if ($item['UF_QUANTITY'] > $productInfo['AMOUNT']) {
                        $productInfo['CAN_BUY'] = false;
                    }

                    global $USER;
                    $productInfo['PRICE'] = CCatalogProduct::GetOptimalPrice($item['UF_PRODUCT_ID'], 1, $USER->GetUserGroupArray());

                    $element = ElementCatalog1cTable::getList([
                        'select' => [
                            'NAME',
                            'PREVIEW_PICTURE',
                            'CML2_ARTICLE',
                            'CODE'
                        ],
                        'filter' => [
                            'ACTIVE' => 'Y',
                            'ID' => $item['UF_PRODUCT_ID']
                        ]
                    ])->fetchObject();

                    if ($element) {
                        if ($element->getName()) {
                            $productInfo['NAME'] = $element->getName();
                        }

                        if ($element->getPreviewPicture()) {
                            $productInfo['PICTURE'] = CFile::GetPath($element->getPreviewPicture());
                        }

                        if ($element->getCml2Article() && $element->getCml2Article()->getValue()) {
                            $productInfo['ARTICLE'] = $element->getCml2Article()->getValue();
                        }

                        if ($element->getCode()) {
                            $productInfo['LINK'] = '/catalog/products/' . $element->getCode() . '/';
                        }
                    }

                    if (
                        $productInfo['QUANTITY'] &&
                        is_array($productInfo['PRICE']) &&
                        $productInfo['PRICE']['DISCOUNT_PRICE']
                    ) {
                        $productInfo['SUM'] = (int)$productInfo['QUANTITY'] * (int)$productInfo['PRICE']['DISCOUNT_PRICE'];
                    }

                    $this->result['ITEMS'][$key][$num] = $productInfo;
                }
            }
        }
    }

    private function makeResult() : void
    {
        $this->arResult = $this->result;
    }

    public function executeComponent() : void
    {
        $this->getUserBasket();
        $this->splitIntoGroupsBasketItems();
        $this->getProductsInfo();
        $this->makeResult();

        $this->includeComponentTemplate();
    }
}
