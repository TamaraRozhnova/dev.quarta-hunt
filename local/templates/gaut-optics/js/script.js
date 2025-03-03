window.jsAction = [];
window.ajaxCallback = [];


/*
    = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    FAVOURITES
    = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
*/
fav_run = function (){
    $.ajax({
        type: 'GET',
        url: '/ajax/fav.php',
        data: {}, // данные для отправки
        success: function (data) { // событие после удачного обращения к серверу и получения ответа
            let r = $.parseJSON(data);
            let arr = r.res||{};
            if(arr && Object.keys(arr).length > 0){
                $('.tip-fav.is-active').removeClass('is-active');
                for (const eid in arr) {
                    $('.tip-fav[data-id='+arr[eid]+']').addClass("is-active");
                }
            }
            console.log(''+Object.keys(arr).length+' favs inited')
        },
    });
}

$(function () {
    fav_run();

    $(document).on("click", ".tip-fav", function (e) {
        var button = $(this),
            ID_val = $(this).attr('data-id');

        this.classList.toggle('is-active');
        $.ajax({
            type: 'GET',
            url: '/ajax/fav.php',
            data: {ID: ID_val, CHECKED: button.hasClass('is-active')},
            success: (data) => { // событие после удачного обращения к серверу и получения ответа
                let r = $.parseJSON(data);
                // console.log('favs: ', r.res);

                // console.log('favs result', data);
                // console.log('favs result', $.parseJSON(data.res));
                // var dataArr = $.parseJSON(data);

                if($(button).parents('.customers-content').length){
                    $(button).parents('.catalog__item').remove()
                }
            },
        });

        // }
    });

[].forEach.call(document.querySelectorAll('img[data-src]'), function(img) {
		img.setAttribute('src', img.getAttribute('data-src'));
		img.onload = function() {
			img.removeAttribute('data-src');
		};
	});

});



/*
    = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    COMPARE
    = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
 */
compare_run = function (){
    $.ajax({
        type: 'GET',
        url: '/ajax/compare.php',
        data: {},
        success: function (data) { // событие после удачного обращения к серверу и получения ответа
            let r = $.parseJSON(data);
            let arr = r.res||{};
            if(arr && Object.keys(arr).length > 0){
                $('.tip-compare.is-active').removeClass('is-active');
                for (const eid in arr) {
                    $('.tip-compare[data-id='+arr[eid]+']').addClass("is-active");
                }

                $(".compare-badge").html(Object.keys(arr).length).show();
            }
            if(!arr || (arr && Object.keys(arr).length < 1)){
                $(".compare-badge").html('').hide();
            }
            console.log(''+Object.keys(arr).length+' compare inited')
        },
    });
}

$(function () {
    compare_run();

    /*
    * BUTTON IN SMALL BASKET
    * */
    $(".js-compare").click(function (e) {
        e.preventDefault()
        let ids = $(this).data("ids").split("|");
        let redirect = $(this).data("redirect");

        $.ajax({
            type: 'GET',
            url: '/ajax/compare.php',
            data: {IDS: [...ids], CHECKED: 'true'}, // данные для отправки
            // dataType: 'json',
            // processData: true,
            success: (data) => { // событие после удачного обращения к серверу и получения ответа
                // console.log(data);
                console.log($.parseJSON(data));
                let dataArr = $.parseJSON(data);
                let arr = dataArr;

                if(!arr || (arr && Object.keys(arr).length < 1)){
                    $(".compare-badge").html('').hide();
                }else{
                    $(".compare-badge").html(Object.keys(arr).length).show();
                }

                window.location.replace("/compare/")
            },
        });

    });


    //tip-compare
    /*
        [catalog.item]

        <a href="#" class="ui-button ui-button--light add2compare tip-compare" data-id="<?=$arItem["ID"]?>">
            <span class="nactive">Сравнить</span>
            <span class="active">Добавлено для сравнения</span>
        </a>
     */
    $(document).on("click", ".tip-compare", function (e) {
        e.preventDefault();

        console.log(".tip-compare");

        var button = $(this),
            ID_val = $(this).attr('data-id');

        this.classList.toggle('is-active');
        $.ajax({
            type: 'GET',
            url: '/ajax/compare.php',
            data: {ID: ID_val, CHECKED: button.hasClass('is-active')},
            success: (data) => {
                let fav = $.parseJSON(data);

                // badge on compare block in header.php
                if(!fav || (fav && Object.keys(fav).length < 1)){
                    $(".compare-badge").html('').hide();
                }else{
                    $(".compare-badge").html(Object.keys(fav).length).show();
                }
            },
        });
    });
});



