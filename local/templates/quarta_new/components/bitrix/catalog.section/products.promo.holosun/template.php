<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if (!empty($arResult['ITEMS'])): ?>
<div class="row">
    <?php foreach ($arResult['ITEMS'] as $arItemIndex => $arItem): ?>
        <div class="<?=($arParams['PAGE_ELEMENT_COUNT'] > 2) ? 'col-3' : 'col-6' ?>">
            <?php $APPLICATION->IncludeComponent(
                'bitrix:catalog.item',
                'main',
                array(
                    'RESULT' => array(
                        'ITEM' => $arItem,
                        'PARAMS' => $arParams
                    ),
                ),
                $component
            ); ?>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
