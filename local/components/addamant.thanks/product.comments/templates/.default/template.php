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
<div class="reviews-list-block">
    <?php foreach ($arResult['COMMENTS'] as $commentId => $comment) : ?>
        <?php
        $ratingComment = $arResult['RATING_COMMENTS'][$comment['ID']];
        $isCurrentUserLiked = $ratingComment['USER_REACTION_LIST'][$comment['AUTHOR_ID']] === 'like';
        $isCurrentUserComment = $comment['AUTHOR_ID'] === $arResult['CURRENT_USER']['ID']
        ?>
        <div class="reviews-item<?= $isCurrentUserComment ? ' my-review-item' : '' ?>"
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
                <div class="like-block<?= $isCurrentUserLiked ? ' liked' : '' ?>">
                    <svg class="liked" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.74675 1.37299L5.05341 5.06632C4.80675 5.31299 4.66675 5.65299 4.66675 6.00632V12.6663C4.66675 13.3997 5.26675 13.9997 6.00008 13.9997H12.0001C12.5334 13.9997 13.0134 13.6797 13.2267 13.193L15.4001 8.11965C15.9601 6.79965 14.9934 5.33299 13.5601 5.33299H9.79341L10.4267 2.27965C10.4934 1.94632 10.3934 1.60632 10.1534 1.36632C9.76008 0.979654 9.13341 0.979654 8.74675 1.37299ZM2.00008 13.9997C2.73341 13.9997 3.33341 13.3997 3.33341 12.6663V7.33299C3.33341 6.59965 2.73341 5.99965 2.00008 5.99965C1.26675 5.99965 0.666748 6.59965 0.666748 7.33299V12.6663C0.666748 13.3997 1.26675 13.9997 2.00008 13.9997Z" fill="var(--color-primary)" />
                    </svg>
                    <svg class="not_liked" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_499_17565)">
                            <path d="M14.0001 5.33366H9.79341L10.4267 2.28699L10.4467 2.07366C10.4467 1.80033 10.3334 1.54699 10.1534 1.36699L9.44675 0.666992L5.06008 5.06033C4.81341 5.30033 4.66675 5.63366 4.66675 6.00033V12.667C4.66675 13.4003 5.26675 14.0003 6.00008 14.0003H12.0001C12.5534 14.0003 13.0267 13.667 13.2267 13.187L15.2401 8.48699C15.3001 8.33366 15.3334 8.17366 15.3334 8.00033V6.66699C15.3334 5.93366 14.7334 5.33366 14.0001 5.33366ZM14.0001 8.00033L12.0001 12.667H6.00008V6.00033L8.89341 3.10699L8.15341 6.66699H14.0001V8.00033ZM0.666748 6.00033H3.33341V14.0003H0.666748V6.00033Z" fill="#333333" />
                        </g>
                        <defs>
                            <clipPath id="clip0_499_17565">
                                <rect width="16" height="16" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <span class="like-block__count"><?= (int)$ratingComment['TOTAL_POSITIVE_VOTES'] ?></span>
                </div>
                <div class="delete-block">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 18L12 12M12 12L6 6M12 12L18 6M12 12L6 18" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (count($arResult['COMMENTS']) < $arResult['COMMENTS_COUNT']) : ?>
        <span class="reviews-list-block__more"><?= Loc::getMessage('MORE_BUTTON') ?></span>
    <?php endif; ?>
</div>

<div class="reviews-add-block" <?= $arParams['USER_ID'] == 0 || in_array($arParams['USER_ID'], $arResult['USER_IDS_WITH_COMMENTS']) ? 'style="display: none"' : '' ?>>
    <textarea class="reviews-add-block__textarea" rows="1" type="text" placeholder="Напишите отзыв"></textarea>
    <span class="length-input-block">29/200</span>
</div>

<? if ($arParams['USER_ID'] == 0) { ?>
    <div class="reviews__no-auth">Авторизуйтесь, чтобы оставить отзыв</div>
<? } ?>

<div class="button-add-review-block hidden">
    <button class="button button-secondary button-review-clear"><?= Loc::getMessage('CANCEL') ?></button>
    <button class="button button-primary red-background button-review-add"><?= Loc::getMessage('SEND') ?></button>
</div>
<script type="text/javascript">
    BX.ready(function() {
        new BX.ProductComment(
            '<?= $this->getComponent()->getSignedParameters() ?>',
            '<?= $this->getComponent()->getName() ?>',
            <?= CUtil::PhpToJSObject($arResult['JS_DATA'], false, true) ?>,
        );
    });
</script>