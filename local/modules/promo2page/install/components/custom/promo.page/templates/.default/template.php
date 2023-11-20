<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$this->setFrameMode(false);

if (empty($arResult['LINK'])) {
    return;
}?>

<a href='<?=$arResult['LINK']?>' class="p2p-line__wrapper hide">
    <div class="p2p-line__inner">
        <div class="p2p-line__text">
            <span><?=$arResult['TEXT']?></span>
        </div>
    </div>
</a>

<script>
    var currentPath = '<?=$arResult['DIR']?>';
</script>