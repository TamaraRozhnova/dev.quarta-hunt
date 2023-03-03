class ProductCardBasket {
    constructor(productElement) {
        this.productElement = productElement;
        this.productId = this.productElement.dataset.id;
        this.productQuantity = this.productElement.dataset.productQuantity;
        this.offersQuantity = this.productElement.dataset.offersQuantity;
        this.basketApi = new BasketApi();

        this.hangEvents();
    }

    hangEvents() {
        const newArrivalsButton = this.productElement.querySelector('.product-card__availability');
        if (newArrivalsButton) {
            newArrivalsButton.addEventListener('click', (event) => {
                event.stopPropagation();
                new ProductSubscribeModal(this.productId);
            });
            return;
        }

        this.hangCounterEvents();
        this.hangAddToBasketButtonEvents();
    }

    hangAddToBasketButtonEvents() {
        const addToBasketButton = this.productElement.querySelector('.product-card__add-basket');
        if (!addToBasketButton) {
            return;
        }
        addToBasketButton.addEventListener('click', () => {
            if (this.offersQuantity > 0) {
                this.handleAddFirstOfferToBasket();
                return;
            }
            this.handleAddFirstProductToBasket(addToBasketButton);
        })
    }

    hangCounterEvents() {
        const productCounter = this.productElement.querySelector('.product__add-count');
        if (!productCounter) {
            return;
        }
        if (this.offersQuantity > 0) {
            this.createCounterInstanceForOffers();
            return;
        }
        this.createCounterInstanceForProducts();
    }

    createCounterInstanceForProducts() {
        const productCardSelector = `.product-card[data-id="${this.productId}"]`;
        const selectorMinusButton = `${productCardSelector} .product__add-minus`;
        const selectorPlusButton = `${productCardSelector} .product__add-plus`;
        const selectorInput = `${productCardSelector} .product__add-count input`;

        new Counter({
            selectorMinusButton,
            selectorPlusButton,
            selectorInput,
            maxValue: this.productQuantity,
            blockChangeState: true,
            onPlus: (value, counterInstance) => {
                this.handleAddProductToBasket(counterInstance);
            },
            onMinus: (value, counterInstance) => {
                this.handleDeleteProductFromBasket(counterInstance);
            },
            onChangeInput: (value, counterInstance) => {
                this.handleSetQuantityForProduct(value, counterInstance)
            }
        });
    }

    createCounterInstanceForOffers() {
        const productCardSelector = `.product-card[data-id="${this.productId}"]`;
        const selectorMinusButton = `${productCardSelector} .product__add-minus`;
        const selectorPlusButton = `${productCardSelector} .product__add-plus`;
        const selectorInput = `${productCardSelector} .product__add-count input`;

        new Counter({
            selectorMinusButton,
            selectorPlusButton,
            selectorInput,
            blockChangeState: true,
            disabledInput: true,
            onPlus: (value, counterInstance) => {
                this.handleAddOfferToBasket(counterInstance);
            },
            onMinus: (value, counterInstance) => {
                this.handleDeleteOfferFromBasket(counterInstance);
            }
        });
    }

    handleAddFirstOfferToBasket() {
        new SelectOfferModal({
            mode: SelectOfferModal.mode.ADD,
            productId: this.productId,
            onSubmit: (quantity) => {
                this.createCounter(quantity);
            }
        });
    }

    handleAddFirstProductToBasket(addToBasketButton) {
        addToBasketButton.disabled = true;
        this.basketApi.addToBasket(this.productId)
            .then(response => {
                if (!response) {
                    addToBasketButton.disabled = false;
                    return;
                }
                this.createCounter();
            })
            .catch(() => addToBasketButton.disabled = false)
    }

    handleAddProductToBasket(counterInstance) {
        if (this.productQuantity == counterInstance.getValue()) {
            return;
        }
        counterInstance.disableButtons();
        this.basketApi.addToBasket(this.productId)
            .then(response => {
                if (!response) {
                    counterInstance.activateButtons();
                    return;
                }
                const value = counterInstance.getValue();
                const newValue = +value + 1;
                counterInstance.setValue(newValue);
                this.productElement.dataset.productBasket = newValue;
            })
            .finally(() => counterInstance.activateButtons())
    }

    handleDeleteProductFromBasket(counterInstance) {
        counterInstance.disableButtons();
        this.basketApi.deleteFromBasket(this.productId)
            .then(response => {
                if (!response) {
                    counterInstance.activateButtons();
                    return;
                }
                const value = counterInstance.getValue();
                const newValue = value - 1;
                if (newValue === 0) {
                    this.createAddToBasketButton();
                    return;
                }
                counterInstance.setValue(newValue);
                counterInstance.activateButtons();
                this.productElement.dataset.productBasket = newValue;
            })
            .catch(() => counterInstance.activateButtons())
    }

    handleSetQuantityForProduct(value, counterInstance) {
        counterInstance.disableButtons();
        const currentProductQuantityInBasket = this.productElement.dataset.productBasket;
        this.basketApi.setProductQuantityToBasket(this.productId, currentProductQuantityInBasket, value)
            .then(response => {
                if (response === 0) {
                    this.createAddToBasketButton();
                } else {
                    counterInstance.setValue(response);
                }
                this.productElement.dataset.productBasket = response;
            })
            .catch(() => setValue(currentProductQuantityInBasket))
            .finally(() => counterInstance.activateButtons())
    }

    handleAddOfferToBasket(counterInstance) {
        if (this.offersQuantity == counterInstance.getValue()) {
            return;
        }
        new SelectOfferModal({
            mode: SelectOfferModal.mode.ADD,
            productId: this.productId,
            onSubmit: (quantity) => {
                const value = counterInstance.getValue();
                counterInstance.setValue(+value + +quantity);
            }
        });
    }

    handleDeleteOfferFromBasket(counterInstance) {
        new SelectOfferModal({
            mode: SelectOfferModal.mode.DELETE,
            productId: this.productId,
            onSubmit: (quantity) => {
                const value = counterInstance.getValue();
                if (+value === +quantity) {
                    this.createAddToBasketButton();
                    return;
                }
                counterInstance.setValue(value - quantity);
            }
        });
    }

    createAddToBasketButton() {
        const block = this.productElement.querySelector('.product-card__add--main');
        block.innerHTML = this.getAddToBasketButtonHtml();
        this.hangAddToBasketButtonEvents();
    }

    createCounter(quantity = 1) {
        const block = this.productElement.querySelector('.product-card__add--main');
        block.innerHTML = this.createCounterHtml(quantity);
        this.hangCounterEvents();
    }

    getAddToBasketButtonHtml() {
        return (
            `<button class="btn btn-primary product-card__button product-card__add-basket">
                 В корзину
             </button>`
        )
    }

    createCounterHtml(value = 1) {
        return (
            `<span class="input-group product__add-count">
                <span class="btn btn-primary product__add-minus">-</span>
                <input type="number" class="form-control" value="${value}" />
                <span class="btn btn-primary product__add-plus">+</span>
             </span>`
        )
    }
}