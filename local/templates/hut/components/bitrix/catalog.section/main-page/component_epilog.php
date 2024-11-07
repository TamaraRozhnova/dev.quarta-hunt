<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $templateData
 * @var string $templateFolder
 * @var CatalogSectionComponent $component
 */

use Helpers\IblockHelper;
use Personal\Favorites;

global $APPLICATION;

if (!empty($templateData['TEMPLATE_LIBRARY'])) {
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES'])) {
		$loadCurrency = \Bitrix\Main\Loader::includeModule('currency');
	}

	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);

	if ($loadCurrency) {
?>
		<script>
			BX.Currency.setCurrencies(<?= $templateData['CURRENCIES'] ?>);
		</script>
		<?
	}
}

//	lazy load and big data json answers
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
if ($request->isAjaxRequest() && ($request->get('action') === 'showMore' || $request->get('action') === 'deferredLoad')) {
	$content = ob_get_contents();
	ob_end_clean();

	[, $itemsContainer] = explode('<!-- items-container -->', $content);
	$paginationContainer = '';
	if ($templateData['USE_PAGINATION_CONTAINER']) {
		[, $paginationContainer] = explode('<!-- pagination-container -->', $content);
	}
	[, $epilogue] = explode('<!-- component-end -->', $content);

	if (isset($arParams['AJAX_MODE']) && $arParams['AJAX_MODE'] === 'Y') {
		$component->prepareLinks($paginationContainer);
	}

	$component::sendJsonAnswer(array(
		'items' => $itemsContainer,
		'pagination' => $paginationContainer,
		'epilogue' => $epilogue,
	));
}

// Проверяем избранное

if ($arResult['ITEM_IDS']) {
	$favorites = new Favorites(IblockHelper::getIdByCode("hutfavorites"), HUT_FAVORITES_COOCKIE_NAME);
	$favoritesIds = $favorites->getFavoritesIds();

	foreach ($arResult['ITEM_IDS'] as $item) {
		if (in_array($item, $favoritesIds)) { ?>
			<script>
				if (document.querySelector('[data-product-id="' + <?= $item ?> + '"]')) {
					document.querySelector('[data-product-id="' + <?= $item ?> + '"]').classList.add('in-favorites');
				}
			</script>
<? }
	}
}
