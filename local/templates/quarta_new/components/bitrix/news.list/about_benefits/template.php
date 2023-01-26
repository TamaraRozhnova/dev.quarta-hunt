<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<section class="advantages bg-white">
    <div class="container">
        <h2>Наши преимущества</h2>
        <div class="row">
            <? foreach ($arResult['ITEMS'] as $item) { ?>
                <div class="col-12 col-sm-6 col-lg-3 row__item">
                    <h4>
                        <img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" class="icon"/>
                        <?= $item['NAME'] ?>
                    </h4>
                    <p class="advantages__abs"><?= $item['PREVIEW_TEXT'] ?></p>
                </div>
            <? } ?>
        </div>
    </div>
</section>