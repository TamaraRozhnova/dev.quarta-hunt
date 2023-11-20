<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<?php if (is_array($arResult['ITEMS']) && !empty($arResult['ITEMS'])): ?>
    <div class="swiper-container swiper-container_action">
        <div class="swiper-wrapper">
            <?php foreach ($arResult['ITEMS'] as $arItemIndex => $arItem): ?>
                <div class="swiper-slide">
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
        <?if (is_array($arResult['ITEMS']) && count($arResult['ITEMS']) > 2) {?>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        <?}?>
    </div>
<?php endif; ?>
