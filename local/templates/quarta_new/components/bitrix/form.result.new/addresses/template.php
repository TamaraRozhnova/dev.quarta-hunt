<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>


<form id="form" class="addresses-form" data-form-id= "5">

    <div class="input input--city mb-4 input--required">
        <label for="city" class="form-label">
            Город
        </label>
        <span class="input__container">
            <input
                id="city"
                type="text"
                class="form-control"
                data-field-id = "PERSONAL_CITY"
            />
        </span>
    </div>

    <div class="input input--street mb-4 input--required">
        <label for="street" class="form-label">
            Улица
        </label>
        <span class="input__container">
            <input
                id="street"
                type="text"
                class="form-control"
                data-field-id = "PERSONAL_STREET"
            />
        </span>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="input input--home mb-4 input--required">
                <label for="home" class="form-label">
                    Дом
                </label>
                <span class="input__container">
                    <input
                        id="home"
                        type="text"
                        class="form-control"
                        data-field-id = "PERSONAL_HOME"
                    />
                </span>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="input input--number_home mb-4 input--required">
                <label for="number_home" class="form-label">
                    Квартира
                </label>
                <span class="input__container">
                    <input
                        id="number_home"
                        type="text"
                        class="form-control"
                        data-field-id = "PERSONAL_MAILBOX"
                    />
                </span>
            </div>
        </div>
    </div>

    <div class="input input--zip mb-4 input--required">
        <label for="zip" class="form-label">
            Почтовый индекс
        </label>
        <span class="input__container">
            <input
                id="zip"
                type="text"
                class="form-control"
                data-field-id = "PERSONAL_ZIP"
            />
        </span>
    </div>

    <div class="col-6 address__btn">
        <button type="submit" class="btn btn-primary w-100">
            Сохранить изменения
        </button>
    </div>


</form>