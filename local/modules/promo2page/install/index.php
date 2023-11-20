<?php

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\SystemException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);

class Promo2page extends CModule
{

    public function __construct()
    {
        $arModuleVersion = [];

        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_ID = 'promo2page';
        $this->MODULE_NAME = Loc::getMessage('MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('MODULE_PARTNER_NAME');
        $this->PARTNER_URI = '#';
    }

    public function InstallFiles()
    {
        CopyDirFiles(
            __DIR__.'/assets/styles',
            Application::getDocumentRoot().'/bitrix/css/'.$this->MODULE_ID.'/',
            true,
            true
        );        
        CopyDirFiles(
            __DIR__.'/components/custom/',
            Application::getDocumentRoot().'/local/components/custom/',
            true,
            true
        );        
    }

    public function UnInstallFiles()
    {
        Directory::deleteDirectory(
            Application::getDocumentRoot().'/bitrix/css/'.$this->MODULE_ID
        );

        Directory::deleteDirectory(
            Application::getDocumentRoot().'/local/components/custom/promo.page'
        );

        Option::delete($this->MODULE_ID);
    }

    public function doInstall()
    {
        if (CheckVersion(ModuleManager::getVersion('main'), '14.00.00')) {
            $this->InstallFiles();
            ModuleManager::registerModule($this->MODULE_ID);
        } else {
            throw new SystemException('1');
        }
    }

    public function doUninstall()
    {
        $this->UnInstallFiles();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }
}
