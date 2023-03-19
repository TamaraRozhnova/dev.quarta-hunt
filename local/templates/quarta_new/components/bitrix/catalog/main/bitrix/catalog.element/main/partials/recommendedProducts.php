<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<div class="recommendations">
    <div class="container">
        <h2 class="mb-4">С этим товаром покупают</h2>
    </div>
    <div class="base-slider">
        <div class="container">
            <div class="swiper-container swiper-container_recommended">
                <div class="swiper-wrapper">
                    <? foreach ($result['RECOMMENDED_PRODUCTS'] as $product) { ?>
                        <div class="swiper-slide">
                            <? $APPLICATION->IncludeComponent(
                                'bitrix:catalog.item',
                                'main',
                                array(
                                    'RESULT' => array(
                                        'ITEM' => $product,
                                        'PARAMS' => $params
                                    ),
                                ),
                                $component
                            ); ?>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>
