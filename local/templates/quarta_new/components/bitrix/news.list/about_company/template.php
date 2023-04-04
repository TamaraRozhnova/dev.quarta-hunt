<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (empty($arResult['ITEMS'])) {
    return;
}

?>

<section class="about-advantages bg-white">
    <div class="container">
        <div class="row">
            <? foreach ($arResult['ITEMS'] as $item) { ?>
                <div class="col-12 col-sm-6 col-lg-3 row__item">
                    <h4>
                        <img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" class="icon" alt="" />
                        <?= $item['NAME'] ?>
                    </h4>
                    <p class="about-advantages__abs">
                        <?= $item['PREVIEW_TEXT'] ?>
                    </p>
                </div>
            <? } ?>
        </div>
    </div>
</section>
