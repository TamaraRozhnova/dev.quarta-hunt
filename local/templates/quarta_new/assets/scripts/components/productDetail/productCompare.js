class ProductCompare {
    constructor(compareList) {
        this.productElement = document.querySelector('.product');
        this.productId = this.productElement.dataset.id;

        this.compareList = compareList;
        this.compareApi = new CompareApi();
        this.compareButton = this.productElement.querySelector('.product-compare');

        this.hangEvents();
        this.defineCompare();
    }

    defineCompare() {
        this.removePlaceholder();
        this.inCompare = this.compareList[this.productId];
        if (this.inCompare) {
            this.changeStyles(true);
        } else {
            this.changeStyles(false);
        }
    }

    hangEvents() {
        this.compareIconDefault = this.compareButton.querySelector('.product-compare__default');
        this.compareIconActive = this.compareButton.querySelector('.product-compare__active');
        this.compareButton.addEventListener('click', async() => this.changeCompare())
    }

    async changeCompare() {
        this.compareButton.style.pointerEvents = 'none';
        if (this.inCompare) {
            await this.deleteCompare();
        } else {
            await this.addCompare();
        }
        this.compareButton.style.pointerEvents = 'all';
    }

    async addCompare() {
        const response = await this.compareApi.addToCompare(this.productId);
        if (!response) {
            return;
        }
        this.changeStyles(true);
        this.inCompare = true;
    }

    async deleteCompare() {
        const response = await this.compareApi.deleteFromCompare(this.productId);
        if (!response) {
            return;
        }
        this.changeStyles(false);
        this.inCompare = false;
    }

    changeStyles(state = true) {
        if (state) {
            this.compareButton.classList.add('text-secondary', 'border-secondary', 'in-compare');
            this.compareIconDefault.style.display = 'none';
            this.compareIconActive.style.display = 'inline';
        } else {
            this.compareButton.classList.remove('text-secondary', 'border-secondary', 'in-compare');
            this.compareIconActive.style.display = 'none';
            this.compareIconDefault.style.display = 'inline';
        }
    }

    removePlaceholder() {
        const placeholder = this.compareButton.querySelector('.placeholder');
        placeholder.remove();
        const wrapper = this.compareButton.querySelector('.product-compare__wrapper');
        wrapper.style.visibility = 'visible';
    }
}