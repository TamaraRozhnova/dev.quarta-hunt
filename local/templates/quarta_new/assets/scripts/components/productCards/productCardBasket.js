class ProductCardBasket {
    constructor(data = {
        productElement,
        basketList
    }
    ) {
        this.productElement = data.productElement;
        this.productId = this.productElement.dataset.id;
        this.basketList = data.basketList;
        this.productAvailable = this.productElement.dataset.available;
        this.productQuantity = this.productElement.dataset.productQuantity;
        this.offersQuantity = this.productElement.dataset.offersQuantity;
        this.basketApi = new BasketApi();

        this.productElementPicture = this.productElement.querySelector('.product-card__image a figure img')
        this.productElementName = this.productElement.querySelector('.product-card__title')
        this.productElementHref = this.productElement.querySelector(`a[itemprop = 'url']`)

        if (window.basketPopupActive !== null) {
            window.basketPopupActive = false
        }

        this.hangEvents();
    }

    hangEvents() {
        this.removePlaceholder();
        if (!this.productAvailable) {
            this.createNewArrivalsButton();
            return;
        }
        const productInBasket = this.basketList[this.productId];
        if (productInBasket) {
            this.createCounter(productInBasket.QUANTITY);
        } else {
            this.createAddToBasketButton();
        }
    }

    removePlaceholder() {
        const basketElement = this.productElement.querySelector('.product-card__add');
        basketElement.classList.remove('placeholder-glow');
        const placeholder = basketElement.querySelector('.placeholder');
        if (!placeholder) return false;
        placeholder.remove();
    }

    hangNewArrivalsButtonEvents() {
        const newArrivalsButton = this.productElement.querySelector('.product-card__availability');
        if (!newArrivalsButton) {
            return;
        }
        newArrivalsButton.addEventListener('click', (event) => {
            event.stopPropagation();
            new ProductSubscribeModal(this.productId);
        });
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

            if (window.innerWidth >= 1200) {
                if (window.basketPopupActive = true) {
                    const allBasketPopupActive = document.querySelectorAll('.product-basket-popup__wrapper')

                    if (allBasketPopupActive.length > 0) {
                        allBasketPopupActive.forEach((popup) =>  {
                            popup.parentNode.removeChild(popup)
                        })
                        window.productAddedPopupBasket = false
                    }
                }

                this.lastPopupHtml = this.createPopupIntoBasket()
                this.insertPopupIntoBasket(this.lastPopupHtml)
                this.deletePopupIntoBasket(this.lastPopupHtml);
            }

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
        addToBasketButton.style.pointerEvents = 'none';
        this.basketApi.addToBasket(this.productId)
            .then(response => {
                if (!response) {
                    addToBasketButton.style.pointerEvents = 'all';
                    return;
                }
                this.createCounter();
                this.productElement.dataset.productBasket = 1;
            })
            .catch(() => addToBasketButton.style.pointerEvents = 'all')
    }

    handleAddProductToBasket(counterInstance) {
        if (window.innerWidth >= 1200) {
            
            if (window.basketPopupActive = true) {
                const allBasketPopupActive = document.querySelectorAll('.product-basket-popup__wrapper')

                if (allBasketPopupActive.length > 0) {
                    allBasketPopupActive.forEach((popup) =>  {
                        popup.parentNode.removeChild(popup)
                    })
                    window.productAddedPopupBasket = false
                }
            }

            this.lastPopupHtml = this.createPopupIntoBasket()
            this.insertPopupIntoBasket(this.lastPopupHtml)
            this.deletePopupIntoBasket(this.lastPopupHtml);
        }

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
        this.basketApi.setProductQuantityToBasket(this.productId, value)
            .then(response => {
                if (response === 0) {
                    this.createAddToBasketButton();
                } else {
                    counterInstance.setValue(response);
                }
                this.productElement.dataset.productBasket = response;
            })
            .catch(() => counterInstance.setValue(currentProductQuantityInBasket))
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
        const block = this.productElement.querySelector('.product-card__add');
        block.innerHTML = this.getAddToBasketButtonHtml();
        this.hangAddToBasketButtonEvents();
    }

    createCounter(quantity = 1) {
        const block = this.productElement.querySelector('.product-card__add');
        block.innerHTML = this.createCounterHtml(quantity);
        this.hangCounterEvents();
    }

    createNewArrivalsButton() {
        const block = this.productElement.querySelector('.product-card__add');
        block.innerHTML = this.createNewArrivalsButtonHtml();
        this.hangNewArrivalsButtonEvents();
    }

    getAddToBasketButtonHtml() {
        return (
            `<button onclick="ym(30377432,'reachGoal','product-card__add-basket')" class="btn btn-primary product-card__button product-card__add-basket">
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

    createNewArrivalsButtonHtml() {
        return (
            `<button class="btn btn-outline-primary product-card__availability">
                Cообщить о поступлении
            </button>`
        )
    }

    createPopupIntoBasket() {

        const popupText = `<div class="product-basket-popup__wrapper">
            <div class="product-basket-popup__inner">
                <div class="product-basket-popup__items">
                    <a href="${this.productElementHref?.href.trim()}" class="product-basket-popup__item">
                        <div class="product-basket-popup__item-picture">
                            <img src="${this.productElementPicture?.src}" alt="${this.productElementPicture?.alt}">
                        </div>
                        <div class="product-basket-popup__item-text">
                            <span>${this.productElementName.textContent}</span>
                        </div>
                    </a>
                </div>
                <div class="product-basket-popup__btn">
                    <a href = "/cart/" class="btn btn-primary">
                        В корзину
                    </a>
                </div>
            </div>
        </div>`

        const domParser = new DOMParser();
        const popupHtml = domParser.parseFromString(popupText, 'text/html');

        return popupHtml.body.firstElementChild
    }

    insertPopupIntoBasket(nodePopup) {

        if (!nodePopup) {
            return
        }

        const nodeCartPage = document.querySelector(`a[href*='cart'].header__top-item`)

        if (nodeCartPage) {
            nodeCartPage.parentNode.appendChild(nodePopup)
            window.basketPopupActive = true
        }

    }

    deletePopupIntoBasket(nodePopup, delay = 2500) {

        this.popupTimeoutId = setTimeout(() => {
            if (nodePopup.parentNode) {
                nodePopup.parentNode.removeChild(nodePopup);
                window.basketPopupActive = false
            }
        }, delay);

    }

}