/*
    = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    BASKET
    = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
 */
$(document).on('click', '[data-add-basket]', function (e){
    const product = $(this).data('add-basket');
    const q = $('[data-q]').length?$('[data-q]').val():1;

    let data = {
        product:product,
        q:q,
        method:'add',
        action:'Basket/updateBasket',
        ajaxCallback:'afterAddToBasket'
    };
    const ajaxCallback = data.ajaxCallback;

    let formData = objectToFormData(data);
    let callback;
    if (typeof ajaxCallback !== "undefined")
        callback = window.ajaxCallback[ajaxCallback];
    else
        callback = function (container) {
        };

    sendAjax(formData, $(this), callback)
});

window.ajaxCallback.afterAddToBasket = function ($obj, data) {
    $('[data-cart-count]').html(data.count);
    $('[data-modal="cart"]').html(data.popupBasket);
    if(typeof data.bigBasket !== "undefined")
    {
        $('.basket__inner').html($('.basket__inner', data.bigBasket).html());
    }


    $obj.html('В корзине').removeClass('ui-button--dark').addClass('ui-button--light');

}

/*
    = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    BASKET RUN
    = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
 */
basket_run = function (){
    $.ajax({
        type: 'GET',
        url: '/ajax/basket.php',
        data: {},
        success: function (data) { // событие после удачного обращения к серверу и получения ответа
            let r = $.parseJSON(data);
            let arr = r.res||{};
            if(arr && Object.keys(arr).length > 0 && $('.catalog__item').length > 0){
                for (const basket_id in arr) {
                    $('button[data-add-basket='+arr[basket_id]+']').html('В корзине').removeClass('ui-button--dark').addClass('ui-button--light');
                }
            }
            console.log(''+Object.keys(arr).length+' basket inited')
        },
    });
}

$(function () {
    basket_run();

    /*
    * BUTTON IN SMALL BASKET
    * */
    $(".js-compare").click(function (e) {
        e.preventDefault()
        let ids = $(this).data("ids").split("|");
        let redirect = $(this).data("redirect");

        $.ajax({
            type: 'GET',
            url: '/ajax/compare.php',
            data: {IDS: [...ids], CHECKED: 'true'}, // данные для отправки
            // dataType: 'json',
            // processData: true,
            success: (data) => { // событие после удачного обращения к серверу и получения ответа
                // console.log(data);
                console.log($.parseJSON(data));
                let dataArr = $.parseJSON(data);
                let arr = dataArr;

                if(!arr || (arr && Object.keys(arr).length < 1)){
                    $(".compare-badge").html('').hide();
                }else{
                    $(".compare-badge").html(Object.keys(arr).length).show();
                }

                window.location.replace("/compare/")
            },
        });
    });
});


/*
    = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    SEARCH
    = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
*/

