class AvailableBlock {

    constructor(
        productsData,
        events = {
            onDeleteFavorites: null,
            onDeleteCompare: null
        }
    ) {

        this.btnsOpenAvailableWindow = document.querySelectorAll("a[data-available-index]")
        this.productElement = document.querySelector(".available-product-window");

        this.onDeleteFavorites = events.onDeleteFavorites;
        this.onDeleteCompare = events.onDeleteCompare;

        this.productsData = productsData;

        this.initModal()
        this.hangEvents()
        
    }

    hangEvents() {

        let productElement = this.productElement

        new ProductCardFavorites(
            { productElement, favoritesList: this.productsData.FAVORITES },
            { onDelete: this.onDeleteFavorites }
        );

        new ProductCardCompare(
            { productElement, compareList: this.productsData.COMPARE },
            { onDelete: this.onDeleteCompare }
        );
        
        new RatingStarsHelper(
            { productElement, ratingsList: this.productsData.RATINGS }
        );

    }

    initModal() {
        if (this.btnsOpenAvailableWindow.length != 0) {

            this.btnsOpenAvailableWindow.forEach( (btn) => {
                
                btn.addEventListener("click", (event) => {
                    event.preventDefault();
                })

                new Modal({
                    modalOpenElementSelector: `.available-window-open-${btn.getAttribute("data-available-index")}`,
                    modalSelector: "#available-window"
                })

            });

        }
    }

}