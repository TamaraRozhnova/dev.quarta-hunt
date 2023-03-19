class ProductQuestionForm {
    constructor() {
        this.ajaxUrl = '/ajax/form/productQuestionForm.php';
        this.questionFormSelector = '.product-ask__form';
        this.questionForm = document.querySelector(this.questionFormSelector);

        if (!this.questionForm) {
            return;
        }

        this.hangEvents();
        this.createElements();
    }

    hangEvents() {
        this.form = document.querySelector(`${this.questionFormSelector} form`);
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
            const response = await Request.fetch(this.ajaxUrl, this.getDataForSubmit());
            if (!response.errors) {
                this.showSuccessBlock();
                return;
            }
            Object.keys(response.errors).forEach(key => {
                if (key === 'message') {
                    this.showError(response.errors[key]);
                    return;
                }
                this.textarea.setError(response.errors[key]);
            })
        } catch (e) {
            this.showError('Ошибка запроса, попробуйте позже');
        } finally {
            this.setDisableSubmitButton(false);
        }
    }

    createElements() {
        this.textarea = new Input({
            wrapperSelector: '.product-ask__form .textarea',
            inputSelector: '#ask-text',
            validMask: /.{10}/,
            errorMessage: 'Не менее 10 символов'
        });

        this.inputProductId = new Input({
            inputSelector: `${this.questionFormSelector} input[name="productId"]`,
        });

        this.controls = {
            text: this.textarea,
            productId: this.inputProductId
        }
    }

    getDataForSubmit() {
        const data = {};
        Object.keys(this.controls).forEach(key => {
            data[key] = this.controls[key].getValue()
        });
        return data;
    }

    isValidData() {
        let isError = false;
        Object.keys(this.controls).forEach(key => {
            if (!this.controls[key].isValidValue()) {
                this.controls[key].setError();
                isError = true;
            }
        });
        return !isError;
    }

    setDisableSubmitButton(disabled) {
        const submitButton = this.form.querySelector('button[type="submit"]');
        submitButton.disabled = disabled;
    }

    showSuccessBlock() {
        const questionSuccessBlock = document.querySelector('.product-ask__success');
        this.questionForm.style.display = 'none';
        questionSuccessBlock.style.display = 'block';
    }

    createErrorHtml(errorText) {
        return `<div class="alert alert-danger product-ask__error mb-4" role="alert">${errorText}</div>`
    }

    showError(errorText) {
        this.form.insertAdjacentHTML('beforebegin', this.createErrorHtml(errorText));
    }

    clearError() {
        const errorElement = this.questionForm.querySelector('.product-ask__error');
        if (errorElement) {
            errorElement.remove();
        }
    }
}