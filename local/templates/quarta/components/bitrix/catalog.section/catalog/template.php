<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();

//echo '<pre>';
//print_r($arResult);
//echo '</pre>';

?>