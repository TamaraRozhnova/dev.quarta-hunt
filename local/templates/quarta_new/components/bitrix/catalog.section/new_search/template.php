<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="search">
    <div class="container">
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5">
            <? foreach ($arResult['ITEMS'] as $item) { ?>
                    <? $APPLICATION->IncludeComponent(
                        'bitrix:catalog.item',
                        'main',
                        array(
                            'RESULT' => array(
                                'ITEM' => $item,
                                'PARAMS' => $arParams
                            ),
                        ),
                        $component
                    ); ?>
            <? } ?>
        </div>
    </div>
</div>
