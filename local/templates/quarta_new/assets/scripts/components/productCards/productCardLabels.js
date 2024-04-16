class ProductCardLabels {
    constructor(productElement) {

        this.productElement = productElement;

        this.productId = this.productElement.dataset.id;
        this.productTags = this.productElement.querySelector('.product-card__tags')
        this.productBtnShowTags = this.productTags.querySelector('.product-btn-list-labels')

        this.productImageFigure = this.productElement.querySelector('.product-card__image figure')
        this.productImageWrapper = this.productImageFigure.parentNode

        if (this.productBtnShowTags) {
            this.hangClickBtnShowTags()
        }

    }

    hangClickBtnShowTags() {

        const blurNode = this.createBlur()

        this.productBtnShowTags.addEventListener('click', () => {

            const productTagsClasslist = this.productTags.classList

            switch (productTagsClasslist.contains('show-all-tags')) {
                case true:
                    productTagsClasslist.remove('show-all-tags')
                    this.productImageWrapper.removeChild(blurNode)
                    break;
                case false:
                    productTagsClasslist.add('show-all-tags')
                    this.productImageWrapper.appendChild(blurNode)
                    break;
            }

        })
    }

    createBlur() {
        const blurNode = document.createElement('div')
        blurNode.classList.add('product-card-blur-img')

        return blurNode
    }

}