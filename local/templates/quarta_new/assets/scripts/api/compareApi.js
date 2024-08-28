class CompareApi {
    constructor() {
        this.url = '/ajax/personal/compare.php';
        this.action = {
            ADD: 'ADD_TO_COMPARE_LIST',
            DELETE: 'DELETE_FROM_COMPARE_LIST',
            CLEAR: 'CLEAR'
        }

        this.headerTopCompareBadge = document.querySelector('.header__top-item .compare-badge');
        this.headerBottomCompareBadge = document.querySelector('.header__bottom-item .compare-badge');
    }

    async addToCompare(productId) {
        const response = await Request.fetch(`${this.url}?action=${this.action.ADD}&id=${productId}`);
        if (response) {
            window.compareCount++;
            this.displayCompareCount();
        }
        return response;
    }

    async deleteFromCompare(productId) {
        const response = await Request.fetch(`${this.url}?action=${this.action.DELETE}&id=${productId}`);
        if (response) {
            window.compareCount--;
            this.displayCompareCount();
        }
        return response;
    }

    async clearCompare() {
        const response = await Request.fetch(`${this.url}?action=${this.action.CLEAR}`);
        if (response) {
            window.compareCount = 0;
            this.displayCompareCount();
        }
        return response;
    }

    displayCompareCount() {
        if (!window.compareCount) {
            this.headerTopCompareBadge.style.display = 'none';

            if (this.headerBottomCompareBadge) {
                this.headerBottomCompareBadge.style.display = 'none';
            }

            return;
        }
        this.headerTopCompareBadge.textContent = window.compareCount;
        this.headerTopCompareBadge.style.display = 'block';

        if (this.headerBottomCompareBadge) {
            this.headerBottomCompareBadge.textContent = window.compareCount;
            this.headerBottomCompareBadge.style.display = 'flex';
        }
    }
}