<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

global $USER;

if(!$USER->IsAuthorized()){
	$res = $USER->Login(strip_tags($_POST['email']), strip_tags($_POST['password']));
	if (empty($res['MESSAGE'])) {
		$n['error'] = false;
		$n['message'] = 'Вы успешно авторизовались';
		$n['user'] = ['ID' => $USER->GetID(), 'LOGIN' => $USER->GetLogin(), 'EMAIL' => $USER->GetEmail(), 'FIRST_NAME' => $USER->GetFirstName(), 'LAST_NAME' => $USER->GetLastName()];
	} else {
		$n['error'] = true;
		$n['message'] = strip_tags($res['MESSAGE']);
		$n['post'] = $_POST;
		$n['result'] = $res;
	}
} else {
	$n['error'] = true;
	$n['message'] = 'Вы уже авторизованы';
	$n['user'] = ['ID' => $USER->GetID(), 'LOGIN' => $USER->GetLogin(), 'EMAIL' => $USER->GetEmail(), 'FIRST_NAME' => $USER->GetFirstName(), 'LAST_NAME' => $USER->GetLastName()];
}


if ($n['message'] === 'Ваш логин заблокирован.<br>')
	$n['message'] = 'Ваш логин не активен. Пожалуйста дождитесь активации.<br>';


ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($n);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

