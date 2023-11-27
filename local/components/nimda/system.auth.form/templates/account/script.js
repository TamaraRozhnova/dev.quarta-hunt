$(function () {
	// $(".js_account_radio").change(function (e){
	//     $(".js_account_input").val($(this).data("account"));
	//     $(".js_gcode_input").val($(this).data("substr"));
	//
	//
	//     // console.log($(".js_account_input").data("substr"));
	// });

	/*let optionsForgetPassForm = {
		errorElement: "em",
		errorPlacement: function errorPlacement(error, element) {
			error.appendTo(element.parent('label'));
		},
		rules: {
			USER_EMAIL: {
				required: true,
				emailValidate: true
			}
		},
		messages: {
			USER_EMAIL: {
				required: 'Для восстановления пароля введите свой e-mail',
				emailValidate: 'Введите корректный e-mail'
			}
		},
		submitHandler: function submitHandler(form) {
			$(form).submit(function (event) {
				window.location.reload(false);
			});
		}
	};*/


	/*
	$(document).on('keyup blur click', '#block-forgotpasswd form', function (){
		$('#block-forgotpasswd form').validate(optionsForgetPassForm);
	});

	$('#auth_bride_form, #auth_spec_form').bind('keyup blur click', function () {
		if ($('#auth_bride_form, #auth_spec_form').hasClass('forget-pass-form')) {
			$('#auth_bride_form, #auth_spec_form').validate(optionsForgetPassForm);
		}
	});
	*/

	//block-forgotpasswd


	/*
	let authModalLink = document.querySelectorAll('.authorization__link');

	authModalLink.forEach(function (link) {
		link.addEventListener('click', function () {
			let parentForm = this.closest('form'),
				passField = parentForm.querySelector('[name="USER_PASSWORD"]'),
				submitBtn = parentForm.querySelector('[type="submit"]');

			passField.closest('label').classList.toggle('hidden');

			if (this.getAttribute('id') == 'forgetPassword') {
				parentForm.classList.add('forget-pass-form');
				this.textContent = 'Авторизоваться';
				submitBtn.textContent = 'Восстановить';
				this.setAttribute('id', 'goAuth');
			} else {
				parentForm.classList.remove('forget-pass-form');
				this.textContent = 'Забыли пароль?';
				submitBtn.textContent = 'Войти';
				this.setAttribute('id', 'forgetPassword');
			}
		});
	});
	*/

});