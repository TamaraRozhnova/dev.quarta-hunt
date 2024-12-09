<?php

use \Bitrix\Main\Loader;
use \Bitrix\Main\EventManager;

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
]);

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
	"iblock",
	"OnBeforeIBlockElementUpdate",
	["CustomEvents\OnBeforeIBlockElementUpdate", "OnBeforeIBlockElementUpdateHandler"]
);
