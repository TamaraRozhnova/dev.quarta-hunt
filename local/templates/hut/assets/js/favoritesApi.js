class FavoritesApi {
  constructor() {
    this.url = "/ajax/personal/favorites.php";
    this.action = {
      ADD: "ADD",
      DELETE: "DELETE",
      CLEAR: "CLEAR",
    };
    this.cookieFavoritesName = "hut_favorites";
    this.cookieLongevityDays = 365;

    this.headerTopFavoritesBadge = document.querySelector(
      ".menu__dop-link--favorites span"
    );
    this.isAuth = window.isAuth;
  }

  addProductToCookie(productId) {
    const cookie = Cookies.get(this.cookieFavoritesName);
    if (!cookie) {
      Cookies.set(this.cookieFavoritesName, JSON.stringify([productId]), {
        expires: this.cookieLongevityDays,
      });
      return;
    }
    const currentFavorites = JSON.parse(cookie);
    currentFavorites.push(productId);
    Cookies.set(this.cookieFavoritesName, JSON.stringify(currentFavorites), {
      expires: this.cookieLongevityDays,
    });
  }

  deleteProductFromCookie(productId) {
    const cookie = Cookies.get(this.cookieFavoritesName);
    if (!cookie) {
      return;
    }
    let currentFavorites = JSON.parse(cookie);
    currentFavorites = currentFavorites.filter(
      (favorite) => favorite !== productId
    );
    Cookies.set(this.cookieFavoritesName, JSON.stringify(currentFavorites), {
      expires: this.cookieLongevityDays,
    });
  }

  clearCookie() {
    Cookies.remove(this.cookieFavoritesName);
  }

  async addToFavorites(productId) {
    if (!this.isAuth) {
      this.addProductToCookie(productId);
      window.favoritesCount++;
      this.displayFavoritesCount();
      return true;
    }
    const data = { action: this.action.ADD, id: productId };
    const response = await Request.fetch(this.url, data);
    if (response) {
      window.favoritesCount++;
      this.displayFavoritesCount();
    }
    return response;
  }

  async deleteFromFavorites(productId) {
    if (!this.isAuth) {
      this.deleteProductFromCookie(productId);
      window.favoritesCount--;
      this.displayFavoritesCount();
      return true;
    }
    const data = { action: this.action.DELETE, id: productId };
    const response = await Request.fetch(this.url, data);
    if (response) {
      window.favoritesCount--;
      this.displayFavoritesCount();
    }
    return response;
  }

  async clearFavorites() {
    if (!this.isAuth) {
      this.clearCookie();
      window.favoritesCount = 0;
      this.displayFavoritesCount();
      return true;
    }
    const data = { action: this.action.CLEAR };
    const response = await Request.fetch(this.url, data);
    if (response) {
      window.favoritesCount = 0;
      this.displayFavoritesCount();
    }
    return response;
  }

  displayFavoritesCount() {
    if (!window.favoritesCount) {
      this.headerTopFavoritesBadge.style.display = "none";
      return;
    }
    this.headerTopFavoritesBadge.textContent = window.favoritesCount;
    this.headerTopFavoritesBadge.style.display = "flex";
  }
}
