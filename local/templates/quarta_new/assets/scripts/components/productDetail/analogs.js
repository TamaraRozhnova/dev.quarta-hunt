class Analogs {
    constructor() {
        this.addEventAnalogButton();
    }

    addEventAnalogButton() {
        const analogsButton = document.querySelector('.product__analog-link');
        if (analogsButton) {
            analogsButton.addEventListener('click', () => {
                this.scrollAnalogs();
            });
        }
    }

    scrollAnalogs() {
        const analogsBlock = document.querySelector('.analogs');
        analogsBlock.scrollIntoView({block: 'center', inline: 'center'});
    }
}