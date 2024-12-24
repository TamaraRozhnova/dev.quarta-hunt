(function () {
    window.addEventListener('DOMContentLoaded', () => {
        const productElements = document.querySelectorAll('.product-card');
        const productIds = Array.from(productElements).map(element => element.dataset.id);
        if (!productIds.length) {
            return;
        }
        const productsDataApi = new ProductsDataApi();
        productsDataApi.getData(productIds)
            .then(response => {
                new ProductCards(response);
            })
    })
})();