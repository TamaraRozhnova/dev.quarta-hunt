<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);?>

<? if($arResult["VIEW_REF_COUPON"] == 'Y'): ?>

    <div class="bonuses-cabinet-ref-wrapper">
        <div class="bonuses-cabinet-ref logictim_user_bonus">
            <div class="bonuses-cabinet-ref-item">
                <div class="bonuses-cabinet-ref-label">
                    <?=Loc::getMessage("LOGICTIM_REFERALS_REF_COUPON")?>
                </div>
                <span id="partnet_coupon">
                    <? if (!empty($arResult['COUPON'])): ?>
                        <?=$arResult["COUPON"]?>
                    <? elseif (Option::get('logictim.balls', 'REFERAL_COUPON_CAN_USER', 'N') == 'Y'): ?>
                        <input 
                            type="text" 
                            class="inputtext" 
                            id="enter_coupon_code" 
                            value="" 
                            placeholder='<?=Loc::getMessage("LOGICTIM_BONUS_ENTER_COUPONE_CODE")?>' 
                        />

                        <a href="#" class="btn btn-default" id="enter_coupon">
                            <?=Loc::getMessage("LOGICTIM_BONUS_ADD_COUPONE_CODE")?>
                        </a>

                        <div id="coupon_error"></div>
                    <? else: ?>

                        <span class="generate_coupon" id="generate_coupon">
                            <?=Loc::getMessage("LOGICTIM_REFERALS_REF_COUPON_GENERATE")?>
                        </span>

                        <div id="coupon_error"></div>
                    <? endif; ?>
                </span>
            </div>
            <? if (!empty($arResult['COUPON'])): ?>
                <div class="bonuses-cabinet-ref-item">
                    <div class="bonuses-cabinet-ref-label">
                        <?=
                        Loc::getMessage(
                            "LOGICTIM_REFERALS_REF_COUPON_USED",
                            ['#USED_COUNT#' => $arResult['USE_COUNT_COUPON']]
                        )
                        ?>
                    </div>
                </div>
            <? endif; ?>
        </div>
    </div>

<? endif; ?>


