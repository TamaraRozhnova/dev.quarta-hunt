class ProductCardCompare {
    constructor(productElement) {
        this.productElement = productElement;
        this.compareApi = new CompareApi();

        this.hangEvents();
    }

    hangEvents() {
        const productId = this.productElement.dataset.id;
        const compareIconDefault = this.productElement.querySelector('.product-card__compare--default');
        const compareIconActive = this.productElement.querySelector('.product-card__compare--active');

        compareIconDefault.addEventListener('click', async () => this.addCompare(compareIconDefault, compareIconActive, productId));
        compareIconActive.addEventListener('click', async () => this.deleteCompare(compareIconDefault, compareIconActive, productId));
    }

    async addCompare(compareIconDefault, compareIconActive, productId) {
        const response = await this.compareApi.addToCompare(productId);
        if (!response) {
            return;
        }
        compareIconDefault.style.display = 'none';
        compareIconActive.style.display = 'inline';
    }

    async deleteCompare(compareIconDefault, compareIconActive, productId) {
        const response = await this.compareApi.deleteFromCompare(productId);
        if (!response) {
            return;
        }
        compareIconActive.style.display = 'none';
        compareIconDefault.style.display = 'inline';
    }
}