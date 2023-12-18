class PromoPage {
    constructor() {
        this.btn = document.querySelector('.p2p-line__wrapper')
        this.ajaxUrl = `/local/components/custom/promo.page/ajax.php`

        this.handleBtn()

        setTimeout(() => {
            this.btn.classList.remove('hide')
        }, 2500);
    }

    handleBtn()
    {
        let _this = this

        this.btn.addEventListener('click', (e) => {
            e.preventDefault();

            const linkHref = this.btn.href

            $.ajax({
                url: this.ajaxUrl,
                type: "POST",
                data: { COOKIE_APPLY: 'Y' },
                success: function(response) {                    
                    _this.btn.classList.add('hide')

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