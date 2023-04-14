<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!$arResult['VIDEO']) {
    return;
}

?>

<div class="row">
    <div class="col-12">
        <div size="large" class="video-player">
            <iframe class="video-js" src="<?= $arResult['VIDEO'] ?>"></iframe>
        </div>
    </div>
</div>
