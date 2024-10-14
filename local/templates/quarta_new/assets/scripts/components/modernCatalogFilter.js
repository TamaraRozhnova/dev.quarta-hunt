class ModernCatalogFilter {
    constructor() {

        this.filterApplied = true;

        this.productsDataApi = new ProductsDataApi();
        this.standartFilter = document.querySelector('.category__filter-wrap.bx-filter')
        this.extraFilters = document.querySelector('.filters-sort');
        this.availableCheckbox = this.extraFilters.querySelector('#available');
        this.selectSortElement = this.extraFilters.querySelector('#select-sort');
        this.selectCountElement = this.extraFilters.querySelector('#select-count');
        this.listCountElements = document.querySelectorAll('#list-count li');

        if (window.innerWidth > 1024) {

            this.viewItemsWrapper = this.extraFilters.querySelector('.filters-mode-view')
            this.viewItems = this.viewItemsWrapper.querySelectorAll('.filters-mode-view__item')

            if (this.viewItems.length > 0) {
                this.hangViewMode()
            }

        }

        this.mobileFilterOpenButton = document.querySelector('.filters-sort__btn');

        this.createElements();
        this.hangEvents();
    }

    hangEvents() {
        this.hangListCountElements();
        this.hangOpenMobileFilterEvent();
        this.hangAvailableEvent();
        this.hangProductCardsEvents();
    }

    clearViewMode() {
        this.viewItems.forEach((view) => {
            view.classList.remove('active')
        })
    }

    hangViewMode() {
        this.viewItems.forEach((view) => {
            view.onclick = () => {
                this.clearViewMode()
                view.classList.add('active')
                this.changeViewMode(view.dataset.template)
            }
        })
    }

    changeViewMode(viewTemplate) {
        this.handleChangeFilters({ 'templateView': viewTemplate })
    }


    hangOpenMobileFilterEvent() {
        this.mobileFilterOpenButton.onclick = () => {
            this.standartFilter.classList.toggle('show')
        }
    }

    hangChangeProductsCountEvent(element) {
        element.onclick = () => {
            const id = element.dataset.id;

            if (this.selectorCount.getValue() == id) {
                return;
            }
            this.changeProductsCountClasses(element);
            this.selectorCount.setValue(id);
            this.handleChangeFilters({ itemsPerPage: id });
        }
    }

    handleChangeFilters(params = null, withChangeUrl = true) {
        const url = this.createNewUrl(params);

        if (withChangeUrl) {
            this.changeUrl(url);
        }

        window.location.reload()
    }

    hangListCountElements() {
        this.listCountElements.forEach(element => this.hangChangeProductsCountEvent(element));
    }

    hangAvailableEvent() {
        this.availableCheckbox.onchange = () => {
            const value = !!this.availableCheckbox.checked;
            this.handleChangeFilters({ onlyAvailable: value });
        }
    }

    changeProductsCountClasses(element) {
        const currentActiveElement = document.querySelector('#list-count li.active');
        currentActiveElement.classList.remove('active');
        element.classList.add('active');
    }

    changeUrl(url) {
        const newUrl = new URL(url);
        const urlParams = new URLSearchParams(newUrl.search);
        const paramsString = urlParams.toString();
        history.pushState(history.state, '', `${newUrl.origin}${newUrl.pathname}${paramsString ? '?' + paramsString : ''}`);
    }

    createNewUrl(params = null) {
        const url = new URL(window.location.href);
        const urlParams = new URLSearchParams(url.search);

        this.filterApplied = true;
        if (params === false) {
            return `${url.origin}${url.pathname}?${urlParams.toString()}`;
        }
        if (!params) {
            this.filterApplied = false;
            return `${url.origin}${url.pathname}`;
        }

        if (params.MULTI_OBJECT == 'Y') {
            if (params.FILTER_ITEMS) {

                Object.keys(params.FILTER_ITEMS).forEach(key => {
                    if (params.FILTER_ITEMS[key]) {
                        urlParams.set(key, params.FILTER_ITEMS[key]);
                    } else {
                        urlParams.delete(key);
                    }
                })

            }
        } else {
            Object.keys(params).forEach(key => {
                if (params[key]) {
                    urlParams.set(key, params[key]);
                } else {
                    urlParams.delete(key);
                }
            })
        }

        return `${url.origin}${url.pathname}?${urlParams.toString()}`;
    }

    async fetchProducts(url) {
        const options = {
            method: 'GET',
            headers: {
                'Content-Type': 'text/html',
                'x-requested-with': 'Y',
            },
        };
        try {
            this.setLoader(true);
            const response = await fetch(url, options);
            return await response.text();
        } finally {
            this.setLoader(false);
        }
    }

    createSelectorSort() {
        this.selectorSort = new Select({
            element: this.selectSortElement,
            onSelect: (id) => {
                this.handleChangeFilters({ sort: id });
            }
        });
    }

    createSelectorCount() {
        this.selectorCount = new Select({
            element: this.selectCountElement,
            onSelect: (id) => {
                const newActiveElement = document.querySelector(`#list-count li[data-id="${id}"]`);
                this.changeProductsCountClasses(newActiveElement);
                this.handleChangeFilters({ itemsPerPage: id });
            }
        });
    }

    createElements() {
        this.createSelectorSort()
        this.createSelectorCount()
    }

    getProductsIds() {
        const productElements = document.querySelectorAll('.product-card');
        return Array.from(productElements).map(element => element.dataset.id);
    }

    hangProductCardsEvents() {
        const productIds = this.getProductsIds();
        if (!productIds.length) {
            return;
        }
        this.productsDataApi.getData(productIds)
            .then(response => {
                new ProductCards(response);
            })
    }
}

