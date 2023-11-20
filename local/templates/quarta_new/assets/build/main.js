class BasketApi {
  constructor() {
    (this.url = "/ajax/personal/basket.php"),
      (this.action = {
        ADD: "ADD",
        SET_QUANTITY: "SET_QUANTITY",
        DELETE: "DELETE",
        GET_COUNT: "GET_COUNT",
        GET_AVAILABLE_OFFERS_FOR_PURCHASING:
          "GET_AVAILABLE_OFFERS_FOR_PURCHASING",
        GET_AVAILABLE_OFFERS_FOR_DELETING: "GET_AVAILABLE_OFFERS_FOR_DELETING",
      }),
      (this.headerTopBasketBadge = document.querySelector(
        ".header__top-item .basket-badge"
      )),
      (this.headerBottomBasketBadge = document.querySelector(
        ".header__bottom-item .basket-badge"
      ));
  }
  async getBasketCount() {
    var t = { action: this.action.GET_COUNT };
    return Request.fetch(this.url, t);
  }
  async getAvailableOffersForPurchasing(t) {
    t = { action: this.action.GET_AVAILABLE_OFFERS_FOR_PURCHASING, id: t };
    return Request.fetch(this.url, t);
  }
  async getAvailableOffersForDeleting(t) {
    t = { action: this.action.GET_AVAILABLE_OFFERS_FOR_DELETING, id: t };
    return Request.fetch(this.url, t);
  }
  async addToBasket(t, e = 1) {
    (t = { action: this.action.ADD, id: t, quantity: e }),
      (e = await Request.fetch(this.url, t));
    return e && this.displayBasketItemsCount(), e;
  }
  async setProductQuantityToBasket(t, e) {
    (t = { action: this.action.SET_QUANTITY, id: t, quantity: e }),
      (e = await Request.fetch(this.url, t));
    return "number" == typeof e && this.displayBasketItemsCount(), e;
  }
  async deleteFromBasket(t, e = 1) {
    (t = { action: this.action.DELETE, id: t, quantity: e }),
      (e = await Request.fetch(this.url, t));
    return e && this.displayBasketItemsCount(), e;
  }
  displayBasketItemsCount() {
    this.getBasketCount().then((t) => {
      t
        ? ((this.headerTopBasketBadge.textContent = t),
          (this.headerTopBasketBadge.style.display = "block"),
          (this.headerBottomBasketBadge.textContent = t),
          (this.headerBottomBasketBadge.style.display = "flex"))
        : ((this.headerTopBasketBadge.style.display = "none"),
          (this.headerBottomBasketBadge.style.display = "none"));
    });
  }
}
class CompareApi {
  constructor() {
    (this.url = "/ajax/personal/compare.php"),
      (this.action = {
        ADD: "ADD_TO_COMPARE_LIST",
        DELETE: "DELETE_FROM_COMPARE_LIST",
        CLEAR: "CLEAR",
      }),
      (this.headerTopCompareBadge = document.querySelector(
        ".header__top-item .compare-badge"
      )),
      (this.headerBottomCompareBadge = document.querySelector(
        ".header__bottom-item .compare-badge"
      ));
  }
  async addToCompare(e) {
    e = await Request.fetch(`${this.url}?action=${this.action.ADD}&id=` + e);
    return e && (window.compareCount++, this.displayCompareCount()), e;
  }
  async deleteFromCompare(e) {
    e = await Request.fetch(`${this.url}?action=${this.action.DELETE}&id=` + e);
    return e && (window.compareCount--, this.displayCompareCount()), e;
  }
  async clearCompare() {
    var e = await Request.fetch(this.url + "?action=" + this.action.CLEAR);
    return e && ((window.compareCount = 0), this.displayCompareCount()), e;
  }
  displayCompareCount() {
    window.compareCount
      ? ((this.headerTopCompareBadge.textContent = window.compareCount),
        (this.headerTopCompareBadge.style.display = "block"),
        (this.headerBottomCompareBadge.textContent = window.compareCount),
        (this.headerBottomCompareBadge.style.display = "flex"))
      : ((this.headerTopCompareBadge.style.display = "none"),
        (this.headerBottomCompareBadge.style.display = "none"));
  }
}
class FavoritesApi {
  constructor() {
    (this.url = "/ajax/personal/favorites.php"),
      (this.action = { ADD: "ADD", DELETE: "DELETE", CLEAR: "CLEAR" }),
      (this.cookieFavoritesName = "favorites"),
      (this.cookieLongevityDays = 365),
      (this.headerTopFavoritesBadge = document.querySelector(
        ".header__top-item .favorites-badge"
      )),
      (this.headerBottomFavoritesBadge = document.querySelector(
        ".header__bottom-item .favorites-badge"
      )),
      (this.isAuth = window.isAuth);
  }
  addProductToCookie(t) {
    var e = Cookies.get(this.cookieFavoritesName);
    e
      ? ((e = JSON.parse(e)).push(t),
        Cookies.set(this.cookieFavoritesName, JSON.stringify(e), {
          expires: this.cookieLongevityDays,
        }))
      : Cookies.set(this.cookieFavoritesName, JSON.stringify([t]), {
          expires: this.cookieLongevityDays,
        });
  }
  deleteProductFromCookie(e) {
    var o = Cookies.get(this.cookieFavoritesName);
    if (o) {
      let t = JSON.parse(o);
      (t = t.filter((t) => t !== e)),
        Cookies.set(this.cookieFavoritesName, JSON.stringify(t), {
          expires: this.cookieLongevityDays,
        });
    }
  }
  clearCookie() {
    Cookies.remove(this.cookieFavoritesName);
  }
  async addToFavorites(t) {
    var e;
    return this.isAuth
      ? ((e = { action: this.action.ADD, id: t }),
        (e = await Request.fetch(this.url, e)) &&
          (window.favoritesCount++, this.displayFavoritesCount()),
        e)
      : (this.addProductToCookie(t),
        window.favoritesCount++,
        this.displayFavoritesCount(),
        !0);
  }
  async deleteFromFavorites(t) {
    var e;
    return this.isAuth
      ? ((e = { action: this.action.DELETE, id: t }),
        (e = await Request.fetch(this.url, e)) &&
          (window.favoritesCount--, this.displayFavoritesCount()),
        e)
      : (this.deleteProductFromCookie(t),
        window.favoritesCount--,
        this.displayFavoritesCount(),
        !0);
  }
  async clearFavorites() {
    var t;
    return this.isAuth
      ? ((t = { action: this.action.CLEAR }),
        (t = await Request.fetch(this.url, t)) &&
          ((window.favoritesCount = 0), this.displayFavoritesCount()),
        t)
      : (this.clearCookie(),
        (window.favoritesCount = 0),
        this.displayFavoritesCount(),
        !0);
  }
  displayFavoritesCount() {
    window.favoritesCount
      ? ((this.headerTopFavoritesBadge.textContent = window.favoritesCount),
        (this.headerTopFavoritesBadge.style.display = "block"),
        (this.headerBottomFavoritesBadge.textContent = window.favoritesCount),
        (this.headerBottomFavoritesBadge.style.display = "flex"))
      : ((this.headerTopFavoritesBadge.style.display = "none"),
        (this.headerBottomFavoritesBadge.style.display = "none"));
  }
}
class ProductsDataApi {
  constructor() {
    this.url = "/ajax/products/productsData.php";
  }
  async getData(t) {
    return Request.fetch(this.url, { productIds: t });
  }
}
class Request {
  static async fetch(t, e = null) {
    var a = { method: "GET", headers: { "Content-Type": "application/json" } };
    return (
      e && ((a.method = "POST"), (a.body = JSON.stringify(e))),
      (await fetch(t, a)).json()
    );
  }
  static async fetchWithFormData(t, e) {
    return (await fetch(t, { method: "POST", body: e })).json();
  }
  static async fetchHtml(t, e = null) {
    return (
      e && (t += "?" + new URLSearchParams(e)),
      (
        await fetch(t, {
          method: "GET",
          headers: { "Content-Type": "text/html", "x-requested-with": "Y" },
        })
      ).text()
    );
  }
}
class ReviewsApi {
  constructor() {
    (this.ajaxAddReviewUrl = "/ajax/feedback/addReview.php"),
      (this.ajaxGetReviewsUrl = "/ajax/feedback/getReviews.php"),
      (this.ajaxUpdateReviewUrl = "/ajax/feedback/updateReview.php"),
      (this.updateReviewAction = {
        LIKE: "LIKE",
        DISLIKE: "DISLIKE",
        RESPONSE: "RESPONSE",
      }),
      (this.isAuth = window.isAuth);
  }
  async addReview(e) {
    return Request.fetchWithFormData(this.ajaxAddReviewUrl, e);
  }
  async addResponseToReview(e, t) {
    e = {
      action: this.updateReviewAction.RESPONSE,
      reviewId: e,
      responseText: t,
    };
    return Request.fetch(this.ajaxUpdateReviewUrl, e);
  }
  async changeLike(e) {
    e = { action: this.updateReviewAction.LIKE, reviewId: e };
    return Request.fetch(this.ajaxUpdateReviewUrl, e);
  }
  async changeDislike(e) {
    e = { action: this.updateReviewAction.DISLIKE, reviewId: e };
    return Request.fetch(this.ajaxUpdateReviewUrl, e);
  }
  async getReviews(e, t) {
    return Request.fetchHtml(this.ajaxGetReviewsUrl, { productId: e, sort: t });
  }
}
class ActionProductsSlider {
  constructor() {
    (this.actionSliderSelector = ".swiper-container_action"), this.makeSlider();
  }
  makeSlider() {
    var e = {
      default: {
        slidesPerView: 2,
        spaceBetween: 15,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      },
      [BaseSlider.breakpointMobile]: { spaceBetween: 20 },
    };
    new BaseSlider(this.actionSliderSelector, e).makeSlider();
  }
}
class BaseSlider {
  static breakpointMobile = 576;
  static breakpointTablet = 992;
  constructor(
    e = ".swiper",
    t = {
      [BaseSlider.breakpointTablet]: {},
      [BaseSlider.breakpointMobile]: {},
      default: {},
    }
  ) {
    (this.swiperSelector = e), (this.options = t);
  }
  makeSlider() {
    return new Swiper(this.swiperSelector, {
      slidesPerView: 1,
      spaceBetween: 20,
      navigation: {
        nextEl: ".base-slider__next",
        prevEl: ".base-slider__prev",
      },
      ...this.options.default,
      breakpoints: { ...this.makeBreakPoints() },
    });
  }
  makeBreakPoints() {
    const t = {};
    return (
      Object.keys(this.options).forEach((e) => {
        e == BaseSlider.breakpointMobile && (t[e] = { slidesPerView: 2 }),
          Object.keys(this.options[e]).length &&
            "default" !== e &&
            (t[e] = { ...this.options[e] });
      }),
      t
    );
  }
}
class Breadcrumbs {
  constructor(e = 0) {
    (this.body = document.querySelector("body")),
      (this.dots = document.querySelector(".breadcrumbs__dots")),
      (this.blackBg = document.querySelector(".black-bg")),
      (this.breadPopup = document.querySelector(".breadcrumb__popup")),
      this.breadPopup && (this.cross = this.breadPopup.querySelector(".cross")),
      this.bindEvents();
  }
  bindEvents() {
    this.openBreadPopup(), this.closeBreadPopup(), this.closeBreadPopupOnBack();
  }
  openBreadPopupHandler() {
    this.breadPopup.classList.add("open"),
      this.body.classList.add("stop-scrolling-bread"),
      (this.blackBg.style.display = "block");
  }
  closeBreadPopupHandler() {
    this.breadPopup.classList.remove("open"),
      this.body.classList.remove("stop-scrolling-bread"),
      (this.blackBg.style.display = "none");
  }
  openBreadPopup() {
    this.dots &&
      this.dots.addEventListener(
        "click",
        this.openBreadPopupHandler.bind(this),
        !1
      );
  }
  closeBreadPopupOnBack() {
    this.blackBg &&
      this.blackBg.addEventListener(
        "click",
        this.closeBreadPopupHandler.bind(this),
        !1
      );
  }
  closeBreadPopup() {
    this.cross &&
      this.cross.addEventListener(
        "click",
        this.closeBreadPopupHandler.bind(this),
        !1
      );
  }
}
window.addEventListener("DOMContentLoaded", () => {
  window.innerWidth < 500 && new Breadcrumbs();
});
class CatalogFilter {
  constructor() {
    this.initDefaultVars(),
      (this.filterApplied = !0),
      (this.filterParams = { FILTER_ITEMS: {} }),
      (this.productsDataApi = new ProductsDataApi()),
      this.createElements(),
      this.hangEvents();
  }
  hangEvents() {
    this.filterSections.forEach((e) => this.hangExpandSectionEvent(e)),
      this.filterCheckboxes.forEach((e) => this.hangChangeCheckboxEvent(e)),
      this.listCountElements.forEach((e) =>
        this.hangChangeProductsCountEvent(e)
      ),
      this.hangPaginationEvents(),
      this.hangAvailableEvent(),
      this.hangFiltersClearEvent(),
      this.hangFiltersExtraClearEvent(),
      this.hangOpenMobileFilterEvent(),
      this.hangOpenCloseFilterEvent(),
      this.setBadges(),
      this.hangProductCardsEvents();
  }
  initDefaultVars() {
    (this.productsDataBlock = document.querySelector(".products-data")),
      (this.mainFiltersWrapper = document.querySelector(
        ".category__filter-wrap"
      )),
      (this.mainFilters = this.mainFiltersWrapper.querySelector(".filters")),
      (this.clearFilterButton =
        this.mainFilters.querySelector(".filters__clear")),
      (this.filterSections =
        this.mainFilters.querySelectorAll(".filters-section")),
      (this.filterCheckboxes = this.mainFilters.querySelectorAll(
        '.filters-item input[type="checkbox"]'
      )),
      (this.filterBtnOnCheckBox = document.querySelector(
        ".filters__accept-on-item-wrapper"
      )),
      (this.filterBtnApplyFilter = document.querySelector(
        ".filters__btn-apply"
      )),
      (this.mobileFilterOpenButton =
        document.querySelector(".filters-sort__btn")),
      (this.mobileFilterCloseButton = document.querySelector(
        ".filters__accept-btn"
      )),
      (this.filterChangeButton = document.querySelector(
        ".filters__accept-on-item"
      )),
      (this.filterBtnApplyFilterWrapper = document.querySelector(
        ".filters-section-btns"
      )),
      (this.loader = document.querySelector(".loading")),
      (this.categoryHeaderContainer =
        document.querySelector(".category__header")),
      (this.extraFilters = document.querySelector(".filters-sort")),
      (this.availableCheckbox = this.extraFilters.querySelector("#available")),
      (this.selectSortElement =
        this.extraFilters.querySelector("#select-sort")),
      (this.selectCountElement =
        this.extraFilters.querySelector("#select-count")),
      (this.listCountElements =
        this.extraFilters.querySelectorAll("#list-count li"));
  }
  reinitHangFilter() {
    this.createPriceField(),
      this.initDefaultVars(),
      this.filterSections.forEach((e) => this.hangExpandSectionEvent(e)),
      this.filterCheckboxes.forEach((e) => this.hangChangeCheckboxEvent(e)),
      this.hangOpenCloseFilterEvent(),
      this.hangCloseAllApplyBnts(),
      this.hangFiltersClearEvent();
  }
  hangOpenMobileFilterEvent() {
    this.mobileFilterOpenButton.onclick = () => {
      this.mainFiltersWrapper.classList.add("category__filter-wrap--show");
    };
  }
  hangCloseAllApplyBnts() {
    991 <= window.innerWidth &&
      ((this.filterBtnOnCheckBox.style.display = "none"),
      (this.filterBtnApplyFilterWrapper.style.display = "none"));
  }
  hangOpenCloseFilterEvent() {
    (this.mobileFilterCloseButton.onclick = () => {
      this.mainFiltersWrapper.classList.remove("category__filter-wrap--show"),
        this.handleChangeFilters(this.filterParams);
    }),
      (this.filterChangeButton.onclick = () => {
        this.hangCloseAllApplyBnts(),
          this.handleChangeFilters(this.filterParams);
      }),
      (this.filterBtnApplyFilter.onclick = () => {
        this.hangCloseAllApplyBnts(),
          this.handleChangeFilters(this.filterParams);
      });
  }
  hangPaginationEvents() {
    (this.paginationElements = document.querySelectorAll(".pagination div")),
      this.paginationElements.length &&
        this.paginationElements.forEach((i) => {
          i.onclick = () => {
            var e = i.dataset.id,
              t = new URL(window.location.href);
            new URLSearchParams(t.search).get("PAGEN_1") != e &&
              this.handleChangeFilters({ PAGEN_1: e });
          };
        });
  }
  hangChangeProductsCountEvent(t) {
    t.onclick = () => {
      var e = t.dataset.id;
      this.selectorCount.getValue() != e &&
        (this.changeProductsCountClasses(t),
        this.selectorCount.setValue(e),
        this.handleChangeFilters({ itemsPerPage: e }));
    };
  }
  handleChangeFilters(e = null, t = !0) {
    e = this.createNewUrl(e);
    this.changeScroll(),
      this.fetchProducts(e).then((e) => {
        e && this.insertHtml(e);
      }),
      t && this.changeUrl(e);
  }
  hangAvailableEvent() {
    this.availableCheckbox.onchange = () => {
      var e = !!this.availableCheckbox.checked;
      this.handleChangeFilters({ onlyAvailable: e });
    };
  }
  hangFiltersClearEvent() {
    this.clearFilterButton.onclick = () => {
      this.resetControls(),
        this.hangCloseAllApplyBnts(),
        document.documentElement.clientWidth <= 991 &&
          this.mainFiltersWrapper.classList.remove(
            "category__filter-wrap--show"
          ),
        this.handleChangeFilters();
    };
  }
  hangFiltersExtraClearEvent() {
    (this.clearFilterExtraButton = document.querySelector(
      ".products-not-found__button"
    )),
      this.clearFilterExtraButton &&
        (this.clearFilterExtraButton.onclick = () => {
          event.preventDefault(),
            this.filterApplied &&
              (this.resetControls(), this.handleChangeFilters());
        });
  }
  hangChangeCheckboxEvent(l) {
    l.onchange = () => {
      var e = l.id,
        t = l.checked ? "Y" : "";
      if (
        ((this.filterParams.MULTI_OBJECT = "Y"),
        (this.filterParams.FILTER_ITEMS[e] = t),
        this.setBadges(),
        991 <= window.innerWidth)
      ) {
        var i,
          e = document.body.getBoundingClientRect(),
          t = l.getBoundingClientRect(),
          s = t.top - e.top,
          t = t.left - e.left,
          e = l.closest(".filters-item"),
          r = e.closest(".filters-section"),
          r = window.getComputedStyle(r, null).getPropertyValue("padding-left"),
          r = Number(r.replace("px", ""));
        (this.filterBtnOnCheckBox.style.display = "block"),
          (this.filterBtnApplyFilterWrapper.style.display = "block"),
          (this.filterBtnOnCheckBox.style.top = s - e.offsetHeight + "px"),
          (this.filterBtnOnCheckBox.style.left =
            t + e.offsetWidth + r / 2 + "px");
        for (i of Object.keys(this.filterParams.FILTER_ITEMS))
          if ("Y" == this.filterParams.FILTER_ITEMS[i]) return !1;
        this.hangCloseAllApplyBnts();
      }
    };
  }
  changeScroll() {
    1200 <= window.innerWidth
      ? this.categoryHeaderContainer.scrollIntoView(!1)
      : document.body.scrollIntoView();
  }
  changeProductsCountClasses(e) {
    this.extraFilters
      .querySelector("#list-count li.active")
      .classList.remove("active"),
      e.classList.add("active");
  }
  insertHtml(e) {
    var e = new DOMParser().parseFromString(e, "text/html"),
      t = e.querySelector(".products-data"),
      e = e.querySelector(".category__filter-wrap"),
      i = this.mainFiltersWrapper.querySelectorAll(
        ".filters__wr .filters-section"
      ),
      s = e.querySelectorAll(".filters__wr .filters-section");
    if (0 < i.length && 0 < s.length) {
      for (let e = 0; e < i.length; e++)
        i[e].classList.contains("filters-section--expanded") &&
          s[e].classList.add("filters-section--expanded");
      this.mainFiltersWrapper.innerHTML = e.innerHTML;
    }
    (this.productsDataBlock.innerHTML = t.innerHTML),
      this.reinitHangFilter(),
      this.setBadges(),
      this.hangFiltersExtraClearEvent(),
      this.hangPaginationEvents(),
      this.hangProductCardsEvents();
  }
  resetControls() {
    (this.availableCheckbox.checked = !1),
      this.filterCheckboxes.forEach((e) => (e.checked = !1)),
      this.selectorSort.resetValue(),
      this.selectorCount.resetValue(),
      this.inputMinPrice.clear(),
      this.inputMaxPrice.clear(),
      (this.filterParams.FILTER_ITEMS = {});
    var e = this.extraFilters.querySelector("#list-count li:first-of-type");
    this.changeProductsCountClasses(e), this.setBadges();
  }
  setLoader(e = !0) {
    e
      ? ((this.mainFilters.style.pointerEvents = "none"),
        (this.extraFilters.style.pointerEvents = "none"),
        (this.mobileFilterCloseButton.style.pointerEvents = "all"),
        (this.filterChangeButton.style.pointerEvents = "all"),
        this.loader.classList.add("loading--show"),
        this.productsDataBlock.classList.remove("products-data--show"))
      : ((this.mainFilters.style.pointerEvents = "all"),
        (this.extraFilters.style.pointerEvents = "all"),
        this.loader.classList.remove("loading--show"),
        this.productsDataBlock.classList.add("products-data--show"));
  }
  changeUrl(e) {
    var e = new URL(e),
      t = new URLSearchParams(e.search),
      t = (t.delete("minPrice"), t.delete("maxPrice"), t.toString());
    history.pushState(
      history.state,
      "",
      "" + e.origin + e.pathname + (t ? "?" + t : "")
    );
  }
  createNewUrl(t = null) {
    var e = new URL(window.location.href);
    const i = new URLSearchParams(e.search);
    if (
      (i.set("minPrice", this.inputMinPrice.getValue()),
      i.set("maxPrice", this.inputMaxPrice.getValue()),
      !(this.filterApplied = !0) !== t)
    ) {
      if (!t) return (this.filterApplied = !1), "" + e.origin + e.pathname;
      t.hasOwnProperty("PAGEN_1") || i.set("PAGEN_1", "1"),
        "Y" == t.MULTI_OBJECT
          ? t.FILTER_ITEMS &&
            Object.keys(t.FILTER_ITEMS).forEach((e) => {
              t.FILTER_ITEMS[e] ? i.set(e, t.FILTER_ITEMS[e]) : i.delete(e);
            })
          : Object.keys(t).forEach((e) => {
              t[e] ? i.set(e, t[e]) : i.delete(e);
            }),
        i.set("set_filter", "Y");
    }
    return "" + e.origin + e.pathname + "?" + i.toString();
  }
  async fetchProducts(e) {
    try {
      return (
        this.setLoader(!0),
        await (
          await fetch(e, {
            method: "GET",
            headers: { "Content-Type": "text/html", "x-requested-with": "Y" },
          })
        ).text()
      );
    } finally {
      this.setLoader(!1);
    }
  }
  hangExpandSectionEvent(e) {
    e.querySelector(".filters-section__header").addEventListener(
      "click",
      () => {
        e.classList.toggle("filters-section--expanded");
      }
    );
  }
  createSelectorSort() {
    this.selectorSort = new Select({
      element: this.selectSortElement,
      onSelect: (e) => {
        this.handleChangeFilters({ sort: e });
      },
    });
  }
  createSelectorCount() {
    this.selectorCount = new Select({
      element: this.selectCountElement,
      onSelect: (e) => {
        var t = this.extraFilters.querySelector(
          `#list-count li[data-id="${e}"]`
        );
        this.changeProductsCountClasses(t),
          this.handleChangeFilters({ itemsPerPage: e });
      },
    });
  }
  createPriceField() {
    (this.inputMinPrice = new Input({
      inputSelector: "#min-price",
      withDebounce: !0,
      onChange: () => this.handleChangeFilters(!1, !1),
    })),
      (this.inputMaxPrice = new Input({
        inputSelector: "#max-price",
        withDebounce: !0,
        onChange: () => this.handleChangeFilters(!1, !1),
      }));
  }
  createElements() {
    this.createSelectorSort(),
      this.createSelectorCount(),
      this.createPriceField();
  }
  setBadges() {
    this.filterSections.forEach((e) => {
      var t = e.querySelectorAll('input[type="checkbox"]');
      const i = e.querySelector(".filters-section__header h6"),
        s = i.querySelector(".filters-section__header-badge");
      Array.from(t).every((e) => {
        var t;
        return (
          e.checked &&
            !s &&
            ((t = document.createElement("div")).classList.add(
              "filters-section__header-badge"
            ),
            i.insertAdjacentElement("beforeend", t)),
          !e.checked
        );
      }) &&
        s &&
        s.remove();
    });
  }
  getProductsIds() {
    var e = document.querySelectorAll(".product-card");
    return Array.from(e).map((e) => e.dataset.id);
  }
  hangProductCardsEvents() {
    var e = this.getProductsIds();
    e.length &&
      this.productsDataApi.getData(e).then((e) => {
        new ProductCards(e);
      });
  }
}
class DropDownMenu {
  dropDown;
  dropdownItems;
  width = 0;
  height = 0;
  shift = 0;
  constructor(
    e = { element: element, sections: sections, level: level, minHeight: 0 }
  ) {
    (this.element = e.element),
      (this.sections = e.sections),
      (this.level = e.level),
      (this.minHeight = e.minHeight),
      this.render(),
      this.makeActionsAfterRender();
  }
  makeActionsAfterRender() {
    this.getNewElements(),
      this.calculateShift(),
      this.setExtraStyles(),
      this.hydrateDropDown(),
      this.hydrateElements();
  }
  getNewElements() {
    (this.dropDown = this.element.querySelector(".nav-dropdown")),
      (this.dropdownItems = this.dropDown.querySelectorAll(".header-nav-item"));
  }
  hydrateDropDown() {
    var e = this.dropDown.querySelector("ul");
    new PerfectScrollbar(e);
  }
  hydrateElements() {
    this.dropdownItems.forEach((e) => {
      const t = e.dataset.id,
        i = this.sections[t].SUBSECTIONS;
      e.addEventListener("mouseenter", () => {
        var e = this.dropDown.querySelector(".nav-dropdown__wrapper");
        e && e.remove(),
          t &&
            i &&
            new DropDownMenu({
              element: this.dropDown,
              sections: i,
              level: this.level + 1,
              minHeight: this.height,
            });
      });
    });
  }
  render() {
    this.element.insertAdjacentHTML("beforeend", this.getHtml());
  }
  getHtml() {
    return `<div class="nav-dropdown__wrapper">
                <div class="nav-dropdown ${
                  this.isOddLevel() && " nav-dropdown--odd"
                }">
                    <ul>
                        ${this.getMenuItemsHtml()}
                    </ul>
                </div>
            </div>`;
  }
  getMenuItemsHtml() {
    return Object.keys(this.sections)
      .map((e) => {
        var { NAME: t, LINK: i } = this.sections[e];
        return `<li>
                    <div class="header-nav-item" data-id="${e}">
                        <a href="${i}">
                            <span>${t}</span>
                        </a>
                    </div>
                </li>`;
      })
      .join("");
  }
  setExtraStyles() {
    var e = this.width / 4 > -this.shift,
      t = {};
    this.minHeight && (t.minHeight = this.minHeight + "px"),
      this.shift < 0 && (t.transform = "translateX(-200%)"),
      this.shift < 0 &&
        (this.level <= 1 || e) &&
        (t.transform = `translateX(${this.shift}px)`),
      (this.dropDown.style.transform = t.transform),
      (this.dropDown.style.minHeight = t.minHeight);
  }
  calculateShift() {
    var e = this.dropDown.getBoundingClientRect(),
      e =
        ((this.width = e.width),
        (this.height = e.height),
        window.innerWidth - e.right);
    this.shift = e - window.catalogMenuContainer.right;
  }
  isOddLevel() {
    return this.level % 2 != 0;
  }
}
window.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".footer-collapse").forEach((e) => {
    e.querySelector(".footer-collapse__toggle--mobile").addEventListener(
      "click",
      () => {
        e.classList.toggle("footer-collapse--expanded");
      }
    );
  });
});
window.addEventListener("DOMContentLoaded", () => {
  const t = document.querySelector(".header__spot"),
    o = t.querySelector(".header__spot-dropdown");
  var e = t.querySelector(".header__spot > span"),
    n = document.querySelectorAll(".catalog-category-mobile");
  const r = document.querySelector(".mobile-nav");
  var c = document.querySelector(".header__button-mobile"),
    l = document.querySelector(".mobile-nav__close");
  const s = document.querySelector(".header__contacts");
  var a = document.querySelector(".header__button-contacts"),
    i = document.querySelectorAll(".header .search-input");
  const d = document.querySelector(".header--desktop"),
    u = d.querySelector(".row.header__top-row");
  1200 < window.innerWidth &&
    window.addEventListener("scroll", function () {
      if (50 < window.scrollY) {
        if (null != document.querySelector(".modal-overlay")) return !1;
        ((document.documentElement.scrollTop > d.offsetHeight + 50 &&
          "initial" == d.style.position) ||
          "" == d.style.position) &&
          ((u.style.display = "none"),
          (d.style.transform = "translateY(-100%)"),
          setTimeout(() => {
            (d.style.position = "sticky"), (d.style.transform = "initial");
          }, 250));
      }
      document.documentElement.scrollTop < d.offsetHeight - 100 &&
        ((u.style.display = "flex"), (d.style.position = "initial"));
    }),
    e.addEventListener("click", (e) => {
      e.stopPropagation(), t.classList.toggle("header__spot--show");
    }),
    window.addEventListener("click", (e) => {
      o.contains(e.target) || t.classList.remove("header__spot--show");
    }),
    n.forEach((e) => {
      e.querySelector(".catalog-category-mobile__title").addEventListener(
        "click",
        () => {
          e.classList.toggle("catalog-category-mobile--expanded");
        }
      );
    }),
    c.addEventListener("click", () => {
      r.classList.add("mobile-nav--show");
    }),
    l.addEventListener("click", () => {
      r.classList.remove("mobile-nav--show"),
        s.classList.remove("header__contacts--show");
    }),
    a.addEventListener("click", () => {
      s.classList.toggle("header__contacts--show");
    }),
    i.forEach((e) => {
      const t = e.querySelector("input");
      e = e.querySelector("button");
      t.addEventListener("keyup", (e) => {
        13 === e.keyCode && (window.location.href = "/search?q=" + t.value);
      }),
        e.addEventListener("click", (e) => {
          e.preventDefault(), (window.location.href = "/search?q=" + t.value);
        });
    });
});

