<?php 

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global CUser $USER
 * @global CMain $APPLICATION
 */
    
use \Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\SystemException;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Engine\CurrentUser;
use \Bitrix\Main\Application;

Loc::loadMessages(__FILE__);

if (!Loader::includeModule('promo2page')) {
    throw new SystemException(
        Loc::getMessage('promo2page is not initialized')
    );
}

class PromoPageComponent extends \CBitrixComponent 
{

    function getOptionFromModule($field) {
        return Option::get(
            'promo2page',
            $field
        );
    }

    function executeComponent()
    {
        $currentUser = CurrentUser::get();
        $request = Application::getInstance()->getContext()->getRequest();

        if (
            $request->getCookie("P2P_APPLY") == 'Y'
            ||
            $currentUser->getId()
        ) {
            return false;
        }

        if ($this->getOptionFromModule('P2P_ACTIVE') !== 'on') {
            return false;
        }

        $this->arResult['DIR'] = __DIR__;
        $this->arResult['TEXT'] = $this->getOptionFromModule('P2P_TEXT');
        $this->arResult['LINK'] = $this->getOptionFromModule('P2P_LINK');
        $this->includeComponentTemplate();
    }

}
