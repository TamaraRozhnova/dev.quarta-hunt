<?php if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true ) die() ?>
<?php

/**
 * @var array $arCurrentValues
 */

$arParameters                 = array ();
$arParameters[ 'CACHE_TIME' ] = array ();
$arParameters[ "INFO_NOTES" ] = array (
	"PARENT"   => "BASE",
	"TYPE"     => "CUSTOM",
	"JS_FILE"  => "/bitrix/js/main/comp_props.js",
	"JS_EVENT" => "BxShowComponentNotes",
	"JS_DATA"  => '<b style="color: red; text-align: center; display: block">Не изменяйте значение параметров, если нет понимания за какой функционал они отвечают. <br>В противном случае изменния могут привести к различным ошибкам в работе сайта.</br>',
);
$arComponentParameters        = array (
	'PARAMETERS' => $arParameters,
);