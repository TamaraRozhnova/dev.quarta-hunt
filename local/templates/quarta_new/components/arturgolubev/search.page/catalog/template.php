<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var  $arParams */
/** @var  $arResult */

?>

<div class="bx-ag-search-page search-page">
    <form action="" method="get">
        <input id="inputsearch" placeholder="<?=$arParams["INPUT_PLACEHOLDER"] ?>" type="text" name="q" value="<?= $arResult["REQUEST"]["QUERY"] ?>" size="50"/>

        <button id="resetsearch" type="reset"></button>
        <input type="hidden" name="how" value="<?php echo $arResult["REQUEST"]["HOW"] == "d" ? "d" : "r" ?>"/>
    </form>
</div>
