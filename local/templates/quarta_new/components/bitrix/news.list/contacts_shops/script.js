window.addEventListener('DOMContentLoaded', () => {
    class Contacts {
        constructor() {
            this.selectorShopElement = document.querySelector('.select--shop');
            this.shopInfoWrappers = document.querySelectorAll(".shop-info__wrapper.row")

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
                    
                    this.shopInfoWrappers.forEach( (shopInfo) => {
                        shopInfo.classList.remove('active')

                        if (shop.ID == shopInfo.getAttribute('data-id')) {
                            shopInfo.classList.add('active')
                        }
                    })

                    this.yandexMap.setLocation(shop);
                }
            });
        }
    }

    new Contacts();
})
