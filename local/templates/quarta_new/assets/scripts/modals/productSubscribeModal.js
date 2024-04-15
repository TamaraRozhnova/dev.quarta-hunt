class ProductSubscribeModal extends Modal {
    constructor(productId) {
        super({
            isCreateMode: true,
            title: 'Сообщить о поступлении'
        });

        this.productId = productId;
        this.url = '/ajax/form/productSubscribeForm.php'
        this.modalClass = 'subscribe-product-modal';

        this.createModal();
        this.hangEvents();
        super.open();
    }

    createModal() {
        const content = this.createModalHtml();
        this.setContent(content);
        this.createControls();
    }

    hangEvents() {
        this.modalForm = document.querySelector(`.${this.modalClass} form`);
        this.modalForm.addEventListener('submit', (event) => this.handleSubmit(event));
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
            const response = await Request.fetch(this.url, this.getDataForSubmit());
            if (!response.errors) {
                super.close();
                new ProductSubscribeSuccessModal();
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
        const submitButton = this.modalForm.querySelector('button[type="submit"]');
        submitButton.disabled = disabled;
    }

    showError(errorText) {
        const submitButton = this.modalForm.querySelector('button[type="submit"]');
        submitButton.insertAdjacentHTML('beforebegin', this.createErrorHtml(errorText));
    }

    clearError() {
        const errorElement = this.modalForm.querySelector('#error-message');
        if (errorElement) {
            errorElement.remove();
        }
    }

    createErrorHtml(errorText) {
        return `<div id="error-message" class="alert alert-danger my-4" role="alert">${errorText}</div>`
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
            data[key] = this.inputs[key].getValue()
        });
        return data;
    }

    createControls() {
        this.inputName = new Input({
            wrapperSelector: `.${this.modalClass} .input--name`,
            required: true,
            errorMessage: 'Поле обязательно к заполнению'
        });

        this.inputEmail = new Input({
            wrapperSelector: `.${this.modalClass} .input--email`,
            required: true,
            validMask: /^([a-zA-Z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/,
            errorMessage: 'Введите email в корректном формате'
        });

        this.inputPhone = new Input({
            wrapperSelector: `.${this.modalClass} .input--phone`,
            validMask: /^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/,
            mask: '+7 (###) ###-##-##',
            errorMessage: 'Телефон должен быть в указанном формате'
        });

        this.inputProductId = new Input({
            inputSelector: `.${this.modalClass} input[name="productId"]`,
        });

        this.inputs = {
            name: this.inputName,
            email: this.inputEmail,
            phone: this.inputPhone,
            productId: this.inputProductId
        }
    }

    createModalHtml() {
        return (
            `<div class="${this.modalClass}">
                <p>
                    Введите Ваши контактные данные, и мы уведомим Вас о поступлении данного
                    товара на склад.
                </p>
                <form>
                    <div class="input input--name my-4">
                        <label for="i_41" class="form-label">Имя</label>
                        <span class="input__container">
                            <input id="i_41" name="name" type="text" class="form-control"> 
                        </span>
                    </div>
                    <div class="input input--phone my-4">
                        <label for="i_42" class="form-label">Номер телефона</label>
                        <span class="input__container">
                            <input id="i_42" name="phone" type="text" placeholder="+7 (___)___-__-__" class="form-control">
                        </span>
                    </div>
                    <div class="input input--email my-4">
                        <label for="i_43" class="form-label">Email</label>
                        <span class="input__container">
                            <input id="i_43" name="email" type="text" placeholder="example@gmail.com" class="form-control">
                        </span>
                    </div>
                  
                    <input id="i_44" name="productId" value="${this.productId}" type="text" class="form-control" hidden>
            
                    <button type="submit" class="btn btn-primary w-100">Подтвердить</button>
                </form>
            </div>`
        )
    }
}