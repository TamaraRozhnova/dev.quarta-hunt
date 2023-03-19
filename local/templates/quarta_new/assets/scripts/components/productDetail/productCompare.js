class ProductCompare {
    constructor() {
        this.productElement = document.querySelector('.product');
        this.productId = this.productElement.dataset.id;
        this.compareApi = new CompareApi();
        this.compareButton = this.productElement.querySelector('.product-compare');

        this.inCompare = this.compareButton.classList.contains('in-compare');

        this.hangEvents();
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
        this.changeButtonClasses(true);
        this.compareIconDefault.style.display = 'none';
        this.compareIconActive.style.display = 'inline';
        this.inCompare = true;
    }

    async deleteCompare() {
        const response = await this.compareApi.deleteFromCompare(this.productId);
        if (!response) {
            return;
        }
        this.changeButtonClasses(false);
        this.compareIconActive.style.display = 'none';
        this.compareIconDefault.style.display = 'inline';
        this.inCompare = false;
    }

    changeButtonClasses(state = true) {
        if (state) {
            this.compareButton.classList.add('text-secondary', 'border-secondary', 'in-compare');
        } else {
            this.compareButton.classList.remove('text-secondary', 'border-secondary', 'in-compare');
        }
    }
}