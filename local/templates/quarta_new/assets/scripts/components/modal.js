class Modal {

    constructor(modalOpenElementSelector, modalSelector = '.modal') {
        this.modalElement = document.querySelector(modalSelector);
        this.openModalElement = document.querySelector(modalOpenElementSelector);
        this.closeModalElement = this.modalElement.querySelector('.modal__close');
        this.modalContentElement = this.modalElement.querySelector('.modal-content');

        this.#hangEvents();
    }

    #hangEvents() {
        this.openModalElement.addEventListener('click', () => this.open());
        this.closeModalElement.addEventListener('click', () => this.close());
        window.addEventListener('click', (event) => this.handleWindowClick(event));
    }

    open() {
        this.createOverlay();
        this.modalElement.classList.add('show');
    }

    close() {
        this.removeOverlay();
        this.modalElement.classList.remove('show');
        this.onClose();
    }

    createOverlay() {
        const modalOverlay = document.createElement('div');
        modalOverlay.classList.add('modal-overlay');
        document.body.appendChild(modalOverlay);
    }

    removeOverlay() {
        const overlay = document.querySelector('.modal-overlay');
        if (overlay) {
            overlay.remove();
        }
    }

    handleWindowClick(event) {
        if (!this.modalContentElement.contains(event.target) && !this.openModalElement.contains(event.target)) {
            this.close();
        }
    }

    onClose() {}
}