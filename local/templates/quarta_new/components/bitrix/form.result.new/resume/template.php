<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<form class="resume-form" data-form-id="<?= $arResult['arForm']['ID'] ?>">
    <div class="input input--full-name mb-3">
        <label for="full-name" class="form-label">
            Фамилия Имя Отчество
        </label>
        <span class="input__container">
            <input
                id="full-name"
                type="text"
                class="form-control"
                placeholder="Фамилия Имя Отчество"
                data-field-id="form_<?= $arResult['CONTROLS'][0]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][0]['ID'] ?>"
            />
        </span>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="input input--email mb-3">
                <label for="email" class="form-label">
                    Email
                </label>
                <span class="input__container">
                    <input
                        id="email"
                        type="text"
                        class="form-control"
                        placeholder="Email"
                        data-field-id="form_<?= $arResult['CONTROLS'][1]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][1]['ID'] ?>"
                    />
                </span>
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="input input--phone mb-3">
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
    <div class="textarea textarea--letter mb-3">
        <label for="letter" class="form-label">
            Сопроводительное письмо
        </label>
        <textarea
            id="letter"
            rows="3"
            class="form-control"
            placeholder="Ваше сообщение..."
            data-field-id="form_<?= $arResult['CONTROLS'][3]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][3]['ID'] ?>"
        ></textarea>
    </div>
    <div class="col-12 col-sm-6">
        <div class="input input--link mb-3">
            <label for="link" class="form-label">
                Ссылка на резюме
            </label>
            <span class="input__container">
                <input
                    id="link"
                    type="text"
                    class="form-control"
                    placeholder="https://..."
                    data-field-id="form_<?= $arResult['CONTROLS'][4]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][4]['ID'] ?>"
                />
            </span>
        </div>
    </div>
    <div class="input-file input--resume mb-3">
        <label for="resume">
            <svg width="10" height="17" fill="none" xmlns="http://www.w3.org/2000/svg" class="input-file__icon">
                <path d="M6.375 0a3.542 3.542 0 013.542 3.542v8.5a4.958 4.958 0 11-9.917 0V6.375h1.417v5.667a3.542 3.542 0 007.083 0v-8.5a2.125 2.125 0 10-4.25 0v8.5a.708.708 0 001.417 0V4.25h1.416v7.792a2.125 2.125 0 11-4.25 0v-8.5A3.542 3.542 0 016.375 0z"
                      fill="currentColor"></path>
            </svg>
            <span class="input-file__description">Приложить резюме в формате .docx, .pdf</span>
        </label>
        <input
            id="resume"
            size="5242880"
            type="file"
            accept=".doc,.docx,.pdf"
            data-field-id="form_<?= $arResult['CONTROLS'][5]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][5]['ID'] ?>"
        />
    </div>
    <input
        id="vacancy-name"
        type="hidden"
        value="<?= $arParams['VACANCY_NAME'] ?>"
        data-field-id="form_<?= $arResult['CONTROLS'][6]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][6]['ID'] ?>"
    />
    <button type="submit" class="btn btn-primary w-100">
        Отправить
    </button>
</form>