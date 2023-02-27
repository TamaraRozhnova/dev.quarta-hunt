class FavoritesApi {
    constructor() {
        this.url = '/ajax/personal/favorites.php';
        this.action = {
            ADD: 'ADD',
            DELETE: 'DELETE'
        }
        this.cookieFavoritesName = 'favorites';
        this.cookieLongevityDays = 365;

        this.headerTopFavoritesBadge = document.querySelector('.header__top-item .favorites-badge');
        this.headerBottomFavoritesBadge = document.querySelector('.header__bottom-item .favorites-badge');
        this.favoritesCount = window.favoritesCount || 0;
        this.isAuth = window.isAuth;
    }

    addProductToCookie(productId) {
        const cookie = Cookies.get(this.cookieFavoritesName);
        if (!cookie) {
            Cookies.set(this.cookieFavoritesName, JSON.stringify([productId]), { expires: this.cookieLongevityDays });
            return;
        }
        const currentFavorites = JSON.parse(cookie);
        currentFavorites.push(productId);
        Cookies.set(this.cookieFavoritesName, JSON.stringify(currentFavorites), { expires: this.cookieLongevityDays });
    }

    deleteProductFromCookie(productId) {
        const cookie = Cookies.get(this.cookieFavoritesName);
        if (!cookie) {
            return;
        }
        let currentFavorites = JSON.parse(cookie);
        currentFavorites = currentFavorites.filter(favorite => favorite !== productId);
        Cookies.set(this.cookieFavoritesName, JSON.stringify(currentFavorites), { expires: this.cookieLongevityDays });
    }

    async addToFavorites(productId) {
        if (!this.isAuth) {
            this.addProductToCookie(productId);
            this.favoritesCount++;
            this.displayFavoritesCount();
            return true;
        }
        const data = { action: this.action.ADD, id: productId }
        const response = await Request.fetch(this.url, data);
        if (response) {
            this.favoritesCount++;
            this.displayFavoritesCount();
        }
        return response;
    }

    async deleteFromFavorites(productId) {
        if (!this.isAuth) {
            this.deleteProductFromCookie(productId);
            this.favoritesCount--;
            this.displayFavoritesCount();
            return true;
        }
        const data = { action: this.action.DELETE, id: productId }
        const response = await Request.fetch(this.url, data);
        if (response) {
            this.favoritesCount--;
            this.displayFavoritesCount();
        }
        return response;
    }

    displayFavoritesCount() {
        if (!this.favoritesCount) {
            this.headerTopFavoritesBadge.style.display = 'none';
            this.headerBottomFavoritesBadge.style.display = 'none';
            return;
        }
        this.headerTopFavoritesBadge.textContent = this.favoritesCount;
        this.headerTopFavoritesBadge.style.display = 'block';
        this.headerBottomFavoritesBadge.textContent = this.favoritesCount;
        this.headerBottomFavoritesBadge.style.display = 'flex';
    }
}