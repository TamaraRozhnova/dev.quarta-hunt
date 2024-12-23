<?
header("Content-Type: application/x-javascript");
$config = array("appmap" => array("main"=>"/test_shop/eshop_app/", "left"=>"/test_shop/eshop_app/left.php"));
echo json_encode($config);
?>