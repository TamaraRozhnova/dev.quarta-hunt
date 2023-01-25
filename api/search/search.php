<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

CModule::IncludeModule('highloadblock');

function getHlBlockData($id) {
    $result = array();
    $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById($id)->fetch();
    $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    $rs_data = $entity_data_class::getList(array('order' => array(), 'select' => array('UF_NAME', 'UF_XML_ID')));
    while ($el = $rs_data->fetch())
    {
        $data['NAME'] = $el['UF_NAME'];
        $data['VALUE'] = $el['UF_XML_ID'];
        $result[] = $data;
    }
    return $result;
}

// RAZMER_OBUV
$arResult['RAZMER_OBUV'] = getHlBlockData(9);

// RAZMER_ODEZHDA_ZHENSKAYA
$arResult['RAZMER_ODEZHDA_ZHENSKAYA'] = getHlBlockData(10);

// RAZMER_NOSKI
$arResult['RAZMER_NOSKI'] = getHlBlockData(8);

// RAZMER_AKSESSUAROV_
$arResult['RAZMER_AKSESSUAROV_'] = getHlBlockData(7);

// RAZMER
$arResult['RAZMER'] = getHlBlockData(11);


$arResult['ITEMS'] = array();
$arResult['NAV']['NAV_ALL_RECORD_COUNT'] = 0;

$query = $_REQUEST['q'];

if (empty($query)) {
	ob_end_clean();
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($arResult);
	die();
}

CModule::IncludeModule('iblock');

$numpage  = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$pagesize = isset($_REQUEST['size']) ? intval($_REQUEST['size']) : 10;

$arResult['NAV']['NAV_PAGE_NOMER'] = intval($numpage);
$arResult['NAV']['NAV_PAGE_SIZE'] = intval($pagesize);


function search(&$arResult, $iblock, $search_field, $q, $numpage, $pagesize) {
	$items = [];
	$ids = [];

	if (mb_strtolower(mb_substr($q, -1)) === 'и' || mb_strtolower(mb_substr($q, -1)) === 'ы') $q = mb_substr($q, 0, -1);

	$q = str_replace(' ', '%', $q);

	$count  = CIBlockElement::GetList(['name' => 'asc'], ['IBLOCK_ID' => $iblock, $search_field => '%' . $q . '%'], []);

	if ($numpage > 0 && $pagesize > 0) {
		$result = CIBlockElement::GetList(['AVAILABLE' => 'desc', 'name' => 'asc'], ['IBLOCK_ID' => $iblock, $search_field => '%' . $q . '%', 'ACTIVE' => 'Y'], false, 
			['iNumPage' => $numpage, 'nPageSize' => $pagesize]);

		while ($item = $result->GetNextElement()) {
			$f = $item->GetFields();
			$p = $item->GetProperties();
			$f['CML2_ARTICLE'] = $p['CML2_ARTICLE']['VALUE'];
			$id = $f['ID'] . '-' . $iblock;
			$items[$id] = $f;
			$ids[] = $f['ID'];
		}

		if ($iblock == 16) {
			$result = CIBlockElement::GetList(['name' => 'asc'], ['IBLOCK_ID' => $iblock, 'ID' => $ids], false, false, 
				['ID', 'NAME', 'CODE', 'CURRENCY', 'PRICE_1', 'PRICE_2', 'PRICE_3', 'QUANTITY']);

			while ($item = $result->GetNext()) {
				$id = $item['ID'] . '-' . $iblock;
				if (!empty($items[$id])) {
					$items[$id]['PRICES'] = $item;
					$items[$id]['RAZMER_OBUV'] = $arResult['RAZMER_OBUV'];
					$items[$id]['RAZMER_ODEZHDA_ZHENSKAYA'] = $arResult['RAZMER_ODEZHDA_ZHENSKAYA'];
					$items[$id]['RAZMER_NOSKI'] = $arResult['RAZMER_NOSKI'];
					$items[$id]['RAZMER_AKSESSUAROV_'] = $arResult['RAZMER_AKSESSUAROV_'];
					$items[$id]['RAZMER'] = $arResult['RAZMER'];
				}
			}
		}

		$arResult['ITEMS'] = array_merge($arResult['ITEMS'], $items);
	}

	$arResult['NAV']['NAV_ALL_RECORD_COUNT'] = $arResult['NAV']['NAV_ALL_RECORD_COUNT'] + $count;
}


// поиск по каталогу
search($arResult, 16, 'SEARCHABLE_CONTENT', $query, $numpage, $pagesize);
search($arResult, 16, 'PROPERTY_CML2_ARTICLE', $query, $numpage, $pagesize);


// поиск по акциям
if ($numpage * $pagesize < $arResult['NAV']['NAV_ALL_RECORD_COUNT']) {
	$numpage = $pagesize = 0;
}

search($arResult, 23, 'NAME', $query, $numpage, $pagesize);


// поиск по новостям
if ($numpage * $pagesize < $arResult['NAV']['NAV_ALL_RECORD_COUNT']) {
	$numpage = $pagesize = 0;
}

search($arResult, 1, 'NAME', $query, $numpage, $pagesize);


$arResult['NAV']['NAV_RECORD_COUNT'] = count($arResult['ITEMS']);
$arResult['NAV']['N_START_PAGE'] = 1;
$arResult['NAV']['N_END_PAGE'] = ceil($arResult['NAV']['NAV_ALL_RECORD_COUNT'] / $arResult['NAV']['NAV_PAGE_SIZE']);
$arResult['NAV']['NAV_NUM'] = $arResult['NAV']['NAV_PAGE_NOMER'] + 1 <= $arResult['NAV']['N_END_PAGE'] ? 
	$arResult['NAV']['NAV_PAGE_NOMER'] + 1 : $arResult['NAV']['N_END_PAGE'];

unset($arResult['RAZMER_OBUV']);
unset($arResult['RAZMER_ODEZHDA_ZHENSKAYA']);
unset($arResult['RAZMER_NOSKI']);
unset($arResult['RAZMER_AKSESSUAROV_']);
unset($arResult['RAZMER']);


$items = $arResult['ITEMS'];
$ids = array();

unset($arResult['ITEMS']);

// перезаписать массив без ключей, пути к картинкам, id-шники для отзывов
foreach ($items as $item) {
	$ids[] = $item['ID'];
	$item['PREVIEW_PICTURE'] = CFile::GetPath($item['PREVIEW_PICTURE']);
	$item['DETAIL_PICTURE'] = CFile::GetPath($item['DETAIL_PICTURE']);
	$arResult['ITEMS'][] = $item;
}

// отзывы о товаре - оценка
$list = CIBlockElement::GetList([], ['IBLOCK_ID' => 11, 'PROPERTY_PRODUCT_ID' => $ids]);

while($i = $list->GetNextElement()) {
	$f = $i->GetFields();
	$p = $i->GetProperties();

	$f['USER_ID'] = $p['USER_ID'];
	$f['PRODUCT_ID'] = $p['PRODUCT_ID'];
	$f['RATING'] = $p['RATING'];

	foreach($arResult['ITEMS'] as $n => $item) {
		if ($item['ID'] == $p['PRODUCT_ID']['VALUE']) {
			$arResult['ITEMS'][$n]['FEEDBACK'][] = $f;
		}
	}
}



ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();

?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>