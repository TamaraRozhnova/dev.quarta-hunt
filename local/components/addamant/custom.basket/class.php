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
use \Bitrix\Main\Engine\CurrentUser;

/**
 * Класс кастомных корзин
 */
class CustomBasketComponent extends CBitrixComponent
{
    private array $hlProductsInfo = [];
    private array $result = [];

    /**
     * Получает корзину пользователя из HL блока
     *
     * @return void Записывает в переменную hlProductsInfo инфу
     */
    private function getUserBasket() : void
    {
        $fUserId = Fuser::getId();

        $customBasketsHl = new HighloadblockManager(QUARTA_HL_CUSTOM_BASKET_BLOCK_CODE);

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
                'UF_ORDER_ID' => 0
            ]
        );

        $this->hlProductsInfo = $customBasketsHl->getDataAll();
    }

    /**
     * Разбивает товары из корзины на подруппы:
     *  1. Для доставки
     *  2. По id складов
     *
     * @return void Записывается в переменную result
     */
    private function splitIntoGroupsBasketItems() : void
    {
        if (empty($this->hlProductsInfo)) {
            return;
        }

        $selectedUserCity = DeliverySettings::getUserSelectedCity();
        $linkCityList = LinkCityToStore::getIblockLinkElement($selectedUserCity);

        if (empty($linkCityList)) {
            $this->splitEmptyCityList();
        } else {
            $this->splitNotEmptyCityList($linkCityList);
        }
    }

    /**
     * Разбиение если пользователь находится в городе без самовывоза
     *
     * @return void Записывается в переменную result
     */
    private function splitEmptyCityList() : void
    {
        $groupItems = [];

        foreach ($this->hlProductsInfo as $product) {
            $groupItems = $this->getItems($groupItems, $product);
        }

        $this->result['STORE_TEXT'][] = 'Товары для доставки';
        $this->result['ITEMS']['all'] = $groupItems;
        $this->result['COUNT_PRODUCTS'] = count($groupItems);
    }

    /**
     * Разбиение если пользователь находится в городе с самовывозом
     *
     * @param array $linkCityList
     * @return void Записывается в переменную result
     */
    private function splitNotEmptyCityList(array $linkCityList = []) : void
    {
        if (empty($linkCityList)) {
            return;
        }

        $groupItems = [];

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
                $resultAll = $this->getItems($resultAll, $product);
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

    /**
     * Получение полной информации о товарах
     *
     * @return void Записываются данные в переменную result
     */
    private function getProductsInfo() : void
    {
        if (empty($this->result['ITEMS'])) {
            return;
        }

        foreach ($this->result['ITEMS'] as $key => $items) {
            $allStore = false;
            $pickUpStore = false;

            /*
             * В данной проверке происходит следующее:
             *  $key == all, это значит, что все товары, которые находятся под этим ключем - товары на доставку
             *  $key == n (ID склада), это значит, что в данном случае все товары идут из 1 склада на самовывоз
             *
             * Это нужно, тк дальше по коду мы берем информацию о доступности товара, если у нас:
             *  $key == all, нам нужно брать общий остаток товара, вне зависимости от склада
             *  $key == n (ID склада), нам нужно брать остаток товара только с определенного склада
             */

            if ($key == 'all') {
                $allStore = true;
            } else {
                $selectedUserCity = DeliverySettings::getUserSelectedCity();
                $linkCityList = LinkCityToStore::getIblockLinkElement($selectedUserCity);

                if (!empty($linkCityList) && !empty($linkCityList['STORE_ID'])) {
                    foreach ($linkCityList['STORE_ID'] as $storeId) {
                        if ($storeId == $key) {
                            $pickUpStore = true;
                            break;
                        }
                    }
                }
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
                            'select' => ['AMOUNT'],
                            'filter' => [
                                'PRODUCT_ID' => $item['UF_PRODUCT_ID'],
                                'STORE.ACTIVE' => 'Y',
                                'STORE.ID' => $key
                            ]
                        ])->fetch();

                        if ($store) {
                            /*
                             * Проверка на самовывоз, масимальное количество товара на складе ограничиваем на 1
                             * Нужно, тк последний товар в мазагине = товар на витрине и он не продается
                             */
                            if ($pickUpStore) {
                                $productInfo['AMOUNT'] = $store['AMOUNT'] - 1;
                            } else {
                                $productInfo['AMOUNT'] = $store['AMOUNT'];
                            }
                        }
                    }

                    $productInfo['QUANTITY'] = $item['UF_QUANTITY'];
                    $productInfo['STORE_ID'] = $item['UF_STORE_ID'];
                    $productInfo['ID'] = $item['UF_PRODUCT_ID'];

                    $productInfo['CAN_BUY'] = true;

                    if ($item['UF_QUANTITY'] > $productInfo['AMOUNT']) {
                        $productInfo['CAN_BUY'] = false;
                    }

                    $productInfo['PRICE'] = CCatalogProduct::GetOptimalPrice($item['UF_PRODUCT_ID'], 1, CurrentUser::get()->getUserGroups());

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
                    ])?->fetchObject();

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

    /**
     * Функция помощник по переборке массива с товарами
     *
     * @param array $groupItems
     * @param mixed $product
     * @return array
     */
    private function getItems(array $groupItems, mixed $product) : array
    {
        if (!is_array($groupItems[$product['UF_PRODUCT_ID']]['UF_STORE_ID'])) {
            $product['UF_STORE_ID'] = [$product['UF_STORE_ID']];
        }

        if (isset($groupItems[$product['UF_PRODUCT_ID']])) {
            $groupItems[$product['UF_PRODUCT_ID']]['UF_QUANTITY'] += $product['UF_QUANTITY'];
            $groupItems[$product['UF_PRODUCT_ID']]['UF_STORE_ID'][] = $product['UF_STORE_ID'];
        } else {
            $groupItems[$product['UF_PRODUCT_ID']] = $product;
        }
        return $groupItems;
    }

    /*
     * Записываем получившийся результат в переменную $arResult компонента
     *
     * @return void
     */
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
