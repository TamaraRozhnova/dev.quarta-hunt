$(document).ready(function () {

    /* jq menu hover*/
    $('.menu-list li').on('mouseover', function (e) {
        let contentId = $(this).data('id');

        $('.menu-list li').each((index, el) => {
            $(el).removeClass('active');
        })
        $('.menu-content-data').each((index, el) => {
            $(el).removeClass('active');
        })

        $(this).addClass('active')
        $("[data-content='" + contentId + "']").addClass('active');
    });

});