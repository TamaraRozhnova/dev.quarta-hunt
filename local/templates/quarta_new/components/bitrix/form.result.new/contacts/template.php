<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>


<form id="form" class="contacts-form" data-form-id="<?= $arResult['arForm']['ID'] ?>">
    <div class="input input--full-name mb-4 input--required">
        <label for="full-name" class="form-label">
            Фамилия Имя Отчество
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
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="input input--email mb-4 input--required">
                <label for="email" class="form-label">
                    Email
                </label>
                <span class="input__container">
                    <input
                        id="email"
                        type="text"
                        class="form-control"
                        data-field-id="form_<?= $arResult['CONTROLS'][1]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][1]['ID'] ?>"
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
                        data-field-id="form_<?= $arResult['CONTROLS'][2]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][2]['ID'] ?>"
                    />
                </span>
            </div>
        </div>
    </div>

    <div class="textarea textarea--letter mb-4">
        <label for="letter" class="form-label">
            Задать вопрос
        </label>
        <textarea
            id="letter"
            rows="3"
            class="form-control"
            data-field-id="form_<?= $arResult['CONTROLS'][3]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][3]['ID'] ?>"
        ></textarea>
    </div>
    <button type="submit" class="btn btn-primary w-100">
        Отправить
    </button>
</form>