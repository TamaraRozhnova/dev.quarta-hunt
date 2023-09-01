document.addEventListener("DOMContentLoaded", function(event) {

    const formCookiesWrapper = document.querySelector('.form-cookies-wrapper')
    const formCookies = formCookiesWrapper.querySelector('.form-cookies')
    const formCookiesApplyBtn = formCookies.querySelector('.form-cookies-btn > button')


    formCookiesApplyBtn.addEventListener('click', () => {

          $.ajax({
            url: '/ajax/form/cookiesForm.php',
            type: "POST",
            data: { COOKIE_APPLY: 'Y' },
            success: function(response) {
                formCookiesWrapper.classList.add('remove')

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    })


});