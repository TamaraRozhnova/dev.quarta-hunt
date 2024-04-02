$(document).ready(function() {


    /*slider init */
    new Swiper('.compact-swiper ', {
        speed: 400,
        spaceBetween: 0,
        navigation: {
            nextEl: '.base-slider__next',
            prevEl: '.base-slider__prev',
        },
        scrollbar: {
            el: '.swiper-scrollbar',
        },
    });

    new Swiper('.holosun-ruler-swiper', {
        speed: 400,
        spaceBetween: 40,
        centeredSlides: true,
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