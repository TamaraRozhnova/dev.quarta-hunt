<?php 

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global CUser $USER
 * @global CMain $APPLICATION
 */
    
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Application;

Loc::loadMessages(__FILE__);

class AttentionAge extends \CBitrixComponent 
{
    public function executeComponent()
    {
        $request = Application::getInstance()->getContext()->getRequest();

        if ($request->getCookie("AGE_APPLY") == 'Y') {
            return false;
        }

        $this->includeComponentTemplate();
    }

}
