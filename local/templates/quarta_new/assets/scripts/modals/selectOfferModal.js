class SelectOfferModal extends Modal {
    static mode = {
        ADD: 'ADD',
        DELETE: 'DELETE'
    }

    constructor(data = {
        mode: SelectOfferModal.ADD,
        productId: 0,
        onSubmit: (offerQuantity) => {}
    })
    {
        super({
            isCreateMode: true,
            title: 'Выбрать размер'
        });

        this.selector = '.modal-trade-offers';
        this.mode = data.mode;
        this.productId = data.productId;
        this.offers = {};
        this.onSubmit = data.onSubmit;

        this.basketApi = new BasketApi();

        this.createModal();
    }

    createModal() {
        this.getData()
            .then(response => {
                if (!response || Array.isArray(response)) {
                    return;
                }
                this.offers = response;
                this.createElements();
                this.hangSubmitEvent();
                super.open();
            })
    }

    createElements() {
        const options = this.mapOffersForSelect();
        const content = this.createModalHtml(options);
        this.setContent(content);
        this.counter = new Counter({
            selectorMinusButton: `${this.selector} .modal-trade-offers__minus`,
            selectorPlusButton: `${this.selector} .modal-trade-offers__plus`,
            selectorInput: `${this.selector} .modal-trade-offers__count input`,
            minValue: 1,
            maxValue: this.getFirstOffer().QUANTITY,
            initialValue: 1
        });

        this.select = new Select({
            selector: `${this.selector} .select`,
            onSelect: (id) => this.handleChangeOffer(id)
        });
    }

    hangSubmitEvent() {
        this.submitButton = document.querySelector(`${this.selector} .product-card__button`);
        this.submitButton.addEventListener('click', async () => this.handleSubmit());
    }

    async handleSubmit() {
        const offerId = this.select.getValue();
        const offerQuantity = this.counter.getValue();
        const response = await this.postData(offerId, offerQuantity);
        if (!response) {
            return;
        }
        super.close();
        this.onSubmit(offerQuantity);
    }

    postData(offerId, offerQuantity) {
        switch (this.mode) {
            case SelectOfferModal.mode.ADD:
                return this.basketApi.addToBasket(offerId, offerQuantity);
            case SelectOfferModal.mode.DELETE:
                return this.basketApi.deleteFromBasket(offerId, offerQuantity);
            default:
                return this.basketApi.addToBasket(offerId, offerQuantity);
        }
    }

    handleChangeOffer(id) {
        this.counter.setMinValue(1);
        this.counter.setMaxValue(this.offers[id].QUANTITY);
        this.counter.setValue(1);
    }

    mapOffersForSelect() {
        return Object.keys(this.offers).map(key => ({
            id: this.offers[key].ID,
            title: this.offers[key].NAME,
        }))
    }

    getFirstOffer() {
        for (let i in this.offers) {
            return this.offers[i];
        }
    }

    getData() {
        switch (this.mode) {
            case SelectOfferModal.mode.ADD:
                return this.basketApi.getAvailableOffersForPurchasing(this.productId);
            case SelectOfferModal.mode.DELETE:
                return this.basketApi.getAvailableOffersForDeleting(this.productId);
            default:
                return this.basketApi.getAvailableOffersForPurchasing(this.productId);
        }
    }

    renderSelectOptions(selectOptions) {
        return selectOptions.map(option => (
            `<div class="select__option" data-id="${option.id}" tabIndex="0">
                <span>${option.title}</span>
             </div>`
        ))
    }

    createModalHtml(selectOptions) {
        return (
            `<div class="modal-trade-offers">
                <div class="modal-trade-offers__wr">
                     <div class="select__wrapper">
                        <div class="select">
                          <button class="select__main btn">
                            <div class="select__options">
                                ${this.renderSelectOptions(selectOptions).join('')}
                            </div>
                          </button>
                        </div>
                    </div>
                    
                    <span class="input-group modal-trade-offers__count">
                        <span class="modal-trade-offers__minus">-</span>
                        <input type="number" class="form-control"/>
                        <span class="modal-trade-offers__plus">+</span>
                    </span>
    
                    <button class="btn btn-primary product-card__button col-12" >
                        ${this.mode === 'DELETE' ? 'Удалить из корзины' : 'В корзину'}
                    </button>
                </div>
            </div>`
        )
    }
}