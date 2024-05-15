BX.namespace('BX.Sale.PersonalOrderComponent');

(function() {
	
	/**
	 * Arrows animation orders
	 */

	/**
	 * Function animated hide order body
	 */
	function toggleAnimationOrder(cardBody, arrow) {
		BX.toggleClass(arrow, ['', 'hided'])
		$(cardBody).slideToggle('slow')
	}
	
	const orders = document.querySelectorAll('.history-order')

	if (orders.length > 0) {
		orders.forEach((order) => {
			const cardArrows = order.querySelectorAll('.history-order__arrow');
			const cardBody = order.querySelector('.history-order__body')
			const wrapperCardBody = order.querySelector('.history-order__summary-body')
			const cardBodyBtnsClass = '.history-order__body-btns'

			if (cardArrows.length > 0) {
				cardArrows.forEach((arrow) => {

					if (window.innerWidth <= 1024) {

						wrapperCardBody.onclick = (e) => {

							if (!e.target.closest(cardBodyBtnsClass)) {
								toggleAnimationOrder(cardBody, arrow)
							}

						}
					} else {

						BX.bind(arrow, 'click', () => {
							toggleAnimationOrder(cardBody, arrow)
						})
					}

				})
			}


		})
	}

	BX.Sale.PersonalOrderComponent.PersonalOrderList = {

		init : function(params)
		{
			var rowWrapper = document.getElementsByClassName('sale-order-list-inner-row');

			params.paymentList = params.paymentList || {};
			params.url = params.url || "";
			params.templateName = params.templateName || "";
			params.returnUrl = params.returnUrl || "";

			Array.prototype.forEach.call(rowWrapper, function(wrapper)
			{
				var shipmentTrackingId = wrapper.getElementsByClassName('sale-order-list-shipment-id');
			

				if (shipmentTrackingId[0])
				{
					Array.prototype.forEach.call(shipmentTrackingId, function(blockId)
					{
						var clipboard = blockId.parentNode.getElementsByClassName('sale-order-list-shipment-id-icon')[0];
						if (clipboard)
						{
							BX.clipboard.bindCopyClick(clipboard, {text : blockId.innerHTML});
						}
					});
				}

				BX.bindDelegate(wrapper, 'click', { 'class': 'ajax_reload' }, BX.proxy(function(event)
				{
					var block = wrapper.getElementsByClassName('sale-order-list-inner-row-body')[0];
					var template = wrapper.getElementsByClassName('sale-order-list-inner-row-template')[0];
					var cancelPaymentLink = template.getElementsByClassName('sale-order-list-cancel-payment')[0];

					BX.ajax(
						{
							method: 'POST',
							dataType: 'html',
							url: event.target.href,
							data:
							{
								sessid: BX.bitrix_sessid(),
								RETURN_URL: params.returnUrl
							},
							onsuccess: BX.proxy(function(result)
							{
								var resultDiv = document.createElement('div');
								resultDiv.innerHTML = result;
								template.insertBefore(resultDiv, cancelPaymentLink);
								block.style.display = 'none';
								template.style.display = 'block';

								BX.bind(cancelPaymentLink, 'click', function()
								{
									block.style.display = 'block';
									template.style.display = 'none';
									resultDiv.remove();
								},this);

							},this),
							onfailure: BX.proxy(function()
							{
								return this;
							}, this)
						}, this
					);
					event.preventDefault();
				}, this));

				BX.bindDelegate(wrapper, 'click', { 'class': 'sale-order-list-change-payment' }, BX.proxy(function(event)
				{
					event.preventDefault();

					var block = wrapper.getElementsByClassName('sale-order-list-inner-row-body')[0];
					var template = wrapper.getElementsByClassName('sale-order-list-inner-row-template')[0];
					var cancelPaymentLink = template.getElementsByClassName('sale-order-list-cancel-payment')[0];

					BX.ajax(
						{
							method: 'POST',
							dataType: 'html',
							url: params.url,
							data:
							{
								sessid: BX.bitrix_sessid(),
								orderData: params.paymentList[event.target.id],
								templateName : params.templateName
							},
							onsuccess: BX.proxy(function(result)
							{
								var resultDiv = document.createElement('div');
								resultDiv.innerHTML = result;
								template.insertBefore(resultDiv, cancelPaymentLink);
								event.target.style.display = 'none';
								block.parentNode.removeChild(block);
								template.style.display = 'block';
								BX.bind(cancelPaymentLink, 'click', function()
								{
									window.location.reload();
								},this);

							},this),
							onfailure: BX.proxy(function()
							{
								return this;
							}, this)
						}, this
					);

				}, this));
			});
		}
	};
})();
