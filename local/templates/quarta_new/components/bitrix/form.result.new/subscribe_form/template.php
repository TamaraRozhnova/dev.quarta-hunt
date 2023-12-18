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

<?if (!empty($arResult["FORM_NOTE"])) {?>    
    <div id="subscribe-window" class="modal show">
        <div class="subscribe-window__wrapper">

            <div class="modal__close">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-x" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </div>

            <div class="modal-content">
                <div class="modal-body">
                    <p class="subscribe-success"><?=GetMessage("FORM_SUCCESS")?></p>
                </div>
            </div>
        </div>
    </div>
    <script>
        new Modal({
            modalSelector: "#subscribe-window"
        }).open();        
    </script>
<?}?>