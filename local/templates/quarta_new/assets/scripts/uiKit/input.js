class Input {

    constructor(
        data = {
            wrapperSelector: '',
            inputSelector: '',
            initialValue: '',
            debounceTime: 2000,
            withDebounce: false,
            required: false,
            validMask: null,
            mask: null,
            errorMessage: 'Поле обязательно для заполнения',
            disabled: false,
            onChange: (value) => {},
            onClear: () => {}
        }
    ) {
        this.inputWrapperSelector = data.wrapperSelector;
        this.inputWrapperElement = document.querySelector(this.inputWrapperSelector);
        this.inputSelector = data.inputSelector || `${this.inputWrapperSelector} input`;
        this.inputElement = document.querySelector(this.inputSelector);
        this.clearButtonElement = document.querySelector(`${this.inputSelector} + .input__clear`);
        this.required = data.required;
        this.errorMessage = data.errorMessage;
        this.withDebounce = data.withDebounce;
        this.debouceTime = data.debounceTime || 2000;
        this.validMask = data.validMask;
        this.onChange = data.onChange;
        this.onClear = data.onClear;

        this.setMask(data.mask);
        this.setRequired();
        this.setDisabled(data.disabled);
        this.setInitialValue(data.initialValue);
        this.hangEvents()
    }

    hangEvents() {
        this.handleChange();
        this.handleClear();
        this.handleFocus();
        this.handleBlur();
    }

    setMask(mask) {
        if (!mask) {
            return;
        }
        const inputMask = new Inputmask(mask);
        inputMask.mask(this.inputSelector);
    }

    setRequired() {
        if (this.required && this.inputWrapperElement) {
            this.inputWrapperElement.classList.add('input--required');
        }
    }

    getValue() {
        return this.inputElement.value;
    }

    setDisabled(value) {
        this.inputElement.disabled = value;
    }

    setInitialValue(value) {
        if (value) {
            this.setValue(value);
        }
    }

    setValue(value) {
        this.inputElement.value = value;
    }

    clear() {
        if (this.clearButtonElement) {
            this.clearButtonElement.classList.remove('show');
        }
        this.inputElement.value = '';
        this.onClear && this.onClear();
    }

    handleChange() {
        this.inputElement.addEventListener('input', () => {
            this.toggleClearButton();
            if (this.debouceTimeout) {
                clearTimeout(this.debouceTimeout);
            }
            if (!this.onChange) {
                return;
            }
            const newValue = this.getValue();
            if (this.withDebounce) {
                this.debouceTimeout = setTimeout(() => {
                    this.onChange(newValue, this);
                }, this.debouceTime);
                return;
            }
            this.onChange(newValue);
        });
    }

    handleFocus() {
        this.inputElement.addEventListener('focus', () => {
            this.clearError();
        })
    }

    handleBlur() {
        this.inputElement.addEventListener('blur', () => {
            if (!this.isValidValue()) {
                this.setError();
            }
        })
    }

    handleClear() {
        if (!this.clearButtonElement) {
            return;
        }
        this.clearButtonElement.addEventListener('click', () => this.clear());
    }

    setError(message) {
        if (this.inputWrapperElement) {
            this.inputWrapperElement.classList.add('is-invalid');
        }
        this.inputElement.classList.add('is-invalid');
        if (document.querySelector(`${this.inputWrapperSelector} .invalid-feedback`)) {
            return;
        }
        const errorElement = document.createElement('div');
        errorElement.classList.add('invalid-feedback');
        if (message) {
            errorElement.textContent = message;
        } else {
            errorElement.textContent = this.errorMessage;
        }
        this.inputElement.insertAdjacentElement('afterend', errorElement);
    }

    clearError() {
        this.inputElement.classList.remove('is-invalid');
        if (this.inputWrapperElement) {
            this.inputWrapperElement.classList.remove('is-invalid');
        }
        const errorElement = document.querySelector(`${this.inputWrapperSelector} .invalid-feedback`);
        if (errorElement) {
            errorElement.remove();
        }
    }

    isValidValue() {
        const value = this.getValue();
        if (this.required && !value) {
            return false;
        }
        if (value && this.validMask && !this.validMask.test(value)) {
            return false;
        }
        return true;
    }

    toggleClearButton() {
        if (!this.clearButtonElement) {
            return;
        }
        const currentValue = this.getValue();
        if (currentValue) {
            this.clearButtonElement.classList.add('show');
            return;
        }
        this.clearButtonElement.classList.remove('show');
    }
}