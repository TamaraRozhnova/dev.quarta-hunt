let optionsRegistrationFormSpec = {
    errorElement: "em",
    errorPlacement: function errorPlacement(error, element) {
        error.appendTo(element.parent('label'));
    },
    rules: {
        "REGISTER[NAME]": {
            required: true,
            nameValidate: true
        },
        "REGISTER[LAST_NAME]": {
            required: true,
            nameValidate: true
        },
        "REGISTER[COMPANY]": {
            required: false,
        },
        "REGISTER[PHONE]": {
            required: true,
        },
        "REGISTER[EMAIL]": {
            required: true,
            emailValidate: true
        },
        "SPEC[CITY]": {
            required: true,
        },
        "SPEC[SERVICES][]": {
            required: true,
        },
        "REGISTER[PASSWORD]": {
            required: true,
            passwordValidate: true
        },
        "REGISTER[CONFIRM_PASSWORD]": {
            required: true,
            equalToPassword: { element: '#reg_spec_form .passwordOne'}
        },
        "SPEC[VK]": {
            // required: false,
            vkValidate: true
        },
        agree: {
            required: true
        }
    },
    messages: {
        "REGISTER[NAME]": {
            required: '',
            // nameValidate: ''
        },
        "REGISTER[LAST_NAME]": {
            required: '',
            // nameValidate: ''
        },
        "REGISTER[PHONE]": {
            required: '',
        },
        "REGISTER[EMAIL]": {
            required: '',
            emailValidate: 'Формат ввода email@mail.ru'
        },
        "REGISTER[PASSWORD]": {
            required: '',
            // passwordValidate: ''
        },
        "REGISTER[CONFIRM_PASSWORD]": {
            required: '',
            equalTo: 'Пожалуйста, введите то же значение еще раз.',
        },
        "SPEC[CITY]": {
            required: 'Нужно выбрать город',
        },
        "SPEC[SERVICES][]": {
            required: 'Нужно выбрать вид деятельности',
        },
        "SPEC[VK]": {
            // required: '',
            // vkValidate: ''
        },
        agree: {
            required: ''
        }
    },
    submitHandler: function submitHandler(form) {
        let $form = $(form);
        let login = $form.find("input[name='REGISTER[EMAIL]']").val()
        let g = $form.find("input[name=GROUP_CODE]").val();
        // $form.find("[name='REGISTER[LOGIN]']").val(login + '_' + g);
        $form.find("[name='REGISTER[LOGIN]']").val(login);

        let formData = new FormData(form);
        let authFormError = $form.find('.auth-form-error');
        let htmlRes = '';

        $.ajax($form.attr('action'), {
            type: $form.attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            // dataType: 'JSON',
            beforeSend: function (data) {
                htmlRes = '';
                authFormError.html(htmlRes);
            },
            success: function (data) {
                // console.log(data);

                let capt = $(form).find("input[name=captcha_sid]");
                if (capt) {
                    if (capt.val() !== data.arResult.CAPTCHA_CODE) {
                        capt.val(data.arResult.CAPTCHA_CODE);
                        capt.parents(".image").find("img").attr("src", "/bitrix/tools/captcha.php?captcha_sid=" + data.arResult.CAPTCHA_CODE);
                    }
                }

                if (data.STATUS == 'OK') {
                    $('.reg-form__form-hide').hide();
                    $('.reg-form__form-success').show();
                    ym(88116146,'reachGoal','reg_spec');
                    // location.href = '/account/';
                } else if (data.STATUS == 'ERROR' && data.MESSAGES.length > 0) {
                    for (let i = 0; data.MESSAGES.length > i; i++) {
                        htmlRes += `<p>${data.MESSAGES[i]}</p>`;
                    }
                } else {
                    htmlRes += `<p>Неизвестная ошибка. Обратитесь на горячую линию!</p>`;
                }

                authFormError.html(htmlRes);
            },
            error: function (data) {
                htmlRes += `<p>Неизвестная ошибка. Обратитесь на горячую линию!</p>`;
                authFormError.html(htmlRes);
            }
        });

        return false;
    }
};

$(function () {
    $.validator.addMethod("vkValidate", function (value, element) {


        return /https?:\/\/(www\.)?vk\.com\/[a-z0-9_\.-]{2,50}$|^$/.test(value);
    }, "Формат ввода https://vk.com/account");


    $('#reg_spec_form').bind('keyup blur click touchstart', function () {
        if ($('#reg_spec_form').validate(optionsRegistrationFormSpec).checkForm()) {
            //$('#authorization').removeClass('is-open');
        } else {
            // $('#person_submit').addClass('button_disabled').attr('disabled', true);
        }
    });
});