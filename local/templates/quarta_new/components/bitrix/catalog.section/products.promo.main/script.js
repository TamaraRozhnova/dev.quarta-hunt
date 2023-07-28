(function () {
    window.addEventListener('DOMContentLoaded', () => {

        new Swiper('.swiper', {
            speed: 400,
            spaceBetween: 100,
            navigation: {
                nextEl: '.base-slider__next',
                prevEl: '.base-slider__prev',
              },
        });

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