$(function () {

    /*
    $(".gotosearch").click(function () {
        var topPos = $("footer").offset().top;
        // $("document").scrollTop(topPos, {600});
        console.log(topPos);

        $("html, body").animate({scrollTop:topPos}, 1000, 'swing', function() {
            $(".ajaxsearch__input").focus();
        });
    });


    // Мигание _
    setInterval(function () {
        let tit = $(".f__search .ajaxsearch__input").attr("placeholder");
        let pos = tit.search('_');
        if(pos > 0){
            tit = tit.substring(0, pos)
        }else{
            tit = tit+'_'
        }

        $(".f__search .ajaxsearch__input").attr("placeholder", tit);
    },500);
    */

    $(".ajaxsearch__input").keyup(function (e) {
        console.log("ajaxsearch__input", $(this).val(), $(this).val().length);
        var q = $(this).val();
        if(q.length > 2){
            // $("#"+$(this).parents(".ajaxsearch__wrapper").prop("id")).find(".ajaxsearch__suggest").remove();
            $.ajax({
                method: "GET",
                url: "/search/ajax/",
                data: { q: q, ajax: true, ajaxid: $(this).parents(".ajaxsearch__wrapper").prop("id")}
            })
                .done(function( data ) {
                    // console.log("ajaxsearch__input data", data, data.items, data.items.length);
                    // console.log("ajaxsearch__input data.items", data.items);
                    // console.log("ajaxsearch__input data.items", Object.keys(data.items).length);

                    if(data.items && Object.keys(data.items).length > 0){
                        var sugg = false;
                        if($("#"+data.ajaxid).find(".ajaxsearch__suggest").length < 1){
                            $("#"+data.ajaxid).append('<div class="ajaxsearch__suggest_wrapper"><div class="ajaxsearch__suggest"></div></div>');
                        }
                        sugg = $("#"+data.ajaxid).find(".ajaxsearch__suggest");

                        $("#"+data.ajaxid).find(".ajaxsearch__suggest > div").each(function () {
                            $(this).remove();
                        });

                        $.each(data.items, function(index, value) {
                            console.log(value);
                            var art = "";
                            if(value.CML2_ARTICLE.length > 0){
                                art = '<span class="ajaxsearch__art">Арт: '+value.CML2_ARTICLE+'</span>';
                            }
                            $("#"+data.ajaxid).find(".ajaxsearch__suggest").append('<div id="index'+index+'"><a href="/catalog/?q='+value.NAME+'" class="ajaxsearch__title" data-title="'+value.NAME+'">'+value.NAME+art+'</a>'+'</div>');
                        });

                        if(data.items.length > 9){
                            sugg.append('<div class="ajaxsearch__more"><sub>...найдено более 10, уточните запрос</sub></div>');
                        }

                        ajaxsearch__suggest_wrapper();

                    }

                    // console.log("res", data);
                });
        }else{
            $("#"+$(this).parents(".ajaxsearch__wrapper").prop("id")).find(".ajaxsearch__suggest_wrapper").remove();
        }
    });

    $(document).on( 'click', '.nav-search.modal-another.is-active .form-close', function (e) {
        console.log('form-close click', $(e.currentTarget), $(e.currentTarget).parents('[data-modal]').find(".ajaxsearch__wrapper").prop("id"));

        $("#"+$(e.currentTarget).parents('[data-modal]').find(".ajaxsearch__wrapper").prop("id")).find(".ajaxsearch__suggest_wrapper").remove();

        // $(e.currentTarget).parents('[data-modal]');
    });


    // $(document).on("click", ".ajaxsearch__title", function (e) {
    //     e.preventDefault();
    //     var sugg = $(this).parents(".ajaxsearch__suggest_wrapper");
    //
    //     var tit = $(this).data("title");
    //     var inp = $(this).parents(".ajaxsearch__wrapper").find(".ajaxsearch__input").val(tit);
    //
    //     var frm = $(this).parents("form");
    //
    //     sugg.remove();
    //     frm.find('[type="submit"]').trigger("click");
    // });

    $('.menu__wrapper .close__search').click(function (e) {
        $(this).parents('.menu__wrapper').find('.subblock').toggleClass('active');
        if($(this).parents('.search').length){

        }else{
            var elem = $(".ajaxsearch__input")[0];
            var caretPos = 0;

            if(elem != null) {
                if(elem.createTextRange) {
                    var range = elem.createTextRange();
                    range.move('character', caretPos);
                    range.select();
                }
                else {
                    if(elem.selectionStart) {
                        elem.focus();
                        elem.setSelectionRange(caretPos, caretPos);
                    }
                    else
                        elem.focus();
                }
            }
        }
    })
});

