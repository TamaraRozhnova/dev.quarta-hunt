class ProductsDataApi {
    constructor() {
        this.url = '/ajax/products/productsData.php';
    }

    async getData(productIds) {
        const data = { productIds };
        return await Request.fetch(this.url, data);
    }
}