$(document).ready(function () {

    /* open mega menu  desctop*/
    $('.mega-menu-opener').on('click', function (e) {
        e.preventDefault();


        $('.mega-menu').css('top', 175)
        $('.mega-menu').css('height', window.innerHeight - 397)
        if (window.scrollY > 50) {
            $('.mega-menu').css('top', 135)
            $('.mega-menu').css('height', window.innerHeight - 397)
        }

        $('.mega-menu').toggleClass('open');
        $(this).toggleClass('open');

        window.addEventListener("wheel", preventScroll, { passive: false });
    });
    $(document).on('click', function (e) {
        let button = $('.mega-menu-opener');
        let container = $('.mega-menu');

        if ((!container.is(e.target) && container.has(e.target).length === 0) && (!button.is(e.target) && button.has(e.target).length === 0)) {
            container.removeClass('open');
            button.removeClass('open');

            allowScroll();
        }
    });

    function allowScroll() {
        window.removeEventListener("wheel", preventScroll);
    }

    function preventScroll(e) {
        e.preventDefault();
    }

    const brandList = document.querySelector('.mega-menu #manu-brands-list')

    /* jq menu hover, click both menu*/
    $('.mega-menu .menu-list li').on('mouseover', function (e) {
        let contentId = $(this).data('id');

        $('.mega-menu .menu-list li').each((index, el) => {
            $(el).removeClass('active');
        })
        $('.mega-menu .menu-content-data').each((index, el) => {
            $(el).removeClass('active');
        })

        $('.mega-menu #manu-brands-list').show()
        $('.mega-menu .menu-content').removeClass('sale')
        if (contentId == 'sale') {
            $('.mega-menu #manu-brands-list').hide()
            $('.mega-menu .menu-content').addClass('sale')
        }

        brandList.innerHTML = '';

        $.each(arSectionsBrandsMenu, (iSection, iBrand) => {

            $.each(iBrand, (iBrandID, iBrandAr) => {

                if (iSection == contentId) {
                    const brand = document.createElement('span')
                    const brandImg = document.createElement('img')
            
                    brandImg.setAttribute('src', iBrandAr?.IMAGE)
                    brandImg.setAttribute('alt', iBrandAr?.NAME)
                    brand.appendChild(brandImg)
        
                    brandList.appendChild(brand)
                }

            })

        })  

        $(this).addClass('active')
        $(".mega-menu [data-content='" + contentId + "']").addClass('active');
    });

    $('body').on('wheel',function(e){
        e.preventDefault();
    });
});