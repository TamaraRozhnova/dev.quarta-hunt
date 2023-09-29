$( document ).ready(function() {
    if ( document.getElementById("phone") ) {
		$('#phone').inputmask({"mask": "+7 (999) 999-99-99"});
    }

    const phoneInput = document.querySelector('#phone');

    phoneInput.addEventListener('paste', (event) => {
        clipboardData = event.clipboardData || window.clipboardData;

        pastedData = clipboardData.getData('Text');

        if (pastedData.match(/\d+/g) != null) {
            let modifyResult = pastedData.match(/\d+/g).join('');

            if (modifyResult.length == 11) {
                phoneInput.value = modifyResult.substring(1)
            }

        }

    })

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
		let phoneLength = $('#phone').val().replace(/[^0-9]/g,"");
		
    	if(phoneLength.length < 11){
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

let objModal = '',
	userSelected = null,
	userData;

function initModalMultiUser(data) {

	if (data.USERS) {

		let hmtlModalListAccounts = '';
		const multiAccountsWindow = document.querySelector('#multi-accounts-window');
		const multiAccountsWindowList = multiAccountsWindow.querySelector('.multi-accounts-content-list');

		data.USERS.forEach( (element, index) => {

			hmtlModalListAccounts += `
				<div data-index = "${index}" class="multi-accounts-content-item">
					<div class="multi-accounts-content-item-name-type">
						<span class = "multi-accounts-content-item-name">
							${element?.NAME_DISPLAY}
						</span>
						<span class = "multi-accounts-content-item-type">
							${element?.TYPE_DISPLAY}
						</span>
					</div>
					<span class = "multi-accounts-content-item-email">
						${element?.EMAIL}
					</span>
				</div>
			`
		});

		if (
			hmtlModalListAccounts != '' 
			&&
			hmtlModalListAccounts != null 
		) {
			multiAccountsWindowList.innerHTML = hmtlModalListAccounts
		}

		handleMultiAccounts(data.USERS)
	
		objModal = new Modal({
			modalSelector: "#multi-accounts-window"
		})

		objModal.open()

	}

}

function handleMultiAccounts(data) {
	document.addEventListener('click', (event) => {
		if (event.target.closest('.multi-accounts-content-item') != null) {
			let currentItem = event.target.closest('.multi-accounts-content-item')
			let currentItemData = data[currentItem.dataset.index]
			let dataSend = {
				USER: currentItemData,
				USER_SELECTED: 'Y'
			}

			userData = dataSend
			userSelected = 'Y';

			authPhone(dataSend)

		}
	})
}

function authPhone(data = null){

	let dataSend;

	if (
		data != null
		&&
		data?.USER_SELECTED
		||
		userSelected == 'Y'
	) {

		if (userData?.USER) {
			userData.USER.userCode = $('input[name="CODE"]').val()
			dataSend = userData
		} else if (data?.USER) {
			data.USER.userCode = $('input[name="CODE"]').val()
			dataSend = data
		}
		
	} else {
		dataSend = {
			USER: {
				PERSONAL_PHONE: $('input[name="USER_PHONE"]').val(),
				userCode: $('input[name="CODE"]').val()
			}
		}
	}

	BX.ajax({
        method: 'POST',
		data: dataSend,
        url: '/local/templates/quarta_new/components/bitrix/system.auth.authorize/flat/ajax.php',
		dataType: 'json',
		onsuccess: function(data){

			if (data?.MULTI_USER == 'Y') {

				/**
				 * Несколько аккаунтов
				 */

				initModalMultiUser(data)

			} else {

				if (typeof objModal != undefined && objModal != null && objModal != '') {
					objModal.close()
				}

				if(data.error == false){
					$('.bx-authform-formgroup-container.code').show();
					$('.bx-authform-formgroup-container.phone').hide();
					$('.form_auth_phone').hide();
					$('.login_auth_phone').show();
					$('.more_code_phone').show();
	
					if(data.user){

						const urlParams = new URLSearchParams(window.location.search);
						if (urlParams.has("logout") && urlParams.get("logout") === "yes") {

							urlParams.delete("logout");
							const newUrl = window.location.origin + window.location.pathname + "?" + urlParams.toString();

							window.location.href = newUrl;

						} else {
							window.location.reload();
						}

					}

				} else {
					$('.error_message').text(data.message);
				}

			}

		}
    });
}