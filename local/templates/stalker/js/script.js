window.jsAction = [];
window.ajaxCallback = [];

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
    console.log(data, container, cb);
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
    if (data.STATUS !== 'OK') {
        $obj.prev().find('[data-form-result]').html('<span style="color:red">' + data.MESSAGE + '</span>');
    } else {
        $obj.prev().find('[data-form-result]').html('<span style="color:green">' + data.MESSAGE + '</span>');
        setTimeout(function () {
            window.location.reload();
        }, 2000)
    }
}

$(document).on('click', '[data-add-basket]', function (){
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
    let cb;
    if (typeof ajaxCallback !== "undefined")
        cb = window.ajaxCallback[ajaxCallback];
    else
        cb = function (container) {
        };

    sendAjax(formData, $(this), cb)
});

window.ajaxCallback.afterAddToBasket = function ($obj, data) {
    $('[data-cart-count]').html(data.count);
    $('[data-modal="cart"]').html(data.popupBasket);
    if(typeof data.bigBasket !== "undefined")
    {
        $('.basket__inner').html($('.basket__inner', data.bigBasket).html());
    }
}

$(document).on('change', '[name="delivery"]', function () {
    const _this = $(this);
    let delivery;
    delivery = _this.data('delivery')
    $('[name=DELIVERY_ID]').val(delivery);

    if (_this.is(':checked') && _this.val() === 'delivery')
    {
        $('[data-delivery-id=' + delivery + ']').prop('checked', true);
    } /*else if (_this.is(':checked') && _this.val() === 'self')
    {

    }*/

    window.SubmitFormOrder('N');
});

$(document).on('change', '[data-delivery-id]', function (){
    const delivery=$('[data-delivery-id]:checked').val()
    $('[name=DELIVERY_ID]').val(delivery);
    window.SubmitFormOrder('N');
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
    window.SubmitFormOrder("N");
});

$(document).on('change', '[name="BUYER_STORE"]',function (){
    window.SubmitFormOrder("N");
});

$(document).on('click', '[data-create-order]', function (e){
   e.preventDefault();
    window.SubmitFormOrder("Y");
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
