class ProductCardCompare {
    constructor(data = {
        productElement,
        compareList
    }, events = {
        onDelete
    }
    ) {
        this.productElement = data.productElement;
        this.productId = this.productElement.dataset.id;
        this.compareList = data.compareList;

        this.onDelete = events.onDelete;

        /** Детальная карточка товара */
        if (document.querySelector('.product') != null) {

            this.productDetailElement = document.querySelector('.product');

            if (this.productId == this.productDetailElement.dataset.id) {

                this.productDetailElementCompareButton = this.productDetailElement.querySelector('.product-compare');

                this.productDetailElementCompareIconDefault = this.productDetailElementCompareButton.querySelector('.product-compare__default');
                this.productDetailElementCompareIconActive = this.productDetailElementCompareButton.querySelector('.product-compare__active');

            }

        }

        this.compareApi = new CompareApi();

        this.hangEvents();
        this.defineCompare();
    }

    defineCompare() {
        this.removePlaceholder();
        const inCompare = this.compareList[this.productId];
        if (inCompare) {
            this.changeStyles(true);
        } else {
            this.changeStyles(false);
        }
    }

    hangEvents() {
        this.productId = this.productElement.dataset.id;
        this.compareIconDefault = this.productElement.querySelector('.product-card__compare--default');
        this.compareIconActive = this.productElement.querySelector('.product-card__compare--active');

        this.compareIconDefault.addEventListener('click', async () => this.addCompare());
        this.compareIconActive.addEventListener('click', async () => this.deleteCompare());
    }

    async addCompare() {
        const response = await this.compareApi.addToCompare(this.productId);
        if (!response) {
            return;
        }
        this.changeStyles(true);
    }

    async deleteCompare() {
        const response = await this.compareApi.deleteFromCompare(this.productId);
        if (!response) {
            return;
        }
        if (this.onDelete) {
            this.onDelete(this.productId);
            return;
        }
        this.changeStyles(false);
    }

    changeStyles(state = true) {

        if (state) {
            this.compareIconDefault.style.display = 'none';
            this.compareIconActive.style.display = 'inline';

            /** Смена стилей для детальной страницы */
            if (document.querySelector('.product') != null != null) {

                if (this.productId == this.productDetailElement.dataset.id) { 

                    this.productDetailElementCompareButton.classList.add('text-secondary', 'border-secondary', 'in-compare');
                    this.productDetailElementCompareIconDefault.style.display = 'none';
                    this.productDetailElementCompareIconActive.style.display = 'inline';

                }
            }

        } else {
            this.compareIconActive.style.display = 'none';
            this.compareIconDefault.style.display = 'inline';

            /** Смена стилей для детальной страницы */
            if (document.querySelector('.product') != null != null) {

                if (this.productId == this.productDetailElement.dataset.id) { 

                    this.productDetailElementCompareButton.classList.remove('text-secondary', 'border-secondary', 'in-compare');
                    this.productDetailElementCompareIconDefault.style.display = 'inline';
                    this.productDetailElementCompareIconActive.style.display = 'none';

                }
            }

        }
    }

    removePlaceholder() {
        const placeholder = this.productElement.querySelector('.placeholder--compare');
        placeholder.remove();
    }
}