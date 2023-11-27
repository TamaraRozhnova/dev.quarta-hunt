<section class="section section-about">
<div class="container">
	<div class="section-about__block">
		<div class="section-about__background">
			<span><? $APPLICATION->IncludeFile( '/_includes/about_bg.php' ); ?></span>
		</div>
		<div class="section-about__content">
			<h2 class="section__title"> О компании </h2>
			<div class="section__text">
				<? $APPLICATION->IncludeFile( '/_includes/main/about_text.php' ); ?>

			</div>
			 <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"smart_o_company",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(""),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "company",
		"USE_EXT" => "N"
	)
);?>
			<div class="section-about__social">
				 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "standard.php",
		"PATH" => "/include/socnet.php"
	)
);?>
			</div>
		</div>
	</div>
</div>
 </section>
