class Select {
    constructor(
        data = {
            selector: '.select',
            initialValue: 0,
            onSelect: (id) => {}
        }
    )
    {
        this.select = document.querySelector(data.selector);
        this.selectButton = this.select.querySelector('.select__main');
        this.options = this.select.querySelectorAll('.select__option');

        this.isOpen = false;
        this.value = {};
        this.onSelect = data.onSelect;

        this.setInitialValue(data.initialValue);
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

    setInitialValue(value) {
        if (this.options.length === 0) {
            return;
        }
        if (!value) {
            const optionId = this.options[0].dataset.id;
            const optionTitle = this.options[0].querySelector('span').textContent.trim();
            this.setValue(optionId, optionTitle);
            return;
        }
        this.options.forEach(option => {
            const optionId = option.dataset.id;
            if (optionId === value) {
                const optionTitle = option.querySelector('span').textContent.trim();
                this.setValue(optionId, optionTitle);
            }
        })
    }

    getValue() {
        return this.value.id;
    }

    setValue(optionId, optionTitle) {
        this.value = { id: optionId, title: optionTitle };
        const text = this.selectButton.childNodes[0];
        text.nodeValue = this.value.title;
    }

    selectOption(option) {
        const optionId = option.dataset.id;
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