<?php if (CSite::InDir( '/about/' ) && !CSite::InDir( '/about/contacts/' )): ?>
	</div>
	</section>
	</div>
<?php endif; ?>
<?php if ( CSite::InDir( '/login/' ) || CSite::InDir( '/auth/' ) ): ?>
    </div>
    </section>
    </div>
<?php endif; ?>

<footer class="footer">
	<div class="container">
		<?php $APPLICATION->IncludeComponent(
			"bitrix:menu",
			"smart_bottom_main",
			[
				"ALLOW_MULTI_SELECT" => "N",
				"CHILD_MENU_TYPE" => "bottom",
				"DELAY" => "N",
				"MAX_LEVEL" => "1",
				"MENU_CACHE_GET_VARS" => [
				],
				"MENU_CACHE_TIME" => "3600",
				"MENU_CACHE_TYPE" => "N",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"ROOT_MENU_TYPE" => "bottom_main",
				"USE_EXT" => "N",
				"COMPONENT_TEMPLATE" => "smart_bottom_main",
			],
			false
		); ?>
		<div class="footer-content">
			<?php $APPLICATION->IncludeComponent(
				"bitrix:main.include",
				"",
				[
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "inc",
					"EDIT_TEMPLATE" => "standard.php",
					"PATH" => "/include/socnet.php",
				]
			); ?>
			<div class="footer__links">
				<div class="accordion footer__links-column">
					<div class="accordion__head" data-accordion-head>
						Компания
						<div class="accordion__arrow"></div>
					</div>
					<div class="accordion__body" data-accordion-body>
						<div class="footer__links-list">
							<?php $APPLICATION->IncludeComponent(
								"bitrix:menu",
								"smart_bottom",
								[
									"ALLOW_MULTI_SELECT" => "N",
									"CHILD_MENU_TYPE" => "left",
									"DELAY" => "N",
									"MAX_LEVEL" => "1",
									"MENU_CACHE_GET_VARS" => [ "" ],
									"MENU_CACHE_TIME" => "3600",
									"MENU_CACHE_TYPE" => "N",
									"MENU_CACHE_USE_GROUPS" => "Y",
									"ROOT_MENU_TYPE" => "bottom",
									"USE_EXT" => "N",
								]
							); ?>
						</div>
					</div>
				</div>
				<div class="accordion footer__links-column">
					<div class="accordion__head" data-accordion-head>
						Каталог
						<div class="accordion__arrow"></div>
					</div>
					<div class="accordion__body" data-accordion-body>
						<!--div-- class="footer__links-list">
							<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"smart_catalog_bottom", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "smart_catalog_bottom"
	),
	false
); ?>
						</div-->
                        <div class="footer__links-list">
                            <?php $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "standard.php",
                                    "PATH" => "/include/footer_adress.php",
                                ]
                            ); ?>
                        </div>
					</div>
				</div>
				<div class="accordion footer__links-column footer__links-column_address">
					<div class="accordion__head" data-accordion-head>
						Контакты
						<div class="accordion__arrow"></div>
					</div>
					<div class="accordion__body" data-accordion-body>
						<div class="footer__links-list">
					<?php $APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						[
							"AREA_FILE_SHOW" => "file",
							"AREA_FILE_SUFFIX" => "inc",
							"EDIT_TEMPLATE" => "standard.php",
							"PATH" => "/include/footer_phones.php",
						]
					); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			[
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => "standard.php",
				"PATH" => "/include/contact_info.php",
			]
		); ?></div>
	</div>
</footer>
<!-- end footer -->

<?php $APPLICATION->IncludeFile( "/_includes/_modal_footer.php" ); ?>

</div>
<!-- END content -->
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/app.js?v5"></script>
<?/*?>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/uiKit/counter.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/uiKit/input.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/uiKit/counter.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/uiKit/inputFile.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/uiKit/select.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/uiKit/tooltip.js"></script>
<?*/?>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/script.js?v3"></script>

</body>
</html>
