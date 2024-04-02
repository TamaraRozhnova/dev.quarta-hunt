<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use General\User;

$user = new User();
$isUserAuth = $user->isAuthorized();

?>

<div class="container">
    <div class="row">
        <div class="product-reviews__container col-12 col-lg-6 pe-lg-5">
            <div class="reviews-list">
                <div class="row">
                    <div class="col-6">
                        <h3>Отзывы</h3>
                    </div>
                    <div class="col-6 reviews-list__meta">
                        <div class="stars stars--reviews-list placeholder-glow">
                            <div class="placeholder"></div>
                            <div class="placeholder"></div>
                            <div class="placeholder"></div>
                            <div class="placeholder"></div>
                            <div class="placeholder"></div>
                        </div>
                        <div class="select__wrapper select__wrapper--small">
                            <div class="select select--small select--reviews">
                                <button class="select__main btn">
                                    Высокие оценки
                                    <div class="select__options">
                                        <div tabindex="0" class="select__option" data-id="high">
                                            <span>Высокие оценки</span>
                                        </div>
                                        <div tabindex="0" class="select__option" data-id="low">
                                            <span>Низкие оценки</span>
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="reviews-list__content" data-product-id="<?= $result['ID'] ?>"></div>
                <div class="loading loading--show">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Загрузка</span>
                    </div>
                    <div class="loading__text">
                        Загрузка
                    </div>
                </div>
            </div>
        </div>
        <? if ($isUserAuth) { ?>
            <div class="col-12 ps-0 pe-0 col-lg-6 pe-lg-5">
                <div class="product-reviews__container _product-reviews__form">
                    <h3>Оставьте отзыв</h3>
                </div>
                <div class="add-review card mt-4">
                    <div class="card-body">
                        <span>Ваша оценка</span>

                        <div class="add-review__stars">
                            <? for ($i = 0; $i < $result['RATING']['MAX_STARS']; $i++) { ?>
                                <div class="star star--large">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                    </svg>
                                </div>
                            <? } ?>
                        </div>

                        <form>
                            <div class="textarea add-review__dignities mb-4">
                                <label for="dignities" class="form-label">
                                    Достоинства
                                </label>
                                <textarea id="dignities" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="textarea add-review__flaws mb-4">
                                <label for="flaws" class="form-label">
                                    Недостатки
                                </label>
                                <textarea id="flaws" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="textarea add-review__comments mb-4">
                                <label for="comments" class="form-label">
                                    Комментарий
                                </label>
                                <textarea id="comments" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="input-file mb-4">
                                <label for="images">
                                    <svg width="10" height="17" fill="none" xmlns="http://www.w3.org/2000/svg" class="input-file__icon">
                                        <path d="M6.375 0a3.542 3.542 0 013.542 3.542v8.5a4.958 4.958 0 11-9.917 0V6.375h1.417v5.667a3.542 3.542 0 007.083 0v-8.5a2.125 2.125 0 10-4.25 0v8.5a.708.708 0 001.417 0V4.25h1.416v7.792a2.125 2.125 0 11-4.25 0v-8.5A3.542 3.542 0 016.375 0z" fill="currentColor"></path>
                                    </svg>
                                    <span class="input-file__description">Прикрепить файл (не более 5MB)</span>
                                </label>
                                <input id="images" multiple="multiple" size="5242880" type="file" accept="image/png, image/jpg, image/jpeg">
                            </div>
                            <button class="btn btn-primary" type="submit">Опубликовать отзыв</button>
                        </form>
                        <div class="add-review__success card-body">
                            <p>Спасибо, ваше мнение очень важно и поможет другим покупателям! Отзыв появится после прохождения модерации.</p>
                        </div>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
</div>
