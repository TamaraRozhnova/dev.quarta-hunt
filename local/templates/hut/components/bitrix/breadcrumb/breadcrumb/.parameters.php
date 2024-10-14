<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);

$arTemplateParameters = array(
	"WHITE_TEXT" => Array(
		"PARENT" => "STYLES",
		"NAME" => "Белый цвет текста",
		"TYPE" => "CHECKBOX",
		"SORT" => "20",
		"DEFAULT" => "N",
	),
);