<div class="nav-catalog modal-another" data-modal="catalog">
	<div class="modal__inner" data-modal-inner="catalog">
		<div class="container">
			<div class="nav-catalog__title"> каталог
				<div class="modal__close" data-modal-close="catalog">
					<svg class="icon icon-close">
						<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-close"></use>
					</svg>
				</div>
			</div>
			<div class="nav-catalog__grid">
				<? $APPLICATION->IncludeComponent(
					"bitrix:menu",
					"smart_catalog_top",
					[
						"ALLOW_MULTI_SELECT" => "N",
						"CHILD_MENU_TYPE" => "left",
						"DELAY" => "N",
						"MAX_LEVEL" => "1",
						"MENU_CACHE_GET_VARS" => [ "" ],
						"MENU_CACHE_TIME" => "3600",
						"MENU_CACHE_TYPE" => "N",
						"MENU_CACHE_USE_GROUPS" => "Y",
						"ROOT_MENU_TYPE" => "top",
						"USE_EXT" => "N",
					]
				); ?>
			</div>
		</div>
	</div>
</div>
<div class="nav-search modal-another" data-modal="search">
	<div class="modal__inner" data-modal-inner="search">
		<div class="container">
			<div class="nav-search__content">
				<form class="form">
					<div class="form-block">
						<label class="form-label">
							<svg class="icon icon-search-reverse">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-search-reverse"></use>
							</svg>
							<input type="text" class="form-input" placeholder="Введите запрос для поиска"/>
						</label>
						<button type="reset" class="form-close">
							<svg class="icon icon-close">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-close"></use>
							</svg>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="mobile-menu modal" data-modal="mobile-menu">
	<div class="modal__inner" data-modal-inner="mobile-menu">
		<div class="mobile-menu__header">
			<div class="header__inner">
				<div class="header__left">
					<div class="header__logo header__item">
						<div class="header__mobile-menu" data-modal-close="mobile-menu">
							<div class="close">
								<svg class="icon icon-close">
									<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-close"></use>
								</svg>
							</div>
						</div>
						<a href="/" class="logo">
							<picture>
								<img src="<?=SITE_TEMPLATE_PATH?>/img/logo.svg" alt=""/>
							</picture>
						</a>
					</div>
				</div>
				<div class="header__right">
					<div class="header__actions">
						<button class="header__search link-modal-another" data-modal-close="mobile-menu" data-modal-open="search">
							<svg class="icon icon-search">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-search"></use>
							</svg>
						</button>
						<a href="#" class="header__profile" data-modal-close="mobile-menu" data-modal-open="profile">
							<svg class="icon icon-profile">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-profile"></use>
							</svg>
							<span class="header__profile-value"> 12 </span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="mobile-menu__content">
			<? $APPLICATION->IncludeComponent(
				"bitrix:menu",
				"smart_top_mob",
				[
					"ALLOW_MULTI_SELECT" => "N",
					"CHILD_MENU_TYPE" => "left",
					"DELAY" => "N",
					"MAX_LEVEL" => "1",
					"MENU_CACHE_GET_VARS" => [ "" ],
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_TYPE" => "N",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"ROOT_MENU_TYPE" => "top",
					"USE_EXT" => "N",
				]
			); ?>
			<div class="mobile-menu__contacts">
				<? $APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					[
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "inc",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/telephone.php",
					]
				); ?>
			</div>
			<div class="mobile-menu__contacts">
				<? $APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					[
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "inc",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/email.php",
					]
				); ?>
			</div>
			<div class="mobile-menu__social">
				<? $APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					[
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "inc",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/socnet.php",
					]
				); ?>
			</div>
		</div>
	</div>
</div>
<div class="modal-cart modal" data-modal="cart">
	<?	$APPLICATION->IncludeFile('/_includes/_modal_cart.php', false, array('SHOW_BORDER' => false));
	?>
</div>

