<div class="sidebar-menu">
	<div class="sidebar-menu__content">
		<div class="sidebar-menu__title"><? $APPLICATION->ShowTitle();?></div>


		<div class="sidebar-menu__list">
			<?$APPLICATION->IncludeComponent(
				"bitrix:menu",
				"smart_sidebar",
				Array(
					"ALLOW_MULTI_SELECT" => "N",
					"CHILD_MENU_TYPE" => "left",
					"DELAY" => "N",
					"MAX_LEVEL" => "1",
					"MENU_CACHE_GET_VARS" => array(""),
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_TYPE" => "N",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"ROOT_MENU_TYPE" => "bottom",
					"USE_EXT" => "N"
				)
			);?>

		</div>
		<div class="contacts sm-none">
			<div class="contacts__text">
				<span> Телефоны </span>
				<? $APPLICATION->IncludeFile('/_includes/contacts/phones.php', false, ['MODE'=> 'text']);?>
			</div>
			<div class="contacts__text">
				<span> E-mail </span>
				<? $APPLICATION->IncludeFile('/_includes/contacts/email.php', false, ['MODE'=> 'text']);?>
			</div>
		</div>
	</div>
</div>
