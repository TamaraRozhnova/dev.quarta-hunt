$( document ).ready(function() {
    
    if ($("#phone").length != 0) {
        $("#phone").inputmask({ mask: "+7 (999) 999-99-99" });
        $("#phone").val("");
    }
    let phoneForm = document.querySelector(".bx-auth-profile");

    if (phoneForm) {
        const phonePersonal = new Input({
            wrapperSelector: `.input__container.phone`,
            required: true,
            validMask: /^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/,
            mask: "+7 (###) ###-##-##",
            errorMessage: "Телефон должен быть в указанном формате",
        });

        const emailPersonal = new Input({
            wrapperSelector: `.input__container.email`,
            required: true,
            validMask: /^([a-z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/,
            errorMessage: "Введите email в корректном формате",
        });
    
        const lastNamePersonal = new Input({
            wrapperSelector: `.input__container.name`,
            required: true,
            errorMessage: "Поле обязательно к заполнению",
        });
    
        const lastLastPersonal = new Input({
            wrapperSelector: `.input__container.last`,
            required: true,
            errorMessage: "Поле обязательно к заполнению",
        });
    
        const lastSecondPersonal = new Input({
            wrapperSelector: `.input__container.second`,
            required: true,
            errorMessage: "Поле обязательно к заполнению",
        });
    
        const PersonalReqFields = [
            phonePersonal,
            lastNamePersonal,
            emailPersonal,
            lastLastPersonal,
            lastSecondPersonal,
        ];
    
        $(".personal-submit-form").on("click", (e) => {
            PersonalReqFields.forEach((field) => {
                if (!field.isValidValue()) {
                    field.setError();
                    e.preventDefault();
                }
            });
        });

        $(document).on('click', '.change-close', function () {
            let changeWrap = $('.change-success');
            changeWrap.css('display', 'none');
        });

        setTimeout(function() { 
            $('.change-success').css('display', 'none');
        }, 3000);
    }
});

/*
function removeAllHint(node) {
    $(node).closest('.profile-block-shown').find('.main-profile__hint').remove();
}

function createHint(node, title) {
    let hintNode = '<span class="main-profile__hint">' + title + '</span>';
    if (node.prop('tagName') == 'INPUT') {
        node.after(hintNode);
    } else {
        node.append(hintNode);
    }
}

function removeElement(arr, sElement)
{
	var tmp = new Array();
	for (var i = 0; i<arr.length; i++) if (arr[i] != sElement) tmp[tmp.length] = arr[i];
	arr=null;
	arr=new Array();
	for (var i = 0; i<tmp.length; i++) arr[i] = tmp[i];
	tmp = null;
	return arr;
}

function SectionClick(id)
{
	var div = document.getElementById('user_div_'+id);
	if (div.className == "profile-block-hidden")
	{
		opened_sections[opened_sections.length]=id;
	}
	else
	{
		opened_sections = removeElement(opened_sections, id);
	}

	document.cookie = cookie_prefix + "_user_profile_open=" + opened_sections.join(",") + "; expires=Thu, 31 Dec 2020 23:59:59 GMT; path=/;";
	div.className = div.className == 'profile-block-hidden' ? 'profile-block-shown' : 'profile-block-hidden';
}


/*if (document.getElementById("phone") ) {
    BX.ready(function() {
        var result = new BX.MaskedInput({
            mask: '+7 (999) 999-99-99', // устанавливаем маску
            input: BX('phone'),
            placeholder: '_' // символ замены +7 ___ ___ __ __
        });
    });
}
$(document).on('blur', '#phone', function () {
    let th = $(this);
    let thWrapper = th.closest('.input');
    let phoneLength = th.val().replace(/[^0-9]/g,"");
    
    removeAllHint(thWrapper);

    if(phoneLength.length < 11 ){
        createHint(thWrapper, 'Телефон должен быть в указанном формате');
        $('.btn-primary[name="save"]').prop("disabled", true);
    }else{
        $('.btn-primary[name="save"]').prop("disabled", false);
    }
});
$(document).on('blur', '.form-control[name="EMAIL"]', function () {
    let th = $(this);
    let thWrapper = th.closest('.input');
    let pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;

    if(th.val() != ''){
        if(th.val().search(pattern) == 0){
            $('.btn-primary[name="save"]').prop("disabled", false);
        }else{
            createHint(thWrapper, 'Неверный формат e-mail');
            $('.btn-primary[name="save"]').prop("disabled", true);
        }
    }else{
        createHint(thWrapper, 'Поле e-mail не должно быть пустым!');
        $('.btn-primary[name="save"]').prop("disabled", true);
    }
});
$(document).on('blur', '.form-control[name="NAME"]', function () {
    let th = $(this);
    let thWrapper = th.closest('.input');

    th.each(function(){
        if (th.val().length == 0) {
            createHint(thWrapper, 'Поле обязательно к заполнению');
            $('.btn-primary[name="save"]').prop("disabled", true);
        }else{
            $('.btn-primary[name="save"]').prop("disabled", false);
        }
    }); 
});
$(document).on('blur', '.form-control[name="LAST_NAME"]', function () {
    let th = $(this);
    let thWrapper = th.closest('.input');

    th.each(function(){
        if (th.val().length == 0) {
            createHint(thWrapper, 'Поле обязательно к заполнению');
            $('.btn-primary[name="save"]').prop("disabled", true);
        }else{
            $('.btn-primary[name="save"]').prop("disabled", false);
        }
    }); 
});*/