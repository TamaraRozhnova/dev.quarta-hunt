<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\Extension;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

Extension::load('ui.notification');
Extension::load('addamant_thanks.global');

$this->addExternalCss($this->GetFolder() . '/styles/buttons/buttons.css');
?>
<div class="reviews__wrap" id="prod_<?= $arParams['ELEMENT_ID'] ?>">
    <div class="reviews-list-block">
        <?php foreach ($arResult['COMMENTS'] as $commentId => $comment) :
            if ($comment['AUTHOR_ID'] != $arResult['CURRENT_USER']['ID']) {
                continue;
            }
        ?>
            <div class="reviews-item"
                data-comment-id="<?= $commentId ?>">
                <div class="reviews-content">
                    <div class="top-review-content">
                        <p class="name"><?= $arResult['USERS'][$comment['AUTHOR_ID']]['FIO'] ?></p>
                        <div class="timer-block">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.99398 1.33301C4.31398 1.33301 1.33398 4.31967 1.33398 7.99967C1.33398 11.6797 4.31398 14.6663 7.99398 14.6663C11.6807 14.6663 14.6673 11.6797 14.6673 7.99967C14.6673 4.31967 11.6807 1.33301 7.99398 1.33301ZM8.00065 13.333C5.05398 13.333 2.66732 10.9463 2.66732 7.99967C2.66732 5.05301 5.05398 2.66634 8.00065 2.66634C10.9473 2.66634 13.334 5.05301 13.334 7.99967C13.334 10.9463 10.9473 13.333 8.00065 13.333ZM7.85398 4.66634H7.81398C7.54732 4.66634 7.33398 4.87967 7.33398 5.14634V8.29301C7.33398 8.52634 7.45398 8.74634 7.66065 8.86634L10.4273 10.5263C10.654 10.6597 10.9473 10.593 11.0807 10.3663C11.2207 10.1397 11.1473 9.83967 10.914 9.70634L8.33398 8.17301V5.14634C8.33398 4.87967 8.12065 4.66634 7.85398 4.66634Z" fill="#A5ADB3" />
                            </svg>
                            <span><?= $comment['DATE_CREATE_FORMATTED'] ?></span>
                        </div>
                    </div>
                    <div class="content-text"><?= nl2br($comment['POST_TEXT']) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="reviews-add-block" <?= in_array($arParams['USER_ID'], $arResult['USER_IDS_WITH_COMMENTS']) ? 'style="display: none"' : '' ?>>
        <textarea class="reviews-add-block__textarea" rows="1" type="text" placeholder="Напишите отзыв"></textarea>
        <span class="length-input-block">29/200</span>
    </div>

    <div class="button-add-review-block hidden">
        <button class="button button-secondary button-review-clear"><?= Loc::getMessage('CANCEL') ?></button>
        <button class="button button-primary red-background button-review-add"><?= Loc::getMessage('SEND') ?></button>
    </div>
</div>
<script type="text/javascript">
    BX.ready(function() {
        new BX.ProductComment(
            '<?= $this->getComponent()->getSignedParameters() ?>',
            '<?= $this->getComponent()->getName() ?>',
            <?= CUtil::PhpToJSObject($arResult['JS_DATA'], false, true) ?>,
            'prod_<?= $arParams['ELEMENT_ID'] ?>',
        );
    });
</script>