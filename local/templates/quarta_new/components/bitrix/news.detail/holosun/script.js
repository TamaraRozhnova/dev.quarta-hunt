$(document).ready(function() {


    /*slider init */
    new Swiper('.swiper', {
        speed: 400,
        spaceBetween: 40,
        navigation: {
            nextEl: '.base-slider__next',
            prevEl: '.base-slider__prev',
        },
        scrollbar: {
            el: '.swiper-scrollbar',
        },
    });

    /* assort tabs mobile*/
    $('.holosun__series-tabs-wr h2').on('click', function () {

        $('.holosun__series-tabs-wr h2').removeClass('active')
        $(this).addClass('active')
        $('.holosun__series .open').removeClass('open');

        var tabIndex = $(this).index();
        $('.holosun__series > div').eq(tabIndex).addClass('open');
    })
});