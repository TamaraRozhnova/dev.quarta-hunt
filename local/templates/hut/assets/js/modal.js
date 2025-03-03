class Modal {

    constructor(
        data = {
            modalOpenElementSelector: null,
            modalSelector: '.modal',
            isCreateMode: false,
            isVideoMode: false,
            isLarge: false,
            title: null
        }
    )
    {
        this.isVideoMode = data.isVideoMode;
        this.isLarge = data.isLarge;
        this.isCreateMode = data.isCreateMode;
        if (this.isCreateMode) {
            this.modalTitle = data.title;
            this.modalElement = this.#createModal();
        } else {
            this.modalElement = document.querySelector(data.modalSelector);
        }

        this.isOpen = false;
        this.openModalElement = document.querySelector(data.modalOpenElementSelector);
        this.closeModalElement = this.modalElement.querySelector('.modal__close');
        this.modalContentElement = this.modalElement.querySelector('.modal-content');
        this.modalBodyElement = this.modalElement.querySelector('.modal-body');
        this.#hangEvents();
    }

    #hangEvents() {
        if (this.openModalElement) {
            this.openModalElement.addEventListener('click', () => this.open());
        }
        this.closeModalElement.addEventListener('click', () => this.close());
        window.addEventListener('click', (event) => this.handleWindowClick(event));
    }

    #createModal() {
        const modal = document.createElement('div');
        modal.id = this.createRandomId();
        modal.classList.add('modal');
        if (this.isVideoMode) {
            modal.classList.add('modal--video-mode');
        }
        modal.insertAdjacentHTML('afterbegin', this.#createModalHtml());
        document.body.appendChild(modal);
        return modal;
    }

    #createModalHtml() {
        return (
            `<div class="modal-dialog${this.isLarge ? ' modal-xl' : ''}">
                <div class="modal__close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-x" viewBox="0 0 16 16">
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </div>
                <div class="modal-content">
                    <div class="modal-body">
                        ${ this.modalTitle ? `<h4 class="modal-title">${this.modalTitle}</h4>` : '' }
                    </div>
                </div>
            </div>`
        )
    }

    createRandomId() {
        let rnd = '';
        while (rnd.length < 6) {
            rnd += Math.random().toString(36).substring(2);
        }
        return `modal-${rnd.substring(0, 6)}`;
    }

    open() {
        this.createOverlay();
        this.modalElement.classList.add('show');
        this.isOpen = true;
    }

    close() {
        this.removeOverlay();
        this.isOpen = false;
        if (this.isCreateMode) {
            this.modalElement.remove();
        } else {
            this.modalElement.classList.remove('show');
        }
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
        if (
            !this.modalContentElement.contains(event.target)
            && (!this.openModalElement || !this.openModalElement.contains(event.target))
            && this.isOpen) {
            this.close();
        }
    }

    setContent(html) {
        this.modalBodyElement.insertAdjacentHTML('beforeend', html);
    }

    onClose() {}
}