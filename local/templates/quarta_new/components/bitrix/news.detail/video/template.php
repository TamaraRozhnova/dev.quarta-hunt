<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!$arResult['VIDEO_LINK']) {
    return;
}

?>

<div size="large" class="video-player">
    <iframe class="video-js" src="<?= $arResult['VIDEO_LINK'] ?>"></iframe>
</div>

