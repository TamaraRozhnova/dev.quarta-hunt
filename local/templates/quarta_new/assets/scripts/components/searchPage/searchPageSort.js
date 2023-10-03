class SearchPageSort {

    constructor(params = {}) {
        this.searchPageWrapper = document.querySelector('.search-result-page')
        this.sortCatalogFilterWrapper = this.searchPageWrapper.querySelector('.search-catalog-filters__wrapper')
        this.sortBlock = this.searchPageWrapper.querySelector('.filters .select__wrapper')
        this.sortDefaultValue = this.sortBlock.querySelector('#select__main-default-value')

        this.sortOptions = this.sortBlock.querySelectorAll('.select__options .select__option')
        this.loader = this.searchPageWrapper.querySelector('.loading')

        this.ajaxUrl = `/ajax/search/sortProducts.php`
        this.paramsCatalog = params?.paramsCatalog

        this.sortCode = null;
        this.searchTarget = null;
        this.searchPagination = null;
        this.searchPaginationLimit = params?.pageSize;

        this.productsDataApi = new ProductsDataApi();

        this.hangEvents()
    }

    hangEvents() {
        this.hangSort()
    }

    hangSort() {
        this.sortBlock.addEventListener('click', (e) => this.toggleStatusSortBlock())

        this.sortOptions.forEach((sort) => sort.addEventListener('click', (e) => {
            this.changeSort(e.target)
        }))
        
    }

    toggleStatusSortBlock() {
        if (this.sortBlock.classList.contains('select--expanded')) {
            this.sortBlock.classList.remove('select--expanded')
        } else {
            this.sortBlock.classList.add('select--expanded')
        }
    }

    changeSort(sort) {
        this.sortDefaultValue.innerHTML = sort.innerHTML

        const sortParent = sort.parentNode?.dataset.id
        const currentSort = sort?.dataset.id
        const activeSort = sortParent || currentSort

        if (typeof activeSort != 'undefined') {

            if (this.sortCode == activeSort) return;

            this.searchTarget = this.getUrlParam('q')
            this.searchPagination = this.getUrlParam('cur_page')

            this.sortCode = activeSort;
            this.fetchHTMLElements()
        }


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

    getProductsIds() {
        const productElements = document.querySelectorAll('.product-card');
        return Array.from(productElements).map(element => element.dataset.id);
    }

    async fetchHTMLElements() {

        SearchPageHttp.fetchElements(
            {
                url: this.ajaxUrl,
                paramsCatalog: this.paramsCatalog,
                sortCode: this.sortCode,
                searchPagination: this.searchPagination,
                searchPaginationLimit: this.searchPaginationLimit,
                searchTarget: this.searchTarget
            }
        ).then(html => {

            if (!html) {
                return;
            }

            this.setLoader(true)

            const domParser = new DOMParser()
            const parsedDocument = domParser.parseFromString(html, "text/html");
            const catalogHTML = parsedDocument.querySelector('.search')

            setTimeout(() => {
                this.insertHTMLElements(catalogHTML)
            }, 1000);


        });

    }

    insertHTMLElements(html) {
        this.searchPageWrapper.querySelector('.search').outerHTML = html.outerHTML
        this.setLoader(false)
        this.hangProductCardsEvents()
        this.buildURL()
        this.changeUrl()
        this.changeUrlPagination()
    }

    setLoader(state = true) {
        if (state) {
            this.sortCatalogFilterWrapper.style.display = 'none'
            this.loader.classList.add('loading--show');
            return;
        }
        this.loader.classList.remove('loading--show');
        this.sortCatalogFilterWrapper.style.display = 'block'
    }

    getUrlParam(param) {
        const url = new URL(window.location.href);
        const urlParams = new URLSearchParams(url.search);

        return urlParams.get(param)
    }

    buildURL() {
        const url = new URL(window.location.href);
        const urlParams = new URLSearchParams(url.search);

        urlParams.set('sort', this.sortCode)

        return `${url.origin}${url.pathname}?${urlParams.toString()}`;
    }

    rebuildURLPagination(link, needes, incoming) {
        let url = new URL(link);
        let urlParams = new URLSearchParams(url.search);

        urlParams.set(needes, incoming)
        url.search = urlParams.toString();

        return url;
    }

    changeUrl() {
        const url = this.buildURL()

        history.pushState(history.state, '', `${url}`);
    }

    changeUrlPagination() {
        document.querySelectorAll('.search-page .pagination.container a').forEach( (link) => {

            const currentUrl = new URL(window.location.href)
            const linkHref = `${currentUrl.origin}${currentUrl.pathname}${link.getAttribute('href')}` 
            const rebuildUrl = new URL(this.rebuildURLPagination(linkHref, 'sort', this.sortCode))

            link.setAttribute('href', rebuildUrl.search)
        })
    }
 
}