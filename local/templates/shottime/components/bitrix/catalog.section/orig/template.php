<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;
use Bitrix\Main\UI\Extension;

Extension::load('ui.bootstrap4');
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 *
 *  _________________________________________________________________________
 * |	Attention!
 * |	The following comments are for system use
 * |	and are required for the component to work correctly in ajax mode:
 * |	<!-- items-container -->
 * |	<!-- pagination-container -->
 * |	<!-- component-end -->
 */

$this->setFrameMode(true);

if (!empty($arResult['NAV_RESULT']))
{
	$navParams =  array(
		'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
		'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
		'NavNum' => $arResult['NAV_RESULT']->NavNum
	);
}
else
{
	$navParams = array(
		'NavPageCount' => 1,
		'NavPageNomer' => 1,
		'NavNum' => $this->randString()
	);
}

$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1)
{
	$showTopPager = $arParams['DISPLAY_TOP_PAGER'];
	$showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
	$showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'];
}

$templateLibrary = array('popup', 'ajax', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$arParams['~MESS_BTN_BUY'] = $arParams['~MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_BUY');
$arParams['~MESS_BTN_DETAIL'] = $arParams['~MESS_BTN_DETAIL'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_DETAIL');
$arParams['~MESS_BTN_COMPARE'] = $arParams['~MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_COMPARE');
$arParams['~MESS_BTN_SUBSCRIBE'] = $arParams['~MESS_BTN_SUBSCRIBE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE');
$arParams['~MESS_BTN_ADD_TO_BASKET'] = $arParams['~MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET');
$arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE');
$arParams['~MESS_NOT_AVAILABLE_SERVICE'] = ($arParams['~MESS_NOT_AVAILABLE_SERVICE'] ?? '')
	?: Loc::getMessage('CP_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE_SERVICE')
;
$arParams['~MESS_SHOW_MAX_QUANTITY'] = $arParams['~MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCS_CATALOG_SHOW_MAX_QUANTITY');
$arParams['~MESS_RELATIVE_QUANTITY_MANY'] = $arParams['~MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['~MESS_RELATIVE_QUANTITY_FEW'] = $arParams['~MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_FEW');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_FEW');

$arParams['MESS_BTN_LAZY_LOAD'] = $arParams['MESS_BTN_LAZY_LOAD'] ?: Loc::getMessage('CT_BCS_CATALOG_MESS_BTN_LAZY_LOAD');

$obName = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($navParams['NavNum']));
$containerName = 'container-'.$navParams['NavNum'];

$themeClass = isset($arParams['TEMPLATE_THEME']) ? ' bx-'.$arParams['TEMPLATE_THEME'] : '';

?>

<div class="inner__hero">
	<?/*
    <? if($arResult['DETAIL_PICTURE']['SRC']):?>
        <div class="inner__hero-img">
            <picture>
                <source media="(max-width: 743px)" srcset="<?=$arResult['BACKGROUND_IMAGE']['SRC']?>">
                <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>">
            </picture>
        </div>
    <?endif?>
    <? if($arResult['DESCRIPTION']):?>
        <div class="inner__hero-desc">
            <?=$arResult['DESCRIPTION']?>
        </div>
    <?endif?>
*/?>
</div>
<div class="inner__catalog catalog"> <? // wrapper ?>
	<?
	//region Pagination
	if ($showTopPager)
	{
		?>
		<div class="inner__catalog_pagination">
			<div class="col text-center" data-pagination-num="<?=$navParams['NavNum']?>">
				<!-- pagination-container -->
				<?=$arResult['NAV_STRING']?>
				<!-- pagination-container -->
			</div>
		</div>
		<?
	}
	//endregion

	//region Description
	if (($arParams['HIDE_SECTION_DESCRIPTION'] !== 'Y') && !empty($arResult['DESCRIPTION']))
	{
		?>
		<div class="row mb-4">
			<div class="col catalog-section-description">
				<p><?=$arResult['DESCRIPTION']?></p>
			</div>
		</div>
		<?
	}
	//endregion
	?>
		<div class="catalog__list" data-entity="<?=$containerName?>">
            <!-- items-container -->
            <? foreach ($arResult['ITEMS'] as $index => $arItem)
            {
                $APPLICATION->IncludeComponent( 'bitrix:catalog.item',
                    'catalog.item',
//                'catalog.item',
                    [
                        'RESULT' => [
                            'ITEM' => $arItem,
                            'SHOW_PROPS' => $arResult['SHOW_PROPS'],
                        ],
                    ] );
            } ?>
            <!-- items-container -->
		</div>

<section class="section section-plus">
  <div class="">
    <div class="section-plus__grid">
				
              <div class="section-plus__item">
                <div class="section-plus__item-title">Выгодные<br>цены</div>
                <div class="section-plus__item-text">Самая доступная пневматика в России</div>
                <div class="plus plus--top-left">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--top-right">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--bottom-left">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--bottom-right">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
              </div>
 
              <div class="section-plus__item">
                <div class="section-plus__item-title">Высокое<br>качество</div>
                <div class="section-plus__item-text">Простые и надёжные механизмы пистолетов</div>
                <div class="plus plus--top-left">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--top-right">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--bottom-left">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--bottom-right">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
              </div>
 
              <div class="section-plus__item">
                <div class="section-plus__item-title">Отличное<br>сходство</div>
                <div class="section-plus__item-text">Основаны на легендарных боевых прототипах</div>
                <div class="plus plus--top-left">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--top-right">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--bottom-left">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--bottom-right">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
              </div>
 
              <div class="section-plus__item">
                <div class="section-plus__item-title">Удобная<br>доставка</div>
                <div class="section-plus__item-text">Доставка в любой регион в течение 5 дней</div>
                <div class="plus plus--top-left">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--top-right">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--bottom-left">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--bottom-right">
                  <svg class="icon icon-plus">
                    <use xlink:href="/local/templates/shottime/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
              </div>
 
             </div>
  </div>
</section>

		<?

		//region LazyLoad Button
		if ($showLazyLoad)
		{
			?>
			<div class="text-center mb-4" data-entity="lazy-<?=$containerName?>">
				<button type="button"
						class="btn btn-primary btn-md"
						style="margin: 15px;"
						data-use="show-more-<?=$navParams['NavNum']?>">
							<?=$arParams['MESS_BTN_LAZY_LOAD']?>
				</button>
			</div>
			<?
		}
		//endregion

		//region Pagination
		if ($showBottomPager)
		{
			?>
			<div class="row mb-4">
				<div class="col text-center" data-pagination-num="<?=$navParams['NavNum']?>">
					<!-- pagination-container -->
					<?=$arResult['NAV_STRING']?>
					<!-- pagination-container -->
				</div>
			</div>
			<?
		}
		//endregion

		$signer = new \Bitrix\Main\Security\Sign\Signer;
		$signedTemplate = $signer->sign($templateName, 'catalog.section');
		$signedParams = $signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');
		?>
		<script>
			BX.message({
				BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
				BASKET_URL: '<?=$arParams['BASKET_URL']?>',
				ADD_TO_BASKET_OK: '<?=GetMessageJS('ADD_TO_BASKET_OK')?>',
				TITLE_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR')?>',
				TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS')?>',
				TITLE_SUCCESSFUL: '<?=GetMessageJS('ADD_TO_BASKET_OK')?>',
				BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR')?>',
				BTN_MESSAGE_SEND_PROPS: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS')?>',
				BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE')?>',
				BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
				COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_OK')?>',
				COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
				COMPARE_TITLE: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_TITLE')?>',
				PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCS_CATALOG_PRICE_TOTAL_PREFIX')?>',
				RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
				RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
				BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
				BTN_MESSAGE_LAZY_LOAD: '<?=CUtil::JSEscape($arParams['MESS_BTN_LAZY_LOAD'])?>',
				BTN_MESSAGE_LAZY_LOAD_WAITER: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_LAZY_LOAD_WAITER')?>',
				SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
			});
			var <?=$obName?> = new JCCatalogSectionComponent({
				siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
				componentPath: '<?=CUtil::JSEscape($componentPath)?>',
				navParams: <?=CUtil::PhpToJSObject($navParams)?>,
				deferredLoad: false,
				initiallyShowHeader: '<?=!empty($arResult['ITEM_ROWS'])?>',
				bigData: <?=CUtil::PhpToJSObject($arResult['BIG_DATA'])?>,
				lazyLoad: !!'<?=$showLazyLoad?>',
				loadOnScroll: !!'<?=($arParams['LOAD_ON_SCROLL'] === 'Y')?>',
				template: '<?=CUtil::JSEscape($signedTemplate)?>',
				ajaxId: '<?=CUtil::JSEscape($arParams['AJAX_ID'])?>',
				parameters: '<?=CUtil::JSEscape($signedParams)?>',
				container: '<?=$containerName?>'
			});
		</script>


</div> <? //end wrapper?>

<!-- component-end -->
