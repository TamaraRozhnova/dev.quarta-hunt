class CatalogSearch {
    constructor() {

        this.initDefaultVars();

        this.productsDataApi = new ProductsDataApi();

        this.createElements();
        this.hangEvents();
    }

    initDefaultVars() {
        this.serachContainer = document.querySelector('.search-page');
        this.productsDataBlock = document.querySelector('.products-data');
        this.mobileFilterOpenButton = document.querySelector('.filters-sort__btn');
        this.loader = document.querySelector('.loading');
        this.extraFilters = document.querySelector('.filters-sort');
        this.availableCheckbox = this.extraFilters.querySelector('#available');
        this.selectSortElement = this.extraFilters.querySelector('#select-sort');
        this.selectCountElement = this.extraFilters.querySelector('#select-count');
        this.listCountElements = document.querySelectorAll('#list-count li');

    }

    hangEvents() {
        this.hangListCountElements();
        this.hangPaginationEvents();
        this.hangAvailableEvent();
        this.hangProductCardsEvents();
    }


    changeViewMode(viewTemplate) {
        this.handleChangeFilters({'templateView': viewTemplate})
    }


    hangCloseAllApplyBnts() {
        if (window.innerWidth >= 991) {
            this.filterBtnOnCheckBox.style.display = 'none'
            this.filterBtnApplyFilterWrapper.style.display = 'none'
        }
    }

    hangPaginationEvents() {
        this.paginationElements = document.querySelectorAll('.pagination div');
        if (!this.paginationElements.length) {
            return;
        }
        this.paginationElements.forEach(element => {
            element.onclick = () => {
                const id = element.dataset.id;
                const url = new URL(window.location.href);
                const params = new URLSearchParams(url.search);
                if (params.get('PAGEN_3') == id) {
                    return;
                }
                this.handleChangeFilters({PAGEN_3: id});
            }
        })
    }

    hangChangeProductsCountEvent(element) {
        element.onclick = () => {
            const id = element.dataset.id;

            if (this.selectorCount.getValue() == id) {
                return;
            }
            this.changeProductsCountClasses(element);
            this.selectorCount.setValue(id);
            this.handleChangeFilters({itemsPerPage: id});
        }
    }

    handleChangeFilters(params = null, withChangeUrl = true) {
        const url = this.createNewUrl(params);
        this.changeScroll();
        this.fetchProducts(url)
            .then(html => {
                if (!html) {
                    return;
                }

                const styleHtml = BX.processHTML(html).STYLE

                if (styleHtml.length > 0) {
                    Array.from(styleHtml).forEach((script) => {
                        if (script.includes('catalog.item')) {
                            BX.loadCSS(script)
                        }
                    })
                }
                this.insertHtml(html);
                this.hangListCountElements()
            });
        if (withChangeUrl) {
            this.changeUrl(url);
        }
    }

    hangListCountElements() {
        this.listCountElements.forEach(element => this.hangChangeProductsCountEvent(element));
    }

    hangAvailableEvent() {
        this.availableCheckbox.onchange = () => {
            const value = !!this.availableCheckbox.checked;
            this.handleChangeFilters({onlyAvailable: value});
        }
    }


    changeScroll() {
        if (window.innerWidth >= 1200) {
            this.serachContainer.scrollIntoView(false);
            return;
        }
        document.body.scrollIntoView();
    }

    changeProductsCountClasses(element) {
        const currentActiveElement = document.querySelector('#list-count li.active');
        currentActiveElement.classList.remove('active');
        element.classList.add('active');
    }

    insertHtml(html) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const data = doc.querySelector('.products-data');
        const dataFilter = doc.querySelector('.category__filter-wrap')

        this.productsDataBlock.innerHTML = data.innerHTML;

        this.hangPaginationEvents();
        this.hangProductCardsEvents();
    }


    setLoader(state = true) {
        if (state) {
            this.extraFilters.style.pointerEvents = 'none';

            this.loader.classList.add('loading--show');
            this.productsDataBlock.classList.remove('products-data--show');
            return;
        }
        this.extraFilters.style.pointerEvents = 'all';
        this.loader.classList.remove('loading--show');
        this.productsDataBlock.classList.add('products-data--show');
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

        if (params === false) {
            return `${url.origin}${url.pathname}?${urlParams.toString()}`;
        }
        if (!params) {
            return `${url.origin}${url.pathname}`;
        }
        if (!params.hasOwnProperty('PAGEN_1')) {
            urlParams.set('PAGEN_1', '1');
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
                this.handleChangeFilters({sort: id});
            }
        });
    }

    createSelectorCount() {
        this.selectorCount = new Select({
            element: this.selectCountElement,
            onSelect: (id) => {
                const newActiveElement = document.querySelector(`#list-count li[data-id="${id}"]`);
                this.changeProductsCountClasses(newActiveElement);
                this.handleChangeFilters({itemsPerPage: id});
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

