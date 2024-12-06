<?php

use \Bitrix\Main\Loader;
use \Bitrix\Main\EventManager;
use UserType\IblockPropertyType;

if (!function_exists('chmod')) {
	function chmod(...$args)
	{
		return true;
	}
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/wsrubi.smtp/classes/general/wsrubismtp.php");

Loader::registerAutoLoadClasses(null, [
	'CustomEvents\OnBeforeIBlockElementUpdate' => '/local/php_interface/classes/Events/OnBeforeIBlockElementUpdate.php',
	'BitSaleExport' => '/local/php_interface/override_classes/BitSaleExport.php',
	'CustomEvents\Hut\OnBeforeIBlockElementUpdate' => '/local/php_interface/classes/Events/Hut/OnBeforeIBlockElementUpdate.php',
    'UserType\IblockPropertyType' => '/local/php_interface/classes/UserType/IblockPropertyType.php',
    'UserType\IBlockElementEnum' => '/local/php_interface/classes/UserType/IBlockElementEnum.php',
]);

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
	"iblock",
	"OnBeforeIBlockElementUpdate",
	["CustomEvents\OnBeforeIBlockElementUpdate", "OnBeforeIBlockElementUpdateHandler"]
);

$eventManager->addEventHandler('main', 'OnUserTypeBuildList', [IblockPropertyType::class, 'GetUserTypeDescription']);
