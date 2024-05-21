$(document).ready(function() {

	/** Validation fields for recovery data */
	const phoneForgot = new Input({
		wrapperSelector: '.fo-phone-recovery',
		required: true,
		validMask: /^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/,
		mask: '+7 (###) ###-##-##',
		errorMessage: 'Телефон должен быть в указанном формате'
	});

	const emailForgot = new Input({
		wrapperSelector: '.fo-email-recovery',
		required: true,
		validMask: /^([a-z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/,
		errorMessage: 'Введите email в корректном формате'
	});

    if ( document.getElementById("phone") ) {
    	BX.ready(function() {
            var result = new BX.MaskedInput({
                mask: '+7 (999) 999-99-99', // устанавливаем маску
                input: BX('phone'),
                placeholder: '_' // символ замены +7 ___ ___ __ __
            });
        });
    }
    $('.forgot_email_form').on('click', function(){
    	$("#form_forgot_phone").hide();
    	$("#form_forgot").show();
		$(this).addClass('active');
		$('.forgot_phone_form').removeClass('active');
    });

    $('.forgot_phone_form').on('click', function(){
    	$("#form_forgot").hide();
    	$("#form_forgot_phone").show();
		$(this).addClass('active');
		$('.forgot_email_form').removeClass('active');
    });

	$('.recovery__btn').on('click', (e) => {
		if (!emailForgot.isValidValue()) {
			e.preventDefault();
			emailForgot.setError()
		}
	})
    
    $('.recovery_btn_phone').on('click', function(e){
    	e.preventDefault();

		if (!phoneForgot.isValidValue()) {
			phoneForgot.setError()
		} else {
    		authPhone();
			$(this).addClass('code');
		}

    });
    
    $('.recovery_btn_phone.code').on('click', function(e){
    	e.preventDefault();
    	authPhone();
    });
});

function authPhone(){
	BX.ajax({
        method: 'POST',
		data: {
			userPhone: $('input[name="USER_PHONE"]').val(),
			userCode: $('input[name="CODE"]').val()
		},
        url: '/local/templates/quarta_new/components/bitrix/system.auth.forgotpasswd/flat/ajax.php',
		dataType: 'json',
		onsuccess: function(data){
			if(data.error == false){
				$('.bx-authform-formgroup-container.code').show();
				$('.bx-authform-formgroup-container.phone').hide();
				$('.bx-forgot .type').hide();

				if(data.user){
					setTimeout(function(){
						window.location.href = "/cabinet";
					}, 300);
				}
			}else{
				$('.error_message').text(data.message);
			}
		}
    });
}