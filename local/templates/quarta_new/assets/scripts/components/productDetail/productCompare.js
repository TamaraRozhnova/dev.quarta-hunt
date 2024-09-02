class ProductCompare {
    constructor(compareList) {
        this.productElement = document.querySelector('.product');
        this.productId = this.productElement.dataset.id;

        this.compareList = compareList;
        this.compareApi = new CompareApi();
        this.compareButton = this.productElement.querySelector('.product-compare');

        this.compareAvailableWindow = document.querySelector('.available-window__wrapper');
        this.compareAvailableActions = this.compareAvailableWindow.querySelector('.product-card__image-actions')

        this.compareAvailableCompareBtn = this.compareAvailableActions.querySelectorAll('.product-card__compare');

        this.compareAvailableCompareDefault = this.compareAvailableActions.querySelector('.product-card__compare--default')
        this.compareAvailableCompareActive = this.compareAvailableActions.querySelector('.product-card__compare--active')

        this.hangEvents();
        this.defineCompare();
    }

    defineCompare() {
        this.removePlaceholder();
        this.inCompare = this.compareList[this.productId];
        if (this.inCompare) {
            this.changeStyles(true);
        } else {
            this.changeStyles(false);
        }
    }

    hangEvents() {
        this.compareIconDefault = this.compareButton.querySelector('.product-compare__default');
        this.compareIconActive = this.compareButton.querySelector('.product-compare__active');
        this.compareButton.addEventListener('click', async() => this.changeCompare())

        this.compareAvailableCompareBtn.forEach( (btnComp) => {
            btnComp.addEventListener('click', async() => this.changeCompare())
        })

    }

    async changeCompare() {
        this.compareButton.style.pointerEvents = 'none';

        if (this.inCompare || this.compareButton.classList.contains('in-compare')) {
            await this.deleteCompare();
        } else {
            await this.addCompare();
        }

        this.compareButton.style.pointerEvents = 'all';

    }

    async addCompare() {
        const response = await this.compareApi.addToCompare(this.productId);
        if (!response) {
            return;
        }
        this.changeStyles(true);
        this.inCompare = true;
    }

    async deleteCompare() {
        const response = await this.compareApi.deleteFromCompare(this.productId);
        if (!response) {
            return;
        }
        this.changeStyles(false);
        this.inCompare = false;
    }

    changeStyles(state = true) {

        if (state) {
            this.compareButton.classList.add('text-secondary', 'border-secondary', 'in-compare');
            this.compareIconDefault.style.display = 'none';
            this.compareIconActive.style.display = 'inline';

            /** Смена стилей для модального окна */
            if (this.compareAvailableWindow != null) {
                this.compareAvailableCompareDefault.style.display = 'none';
                this.compareAvailableCompareActive.style.display = 'inline';
            } 

        } else {
            this.compareButton.classList.remove('text-secondary', 'border-secondary', 'in-compare');
            this.compareIconActive.style.display = 'none';
            this.compareIconDefault.style.display = 'inline';

            /** Смена стилей для модального окна */
            if (this.compareAvailableWindow != null) {
                this.compareAvailableCompareDefault.style.display = 'inline';
                this.compareAvailableCompareActive.style.display = 'none';
            } 

        }
    }

    removePlaceholder() {
        const placeholder = this.compareButton.querySelector('.placeholder');
        placeholder.remove();
        const wrapper = this.compareButton.querySelector('.product-compare__wrapper');
        wrapper.style.visibility = 'visible';
    }
}