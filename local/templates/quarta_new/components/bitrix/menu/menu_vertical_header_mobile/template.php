<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult)) {
    return;
}

?>

<div class="py-3">
    <? foreach ($arResult as $item) { ?>
        <a href="<?= $item['LINK'] ?>" class="mobile-nav__item"><?= $item['TEXT'] ?></a>
    <? } ?>
</div>