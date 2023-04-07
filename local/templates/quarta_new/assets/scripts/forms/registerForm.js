class RegisterForm {
    constructor() {
        this.ajaxUrl = '/ajax/form/auth/registrationForm.php'
        this.formSelector = '#registration-form';
        this.form = document.querySelector(this.formSelector);

        this.createControls();
        this.hangEvents();
    }

    hangEvents() {
        this.form.addEventListener('submit', (event) => this.handleSubmit(event));
        this.hangTooltipsEvents();
    }

    async handleSubmit(event) {
        event.preventDefault();
        this.setDisableSubmitButton(true);
        this.clearError();
        if (!this.isValidData()) {
            this.setDisableSubmitButton(false);
            return;
        }
        try {
            const response = await Request.fetch(this.ajaxUrl, this.getDataForSubmit());
            if (!response.errors) {
                this.showSuccess();
                return;
            }
            Object.keys(response.errors).forEach(key => {
                if (key === 'message') {
                    this.showError(response.errors[key]);
                    return;
                }
                this.inputs[key].setError(response.errors[key]);
            })
        } catch (e) {
            this.showError('Ошибка запроса, попробуйте позже');
        } finally {
            this.setDisableSubmitButton(false);
        }
    }

    setDisableSubmitButton(disabled) {
        const submitButton = this.form.querySelector('button[type="submit"]');
        submitButton.disabled = disabled;
    }

    showSuccess() {
        const extra = document.querySelector('.wholesale__form-consent');
        this.form.insertAdjacentHTML('afterend', this.createSuccessHtml());
        this.form.remove();
        extra.remove();
        this.scrollToSuccessElement();
    }

    scrollToSuccessElement() {
        const successBlock = document.querySelector('.success-message');
        successBlock.scrollIntoView({ block: 'center', inline: 'center' });
    }

    createSuccessHtml() {
        return `<p class="success-message">Спасибо за регистрацию! Ваш аккаунт будет активирован позже</p>`
    }

    showError(errorText) {
        this.form.insertAdjacentHTML('afterend', this.createErrorHtml(errorText));
    }

    clearError() {
        const errorElement = document.querySelector('.error-message');
        if (errorElement) {
            errorElement.remove();
        }
    }

    createErrorHtml(errorText) {
        return `<div class="error-message alert alert-danger" role="alert">${errorText}</div>`
    }

    isValidData() {
        let isError = false;
        Object.keys(this.inputs).forEach(key => {
            if (!this.inputs[key].isValidValue()) {
                this.inputs[key].setError();
                isError = true;
            }
        });
        return !isError;
    }

    getDataForSubmit() {
        const data = {};
        Object.keys(this.inputs).forEach(key => {
            data[key] = this.inputs[key].getValue();
        });
        data.promo = this.checkboxPromo.checked;
        return data;
    }

    createControls() {
        this.inputCompany = new Input({
            wrapperSelector: `${this.formSelector} .input--company`,
            required: true,
            errorMessage: 'Поле обязательно к заполнению'
        });
        this.inputAddress = new Input({
            wrapperSelector: `${this.formSelector} .input--address`,
        });
        this.inputMarketPlace = new Input({
            wrapperSelector: `${this.formSelector} .input--marketplace`,
            required: true,
            errorMessage: 'Поле обязательно к заполнению'
        });
        this.inputContact = new Input({
            wrapperSelector: `${this.formSelector} .input--contact`,
            required: true,
            errorMessage: 'Поле обязательно к заполнению'
        });
        this.inputPosition = new Input({
            wrapperSelector: `${this.formSelector} .input--position`,
            required: true,
            errorMessage: 'Поле обязательно к заполнению'
        });
        this.inputPhone = new Input({
            wrapperSelector: `${this.formSelector} .input--phone`,
            required: true,
            validMask: /^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/,
            mask: '+7 (###) ###-##-##',
            errorMessage: 'Телефон должен быть в указанном формате'
        });
        this.inputEmail = new Input({
            wrapperSelector: `${this.formSelector} .input--email`,
            required: true,
            validMask: /^([a-z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/,
            errorMessage: 'Введите email в корректном формате'
        });
        this.inputPassword = new Input({
            wrapperSelector: `${this.formSelector} .input--password`,
            required: true,
            validMask: /.{8,}/,
            errorMessage: 'Пароль должен содержать не менее 8 символов'
        });
        this.checkboxPromo = this.form.querySelector('#promo');

        this.inputs = {
            company: this.inputCompany,
            address: this.inputAddress,
            marketPlace: this.inputMarketPlace,
            contact: this.inputContact,
            position: this.inputPosition,
            phone: this.inputPhone,
            email: this.inputEmail,
            password: this.inputPassword,
        }
    }

    hangTooltipsEvents() {
        const tooltipContainers = this.form.querySelectorAll('.info');
        tooltipContainers.forEach(container => {
            const wrapperElement = container.querySelector('span:first-child');
            const tooltipElement = container.querySelector('.tooltip');
            new Tooltip(wrapperElement, tooltipElement)
        })
    }
}