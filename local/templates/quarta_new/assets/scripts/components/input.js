class Input {

    constructor(
        inputSelector,
        options = {onChange: () => {}, onClear: () => {}}
    ) {
        this.inputElement = document.querySelector(inputSelector);
        this.clearButtonElement = this.inputElement.querySelector(`${inputSelector} + .input__clear`);
        this.options = options;

        this.hangEvents()
    }

    hangEvents() {
        this.handleChange();
        this.handleClear();
    }

    getValue() {
        return this.inputElement.value;
    }

    setValue(value) {
        this.inputElement.value = value;
        this.options.onChange();
    }

    clear() {
        this.inputElement.value = '';
        this.clearButtonElement.classList.remove('show');
        this.options.onClear();
    }

    handleChange() {
        this.inputElement.addEventListener('input', () => {
            this.toggleClearButton();
            this.options.onChange();
        });
    }

    handleClear() {
        if (!this.clearButtonElement) {
            return;
        }
        this.clearButtonElement.addEventListener('click', () => this.clear());
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