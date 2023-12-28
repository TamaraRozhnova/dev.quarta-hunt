<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;
use    Bitrix\Sale;
use Bitrix\Sale\Internals\DiscountCouponTable;

CBitrixComponent::includeComponentClass("bitrix:sale.basket.basket");

class CBitrixBasketBasketSmallMailComponent extends CBitrixBasketComponent
{
    const LICENCE_CAT = 583;
    protected int $userId;

    public function onPrepareComponentParams($params)
    {
        $columnList = $params['COLUMNS_LIST'] ?? [];
        if (empty($columnList) || !is_array($columnList)) {
            $columnList = [
                'PREVIEW_PICTURE',
                'NAME',
                'SUM',
            ];
        }
        $params = parent::onPrepareComponentParams($params);
        $this->columns = $columnList;

        $this->userId = (int)($params['USER_ID'] ?? 0);

        $fuserId = (int)($params['FUSER_ID'] ?? 0);
        if ($fuserId > 0) {
            $this->fUserId = $fuserId;
        } else {
            $this->fUserId = Sale\Fuser::getIdByUserId($this->userId);
        }

        $params['COMPATIBLE_MODE'] = 'Y';

        if (!$this->getSiteId()) {
            $siteId = (string)($params['LID'] ?? CSite::GetDefSite());
            $this->setSiteId($siteId);
        }

        return $params;
    }

    protected function sortItemsByTabs(&$result)
    {
        $result['ITEMS'] = array(
            'AnDelCanBuy' => array(),
            'DelDelCanBuy' => array(),
            'nAnCanBuy' => array(),
            'ProdSubscribe' => array()
        );

        $result['IS_LICENCE_PRODUCT'] = false;


        if (!empty($this->basketItems)) {
            foreach ($this->basketItems as $item) {

                $arSections = $this->isLicenseProduct($item);
                if (in_array(self::LICENCE_CAT, $arSections)) {
                    $result['IS_LICENCE_PRODUCT'] = true;
                }

                if ($item['CAN_BUY'] === 'Y' && $item['DELAY'] !== 'Y') {
                    $result['ITEMS']['AnDelCanBuy'][] = $item;
                } elseif ($this->arParams['SHOW_DELAY'] === 'Y' && $item['CAN_BUY'] === 'Y' && $item['DELAY'] === 'Y') {
                    $result['ITEMS']['DelDelCanBuy'][] = $item;
                } elseif ($this->arParams['SHOW_SUBSCRIBE'] === 'Y' && $item['CAN_BUY'] !== 'Y' && $item['SUBSCRIBE'] === 'Y') {
                    $result['ITEMS']['ProdSubscribe'][] = $item;
                } elseif ($this->arParams['SHOW_NOTAVAIL'] === 'Y') {
                    $result['ITEMS']['nAnCanBuy'][] = $item;
                }
            }
        }

        if (!$result['IS_LICENCE_PRODUCT']) {
            $result['PROMOCODE'] = $this->generatePromocode();
        }

        $result['ShowReady'] = !empty($result['ITEMS']['AnDelCanBuy']) ? 'Y' : 'N';
        $result['ShowDelay'] = !empty($result['ITEMS']['DelDelCanBuy']) ? 'Y' : 'N';
        $result['ShowNotAvail'] = !empty($result['ITEMS']['nAnCanBuy']) ? 'Y' : 'N';
        $result['ShowSubscribe'] = !empty($result['ITEMS']['ProdSubscribe']) ? 'Y' : 'N';
    }

    protected function isLicenseProduct($item)
    {
        Loader::includeModule('iblock');

        $dbGroups = CIBlockElement::GetElementGroups($item['PRODUCT_ID']);
        while ($arGroup = $dbGroups->Fetch()) {
            $subSections[] = $arGroup['ID'];
        }

        foreach ($subSections as $subSectionItem) {
            foreach (CIBlockSection::GetNavChain(false, $subSectionItem, ['ID'], true) as $sectionItem) {
                $arSections[] = $sectionItem['ID'];
            }
        }

        return $arSections;
    }

    protected function generatePromocode()
    {
        if (CModule::IncludeModule("catalog")) {

            $coupon = DiscountCouponTable::generateCoupon(true);
            $addDb = DiscountCouponTable::add(array(
                'DISCOUNT_ID' => 42,
                'COUPON' => $coupon,
                'TYPE' => DiscountCouponTable::TYPE_ONE_ORDER,
                'MAX_USE' => 1,
                'USER_ID' => 0,
                'DESCRIPTION' => ''
            ));

            if ($addDb->isSuccess()) {
                return $coupon;
            } else {
                return $addDb->getErrorMessages();
            }
        }
    }
}
