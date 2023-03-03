class CompareApi {
    constructor() {
        this.url = '/ajax/personal/compare.php';
        this.action = {
            ADD: 'ADD_TO_COMPARE_LIST',
            DELETE: 'DELETE_FROM_COMPARE_LIST'
        }

        this.headerTopCompareBadge = document.querySelector('.header__top-item .compare-badge');
        this.headerBottomCompareBadge = document.querySelector('.header__bottom-item .compare-badge');
        this.compareCount = window.compareCount || 0;
    }

    async addToCompare(productId) {
        const response = await Request.fetch(`${this.url}?action=${this.action.ADD}&id=${productId}`);
        if (response) {
            this.compareCount++;
            this.displayCompareCount();
        }
        return response;
    }

    async deleteFromCompare(productId) {
        const response = await Request.fetch(`${this.url}?action=${this.action.DELETE}&id=${productId}`);
        if (response) {
            this.compareCount--;
            this.displayCompareCount();
        }
        return response;
    }

    displayCompareCount() {
        if (!this.compareCount) {
            this.headerTopCompareBadge.style.display = 'none';
            this.headerBottomCompareBadge.style.display = 'none';
            return;
        }
        this.headerTopCompareBadge.textContent = this.compareCount;
        this.headerTopCompareBadge.style.display = 'block';
        this.headerBottomCompareBadge.textContent = this.compareCount;
        this.headerBottomCompareBadge.style.display = 'flex';
    }
}