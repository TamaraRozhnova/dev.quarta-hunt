
class SearchLive {
    constructor(params = {
        mobile:null
    }) {

        this.headerPC = document.querySelector('.header--desktop')
        this.headerMobile = document.querySelector('.header--mobile')
        this.body = document.querySelector('body')

        if (params?.mobile == null) {
            this.liveSearchWrapper = this.headerPC.querySelector('.search-live__wrapper')
        } else {
            this.liveSearchWrapper = this.headerMobile.querySelector('.search-live__wrapper')
            this.btnCancel = this.headerMobile.querySelector('.search-live__items-btn-cancel')
        }

        if (this.liveSearchWrapper == null) {
            return
        }

        this.liveSearchInput = this.liveSearchWrapper.querySelector('.search-live__input')
        this.matchsItems = this.liveSearchWrapper.querySelector('.search-live__items')
        this.timer;
        this.ajaxUrl = '/ajax/search/getMatchsLive.php'

        this.hangEvents();

    }

    hangEvents() {
        this.hangInput();
        this.hangClickEmptyArea();
        this.hangClickOnInput();
        this.hangClickBtnCancel();
    }

    hangInput() {
        this.liveSearchInput.addEventListener('input', (e) => {
            clearTimeout(this.timer)
    
            this.timer = setTimeout(() => {
                this.getMatches(e.target.value)
            }, 500);
        })
    }

    hangClickEmptyArea() {
        document.addEventListener('click', (e) => {

            if (!e.target.closest('.search-live__wrapper')) {
                this.matchsItems.classList.add('hide')
                this.body.classList.remove('stop-scrolling')
                return;
            }

        })
    }

    hangClickBtnCancel() {
        if (this.btnCancel == null) {
            return
        }

        this.btnCancel.addEventListener('click', (e) => {
            this.btnCancel.classList.add('hide')
            this.matchsItems.classList.add('hide')
            this.body.classList.remove('stop-scrolling')
        })
    }

    hangClickOnInput() {
        this.liveSearchInput.addEventListener('click', (e) => {
            if (this.matchsItems.hasChildNodes()) {

                if (this.btnCancel != null) {
                    this.btnCancel.classList.remove('hide')
                }

                this.matchsItems.classList.remove('hide')

                this.body.classList.add('stop-scrolling')
            }
        })
    }

    getMatches(value) {

        if (value.trim() == '') {
            return;
        }

        const urlWithParams = this.ajaxUrl + `?q=${value}`

        const queryToAjax = Request.fetch(urlWithParams)
        
        queryToAjax.then((response) => {

            if (response?.STATUS == 'ERROR') {
                return console.log('ERROR')
            }

            this.showResultMatches(response)

        })
    }

    buildHtmlMatch(ob) {

        let htmlArray = '';

        const sizeObject = Object.keys(ob).length

        if (sizeObject != 0) {

            for (let index = 0; index < sizeObject; index++) {

                const element = ob[index];

                htmlArray += 
                    `<div class = 'search-live__item'>
                        <div class = 'search-live__item-icon'>
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.8082 15.885L13.2794 12.3562C14.5256 10.8721 15.1508 8.96421 15.0245 7.03043C14.8983 5.09664 14.0305 3.28623 12.6019 1.97673C11.1734 0.667227 9.29454 -0.040272 7.3571 0.00177205C5.41965 0.0438161 3.57323 0.832157 2.20287 2.2024C0.832506 3.57264 0.0440018 5.41899 0.00178652 7.35643C-0.0404288 9.29387 0.666904 11.1728 1.97628 12.6014C3.28566 14.0301 5.09599 14.8981 7.02976 15.0245C8.96353 15.1509 10.8715 14.5259 12.3557 13.2799L15.8845 16.8087C16.007 16.9312 16.1731 17 16.3463 17C16.5196 17 16.6857 16.9312 16.8082 16.8087C16.9307 16.6862 16.9995 16.5201 16.9995 16.3468C16.9995 16.1736 16.9307 16.0075 16.8082 15.885ZM1.32461 7.52938C1.32461 6.30218 1.68852 5.10254 2.37031 4.08216C3.05211 3.06178 4.02117 2.26649 5.15495 1.79686C6.28874 1.32723 7.53632 1.20436 8.73994 1.44377C9.94356 1.68319 11.0492 2.27414 11.9169 3.1419C12.7847 4.00966 13.3756 5.11526 13.615 6.31887C13.8545 7.52249 13.7316 8.77008 13.262 9.90386C12.7923 11.0376 11.997 12.0067 10.9767 12.6885C9.95628 13.3703 8.75664 13.7342 7.52944 13.7342C5.88439 13.7323 4.30724 13.078 3.14402 11.9148C1.98079 10.7516 1.32647 9.17443 1.32461 7.52938Z" fill="white"></path>
                            </svg>
                        </div>
                        <a class="search-live__item-link" href='${element['detail_page']}'>
                            <span>${element['name']}</span>
                        </a>
                        <a class="search-live__item-section search-live__item-bold" href='${element['section_detail_page']}'>
                            ${element['section_name']}
                        </a>
                    </div>`
                
            }

        }

        return htmlArray

    }

    buildHtmlNotFound() {
        const html = `
            <div class = 'search-live__not-found'>
                <span>Ничего не найдено</span>
            </div>`
        return html
    }

    showResultMatches(response) {
        const products = response?.PRODUCTS
        const articles = response?.ARTICLES

        let result;

        if (
            products.length == 0
            &&
            articles.length == 0
        ) {
            result = this.buildHtmlNotFound()
        } else {
            result = this.buildHtmlMatch(products) + this.buildHtmlMatch(articles)
        }
        
        this.matchsItems.classList.remove('hide')
        this.body.classList.add('stop-scrolling')

        if (this.btnCancel != null) {
            this.btnCancel.classList.remove('hide')
        }
        
        this.matchsItems.innerHTML = result

    }

}

window.addEventListener('DOMContentLoaded', (e) => {
    if (window.innerWidth > 1200) {
        new SearchLive()
    } else {
        new SearchLive({
            mobile: true
        })
    }
})


