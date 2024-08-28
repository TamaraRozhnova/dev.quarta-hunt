class ProductCardDescriptionAccordeon {
    constructor(productElement) {

        this.productElement = productElement;

        this.productId = this.productElement.dataset.id;
        this.productAccordeon = this.productElement.querySelector('.product-card__preview-text')

        if (!this.productAccordeon) {
            return false;
        }

        this.productAccordeonBtn = this.productAccordeon.querySelector('.product-card__preview-text-btn')
        this.productAccordeonText = this.productAccordeon.querySelector('.product-card__preview-text-content')
        this.productAccordeonSvg = this.productAccordeon.querySelector('.product-card__preview-text-svg')

        this.hangClickAccordeon();

    }

    hangClickAccordeon() {
        this.productAccordeonBtn.addEventListener('click', () => this.toggleAccordeon())
    }

    toggleAccordeon() {
        $(this.productAccordeonText).slideToggle('fast');
        this.productAccordeonSvg.classList.toggle('active')
    }

}