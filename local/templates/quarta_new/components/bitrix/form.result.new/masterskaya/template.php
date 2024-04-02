<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

global $APPLICATION;

use Bitrix\Main\Engine\CurrentUser;

?>

<form id="form" id="masterskaya-form" class="masterskaya-form" data-form-id="<?= $arResult['arForm']['ID'] ?>">
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="input input--full-name mb-4 input--required">
                <label for="full-name" class="form-label">
                    ФИО
                </label>
                <span class="input__container">
                    <input
                        id="full-name"
                        type="text"
                        class="form-control"
                        data-field-id="form_<?= $arResult['CONTROLS'][0]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][0]['ID'] ?>"
                    />
                </span>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="input input--phone mb-4 input--required">
                <label for="phone" class="form-label">
                    Телефон:
                </label>
                <span class="input__container">
                    <input
                        id="phone"
                        type="text"
                        class="form-control"
                        placeholder="+7 (___)___-__-__"
                        data-field-id="form_<?= $arResult['CONTROLS'][1]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][1]['ID'] ?>"
                    />
                </span>
            </div>
        </div>
    </div>

    <div class="input textarea textarea--letter mb-4">
        <label for="letter" class="form-label">
        Опишите суть проблемы:
        </label>
        <textarea
            id="letter"
            rows="3"
            class="form-control textarea"
            data-field-id="form_<?= $arResult['CONTROLS'][2]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][2]['ID'] ?>"
        ></textarea>
    </div>

    <?=$arResult['CAPTCHA']?>

    <button type="submit" class="btn btn-secondary mb-4">
        Отправить запрос
    </button>

    <div class="row">
        <small>Нажимая кнопку «Отправить запрос», 
            <a href="/privacy-statement/">я даю свое согласие на обработку моих персональных данных.</a>
            <a href="/about/oferta/">а так же подтверждаю своё согласие с офертой</a>
        </small>
    </div>

</form>