ajaxsearch__suggest_wrapper = function () {
    if($('.ajaxsearch__suggest_wrapper').length && $('.ajaxsearch__suggest_wrapper:visible').length && $(window).width() > 743){
        let left = $(".header__navigation").position().left;
        let width = $(".header__navigation").outerWidth();
        $(".ajaxsearch__suggest_wrapper").css('left', left);
        $(".ajaxsearch__suggest_wrapper").css('width', width);
    }
}

$(window).resize(ajaxsearch__suggest_wrapper)



$('.stars-block:not(.clicked)').mousemove(function(event) {
    let left = event.pageX - $(this).offset().left;
    let top = event.pageY - $(this).offset().top;
    // $('#gas-electric-hover').css({top: top,left: left}).show();

    // console.log('(.stars-block).mousemove', {top: top,left: left});

    let proc = Math.floor(left * 100 / $(this).innerWidth());
    let part = Math.floor((proc/20)+1);
    if(part > 5){
        part = 5;
    }
    // console.log('(.stars-block).mousemove', proc, 'stars-'+part );

    $(this).find(".stars").removeClass().addClass('stars stars-'+part );
    $(this).parents('[data-stars-parent]').find('[data-stars-count]').html(part);

    // $(this).addClass('clicked');


    //console.log (left, top);
    //console.log (left, top);
});

$('.stars-block').mouseleave(function(event) {
    let part = $(this).find("[name=stars]").val();

    console.log('name=stars', part);

    if(part > 0){
        $(this).find(".stars").removeClass().addClass('stars stars-'+part );
        $(this).parents('[data-stars-parent]').find('[data-stars-count]').html(part);
    }else{
        $(this).find(".stars").removeClass().addClass('stars stars-0' );
        $(this).parents('[data-stars-parent]').find('[data-stars-count]').html('-');
    }
});

$('.stars-block').click(function(event) {
    let left = event.pageX - $(this).offset().left;
    let top = event.pageY - $(this).offset().top;
    let proc = Math.floor(left * 100 / $(this).innerWidth());
    let part = Math.floor((proc/20)+1);
    if(part > 5){
        part = 5;
    }

    $(this).find("[name=stars]").val(part);

    $(this).find(".stars").removeClass().addClass('stars stars-'+part );
    $(this).parents('[data-stars-parent]').find('[data-stars-count]').html(part);

    // $(this).addClass('clicked');

    console.log('name=stars', $(this).find("[name=stars]").val() );

    //console.log (left, top);
    //console.log (left, top);
});



$(document).on("submit", "[data-ajax-form]", function (e) {
    e.preventDefault();
    const _this = $(this);
    const ajaxCallback = _this.find('[name="afterCallback"]').val();

    if (0 === validateForm(_this)) return false;
    var formData = new FormData(_this[0]);

    var cb;
    if (typeof ajaxCallback !== "undefined")
        cb = window.ajaxCallback[ajaxCallback];
    else
        cb = function (container) {
        };
    window.sendAjax(formData, _this, cb);
});

function validateForm(form) {
    $('[data-reg-errors]').html();
    $(form).find(".error").removeClass("error");
    var send = 1;
    $(form).find("[data-required]").each(function () {
        if ($(this).val() === "") {
            $(this).parent().addClass("error");
            send = 0;
        }
    });

    return send;
}

$(document).on('focus', '.error input', function () {
    $(this).parent().removeClass('error');
});

var sendAjax = window.sendAjax = function (data, container, cb) {
    // console.log(data, container, cb);
    $.ajax({
        type: "POST", url: "/local/ajax/",
        data: data, dataType: "json",
        cache: false, contentType: false, processData: false,
        success: function (data) {
            if (typeof cb === 'function')
                cb(container, data);
        }
    });
};

objectToFormData = function (data){
    let formData = new FormData();
    $.each(data, function (index, value)
    {
        formData.append(index, value);
    });

    return formData;
};
window.ajaxCallback.afterRegister = function ($obj, data) {
    if (data.STATUS !== 'OK') {
        $obj.find('[data-form-result]').html('<span style="color:red">' + data.MESSAGE + '</span>');
    } else {

        $obj.find('[data-form-result]').html('<span style="color:green">' + data.MESSAGE + '</span>');
        setTimeout(function () {
            window.location.reload();
        }, 2000)
    }
}

