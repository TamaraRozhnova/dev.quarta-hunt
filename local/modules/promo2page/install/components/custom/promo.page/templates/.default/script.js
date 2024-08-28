class PromoPage {
    constructor() {
        this.wrap = document.querySelector('.p2p-line__wrapper')
        this.btn = document.querySelector('.p2p-line__wrapper .p2p-line__inner')
        this.btnClose = document.querySelector('.p2p-line__wrapper .p2p-line__close')
        this.ajaxUrl = `/local/components/custom/promo.page/ajax.php`

        this.handleBtn()
        this.handleBtnClose()

        if(BX.getCookie('P2P_APPLY') !== 'Y'){
            setTimeout(() => {
                this.wrap.classList.remove('hide')
            }, 2500);
        }
    }

    handleBtnClose()
    {
        let _this = this.wrap
        this.btnClose.addEventListener('click', (e) => {
            _this.classList.add('close')
            BX.setCookie("P2P_APPLY", "Y", Date.now() + 3600);
        })

    }


    handleBtn()
    {
        let _this = this.wrap

        this.btn.addEventListener('click', (e) => {
            e.preventDefault();

            const linkHref = this.btn.href

            $.ajax({
                url: this.ajaxUrl,
                type: "POST",
                data: { COOKIE_APPLY: 'Y' },
                success: function(response) {                    
                    _this.classList.add('hide')

                    setTimeout(() => {
                        window.location.replace(linkHref)
                    }, 250);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            })

        })
    }

}

document.addEventListener('DOMContentLoaded', (e) => {
    setTimeout(() => {
        new PromoPage
    }, 50)
})