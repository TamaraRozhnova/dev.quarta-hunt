class ProductCardFavorites {
    constructor(data = {
                    productElement,
                    favoritesList
                }, events = {
                    onDelete
                }
    ) {
        this.productElement = data.productElement;
        this.productId = this.productElement.dataset.id;
        this.favoritesList = data.favoritesList;

        this.onDelete = events.onDelete;

        this.favoritesApi = new FavoritesApi();

        this.hangEvents();
        this.defineFavorites();
    }

    defineFavorites() {
        this.removePlaceholder();
        const inFavorites = this.favoritesList[this.productId];
        if (inFavorites) {
            this.changeStyles(true);
        } else {
            this.changeStyles(false);
        }
    }

    hangEvents() {
        this.productId = this.productElement.dataset.id;
        this.favoritesIconDefault = this.productElement.querySelector('.product-card__fav--default');
        if (this.favoritesIconDefault && this.favoritesIconDefault != null) {
            this.favoritesIconDefault.addEventListener('click', async () => this.addFavorites());
        }
        this.favoritesIconActive = this.productElement.querySelector('.product-card__fav--active');
        if (this.favoritesIconActive && this.favoritesIconActive != null) {
            this.favoritesIconActive.addEventListener('click', async () => this.deleteFavorites());
        }

    }

    async addFavorites() {
        const response = await this.favoritesApi.addToFavorites(this.productId);
        if (!response) {
            return;
        }
        this.changeStyles(true);
    }

    async deleteFavorites() {
        const response = await this.favoritesApi.deleteFromFavorites(this.productId);
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

            if (this.favoritesIconDefault && this.favoritesIconDefault != null) {
                this.favoritesIconDefault.style.display = 'none';
            }

            if (this.favoritesIconActive && this.favoritesIconActive != null) {
                this.favoritesIconActive.style.display = 'inline';
            }
        } else {
            if (this.favoritesIconActive && this.favoritesIconActive != null) {
                this.favoritesIconActive.style.display = 'none';
            }
            if (this.favoritesIconDefault && this.favoritesIconDefault != null) {
                this.favoritesIconDefault.style.display = 'inline';
            }
        }
    }

    removePlaceholder() {
        const placeholder = this.productElement.querySelector('.placeholder--fav');
        if (placeholder && placeholder != null) {
            placeholder.remove();
        }
    }
}
