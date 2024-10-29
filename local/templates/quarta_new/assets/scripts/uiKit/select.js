class Select {
    constructor(
        data = {
            selector: '.select',
            element: null,
            onSelect: (id) => {},
        }
    )
    {
        if (data.element) {
            this.select = data.element;
        } else {
            this.select = document.querySelector(data.selector);
        }
        this.selectButton = this.select.querySelector('.select__main');
        this.options = this.select.querySelectorAll('.select__option');
        this.placeholder = this.select.dataset.placeholder;
        this.initialValueId = this.select.dataset.initialId;

        this.isOpen = false;
        this.value = {};
        this.onSelect = data.onSelect;

        this.setInitialValue();
        this.hangEvents();
    }

    hangEvents() {
        this.selectButton.addEventListener('click', () => this.open());
        this.options.forEach(option => {
            option.addEventListener('click', (event) => {
                event.stopPropagation();
                this.selectOption(option);
            });
        })
        window.addEventListener('click', (event) => this.handleWindowClick(event));
    }

    handleWindowClick(event) {
        if (!this.select.contains(event.target) && this.isOpen) {
            this.close();
        }
    }

    resetValue() {
        if (this.placeholder) {
            this.setValueTextInHtml(this.placeholder);
            this.value = {};
            return;
        }
        this.setValue(this.initialValueId);
    }

    setInitialValue() {
        if (this.options.length === 0) {
            return;
        }
        if (this.initialValueId) {
            this.options.forEach(option => {
                const optionId = option.dataset.id;
                if (optionId === this.initialValueId) {
                    const optionTitle = option.querySelector('span').textContent.trim();
                    this.setValue(optionId, optionTitle);
                }
            })
            return;
        }
        if (this.placeholder) {
            this.setValueTextInHtml(this.placeholder);
            return;
        }
        if (!this.initialValueId) {
            const optionId = this.options[0].dataset.id;
            const optionTitle = this.options[0].querySelector('span').textContent.trim();
            this.setValue(optionId, optionTitle);
            this.initialValueId = this.value.id;
        }
    }

    getValue() {
        return this.value.id;
    }

    setValue(optionId, optionTitle = null) {
        let title = optionTitle;
        if (!title) {
            const option = this.select.querySelector(`.select__option[data-id="${optionId}"]`);
            title = option.textContent.trim();
        }
        this.value = { id: optionId, title };
        this.setValueTextInHtml(this.value.title);
    }

    setValueTextInHtml(value) {
        const text = this.selectButton.childNodes[0];
        text.nodeValue = value;
    }

    selectOption(option) {
        const optionId = option.dataset.id;
        if (optionId == this.value.id) {
            this.close();
            return;
        }
        const optionTitle = option.querySelector('span').textContent.trim();
        this.setValue(optionId, optionTitle);
        this.onSelect && this.onSelect(optionId);
        this.close();
    }

    open() {
        this.isOpen = true;
        this.select.classList.add('select--expanded');
    }

    close() {
        this.isOpen = false;
        this.select.classList.remove('select--expanded');
    }
}
