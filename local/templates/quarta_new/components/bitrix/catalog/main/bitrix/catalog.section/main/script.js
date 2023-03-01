window.addEventListener('DOMContentLoaded', () => {
    class Filter {
        constructor() {
            this.productsDataBlock = document.querySelector('.products-data');
            this.mainFilters = document.querySelector('.filters');
            this.clearFilterButton = this.mainFilters.querySelector('.filters__clear');
            this.filterSections = this.mainFilters.querySelectorAll('.filters-section');
            this.filterCheckboxes = this.mainFilters.querySelectorAll('.filters-item input[type="checkbox"]');

            this.loader = document.querySelector('.loading');

            this.extraFilters = document.querySelector('.filters-sort');
            this.availableCheckbox = this.extraFilters.querySelector('#available');
            this.selectSortElement = this.extraFilters.querySelector('#select-sort');
            this.selectCountElement = this.extraFilters.querySelector('#select-count');
            this.listCountElements = this.extraFilters.querySelectorAll('#list-count li');
            this.createElements();
            this.hangEvents();
        }

        hangEvents() {
            this.filterSections.forEach(section => this.hangExpandSectionEvent(section));
            this.filterCheckboxes.forEach(checkbox => this.hangChangeCheckboxEvent(checkbox));
            this.listCountElements.forEach(element => this.hangChangeProductsCountEvent(element));
            this.hangAvailableEvent();
            this.hangFiltersClearEvent();
            this.hangFiltersExtraClearEvent();
            this.hangProductCardsEvents();
        }

        hangChangeProductsCountEvent(element) {
            element.addEventListener('click', () => {
                const id = element.dataset.id;
                if (this.selectorCount.getValue() == id) {
                    return;
                }
                this.changeProductsCountClasses(element);
                this.selectorCount.setValue(id);
                this.handleChangeFilters('itemsPerPage', id);
            });
        }

        handleChangeFilters(param = null, value = null) {
            const url = this.createNewUrl(param, value);
            this.changeUrl(url);
            this.fetchProducts(url)
                .then(html => {
                    if (!html) {
                        return;
                    }
                    this.insertHtml(html);
                });
        }

        hangAvailableEvent() {
            this.availableCheckbox.addEventListener('change', () => {
                const value = !!this.availableCheckbox.checked;
                this.handleChangeFilters('onlyAvailable', value);
            })
        }

        hangFiltersClearEvent() {
            this.clearFilterButton.addEventListener('click', () => {
                this.resetControls();
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
                this.resetControls();
                this.handleChangeFilters();
            });
        }

        hangChangeCheckboxEvent(checkbox) {
            checkbox.addEventListener('change', () => {
                const id = checkbox.id;
                const valueForUrl = checkbox.checked ? 'Y' : '';
                this.handleChangeFilters(id, valueForUrl);
            })
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
            this.hangProductCardsEvents();
        }

        resetControls() {
            this.availableCheckbox.checked = false;
            this.filterCheckboxes.forEach(checkbox => checkbox.checked = false);
            this.selectorSort.resetValue();
            this.selectorCount.resetValue();
            const newActiveCountElement = this.extraFilters.querySelector(`#list-count li[data-id="${this.selectorCount.getValue()}"]`);
            this.changeProductsCountClasses(newActiveCountElement);
        }

        setLoader(state = true) {
            if (state) {
                this.mainFilters.style.pointerEvents = 'none';
                this.extraFilters.style.pointerEvents = 'none';
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
            history.pushState(history.state, '', url);
        }

        createNewUrl(param = null, value = null) {
            const url = new URL(window.location.href);
            if (!param) {
                return `${url.origin}${url.pathname}`;
            }
            const params = new URLSearchParams(url.search);
            if (value) {
                params.set(param, value);
            } else {
                params.delete(param);
            }
            params.set('set_filter', 'Y');
            return `${url.origin}${url.pathname}?${params.toString()}`;
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
                withPlaceholder: true,
                onSelect: (id) => {
                    this.handleChangeFilters('sort', id);
                }
            });

            this.selectorCount = new Select({
                element: this.selectCountElement,
                onSelect: (id) => {
                    const newActiveElement = this.extraFilters.querySelector(`#list-count li[data-id="${id}"]`);
                    this.changeProductsCountClasses(newActiveElement);
                    this.handleChangeFilters('itemsPerPage', id);
                }
            });
        }

        hangProductCardsEvents() {
            new ProductCards();
        }
    }

    new Filter();
})
