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
    'CustomEvents\Hut\OneCImportHandler' => '/local/php_interface/classes/Events/Hut/OneCImportHandler.php',
]);

include 'events.php';