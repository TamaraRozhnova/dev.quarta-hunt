class Counter {

    constructor(
        data = {
            selectorMinusButton: '',
            selectorPlusButton: '',
            selectorInput: '',
            minValue: 0,
            maxValue: 1000,
            initialValue: 0,
            blockChangeState: false,
            disabledInput: false,
            onChangeInput: (value, counterInstance) => {},
            onPlus: (value, counterInstance) => {},
            onMinus: (value, counterInstance) => {}
        }
    )
    {
        this.inputSelector = data.selectorInput;
        this.minusButton = document.querySelector(data.selectorMinusButton);
        this.plusButton = document.querySelector(data.selectorPlusButton);
        this.minValue = data.minValue;
        this.maxValue = data.maxValue;
        this.initialValue = data.initialValue;
        this.blockChangeState = data.blockChangeState;
        this.disabledInput = data.disabledInput;
        this.debounceTime = 1500;

        this.onChangeInput = data.onChangeInput;
        this.onPlus = data.onPlus;
        this.onMinus = data.onMinus;

        this.hangEvents();
    }

    disableButtons() {
        this.minusButton.style.pointerEvents = 'none';
        this.plusButton.style.pointerEvents = 'none';
    }

    activateButtons() {
        this.minusButton.style.pointerEvents = 'all';
        this.plusButton.style.pointerEvents = 'all';
    }

    setMinValue(value) {
        this.minValue = value;
    }

    setMaxValue(value) {
        this.maxValue = value;
    }

    setValue(value) {
        if (value < this.minValue) {
            this.input.setValue(this.minValue);
            return;
        }
        if (value > this.maxValue) {
            this.input.setValue(this.maxValue);
            return;
        }
        this.input.setValue(value);
    }

    getValue() {
        return this.input.getValue();
    }

    hangEvents() {
        this.input = new Input({
            inputSelector: this.inputSelector,
            initialValue: this.initialValue,
            disabled: this.disabledInput,
            onChange: (value) => this.handleChangeInput(value)
        });
        this.handleDecreaseCounter();
        this.handleIncreaseCounter();
    }

    handleChangeInput(value) {
        if (value < this.minValue) {
            this.input.setValue(this.minValue);
        }
        if (value > this.maxValue) {
            this.input.setValue(this.maxValue);
        }
        if (this.debouceTimeout) {
            clearTimeout(this.debouceTimeout);
        }
        if (this.onChangeInput) {
            this.debouceTimeout = setTimeout(() => {
                this.onChangeInput(this.input.getValue(), this);
            }, this.debounceTime);
        }
    }

    handleIncreaseCounter() {
        this.plusButton.addEventListener('click', () => {
            let value = this.input.getValue();
            if (value == this.maxValue) {
                return;
            }
            if (!this.blockChangeState) {
                value++;
                this.input.setValue(value);;
            }
            this.onPlus && this.onPlus(+value, this);
        });
    }

    handleDecreaseCounter() {
        this.minusButton.addEventListener('click', () => {
            let value = this.input.getValue();
            if (value == this.minValue) {
                return;
            }
            if (!this.blockChangeState) {
                value--;
                this.input.setValue(value);
            }
            this.onMinus && this.onMinus(+value, this);
        });
    }
}