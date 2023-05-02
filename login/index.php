<? 
define("NEED_AUTH", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $USER; if ($USER->IsAuthorized()){
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: /");
    exit();
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