window.ajaxCallback.afterLogin = function ($obj, data) {
    if (data.STATUS !== 'OK') {
        $obj.find('[data-form-result]').html('<span style="color:red">' + data.MESSAGE + '</span>');
    } else {
        $obj.find('[data-form-result]').html('<span style="color:green">' + data.MESSAGE + '</span>');
        setTimeout(function () {
            window.location.reload();
        }, 2000)
    }
}

$(document).on('click', '[data-promo-apply]', function () {
    promoApply($(this));
});

function promoApply($this) {
    let data = {
        coupon: $('[data-promo-input]').val(),
        action: 'Basket/applyCoupon',
        extra:'getBigBasket',
    };

    let formData = objectToFormData(data);

    window.sendAjax(formData, $this, window.ajaxCallback.afterAddToBasket);
}

window.ajaxCallback.afterCouponApply = function ($obj, data) {
    if (data.DISCOUNT === 'OK') {
        $('[data-total-eur]').html(data.PRICES.EUR);
        $('[data-total-rub]').html(data.PRICES.RUB);
    }

}

window.ajaxCallback.afterSubmitReview = function ($obj, data) {
    console.log('afterSubmitReview', [$obj, data])
    console.log('afterSubmitReview', $obj.prev().find('[data-form-result]'))

    if (data.STATUS !== 'OK') {
        $obj.parent().find('[data-form-result]').html('<span style="color:red">' + data.MESSAGE + '</span>').show();
    } else {
        $obj.parent().find('[data-form-result]').html('<span style="color:green">' + data.MESSAGE + '</span>').show();
        $obj.hide();
        // setTimeout(function () {
        //     window.location.reload();
        // }, 2000)
    }
}


// $(document).on('change', '[name="delivery"]', function () {
//     const _this = $(this);
//     let delivery;
//     delivery = _this.data('delivery')
//     $('[name=DELIVERY_ID]').val(delivery);
//
//     if (_this.is(':checked') && _this.val() === 'delivery')
//     {
//         $('[data-delivery-id=' + delivery + ']').prop('checked', true);
//     } /*else if (_this.is(':checked') && _this.val() === 'self')
//     {
//
//     }*/
//
//     // window.SubmitFormOrder('N');
// });

$(document).on('change', '[name="delivery"]', function () {
    const _this = $(this);
    let delivery;

    console.log('delivery', _this.data('delivery'));

    // $("#ID_DELIVERY_ID_"+delivery).parents("label").click();

    delivery = _this.data('delivery')

    console.log('delivery && delivery > 0', (delivery && delivery > 0), delivery)

    if(delivery && delivery > 0){
        // $('[name=DELIVERY_ID]').val(delivery);
        setTimeout(function () {
            console.log('#ID_DELIVERY_ID_', '#ID_DELIVERY_ID_'+delivery);
            $('#ID_DELIVERY_ID_'+delivery).parents("label").click();
        }, 200);
    }else{
        setTimeout(function () {
            $('.checkout__choose-delivery .checkout__label:first-child input').parents("label").click();
        }, 200);
    }

    if (_this.is(':checked') && _this.val() === 'delivery')
    {
        $('[data-delivery-id=' + delivery + ']').prop('checked', true);
    } /*else if (_this.is(':checked') && _this.val() === 'self')
    {

    }*/

    // window.SubmitFormOrder('N');
});

$(document).on('change', '[data-delivery-id]', function (){
    const delivery=$('[data-delivery-id]:checked').val()
    $('[name=DELIVERY_ID]').val(delivery);
    // window.SubmitFormOrder('N');
});

window.SubmitFormOrder = function (flag)
{
    let form = $('#ORDER_FORM'),
        send = 1,
        confirmorder = $('input[name=confirmorder]', form),
        json = $('input[name=json]', form);

    if (flag === 'Y')
    {

        confirmorder.val('Y');
        json.val('Y');
    }

    if (send === 1)
        form.submit();

    return false;
};

