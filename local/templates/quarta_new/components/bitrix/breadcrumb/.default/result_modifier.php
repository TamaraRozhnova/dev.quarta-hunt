<?php 

if(!defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED !== true) {
	die();
}

global $APPLICATION;

// Подменяем название раздела в хлебных крошках.
for ($i=1; $i < count($arResult); $i++) {

	// Разбираем путь до раздела в массив. Отбрасывая пустые элементы.
	if ($arResult[$i]['LINK']) {
		$section_url = array_values(array_filter(explode('/', $arResult[$i]['LINK']), function($element) { return !empty($element); }));
	} else {
		$section_url = '';
		$element_url = array_values(array_filter(explode('/', $APPLICATION->GetCurDir()), function($element) { return !empty($element); }));
	}

	// Если мы в разделе
	if (!empty($section_url)) {
		if (count($section_url) >= 2) {
			// Берём последний элемент массива. Это и есть символьный код раздела.
			$section_code = array_pop($section_url);
	
			//Используем метод для определения id раздела по его символьному коду.
			$section_id = CIBlockFindTools::GetSectionID($sid, $section_code, $arrfilter);
	
			if($section_id && $section_id != 0) {
				//Получаем название раздела из его свойств по id раздела.
				$res = CIBlockSection::GetByID($section_id);
				if($ar_res = $res->GetNext()) {
					$section_name = $ar_res['NAME'];
				}
	
				// Подменяем название пункта хлебных крошек.
				$arResult[$i]['TITLE'] = $section_name;
			}
		}
	}

	// Если мы в элементе
	if (!empty($element_url)) {
		if (count($element_url) >= 2) {

			$parent_url = array_values(array_filter(explode('/', $arResult[$i-1]['LINK']), function($element) { return !empty($element); }));
	
			if (!empty($parent_url)) {
				// $parent_code = array_pop($parent_url);
				for ($p=1; $p < count($parent_url); $p++) {
					$parent_code = $parent_url[$p];
					//Используем метод для определения id раздела родителя по его символьному коду.
					$parent_id = CIBlockFindTools::GetSectionID($id, $parent_code, $arrfilter);
	
					$parent_res = CIBlockSection::GetByID($parent_id);
					if($parent_ar_res = $parent_res->GetNext()) {
						$parent_name = $parent_ar_res['NAME'];
					}
				}
			}
	
			// Берём последний элемент массива элемента. Это и есть символьный код элемента.
			$element_code = array_pop($element_url);
			//Используем метод для определения id раздела по его символьному коду.
			$element_id = CIBlockFindTools::GetElementID($id, $element_code, $parent_id, $parent_code, $arrfilter);
	
			if($element_id && $element_id != 0) {
				//Получаем название элемента из его свойств по id элемента.
				$res = CIBlockElement::GetByID($element_id);
				if($ar_res = $res->GetNext()) {
					$element_name = $ar_res['NAME'];
				}
	
				// Подменяем название пункта хлебных крошек.
				$arResult[$i]['TITLE'] = $element_name;
			}
		}
	}

}
?>