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
                    <small>Подписаться на новости</small><br>
                    Будьте в курсе событий!
                </h2>
            </div>

            <div class="col-12 col-lg-6 subscribe__form-wr">
                <div class="subscribe__form">
                    <?=preg_replace('/<input(.*)\/>/U', '<input$1>', $arResult['FORM_HEADER']); ?>
                    <div class="input input--lg">
                        <span class="input__container">
                            <input id="i_0"
                                   name="form_email_1"
                                   placeholder="Введите email"
                                   type="email"
                                   class="form-control bg-white"
                                   required
                            >
                            <span class="svg-x-icon"></span>
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
                            >
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
            <div class="modal-content">
                <div class="modal-body">
                    <div class="subscribe-window__content">
                        <div class="subscribe-window-ico">
                            <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                viewBox="0 0 60 60" xml:space="preserve">
                            <path d="M0,8.5v2.291v38.418V51.5h60v-2.291V10.791V8.5H0z M36.625,30.564l-5.446,5.472c-0.662,0.615-1.698,0.614-2.332,0.026
                                l-5.473-5.498l0.048-0.047L3.647,10.5h52.719L36.577,30.518L36.625,30.564z M20.524,30.533L2,48.355V11.923L20.524,30.533z
                                M21.934,31.95l5.523,5.549c0.709,0.661,1.619,0.993,2.533,0.993c0.923,0,1.85-0.339,2.581-1.02l5.496-5.522L56.304,49.5H3.686
                                L21.934,31.95z M39.477,30.534L58,11.922v36.433L39.477,30.534z"/>
                            </svg>
                        </div>
                        <div class="subscribe-window-text">
                            <h2>
                                <?=GetMessage("FORM_SUCCESS_TITLE")?>
                            </h2>
                            <p class="subscribe-success">
                                <?=GetMessage("FORM_SUCCESS_SUBTEXT")?>
                            </p>
                        </div>
                        <div class="subscribe-window-btn">
                            <a href = '/catalog/' class="btn btn-primary btn-lg">
                                <?=GetMessage("FORM_SUCCESS_BEGIN_ORDERING")?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal__close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-x" viewBox="0 0 16 16">
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
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