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

        this.productsData = productsData;

        this.initModal()
        this.hangEvents()
        
    }

    hangEvents() {

        let productElement = this.productElement
        
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