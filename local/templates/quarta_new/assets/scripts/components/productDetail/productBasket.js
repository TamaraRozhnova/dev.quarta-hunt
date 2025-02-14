class ProductBasket {

    constructor(basketList) {
        this.productElement = document.querySelector('.product');
        this.productAddElement = this.productElement.querySelector('.product__add');
        this.productId = this.productElement.dataset.id;
        this.basketList = basketList;
        this.productAvailable = this.productElement.dataset.available;
        this.productQuantity = this.productElement.dataset.productQuantity;
        this.productAddBasketStore = document.querySelectorAll('.product-card__add-basket-store');
        this.addProductInBasketAjaxUrl = '/local/ajax/includes/CustomBasket.php';

        this.productElementPicture = this.productElement.querySelector('.product-photos figure a').style.backgroundImage.slice(5, -2)
        this.productElementName = this.productElement.querySelector('.product__title')

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

        this.createAddToBasketButton();

        if (this.productAddBasketStore) {
            this.productAddBasketStore.forEach(btn => {
                let productId = btn.dataset.id;
                let storeId = btn.dataset.storeId ? btn.dataset.storeId : 0;
                let mode = btn.dataset.mode ? btn.dataset.mode : 'ADD';
                let maxQuantity = btn.dataset.amount ? btn.dataset.amount : 1;

                btn.addEventListener('click', () => {
                    this.runAddProductComponentAjax(productId, storeId, mode, 1, maxQuantity, btn);
                });

                let parent = btn.parentNode;

                if (parent) {
                    let counterStore = parent.querySelector('.product-count');

                    if (counterStore) {
                        this.hangStoreCounterEvents(id, maxQuantity, 1, parent);
                    }
                }
            });
        }
    }

    runAddProductComponentAjax(productId, storeId = 0, mode = 'ADD', quantity = 1, maxQuantity = 1, btn)
    {
        this.runAjax(
            this.addProductInBasketAjaxUrl,
            {
                productId: productId,
                storeId: storeId,
                mode: mode,
                quantity: quantity
            },
            response => {
                let res = JSON.parse(response);

                if (res.SUCCESS === true) {
                    if (mode === 'ADD') {
                        if (window.innerWidth >= 1200) {
                            if (window.basketPopupActive === true) {
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

                        this.createStoreCounter(productId, maxQuantity, quantity, btn);
                    }
                }
            },
            () => {}
        );
    }

    createStoreCounter(id, maxQuantity, quantity, btn)
    {
        let parent = btn.parentNode;

        this.hideAddStoreToBasketButton(btn);

        if (parent) {
            parent.insertAdjacentHTML('afterbegin', this.createCounterHtml(quantity));
        }

        this.hangStoreCounterEvents(id, maxQuantity, quantity, parent);
    }

    hangStoreCounterEvents(id, maxQuantity, quantity, parent)
    {
        this.productStoreCounter = parent.querySelector('.product-count');
        if (!this.productStoreCounter) {
            return;
        }
        this.createStoreCounterInstance(id, maxQuantity, quantity, parent);
    }

    createStoreCounterInstance(id, maxQuantity, quantity, parent)
    {
        const minus = parent.querySelector('.product-count__add-minus');
        const plus = parent.querySelector('.product-count__add-plus');
        const input = parent.querySelector('.product-count input');
        const btn = parent.querySelector('.product-card__add-basket-store');

        let storeId = 0;

        if (btn) {
            storeId =  btn.dataset.storeId ? btn.dataset.storeId : 0;
        }

        if (!minus || !plus || !input) {
            return;
        }

        let inputVal = input.value;
        let minValue = 1;
        let maxValue = maxQuantity;

        if (
            minValue >= maxValue ||
            inputVal >= maxValue
        ) {
            plus.style.pointerEvents = 'none';
        }

        plus.addEventListener('click', () => {
            if (maxValue > inputVal) {
                inputVal++;
                input.value = inputVal;

                if (inputVal >= maxValue) {
                    plus.style.pointerEvents = 'none';
                }

                this.runAddProductComponentAjax(id, storeId, 'UPDATE', inputVal, maxValue);
            }
        });

        minus.addEventListener('click', () => {
            if (inputVal == 1) {
                this.showAddStoreToBasketButton(parent);
                this.removeStoreCounter(parent);

                this.runAddProductComponentAjax(id, storeId, 'DELETE', inputVal, maxValue);
            } else {
                inputVal--;
                input.value = inputVal;

                if (inputVal < maxValue) {
                    plus.style.pointerEvents = 'all';
                }

                this.runAddProductComponentAjax(id, storeId, 'UPDATE', inputVal, maxValue);
            }
        });

        input.addEventListener('change', () => {
            inputVal = input.value;

            if (parseInt(inputVal) >= parseInt(maxValue)) {
                input.value = maxValue;
                inputVal = maxValue;
                plus.style.pointerEvents = 'none';
            } else {
                inputVal = input.value;
                plus.style.pointerEvents = 'all';
            }

            this.runAddProductComponentAjax(id, storeId, 'UPDATE', inputVal, maxValue);
        });
    }

    removeStoreCounter(parent)
    {
        let counter = parent.querySelector('.product-count');

        if (counter) {
            counter.remove();
        }
    }

    showAddStoreToBasketButton(parent)
    {
        let btn = parent.querySelector('.product-card__add-basket-store');

        if (btn) {
            btn.style.display = 'block';
        }
    }

    hideAddStoreToBasketButton(btn)
    {
        if (btn) {
            btn.style.display = 'none';
        }
    }

    runAjax(url, data, responseHandler, errorHandler)
    {
        BX.ajax({
            url,
            method: 'POST',
            data,
            onsuccess: response => responseHandler(response),
            onfailure: error => errorHandler(error)
        });
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
            let productTabs = document.querySelectorAll('.product-about__tab');
            let productTabsContent = document.querySelectorAll('.product__tab');

            productTabs.forEach(tab => {
                let tabId = tab.dataset.tab;

                if (tabId === '2') {
                    tab.classList.add('product-about__tab--selected');
                } else {
                    tab.classList.remove('product-about__tab--selected');
                }
            });

            let productTabContentAvailable;

            productTabsContent.forEach(content => {
                if (content.classList.contains('product-availability')) {
                    content.classList.add('product__tab--active');
                    productTabContentAvailable = content;
                } else {
                    content.classList.remove('product__tab--active');
                }
            });

            productTabContentAvailable.scrollIntoView({ behavior: 'smooth' });
        });
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

    createPopupIntoBasket() {

        const popupText = `<div class="product-basket-popup__wrapper">
            <div class="product-basket-popup__inner">
                <div class="product-basket-popup__items">
                    <a  class="product-basket-popup__item">
                        <div class="product-basket-popup__item-picture">
                            <img src="${this.productElementPicture}" alt="${this.productElementName.textContent}">
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