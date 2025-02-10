<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arTemplateParameters = array(
	"DISPLAY_DATE" => array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_NAME" => array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PREVIEW_TEXT" => array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
);

$arTemplateParameters['LINK_VALUE'] = array(
	'PARENT' => 'ADDITIONAL_SETTINGS',
	'NAME' => GetMessage('LINK_VALUE'),
	'TYPE' => 'TEXT',
);

$arTemplateParameters['LINK_TEXT'] = array(
	'PARENT' => 'ADDITIONAL_SETTINGS',
	'NAME' => GetMessage('LINK_TEXT'),
	'TYPE' => 'TEXT',
);
