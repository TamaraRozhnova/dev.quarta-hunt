<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

$arResult = array('error' => false, 'msg' => 'success');


ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();

?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>