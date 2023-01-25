<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

CModule::IncludeModule('iblock');

$p = $_REQUEST['product_id'];
$q = $_REQUEST['text'];
$r = [];

if (!empty($p) && !empty($q)) {

	if ($USER && $USER->isAuthorized()) {

		$items = CIBlockElement::GetByID($p);

		if ($item = $items->GetNextElement()) {

			$f = $item->GetFields();
			$p = $item->GetProperties();

			$p_name = $f['NAME'];
			$p_art = $p['CML2_ARTICLE']['VALUE'];

			$arEventFields = [
				'NAME' => $USER->GetFirstName(),
				'LAST_NAME' => $USER->GetLastName(),
				'EMAIL' => $USER->GetEmail(),
				'PRODUCT_ART' => $p_art,
				'PRODUCT_NAME' => $p_name,
				'TEXT' => $q,
			];
	
			$event = new CEvent;
			$event->SendImmediate("PRODUCT_QUESTION", SITE_ID, $arEventFields);
	
			$r['error'] = false;
			$r['message'] = 'Ваш вопрос успешно отправлен';

		} else {

			$r['error'] = true;
			$r['message'] = 'Товар не найден';

		}


	} else {

		$r['error'] = true;
		$r['message'] = 'Пользователь не авторизован';

	}

} else {

	$r['error'] = true;
	$r['message'] = 'Неверное или пустое поле запроса';

}


ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($r);

die();

?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