//forms ajax
$(document).on('submit', 'form#ORDER_FORM', function (e)
{
    e.preventDefault();
    let obj = $(this);
    let id = obj.attr('id');
    let data_params = obj.serialize();

    let url = this.action;
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'html',
        data: data_params,
        success: function (data)
        {
            let redirect = false;
            try
            {
                let data1 = JSON.parse(data);
                if (data1.success)
                {
                    window.location.href = data1.redirect;
                    redirect = true;
                }
            } catch (e)
            {
            }

            if (!redirect && id.length > 0)
            {
                $('form#' + id).html(data);
                window.initTabs();
                if($('.errortext').length)
                {
                    $('html, body').animate({
                        scrollTop: $(".errortext:first-child").offset().top
                    }, 1000);
                }
            }
        }
    });
    return false;
});

$(document).on("change", "[name=PAY_SYSTEM_ID]", function (){
    // window.SubmitFormOrder("N");
});

$(document).on('change', '[name="BUYER_STORE"]',function (){
    // window.SubmitFormOrder("N");
});

$(document).on('click', '[data-create-order]', function (e){
   e.preventDefault();
    // window.SubmitFormOrder("Y");
});

$(document).on('input', '[data-basket_item]', function (){
    clearTimeout(window.changeQ);
    const _this = $(this);
    const product =_this.data('basket_item');
    const q = _this.val();
    window.changeQ = setTimeout(function (){
        let data = {
            product:product,
            q:q,
            method:'update',
            extra:'getBigBasket',
            action:'Basket/updateBasket',
            ajaxCallback:'afterAddToBasket'
        };
        const ajaxCallback = data.ajaxCallback;

        let formData = objectToFormData(data);
        let cb;
        if (typeof ajaxCallback !== "undefined")
            cb = window.ajaxCallback[ajaxCallback];
        else
            cb = function (container) {
            };

        sendAjax(formData,_this, cb)
    }, 1000);
    return false;
});

$(document).on('click', '[data-delete-basket]', function (){
    const _this = $(this);
    let data = {
        id: _this.data('delete-basket'),
        extra:'getBigBasket',
        action:'Basket/deleteProduct',
        ajaxCallback:'afterAddToBasket'
    };
    const ajaxCallback = data.ajaxCallback;

    let formData = objectToFormData(data);
    let cb;
    if (typeof ajaxCallback !== "undefined")
        cb = window.ajaxCallback[ajaxCallback];
    else
        cb = function (container) {
        };

    sendAjax(formData,_this, cb)
});

window.ajaxCallback.afterFeedback = function ($obj, data) {
    if (data.STATUS !== 'OK') {
        $obj.find('[data-form-result]').html('<span style="color:red">' + data.MESSAGE + '</span>');
    } else {
        $obj.find(':not([data-form-result])').hide();
        $obj.find('[data-form-result]').html('<span style="color:green">' + data.MESSAGE + '</span>');
        setTimeout(function () {
            window.location.reload();
        }, 2000)
    }
}

scrollmenu = function () {
    // console.log("scrollmenu");

    if($("#bx-panel").height() > 0 && $("#bx-panel").height()-$(window).scrollTop()>0){
        $('.header').css('top', $("#bx-panel").height()-$(window).scrollTop());
    }else{
        $('.header').css('top', 0);
    }

    $('body > div.page').css('padding-top', $('.header').height());

    return true;
}

