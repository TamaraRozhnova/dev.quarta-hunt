<form id="registration-form">
    <div class="input input--company mb-4 input--lg input--required">
        <label for="company" class="form-label">
            Компания
        </label>
        <span class="input__container">
            <input id="company" placeholder="Название вашей компании" type="text" class="form-control">
        </span>
    </div>
    <div class="input input--address mb-4 input--lg">
        <label for="address" class="form-label">
            Адрес
        </label>
        <span class="input__container">
            <input id="address" type="text" class="form-control">
        </span>
    </div>
    <div class="input input--marketplace mb-4 input--lg input--required">
        <label for="marketplace" class="form-label">
            Торговая площадка
        </label>
        <span class="info">
            <span>
                <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"
                     class="icon">
                    <path d="M8 16A8 8 0 108-.001 8 8 0 008 16zm.93-9.412l-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287H8.93zM8 5.5a1 1 0 110-2 1 1 0 010 2z"
                          fill="currentColor"></path>
                </svg>
            </span>
            <span class="tooltip">
                Название магазина, ссылка на сайт
            </span>
        </span>
        <span class="input__container">
            <input id="marketplace" type="text" class="form-control">
        </span>
    </div>
    <div class="input input--contact mb-4 input--lg input--required">
        <label for="contact" class="form-label">
            Контактное лицо
        </label>
        <span class="input__container">
            <input id="contact" type="text" class="form-control">
        </span>
    </div>
    <div class="input input--position mb-4 input--lg input--required">
        <label for="position" class="form-label">
            Должность
        </label>
        <span class="input__container">
            <input id="position" type="text" class="form-control">
        </span>
    </div>
    <div class="input input--phone mb-4 input--lg input--required">
        <label for="phone" class="form-label">
            Телефон для связи
        </label>
        <span class="input__container">
            <input type="text" id="phone" placeholder="+7 (___) ___-__-__" class="form-control">
        </span>
    </div>
    <div class="input input--email mb-4 input--lg input--required is-invalid">
        <label for="email" class="form-label">
            Email
        </label>
        <span class="input__container">
            <input id="email" placeholder="example@gmail.com" type="email" class="form-control">
        </span>
    </div>
    <div class="input input--password mb-4 input--lg input--required">
        <label for="password" class="form-label">
            Пароль
        </label>
        <span class="input__container">
            <input id="password" type="password" class="form-control">
        </span>
    </div>
    <div class="checkbox checkbox--promo form-check mb-4 wholesale__form-checkbox">
        <input id="promo" type="checkbox" class="form-check-input" checked>
        <label for="promo" class="form-check-label">
            Отправлять акции и предложения по email
        </label>
    </div>
    <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
        Отправить
    </button>
</form>

<small class="wholesale__form-consent">
    Нажимая кнопку «Отправить»,
    <a href="/polozhenie-o-konfidentsialnosti">
        я даю свое согласие на обработку моих персональных данных.
    </a>
</small>

<script>
    new RegisterForm();
</script>