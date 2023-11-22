<? require( $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php" );
$APPLICATION->SetTitle( "Задайте вопрос" );
?>

	<div class="main">
		<section class="contacts">
			<div class="container">
				<div class="section__title">
					Контакты
				</div>
				<div class="contacts-block">
					<div class="contacts-element">
						<div class="contacts-row">
							<div class="contacts-item">
								<div class="contacts-item__title">Связаться</div>
								<div class="contacts-info">
									<div class="contacts-info__title">Телефон:</div>
									<?$APPLICATION->IncludeFile('/_includes/contacts/phones.php', false, ['MODE'=> 'text']);?>

								</div>
								<div class="contacts-info">
									<div class="contacts-info__title">E-mail:</div>
									<?$APPLICATION->IncludeFile('/_includes/contacts/email.php', false, ['MODE'=> 'text']);?>
								</div>
							</div>
							<div class="contacts-item">
								<div class="contacts-item__title">Почтовый адрес</div>
								<div class="contacts-info">
									<div class="contacts-info__title">Адрес:</div>
									<div class="contacts-info__text">
										<?$APPLICATION->IncludeFile('/_includes/contacts/address.php', false, ['MODE'=> 'text']);?>

										</div>
								</div>
								<div class="contacts-info">
									<div class="contacts-info__title">Часы работы:</div>
									<div class="contacts-info__text">
										<?$APPLICATION->IncludeFile('/_includes/contacts/work_time.php', false, ['MODE'=> 'text']);?>

									</div>
								</div>
							</div>
						</div>

						<div class="contacts-social">
							<div class="contacts-social__title">Мы в соцсетях</div>
							<?$APPLICATION->IncludeComponent("spro:widget", "social", array(), false, array("HIDE_ICONS" => "Y"));?>
						</div>

						<button class="ui-button ui-button--red contacts-button" type="button" data-modal-open="feedback">Связаться с нами</button>
					</div>
					<div class="contacts-map">
						<? $APPLICATION->IncludeComponent(
	"bitrix:map.yandex.view", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"INIT_MAP_TYPE" => "MAP",
		"MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:55.73829999999371;s:10:\"yandex_lon\";d:37.59459999999997;s:12:\"yandex_scale\";i:10;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:3:\"LON\";d:37.709956445312464;s:3:\"LAT\";d:55.74740257696169;s:4:\"TEXT\";s:0:\"\";}}}",
		"MAP_WIDTH" => "600",
		"MAP_HEIGHT" => "500",
		"CONTROLS" => array(
			0 => "ZOOM",
			1 => "MINIMAP",
			2 => "TYPECONTROL",
			3 => "SCALELINE",
		),
		"OPTIONS" => array(
			0 => "ENABLE_SCROLL_ZOOM",
			1 => "ENABLE_DBLCLICK_ZOOM",
			2 => "ENABLE_DRAGGING",
		),
		"MAP_ID" => "",
		"API_KEY" => ""
	),
	false,
	array(
		"HIDE_ICONS" => "N"
	)
);?>

					</div>
				</div>
			</div>
		</section>
	</div>

<? require( $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php" ) ?>
