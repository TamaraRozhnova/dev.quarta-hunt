class ProductFavorites {
    constructor() {
        this.productElement = document.querySelector('.product');
        this.productId = this.productElement.dataset.id;
        this.favoritesApi = new FavoritesApi();
        this.favoritesButton = this.productElement.querySelector('.product-fav');
        this.favoritesText = this.favoritesButton.querySelector('span');

        this.inFav = this.favoritesButton.classList.contains('in-fav');

        this.hangEvents();
    }

    hangEvents() {
        this.favoritesIconDefault = this.favoritesButton.querySelector('.product-fav__default');
        this.favoritesIconActive = this.favoritesButton.querySelector('.product-fav__active');
        this.favoritesButton.addEventListener('click', async() => this.changeFavorites())
    }

    async changeFavorites() {
        this.favoritesButton.style.pointerEvents = 'none';
        if (this.inFav) {
            await this.deleteFavorites();
        } else {
            await this.addFavorites();
        }
        this.favoritesButton.style.pointerEvents = 'all';
    }

    async addFavorites() {
        const response = await this.favoritesApi.addToFavorites(this.productId);
        if (!response) {
            return;
        }
        this.changeButtonClasses(true);
        this.favoritesIconDefault.style.display = 'none';
        this.favoritesIconActive.style.display = 'inline';
        this.favoritesText.textContent = 'В избранном';
        this.inFav = true;
    }

    async deleteFavorites() {
        const response = await this.favoritesApi.deleteFromFavorites(this.productId);
        if (!response) {
            return;
        }
        this.changeButtonClasses(false);
        this.favoritesIconActive.style.display = 'none';
        this.favoritesIconDefault.style.display = 'inline';
        this.favoritesText.textContent = 'В избранное';
        this.inFav = false;
    }

    changeButtonClasses(state = true) {
        if (state) {
            this.favoritesButton.classList.add('text-secondary', 'border-secondary', 'in-fav');
        } else {
            this.favoritesButton.classList.remove('text-secondary', 'border-secondary', 'in-fav');
        }
    }
}