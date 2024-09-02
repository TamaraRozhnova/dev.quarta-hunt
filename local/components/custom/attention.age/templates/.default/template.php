<?php 

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

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

$this->setFrameMode(false); ?>

<div id="attention-age-modal" class="modal">
	<div class="modal-content">
		<div class="modal-body">
            <div class="attention-age-modal__title">
                <span><?=Loc::getMessage('ATTENTION_TEXT')?></span>
            </div>
            <div class="attention-age-modal__btn">
                <button class="btn btn-primary">
                    <?=Loc::getMessage('ATTENTION_BTN')?>
                </button>
            </div>
		</div>
		<div class="modal__close">
		</div>
	</div>	
</div>
<div id="maxed-blur"></div>