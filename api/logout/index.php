<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


global $USER;

if ($USER->IsAuthorized()) {
	$n['error'] = false;
	$n['message'] = 'Выход';
	$n['user'] = ['ID' => $USER->GetID(), 'LOGIN' => $USER->GetLogin(), 'EMAIL' => $USER->GetEmail(), 'FIRST_NAME' => $USER->GetFirstName(), 'LAST_NAME' => $USER->GetLastName()];
	$res = $USER->Logout();
	$n['r'] = $res;
} else {
	$n['error'] = true;
	$n['message'] = 'Вы не были авторизованы';
	$n['user'] = ['ID' => '', 'LOGIN' => '', 'EMAIL' => '', 'FIRST_NAME' => '', 'LAST_NAME' => ''];
}


ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($n);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>