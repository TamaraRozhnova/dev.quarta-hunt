$(document).ready(function () {

    /* open mega menu */
    $('.mega-menu-opener').on('click', function (e) {
        e.preventDefault();

        $('.mega-menu').toggleClass('open');
    });
    $(document).on('click', function (e) {
        let button = $('.mega-menu-opener');
        let container = $('.mega-menu');

        if (
            (!container.is(e.target) && container.has(e.target).length === 0) &&
            (!button.is(e.target) && button.has(e.target).length === 0)
        ) {
            container.removeClass('open')
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
        if (contentId == 'sale') {
            $('#manu-brands-list').hide()
        }

        $(this).addClass('active')
        $("[data-content='" + contentId + "']").addClass('active');
    });

});