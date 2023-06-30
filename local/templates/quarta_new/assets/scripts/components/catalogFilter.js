class CatalogFilter {
    constructor() {
        this.productsDataBlock = document.querySelector('.products-data');
        this.mainFiltersWrapper = document.querySelector('.category__filter-wrap');
        this.mainFilters = this.mainFiltersWrapper.querySelector('.filters');
        this.clearFilterButton = this.mainFilters.querySelector('.filters__clear');
        this.filterSections = this.mainFilters.querySelectorAll('.filters-section');
        this.filterCheckboxes = this.mainFilters.querySelectorAll('.filters-item input[type="checkbox"]');

        this.mobileFilterOpenButton = document.querySelector('.filters-sort__btn');
        this.mobileFilterCloseButton = document.querySelector('.filters__accept-btn');
        this.loader = document.querySelector('.loading');
        this.categoryHeaderContainer = document.querySelector('.category__header');

        this.extraFilters = document.querySelector('.filters-sort');
        this.availableCheckbox = this.extraFilters.querySelector('#available');
        this.selectSortElement = this.extraFilters.querySelector('#select-sort');
        this.selectCountElement = this.extraFilters.querySelector('#select-count');
        this.listCountElements = this.extraFilters.querySelectorAll('#list-count li');

        this.filterApplied = true;

        this.filterParams = {
            'FILTER_ITEMS': {}
        };

        this.productsDataApi = new ProductsDataApi();

        this.createElements();
        this.hangEvents();
    }

    hangEvents() {
        this.filterSections.forEach(section => this.hangExpandSectionEvent(section));
        this.filterCheckboxes.forEach(checkbox => this.hangChangeCheckboxEvent(checkbox));
        this.listCountElements.forEach(element => this.hangChangeProductsCountEvent(element));
        this.hangPaginationEvents();
        this.hangAvailableEvent();
        this.hangFiltersClearEvent();
        this.hangFiltersExtraClearEvent();
        this.hangOpenMobileFilterEvent();
        this.hangOpenCloseFilterEvent();
        this.setBadges();
        this.hangProductCardsEvents();
    }

    hangOpenMobileFilterEvent() {
        this.mobileFilterOpenButton.addEventListener('click', () => {
            this.mainFiltersWrapper.classList.add('category__filter-wrap--show');
        });
    }

    /** Кнопка применить */
    hangOpenCloseFilterEvent() {
        this.mobileFilterCloseButton.addEventListener('click', () => {
            this.mainFiltersWrapper.classList.remove('category__filter-wrap--show');

            this.handleChangeFilters(this.filterParams);
            // this.setBadges();

        });
    }

    hangPaginationEvents() {
        this.paginationElements = document.querySelectorAll('.pagination div');
        if (!this.paginationElements.length) {
            return;
        }
        this.paginationElements.forEach(element => {
            element.addEventListener('click', () => {
                const id = element.dataset.id;
                const url = new URL(window.location.href);
                const params = new URLSearchParams(url.search);
                if (params.get('PAGEN_1') == id) {
                    return;
                }
                this.handleChangeFilters({PAGEN_1: id});
            });
        })
    }

    hangChangeProductsCountEvent(element) {
        element.addEventListener('click', () => {
            const id = element.dataset.id;
            if (this.selectorCount.getValue() == id) {
                return;
            }
            this.changeProductsCountClasses(element);
            this.selectorCount.setValue(id);
            this.handleChangeFilters({itemsPerPage: id});
        });
    }

    handleChangeFilters(params = null, withChangeUrl = true) {
        const url = this.createNewUrl(params);
        this.changeScroll();
        this.fetchProducts(url)
            .then(html => {
                if (!html) {
                    return;
                }
                this.insertHtml(html);
            });
        if (withChangeUrl) {
            this.changeUrl(url);
        }
    }

    hangAvailableEvent() {
        this.availableCheckbox.addEventListener('change', () => {
            const value = !!this.availableCheckbox.checked;
            this.handleChangeFilters({onlyAvailable: value});
        })
    }

    hangFiltersClearEvent() {
        this.clearFilterButton.addEventListener('click', () => {
            this.resetControls();
            this.mobileFilterCloseButton.click()
            this.handleChangeFilters();
        });
    }

    hangFiltersExtraClearEvent() {
        this.clearFilterExtraButton = document.querySelector('.products-not-found__button');
        if (!this.clearFilterExtraButton) {
            return;
        }
        this.clearFilterExtraButton.addEventListener('click', (event) => {
            event.preventDefault();
            if (this.filterApplied) {
                this.resetControls();
                this.handleChangeFilters();
            }
        });
    }

    /** Чекбоксы */
    hangChangeCheckboxEvent(checkbox) {
        checkbox.addEventListener('change', () => {
            const id = checkbox.id;
            const valueForUrl = checkbox.checked ? 'Y' : '';

            // this.filterParams = {[id]: valueForUrl}

            this.filterParams['MULTI_OBJECT'] = 'Y'
            
            this.filterParams['FILTER_ITEMS'][id] = valueForUrl

            console.log(this.filterParams)
            // this.handleChangeFilters(this.filterParams);
            // this.handleChangeFilters({[id]: valueForUrl});
            this.setBadges();
        })
    }

    changeScroll() {
        if (window.innerWidth >= 1200) {
            this.categoryHeaderContainer.scrollIntoView(false);
            return;
        }
        document.body.scrollIntoView();
    }

    changeProductsCountClasses(element) {
        const currentActiveElement = this.extraFilters.querySelector('#list-count li.active');
        currentActiveElement.classList.remove('active');
        element.classList.add('active');
    }

    insertHtml(html) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const data = doc.querySelector('.products-data');
        this.productsDataBlock.innerHTML = data.innerHTML;
        this.hangFiltersExtraClearEvent();
        this.hangPaginationEvents();
        this.hangProductCardsEvents();
    }

    resetControls() {
        this.availableCheckbox.checked = false;
        this.filterCheckboxes.forEach(checkbox => checkbox.checked = false);
        this.selectorSort.resetValue();
        this.selectorCount.resetValue();
        this.inputMinPrice.clear();
        this.inputMaxPrice.clear();
        this.filterParams.FILTER_ITEMS = {};
        const newActiveCountElement = this.extraFilters.querySelector(`#list-count li:first-of-type`);
        this.changeProductsCountClasses(newActiveCountElement);
        this.setBadges();
    }

    setLoader(state = true) {
        if (state) {
            this.mainFilters.style.pointerEvents = 'none';
            this.extraFilters.style.pointerEvents = 'none';

            this.mobileFilterCloseButton.style.pointerEvents = 'all';

            this.loader.classList.add('loading--show');
            this.productsDataBlock.classList.remove('products-data--show');
            return;
        }
        this.mainFilters.style.pointerEvents = 'all';
        this.extraFilters.style.pointerEvents = 'all';
        this.loader.classList.remove('loading--show');
        this.productsDataBlock.classList.add('products-data--show');
    }

    changeUrl(url) {
        const newUrl = new URL(url);
        const urlParams = new URLSearchParams(newUrl.search);
        urlParams.delete('minPrice');
        urlParams.delete('maxPrice');
        const paramsString = urlParams.toString();
        history.pushState(history.state, '', `${newUrl.origin}${newUrl.pathname}${paramsString ? '?' + paramsString : ''}`);
    }

    createNewUrl(params = null) {
        const url = new URL(window.location.href);
        const urlParams = new URLSearchParams(url.search);
        urlParams.set('minPrice', this.inputMinPrice.getValue());
        urlParams.set('maxPrice', this.inputMaxPrice.getValue());
        this.filterApplied = true;
        if (params === false) {
            return `${url.origin}${url.pathname}?${urlParams.toString()}`;
        }
        if (!params) {
            this.filterApplied = false;
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


        urlParams.set('set_filter', 'Y');
        return `${url.origin}${url.pathname}?${urlParams.toString()}`;
    }

    async fetchProducts(url) {
        const options = {
            method: 'GET',
            headers: {
                'Content-Type': 'text/html',
                'x-requested-with': 'Y'
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

    hangExpandSectionEvent(section) {
        const button = section.querySelector('.filters-section__header');
        button.addEventListener('click', () => {
            section.classList.toggle('filters-section--expanded');
        });
    }

    createElements() {
        this.selectorSort = new Select({
            element: this.selectSortElement,
            onSelect: (id) => {
                this.handleChangeFilters({sort: id});
            }
        });

        this.selectorCount = new Select({
            element: this.selectCountElement,
            onSelect: (id) => {
                const newActiveElement = this.extraFilters.querySelector(`#list-count li[data-id="${id}"]`);
                this.changeProductsCountClasses(newActiveElement);
                this.handleChangeFilters({itemsPerPage: id});
            }
        });

        this.inputMinPrice = new Input({
            inputSelector: '#min-price',
            withDebounce: true,
            onChange: () => this.handleChangeFilters(false, false)
        });

        this.inputMaxPrice = new Input({
            inputSelector: '#max-price',
            withDebounce: true,
            onChange: () => this.handleChangeFilters(false, false)
        });
    }

    setBadges() {
        this.filterSections.forEach(section => {
            const checkboxes = section.querySelectorAll('input[type="checkbox"]');
            const title = section.querySelector('.filters-section__header h6');
            const currentBadge = title.querySelector('.filters-section__header-badge');
            const isNotCheckedSection = Array.from(checkboxes).every(checkbox => {
                if (checkbox.checked && !currentBadge) {
                    const newBadge = document.createElement('div');
                    newBadge.classList.add('filters-section__header-badge');
                    title.insertAdjacentElement('beforeend', newBadge);
                }
                return !checkbox.checked;
            });
            if (isNotCheckedSection && currentBadge) {
                currentBadge.remove();
            }
        })
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

