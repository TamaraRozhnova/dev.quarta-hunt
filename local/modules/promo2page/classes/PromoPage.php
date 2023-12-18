<?php 

namespace Promo;

use \Bitrix\Main\Application;
use \Bitrix\Main\Loader;
use \Bitrix\Main\SystemException;
use \Bitrix\Main\Config\Option;

if (!Loader::includeModule('promo2page')) {
    throw new SystemException('Module promo2page is not initialized');
}

/**
 * Класс для работы со сноской акции
 * Реализует паттерн синглтон
 */
class PromoPage
{
    protected static $_instance;
    private $moduleName = 'promo2page';
    private $fields = null;

    private function __construct() {
        $this->setFields();
        $this->handleRequest();
    }

    static function setStyles()
    {
        global $APPLICATION;
        $APPLICATION->SetAdditionalCSS("/bitrix/css/promo2page/admin.css");
    }

    private function setFields()
    {
        $this->fields = [
            'P2P_ACTIVE' => [
                'NAME' => 'Активность',
                'TYPE' => 'checkbox',
                'FILE_PATH' => '/inc/active_field.php'
            ],
            'P2P_LINK' => [
                'NAME' => 'Ссылка',
                'TYPE' => 'text',
                'FILE_PATH' => '/inc/link_field.php'
            ],
            'P2P_TEXT' => [
                'NAME' => 'Текст',
                'TYPE' => 'text',
                'FILE_PATH' => '/inc/text_field.php'
            ],
        ];
    }

    private function getFields()
    {
        return $this->fields;
    }

    static function getInstance() 
    {
        if (self::$_instance === null) {
            self::$_instance = new self;  
        }
 
        return self::$_instance;
    }
 
    private function __clone() {}

    private function __wakeup() {} 

    function getOptionsModule() : ?array
    {
        $optionsData = null;

        if (!empty($this->getFields())) {
            foreach ($this->getFields() as $arFieldKey => $arField) {
                $optionsData[$arFieldKey]['VALUE'] = Option::get(
                    $this->moduleName,
                    $arFieldKey
                );
                $optionsData[$arFieldKey]['NAME'] = $arField['NAME'];
                $optionsData[$arFieldKey]['TYPE'] = $arField['TYPE'];
                $optionsData[$arFieldKey]['FILE_PATH'] = $arField['FILE_PATH'];
            }
        }

        return $optionsData;
    }

    private function handleRequest()
    {
        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();
        $arPost = $request->getPostList()->toArray();

        $fields = $this->getFields();

        if (!empty($arPost)) {
            foreach ($fields as $arFieldKey => $arField) {
                $this->setOptionModule($arFieldKey, $arPost[$arFieldKey]);
            }
        }
    }

    function setOptionModule($field, $value)
    {
        if (empty($field)) {
            return false;
        }

        Option::set(
            $this->moduleName,
            $field,
            $value
        );

    }
}