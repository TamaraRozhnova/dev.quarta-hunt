<?php
if (!function_exists('chmod')) {
	function chmod(...$args)
	{
		return true;
	}
}
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/wsrubi.smtp/classes/general/wsrubismtp.php");