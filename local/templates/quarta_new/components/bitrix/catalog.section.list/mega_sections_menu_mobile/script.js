$(document).ready(function () {

    /* mobile menu logic */


        /* jq menu hover, click both menu*/
        $('.catalog-mobile .menu-list li').on('click', function (e) {
            let contentId = $(this).data('id');

            $('.catalog-mobile .menu-list li').each((index, el) => {
                $(el).removeClass('active');
            })
            $('.catalog-mobile .menu-content-data').each((index, el) => {
                $(el).removeClass('active');
            })

            $('.catalog-mobile .menu-content').removeClass('sale')
            if (contentId == 'sale') {
                $('.catalog-mobile .menu-content').addClass('sale')
            }

            $('.header--mobile .mobile-nav__back').show()
            $('.catalog-slide-menu').addClass('active')
            $(this).addClass('active')
            $(".catalog-mobile [data-content='" + contentId + "']").addClass('active');
            console.log(123123)

            $('.mobile-nav__body').animate({
                scrollTop: 0
            }, 150);
        });

    $('.header--mobile .mobile-nav__back').on('click', function () {
        $(this).hide();
        $('.catalog-slide-menu').removeClass('active')
    })
});
