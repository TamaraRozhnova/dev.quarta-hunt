<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>
<?
if (isset($result['ANALOG_PRODUCTS']) && count($result['ANALOG_PRODUCTS']) > 0) {
?>
<div class="analogs">
    <div class="container">
        <h2 class="mb-4"><?=GetMessage("ANALOG_TITLE")?></h2>
    </div>
    <div class="base-slider">
        <div class="container">
            <div class="swiper-container swiper-container_analogs">
                <div class="swiper-wrapper" itemscope itemtype="http://schema.org/ItemList">
                    <? foreach ($result['ANALOG_PRODUCTS'] as $product) { ?>
                        <div class="swiper-slide" >
                            <? $APPLICATION->IncludeComponent(
                                'bitrix:catalog.item',
                                'main_slide',
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
<?
}
?>
