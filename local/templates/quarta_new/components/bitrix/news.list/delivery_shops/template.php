<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}

?>

<div class="bg-white">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/third_section/title.php",
                        ],
                        false
                    ); ?>
                </h2>
            </div>
            <div class="col-12 mt-5">
                <div class="select__wrapper">
                    <div class="select select--shop" data-initial-id="<?= $arResult['ITEMS'][0]['ID'] ?>">
                        <button class="select__main btn">
                            <?= $arResult['ITEMS'][0]['ID'] ?>
                            <div class="select__options">
                                <? foreach ($arResult['ITEMS'] as $item) { ?>
                                    <div class="select__option" data-id="<?= $item['ID'] ?>" tabindex="0">
                                        <span><?= $item['NAME'] ?></span>
                                    </div>
                                <? } ?>
                            </div>
                        </button>
                    </div>
                </div>

                <div id="yandex-map" class="yandex-map mt-5">
                    <div id="shop-map"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const shops = <?= CUtil::PhpToJSObject($arResult['ITEMS']) ?>;
</script>
