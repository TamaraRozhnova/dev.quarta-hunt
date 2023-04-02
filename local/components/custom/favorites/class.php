<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Helpers\NumWordHelper;
use Personal\Favorites;

class FavoritesComponent extends CBitrixComponent
{
    private const DEFAULT_IBLOCK_TYPE = 'userdata';
    private const DEFAULT_IBLOCK_ID = 21;


    /**
     * Проверка наличия модулей требуемых для работы компонента
     * @return bool
     * @throws Exception
     */
    private function checkModules() {
        if (!Loader::includeModule('iblock') || !Loader::includeModule('sale')) {
            throw new \Exception('Не загружены модули необходимые для работы модуля');
        }

        return true;
    }


    /**
     * Подготовка параметров компонента
     * @param $arParams
     * @return mixed
     */
    public function onPrepareComponentParams($arParams)
    {
        if (!isset($arParams['IBLOCK_TYPE'])) {
            $arParams['IBLOCK_TYPE'] = FavoritesComponent::DEFAULT_IBLOCK_TYPE;
        }
        if (!isset($arParams['IBLOCK_ID'])) {
            $arParams['IBLOCK_ID'] = FavoritesComponent::DEFAULT_IBLOCK_ID;
        }

        return $arParams;
    }


    /**
     * Формирует массив $arResult
     */
    public function makeArResult(): void {
        $favoritesInstance = new Favorites();
        $favoritesCount = $favoritesInstance->getFavoritesIds();

        if (!$favoritesCount) {
            return;
        }

        $this->arResult['COUNT'] = NumWordHelper::getNumWord($favoritesCount, ['товар', 'товара', 'товаров']);
        $this->arResult['ITEMS'] = $favoritesInstance->getFavorites();
    }


    public function executeComponent() {
        $this->checkModules();
        $this->makeArResult();
        $this->includeComponentTemplate();
    }

}