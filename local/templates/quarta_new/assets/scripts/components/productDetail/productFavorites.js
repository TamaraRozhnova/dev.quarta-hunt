class ProductFavorites {
    constructor(favoritesList) {
        this.productElement = document.querySelector('.product');
        this.productId = this.productElement.dataset.id;

        this.favoritesList = favoritesList;
        this.favoritesApi = new FavoritesApi();
        this.favoritesButton = this.productElement.querySelector('.product-fav');
        this.favoritesText = this.favoritesButton.querySelector('.product-fav__text');

        this.favoritesAvailableWindow = document.querySelector('.available-window__wrapper');
        this.favoritesAvailableActions = this.favoritesAvailableWindow.querySelector('.product-card__image-actions')

        this.favoritesAvailableFavoriteButton = this.favoritesAvailableWindow.querySelectorAll('.product-card__fav')

        this.favoritesAvailableFavoriteDefault = this.favoritesAvailableActions.querySelector('.product-card__fav--default')
        this.favoritesAvailableFavoriteActive = this.favoritesAvailableActions.querySelector('.product-card__fav--active')

        this.hangEvents();
        this.defineFavorites();
    }

    defineFavorites() {
        this.removePlaceholder();
        this.inFavorites = this.favoritesList[this.productId];
        if (this.inFavorites) {
            this.changeStyles(true);
        } else {
            this.changeStyles(false);
        }
    }

    hangEvents() {
        this.favoritesIconDefault = this.favoritesButton.querySelector('.product-fav__default');
        this.favoritesIconActive = this.favoritesButton.querySelector('.product-fav__active');

        this.favoritesButton.addEventListener('click', async() => this.changeFavorites())

        this.favoritesAvailableFavoriteButton.forEach( (btnFav) => {
            btnFav.addEventListener('click', async() => this.changeFavorites())
        })

    }

    async changeFavorites() {
        this.favoritesButton.style.pointerEvents = 'none';
        if (this.inFavorites) {
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
        this.changeStyles(true);
        this.inFavorites = true;
    }

    async deleteFavorites() {
        const response = await this.favoritesApi.deleteFromFavorites(this.productId);
        if (!response) {
            return;
        }
        this.changeStyles(false);
        this.inFavorites = false;
    }

    changeStyles(state = true) {
        if (state) {
            this.favoritesButton.classList.add('text-secondary', 'border-secondary', 'in-fav');
            this.favoritesIconDefault.style.display = 'none';
            this.favoritesIconActive.style.display = 'inline';
            this.favoritesText.textContent = 'В избранном';

            /** Смена стилей для модального окна */
            if (this.favoritesAvailableWindow != null) {
                this.favoritesAvailableFavoriteDefault.style.display = 'none';
                this.favoritesAvailableFavoriteActive.style.display = 'inline';
            } 

        } else {
            this.favoritesButton.classList.remove('text-secondary', 'border-secondary', 'in-fav');
            this.favoritesIconActive.style.display = 'none';
            this.favoritesIconDefault.style.display = 'inline';
            this.favoritesText.textContent = 'В избранное';

            /** Смена стилей для модального окна */
            if (this.favoritesAvailableWindow != null) {
                this.favoritesAvailableFavoriteDefault.style.display = 'inline';
                this.favoritesAvailableFavoriteActive.style.display = 'none';
            } 

        }
    }

    removePlaceholder() {
        const placeholder = this.favoritesButton.querySelector('.placeholder');
        placeholder.remove();
        const wrapper = this.favoritesButton.querySelector('.product-fav__wrapper');
        wrapper.style.visibility = 'visible';
    }
}