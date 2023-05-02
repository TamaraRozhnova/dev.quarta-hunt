<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?
global $USER;
?>
<div class="registration-wrap mb-4">
	<div class="container">
	<?$APPLICATION->IncludeComponent(
		"custom:main.register",
		"custom",
		Array(
			"AUTH" => "Y",
			"REQUIRED_FIELDS" => array("EMAIL", "NAME", "LAST_NAME", "PERSONAL_PHONE"),
			"SET_TITLE" => "Y",
			"SHOW_FIELDS" => array("PERSONAL_PHONE", "NAME", "LAST_NAME", "EMAIL" ),
			"SUCCESS_PAGE" => "",
			"USER_PROPERTY" => array("UF_TYPE", "UF_PROMO"),
			"USER_PROPERTY_NAME" => "",
			"USE_BACKURL" => "N"
		)
	);?>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

