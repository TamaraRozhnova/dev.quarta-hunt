<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters["INPUT_PLACEHOLDER"] = array(
	"NAME" => GetMessage("TP_BSP_INPUT_PLACEHOLDER"),
	"TYPE" => "STRING",
	"DEFAULT" => "",
);

$arTemplateParameters["SHOW_HISTORY"] = array(
	"PARENT" => "VISUAL",
	"NAME" => GetMessage("CP_BSP_SHOW_HISTORY"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N"
);
?>
