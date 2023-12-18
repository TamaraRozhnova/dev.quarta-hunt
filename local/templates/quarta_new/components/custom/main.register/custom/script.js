$(document).ready(function() {
    if ($('#phone').length != 0) {
        $('#phone').inputmask({"mask": "+7 (999) 999-99-99"});
        $('#phone').val('')
    }

    const phoneInput = document.querySelector('#phone');

    if (phoneInput !== null) {
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
    }

    if ($('#promo').prop('checked') == true) {
		$('input[name="UF_PROMO"]').val('true');
	}

	$('#promo').on('click', function(){
		if ($(this).prop('checked') == true){
			$('input[name="UF_PROMO"]').val('true');
		}else{
			$('input[name="UF_PROMO"]').val('false');
		}
	});

})

