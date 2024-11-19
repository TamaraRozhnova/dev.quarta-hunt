<?php if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global \CMain $APPLICATION */
/** @global \CUser $USER */
/** @global \CDatabase $DB */
/** @var \CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var array $templateData */
/** @var \CBitrixComponent $component */
$this->setFrameMode( true );
/*echo '<pre>';
print_r($arResult);
echo '</pre>';*/


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
$containerName = 'container-'.$navParams['NavNum'];

?>
<div class="inner__hero">
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
</div>
<div class="inner__catalog catalog">
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
    ?>

	<div class="catalog__list"  data-entity="<?=$containerName?>">
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
    ?>
</div>
