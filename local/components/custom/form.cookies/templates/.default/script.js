document.addEventListener("DOMContentLoaded", function(event) {

    const formCookiesWrapper = document.querySelector('.form-cookies-wrapper')
    const formCookies = formCookiesWrapper.querySelector('.form-cookies')
    const formCookiesApplyBtn = formCookies.querySelector('.form-cookies-btn > button')


    formCookiesApplyBtn.addEventListener('click', () => {

        /**
         * Для моблиьных устройств при клике на "Принять куки"
         * 
         * Сделано для того, чтобы убрать задержку скрытия 
         * уведомления о куках
         */
        
        if (window.innerWidth < 747) {
            formCookiesWrapper.classList.add('remove')
        }

          $.ajax({
            url: '/ajax/form/cookiesForm.php',
            type: "POST",
            data: { COOKIE_APPLY: 'Y' },
            success: function(response) {
                
                if (!formCookiesWrapper.classList.contains('remove')) {
                    formCookiesWrapper.classList.add('remove')
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    })


});