class MainSlider {
  swiper = null;
  delay = 5e3;
  isHovered = !1;
  timerProgress = 0;
  fps = 30;
  timer = 0;
  interval = null;
  perimeter = 62.831853072;
  progressItems = [];
  wrapperDotItems = [];
  dotItems = [];
  circleItems = [];
  sliderProgressScroller = null;
  constructor(e = ".swiper", s = [], t = !1) {
    (this.swiperSelector = e), (this.sliderImages = s), (this.compact = t);
  }
  get getCurrentIndexSlider() {
    return this.swiper.realIndex ?? 0;
  }
  get countSlides() {
    return this.sliderImages.length;
  }
  get timePerTick() {
    return 1e3 / this.fps;
  }
  getExtraElements() {
    (this.progressItems = document.querySelectorAll(
      ".main-slider-progress__item"
    )),
      (this.wrapperDotItems = document.querySelectorAll(".main-slider__dot")),
      (this.dotItems = document.querySelectorAll(".main-slider-dot")),
      (this.circleItems = document.querySelectorAll(
        ".main-slider-dot svg circle:last-of-type"
      )),
      (this.sliderProgressScroller = document.querySelector(
        ".main-slider-progress__scroller-inner"
      ));
  }
  makeSlider() {
    this.displayImages(),
      (this.swiper = new Swiper(this.swiperSelector, {
        slidesPerView: 1,
        direction: "horizontal",
        height: this.compact ? 455 : 511,
        loop: !0,
        navigation: {
          nextEl: ".main-slider__arrow-next",
          prevEl: ".main-slider__arrow-prev",
        },
        on: { slideChangeTransitionEnd: () => this.changeSlideTransitionEnd() },
        breakpoints: {
          576: { height: this.compact ? 482 : 964 },
          992: { height: this.compact ? 318 : 635 },
        },
      })),
      this.getExtraElements(),
      this.hangEvents(),
      this.startTimer();
  }
  hangEvents() {
    var e = document.querySelector(".main-slider");
    e.addEventListener("mouseenter", () => {
      (this.isHovered = !0), this.stopTimer();
    }),
      e.addEventListener("mouseleave", () => {
        (this.isHovered = !1), this.startTimer();
      }),
      this.progressItems.forEach((e, s) => {
        e.addEventListener("click", () => this.swiper.slideTo(s + 1));
      }),
      this.wrapperDotItems.forEach((e, s) => {
        e.addEventListener("click", () => this.swiper.slideTo(s + 1));
      });
  }
  displayImages() {
    var e = document.querySelectorAll(".main-slider .swiper-slide");
    992 < window.innerWidth
      ? e.forEach(
          (e, s) =>
            (e.style.backgroundImage = `url(${this.sliderImages[s].IMAGE})`)
        )
      : e.forEach(
          (e, s) =>
            (e.style.backgroundImage = `url(${this.sliderImages[s].IMAGE_MOBILE})`)
        );
  }
  startTimer() {
    this.interval ||
      (this.interval = setInterval(() => this.tick(), 1e3 / this.fps));
  }
  stopTimer() {
    clearInterval(this.interval), (this.interval = null);
  }
  clearTimer() {
    this.timer = 0;
  }
  changeSlideTransitionEnd() {
    setTimeout(() => {
      this.handleActiveClasses(),
        this.handleProgressScrollerPosition(),
        this.stopTimer(),
        this.clearTimer(),
        this.isHovered || this.startTimer();
    });
  }
  handleActiveClasses() {
    const t = this.getCurrentIndexSlider;
    this.progressItems.forEach((e, s) => {
      s === t
        ? e.classList.add("main-slider-progress__item--active")
        : e.classList.remove("main-slider-progress__item--active");
    }),
      this.dotItems.forEach((e, s) => {
        s === t
          ? e.classList.add("main-slider-dot_active")
          : e.classList.remove("main-slider-dot_active");
      });
  }
  handleProgressScrollerPosition() {
    var e, s, t;
    this.sliderProgressScroller &&
      ((e = this.getCurrentIndexSlider),
      (s = this.countSlides),
      (this.sliderProgressScroller.style.left = (t = 100 / s) * e + "%"),
      (this.sliderProgressScroller.style.right = t * (s - e - 1) + "%"));
  }
  tick() {
    (this.timer = this.timer + this.timePerTick),
      (this.timerProgress = this.timer / this.delay),
      this.fillProgress(),
      this.timer >= this.delay &&
        (this.stopTimer(), this.clearTimer(), this.swiper.slideNext(300));
  }
  fillProgress() {
    var e;
    this.circleItems.length &&
      ((e = this.getCurrentIndexSlider),
      this.circleItems[e].setAttribute(
        "stroke-dasharray",
        this.perimeter * this.timerProgress +
          " " +
          (this.perimeter - this.perimeter * this.timerProgress)
      ));
  }
}
class ReviewAdding {
  constructor(e) {
    (this.ajaxUrl = "/ajax/feedback/addReview.php"),
      (this.productId = e),
      (this.reviewsApi = new ReviewsApi()),
      (this.addReviewElement = document.querySelector(".add-review")),
      this.addReviewElement &&
        ((this.rating = 0), this.hangEvents(), this.createElements());
  }
  createElements() {
    (this.inputImages = new InputFile({
      wrapperSelector: ".add-review .input-file",
      maxFiles: 3,
      maxSize: 5242880,
      showAddedFiles: !0,
    })),
      (this.textareaFlaws = new Input({
        wrapperSelector: ".add-review__flaws",
        inputSelector: "#flaws",
      })),
      (this.textareaDignities = new Input({
        wrapperSelector: ".add-review__dignities",
        inputSelector: "#dignities",
      })),
      (this.textareaComments = new Input({
        wrapperSelector: ".add-review__comments",
        inputSelector: "#comments",
      })),
      (this.controls = {
        flaws: this.textareaFlaws,
        dignities: this.textareaDignities,
        comments: this.textareaComments,
        images: this.inputImages,
      });
  }
  hangEvents() {
    (this.stars = this.addReviewElement.querySelectorAll(".add-review .star")),
      this.stars.forEach((e, t) => this.hangStarsEvents(e, t)),
      (this.form = this.addReviewElement.querySelector("form")),
      this.form.addEventListener("submit", (e) => this.handleSubmit(e));
  }
  hangStarsEvents(e, t) {
    (this.reviewsStarsElement =
      this.addReviewElement.querySelector(".add-review__stars")),
      this.reviewsStarsElement.addEventListener("mouseleave", () => {
        this.changeHoveredStars(0), this.insertDescriptionHtml(0);
      }),
      e.addEventListener("mouseenter", () => {
        this.changeHoveredStars(t + 1), this.insertDescriptionHtml(t + 1);
      }),
      e.addEventListener("click", () => {
        (this.rating = t + 1), this.changeActiveStars();
      });
  }
  insertDescriptionHtml(e) {
    var t,
      s = this.reviewsStarsElement.querySelector(
        ".add-review__stars-description"
      );
    !s && e
      ? ((t = this.createDescriptionRatingHtml(e)),
        this.reviewsStarsElement.insertAdjacentHTML("beforeend", t),
        (this.descriptionRatingELement = this.addReviewElement.querySelector(
          ".add-review__stars-description"
        )),
        this.descriptionRatingELement.addEventListener("mouseenter", () =>
          this.changeHoveredStars(0)
        ))
      : e
      ? (s.innerHTML = this.getDescriptionText(e))
      : this.rating
      ? (s.innerHTML = this.getDescriptionText(this.rating))
      : s && s.remove();
  }
  createDescriptionRatingHtml(e) {
    return `<div class="add-review__stars-description">
                 ${this.getDescriptionText(e)}
            </div>`;
  }
  getDescriptionText(e) {
    switch (e) {
      case 1:
        return "Ужасно";
      case 2:
        return "Плохо";
      case 3:
        return "Нормально";
      case 4:
        return "Хорошо";
      case 5:
        return "Отлично";
      default:
        return "";
    }
  }
  changeHoveredStars(s) {
    this.stars.forEach((e, t) => {
      t + 1 <= s
        ? e.classList.add("star--hovered")
        : e.classList.remove("star--hovered");
    });
  }
  changeActiveStars() {
    this.stars.forEach((e, t) => {
      t + 1 <= this.rating
        ? e.classList.add("star--active")
        : e.classList.remove("star--active");
    });
  }
  async handleSubmit(e) {
    e.preventDefault(),
      this.setDisableSubmitButton(!0),
      this.isValidData()
        ? this.reviewsApi
            .addReview(this.getDataForSubmit())
            .then((e) => {
              e && this.showSuccessBlock();
            })
            .finally(() => this.setDisableSubmitButton(!1))
        : this.setDisableSubmitButton(!1);
  }
  getDataForSubmit() {
    const s = new FormData();
    return (
      s.append("productId", this.productId),
      s.append("rating", this.rating),
      Object.keys(this.controls).forEach((e) => {
        var t = this.controls[e].getValue();
        t &&
          ("images" === e
            ? t.forEach((e) => {
                s.append("images[]", e);
              })
            : s.append(e, t));
      }),
      s
    );
  }
  isValidData() {
    return this.rating;
  }
  setDisableSubmitButton(e) {
    this.form.querySelector('button[type="submit"]').disabled = e;
  }
  showSuccessBlock() {
    this.addReviewElement.classList.add("add-review--success");
  }
}
class YandexMap {
  constructor(t, o) {
    (this.selectorIdMap = t),
      (this.points = o),
      (this.apiKey = "c38076c2-06f1-4e49-992b-4e4156255a1d"),
      (this.zoom = 16),
      this.createMapScript();
  }
  createMapScript() {
    var t = document.createElement("script");
    (t.src = `https://api-maps.yandex.ru/2.1/?apikey=${this.apiKey}&lang=ru_RU`),
      document.body.append(t),
      (t.onload = () => this.initMap());
  }
  initMap() {
    ymaps.ready(() => {
      (this.map = new ymaps.Map(this.selectorIdMap, this.createMapOptions())),
        this.map.controls.add("zoomControl", { size: "small" }),
        this.createPlacemarks(),
        this.setLocation(this.points[0]);
    });
  }
  createMapOptions() {
    return {
      center: this.getLocation(this.points[0]),
      zoom: this.zoom,
      controls: ["fullscreenControl", "geolocationControl"],
    };
  }
  createPlacemarks() {
    this.points.forEach((t) => {
      this.map?.geoObjects.add(
        new ymaps.Placemark(
          this.getLocation(t),
          { balloonContent: this.makeBalloonContent(t) },
          { iconColor: "#004989" }
        )
      );
    });
  }
  makeBalloonContent(t) {
    let o = `Адрес: <b>${t.NAME}</b><br/><br/>`;
    t = t.PROPERTIES.SCHEDULE.VALUE.TEXT;
    return t && (o += `Режим работы: <span>${t}</span>`), o;
  }
  getLocation(t) {
    return [t.PROPERTIES.LATITUDE.VALUE, t.PROPERTIES.LONGITUDE.VALUE];
  }
  setLocation(t) {
    this.map?.setCenter(this.getLocation(t), this.zoom);
  }
}
class RegisterForm {
  constructor() {
    (this.ajaxUrl = "/ajax/form/auth/registrationForm.php"),
      (this.formSelector = "#registration-form"),
      (this.form = document.querySelector(this.formSelector)),
      this.createControls(),
      this.hangEvents();
  }
  hangEvents() {
    this.form.addEventListener("submit", (e) => this.handleSubmit(e)),
      this.hangTooltipsEvents();
  }
  async handleSubmit(e) {
    if (
      (e.preventDefault(),
      this.setDisableSubmitButton(!0),
      this.clearError(),
      this.isValidData())
    )
      try {
        const t = await Request.fetch(this.ajaxUrl, this.getDataForSubmit());
        t.errors
          ? Object.keys(t.errors).forEach((e) => {
              "message" === e
                ? this.showError(t.errors[e])
                : this.inputs[e].setError(t.errors[e]);
            })
          : this.showSuccess();
      } catch (e) {
        this.showError("Ошибка запроса, попробуйте позже");
      } finally {
        this.setDisableSubmitButton(!1);
      }
    else this.setDisableSubmitButton(!1);
  }
  setDisableSubmitButton(e) {
    this.form.querySelector('button[type="submit"]').disabled = e;
  }
  showSuccess() {
    var e = document.querySelector(".wholesale__form-consent");
    this.form.insertAdjacentHTML("afterend", this.createSuccessHtml()),
      this.form.remove(),
      e.remove(),
      this.scrollToSuccessElement();
  }
  scrollToSuccessElement() {
    document
      .querySelector(".success-message")
      .scrollIntoView({ block: "center", inline: "center" });
  }
  createSuccessHtml() {
    return '<p class="success-message">Спасибо за регистрацию! Ваш аккаунт будет активирован позже</p>';
  }
  showError(e) {
    this.form.insertAdjacentHTML("afterend", this.createErrorHtml(e));
  }
  clearError() {
    var e = document.querySelector(".error-message");
    e && e.remove();
  }
  createErrorHtml(e) {
    return `<div class="error-message alert alert-danger" role="alert">${e}</div>`;
  }
  isValidData() {
    let t = !1;
    return (
      Object.keys(this.inputs).forEach((e) => {
        this.inputs[e].isValidValue() || (this.inputs[e].setError(), (t = !0));
      }),
      !t
    );
  }
  getDataForSubmit() {
    const t = {};
    return (
      Object.keys(this.inputs).forEach((e) => {
        t[e] = this.inputs[e].getValue();
      }),
      (t.promo = this.checkboxPromo.checked),
      t
    );
  }
  createControls() {
    (this.inputCompany = new Input({
      wrapperSelector: this.formSelector + " .input--company",
      required: !0,
      errorMessage: "Поле обязательно к заполнению",
    })),
      (this.inputAddress = new Input({
        wrapperSelector: this.formSelector + " .input--address",
      })),
      (this.inputMarketPlace = new Input({
        wrapperSelector: this.formSelector + " .input--marketplace",
        required: !0,
        errorMessage: "Поле обязательно к заполнению",
      })),
      (this.inputContact = new Input({
        wrapperSelector: this.formSelector + " .input--contact",
        required: !0,
        errorMessage: "Поле обязательно к заполнению",
      })),
      (this.inputPosition = new Input({
        wrapperSelector: this.formSelector + " .input--position",
        required: !0,
        errorMessage: "Поле обязательно к заполнению",
      })),
      (this.inputPhone = new Input({
        wrapperSelector: this.formSelector + " .input--phone",
        required: !0,
        validMask: /^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/,
        mask: "+7 (###) ###-##-##",
        errorMessage: "Телефон должен быть в указанном формате",
      })),
      (this.inputEmail = new Input({
        wrapperSelector: this.formSelector + " .input--email",
        required: !0,
        validMask: /^([a-z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/,
        errorMessage: "Введите email в корректном формате",
      })),
      (this.inputPassword = new Input({
        wrapperSelector: this.formSelector + " .input--password",
        required: !0,
        validMask: /.{8,}/,
        errorMessage: "Пароль должен содержать не менее 8 символов",
      })),
      (this.checkboxPromo = this.form.querySelector("#promo")),
      (this.inputs = {
        company: this.inputCompany,
        address: this.inputAddress,
        marketPlace: this.inputMarketPlace,
        contact: this.inputContact,
        position: this.inputPosition,
        phone: this.inputPhone,
        email: this.inputEmail,
        password: this.inputPassword,
      });
  }
  hangTooltipsEvents() {
    this.form.querySelectorAll(".info").forEach((e) => {
      var t = e.querySelector("span:first-child"),
        e = e.querySelector(".tooltip");
      new Tooltip(t, e);
    });
  }
}
class RatingStarsHelper {
  constructor(
    t = {
      productElement: null,
      productId: null,
      starsSelector: null,
      ratingsList: ratingsList,
    },
    s = !1
  ) {
    t.productElement
      ? ((this.productElement = t.productElement),
        (this.productId = this.productElement.dataset.id))
      : (this.productId = t.productId),
      (this.starsSelector = t.starsSelector || ".stars"),
      (this.ratingsList = t.ratingsList),
      (this.showRatingValue = s),
      (this.maxStars = 5),
      this.defineStars(),
      this.insertHtml();
  }
  defineStars() {
    var t = this.ratingsList[this.productId],
      t = ((this.rating = t ? t.RATING : 0), Math.round(this.rating));
    (this.fillStars = Math.floor(this.rating)),
      (this.halfStars = 0),
      t > this.rating && (this.halfStars = 1),
      (this.outlineStars = this.maxStars - this.fillStars - this.halfStars);
  }
  insertHtml() {
    let t;
    (t = (this.productElement || document).querySelector(this.starsSelector)) &&
      (t.classList.remove("placeholder-glow"),
      (t.innerHTML = this.createStarsHtml()));
  }
  createFillStarHtml() {
    return `<div class="star star--small">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>
            </div>`;
  }
  createHalfStarHtml() {
    return `<div class="star star--small">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                    <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
                </svg>
            </div>`;
  }
  createOutlineStarHtml() {
    return `<div class="star star--small">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                </svg>
            </div>`;
  }
  createRatingValueHtml() {
    return `<div class="stars__count">${this.rating}</div>`;
  }
  createStarsHtml() {
    let s = "";
    for (let t = 0; t < this.fillStars; t++) s += this.createFillStarHtml();
    this.halfStars && (s += this.createHalfStarHtml());
    for (let t = 0; t < this.outlineStars; t++)
      s += this.createOutlineStarHtml();
    return this.showRatingValue && (s += this.createRatingValueHtml()), s;
  }
}
class Modal {
  constructor(
    e = {
      modalOpenElementSelector: null,
      modalSelector: ".modal",
      isCreateMode: !1,
      isVideoMode: !1,
      isLarge: !1,
      title: null,
    }
  ) {
    (this.isVideoMode = e.isVideoMode),
      (this.isLarge = e.isLarge),
      (this.isCreateMode = e.isCreateMode),
      this.isCreateMode
        ? ((this.modalTitle = e.title),
          (this.modalElement = this.#createModal()))
        : (this.modalElement = document.querySelector(e.modalSelector)),
      (this.isOpen = !1),
      (this.openModalElement = document.querySelector(
        e.modalOpenElementSelector
      )),
      (this.closeModalElement =
        this.modalElement.querySelector(".modal__close")),
      (this.modalContentElement =
        this.modalElement.querySelector(".modal-content")),
      (this.modalBodyElement = this.modalElement.querySelector(".modal-body")),
      this.#hangEvents();
  }
  #hangEvents() {
    this.openModalElement &&
      this.openModalElement.addEventListener("click", () => this.open()),
      this.closeModalElement.addEventListener("click", () => this.close()),
      window.addEventListener("click", (e) => this.handleWindowClick(e));
  }
  #createModal() {
    var e = document.createElement("div");
    return (
      (e.id = this.createRandomId()),
      e.classList.add("modal"),
      this.isVideoMode && e.classList.add("modal--video-mode"),
      e.insertAdjacentHTML("afterbegin", this.#createModalHtml()),
      document.body.appendChild(e),
      e
    );
  }
  #createModalHtml() {
    return `<div class="modal-dialog${this.isLarge ? " modal-xl" : ""}">
                <div class="modal__close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-x" viewBox="0 0 16 16">
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </div>
                <div class="modal-content">
                    <div class="modal-body">
                        ${
                          this.modalTitle
                            ? `<h4 class="modal-title">${this.modalTitle}</h4>`
                            : ""
                        }
                    </div>
                </div>
            </div>`;
  }
  createRandomId() {
    let e = "";
    for (; e.length < 6; ) e += Math.random().toString(36).substring(2);
    return "modal-" + e.substring(0, 6);
  }
  open() {
    this.createOverlay(),
      this.modalElement.classList.add("show"),
      (this.isOpen = !0);
  }
  close() {
    this.removeOverlay(),
      (this.isOpen = !1),
      this.isCreateMode
        ? this.modalElement.remove()
        : this.modalElement.classList.remove("show"),
      this.onClose();
  }
  createOverlay() {
    var e = document.createElement("div");
    e.classList.add("modal-overlay"), document.body.appendChild(e);
  }
  removeOverlay() {
    var e = document.querySelector(".modal-overlay");
    e && e.remove();
  }
  handleWindowClick(e) {
    this.modalContentElement.contains(e.target) ||
      (this.openModalElement && this.openModalElement.contains(e.target)) ||
      !this.isOpen ||
      this.close();
  }
  setContent(e) {
    this.modalBodyElement.insertAdjacentHTML("beforeend", e);
  }
  onClose() {}
}
class ProductSubscribeModal extends Modal {
  constructor(t) {
    super({ isCreateMode: !0, title: "Сообщить о поступлении" }),
      (this.productId = t),
      (this.url = "/ajax/form/productSubscribeForm.php"),
      (this.modalClass = "subscribe-product-modal"),
      this.createModal(),
      this.hangEvents(),
      super.open();
  }
  createModal() {
    var t = this.createModalHtml();
    this.setContent(t), this.createControls();
  }
  hangEvents() {
    (this.modalForm = document.querySelector(`.${this.modalClass} form`)),
      this.modalForm.addEventListener("submit", (t) => this.handleSubmit(t));
  }
  async handleSubmit(t) {
    if (
      (t.preventDefault(),
      this.setDisableSubmitButton(!0),
      this.clearError(),
      this.isValidData())
    )
      try {
        const e = await Request.fetch(this.url, this.getDataForSubmit());
        e.errors
          ? Object.keys(e.errors).forEach((t) => {
              "message" === t
                ? this.showError(e.errors[t])
                : this.inputs[t].setError(e.errors[t]);
            })
          : (super.close(), new ProductSubscribeSuccessModal());
      } catch (t) {
        this.showError("Ошибка запроса, попробуйте позже");
      } finally {
        this.setDisableSubmitButton(!1);
      }
    else this.setDisableSubmitButton(!1);
  }
  setDisableSubmitButton(t) {
    this.modalForm.querySelector('button[type="submit"]').disabled = t;
  }
  showError(t) {
    this.modalForm
      .querySelector('button[type="submit"]')
      .insertAdjacentHTML("beforebegin", this.createErrorHtml(t));
  }
  clearError() {
    var t = this.modalForm.querySelector("#error-message");
    t && t.remove();
  }
  createErrorHtml(t) {
    return `<div id="error-message" class="alert alert-danger my-4" role="alert">${t}</div>`;
  }
  isValidData() {
    let e = !1;
    return (
      Object.keys(this.inputs).forEach((t) => {
        this.inputs[t].isValidValue() || (this.inputs[t].setError(), (e = !0));
      }),
      !e
    );
  }
  getDataForSubmit() {
    const e = {};
    return (
      Object.keys(this.inputs).forEach((t) => {
        e[t] = this.inputs[t].getValue();
      }),
      e
    );
  }
  createControls() {
    (this.inputName = new Input({
      wrapperSelector: `.${this.modalClass} .input--name`,
      required: !0,
      errorMessage: "Поле обязательно к заполнению",
    })),
      (this.inputEmail = new Input({
        wrapperSelector: `.${this.modalClass} .input--email`,
        required: !0,
        validMask: /^([a-z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/,
        errorMessage: "Введите email в корректном формате",
      })),
      (this.inputPhone = new Input({
        wrapperSelector: `.${this.modalClass} .input--phone`,
        validMask: /^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/,
        mask: "+7 (###) ###-##-##",
        errorMessage: "Телефон должен быть в указанном формате",
      })),
      (this.inputProductId = new Input({
        inputSelector: `.${this.modalClass} input[name="productId"]`,
      })),
      (this.inputs = {
        name: this.inputName,
        email: this.inputEmail,
        phone: this.inputPhone,
        productId: this.inputProductId,
      });
  }
  createModalHtml() {
    return `<div class="${this.modalClass}">
                <p>
                    Введите Ваши контактные данные, и мы уведомим Вас о поступлении данного
                    товара на склад.
                </p>
                <form>
                    <div class="input input--name my-4">
                        <label for="i_41" class="form-label">Имя</label>
                        <span class="input__container">
                            <input id="i_41" name="name" type="text" class="form-control"> 
                        </span>
                    </div>
                    <div class="input input--phone my-4">
                        <label for="i_42" class="form-label">Номер телефона</label>
                        <span class="input__container">
                            <input id="i_42" name="phone" type="text" placeholder="+7 (___)___-__-__" class="form-control">
                        </span>
                    </div>
                    <div class="input input--email my-4">
                        <label for="i_43" class="form-label">Email</label>
                        <span class="input__container">
                            <input id="i_43" name="email" type="text" placeholder="example@gmail.com" class="form-control">
                        </span>
                    </div>
                  
                    <input id="i_44" name="productId" value="${this.productId}" type="text" class="form-control" hidden>
            
                    <button type="submit" class="btn btn-primary w-100">Подтвердить</button>
                </form>
            </div>`;
  }
}
class ProductSubscribeSuccessModal extends Modal {
  constructor() {
    super({ isCreateMode: !0, title: "Заявка отправлена" }),
      (this.modalClass = "subscribe-product-modal"),
      this.createModal(),
      super.open();
  }
  createModal() {
    var t = this.createModalHtml();
    super.setContent(t), this.hangEvents();
  }
  hangEvents() {
    document
      .querySelector(`.${this.modalClass} button`)
      .addEventListener("click", () => super.close());
  }
  createModalHtml() {
    return `
            <div class="${this.modalClass}">
                <p>
                    Менеджер свяжется с вами в рабочее время и обсудит детали заказа.
                </p>
                <button class="btn btn-primary w-100">
                    Вернуться к покупкам
                </button>
            </div>    
        `;
  }
}
class SelectOfferModal extends Modal {
  static mode = { ADD: "ADD", DELETE: "DELETE" };
  constructor(
    t = { mode: SelectOfferModal.ADD, productId: 0, onSubmit: (t) => {} }
  ) {
    super({ isCreateMode: !0, title: "Выбрать размер" }),
      (this.selector = ".modal-trade-offers"),
      (this.mode = t.mode),
      (this.productId = t.productId),
      (this.offers = {}),
      (this.onSubmit = t.onSubmit),
      (this.basketApi = new BasketApi()),
      this.createModal();
  }
  createModal() {
    this.getData().then((t) => {
      t &&
        !Array.isArray(t) &&
        ((this.offers = t),
        this.createElements(),
        this.hangSubmitEvent(),
        super.open());
    });
  }
  createElements() {
    var t = this.mapOffersForSelect(),
      t = this.createModalHtml(t);
    this.setContent(t),
      (this.counter = new Counter({
        selectorMinusButton: this.selector + " .modal-trade-offers__minus",
        selectorPlusButton: this.selector + " .modal-trade-offers__plus",
        selectorInput: this.selector + " .modal-trade-offers__count input",
        minValue: 1,
        maxValue: this.getFirstOffer().QUANTITY,
        initialValue: 1,
      })),
      (this.select = new Select({
        selector: this.selector + " .select",
        onSelect: (t) => this.handleChangeOffer(t),
      }));
  }
  hangSubmitEvent() {
    (this.submitButton = document.querySelector(
      this.selector + " .product-card__button"
    )),
      this.submitButton.addEventListener("click", async () =>
        this.handleSubmit()
      );
  }
  async handleSubmit() {
    var t = this.select.getValue(),
      e = this.counter.getValue();
    (await this.postData(t, e)) && (super.close(), this.onSubmit(e));
  }
  postData(t, e) {
    switch (this.mode) {
      case SelectOfferModal.mode.ADD:
        return this.basketApi.addToBasket(t, e);
      case SelectOfferModal.mode.DELETE:
        return this.basketApi.deleteFromBasket(t, e);
      default:
        return this.basketApi.addToBasket(t, e);
    }
  }
  handleChangeOffer(t) {
    this.counter.setMinValue(1),
      this.counter.setMaxValue(this.offers[t].QUANTITY),
      this.counter.setValue(1);
  }
  mapOffersForSelect() {
    return Object.keys(this.offers).map((t) => ({
      id: this.offers[t].ID,
      title: this.offers[t].NAME,
    }));
  }
  getFirstOffer() {
    for (var t in this.offers) return this.offers[t];
  }
  getData() {
    switch (this.mode) {
      case SelectOfferModal.mode.ADD:
        return this.basketApi.getAvailableOffersForPurchasing(this.productId);
      case SelectOfferModal.mode.DELETE:
        return this.basketApi.getAvailableOffersForDeleting(this.productId);
      default:
        return this.basketApi.getAvailableOffersForPurchasing(this.productId);
    }
  }
  renderSelectOptions(t) {
    return t.map(
      (t) => `<div class="select__option" data-id="${t.id}" tabIndex="0">
                <span>${t.title}</span>
             </div>`
    );
  }
  createModalHtml(t) {
    return `<div class="modal-trade-offers">
                <div class="modal-trade-offers__wr">
                     <div class="select__wrapper">
                        <div class="select">
                          <button class="select__main btn">
                            <div class="select__options">
                                ${this.renderSelectOptions(t).join("")}
                            </div>
                          </button>
                        </div>
                    </div>
                    
                    <span class="input-group modal-trade-offers__count">
                        <span class="modal-trade-offers__minus">-</span>
                        <input type="number" class="form-control"/>
                        <span class="modal-trade-offers__plus">+</span>
                    </span>
    
                    <button class="btn btn-primary product-card__button col-12" >
                        ${
                          "DELETE" === this.mode
                            ? "Удалить из корзины"
                            : "В корзину"
                        }
                    </button>
                </div>
            </div>`;
  }
}
class VideoReviewModal extends Modal {
  constructor(e) {
    super({ isCreateMode: !0, isVideoMode: !0, isLarge: !0 }),
      (this.videoSrc = e),
      this.videoSrc && (this.createModal(), super.open());
  }
  createModal() {
    var e = this.createModalHtml();
    this.setContent(e);
  }
  createModalHtml() {
    return `<div class="yt-wrapper">
                <div class="yt-container">
                    <iframe src="${this.videoSrc}" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>`;
  }
}
class Counter {
  constructor(
    t = {
      selectorMinusButton: "",
      selectorPlusButton: "",
      selectorInput: "",
      minValue: minValue,
      maxValue: maxValue,
      initialValue: 0,
      blockChangeState: !1,
      disabledInput: !1,
      onChangeInput: (t, e) => {},
      onPlus: (t, e) => {},
      onMinus: (t, e) => {},
    }
  ) {
    (this.inputSelector = t.selectorInput),
      (this.minusButton = document.querySelector(t.selectorMinusButton)),
      (this.plusButton = document.querySelector(t.selectorPlusButton)),
      (this.minValue = t.minValue || 0),
      (this.maxValue = t.maxValue || 1e3),
      (this.initialValue = t.initialValue),
      (this.blockChangeState = t.blockChangeState),
      (this.disabledInput = t.disabledInput),
      (this.debounceTime = 1500),
      (this.onChangeInput = t.onChangeInput),
      (this.onPlus = t.onPlus),
      (this.onMinus = t.onMinus),
      this.hangEvents();
  }
  disableButtons() {
    (this.minusButton.style.pointerEvents = "none"),
      (this.plusButton.style.pointerEvents = "none");
  }
  activateButtons() {
    (this.minusButton.style.pointerEvents = "all"),
      (this.plusButton.style.pointerEvents = "all");
  }
  setMinValue(t) {
    this.minValue = t;
  }
  setMaxValue(t) {
    this.maxValue = t;
  }
  setValue(t) {
    t < this.minValue
      ? this.input.setValue(this.minValue)
      : t > this.maxValue
      ? this.input.setValue(this.maxValue)
      : this.input.setValue(t);
  }
  getValue() {
    return this.input.getValue();
  }
  hangEvents() {
    (this.input = new Input({
      inputSelector: this.inputSelector,
      initialValue: this.initialValue,
      disabled: this.disabledInput,
      onChange: (t) => this.handleChangeInput(t),
    })),
      this.handleDecreaseCounter(),
      this.handleIncreaseCounter();
  }
  handleChangeInput(t) {
    +t < this.minValue && this.input.setValue(this.minValue),
      +t > this.maxValue && this.input.setValue(this.maxValue),
      this.debouceTimeout && clearTimeout(this.debouceTimeout),
      this.onChangeInput &&
        (this.debouceTimeout = setTimeout(() => {
          this.onChangeInput(this.input.getValue(), this);
        }, this.debounceTime));
  }
  handleIncreaseCounter() {
    this.plusButton.addEventListener("click", () => {
      let t = this.input.getValue();
      t != this.maxValue &&
        (this.blockChangeState || (t++, this.input.setValue(t)), this.onPlus) &&
        this.onPlus(+t, this);
    });
  }
  handleDecreaseCounter() {
    this.minusButton.addEventListener("click", () => {
      let t = this.input.getValue();
      t != this.minValue &&
        (this.blockChangeState || (t--, this.input.setValue(t)),
        this.onMinus) &&
        this.onMinus(+t, this);
    });
  }
}
class Input {
  constructor(
    e = {
      wrapperSelector: "",
      inputSelector: "",
      initialValue: "",
      debounceTime: 2e3,
      withDebounce: !1,
      required: !1,
      validMask: null,
      mask: null,
      errorMessage: "Поле обязательно для заполнения",
      disabled: !1,
      onChange: (e) => {},
      onClear: () => {},
    }
  ) {
    (this.inputWrapperSelector = e.wrapperSelector),
      (this.inputWrapperElement = document.querySelector(
        this.inputWrapperSelector
      )),
      (this.inputSelector =
        e.inputSelector || this.inputWrapperSelector + " input"),
      (this.inputElement = document.querySelector(this.inputSelector)),
      (this.clearButtonElement = document.querySelector(
        this.inputSelector + " + .input__clear"
      )),
      (this.required = e.required),
      (this.errorMessage = e.errorMessage),
      (this.withDebounce = e.withDebounce),
      (this.debouceTime = e.debounceTime || 2e3),
      (this.validMask = e.validMask),
      (this.onChange = e.onChange),
      (this.onClear = e.onClear),
      this.setMask(e.mask),
      this.setRequired(),
      this.setDisabled(e.disabled),
      this.setInitialValue(e.initialValue),
      this.hangEvents();
  }
  hangEvents() {
    this.handleChange(),
      this.handleClear(),
      this.handleFocus(),
      this.handleBlur();
  }
  setMask(e) {
    e && new Inputmask(e).mask(this.inputSelector);
  }
  setRequired() {
    this.required &&
      this.inputWrapperElement &&
      this.inputWrapperElement.classList.add("input--required");
  }
  getValue() {
    return this.inputElement.value;
  }
  getDataAttribute(e) {
    return this.inputElement.dataset[e];
  }
  setDisabled(e) {
    this.inputElement.disabled = e;
  }
  setInitialValue(e) {
    e && this.setValue(e);
  }
  setValue(e) {
    this.inputElement.value = e;
  }
  clear() {
    this.clearButtonElement && this.clearButtonElement.classList.remove("show"),
      (this.inputElement.value = ""),
      this.onClear && this.onClear();
  }
  handleChange() {
    this.inputElement.addEventListener("input", () => {
      if (
        (this.toggleClearButton(),
        this.debouceTimeout && clearTimeout(this.debouceTimeout),
        this.onChange)
      ) {
        const e = this.getValue();
        this.withDebounce
          ? (this.debouceTimeout = setTimeout(() => {
              this.onChange(e, this);
            }, this.debouceTime))
          : this.onChange(e);
      }
    });
  }
  handleFocus() {
    this.inputElement.addEventListener("focus", () => {
      this.clearError();
    });
  }
  handleBlur() {
    this.inputElement.addEventListener("blur", () => {
      this.isValidValue() || this.setError();
    });
  }
  handleClear() {
    this.clearButtonElement &&
      this.clearButtonElement.addEventListener("click", () => this.clear());
  }
  setError(e) {
    var t;
    this.inputWrapperElement &&
      this.inputWrapperElement.classList.add("is-invalid"),
      this.inputElement.classList.add("is-invalid"),
      document.querySelector(
        this.inputWrapperSelector + " .invalid-feedback"
      ) ||
        ((t = document.createElement("div")).classList.add("invalid-feedback"),
        (t.textContent = e || this.errorMessage),
        this.inputElement.insertAdjacentElement("afterend", t));
  }
  clearError() {
    this.inputElement.classList.remove("is-invalid"),
      this.inputWrapperElement &&
        this.inputWrapperElement.classList.remove("is-invalid");
    var e = document.querySelector(
      this.inputWrapperSelector + " .invalid-feedback"
    );
    e && e.remove();
  }
  isValidValue() {
    var e = this.getValue();
    return !(
      (this.required && !e) ||
      (e && this.validMask && !this.validMask.test(e))
    );
  }
  toggleClearButton() {
    this.clearButtonElement &&
      (this.getValue()
        ? this.clearButtonElement.classList.add("show")
        : this.clearButtonElement.classList.remove("show"));
  }
}
class InputFile {
  constructor(
    e = {
      wrapperSelector: ".input-file",
      maxSize: 5242880,
      maxFiles: 1,
      showAddedFiles: !0,
    }
  ) {
    (this.wrapperSelector = e.wrapperSelector),
      (this.wrapper = document.querySelector(this.wrapperSelector)),
      (this.inputFile = this.wrapper.querySelector('input[type="file"]')),
      (this.description = this.wrapper.querySelector(
        ".input-file__description"
      )),
      (this.maxSize = e.maxSize),
      (this.maxFiles = e.maxFiles),
      (this.showAddedFiles = e.showAddedFiles),
      (this.files = []),
      this.hangEvents();
  }
  getValue() {
    return this.files;
  }
  getDataAttribute(e) {
    return this.inputFile.dataset[e];
  }
  hangEvents() {
    this.handleLoadFile();
  }
  handleLoadFile() {
    this.inputFile.addEventListener("change", (e) => {
      e = [...e.target.files];
      (this.inputFile.value = null),
        Array.from(e).forEach((e) => {
          e.size > this.maxSize ||
            (this.checkMaxCountFiles() && this.files.push(e));
        }),
        this.updateFileList();
    });
  }
  updateFileList() {
    if (this.showAddedFiles) {
      let e = this.wrapper.querySelector(".input-file__files");
      e ||
        (this.wrapper.insertAdjacentHTML(
          "beforeend",
          this.createFileListHtml()
        ),
        (e = this.wrapper.querySelector(".input-file__files"))),
        (e.innerHTML = this.files
          .map((e, i) => this.createAddedFileHtml(e.name, i))
          .join("")),
        this.changeDescriptionStyle(),
        this.hangDeleteFilesEvent();
    }
  }
  hangDeleteFilesEvent() {
    this.wrapper.querySelectorAll(".input-file__file").forEach((e) => {
      const i = e.querySelector(".input-file__file-remove");
      i.addEventListener("click", () => {
        const t = i.dataset.id;
        (this.files = this.files.filter((e, i) => i != t)),
          this.updateFileList();
      });
    });
  }
  createFileListHtml() {
    return `<div class="input-file__files--list">
                <p class="input-file__added-files">Добавленные файлы:</p>
                <div class="input-file__files"></div>
            </div>`;
  }
  createAddedFileHtml(e, i) {
    return `<div class="input-file__file">
                ${e}
                <svg class="input-file__file-remove bi bi-x" data-id="${i}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </div>`;
  }
  checkMaxCountFiles() {
    return this.files.length < this.maxFiles;
  }
  changeDescriptionStyle() {
    this.files.length === this.maxFiles
      ? (this.wrapper.classList.add("input-file--max-count-reached"),
        (this.description.innerHTML =
          "Достигнуто максимальное колличество файлов"))
      : (this.wrapper.classList.remove("input-file--max-count-reached"),
        (this.description.innerHTML = `Прикрепить файл (не более ${
          this.maxSize / 1048576
        }MB)`));
  }
}
class Select {
  constructor(t = { selector: ".select", element: null, onSelect: (t) => {} }) {
    t.element
      ? (this.select = t.element)
      : (this.select = document.querySelector(t.selector)),
      (this.selectButton = this.select.querySelector(".select__main")),
      (this.options = this.select.querySelectorAll(".select__option")),
      (this.placeholder = this.select.dataset.placeholder),
      (this.initialValueId = this.select.dataset.initialId),
      (this.isOpen = !1),
      (this.value = {}),
      (this.onSelect = t.onSelect),
      this.setInitialValue(),
      this.hangEvents();
  }
  hangEvents() {
    this.selectButton.addEventListener("click", () => this.open()),
      this.options.forEach((e) => {
        e.addEventListener("click", (t) => {
          t.stopPropagation(), this.selectOption(e);
        });
      }),
      window.addEventListener("click", (t) => this.handleWindowClick(t));
  }
  handleWindowClick(t) {
    !this.select.contains(t.target) && this.isOpen && this.close();
  }
  resetValue() {
    this.placeholder
      ? (this.setValueTextInHtml(this.placeholder), (this.value = {}))
      : this.setValue(this.initialValueId);
  }
  setInitialValue() {
    var t, e;
    0 !== this.options.length &&
      (this.initialValueId
        ? this.options.forEach((t) => {
            var e = t.dataset.id;
            e === this.initialValueId &&
              ((t = t.querySelector("span").textContent.trim()),
              this.setValue(e, t));
          })
        : this.placeholder
        ? this.setValueTextInHtml(this.placeholder)
        : this.initialValueId ||
          ((t = this.options[0].dataset.id),
          (e = this.options[0].querySelector("span").textContent.trim()),
          this.setValue(t, e),
          (this.initialValueId = this.value.id)));
  }
  getValue() {
    return this.value.id;
  }
  setValue(t, e = null) {
    let s = e;
    s ||
      ((e = this.select.querySelector(`.select__option[data-id="${t}"]`)),
      (s = e.textContent.trim())),
      (this.value = { id: t, title: s }),
      this.setValueTextInHtml(this.value.title);
  }
  setValueTextInHtml(t) {
    this.selectButton.childNodes[0].nodeValue = t;
  }
  selectOption(t) {
    var e = t.dataset.id;
    e != this.value.id &&
      ((t = t.querySelector("span").textContent.trim()),
      this.setValue(e, t),
      this.onSelect) &&
      this.onSelect(e),
      this.close();
  }
  open() {
    (this.isOpen = !0), this.select.classList.add("select--expanded");
  }
  close() {
    (this.isOpen = !1), this.select.classList.remove("select--expanded");
  }
}
class Tooltip {
  constructor(t, e) {
    (this.wrapper = t),
      (this.tooltip = e),
      this.createTooltip(),
      this.hangEvents();
  }
  createTooltip() {
    this.popper = Popper.createPopper(this.wrapper, this.tooltip, {
      placement: "right",
      modifiers: [{ name: "offset", options: { offset: [0, 8] } }],
    });
  }
  hangEvents() {
    this.wrapper.addEventListener("mouseenter", () => {
      this.tooltip.setAttribute("data-show", ""), this.popper.update();
    }),
      this.wrapper.addEventListener("mouseleave", () => {
        this.tooltip.removeAttribute("data-show");
      });
  }
}
function getPluralString(e, a) {
  let t = e % 100,
    c = (19 < t && (t %= 10), e + " ");
  switch (t) {
    case 1:
      c += a[0];
      break;
    case 2:
    case 3:
    case 4:
      c += a[1];
      break;
    default:
      c += a[2];
  }
  return c;
}
class ProductCardBasket {
  constructor(t = { productElement: productElement, basketList: basketList }) {
    (this.productElement = t.productElement),
      (this.productId = this.productElement.dataset.id),
      (this.basketList = t.basketList),
      (this.productAvailable = this.productElement.dataset.available),
      (this.productQuantity = this.productElement.dataset.productQuantity),
      (this.offersQuantity = this.productElement.dataset.offersQuantity),
      (this.basketApi = new BasketApi()),
      this.hangEvents();
  }
  hangEvents() {
    var t;
    this.removePlaceholder(),
      this.productAvailable
        ? (t = this.basketList[this.productId])
          ? this.createCounter(t.QUANTITY)
          : this.createAddToBasketButton()
        : this.createNewArrivalsButton();
  }
  removePlaceholder() {
    var t = this.productElement.querySelector(".product-card__add");
    t.classList.remove("placeholder-glow"),
      t.querySelector(".placeholder").remove();
  }
  hangNewArrivalsButtonEvents() {
    var t = this.productElement.querySelector(".product-card__availability");
    t &&
      t.addEventListener("click", (t) => {
        t.stopPropagation(), new ProductSubscribeModal(this.productId);
      });
  }
  hangAddToBasketButtonEvents() {
    const t = this.productElement.querySelector(".product-card__add-basket");
    t &&
      t.addEventListener("click", () => {
        0 < this.offersQuantity
          ? this.handleAddFirstOfferToBasket()
          : this.handleAddFirstProductToBasket(t);
      });
  }
  hangCounterEvents() {
    this.productElement.querySelector(".product__add-count") &&
      (0 < this.offersQuantity
        ? this.createCounterInstanceForOffers()
        : this.createCounterInstanceForProducts());
  }
  createCounterInstanceForProducts() {
    var t = `.product-card[data-id="${this.productId}"]`;
    new Counter({
      selectorMinusButton: t + " .product__add-minus",
      selectorPlusButton: t + " .product__add-plus",
      selectorInput: t + " .product__add-count input",
      maxValue: this.productQuantity,
      blockChangeState: !0,
      onPlus: (t, e) => {
        this.handleAddProductToBasket(e);
      },
      onMinus: (t, e) => {
        this.handleDeleteProductFromBasket(e);
      },
      onChangeInput: (t, e) => {
        this.handleSetQuantityForProduct(t, e);
      },
    });
  }
  createCounterInstanceForOffers() {
    var t = `.product-card[data-id="${this.productId}"]`;
    new Counter({
      selectorMinusButton: t + " .product__add-minus",
      selectorPlusButton: t + " .product__add-plus",
      selectorInput: t + " .product__add-count input",
      blockChangeState: !0,
      disabledInput: !0,
      onPlus: (t, e) => {
        this.handleAddOfferToBasket(e);
      },
      onMinus: (t, e) => {
        this.handleDeleteOfferFromBasket(e);
      },
    });
  }
  handleAddFirstOfferToBasket() {
    new SelectOfferModal({
      mode: SelectOfferModal.mode.ADD,
      productId: this.productId,
      onSubmit: (t) => {
        this.createCounter(t);
      },
    });
  }
  handleAddFirstProductToBasket(e) {
    (e.style.pointerEvents = "none"),
      this.basketApi
        .addToBasket(this.productId)
        .then((t) => {
          t
            ? (this.createCounter(),
              (this.productElement.dataset.productBasket = 1))
            : (e.style.pointerEvents = "all");
        })
        .catch(() => (e.style.pointerEvents = "all"));
  }
  handleAddProductToBasket(e) {
    this.productQuantity != e.getValue() &&
      (e.disableButtons(),
      this.basketApi
        .addToBasket(this.productId)
        .then((t) => {
          t
            ? ((t = +e.getValue() + 1),
              e.setValue(t),
              (this.productElement.dataset.productBasket = t))
            : e.activateButtons();
        })
        .finally(() => e.activateButtons()));
  }
  handleDeleteProductFromBasket(e) {
    e.disableButtons(),
      this.basketApi
        .deleteFromBasket(this.productId)
        .then((t) => {
          t
            ? 0 == (t = e.getValue() - 1)
              ? this.createAddToBasketButton()
              : (e.setValue(t),
                e.activateButtons(),
                (this.productElement.dataset.productBasket = t))
            : e.activateButtons();
        })
        .catch(() => e.activateButtons());
  }
  handleSetQuantityForProduct(t, e) {
    e.disableButtons();
    const a = this.productElement.dataset.productBasket;
    this.basketApi
      .setProductQuantityToBasket(this.productId, t)
      .then((t) => {
        0 === t ? this.createAddToBasketButton() : e.setValue(t),
          (this.productElement.dataset.productBasket = t);
      })
      .catch(() => e.setValue(a))
      .finally(() => e.activateButtons());
  }
  handleAddOfferToBasket(a) {
    this.offersQuantity != a.getValue() &&
      new SelectOfferModal({
        mode: SelectOfferModal.mode.ADD,
        productId: this.productId,
        onSubmit: (t) => {
          var e = a.getValue();
          a.setValue(+e + +t);
        },
      });
  }
  handleDeleteOfferFromBasket(a) {
    new SelectOfferModal({
      mode: SelectOfferModal.mode.DELETE,
      productId: this.productId,
      onSubmit: (t) => {
        var e = a.getValue();
        +e == +t ? this.createAddToBasketButton() : a.setValue(e - t);
      },
    });
  }
  createAddToBasketButton() {
    (this.productElement.querySelector(".product-card__add").innerHTML =
      this.getAddToBasketButtonHtml()),
      this.hangAddToBasketButtonEvents();
  }
  createCounter(t = 1) {
    (this.productElement.querySelector(".product-card__add").innerHTML =
      this.createCounterHtml(t)),
      this.hangCounterEvents();
  }
  createNewArrivalsButton() {
    (this.productElement.querySelector(".product-card__add").innerHTML =
      this.createNewArrivalsButtonHtml()),
      this.hangNewArrivalsButtonEvents();
  }
  getAddToBasketButtonHtml() {
    return `<button onclick="ym(30377432,'reachGoal','product-card__add-basket')" class="btn btn-primary product-card__button product-card__add-basket">
                 В корзину
             </button>`;
  }
  createCounterHtml(t = 1) {
    return `<span class="input-group product__add-count">
                <span class="btn btn-primary product__add-minus">-</span>
                <input type="number" class="form-control" value="${t}" />
                <span class="btn btn-primary product__add-plus">+</span>
             </span>`;
  }
  createNewArrivalsButtonHtml() {
    return `<button class="btn btn-outline-primary product-card__availability">
                Cообщить о поступлении
            </button>`;
  }
}
class ProductCardCompare {
  constructor(
    e = { productElement: productElement, compareList: compareList },
    t = { onDelete: onDelete }
  ) {
    (this.productElement = e.productElement),
      (this.productId = this.productElement.dataset.id),
      (this.compareList = e.compareList),
      (this.onDelete = t.onDelete),
      (this.compareApi = new CompareApi()),
      this.hangEvents(),
      this.defineCompare();
  }
  defineCompare() {
    this.removePlaceholder(),
      this.compareList[this.productId]
        ? this.changeStyles(!0)
        : this.changeStyles(!1);
  }
  hangEvents() {
    (this.productId = this.productElement.dataset.id),
      (this.compareIconDefault = this.productElement.querySelector(
        ".product-card__compare--default"
      )),
      (this.compareIconActive = this.productElement.querySelector(
        ".product-card__compare--active"
      )),
      null !=
        this.productElement.querySelector(".product-card__remove-compare") &&
        this.productElement
          .querySelector(".product-card__remove-compare")
          .addEventListener("click", async () => this.deleteCompare()),
      this.compareIconDefault.addEventListener("click", async () =>
        this.addCompare()
      ),
      this.compareIconActive.addEventListener("click", async () =>
        this.deleteCompare()
      );
  }
  async addCompare() {
    (await this.compareApi.addToCompare(this.productId)) &&
      this.changeStyles(!0);
  }
  async deleteCompare() {
    (await this.compareApi.deleteFromCompare(this.productId)) &&
      (this.onDelete ? this.onDelete(this.productId) : this.changeStyles(!1));
  }
  changeStyles(e = !0) {
    e
      ? ((this.compareIconDefault.style.display = "none"),
        (this.compareIconActive.style.display = "inline"))
      : ((this.compareIconActive.style.display = "none"),
        (this.compareIconDefault.style.display = "inline"));
  }
  removePlaceholder() {
    this.productElement.querySelector(".placeholder--compare").remove();
  }
}
class ProductCardFavorites {
  constructor(
    t = { productElement: productElement, favoritesList: favoritesList },
    e = { onDelete: onDelete }
  ) {
    (this.productElement = t.productElement),
      (this.productId = this.productElement.dataset.id),
      (this.favoritesList = t.favoritesList),
      (this.onDelete = e.onDelete),
      (this.favoritesApi = new FavoritesApi()),
      this.hangEvents(),
      this.defineFavorites();
  }
  defineFavorites() {
    this.removePlaceholder(),
      this.favoritesList[this.productId]
        ? this.changeStyles(!0)
        : this.changeStyles(!1);
  }
  hangEvents() {
    (this.productId = this.productElement.dataset.id),
      (this.favoritesIconDefault = this.productElement.querySelector(
        ".product-card__fav--default"
      )),
      (this.favoritesIconActive = this.productElement.querySelector(
        ".product-card__fav--active"
      )),
      this.favoritesIconDefault.addEventListener("click", async () =>
        this.addFavorites()
      ),
      this.favoritesIconActive.addEventListener("click", async () =>
        this.deleteFavorites()
      );
  }
  async addFavorites() {
    (await this.favoritesApi.addToFavorites(this.productId)) &&
      this.changeStyles(!0);
  }
  async deleteFavorites() {
    (await this.favoritesApi.deleteFromFavorites(this.productId)) &&
      (this.onDelete ? this.onDelete(this.productId) : this.changeStyles(!1));
  }
  changeStyles(t = !0) {
    t
      ? ((this.favoritesIconDefault.style.display = "none"),
        (this.favoritesIconActive.style.display = "inline"))
      : ((this.favoritesIconActive.style.display = "none"),
        (this.favoritesIconDefault.style.display = "inline"));
  }
  removePlaceholder() {
    this.productElement.querySelector(".placeholder--fav").remove();
  }
}
class ProductCards {
  constructor(t, e = { onDeleteFavorites: null, onDeleteCompare: null }) {
    (this.productElements = document.querySelectorAll(".product-card")),
      (this.onDeleteFavorites = e.onDeleteFavorites),
      (this.onDeleteCompare = e.onDeleteCompare),
      (this.productsData = t),
      this.hangEvents();
  }
  hangEvents() {
    this.productElements.forEach((t) => {
      new ProductCardFavorites(
        { productElement: t, favoritesList: this.productsData.FAVORITES },
        { onDelete: this.onDeleteFavorites }
      ),
        new ProductCardCompare(
          { productElement: t, compareList: this.productsData.COMPARE },
          { onDelete: this.onDeleteCompare }
        ),
        new ProductCardBasket({
          productElement: t,
          basketList: this.productsData.BASKET,
        }),
        new RatingStarsHelper({
          productElement: t,
          ratingsList: this.productsData.RATINGS,
        }),
        t.querySelectorAll(".product-card__tags .info").forEach((t) => {
          var e = t.querySelector("span:first-child"),
            t = t.querySelector(".tooltip");
          new Tooltip(e, t);
        });
    });
  }
}
class DescriptionBlock {
  constructor() {
    (this.descriptionWrapper = document.querySelector(
      ".product-description__wrapper"
    )),
      (this.descriptionTextBlock = this.descriptionWrapper.querySelector(
        ".product-description"
      )),
      (this.descriptionMore = this.descriptionWrapper.querySelector(
        ".product-description__more"
      )),
      (this.descriptionMoreButton = this.descriptionMore.querySelector("a")),
      this.calculateHeightDescriptionBlock(),
      this.makeDescriptionBlock();
  }
  makeDescriptionBlock() {
    let t = !1;
    this.descriptionMoreButton.addEventListener("click", () => {
      t
        ? (this.descriptionWrapper.classList.remove(
            "product-description__wrapper--show-more"
          ),
          (t = !1),
          (this.descriptionMoreButton.textContent = "Еще..."))
        : (this.descriptionWrapper.classList.add(
            "product-description__wrapper--show-more"
          ),
          (t = !0),
          (this.descriptionMoreButton.textContent = "Свернуть"));
    });
  }
  calculateHeightDescriptionBlock() {
    this.calculateTimeout && clearTimeout(this.calculateTimeout),
      (this.calculateTimeout = setTimeout(() => {
        var t = this.descriptionWrapper.getBoundingClientRect().height;
        let e = this.descriptionTextBlock.getBoundingClientRect().height;
        this.descriptionWrapper.querySelectorAll("table").forEach((t) => {
          e += t.getBoundingClientRect().height;
        }),
          e > t && (this.descriptionMore.style.display = "flex");
      }, 500));
  }
}
class PhotosSlider {
  constructor() {
    (this.photosSliderSelector = ".photos-slider .swiper-container"),
      (this.selectedPhoto = document.querySelector(
        ".product-photos__selected-photo"
      )),
      (this.photosSliderElements = document.querySelectorAll(
        ".photos-slider__item"
      )),
      (this.imageElementSrc = null),
      this.makeSlider(),
      null == document.querySelector("[data-hide]") &&
        (this.hangSelectedPhotoEvent(), this.hangPhotosInSlider());
  }
  makeSlider() {
    var e = {
        default: { slidesPerView: 1, spaceBetween: 10 },
        [BaseSlider.breakpointTablet]: { slidesPerView: 5, spaceBetween: 20 },
        [BaseSlider.breakpointMobile]: { slidesPerView: 5 },
      },
      e = new BaseSlider(this.photosSliderSelector, e);
    (this.photosSlider = e.makeSlider()),
      (this.photosSliderCurrentSlide = 0),
      this.photosSlider.slides[0].classList.add("photos-slider__item--active"),
      this.hangPhotosSliderEvents();
  }
  hangPhotosInSlider() {
    this.photosSliderElements.forEach((e) => {
      e.addEventListener("click", () => {
        this.selectedPhoto.setAttribute(
          "data-modal-index",
          e.dataset.modalIndex
        );
      });
    });
  }
  hangSelectedPhotoEvent() {
    this.selectedPhoto.addEventListener("click", (e) => {
      e = e.target.dataset.modalIndex;
      document
        .querySelector(`.photos-slider__item[data-modal-index="${e}"]`)
        .click();
    });
  }
  hangPhotosSliderEvents() {
    document
      .querySelector(".photos-slider__next-button")
      .addEventListener("click", () => {
        this.photosSliderCurrentSlide === this.photosSlider.slides.length - 1
          ? (this.photosSliderCurrentSlide = 0)
          : (this.photosSliderCurrentSlide += 1),
          this.photosSlider.slideTo(this.photosSliderCurrentSlide),
          this.selectedPhoto.setAttribute(
            "data-modal-index",
            this.photosSliderCurrentSlide
          ),
          this.handleChangeSlide();
      }),
      this.photosSlider.slides.forEach((e, t) => {
        e.addEventListener("click", () => {
          this.photosSlider.slideTo(t),
            (this.photosSliderCurrentSlide = t),
            this.handleChangeSlide();
        });
      });
  }
  handleChangeSlide() {
    this.photosSlider.slides.forEach((e, t) => {
      this.photosSliderCurrentSlide === t
        ? ((t = e.style.backgroundImage),
          (this.selectedPhoto.style.backgroundImage = t),
          (this.imageElementSrc = t.replace(/(url\(")|("\))/g, "")),
          e.classList.add("photos-slider__item--active"))
        : e.classList.remove("photos-slider__item--active");
    });
  }
}
class AvailableBlock {
  constructor(e, t = 0) {
    (this.btnsOpenAvailableWindow = document.querySelectorAll(
      "a[data-available-index]"
    )),
      (this.productElement = document.querySelector(
        ".available-product-window"
      )),
      (this.productsData = e),
      this.initModal(),
      this.hangEvents();
  }
  hangEvents() {
    var e = this.productElement;
    new RatingStarsHelper({
      productElement: e,
      ratingsList: this.productsData.RATINGS,
    });
  }
  initModal() {
    0 != this.btnsOpenAvailableWindow.length &&
      this.btnsOpenAvailableWindow.forEach((e) => {
        e.addEventListener("click", (e) => {
          e.preventDefault();
        }),
          new Modal({
            modalOpenElementSelector:
              ".available-window-open-" +
              e.getAttribute("data-available-index"),
            modalSelector: "#available-window",
          });
      });
  }
}
class ProductBasket {
  constructor(t) {
    (this.productElement = document.querySelector(".product")),
      (this.productAddElement =
        this.productElement.querySelector(".product__add")),
      (this.productId = this.productElement.dataset.id),
      (this.basketList = t),
      (this.productAvailable = this.productElement.dataset.available),
      (this.productQuantity = this.productElement.dataset.productQuantity),
      (this.offers = {}),
      (this.basketApi = new BasketApi()),
      this.fillOffersData(),
      this.hangEvents();
  }
  hangEvents() {
    var t;
    this.removePlaceholders(),
      this.productAvailable
        ? Object.keys(this.offers).length
          ? this.hangSelectOfferEvent()
          : (t = this.basketList[this.productId])
          ? this.createCounter(this.productId, this.productQuantity, t.QUANTITY)
          : this.createAddToBasketButton()
        : this.createNewArrivalsButton();
  }
  fillOffersData() {
    this.productElement
      .querySelectorAll(".product__trade-offers .select__option")
      .forEach((t) => {
        var e = t.dataset.id,
          s = this.basketList[e];
        this.offers[e] = {
          quantity: +t.dataset.quantity,
          basket: s ? +s.QUANTITY : 0,
        };
      });
  }
  removePlaceholders() {
    var t = this.productElement.querySelector(".product__add"),
      e = t.querySelector(".placeholder"),
      t =
        (t.classList.remove("placeholder-glow"),
        e && e.remove(),
        this.productElement.querySelector(".product__trade-offers"));
    t &&
      (t.classList.remove("placeholder-glow"),
      (e = t.querySelector(".select")),
      (t = t.querySelector(".placeholder")),
      (e.style.display = "inline-block"),
      t.remove());
  }
  hangSubscribeToProductEvent() {
    (this.subscribeButton =
      this.productElement.querySelector(".product-subscribe")),
      this.subscribeButton &&
        this.subscribeButton.addEventListener("click", (t) => {
          t.stopPropagation(), new ProductSubscribeModal(this.productId);
        });
  }
  hangAddToBasketButtonEvents(t = this.productId, e = this.productQuantity) {
    (this.addToBasketButton =
      this.productElement.querySelector(".product-basket")),
      this.addToBasketButton &&
        this.addToBasketButton.addEventListener("click", () => {
          this.handleAddFirstProductToBasket(t, e);
        });
  }
  handleAddFirstProductToBasket(e, s) {
    (this.addToBasketButton.style.pointerEvents = "none"),
      this.basketApi
        .addToBasket(e)
        .then((t) => {
          t
            ? (e == this.productId
                ? (this.productBasket = 1)
                : (this.offers[e].basket = 1),
              this.createCounter(e, s))
            : (this.addToBasketButton.style.pointerEvents = "all");
        })
        .catch(() => (this.addToBasketButton.style.pointerEvents = "all"));
  }
  hangSelectOfferEvent() {
    new Select({
      selector: ".product__trade-offers .select",
      onSelect: (t) => this.handleChangeOffer(t),
    });
  }
  handleChangeOffer(t) {
    var { quantity: e, basket: s } = this.offers[t];
    s
      ? (this.removeCounter(), this.createCounter(t, e, s))
      : (this.removeAddToBasketButton(), this.createAddToBasketButton(t, e));
  }
  createNewArrivalsButton() {
    this.productAddElement.insertAdjacentHTML(
      "afterbegin",
      this.createNewArrivalsButtonHtml()
    ),
      this.hangSubscribeToProductEvent();
  }
  createAddToBasketButton(t = this.productId, e = this.productQuantity) {
    this.removeCounter(),
      this.productAddElement.insertAdjacentHTML(
        "afterbegin",
        this.createAddToBasketButtonHtml()
      ),
      this.hangAddToBasketButtonEvents(t, e);
  }
  createCounter(t, e, s = 1) {
    this.removeAddToBasketButton(),
      this.productAddElement.insertAdjacentHTML(
        "afterbegin",
        this.createCounterHtml(s)
      ),
      this.hangCounterEvents(t, e, s);
  }
  hangCounterEvents(
    t = this.productId,
    e = this.productQuantity,
    s = this.productBasket
  ) {
    (this.productCounter = this.productElement.querySelector(".product-count")),
      this.productCounter && this.createCounterInstance(t, e, s);
  }
  createCounterInstance(s, t, o) {
    this.counter = new Counter({
      selectorMinusButton: ".product-count__add-minus",
      selectorPlusButton: ".product-count__add-plus",
      selectorInput: ".product-count input",
      maxValue: t,
      blockChangeState: !0,
      onPlus: (t, e) => {
        this.handleSetQuantityForProduct({
          id: s,
          quantity: o,
          value: t + 1,
          counterInstance: e,
        });
      },
      onMinus: (t, e) => {
        this.handleSetQuantityForProduct({
          id: s,
          quantity: o,
          value: t - 1,
          counterInstance: e,
        });
      },
      onChangeInput: (t, e) => {
        this.handleSetQuantityForProduct({
          id: s,
          quantity: o,
          value: t,
          counterInstance: e,
        });
      },
    });
  }
  handleSetQuantityForProduct({
    id: e,
    quantity: s,
    value: t,
    counterInstance: o,
  }) {
    o.disableButtons(),
      this.basketApi
        .setProductQuantityToBasket(e, t)
        .then((t) => {
          0 === t ? this.createAddToBasketButton(e, s) : o.setValue(t),
            e == this.productId
              ? (this.productBasket = t)
              : (this.offers[e].basket = t);
        })
        .catch(() => o.setValue(s))
        .finally(() => o.activateButtons());
  }
  removeAddToBasketButton() {
    this.addToBasketButton && this.addToBasketButton.remove();
  }
  removeCounter() {
    this.productCounter && this.productCounter.remove();
  }
  createAddToBasketButtonHtml() {
    return `<button onclick="ym(30377432,'reachGoal','product-card__add-basket')" class="product-basket btn btn-primary px-5 product-card__add-basket">
                В корзину
            </button>`;
  }
  createCounterHtml(t = 1) {
    return `<div class="product-count">
                <span class="product-count__add-minus">-</span>
                <span class="product-count__add-plus">+</span>
                <input type="number" value="${t}" class="form-control" />
            </div>`;
  }
  createNewArrivalsButtonHtml() {
    return `<button class="product-subscribe btn btn-primary px-3">
                  Cообщить о поступлении
             </button>`;
  }
}
class ProductCompare {
  constructor(e) {
    (this.productElement = document.querySelector(".product")),
      (this.productId = this.productElement.dataset.id),
      (this.compareList = e),
      (this.compareApi = new CompareApi()),
      (this.compareButton =
        this.productElement.querySelector(".product-compare")),
      (this.compareAvailableWindow = document.querySelector(
        ".available-window__wrapper"
      )),
      (this.compareAvailableActions = this.compareAvailableWindow.querySelector(
        ".product-card__image-actions"
      )),
      (this.compareAvailableCompareBtn =
        this.compareAvailableActions.querySelectorAll(
          ".product-card__compare"
        )),
      (this.compareAvailableCompareDefault =
        this.compareAvailableActions.querySelector(
          ".product-card__compare--default"
        )),
      (this.compareAvailableCompareActive =
        this.compareAvailableActions.querySelector(
          ".product-card__compare--active"
        )),
      this.hangEvents(),
      this.defineCompare();
  }
  defineCompare() {
    this.removePlaceholder(),
      (this.inCompare = this.compareList[this.productId]),
      this.inCompare ? this.changeStyles(!0) : this.changeStyles(!1);
  }
  hangEvents() {
    (this.compareIconDefault = this.compareButton.querySelector(
      ".product-compare__default"
    )),
      (this.compareIconActive = this.compareButton.querySelector(
        ".product-compare__active"
      )),
      this.compareButton.addEventListener("click", async () =>
        this.changeCompare()
      ),
      this.compareAvailableCompareBtn.forEach((e) => {
        e.addEventListener("click", async () => this.changeCompare());
      });
  }
  async changeCompare() {
    (this.compareButton.style.pointerEvents = "none"),
      this.inCompare || this.compareButton.classList.contains("in-compare")
        ? await this.deleteCompare()
        : await this.addCompare(),
      (this.compareButton.style.pointerEvents = "all");
  }
  async addCompare() {
    (await this.compareApi.addToCompare(this.productId)) &&
      (this.changeStyles(!0), (this.inCompare = !0));
  }
  async deleteCompare() {
    (await this.compareApi.deleteFromCompare(this.productId)) &&
      (this.changeStyles(!1), (this.inCompare = !1));
  }
  changeStyles(e = !0) {
    e
      ? (this.compareButton.classList.add(
          "text-secondary",
          "border-secondary",
          "in-compare"
        ),
        (this.compareIconDefault.style.display = "none"),
        (this.compareIconActive.style.display = "inline"),
        null != this.compareAvailableWindow &&
          ((this.compareAvailableCompareDefault.style.display = "none"),
          (this.compareAvailableCompareActive.style.display = "inline")))
      : (this.compareButton.classList.remove(
          "text-secondary",
          "border-secondary",
          "in-compare"
        ),
        (this.compareIconActive.style.display = "none"),
        (this.compareIconDefault.style.display = "inline"),
        null != this.compareAvailableWindow &&
          ((this.compareAvailableCompareDefault.style.display = "inline"),
          (this.compareAvailableCompareActive.style.display = "none")));
  }
  removePlaceholder() {
    this.compareButton.querySelector(".placeholder").remove(),
      (this.compareButton.querySelector(
        ".product-compare__wrapper"
      ).style.visibility = "visible");
  }
}
class ProductFavorites {
  constructor(t) {
    (this.productElement = document.querySelector(".product")),
      (this.productId = this.productElement.dataset.id),
      (this.favoritesList = t),
      (this.favoritesApi = new FavoritesApi()),
      (this.favoritesButton =
        this.productElement.querySelector(".product-fav")),
      (this.favoritesText =
        this.favoritesButton.querySelector(".product-fav__text")),
      (this.favoritesAvailableWindow = document.querySelector(
        ".available-window__wrapper"
      )),
      (this.favoritesAvailableActions =
        this.favoritesAvailableWindow.querySelector(
          ".product-card__image-actions"
        )),
      (this.favoritesAvailableFavoriteButton =
        this.favoritesAvailableWindow.querySelectorAll(".product-card__fav")),
      (this.favoritesAvailableFavoriteDefault =
        this.favoritesAvailableActions.querySelector(
          ".product-card__fav--default"
        )),
      (this.favoritesAvailableFavoriteActive =
        this.favoritesAvailableActions.querySelector(
          ".product-card__fav--active"
        )),
      this.hangEvents(),
      this.defineFavorites();
  }
  defineFavorites() {
    this.removePlaceholder(),
      (this.inFavorites = this.favoritesList[this.productId]),
      this.inFavorites ? this.changeStyles(!0) : this.changeStyles(!1);
  }
  hangEvents() {
    (this.favoritesIconDefault = this.favoritesButton.querySelector(
      ".product-fav__default"
    )),
      (this.favoritesIconActive = this.favoritesButton.querySelector(
        ".product-fav__active"
      )),
      this.favoritesButton.addEventListener("click", async () =>
        this.changeFavorites()
      ),
      this.favoritesAvailableFavoriteButton.forEach((t) => {
        t.addEventListener("click", async () => this.changeFavorites());
      });
  }
  async changeFavorites() {
    (this.favoritesButton.style.pointerEvents = "none"),
      this.inFavorites
        ? await this.deleteFavorites()
        : await this.addFavorites(),
      (this.favoritesButton.style.pointerEvents = "all");
  }
  async addFavorites() {
    (await this.favoritesApi.addToFavorites(this.productId)) &&
      (this.changeStyles(!0), (this.inFavorites = !0));
  }
  async deleteFavorites() {
    (await this.favoritesApi.deleteFromFavorites(this.productId)) &&
      (this.changeStyles(!1), (this.inFavorites = !1));
  }
  changeStyles(t = !0) {
    t
      ? (this.favoritesButton.classList.add(
          "text-secondary",
          "border-secondary",
          "in-fav"
        ),
        (this.favoritesIconDefault.style.display = "none"),
        (this.favoritesIconActive.style.display = "inline"),
        (this.favoritesText.textContent = "В избранном"),
        null != this.favoritesAvailableWindow &&
          ((this.favoritesAvailableFavoriteDefault.style.display = "none"),
          (this.favoritesAvailableFavoriteActive.style.display = "inline")))
      : (this.favoritesButton.classList.remove(
          "text-secondary",
          "border-secondary",
          "in-fav"
        ),
        (this.favoritesIconActive.style.display = "none"),
        (this.favoritesIconDefault.style.display = "inline"),
        (this.favoritesText.textContent = "В избранное"),
        null != this.favoritesAvailableWindow &&
          ((this.favoritesAvailableFavoriteDefault.style.display = "inline"),
          (this.favoritesAvailableFavoriteActive.style.display = "none")));
  }
  removePlaceholder() {
    this.favoritesButton.querySelector(".placeholder").remove(),
      (this.favoritesButton.querySelector(
        ".product-fav__wrapper"
      ).style.visibility = "visible");
  }
}
class ProductQuestionForm {
  constructor() {
    (this.ajaxUrl = "/ajax/form/productQuestionForm.php"),
      (this.questionFormSelector = ".product-ask__form"),
      (this.questionForm = document.querySelector(this.questionFormSelector)),
      this.questionForm && (this.hangEvents(), this.createElements());
  }
  hangEvents() {
    (this.form = document.querySelector(this.questionFormSelector + " form")),
      this.form.addEventListener("submit", (t) => this.handleSubmit(t));
  }
  async handleSubmit(t) {
    if (
      (t.preventDefault(),
      this.setDisableSubmitButton(!0),
      this.clearError(),
      this.isValidData())
    )
      try {
        const e = await Request.fetch(this.ajaxUrl, this.getDataForSubmit());
        e.errors
          ? Object.keys(e.errors).forEach((t) => {
              "message" === t
                ? this.showError(e.errors[t])
                : this.textarea.setError(e.errors[t]);
            })
          : this.showSuccessBlock();
      } catch (t) {
        this.showError("Ошибка запроса, попробуйте позже");
      } finally {
        this.setDisableSubmitButton(!1);
      }
    else this.setDisableSubmitButton(!1);
  }
  createElements() {
    (this.textarea = new Input({
      wrapperSelector: ".product-ask__form .textarea",
      inputSelector: "#ask-text",
      validMask: /.{10}/,
      errorMessage: "Не менее 10 символов",
    })),
      (this.inputProductId = new Input({
        inputSelector: this.questionFormSelector + ' input[name="productId"]',
      })),
      (this.controls = { text: this.textarea, productId: this.inputProductId });
  }
  getDataForSubmit() {
    const e = {};
    return (
      Object.keys(this.controls).forEach((t) => {
        e[t] = this.controls[t].getValue();
      }),
      e
    );
  }
  isValidData() {
    let e = !1;
    return (
      Object.keys(this.controls).forEach((t) => {
        this.controls[t].isValidValue() ||
          (this.controls[t].setError(), (e = !0));
      }),
      !e
    );
  }
  setDisableSubmitButton(t) {
    this.form.querySelector('button[type="submit"]').disabled = t;
  }
  showSuccessBlock() {
    var t = document.querySelector(".product-ask__success");
    (this.questionForm.style.display = "none"), (t.style.display = "block");
  }
  createErrorHtml(t) {
    return `<div class="alert alert-danger product-ask__error mb-4" role="alert">${t}</div>`;
  }
  showError(t) {
    this.form.insertAdjacentHTML("beforebegin", this.createErrorHtml(t));
  }
  clearError() {
    var t = this.questionForm.querySelector(".product-ask__error");
    t && t.remove();
  }
}
class RecommendedProductsSlider {
  constructor() {
    (this.recommendedSliderSelector = ".swiper-container_recommended"),
      this.makeSlider();
  }
  makeSlider() {
    var e = {
      default: { slidesPerView: 2, spaceBetween: 15 },
      [BaseSlider.breakpointMobile]: { slidesPerView: 4, spaceBetween: 20 },
    };
    new BaseSlider(this.recommendedSliderSelector, e).makeSlider();
  }
}
class Reviews {
  constructor() {
    (this.reviewsBlock = document.querySelector(".reviews-list__content")),
      (this.loader = document.querySelector(".loading")),
      (this.productId = this.reviewsBlock.dataset.productId),
      (this.reviewsApi = new ReviewsApi()),
      this.createSelectorSort(),
      this.getReviews(),
      new ReviewAdding(this.productId);
  }
  createSelectorSort() {
    this.selectorSort = new Select({
      selector: ".select--reviews",
      onSelect: (e) => {
        this.getReviews(e);
      },
    });
  }
  hangEvents() {
    (this.reviews = this.reviewsBlock.querySelectorAll(".review")),
      this.reviews.forEach((e) => {
        this.hangLikesAndDislikesEvents(e), this.hangResponseButtonEvent(e);
      });
  }
  hangLikesAndDislikesEvents(e) {
    const t = e.dataset.id,
      s = e.querySelector(".review__reaction--like svg"),
      r = e.querySelector(".review__reaction--dislike svg");
    s.addEventListener("click", () => {
      this.reviewsApi.changeLike(t).then((e) => {
        e && this.setLikesAndDislikesForReview(s, r, e);
      });
    }),
      r.addEventListener("click", () => {
        this.reviewsApi.changeDislike(t).then((e) => {
          e && this.setLikesAndDislikesForReview(s, r, e);
        });
      });
  }
  setLikesAndDislikesForReview(e, t, s) {
    switch (s.ACTIVE) {
      case "LIKE":
        e.classList.add("review__mark-btn--active"),
          t.classList.remove("review__mark-btn--active");
        break;
      case "DISLIKE":
        e.classList.remove("review__mark-btn--active"),
          t.classList.add("review__mark-btn--active");
        break;
      default:
        e.classList.remove("review__mark-btn--active"),
          t.classList.remove("review__mark-btn--active");
    }
    (e.nextElementSibling.textContent = s.LIKES),
      (t.nextElementSibling.textContent = s.DISLIKES);
  }
  getReviews(e = "high") {
    this.setLoader(!0),
      this.reviewsApi.getReviews(this.productId, e).then((e) => {
        this.insertHtml(e), this.hangEvents();
      }),
      this.setLoader(!1);
  }
  insertHtml(e) {
    e = new DOMParser()
      .parseFromString(e, "text/html")
      .querySelector(".reviews-list__content");
    this.reviewsBlock.innerHTML = e.innerHTML;
  }
  createElementsForResponse() {
    this.responseTextarea = new Input({
      wrapperSelector: ".review__reply-form .textarea",
      inputSelector: ".review__reply-form textarea",
      required: !0,
      errorMessage: "Поле обязательно к заполнению",
    });
  }
  createResponseToReviewHtml() {
    return `<div class="card review__reply-form">
                <div class="card-body">
                    <div class="textarea mb-4">
                        <label for="response-text" class="form-label">
                            Введите ответ
                        </label>
                        <textarea id="response-text" rows="3" class="form-control"></textarea>
                    </div>
                    <button class="btn btn-primary">Отправить</button>
                </div>
                <div class="review__reply-form-success card-body">
                    <p>Спасибо Ваш отзыв отправлен</p>
                </div>
            </div>`;
  }
  hangResponseButtonEvent(s) {
    s.querySelectorAll(".review__reply-button").forEach((e) =>
      e.addEventListener("click", () => {
        var e,
          t = s.querySelector(".review__reply-form");
        t
          ? t.remove()
          : ((t = s.querySelector(".review__reply")),
            (e = this.createResponseToReviewHtml()),
            t.insertAdjacentHTML("beforeend", e),
            this.createElementsForResponse(),
            this.hangResponseFormEvents(s));
      })
    );
  }
  hangResponseFormEvents(t) {
    const e = t.dataset.id,
      s = t.querySelector(".review__reply-form");
    s.querySelector("button").addEventListener("click", () => {
      this.responseTextarea.isValidValue()
        ? this.reviewsApi
            .addResponseToReview(e, this.responseTextarea.getValue())
            .then((e) => {
              e
                ? (s.classList.add("review__reply-form--success"),
                  this.hideResponseButtons(t))
                : this.responseTextarea.setError("Ошибка, попробуйте позже");
            })
        : this.responseTextarea.setError();
    });
  }
  hideResponseButtons(e) {
    e.querySelectorAll(".review__reply-button").forEach((e) => e.remove());
  }
  setLoader(e = !1) {
    e
      ? (this.loader.classList.add("loading--show"),
        this.reviewsBlock.classList.remove("reviews-list__content--show"))
      : (this.loader.classList.remove("loading--show"),
        this.reviewsBlock.classList.add("reviews-list__content--show"));
  }
}
class Tabs {
  constructor() {
    (this.reviewsTabId = 5), (this.reviewsFirstLoad = !1), this.makeTabs();
  }
  makeTabs() {
    document.querySelectorAll(".product-about__tab").forEach((e) => {
      e.addEventListener("click", () => {
        var t = e.dataset.tab;
        t != this.reviewsTabId ||
          this.reviewsFirstLoad ||
          (new Reviews(), (this.reviewsFirstLoad = !0)),
          this.changeClasses(e, t);
      });
    });
  }
  changeClasses(t, e) {
    document
      .querySelector(".product-about__tab.product-about__tab--selected")
      .classList.remove("product-about__tab--selected"),
      t.classList.add("product-about__tab--selected");
    (t = document.querySelector(".product__tab.product__tab--active")),
      (e = document.querySelector(`.product__tab[data-tab="${e}"]`));
    t.classList.remove("product__tab--active"),
      e.classList.add("product__tab--active");
  }
}
class VideoReviewsSlider {
  constructor() {
    (this.sliderSelector = ".swiper-container_video-reviews"),
      (this.videoWrappers = document.querySelectorAll(
        ".video-preview__wrapper"
      )),
      this.makeSlider(),
      this.hangEvents();
  }
  hangEvents() {
    this.videoWrappers.forEach((i) => {
      i.addEventListener("click", (e) => {
        e.stopPropagation();
        e = i.dataset.videoSrc;
        new VideoReviewModal(e);
      });
    });
  }
  makeSlider() {
    var e = {
        default: { slidesPerView: 1.05, spaceBetween: 15 },
        [BaseSlider.breakpointMobile]: { spaceBetween: 20, slidesPerView: 2 },
      },
      e = new BaseSlider(this.sliderSelector, e);
    this.photosSlider = e.makeSlider();
  }
}
class SearchPage {
  constructor(a) {
    var e = a?.templateFolder,
      r = a?.paramsCatalog,
      t = a?.countSearch,
      o = a?.pageSize;
    0 != a?.countProduct &&
      0 != t &&
      new SearchPageSort({ templateFolder: e, paramsCatalog: r, pageSize: o });
  }
}
class SearchPageHttp {
  static async fetchElements(t = {}) {
    var e = t.url,
      t = {
        method: "POST",
        headers: { "Content-Type": "text/html", "x-requested-with": "Y" },
        body: JSON.stringify({ params: t }),
      };
    return await (await fetch(e, t)).text();
  }
}
class SearchPageSort {
  constructor(t = {}) {
    (this.searchPageWrapper = document.querySelector(".search-result-page")),
      (this.sortCatalogFilterWrapper = this.searchPageWrapper.querySelector(
        ".search-catalog-filters__wrapper"
      )),
      (this.sortBlock = this.searchPageWrapper.querySelector(
        ".filters .select__wrapper"
      )),
      (this.sortDefaultValue = this.sortBlock.querySelector(
        "#select__main-default-value"
      )),
      (this.sortOptions = this.sortBlock.querySelectorAll(
        ".select__options .select__option"
      )),
      (this.loader = this.searchPageWrapper.querySelector(".loading")),
      (this.ajaxUrl = "/ajax/search/sortProducts.php"),
      (this.paramsCatalog = t?.paramsCatalog),
      (this.sortCode = null),
      (this.searchTarget = null),
      (this.searchPagination = null),
      (this.searchPaginationLimit = t?.pageSize),
      (this.productsDataApi = new ProductsDataApi()),
      this.hangEvents();
  }
  hangEvents() {
    this.hangSort();
  }
  hangSort() {
    this.sortBlock.addEventListener("click", (t) =>
      this.toggleStatusSortBlock()
    ),
      this.sortOptions.forEach((t) =>
        t.addEventListener("click", (t) => {
          this.changeSort(t.target);
        })
      );
  }
  toggleStatusSortBlock() {
    this.sortBlock.classList.contains("select--expanded")
      ? this.sortBlock.classList.remove("select--expanded")
      : this.sortBlock.classList.add("select--expanded");
  }
  changeSort(t) {
    this.sortDefaultValue.innerHTML = t.innerHTML;
    var e = t.parentNode?.dataset.id,
      t = t?.dataset.id,
      e = e || t;
    void 0 !== e &&
      this.sortCode != e &&
      ((this.searchTarget = this.getUrlParam("q")),
      (this.searchPagination = this.getUrlParam("cur_page")),
      (this.sortCode = e),
      this.fetchHTMLElements());
  }
  hangProductCardsEvents() {
    var t = this.getProductsIds();
    t.length &&
      this.productsDataApi.getData(t).then((t) => {
        new ProductCards(t);
      });
  }
  getProductsIds() {
    var t = document.querySelectorAll(".product-card");
    return Array.from(t).map((t) => t.dataset.id);
  }
  async fetchHTMLElements() {
    SearchPageHttp.fetchElements({
      url: this.ajaxUrl,
      paramsCatalog: this.paramsCatalog,
      sortCode: this.sortCode,
      searchPagination: this.searchPagination,
      searchPaginationLimit: this.searchPaginationLimit,
      searchTarget: this.searchTarget,
    }).then((t) => {
      if (t) {
        this.setLoader(!0);
        const e = new DOMParser()
          .parseFromString(t, "text/html")
          .querySelector(".search");
        setTimeout(() => {
          this.insertHTMLElements(e);
        }, 1e3);
      }
    });
  }
  insertHTMLElements(t) {
    (this.searchPageWrapper.querySelector(".search").outerHTML = t.outerHTML),
      this.setLoader(!1),
      this.hangProductCardsEvents(),
      this.buildURL(),
      this.changeUrl(),
      this.changeUrlPagination();
  }
  setLoader(t = !0) {
    t
      ? ((this.sortCatalogFilterWrapper.style.display = "none"),
        this.loader.classList.add("loading--show"))
      : (this.loader.classList.remove("loading--show"),
        (this.sortCatalogFilterWrapper.style.display = "block"));
  }
  getUrlParam(t) {
    var e = new URL(window.location.href);
    return new URLSearchParams(e.search).get(t);
  }
  buildURL() {
    var t = new URL(window.location.href),
      e = new URLSearchParams(t.search);
    return (
      e.set("sort", this.sortCode),
      "" + t.origin + t.pathname + "?" + e.toString()
    );
  }
  rebuildURLPagination(t, e, a) {
    var t = new URL(t),
      r = new URLSearchParams(t.search);
    return r.set(e, a), (t.search = r.toString()), t;
  }
  changeUrl() {
    var t = this.buildURL();
    history.pushState(history.state, "", "" + t);
  }
  changeUrlPagination() {
    document
      .querySelectorAll(".search-page .pagination.container a")
      .forEach((t) => {
        var e = new URL(window.location.href),
          e = "" + e.origin + e.pathname + t.getAttribute("href"),
          e = new URL(this.rebuildURLPagination(e, "sort", this.sortCode));
        t.setAttribute("href", e.search);
      });
  }
}
