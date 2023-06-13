window.addEventListener('DOMContentLoaded', () => {
    class Contacts {
        constructor() {
            this.selectorShopElement = document.querySelector('.select--shop');
            this.shopInfoWrappers = document.querySelectorAll(".shop-info__wrapper.row")
            this.shopMaps = document.querySelector('.shop-maps')

            if (!this.selectorShopElement) {
                return;
            }
            
            this.createElements();

        }

        createElement(htmlStr) {
            let frag = document.createDocumentFragment(),
                temp = document.createElement('div');
            temp.innerHTML = htmlStr;
            while (temp.firstChild) {
                frag.appendChild(temp.firstChild);
            }
            return frag;
        }

        deactiveElements() {
            if (this.shopMaps.querySelectorAll('div[data-id]').length != 0) {

                this.shopMaps.querySelectorAll('div[data-id]').forEach( (map) => {
                    map.classList.remove('active')
                })

            }
        }

        createElements() {
            new Select({
                element: this.selectorShopElement,
                onSelect: (id) => {
                    const shop = shops.find(shop => shop.ID == id);
                    
                    this.shopInfoWrappers.forEach( (shopInfo) => {
                        shopInfo.classList.remove('active')

                        if (shop.ID == shopInfo.getAttribute('data-id')) {

                            let currentShopID = shopInfo.getAttribute('data-id')

                            if (typeof shop.PROPERTIES != 'undefined') {

                                if (typeof shop.PROPERTIES.IFRAME_YA_MAP != 'undefined') {

                                    if (this.shopMaps.querySelector(`div[data-id = "${currentShopID}"]`) == null) {

                                        this.deactiveElements()

                                        let newMap = this.createElement(
                                            `
                                            <div data-id = '${currentShopID}' class = 'shop-map active'>
                                                ${shop.PROPERTIES.IFRAME_YA_MAP['~VALUE']}
                                            </div>
                                            `
                                        );

                                        this.shopMaps.append(newMap)

                                    } else {
                                        
                                        this.deactiveElements()

                                        this.shopMaps.querySelector(`div[data-id = "${currentShopID}"]`).classList.add('active')
                                        
                                    }

                                }

                            }
                            shopInfo.classList.add('active')
                        }
                    })
                }
            });
        }
    }

    new Contacts();
})
