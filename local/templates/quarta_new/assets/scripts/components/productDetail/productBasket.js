class ProductBasket {
    constructor(basketList) {
        this.productElement = document.querySelector('.product');
        this.productAddElement = this.productElement.querySelector('.product__add');
        this.productId = this.productElement.dataset.id;
        this.basketList = basketList;
        this.productAvailable = this.productElement.dataset.available;
        this.productQuantity = this.productElement.dataset.productQuantity;

        this.offers = {};

        this.basketApi = new BasketApi();
        this.fillOffersData();
        this.hangEvents();
    }

    hangEvents() {
        this.removePlaceholders();
        if (!this.productAvailable) {
            this.createNewArrivalsButton();
            return;
        }
        if (Object.keys(this.offers).length) {
            this.hangSelectOfferEvent();
            return;
        }
        const productInBasket = this.basketList[this.productId];
        if (productInBasket) {
            this.createCounter(this.productId, this.productQuantity, productInBasket.QUANTITY);
        } else {
            this.createAddToBasketButton();
        }
    }

    fillOffersData() {
        const offersOptions = this.productElement.querySelectorAll('.product__trade-offers .select__option');
        offersOptions.forEach(offerOption => {
            const id = offerOption.dataset.id;
            const offerInBasket = this.basketList[id];
            this.offers[id] = {
                quantity: +offerOption.dataset.quantity,
                basket: offerInBasket ? +offerInBasket.QUANTITY : 0
            }
        })
    }

    removePlaceholders() {
        const productAddElement = this.productElement.querySelector('.product__add');
        const placeholder = productAddElement.querySelector('.placeholder');
        productAddElement.classList.remove('placeholder-glow');
        if (placeholder) {
            placeholder.remove();
        }
        const selectOffersWrapperElement = this.productElement.querySelector('.product__trade-offers');
        if (!selectOffersWrapperElement) {
            return;
        }
        selectOffersWrapperElement.classList.remove('placeholder-glow');
        const selectOffersElement = selectOffersWrapperElement.querySelector('.select');
        const selectOffersPlaceholder = selectOffersWrapperElement.querySelector('.placeholder');
        selectOffersElement.style.display = 'inline-block';
        selectOffersPlaceholder.remove();
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
        new Select({
            selector: '.product__trade-offers .select',
            onSelect: (id) => this.handleChangeOffer(id)
        });
    }

    handleChangeOffer(offerId) {
        const { quantity, basket } = this.offers[offerId];
        if (basket) {
            this.removeCounter();
            this.createCounter(offerId, quantity, basket);
        } else {
            this.removeAddToBasketButton();
            this.createAddToBasketButton(offerId, quantity);
        }
    }

    createNewArrivalsButton() {
        this.productAddElement.insertAdjacentHTML('afterbegin', this.createNewArrivalsButtonHtml());
        this.hangSubscribeToProductEvent();
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
            `<button onclick="ym(30377432,'reachGoal','product-card__add-basket')" class="product-basket btn btn-primary px-5 product-card__add-basket">
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

    createNewArrivalsButtonHtml() {
        return (
            `<button class="product-subscribe btn btn-primary px-3">
                  Cообщить о поступлении
             </button>`
        )
    }
}