<?
define("NEED_AUTH", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("");?>


<div class = "address">
	<div class="container">
		<div class="row">
			<div class="col-8">
				<div class="address__card">
					<h2>
						<svg  width="15" height="11" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon">
							<path  d="M11.59 9.969c-.27 0-.53-.109-.722-.302a1.036 1.036 0 010-1.459 1.019 1.019 0 011.446 0 1.036 1.036 0 010 1.459 1.018 1.018 0 01-.723.302zm1.024-6.188L13.95 5.5h-3.04V3.781h1.704zM3.409 9.97a1.02 1.02 0 01-.723-.302 1.036 1.036 0 010-1.459 1.018 1.018 0 011.446 0 1.036 1.036 0 010 1.459 1.018 1.018 0 01-.723.302zm9.546-7.219h-2.046V0H1.364C.607 0 0 .612 0 1.375v7.563h1.364c0 .547.215 1.071.599 1.458a2.037 2.037 0 002.892 0c.384-.387.6-.911.6-1.459h4.09c0 .548.216 1.072.6 1.459a2.037 2.037 0 002.892 0c.384-.387.6-.911.6-1.459H15V5.5l-2.046-2.75z" fill="#808d9a">
							</path>
						</svg>
						Адрес доставки
					</h2>

					<?$APPLICATION->IncludeComponent("bitrix:form.result.new", "addresses", Array(
						"CACHE_TIME" => "3600",	
							"CACHE_TYPE" => "A",	
							"CHAIN_ITEM_LINK" => "",	
							"CHAIN_ITEM_TEXT" => "",	
							"EDIT_URL" => "result_edit.php",	
							"IGNORE_CUSTOM_TEMPLATE" => "N",	
							"LIST_URL" => "",	
							"SEF_MODE" => "N",	
							"SUCCESS_URL" => "",
							"USE_EXTENDED_ERRORS" => "N",	
							"VACANCY_NAME" => "",	
							"VARIABLE_ALIASES" => array(
								"RESULT_ID" => "RESULT_ID",
								"WEB_FORM_ID" => "WEB_FORM_ID",
							),
							"WEB_FORM_ID" => "5",	
						),
						false
					);?>


				</div>
			</div>
		</div>
	</div>
</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>