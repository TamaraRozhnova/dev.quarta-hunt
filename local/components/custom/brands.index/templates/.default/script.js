class IndexBrands {

    constructor() {

        this.anchors = document.querySelectorAll('a[data-word]')
        this.brandsForSearch = brandsForSearch
        this.brandsFilters = brandsFilters
        this.brandsForSearchArray = null;

        if (this.brandsForSearch) {
            this.brandsForSearchArray = Object.values(this.brandsForSearch?.ALP_SEARCH)
        }

        this.searchBrandPanel = document.querySelector('.search-brand-panel')
        this.searchBrandPanelResult = document.querySelector('.brands-index__search-result')
        this.searchBrandPanelWrapper = document.querySelector('.brands-index__search')

        this.handleEvents()
    }

    handleEvents() {
        this.handleAnchor()

        if (this.searchBrandPanel) {
            this.handleSearch()
            this.handleSearchPanel()
            this.handleResultSearch()
        }

    }

    handleSearch() {
        this.searchBrandPanel.addEventListener('input', (e) => {
            const value = e.target.value.trim()

            this.fillSearchResult(
                this.getMatchBrand(value)
            )

        })
    }

    handleResultSearch() {
        document.addEventListener('click', (e) => {

            if (!e.target.closest('.brands-index__search')) {
                this.searchBrandPanelResult.classList.add('hide')
            }

        })
    }

    handleSearchPanel() {
        
    }

    handleAnchor() {
        if (this.anchors) {
            this.anchors.forEach((anchor) => {

                anchor.addEventListener('click', (event) => {
                    event.preventDefault();

                    const anchorFinallyPoints = document.querySelector(`[data-word-anchor='${event.target?.dataset?.word}']`)

                    if (anchorFinallyPoints) {

                        let offsetAnchor

                        if (window.innerWidth > 747) {
                            offsetAnchor = 250
                        } else {
                            offsetAnchor = 75
                        }

                        this.scrollToTargetAdjusted(anchorFinallyPoints, offsetAnchor)
                    }

                })
            })
        }
    }

    fillSearchResult(searchResult) {

        if (searchResult.length == 0) {
            this.searchBrandPanelResult.classList.add('hide') 
            return
        }

        if (searchResult) {

            let nodeResultsBrand = document.createElement('div')

            for (let index = 0; index < searchResult.length; index++) {
                const findedBrand = searchResult[index];

                const nodeBrandWrapper = document.createElement('div')
                nodeBrandWrapper.classList.add('brands-index__search-result-item-wrapper')

                const nodeBrandItem = document.createElement('a')
                nodeBrandItem.setAttribute('href', this.brandsFilters[findedBrand])
                nodeBrandItem.classList.add('brands-index__search-result-item')
                nodeBrandItem.textContent = findedBrand

                nodeBrandWrapper.appendChild(nodeBrandItem)
                nodeResultsBrand.appendChild(nodeBrandWrapper)
                
            }

            if (typeof nodeResultsBrand !== 'undefined') {
                this.searchBrandPanelResult.innerHTML = nodeResultsBrand.innerHTML
            }

            if (this.searchBrandPanelResult.classList.contains('hide')) {
                this.searchBrandPanelResult.classList.remove('hide')
            }

        }

    }

    getMatchBrand(text) {

        if (text == '') {
            return []
        }

        const lowerCaseText = text.toLowerCase();

        if (this.brandsForSearchArray) {
            return this.brandsForSearchArray.filter(element => 
                element.toLowerCase().includes(lowerCaseText)
            );
        }
    }

    scrollToTargetAdjusted(element, offset) {

        let elementPosition = element.getBoundingClientRect().top;
        let offsetPosition = elementPosition + window.pageYOffset - offset;
      
        window.scrollTo({
            top: offsetPosition,
            behavior: "smooth"
        });
    }

}

document.addEventListener('DOMContentLoaded' , () => {
    setTimeout(() => {
        new IndexBrands()
    }, 50);
})