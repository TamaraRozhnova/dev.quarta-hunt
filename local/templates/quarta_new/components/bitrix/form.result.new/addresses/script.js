window.addEventListener('DOMContentLoaded', () => {
    class AddressesForm {
        constructor() {
            this.ajaxUrl = '/ajax/form/addressesForm.php'
            this.formSelector = '.addresses-form';
            this.form = document.querySelector(this.formSelector);

            this.createControls();
            this.hangEvents();
        }

        hangEvents() {
            this.form.addEventListener('submit', (event) => this.handleSubmit(event));
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
                const response = await Request.fetchWithFormData(this.ajaxUrl, this.getDataForSubmit());
                if (!response) {
                    throw new Error();
                }
                window.location.href = "/cabinet/";
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
            this.form.insertAdjacentHTML('afterend', this.createSuccessHtml());
            this.form.remove();
            this.scrollToSuccessElement();
        }

        scrollToSuccessElement() {
            const successBlock = document.querySelector('.addresses-form__success-message');
            successBlock.scrollIntoView({ block: 'center', inline: 'center' });
        }

        createSuccessHtml() {
            return `<p class="addresses-form__success-message success-message">Успешно!</p>`
        }

        showError(errorText) {
            this.form.insertAdjacentHTML('afterbegin', this.createErrorHtml(errorText));
        }

        clearError() {
            const errorElement = document.querySelector('.error-message');
            if (errorElement) {
                errorElement.remove();
            }
        }

        createErrorHtml(errorText) {
            return `<div class="error-message alert alert-danger mb-3" role="alert">${errorText}</div>`
        }

        isValidData() {
            let isError = false;
            Object.keys(this.requiredInputs).forEach(key => {
                if (key === 'addresses') {
                    return;
                }
                if (!this.requiredInputs[key].isValidValue()) {
                    this.requiredInputs[key].setError();
                    isError = true;
                }
            });
            return !isError;
        }

        getDataForSubmit() {
            const formData = new FormData();
            formData.append('formId', this.form.dataset.formId);
            Object.keys(this.inputs).forEach(key => {
                const fieldId = this.inputs[key].getDataAttribute('fieldId');
                let value = this.inputs[key].getValue();
                if (!value) {
                    return;
                }
                if (key === 'contacts') {
                    value = value[0];
                }
                formData.append(fieldId, value);
            });
            return formData;
        }

        createControls() {
            this.inputCity = new Input({
                wrapperSelector: `${this.formSelector} .input--city`,
                required: true,
                errorMessage: 'Поле обязательно к заполнению'
            });

            this.inputStreet = new Input({
                wrapperSelector: `${this.formSelector} .input--street`,
                required: true,
                errorMessage: 'Поле обязательно к заполнению'
            });

            this.inputHome = new Input({
                wrapperSelector: `${this.formSelector} .input--home`,
                required: true,
                errorMessage: 'Поле обязательно к заполнению'
            });
            
            this.inputNumberHome = new Input({
                wrapperSelector: `${this.formSelector} .input--number_home`,
                required: true,
                errorMessage: 'Поле обязательно к заполнению'
            });

            this.inputPersonalZip = new Input({
                wrapperSelector: `${this.formSelector} .input--zip`,
                required: true,
                errorMessage: 'Поле обязательно к заполнению'
            });
            
            this.inputs = {
                city: this.inputCity,
                street: this.inputStreet,
                home: this.inputHome,
                numberHome: this.inputNumberHome,
                zip: this.inputPersonalZip
            }

            this.requiredInputs = [];

            Object.keys(this.inputs).forEach( (key,value) => {

                if (this.inputs[key].required == true) {
                    this.requiredInputs.push(
                        this.inputs[key]
                    )
                }
                
            });

        }
    }

    new AddressesForm();
})