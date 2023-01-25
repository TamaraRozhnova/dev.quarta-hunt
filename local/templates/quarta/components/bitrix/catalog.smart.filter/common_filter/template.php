<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (defined("FILTER_VALUES") && FILTER_VALUES === true) {

	ob_end_clean();

	header('Content-Type: application/json; charset=utf-8');

	echo json_encode($arResult);

	die();

}

?>