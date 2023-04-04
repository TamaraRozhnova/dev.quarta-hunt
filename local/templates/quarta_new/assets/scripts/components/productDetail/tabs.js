class Tabs {
    constructor() {
        this.reviewsTabId = 5;
        this.reviewsFirstLoad = false;

        this.makeTabs();
    }

    makeTabs() {
        const tabsButtons = document.querySelectorAll('.product-about__tab');
        tabsButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.dataset.tab;
                if (tabId == this.reviewsTabId && !this.reviewsFirstLoad) {
                    new Reviews();
                    this.reviewsFirstLoad = true;
                }
                this.changeClasses(button, tabId);
            });
        });
    }

    changeClasses(button, tabId) {
        const currentActiveButton = document.querySelector(`.product-about__tab.product-about__tab--selected`);
        currentActiveButton.classList.remove('product-about__tab--selected');
        button.classList.add('product-about__tab--selected');

        const currentActiveTab = document.querySelector(`.product__tab.product__tab--active`);
        const newActiveTab = document.querySelector(`.product__tab[data-tab="${tabId}"]`);
        currentActiveTab.classList.remove('product__tab--active');
        newActiveTab.classList.add('product__tab--active');
    }
}