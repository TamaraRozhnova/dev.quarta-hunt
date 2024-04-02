window.addEventListener('DOMContentLoaded', () => {
    class MasterskayaForm {
        constructor() {
            this.ajaxUrl = '/ajax/form/masterskayaForm.php'
            this.formSelector = '.masterskaya-form';
            this.form = document.querySelector(this.formSelector);

            this.anchorForm = document.querySelector('.go-to-form')

            this.createControls();
            this.hangEvents();

        }

        hangEvents() {
            this.form.addEventListener('submit', (event) => this.handleSubmit(event));
            this.anchorForm.addEventListener('click', (e) => {
                e.preventDefault();
                this.form.scrollIntoView({behavior: "smooth", block: "center", inline: "start"})
            })
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
                this.showSuccess();
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
            const successBlock = document.querySelector('.warranty-form__success-message');
            successBlock.scrollIntoView({ block: 'center', inline: 'center' });
        }

        createSuccessHtml() {
            return `<p class="warranty-form__success-message success-message">Заявка успешно отправлена!</p>`
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
                if (key === 'warranty') {
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
            const formData = new FormData(this.form);
            formData.append('formId', this.form.dataset.formId);
            Object.keys(this.inputs).forEach(key => {
                const fieldId = this.inputs[key].getDataAttribute('fieldId');
                let value = this.inputs[key].getValue();
                if (!value) {
                    return;
                }
                if (key === 'warranty') {
                    value = value[0];
                }
                formData.append(fieldId, value);
            });
            console.log(...formData)
            return formData;
        }

        createControls() {
            this.inputFullName = new Input({
                wrapperSelector: `${this.formSelector} .input--full-name`,
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

            this.inputLetter = new Input({
                wrapperSelector: `${this.formSelector} .textarea--letter`,
                inputSelector: '#letter'
            });
        
            this.inputs = {
                fullName: this.inputFullName,
                phone: this.inputPhone,
                letter: this.inputLetter,
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

    new MasterskayaForm();
})