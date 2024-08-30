class ProductCardCompare {
    constructor(data = {
        productElement,
        compareList
    }, events = {
        onDelete
    }
    ) {
        this.productElement = data.productElement;
        this.productId = this.productElement.dataset.id;
        this.compareList = data.compareList;

        this.onDelete = events.onDelete;
        this.popupWrap = document.querySelector('.compare-popup');
        this.closePopupWrap = document.querySelector('.compare-popup_close');

        this.compareApi = new CompareApi();

        this.hangEvents();
        this.defineCompare();
    }

    closePopup(){
        this.popupWrap.classList.remove("active");
    }

    openPopup(){
        if(this.compareApi.headerTopCompareBadge.innerText > 1){
            this.popupWrap.classList.add("active");
        }
    }

    defineCompare() {
        this.removePlaceholder();
        const inCompare = this.compareList[this.productId];
        if (inCompare) {
            this.changeStyles(true);
        } else {
            this.changeStyles(false);
        }
    }

    hangEvents() {
        this.productId = this.productElement.dataset.id;
        this.compareIconDefault = this.productElement.querySelector('.product-card__compare--default');
        this.compareIconActive = this.productElement.querySelector('.product-card__compare--active');

        if (this.productElement.querySelector('.product-card__remove-compare') != null) {
            this.productElement.querySelector('.product-card__remove-compare').addEventListener('click', async () => this.deleteCompare())
        }

        this.compareIconDefault.addEventListener('click', async () => this.addCompare());
        this.compareIconActive.addEventListener('click', async () => this.deleteCompare());
        if(this.closePopupWrap !== null){
            this.closePopupWrap.addEventListener('click', async () => this.closePopup());
        }
    }

    async addCompare() {
        const response = await this.compareApi.addToCompare(this.productId);
        if (!response) {
            return;
        }
        this.changeStyles(true);
        this.openPopup();
    }

    async deleteCompare() {
        const response = await this.compareApi.deleteFromCompare(this.productId);
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
            this.compareIconDefault.style.display = 'none';
            this.compareIconActive.style.display = 'inline';
        } else {
            this.compareIconActive.style.display = 'none';
            this.compareIconDefault.style.display = 'inline';
        }
    }

    removePlaceholder() {
        const placeholder = this.productElement.querySelector('.placeholder--compare');
        placeholder.remove();
    }
}