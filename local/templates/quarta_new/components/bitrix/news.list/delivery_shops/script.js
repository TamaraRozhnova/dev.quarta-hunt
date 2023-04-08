window.addEventListener('DOMContentLoaded', () => {
    class DeliveryShops {
        constructor() {
            this.selectorShopElement = document.querySelector('.select--shop');
            if (!this.selectorShopElement) {
                return;
            }
            this.createElements();
            this.yandexMap = new YandexMap('shop-map', shops);
        }

        createElements() {
            new Select({
                element: this.selectorShopElement,
                onSelect: (id) => {
                    const shop = shops.find(shop => shop.ID == id);
                    this.yandexMap.setLocation(shop);
                }
            });
        }
    }

    new DeliveryShops();
})
