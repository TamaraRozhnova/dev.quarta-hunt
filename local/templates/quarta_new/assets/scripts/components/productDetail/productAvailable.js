class AvailableBlock {

    constructor() {
        this.btnsOpenAvailableWindow = document.querySelectorAll("a[data-available-index]")
        this.initModal()
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