<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

$u = $USER->GetByID($USER->GetID());

$res = $u->arResult[0];

$res['GROUP_ID'] = $USER->GetUserGroup($USER->GetID());

if (in_array("9", $res['GROUP_ID']))
	$res['PRICE_TYPE'] = 'OPT_SMALL';
else
	$res['PRICE_TYPE'] = 'BASE';


$res['sessid'] = $_SESSION['fixed_session_id'];


ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($res);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

