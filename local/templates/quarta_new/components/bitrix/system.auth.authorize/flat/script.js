$( document ).ready(function() {
    if ( document.getElementById("phone") ) {
    	BX.ready(function() {
            var result = new BX.MaskedInput({
                mask: '+7 (999) 999-99-99', // устанавливаем маску
                input: BX('phone'),
                placeholder: '_' // символ замены +7 ___ ___ __ __
            });
        });
    }
    $('.auth_email_form').on('click', function(){
    	$("#form_auth_phone").hide();
    	$(".auth_email_form").hide();
    	$("#form_auth").show();
    	$(".foggot_pass").show();
    	$(".auth_phone_form").show();
    });
    $('.auth_phone_form').on('click', function(){
    	$("#form_auth_phone").show();
    	$(".auth_email_form").show();
    	$("#form_auth").hide();
    	$(".foggot_pass").hide();
    	$(".auth_phone_form").hide();
    });
    
    $('.form_auth_phone').on('click', function(e){
    	e.preventDefault();
    	console.log($('#phone').val().length);
    	if($('#phone').val() == '' || $('#phone').val().length < 18){
    		$('.error_message').text('Введите номер телефона');
    	}else{
    		authPhone();
    	}
    
    });
    
    $('.more_code_phone').on('click', function(e){
    	e.preventDefault();
    	authPhone();
    });
    
    $('.login_auth_phone').on('click', function(e){
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
        url: '/local/templates/quarta_new/components/bitrix/system.auth.authorize/flat/ajax.php',
		dataType: 'json',
		onsuccess: function(data){
			if(data.error == false){
				$('.bx-authform-formgroup-container.code').show();
				$('.bx-authform-formgroup-container.phone').hide();
				$('.form_auth_phone').hide();
				$('.login_auth_phone').show();
				$('.more_code_phone').show();

				if(data.user){
					window.location.reload();
				}
			}else{
				$('.error_message').text(data.message);
			}
		}
    });
}