<div class="modal modal-profile" data-modal="profile">
	<div class="modal__inner" data-modal-inner="profile">
		<div class="modal__close" data-modal-close="profile">
			<svg class="icon icon-close">
				<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-close"></use>
			</svg>
		</div>
		<div class="modal-profile__content">
			<div class="modal-profile__tabs tabs" data-tabs>
				<div class="tabs__head" data-tabs-head>
					<div class="tabs__item is-active" data-tabs-item="login">Войти</div>
					<div class="tabs__item" data-tabs-item="signup">Регистрация</div>
				</div>
				<div class="tabs__body">
					<div class="tabs__content is-active" data-tabs-content="login">
						<form class="ui-form ui-form--login" data-ajax-form>
							<div data-form-result></div>
							<input type="hidden" name="action" value="User/login">
												<input type="hidden" name="afterCallback" value="afterRegister">
							<div class="ui-block">
								<label class="ui-label">
									<input type="email" name="email" class="ui-input" placeholder="E-mail" />
								</label>
							</div>
							<div class="ui-block">
								<label class="ui-label">
									<input type="password" name="pass" class="ui-input" placeholder="Пароль" />
								</label>
							</div>
							<button type="submit" class="ui-button ui-button--red"> Войти </button>
						</form>
						<?php /*
						<a href="#" class="forget-password__link"> Забыли пароль? </a>
						*/?>
					</div>
					<div class="tabs__content" data-tabs-content="signup">
						<form class="ui-form" data-ajax-form>
							<div data-form-result></div>
							<input type="hidden" name="action" value="User/register">
							<input type="hidden" name="afterCallback" value="afterRegister">
							<div class="ui-block">
								<label class="ui-label">
									<input type="text" name="name" class="ui-input" placeholder="Имя" />
								</label>
							</div>
							<div class="ui-block">
								<label class="ui-label">
									<input type="text" name="last_name" class="ui-input" placeholder="Фамилия" />
								</label>
							</div>
							<div class="ui-block">
								<label class="ui-label">
									<input type="email" name="email" class="ui-input" placeholder="E-mail" />
								</label>
							</div>
							<div class="ui-block">
								<label class="ui-label">
									<input type="password" name="pass" class="ui-input" placeholder="Пароль" />
								</label>
							</div>
							<div class="ui-block">
								<label class="ui-label">
									<input type="password" name="pass2" class="ui-input" placeholder="Пароль" />
								</label>
							</div>
							<button type="submit" class="ui-button ui-button--red"> Зарегистрироваться </button>
							<div class="policy">
								Нажимая кнопку "Зарегистрироваться", Вы соглашаетесь <a href="/politic/" target="_blank">c условиями политики конфиденциальности</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal modal-profile" data-modal="feedback">
	<div class="modal__inner" data-modal-inner="profile">
		<div class="modal__close" data-modal-close="feedback">
			<svg class="icon icon-close">
				<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-close"></use>
			</svg>
		</div>
		<div class="modal-profile__content">
			<div class="modal-profile__tabs tabs" data-tabs>

				<div class="tabs__body">

					<div class="tabs__content  is-active" data-tabs-content="signup">
						<form class="ui-form" data-ajax-form>
							<div data-form-result></div>
							<input type="hidden" name="action" value="WebForm/feedback">
							<input type="hidden" name="afterCallback" value="afterFeedback">
							<div class="ui-block">
								<label class="ui-label">
									<input type="text" name="name" class="ui-input" placeholder="ФИО" />
								</label>
							</div>
							<div class="ui-block">
								<label class="ui-label">
									<input type="email" name="email" class="ui-input" placeholder="E-mail" />
								</label>
							</div>
							<div class="ui-block">
								<label class="ui-label">
									<textarea class="ui-input" name="message" placeholder="Текст сообщения"></textarea>
								</label>
							</div>
							<button type="submit" class="ui-button ui-button--red"> Отправить сообщение </button>
							<div class="policy">
								Нажимая кнопку "Отправить сообщение", Вы соглашаетесь <a href="/politic/" target="_blank">c условиями политики конфиденциальности</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php /*
<div class="modal-favorite modal" data-modal="favorite">
	<div class="modal__inner" data-modal-inner="favorite">
		<div class="modal__close" data-modal-close="favorite">
			<svg class="icon icon-close">
				<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-close"></use>
			</svg>
		</div>
		<div class="modal__header">
			<div class="section__title"> Избранное </div>
		</div>
		<div class="modal-cart__content">
			<div class="modal-cart__list">
				<div class="modal-cart__item">
					<div class="modal-cart__item-img">
						<picture>
							<source data-srcset="<?=SITE_TEMPLATE_PATH?>/img/thumb.webp" />
							<img data-src="<?=SITE_TEMPLATE_PATH?>/img/thumb.jpg" alt="" class="lazy">
						</picture>
						<div class="dot dot--top-left"></div>
						<div class="dot dot--top-right"></div>
						<div class="dot dot--bottom-right"></div>
						<div class="dot dot--bottom-left"></div>
					</div>
					<div class="modal-cart__item-content">
						<div class="modal-cart__item-name"> Пистолет Макарова ПМММакарова ПММ </div>
						<div class="modal-cart__item-price">
							<div class="price">
								<div class="price-new">
									<span class="value">8 500</span> руб
								</div>
								<div class="price-old">
									<span class="value">10 495</span> руб
								</div>
							</div>
						</div>
					</div>
					<div class="modal-cart__remove">
						<svg class="icon icon-close">
							<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-close"></use>
						</svg>
					</div>
				</div>
				<div class="modal-cart__item">
					<div class="modal-cart__item-img">
						<picture>
							<source data-srcset="<?=SITE_TEMPLATE_PATH?>/img/thumb.webp" />
							<img data-src="<?=SITE_TEMPLATE_PATH?>/img/thumb.jpg" alt="" class="lazy">
						</picture>
						<div class="dot dot--top-left"></div>
						<div class="dot dot--top-right"></div>
						<div class="dot dot--bottom-right"></div>
						<div class="dot dot--bottom-left"></div>
					</div>
					<div class="modal-cart__item-content">
						<div class="modal-cart__item-name"> Пистолет Макарова ПМММакарова ПММ </div>
						<div class="modal-cart__item-price">
							<div class="price">
								<div class="price-new">
									<span class="value">8 500</span> руб
								</div>
								<div class="price-old">
									<span class="value">10 495</span> руб
								</div>
							</div>
						</div>
					</div>
					<div class="modal-cart__remove">
						<svg class="icon icon-close">
							<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-close"></use>
						</svg>
					</div>
				</div>
				<div class="modal-cart__item">
					<div class="modal-cart__item-img">
						<picture>
							<source data-srcset="<?=SITE_TEMPLATE_PATH?>/img/thumb.webp" />
							<img data-src="<?=SITE_TEMPLATE_PATH?>/img/thumb.jpg" alt="" class="lazy">
						</picture>
						<div class="dot dot--top-left"></div>
						<div class="dot dot--top-right"></div>
						<div class="dot dot--bottom-right"></div>
						<div class="dot dot--bottom-left"></div>
					</div>
					<div class="modal-cart__item-content">
						<div class="modal-cart__item-name"> Пистолет Макарова ПМММакарова ПММ </div>
						<div class="modal-cart__item-price">
							<div class="price">
								<div class="price-new">
									<span class="value">8 500</span> руб
								</div>
								<div class="price-old">
									<span class="value">10 495</span> руб
								</div>
							</div>
						</div>
					</div>
					<div class="modal-cart__remove">
						<svg class="icon icon-close">
							<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-close"></use>
						</svg>
					</div>
				</div>
				<div class="modal-cart__item">
					<div class="modal-cart__item-img">
						<picture>
							<source data-srcset="<?=SITE_TEMPLATE_PATH?>/img/thumb.webp" />
							<img data-src="<?=SITE_TEMPLATE_PATH?>/img/thumb.jpg" alt="" class="lazy">
						</picture>
						<div class="dot dot--top-left"></div>
						<div class="dot dot--top-right"></div>
						<div class="dot dot--bottom-right"></div>
						<div class="dot dot--bottom-left"></div>
					</div>
					<div class="modal-cart__item-content">
						<div class="modal-cart__item-name"> Пистолет Макарова ПМММакарова ПММ </div>
						<div class="modal-cart__item-price">
							<div class="price">
								<div class="price-new">
									<span class="value">8 500</span> руб
								</div>
								<div class="price-old">
									<span class="value">10 495</span> руб
								</div>
							</div>
						</div>
					</div>
					<div class="modal-cart__remove">
						<svg class="icon icon-close">
							<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-close"></use>
						</svg>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-cart__total">
			<div class="ui-button ui-button--transparent"> Все избранное </div>
		</div>
	</div>
</div>
*/?>
