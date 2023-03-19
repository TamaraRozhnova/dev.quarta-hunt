class ProductBasket {
    constructor() {
        this.productElement = document.querySelector('.product');
        this.productAddElement = this.productElement.querySelector('.product__add');
        this.productId = this.productElement.dataset.id;
        this.productQuantity = this.productElement.dataset.productQuantity;
        this.productBasket = this.productElement.dataset.productBasket;

        this.offers = {};

        this.basketApi = new BasketApi();
        this.fillOffersData();
        this.hangEvents();
    }

    hangEvents() {
        this.hangSelectOfferEvent();
        this.hangAddToBasketButtonEvents();
        this.hangCounterEvents();
        this.hangSubscribeToProductEvent();
    }

    fillOffersData() {
        const offersOptions = this.productElement.querySelectorAll('.product__trade-offers .select__option');
        offersOptions.forEach(offerOption => {
            const id = offerOption.dataset.id;
            this.offers[id] = {
                quantity: +offerOption.dataset.quantity,
                basket: +offerOption.dataset.basket
            }
        })
    }

    hangSubscribeToProductEvent() {
        this.subscribeButton = this.productElement.querySelector('.product-subscribe');
        if (this.subscribeButton) {
            this.subscribeButton.addEventListener('click', (event) => {
                event.stopPropagation();
                new ProductSubscribeModal(this.productId);
            })
        }
    }

    hangAddToBasketButtonEvents(id = this.productId, maxQuantity = this.productQuantity) {
        this.addToBasketButton = this.productElement.querySelector('.product-basket');
        if (!this.addToBasketButton) {
            return;
        }
        this.addToBasketButton.addEventListener('click', () => {
            this.handleAddFirstProductToBasket(id, maxQuantity);
        })
    }

    handleAddFirstProductToBasket(id, maxQuantity) {
        this.addToBasketButton.style.pointerEvents = 'none';
        this.basketApi.addToBasket(id)
            .then(response => {
                if (!response) {
                    this.addToBasketButton.style.pointerEvents = 'all';
                    return;
                }
                if (id == this.productId) {
                    this.productBasket = 1;
                } else {
                    this.offers[id].basket = 1;
                }
                this.createCounter(id, maxQuantity);
            })
            .catch(() => this.addToBasketButton.style.pointerEvents = 'all')
    }

    hangSelectOfferEvent() {
        if (!Object.keys(this.offers).length) {
            return;
        }
        new Select({
            selector: '.product__trade-offers .select',
            onSelect: (id) => this.handleChangeOffer(id)
        });
    }

    handleChangeOffer(offerId) {
        const { quantity, basket } = this.offers[offerId];
        console.log(this.offers[offerId])
        if (basket) {
            this.removeCounter();
            this.createCounter(offerId, quantity, basket);
        } else {
            this.removeAddToBasketButton();
            this.createAddToBasketButton(offerId, quantity);
        }
    }

    createAddToBasketButton(id = this.productId, maxQuantity = this.productQuantity) {
        this.removeCounter();
        this.productAddElement.insertAdjacentHTML('afterbegin', this.createAddToBasketButtonHtml());
        this.hangAddToBasketButtonEvents(id, maxQuantity);
    }

    createCounter(id, maxQuantity, quantity = 1) {
        this.removeAddToBasketButton();
        this.productAddElement.insertAdjacentHTML('afterbegin', this.createCounterHtml(quantity));
        this.hangCounterEvents(id, maxQuantity, quantity);
    }

    hangCounterEvents(id = this.productId, maxQuantity = this.productQuantity, quantity = this.productBasket) {
        this.productCounter = this.productElement.querySelector('.product-count');
        if (!this.productCounter) {
            return;
        }
        this.createCounterInstance(id, maxQuantity, quantity);
    }

    createCounterInstance(id, maxQuantity, quantity) {
        const selectorMinusButton = '.product-count__add-minus';
        const selectorPlusButton = '.product-count__add-plus';
        const selectorInput = '.product-count input';

        this.counter = new Counter({
            selectorMinusButton,
            selectorPlusButton,
            selectorInput,
            maxValue: maxQuantity,
            blockChangeState: true,
            onPlus: (value, counterInstance) => {
                this.handleSetQuantityForProduct({id, quantity, value: value + 1, counterInstance});
            },
            onMinus: (value, counterInstance) => {
                this.handleSetQuantityForProduct({id, quantity, value: value - 1, counterInstance});
            },
            onChangeInput: (value, counterInstance) => {
                this.handleSetQuantityForProduct({id, quantity, value, counterInstance})
            }
        });
    }

    handleSetQuantityForProduct({id, quantity, value, counterInstance}) {
        counterInstance.disableButtons();
        this.basketApi.setProductQuantityToBasket(id, value)
            .then(response => {
                if (response === 0) {
                    this.createAddToBasketButton(id, quantity);
                } else {
                    counterInstance.setValue(response);
                }
                if (id == this.productId) {
                    this.productBasket = response;
                } else {
                    this.offers[id].basket = response;
                }
            })
            .catch(() => counterInstance.setValue(quantity))
            .finally(() => counterInstance.activateButtons())
    }

    removeAddToBasketButton() {
        if (this.addToBasketButton) {
            this.addToBasketButton.remove();
        }
    }

    removeCounter() {
        if (this.productCounter) {
            this.productCounter.remove();
        }
    }

    createAddToBasketButtonHtml() {
        return (
            `<button class="product-basket btn btn-primary px-5">
                В корзину
            </button>`
        )
    }

    createCounterHtml(value = 1) {
        return (
            `<div class="product-count">
                <span class="product-count__add-minus">-</span>
                <span class="product-count__add-plus">+</span>
                <input type="number" value="${value}" class="form-control" />
            </div>`
        )
    }
}