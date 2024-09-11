<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var  $arResult */
/** @var  $APPLICATION */
/** @var  $component */
/** @var  $arParams */
?>

<div class="search">
    <div class="container">
        <div class="row">
            <?php
            foreach ($arResult['ITEMS'] as $item) { ?>
                <?php
                $APPLICATION->IncludeComponent(
                        'bitrix:catalog.item',
                        'search_title',
                        array(
                            'RESULT' => array(
                                'ITEM' => $item,
                                'PARAMS' => $arParams
                            ),
                        ),
                        $component
                    ); ?>
            <?php } ?>
        </div>
    </div>
</div>
