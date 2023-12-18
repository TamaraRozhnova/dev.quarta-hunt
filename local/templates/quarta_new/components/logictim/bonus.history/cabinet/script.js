BX.ready(function(){

	BX.bind(BX("generate_coupon"), "click", function(){
		var data = new Object();
		data["ACTION"] = 'ADD_COUPON';
		BX.ajax({
			url: '/bitrix/components/logictim/bonus.history/ajax.php',
			method: 'POST',
			data: data,
			dataType: 'json',
			onsuccess: function(result) {
				if(result.COUPON && result.COUPON != '')
				{
					BX.adjust(BX('partnet_coupon'), {text: result.COUPON});
				}
				if(result.ERROR_TEXT && result.ERROR_TEXT != '')
				{
					BX.adjust(BX('coupon_error'), {text: result.ERROR_TEXT});
				}
			}
		});
		
	});
	
	BX.bind(BX("enter_coupon"), "click", function(event){
		event.preventDefault();
		var data = new Object();
		data["ACTION"] = 'ENTER_COUPON';
		data["COUPON_CODE"] = BX('enter_coupon_code').value;
		BX.ajax({
			url: '/bitrix/components/logictim/bonus.history/ajax.php',
			method: 'POST',
			data: data,
			dataType: 'json',
			onsuccess: function(result) {
				if(result.COUPON && result.COUPON != '')
				{
					BX.adjust(BX('partnet_coupon'), {text: result.COUPON});
				}
				if(result.ERROR_TEXT && result.ERROR_TEXT != '')
				{
					BX.adjust(BX('coupon_error'), {text: result.ERROR_TEXT});
				}
			}
		});
	});	
	
	BX.bind(BX("exit_bonus_link"), "click", function(){
		var data = new Object();
		data["ACTION"] = 'EXIT_BONUS';
		data["SUM"] = BX("exit_bonus_input").value;
		BX.ajax({
			url: '/bitrix/components/logictim/bonus.history/ajax.php',
			method: 'POST',
			data: data,
			dataType: 'json',
			onsuccess: function(result) {
				if(result.RESULT.RESULT && result.RESULT.RESULT != '')
				{
					if(result.RESULT.RESULT == 'OK')
						var class_name = 'send_ok';
					else
						var class_name = 'send_error';
						
					BX.adjust(BX('exit_bonus_result'), {props: {className: class_name}, html: result.RESULT.RESULT_TEXT});
				}
				//console.log(result);
			}
		});
		
	}); 
	
	

});


