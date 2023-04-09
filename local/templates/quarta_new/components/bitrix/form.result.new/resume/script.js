window.addEventListener('DOMContentLoaded', () => {
    class ResumeForm {
        constructor() {
            this.ajaxUrl = '/ajax/form/resumeForm.php'
            this.formSelector = '.resume-form';
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
            const successBlock = document.querySelector('.resume-form__success-message');
            successBlock.scrollIntoView({ block: 'center', inline: 'center' });
        }

        createSuccessHtml() {
            return `<p class="resume-form__success-message success-message">Заявка успешно отправлена!</p>`
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
            Object.keys(this.inputs).forEach(key => {
                if (key === 'resume') {
                    return;
                }
                if (!this.inputs[key].isValidValue()) {
                    this.inputs[key].setError();
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
                if (key === 'resume') {
                    value = value[0];
                }
                formData.append(fieldId, value);
            });
            return formData;
        }

        createControls() {
            this.inputFullName = new Input({
                wrapperSelector: `${this.formSelector} .input--full-name`,
                required: true,
                errorMessage: 'Поле обязательно к заполнению'
            });
            this.inputEmail = new Input({
                wrapperSelector: `${this.formSelector} .input--email`,
                required: true,
                validMask: /^([a-z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/,
                errorMessage: 'Введите email в корректном формате'
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
            this.inputLink = new Input({
                wrapperSelector: `${this.formSelector} .input--link`,
            });
            this.inputResume = new InputFile({
                wrapperSelector: '.input--resume',
                maxFiles: 1,
                maxSize: 5242880,
                showAddedFiles: true,
            });
            this.inputVacancy = new Input({
                inputSelector: `${this.formSelector} #vacancy-name`,
            });

            this.inputs = {
                fullName: this.inputFullName,
                email: this.inputEmail,
                phone: this.inputPhone,
                letter: this.inputLetter,
                link: this.inputLink,
                resume: this.inputResume,
                vacancy: this.inputVacancy
            }
        }
    }

    new ResumeForm();
})