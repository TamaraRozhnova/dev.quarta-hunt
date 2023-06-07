<?php define("NEED_AUTH", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Оставьте отзыв");
$APPLICATION->SetTitle("Оставьте отзыв");

$request = \Bitrix\Main\Context::getCurrent()->getRequest();

$getParams = $request->getQueryList()->toArray(); ?>


<div class="reviews-cabinet-page-header">
	<div class="container">
		<div class="reviews-cabinet-page-header-text">
			<h1><?=$APPLICATION->ShowTitle();?></h1>
		</div>
		<div class="reviews-cabinet-page-header-subtext">
			<span>Получите + 300 бонусных баллов за 1 отзыв о товаре</span>
		</div>
	</div>
</div>

<div class="reviews-cabinet-container">
	<?if (!empty($getParams['order_id'])):?>
		<?$APPLICATION->IncludeComponent(
			"custom:sale.order.forms.review",
			"",
			Array(
				"ORDER_NUMBER" => $getParams['order_id']
			)
		);?>
	<?endif;?>
</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");