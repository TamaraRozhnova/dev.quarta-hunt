<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use General\User;

$user = new User();
$isUserAuth = $user->isAuthorized();

?>

<div class="reviews-list__content">
    <? if (empty($arResult['ITEMS'])) { ?>
        <center class="py-5">Пока нет ни одного отзыва</center>
        <? return; ?>
    <? } ?>

    <div class="reviews">
        <? foreach ($arResult['ITEMS'] as $review) { ?>
            <div class="review" data-id="<?= $review['ID'] ?>">
                <div class="review__header">
                    <div class="review__name"><?= $review['USER_NAME'] ?></div>
                    <div class="review__date"><?= $review['TIMESTAMP_X'] ?></div>
                    <div class="review__stars">
                        <div class="stars">
                            <? for ($i = 0; $i < $review['RATING']['FILL_STARS']; $i++) { ?>
                                <div class="star star--small">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                </div>
                            <? } ?>

                            <? for ($i = 0; $i < $review['RATING']['OUTLINE_STARS']; $i++) { ?>
                                <div class="star star--small">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                    </svg>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                </div>
                <? if ($review['PROPERTIES']['DIGNITIES']['VALUE']) { ?>
                    <div class="review__pros">
                        <h6>Достоинства</h6>
                        <p>
                            <?= $review['PROPERTIES']['DIGNITIES']['VALUE'] ?>
                        </p>
                    </div>
                <? } ?>
                <? if ($review['PROPERTIES']['FLAWS']['VALUE']) { ?>
                    <div class="review__cons">
                        <h6>Недостатки</h6>
                        <p>
                            <?= $review['PROPERTIES']['FLAWS']['VALUE']?>
                        </p>
                    </div>
                <? } ?>
                <? if ($review['PROPERTIES']['COMMENTS']['VALUE']) { ?>
                    <div class="review__comment">
                        <h6>Комментарий</h6>
                        <p>
                            <?= $review['PROPERTIES']['COMMENTS']['VALUE']?>
                        </p>
                    </div>
                <? } ?>
                <? if ($review['IMAGES']) { ?>
                    <div class="review__images">
                        <? foreach ($review['IMAGES'] as $image) { ?>
                            <div class="image-preview" style="background-image: url('<?= $image['SRC'] ?>')">
                                <div class="image-preview__zoom">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 13C10.3137 13 13 10.3137 13 7C13 3.68629 10.3137 1 7 1C3.68629 1 1 3.68629 1 7C1 10.3137 3.68629 13 7 13Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M11.5 11.5L15 15" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5 7H9M7 5V9V5Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                <? } ?>
                <div class="review__reply">
                    <div class="review__reply-actions">
                        <? if ($isUserAuth) { ?>
                            <a class="review__reply-button">Ответить</a>
                        <? } ?>
                        <div class="review__reaction review__reaction--like">
                            <svg class="review__mark-btn <?= $review['LIKES']['ACTIVE'] ? 'review__mark-btn--active' : '' ?>" width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 12H2.4V4.8H0V12ZM13.2 5.4C13.2 4.74 12.66 4.2 12 4.2H8.214L8.784 1.458L8.802 1.266C8.802 1.02 8.7 0.792 8.538 0.63L7.902 0L3.954 3.954C3.732 4.17 3.6 4.47 3.6 4.8V10.8C3.6 11.46 4.14 12 4.8 12H10.2C10.698 12 11.124 11.7 11.304 11.268L13.116 7.038C13.17 6.9 13.2 6.756 13.2 6.6V5.4Z" fill="#808D9A"/>
                            </svg>
                            <span><?= $review['LIKES']['COUNT'] ?></span>
                        </div>
                        <div class="review__reaction review__reaction--dislike">
                            <svg class="review__mark-btn <?= $review['DISLIKES']['ACTIVE'] ? 'review__mark-btn--active' : '' ?>" width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.4 0H3C2.502 0 2.076 0.3 1.896 0.732L0.084 4.962C0.03 5.1 0 5.244 0 5.4V6.6C0 7.26 0.54 7.8 1.2 7.8H4.986L4.416 10.542L4.398 10.734C4.398 10.98 4.5 11.208 4.662 11.37L5.298 12L9.252 8.046C9.468 7.83 9.6 7.53 9.6 7.2V1.2C9.6 0.54 9.06 0 8.4 0ZM10.8 0V7.2H13.2V0H10.8Z" fill="#808D9A"/>
                            </svg>
                            <span><?= $review['DISLIKES']['COUNT'] ?></span>
                        </div>
                    </div>

                    <? foreach ($review['RESPONSES'] as $response) { ?>
                        <div class="review__response">
                            <div class="review__response-header">
                                <div class="review__response-name"><?= $response['USER_NAME'] ?></div>
                                <div class="review__response-date"><?= $response['DATETIME'] ?></div>
                            </div>
                            <p class="review__response-text">
                                <?= $response['TEXT'] ?>
                            </p>
                            <? if ($isUserAuth) { ?>
                                <a class="review__reply-button">Ответить</a>
                            <? } ?>
                        </div>
                    <? } ?>

                </div>
                <hr/>
            </div>
        <? } ?>
    </div>
</div>

