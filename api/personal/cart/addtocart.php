<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

global $USER;

CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");

if (!empty($_REQUEST['PRODUCT_ID']) && isset($_REQUEST['QUANTITY'])) {

	$sections = CIBlockSection::GetList([], ['IBLOCK_ID' => 16], false, ['UF_*']);
	$sections_ind = 0;
	$sids = [];
	$sids_db = [];

	while ($s = $sections->GetNext()) {
		$arSections[$sections_ind]['IBLOCK_ID'] = $s['IBLOCK_ID'];
		$arSections[$sections_ind]['IBLOCK_SECTION_ID'] = $s['IBLOCK_SECTION_ID'];
		$arSections[$sections_ind]['XML_ID'] = $s['XML_ID'];
		$arSections[$sections_ind]['ID'] = $s['ID'];
		$arSections[$sections_ind]['NAME'] = $s['NAME'];
		$arSections[$sections_ind]['CODE'] = $s['CODE'];
		$arSections[$sections_ind]['SECTION_PAGE_URL'] = $s['SECTION_PAGE_URL'];
		$arSections[$sections_ind]['UF_BONUS_SYSTEM_ACTIVE'] = $s['UF_BONUS_SYSTEM_ACTIVE'];
		$arSections[$sections_ind]['UF_DOUBLE_BONUS'] = $s['UF_DOUBLE_BONUS'];
		$arSections[$sections_ind]['UF_LISENCE_PRODUCTS'] = $s['UF_LISENCE_PRODUCTS'];
		$sections_ind++;
	}

	foreach ($arSections as $s) {
		if ($s['UF_BONUS_SYSTEM_ACTIVE'] === '1') $sids[] = $s['ID'];
		if ($s['UF_BONUS_SYSTEM_ACTIVE'] === '1' && $s['UF_DOUBLE_BONUS'] === '1') $sids_db[] = $s['ID'];
	}

	foreach ($arSections as $s) {
		if (in_array($s['IBLOCK_SECTION_ID'], $sids)) $sids[] = $s['ID'];
		if (in_array($s['IBLOCK_SECTION_ID'], $sids_db)) $sids_db[] = $s['ID'];
	}

	$base_pr_res = CIBlockElement::GetList([], ['ID' => $_REQUEST['PRODUCT_ID']], false, false, 
		['ID', 'NAME', 'CODE', 'XML_ID', 'PRICE_1', 'PRICE_2', 'PRICE_3', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL', 
			'PROPERTY_CML2_ARTICLE', 'PROPERTY_CML2_TAXES', 'PROPERTY_CML2_TRAITS', 'PROPERTY_CML2_MANUFACTURER', 'PROPERTY_CML2_BASE_UNIT']);

	if ($base_pr = $base_pr_res->GetNext()) {

		$cat_pr = CCatalogProduct::GetByID($base_pr['ID']);
		$base_pr['WEIGHT'] = $cat_pr['WEIGHT'];

		$bonus_system_active = in_array($base_pr['IBLOCK_SECTION_ID'], $sids);
		$db = in_array($base_pr['IBLOCK_SECTION_ID'], $sids_db) ? 2 : 1;

		if (isset($_REQUEST['KIT_ID'])) {

			if ($_REQUEST['KIT_ID'] !== '')
				$kit = explode(',', $_REQUEST['KIT_ID']);
			else
				$kit = [];

			if (!empty($kit)) {
				$kit_pr_res = CIBlockElement::GetList([], ['ID' => $kit], false, false, 
					['ID', 'NAME', 'CODE', 'XML_ID', 'PRICE_1', 'PRICE_2', 'PRICE_3', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL',
						'PROPERTY_CML2_ARTICLE', 'PROPERTY_CML2_TAXES', 'PROPERTY_CML2_TRAITS', 'PROPERTY_CML2_MANUFACTURER', 'PROPERTY_CML2_BASE_UNIT']);

				$kids = [];

				while ($kit_pr = $kit_pr_res->GetNext()) {
					$kit_catalog_pr = CCatalogProduct::GetByID($kit_pr['ID']);
					$kit_pr['WEIGHT'] = $kit_catalog_pr['WEIGHT'];
					if (!in_array($kit_pr['ID'], $kids)) {
						$kit_pr_arr[] = $kit_pr;
						$kids[] = $kit_pr['ID'];
					}
				}

				if (count($kit_pr_arr) > 0) {
					$kit_sum_price = $base_pr['PRICE_1'];

					foreach ($kit_pr_arr as $k_pr) {
						$kit_sum_price += $k_pr['PRICE_1'];
						$kit_sum_price_2 += $k_pr['PRICE_1'];
					}

					if ($base_pr['PRICE_1'] > 0 && $kit_sum_price_2 > 0)
						$persent = 100 * ((floatval($base_pr['PRICE_1']) + $kit_sum_price_2) / floatval($base_pr['PRICE_1']) - 1);
					else
						$persent = 0;

					$discount = 0;

					if ($present >= 1 && $persent <= 5)
						$discount = 2;
					else if ($persent > 5 && $persent <= 10)
						$discount = 3;
					else if ($persent > 10 && $persent <= 20)
						$discount = 4;
					else if ($persent > 20 && $persent <= 30)
						$discount = 5;
					else if ($persent > 30 && $persent <= 40)
						$discount = 6;
					else if ($persent > 40 && $persent <= 50)
						$discount = 7;
					else if ($persent > 50 && $persent <= 60)
						$discount = 8;
					else if ($persent > 60 && $persent <= 70)
						$discount = 9;
					else if ($persent > 70 && $persent <= 100)
						$discount = 10;
					else if ($persent > 100)
						$discount = 12;
					else
						$discount = 0;

					$base_pr['PRICE_1_DISCOUNT'] = $discount > 0 ? strval($discount * $base_pr['PRICE_1'] / 100) : '0';
					$base_pr['~PRICE_1_DISCOUNT'] = $base_pr['PRICE_1_DISCOUNT'];
					$base_pr['PRICE_1_TOTAL'] = strval($base_pr['PRICE_1'] - $base_pr['PRICE_1_DISCOUNT']);
					$base_pr['~PRICE_1_TOTAL'] = $base_pr['PRICE_1_TOTAL'];

					foreach ($kit_pr_arr as $n => $k_pr) {
						$kit_pr_arr[$n]['PRICE_1_DISCOUNT'] = $discount > 0 ? strval($discount * $k_pr['PRICE_1'] / 100) : '0';
						$kit_pr_arr[$n]['~PRICE_1_DISCOUNT'] = $kit_pr_arr[$n]['PRICE_1_DISCOUNT'];
						$kit_pr_arr[$n]['PRICE_1_TOTAL'] = strval($k_pr['PRICE_1'] - $kit_pr_arr[$n]['PRICE_1_DISCOUNT']);
						$kit_pr_arr[$n]['~PRICE_1_TOTAL'] = $kit_pr_arr[$n]['PRICE_1_TOTAL'];
					}

					$arResult['error'] = false;
					$arResult['message'] = 'Общая стоимость комплекта';
					$arResult['id'] = 0;
					$arResult['base_product'] = $base_pr;
					$arResult['kit_products'] = $kit_pr_arr;
					$arResult['sumprice'] = $kit_sum_price;
					$arResult['persent'] = $persent;
					$arResult['discount'] = $discount;
					$arResult['sumprice_discount'] = $discount > 0 ? $discount * $kit_sum_price / 100 : $kit_sum_price;
					$arResult['sumprice_total'] = $kit_sum_price - $arResult['sumprice_discount'];

					if (!empty($_REQUEST['ADDKIT']) && $_REQUEST['ADDKIT'] === 'Y') {

						$arResult = [];

						$arNotesBase = [
							'ID' => $base_pr['ID'],
							'PRICE_1_DISCOUNT' => $base_pr['PRICE_1_DISCOUNT'],
							'PRICE_1_TOTAL' => $base_pr['PRICE_1_TOTAL'],
							'DISCOUNT_PERSENT' => $discount,							
							'UF_BONUS_SYSTEM_ACTIVE' => $bonus_system_active,
						];

						$arFieldsBase = [
							'PRODUCT_ID' => $base_pr['ID'],
							'PRODUCT_PRICE_ID' => 0,
							'PRICE' => $base_pr['PRICE_1_TOTAL'],
							'QUANTITY' => 1,
							'LID' => 's1',
							'CUSTOM_PRICE' => 'Y',
							'CAN_BUY' => 'Y',
							'CURRENCY' => 'RUB',
							'NAME' => $base_pr['NAME'],
							'NOTES' => serialize($arNotesBase),
							'WEIGHT' => $base_pr['WEIGHT'],
							'DETAIL_PAGE_URL' => $base_pr['DETAIL_PAGE_URL'],
							'DELAY' => 'N',
							'MODULE' => 'catalog',
							'PROPS' => [
								['NAME' => 'Артикул', 'CODE' => 'CML2_ARTICLE', 'VALUE' => $base_pr['PROPERTY_CML2_ARTICLE_VALUE'], 'SORT' => '1'],
								['NAME' => 'Ставки налогов', 'CODE' => 'CML2_TAXES', 'VALUE' => $base_pr['PROPERTY_CML2_TAXES_VALUE'], 'SORT' => '2'],
								['NAME' => 'Реквизиты', 'CODE' => 'CML2_TRAITS', 'VALUE' => $base_pr['PROPERTY_CML2_TRAITS_VALUE'], 'SORT' => '3'],
								['NAME' => 'Производитель', 'CODE' => 'CML2_MANUFACTURER', 'VALUE' => $base_pr['PROPERTY_CML2_MANUFACTURER_VALUE'], 'SORT' => '4'],
								['NAME' => 'Базовая единица', 'CODE' => 'CML2_BASE_UNIT', 'VALUE' => $base_pr['PROPERTY_CML2_BASE_UNIT_VALUE'], 'SORT' => '5'],
								['NAME' => 'Раздел', 'CODE' => 'IBLOCK_SECTION_ID', 'VALUE' => $base_pr['IBLOCK_SECTION_ID'], 'SORT' => '6'],
							],
						];

						$base_id = CSaleBasket::Add($arFieldsBase);

						$arResult['error'] = false;
						$arResult['message'] = 'Комплект добавлен в корзину';
						$arResult['id'] = $base_pr['ID'];
						$arResult['element_id'] = strval($base_id);
						$arResult['name'] = $base_pr['NAME'];

						foreach ($kit_pr_arr as $k_pr) {
							$arNotesKit = [
								'ID' => $base_pr['ID'],
								'PRICE_1_DISCOUNT' => $k_pr['PRICE_1_DISCOUNT'],
								'PRICE_1_TOTAL' => $k_pr['PRICE_1_TOTAL'],
								'DISCOUNT_PERSENT' => $discount,								
								'UF_BONUS_SYSTEM_ACTIVE' => $bonus_system_active,
							];

							$arFieldsKit = [
								'PRODUCT_ID' => $k_pr['ID'],
								'PRICE' => $k_pr['PRICE_1_TOTAL'],
								'QUANTITY' => 1,
								'LID' => 's1',
								'CUSTOM_PRICE' => 'Y',
								'CAN_BUY' => 'Y',
								'CURRENCY' => 'RUB',
								'NAME' => $k_pr['NAME'],
								'NOTES' => serialize($arNotesKit),
								'WEIGHT' => $k_pr['WEIGHT'],
								'DETAIL_PAGE_URL' => $k_pr['DETAIL_PAGE_URL'],
								'DELAY' => 'N',
								'MODULE' => 'catalog',
								'PROPS' => [
									['NAME' => 'Артикул', 'CODE' => 'CML2_ARTICLE', 'VALUE' => $k_pr['PROPERTY_CML2_ARTICLE_VALUE'], 'SORT' => '1'],
									['NAME' => 'Ставки налогов', 'CODE' => 'CML2_TAXES', 'VALUE' => $k_pr['PROPERTY_CML2_TAXES_VALUE'], 'SORT' => '2'],
									['NAME' => 'Реквизиты', 'CODE' => 'CML2_TRAITS', 'VALUE' => $k_pr['PROPERTY_CML2_TRAITS_VALUE'], 'SORT' => '3'],
									['NAME' => 'Производитель', 'CODE' => 'CML2_MANUFACTURER', 'VALUE' => $k_pr['PROPERTY_CML2_MANUFACTURER_VALUE'], 'SORT' => '4'],
									['NAME' => 'Базовая единица', 'CODE' => 'CML2_BASE_UNIT', 'VALUE' => $k_pr['PROPERTY_CML2_BASE_UNIT_VALUE'], 'SORT' => '5'],
									['NAME' => 'Раздел', 'CODE' => 'IBLOCK_SECTION_ID', 'VALUE' => $base_pr['IBLOCK_SECTION_ID'], 'SORT' => '6'],
								],
							];

							$k_id = CSaleBasket::Add($arFieldsKit);

							$k['id'] = $k_pr['ID'];
							$k['element_id'] = strval($k_id);
							$k['name'] = $k_pr['NAME'];

							$arResult['kit'][] = $k;
						}
					}
				} else {
					$arResult['error'] = true;
					$arResult['message'] = 'Ошибка добавления комплекта';
					$arResult['id'] = 0;
				}
			} else {
				$kit_pr_arr = [];
				$kit_sum_price = 0;
				$persent = 0;
				$discount = 0;

				$base_pr['PRICE_1_DISCOUNT'] = $discount > 0 ? strval($discount * $base_pr['PRICE_1'] / 100) : '0';
				$base_pr['~PRICE_1_DISCOUNT'] = $base_pr['PRICE_1_DISCOUNT'];
				$base_pr['PRICE_1_TOTAL'] = strval($base_pr['PRICE_1'] - $base_pr['PRICE_1_DISCOUNT']);
				$base_pr['~PRICE_1_TOTAL'] = $base_pr['PRICE_1_TOTAL'];

				$arResult['error'] = false;
				$arResult['message'] = 'Общая стоимость комплекта';
				$arResult['id'] = 0;
				$arResult['base_product'] = $base_pr;
				$arResult['kit_products'] = $kit_pr_arr;
				$arResult['sumprice'] = $kit_sum_price;
				$arResult['persent'] = $persent;
				$arResult['discount'] = $discount;
				$arResult['sumprice_discount'] = $discount > 0 ? $discount * $kit_sum_price / 100 : $kit_sum_price;
				$arResult['sumprice_total'] = $kit_sum_price - $arResult['sumprice_discount'];
			}

		} else {

			//$r = Add2BasketByProductID($_REQUEST['PRODUCT_ID'], $_REQUEST['QUANTITY']);

			$group = $USER->GetUserGroup($USER->GetID());
			$opt = in_array('9', $group);

			$arNotesBase = [
				'ID' => '0',
				'PRICE_1_DISCOUNT' => 0,
				'PRICE_1_TOTAL' => !$opt ? $base_pr['PRICE_1'] : $base_pr['PRICE_3'],
				'DISCOUNT_PERSENT' => 0,				
				'UF_BONUS_SYSTEM_ACTIVE' => $bonus_system_active,
				'MAIN_PRODUCT_ID' => !empty($_REQUEST['MAIN_PRODUCT_ID']) ? $_REQUEST['MAIN_PRODUCT_ID'] : 0,
				'SKU_ID' => !empty($_REQUEST['MAIN_PRODUCT_ID']) ? $_REQUEST['PRODUCT_ID'] : 0,
			];

			$arFieldsBase = [
				'PRODUCT_ID' => $base_pr['ID'],
				'PRODUCT_PRICE_ID' => 0,
				'PRICE' => !$opt ? $base_pr['PRICE_1'] : $base_pr['PRICE_3'],
				'QUANTITY' => $_REQUEST['QUANTITY'],
				'LID' => 's1',
				'CUSTOM_PRICE' => !$opt ? 'N' : 'Y',
				'CAN_BUY' => 'Y',
				'CURRENCY' => 'RUB',
				'NAME' => $base_pr['NAME'],
				'NOTES' => serialize($arNotesBase),
				'WEIGHT' => $base_pr['WEIGHT'],
				'DETAIL_PAGE_URL' => $base_pr['DETAIL_PAGE_URL'],
				'DELAY' => 'N',
				'MODULE' => 'catalog',
				'PROPS' => [
					['NAME' => 'Артикул', 'CODE' => 'CML2_ARTICLE', 'VALUE' => $base_pr['PROPERTY_CML2_ARTICLE_VALUE'], 'SORT' => '1'],
					['NAME' => 'Ставки налогов', 'CODE' => 'CML2_TAXES', 'VALUE' => $base_pr['PROPERTY_CML2_TAXES_VALUE'], 'SORT' => '2'],
					['NAME' => 'Реквизиты', 'CODE' => 'CML2_TRAITS', 'VALUE' => $base_pr['PROPERTY_CML2_TRAITS_VALUE'], 'SORT' => '3'],
					['NAME' => 'Производитель', 'CODE' => 'CML2_MANUFACTURER', 'VALUE' => $base_pr['PROPERTY_CML2_MANUFACTURER_VALUE'], 'SORT' => '4'],
					['NAME' => 'Базовая единица', 'CODE' => 'CML2_BASE_UNIT', 'VALUE' => $base_pr['PROPERTY_CML2_BASE_UNIT_VALUE'], 'SORT' => '5'],
					['NAME' => 'Раздел', 'CODE' => 'IBLOCK_SECTION_ID', 'VALUE' => $base_pr['IBLOCK_SECTION_ID'], 'SORT' => '6'],
				],
			];

			$basket_product = null;

			$basket_list = CSaleBasket::GetList(['NAME' => 'ASC', 'ID' => 'ASC'], ['FUSER_ID' => CSaleBasket::GetBasketUserID(), 'LID' => SITE_ID, 'ORDER_ID' => 'NULL']);

			while ($basket_item = $basket_list->GetNext()) {
				if ($base_pr['ID'] === $basket_item['PRODUCT_ID']) {
					$basket_product = $basket_item;
				}
			}

			if ($basket_product === null) {

				$base_id = CSaleBasket::Add($arFieldsBase);

				if (!$opt && $base_id !== false) {

					$gift = DiscountsHelper::getGiftIds($base_pr['ID']);

					//$arResult['gift'] = $gift;

					if (!empty($gift)) {

						$gift_pr_res = CIBlockElement::GetByID($gift[0]);

						if ($gift_pr = $gift_pr_res->GetNext()) {

							$arNotesGift = [
								'ID' => '0',
								'PRICE_1_DISCOUNT' => 0,
								'PRICE_1_TOTAL' => 0,
								'DISCOUNT_PERSENT' => 0,								
								'UF_BONUS_SYSTEM_ACTIVE' => false,
							];

							$arFieldsGift = [
								'PRODUCT_ID' => $gift[0],
								'PRODUCT_PRICE_ID' => 0,
								'PRICE' => 0,
								'QUANTITY' => 1,
								'LID' => 's1',
								'CUSTOM_PRICE' => 'Y',
								'CAN_BUY' => 'Y',
								'CURRENCY' => 'RUB',
								'NAME' => $gift_pr['NAME'],
								'NOTES' => serialize($arNotesGift),
								'WEIGHT' => $gift_pr['WEIGHT'],
								'DETAIL_PAGE_URL' => $gift_pr['DETAIL_PAGE_URL'],
								'DELAY' => 'N',
								'MODULE' => 'catalog',
								'PROPS' => [
									['NAME' => 'Артикул', 'CODE' => 'CML2_ARTICLE', 'VALUE' => $gift_pr['PROPERTY_CML2_ARTICLE_VALUE'], 'SORT' => '1'],
									['NAME' => 'Ставки налогов', 'CODE' => 'CML2_TAXES', 'VALUE' => $gift_pr['PROPERTY_CML2_TAXES_VALUE'], 'SORT' => '2'],
									['NAME' => 'Реквизиты', 'CODE' => 'CML2_TRAITS', 'VALUE' => $gift_pr['PROPERTY_CML2_TRAITS_VALUE'], 'SORT' => '3'],
									['NAME' => 'Производитель', 'CODE' => 'CML2_MANUFACTURER', 'VALUE' => $gift_pr['PROPERTY_CML2_MANUFACTURER_VALUE'], 'SORT' => '4'],
									['NAME' => 'Базовая единица', 'CODE' => 'CML2_BASE_UNIT', 'VALUE' => $gift_pr['PROPERTY_CML2_BASE_UNIT_VALUE'], 'SORT' => '5'],
									['NAME' => 'Раздел', 'CODE' => 'IBLOCK_SECTION_ID', 'VALUE' => $base_pr['IBLOCK_SECTION_ID'], 'SORT' => '6'],
								],
							];

							$gift_id = CSaleBasket::Add($arFieldsGift);

							$arResult['gift_id'] = $gift[0];
							$arResult['gift_element_id'] = $gift_id;

						}

					} else {

							$arResult['gift_id'] = 0;
							$arResult['gift_element_id'] = 0;

					}
				}

			} else {

				if ($_REQUEST['QUANTITY'] > 0) {
					$base_id = CSaleBasket::Update($basket_product['ID'], ['QUANTITY' => $_REQUEST['QUANTITY']]);
				} else {
					$base_id = CSaleBasket::Delete($basket_product['ID']);
					if (!$opt && $base_id !== false) {
						$gift = DiscountsHelper::getGiftIds($basket_product['PRODUCT_ID']);
						if (!empty($gift)) {
							$gift_product = null;
							$bl = CSaleBasket::GetList(['NAME' => 'ASC', 'ID' => 'ASC'], ['FUSER_ID' => CSaleBasket::GetBasketUserID(), 'LID' => SITE_ID, 'ORDER_ID' => 'NULL']);
							while ($bi = $bl->GetNext()) {
								if (intval($bi['PRODUCT_ID']) === $gift[0]) $gift_product = $bi;
							}
							if ($gift_product !== null) {
								$gift_id = CSaleBasket::Delete($gift_product['ID']);
								$arResult['gift_id'] = $gift[0];
								$arResult['gift_element_id'] = $gift_id;
							} else {
								$arResult['gift_id'] = 0;
								$arResult['gift_element_id'] = 0;
							}
						}
					}
/*
					$arResult['product'] = $basket_product;
					$arResult['base_id'] = $base_id;
					$arResult['opt'] = $opt;
					$arResult['gift'] = $gift;
					$arResult['gift_product'] = $gift_product;
					$arResult['gift_id'] = $gift_id;
*/
				}

			}

			$arResult['error'] = !$base_id;
			$arResult['message'] = $base_id === false ? 'Ошибка добавления товара' : 'Корзина обновлена';
			$arResult['id'] = intval($base_pr['ID']);
			$arResult['element_id'] = $base_id === true ? intval($basket_product['ID']) : $base_id;


		}

	} else {

		$arResult['error'] = true;
		$arResult['message'] = 'Ошибка добавления товара';
		$arResult['id'] = 0;

	}	

} else {

	$arResult['error'] = true;
	$arResult['message'] = 'Ошибка добавления товара';
	$arResult['id'] = 0;

}

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();


?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

