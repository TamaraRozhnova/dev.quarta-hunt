<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<section class="subscribe">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 subscribe__title">
                <h2>
                    <small>Подписаться на новости</small><br/>
                    Будьте в курсе событий!
                </h2>
            </div>

            <div class="col-12 col-lg-6 subscribe__form-wr">
                <div class="subscribe__form">
                    <?= $arResult['FORM_HEADER'] ?>
                    <div class="input input--lg">
                        <span class="input__container">
                            <input id="i_0"
                                   name="form_email_1"
                                   placeholder="Введите email"
                                   type="email"
                                   class="form-control bg-white"
                                   required
                            >
                        </span>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-lg-6">
                            <div class="checkbox form-check checkbox--large">
                                <input id="i_1" type="checkbox" class="form-check-input" required>
                                <label for="i_1" class="form-check-label">
                                    <a href="/privacy-statement">
                                        Я соглашаюсь на обработку персональных данных
                                    </a>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 subscribe__button">
                            <input name="web_form_submit"
                                   type="submit"
                                   class="btn btn-primary btn-lg"
                                   value="Подписаться"
                            />
                        </div>
                    </div>
                    <?= $arResult['FORM_FOOTER'] ?>
                </div>
            </div>
        </div>
    </div>
</section>