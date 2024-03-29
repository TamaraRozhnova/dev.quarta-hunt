$(document).ready(function () {

    /* open mega menu */
    $('.mega-menu-opener').on('click', function (e) {
        e.preventDefault();


        $('.mega-menu').css('top', 215)
        $('.mega-menu').css('height', window.innerHeight-215)
        if (window.scrollY > 50) {
            $('.mega-menu').css('top', 135)
            $('.mega-menu').css('height', window.innerHeight-135)
        }

        $('.mega-menu').toggleClass('open');
        $(this).toggleClass('open')
    });
    $(document).on('click', function (e) {
        let button = $('.mega-menu-opener');
        let container = $('.mega-menu');

        if (
            (!container.is(e.target) && container.has(e.target).length === 0) &&
            (!button.is(e.target) && button.has(e.target).length === 0)
        ) {
            container.removeClass('open')
            button.removeClass('open')
        }
    });


    /* jq menu hover*/
    $('.menu-list li').on('mouseover', function (e) {
        let contentId = $(this).data('id');

        $('.menu-list li').each((index, el) => {
            $(el).removeClass('active');
        })
        $('.menu-content-data').each((index, el) => {
            $(el).removeClass('active');
        })

        $('#manu-brands-list').show()
        $('.menu-content').removeClass('sale')
        if (contentId == 'sale') {
            $('#manu-brands-list').hide()
            $('.menu-content').addClass('sale')
        }

        $(this).addClass('active')
        $("[data-content='" + contentId + "']").addClass('active');
    });

});