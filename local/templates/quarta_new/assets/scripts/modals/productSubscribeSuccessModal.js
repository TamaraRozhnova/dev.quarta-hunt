class ProductSubscribeSuccessModal extends Modal {
    constructor() {
        super({
            isCreateMode: true,
            title: 'Заявка отправлена'
        })

        this.modalClass = 'subscribe-product-modal';
        this.createModal();
        super.open();
    }

    createModal() {
        const content = this.createModalHtml();
        super.setContent(content);
        this.hangEvents();
    }

    hangEvents() {
        const button = document.querySelector(`.${this.modalClass} button`);
        button.addEventListener('click', () => super.close());
    }

    createModalHtml() {
        return (`
            <div class="${this.modalClass}">
                <p>
                    Менеджер свяжется с вами в рабочее время и обсудит детали заказа.
                </p>
                <button class="btn btn-primary w-100">
                    Вернуться к покупкам
                </button>
            </div>    
        `)
    }
}