fixmodals = function (e) {
    // console.log('fixmodals');


    if($(".modal.js-modal-fixed").length > 0){
        $(".modal.js-modal-fixed").css('top', '');
        $(".modal.js-modal-fixed").css('height', '');

        if($(".modal.js-modal-fixed").find('[data-modal-inner="profile"]').length){
            $(".modal.js-modal-fixed").find('[data-modal-inner="profile"]').css('marginTop', '');
        }

        $(".modal").removeClass('js-modal-fixed');
    }

    if($(".modal.is-active").length > 0){
        $(".modal.is-active").each(function(i){
            if($(this).css("position") === "fixed"){
                // console.log($(this).css("position"));
                if($(this).css("top") === "0px"){
                    // console.log($(this).css("top"));
                    let panel = 0;
                    if($("#bx-panel").length && $("#bx-panel:visible").length){
                        panel += $("#bx-panel").height();
                    }
                    let header = 0;
                    if($("header.header").length && $("header.header:visible").length){
                        header += $("header.header").height();
                    }

                    console.log(panel, panel-$(window).scrollTop(), header)

                    if($(window).width() > 743){
                        if(panel > 0 && panel-$(window).scrollTop()>0){
                            $(this).css('top', panel+header-$(window).scrollTop());
                            $(this).css('height', 'calc(100% - '+(panel+header-$(window).scrollTop())+'px)');
                            $(this).addClass('js-modal-fixed');
                        }else{
                            $(this).css('top', header);
                            $(this).css('height', 'calc(100% - '+(header)+'px)');
                            $(this).addClass('js-modal-fixed');
                        }
                    }else{
                        if(panel > 0 && panel-$(window).scrollTop()>0){

                            // console.log(panel,header,$(".header__catalog").height(),$(window).scrollTop());
                            // console.log((panel+header+$(".header__catalog").height()-$(window).scrollTop()));

                            $(this).css('top', panel+header-$(window).scrollTop());
                            $(this).css('height', 'calc(100% - '+(panel+header+$(".header__catalog").height()-$(window).scrollTop())+'px)');
                            $(this).addClass('js-modal-fixed');
                        }else{
                            console.log('header', header)
                            console.log('calc', (header+$(".header__catalog").height()))


                            $(this).css('top', header);
                            $(this).css('height', 'calc(100% - '+(header+$(".header__catalog").height())+'px)');
                            $(this).addClass('js-modal-fixed');
                        }

                    }

                }
            }

            if($(window).width() > 743){


            }else{
                if($(this).find('[data-modal-inner="profile"]').length){
                    $(this).find('[data-modal-inner="profile"]').css('marginTop', '50px');
                }
            }
        })
    }

}

fixmodalsclose = function (e) {
    // console.log('fixmodalsclose', e);

    // if($(".modal.js-modal-fixed").length > 0){
    //     $(".modal.js-modal-fixed").css('top', '');
    //     $(".modal.js-modal-fixed").css('height', '');
    //
    //     if($(".modal.js-modal-fixed").find('[data-modal-inner="profile"]').length){
    //         $(".modal.js-modal-fixed").find('[data-modal-inner="profile"]').css('marginTop', '');
    //     }
    //
    //     $(".modal").removeClass('js-modal-fixed');
    // }

}

orderTotalFixer = function (e) {
    let upperGap = 0;

    if($(".bx-soa-cart-total-wrapper.bx-soa-cart-total-fixed").length){
        upperGap = $("header.header").height()+parseInt($("header.header").css("top"))+30;
        $(".bx-soa-cart-total-wrapper.bx-soa-cart-total-fixed").css("top", upperGap);
    }

    // console.log("orderTotalFixer", $(".bx-soa-cart-total-fixed").length, upperGap, $(".bx-soa-cart-total.bx-soa-cart-total-fixed").css("top"))
}


$(window).scroll(scrollmenu);
$(window).scroll(orderTotalFixer);
$(document).on("modal-open", fixmodals);
$(document).on("modal-close", fixmodalsclose);


$(function () {
    scrollmenu();

    $(document).on("click", ".jslink", function (e) {
        e.preventDefault();
        let link = $(this).data("href");

        let a= document.createElement('a');
        a.target= $(this).attr("target") || '_self';
        a.href= link;
        a.click();
    });

});

$.fn.inputFilter = function(callback, errMsg) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function(e) {
        if (callback(this.value)) {
            // Accepted value
            if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
                $(this).removeClass("input-error");
                this.setCustomValidity("");
            }
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
            // Rejected value - restore the previous one
            $(this).addClass("input-error");
            this.setCustomValidity(errMsg);
            this.reportValidity();
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
            // Rejected value - nothing to restore
            this.value = "";
        }
    });
};




