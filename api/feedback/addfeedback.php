<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

CModule::IncludeModule("iblock");

/*
$feedbacks = CIBlockElement::GetList([], ['IBLOCK_ID' => 11]);

while ($feedback = $feedbacks->GetNextElement()) {
	$f = $feedback->GetFields();
	$p = $feedback->GetProperties();
	$arr['FIELDS'] = $f;
	$arr['PROPERTIES'] = $p;
	$arResult[] = $arr;
}
*/

/*
$_REQUEST['PRODUCT_ID'] = 35741;
$_REQUEST['USER_ID'] = 35;
$_REQUEST['FLAWS'] = 'недостатки';
$_REQUEST['DIGNITIES'] = 'достоинства';
$_REQUEST['COMMENTS'] = 'комментарии';
$_REQUEST['RATING'] = 5;
*/

/*
$_REQUEST['ID'] = 35741;
$_REQUEST['USER_ID'] = 35;
$_REQUEST['LIKES'] = 1;
$_REQUEST['DISLIKES'] = 0;
*/

$user_id = $USER->GetID();

if (!empty($user_id) && $_REQUEST['USER_ID'] == $user_id) {
	$el = new CIBlockElement();

	if (!empty($_REQUEST['PRODUCT_ID']) && !empty($_REQUEST['RATING'])) {
		$date = date('Y_m_d_H_i_s');
		$name = 'feed_' . $_REQUEST['PRODUCT_ID'] . '_' . $_REQUEST['USER_ID'] . '_' . $date;

		$feed = [
			'IBLOCK_ID' => 11,
			'NAME' => $name, 
			'CODE' => $name, 
			'XML_ID' => $name, 
			'ACTIVE' => 'N',
			'PROPERTY_VALUES' => [
				'PRODUCT_ID' => $_REQUEST['PRODUCT_ID'], 
				'USER_ID' => $_REQUEST['USER_ID'], 
				'FLAWS' => $_REQUEST['FLAWS'], 
				'DIGNITIES' => $_REQUEST['DIGNITIES'], 
				'COMMENTS' => $_REQUEST['COMMENTS'], 
				'RATING' => $_REQUEST['RATING'],
			],
		];

		$id = $el->Add($feed);

		if ($id) {
			$image = $_FILES['IMAGES'];
			$images_array = [];
			$file_names = [];
			$arResult['files'] = $image;
			foreach ($image['name'] as $i => $img) {
				if ($img['error'][$i] == 0) {
					$file_name = $_SERVER['DOCUMENT_ROOT'] . '/upload/feedback/' . basename($image['name'][$i]);
					$upl = move_uploaded_file($image['tmp_name'][$i], $file_name);
					if ($upl) {
						$file_array = CFile::MakeFileArray($file_name);
						$images_array[] = ['VALUE' => $file_array, 'DESCRIPTION' => $file_array['name']]; 
						$file_names[] = $file_name;
					}
				}
			}
			if (!empty($images_array)) {
				$arResult['images'] = $images_array;
				$el->SetPropertyValuesEx($id, 11, ['IMAGES' => $images_array]);
				foreach ($file_names as $file_name) {
					unlink($file_name);
				}
			}
		}

		$arResult['error'] = !$id;
		$arResult['id'] = $id;
		$arResult['message'] = $el->LAST_ERROR; //'Ошибка добавления отзыва';
		$arResult['feedback'] = $feed;
	} else if (!empty($_REQUEST['ID'])) {
		$res = $el->GetByID($_REQUEST['ID']);

		if ($feed = $res->GetNextElement()) {
			$data = $feed->GetProperties();

			if (isset($_REQUEST['LIKES']) && $_REQUEST['LIKES'] !== '' && isset($_REQUEST['DISLIKES']) && $_REQUEST['DISLIKES'] !== '') {
				$likes = $_REQUEST['LIKES'];
				$dislikes = $_REQUEST['DISLIKES'];

				if (!empty($data['LIKES']['VALUE']))
					$likes_arr = explode(',', $data['LIKES']['VALUE']);
				else
					$likes_arr = [];

				if (!empty($data['DISLIKES']['VALUE']))
					$dislikes_arr = explode(',', $data['DISLIKES']['VALUE']);
				else
					$dislikes_arr = [];

				$key_l = array_search($user_id, $likes_arr);
				$key_d = array_search($user_id, $dislikes_arr);

				if ($key_l === false && $key_d === false && $likes == 1 && $dislikes == 0) {
					$likes_arr[] = $user_id;
				}
				else
				if ($key_l === false && $key_d === false && $likes == 0 && $dislikes == 1) {
					$dislikes_arr[] = $user_id;
				}
				else
				if ($key_l !== false && $key_d === false && $likes == 0 && $dislikes == 0) {
					unset($likes_arr[$key_l]);
				}
				else
				if ($key_l === false && $key_d !== false && $likes == 0 && $dislikes == 0) {
					unset($dislikes_arr[$key_d]);
				}
				else {
					$arResult['error'] = true;
					$arResult['id'] = $_REQUEST['ID'];
					$arResult['message'] = 'Ошибка обновления лайка или дислайка';
					$arResult['feedback'] = null;
				}

				if ($arResult['error'] !== true) {
					$property_values['LIKES'] = implode(',', $likes_arr);
					$property_values['DISLIKES'] = implode(',', $dislikes_arr);

					$el->SetPropertyValuesEx($_REQUEST['ID'], 11, $property_values);

					$arResult['error'] = false;
					$arResult['id'] = $_REQUEST['ID'];
					$arResult['message'] = '';
					$arResult['feedback'] = null;
				}
			}
			else
			if (isset($_REQUEST['RESPONSES']) && $_REQUEST['RESPONSES'] !== '') {
				$res = $el->GetByID($_REQUEST['ID']);

				if ($feed = $res->GetNextElement()) {
					$data = $feed->GetProperties();

					$date = date('Y_m_d_H_i_s');
					$name = 'feed_answ_' . $_REQUEST['ID'] . '_' . $_REQUEST['USER_ID'] . '_' . $date;
	
					$feedansw = [
						'IBLOCK_ID' => 28,
						'NAME' => $name, 
						'CODE' => $name, 
						'XML_ID' => $name, 
						'ACTIVE' => 'N',
						'PROPERTY_VALUES' => [
							'FEEDBACK_ID' => $_REQUEST['ID'], 
							'USER_ID' => $_REQUEST['USER_ID'], 
							'FEEDBACK_ANSW' => $_REQUEST['RESPONSES'], 
						],
					];
	
					$id = $el->Add($feedansw);

					if ($id) {
						$resp_arr = $data['RESPONSES']['VALUE'];
						$resp_arr[] = strval($id);
						$el->SetPropertyValuesEx($_REQUEST['ID'], 11, ['RESPONSES' => $resp_arr]);
					}
	
					$arResult['error'] = !$id;
					$arResult['id'] = $id;
					$arResult['message'] = $el->LAST_ERROR; //'Ошибка добавления отзыва';
					$arResult['feedback_answ'] = $feedansw;
				} else {
					$arResult['error'] = true;
					$arResult['id'] = 0;
					$arResult['message'] = 'Ответ не может быть добавлен';
					$arResult['feedback'] = null;
				}
			} else {
				$arResult['error'] = true;
				$arResult['id'] = 0;
				$arResult['message'] = 'Неверные параметры';
				$arResult['feedback'] = null;
			}
		} else {
			$arResult['error'] = true;
			$arResult['id'] = 0;
			$arResult['message'] = 'Отзыв не может быть обновлен';
			$arResult['feedback'] = null;
		}
	} else {
		$arResult['error'] = true;
		$arResult['id'] = 0;
		$arResult['message'] = 'Ошибка добавления отзыва';
		$arResult['feedback'] = null;
	}	
} else {
	$arResult['error'] = true;
	$arResult['id'] = 0;
	$arResult['message'] = 'Пользователь не авторизован';
	$arResult['feedback'] = null;	
}


ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();


?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>