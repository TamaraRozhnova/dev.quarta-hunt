
<? if (empty( $arResult['ORDER'] )):
	$rootFolder = \Bitrix\Main\Application::getDocumentRoot();
	?>
	<div class="cart-page cart">
		<form action="" id="ORDER_FORM" name="ORDER_FORM" enctype="multipart/form-data">
			<? if ($_POST["is_ajax_post"] == "Y") $APPLICATION->RestartBuffer() ?>

			<div style="display: none">
				<?
				if ( !empty( $arResult["ERROR"] ))
				{
					foreach ($arResult["ERROR"] as $v)
					{
						echo ShowError( $v );
					}
				} ?>
			</div>

			<input type="checkbox" name="PERSON_TYPE" id="PERSON_TYPE" value="3" checked style="display:none;">
			<input type="hidden" name="confirmorder" id="confirmorder" value="N">
			<input type="hidden" name="order_form" id="order_form" value="Y">
			<input type="hidden" name="profile_change" id="profile_change" value="N">
			<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
			<input type="hidden" name="json" value="N">
			<input type="hidden" name="afterLoadAction" value="">

			<div class="cart-page__row">
				<div class="cart-page__main">
					<div class="cart-delivery">
						<? foreach ($arResult["DELIVERY"] as $arDelivery):
							if ($arDelivery["CHECKED"] == "Y"):
								$deliveryChecked = $arDelivery["ID"];
								?>
								<input type="hidden" name="DELIVERY_ID" class="delivery_id" value="<?=$arDelivery["ID"]?>">
							<? endif;
						endforeach ?>
						<? include $rootFolder . $this->__folder . "/pay_system.php"; ?>

						<div class="cart__box-title">Способы доставки</div>

						<div class="choice-region-inline">
							<div class="choice-region-inline__head">
								<svg class="icon icon-map-2">
									<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-map-2"></use>
								</svg>
								Населенный пункт:
							</div>
							<div class="choice-region-inline__body">
								<div class="choice-region-inline__title"><?=$arCity["LOCATION_NAME"]?></div>
								<a href="#" class="choice-region-inline__link" data-modal="city">Сменить регион</a>
							</div>
						</div>

						<div class="cart-delivery-box">
							<? // Самовывоз
							?>
							<div class="cart-delivery-box__col <? if ($deliveryChecked == 2): ?>active<? endif; ?>">
								<div class="cart-delivery-box__radio cart-delivery-box__radio--md-width">
									<div class="radio-box radio-box--big-icon">
										<input type="radio" name="delivery-main" class="radio-box__input cart-delivery-box__input-radio"
										       value="self" id="cart-delivery-store" <? if ( $deliveryChecked == 2 ): ?>checked<? endif; ?>>
										<label for="cart-delivery-store" class="radio-box__label radio-box__label--mini"
										       onclick="$('.delivery_id').val(2); $('input[name=delivery-main][value=self]').prop('checked', 'checked'); SubmitFormOrder('N')">
											<span class="radio-box__label-icon"></span>
											Самовывоз<br>
											со склада
										</label>
									</div>
								</div>
								<div class="cart-delivery-box__contacts-box">
									<div class="cart-delivery-box__contacts-col">
										<ul class="contacts-list cart-delivery-box__contacts">
											<li>
												<svg class="icon icon-map-2">
													<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-map-2"></use>
												</svg>
												г. Иваново, ул. Тимирязева, д.1
											</li>
											<li>
												<svg class="icon icon-phone-2">
													<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-phone-2"></use>
												</svg>
												+7 (4932) 34-50-10
											</li>
										</ul>
									</div>
									<div class="cart-delivery-box__contacts-col">
										<ul class="contacts-list cart-delivery-box__contacts">
											<li>
												<svg class="icon icon-mail-2">
													<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-mail-2"></use>
												</svg>
												sales@gutmorgen.ru
											</li>
											<li>
												<svg class="icon icon-time-2">
													<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-time-2"></use>
												</svg>
												пн-пт: с 8:00 до 18:00
											</li>
										</ul>
									</div>
									<div class="cart-delivery-box__contacts-link">
										<a href="#" data-modal="order-map">Посмотреть на карте</a>
									</div>
								</div>
							</div>
							<? if (is_array( $arResult["DELIVERY"][43] ) || is_array( $arResult["DELIVERY"][39] ) || is_array( $arResult["DELIVERY"][48] )): ?>
								<? // Доставка ТК до ПВЗ ?>
								<div class="cart-delivery-box__col <? if ($deliveryChecked == 43 || $deliveryChecked == 39 || $deliveryChecked == 48): ?>active<? endif; ?>">
									<div class="cart-delivery-box__radio">
										<div class="radio-box radio-box--big-icon">
											<input type="radio" name="delivery-main" class="radio-box__input cart-delivery-box__input-radio"
											       value="tk_pvz" id="cart-delivery-point"
											       <? if ( $deliveryChecked == 43 || $deliveryChecked == 39 || $deliveryChecked == 48 ): ?>checked<? endif;
											?>>
											<label for="cart-delivery-point" class="radio-box__label radio-box__label--mini">
												<span class="radio-box__label-icon"></span>
												Самовывоз из пунктов<br>
												выдачи
											</label>
										</div>
									</div>
									<div class="cart-delivery-box__tk-list">
										<? if (is_array( $arResult["DELIVERY"][39] )): ?>
											<div class="cart-delivery-box__tk">
												<div class="tk-info<? if ($deliveryChecked == 39): ?> active<? endif; ?>">
													<? preg_match( '#onclick="(.*?)"#', $arResult["JS_DATA"]["DELIVERY"]["39"]["PERIOD_TEXT"], $matches ); ?>
													<div class="tk-info__head"
													     data-boxberry-pvz <?=$arResult["JS_DATA"]["DELIVERY"]["39"]["PERIOD_TEXT"]?$matches[0]:'onclick="$(\'.delivery_id\').val(39); $(\'[name=afterLoadAction]\').val(\'showBoxberryPvz\'); SubmitFormOrder(\'N\');"'?>>
														<div class="tk-info__logo">
															<img src="<?=SITE_TEMPLATE_PATH?>/img/delivery-2.jpg" alt="">
														</div>
														<div class="tk-info__checked">
															<svg class="icon icon-checked-round">
																<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-checked-round"></use>
															</svg>
														</div>
														<a class="tk-info__link">Изменить пункт выдачи</a>
													</div>
												</div>
												<ul class="tk-info__contacts contacts-list cart-delivery-box__contacts">
													<? if ($deliveryChecked == 39 && $arResult["ORDER_DATA"]["ORDER_PROP"][23]): ?>
														<li class="delivery-my-address show">
															<svg class="icon icon-map-2">
																<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-map-2"></use>
															</svg>
															<span><?=htmlspecialcharsbx( $arResult["ORDER_DATA"]["ORDER_PROP"][23] );?></span>
														</li>
													<? endif; ?>
													<li>
														<svg class="icon icon-time-2">
															<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-time-2"></use>
														</svg>
														<? $str = preg_replace( '#(<a.*?>).*?(</a>)#', '', $arResult["JS_DATA"]["DELIVERY"]["39"]["PERIOD_TEXT"] ) ?>
														<?=$deliveryChecked == 39?$str:$arResult["CAD_DELIVERY_INFO"]['UF_BOXBERRY_TRANZIT_PVZ'] . " дня"?>
													</li>
													<li>
														<svg class="icon icon-purse">
															<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-purse"></use>
														</svg>
														<?=$deliveryChecked == 39?$arResult["DELIVERY"][39]["PRICE_FORMATED"]:"от " . $arResult["CAD_DELIVERY_INFO"]['UF_BOXBERRY_PVZ'] . " руб."?>
													</li>
												</ul>
											</div>
										<? endif; ?>
										<? if (is_array( $arResult["DELIVERY"][43] )): ?>
											<div class="cart-delivery-box__tk">
												<div class="tk-info<? if ($deliveryChecked == 43): ?> active<? endif; ?> SDEK_selectPVZ"
												     onclick="$('.delivery_id').val(43); IPOLSDEK_pvz.selectPVZ('43','PVZ');">
													<div class="tk-info__head">
														<div class="tk-info__logo">
															<img src="<?=SITE_TEMPLATE_PATH?>/img/delivery-1.jpg" alt="">
														</div>
														<div class="tk-info__checked">
															<svg class="icon icon-checked-round">
																<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-checked-round"></use>
															</svg>
														</div>
														<a class="tk-info__link">Выбрать пункт выдачи</a>
													</div>
												</div>
												<ul class="tk-info__contacts contacts-list cart-delivery-box__contacts">
													<? if ($deliveryChecked == 43): ?>
														<li class="delivery-my-address show">
															<svg class="icon icon-map-2">
																<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-map-2"></use>
															</svg>
															<span><?=htmlspecialcharsbx( $arResult["ORDER_DATA"]["ORDER_PROP"][23] );?></span>
														</li>
													<? endif; ?>
													<li>
														<svg class="icon icon-time-2">
															<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-time-2"></use>
														</svg>
														<?=$deliveryChecked == 43?$arResult["DELIVERY"][43]["PERIOD_TEXT"]:$arResult["CAD_DELIVERY_INFO"]['UF_CDEK_TRANZIT_PVZ']?>
													</li>
													<li>
														<svg class="icon icon-purse">
															<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-purse"></use>
														</svg>
														<?=$deliveryChecked == 43?$arResult["DELIVERY"][43]["PRICE_FORMATED"]:"от " . $arResult["CAD_DELIVERY_INFO"]['UF_CDEK_PVZ'] . " руб."?>
													</li>
												</ul>
											</div>
										<? endif; ?>
										<? if (is_array( $arResult["DELIVERY"][48] )): ?>
											<div class="cart-delivery-box__tk">
												<div class="tk-info<? if ($deliveryChecked == 48): ?> active<? endif; ?>">
													<div class="tk-info__head" data-modal="order-address" data-tk="48">
														<div class="tk-info__logo">
															<img src="<?=SITE_TEMPLATE_PATH?>/img/delivery-3.jpg" alt="">
														</div>
														<div class="tk-info__checked">
															<svg class="icon icon-checked-round">
																<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-checked-round"></use>
															</svg>
														</div>
														<a href="#" class="tk-info__link ">Изменить адрес</a>
													</div>
												</div>
												<ul class="tk-info__contacts contacts-list cart-delivery-box__contacts">
													<li class="delivery-my-address<? if ($deliveryChecked == 48): ?> show<? endif; ?>">
														<svg class="icon icon-map-2">
															<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-map-2"></use>
														</svg>
														<span><?=htmlspecialcharsbx( $arResult["ORDER_DATA"]["ORDER_PROP"][23] )?></span>
													</li>
													<li>
														<svg class="icon icon-time-2">
															<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-time-2"></use>
														</svg>
														<?=$arResult["CAD_DELIVERY_INFO"]['UF_POST_TRANZIT'] . ' дней'?>
													</li>
													<li>
														<svg class="icon icon-purse">
															<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-purse"></use>
														</svg>
														<?=$arResult["CAD_DELIVERY_INFO"]['UF_POST']?"от " . $arResult["CAD_DELIVERY_INFO"]['UF_POST'] . " руб.":"Информация о стоимости временно не доступна" //"от ". $arResult["CAD_DELIVERY_INFO"]['UF_POST'] . " руб."?>
													</li>
												</ul>
											</div>
										<? endif; ?>
									</div>
								</div>
							<? endif; ?>
							<div class="cart-delivery-box__col<? if ($deliveryChecked == 42 || $deliveryChecked == 40): ?> active<? endif; ?>">
								<div class="cart-delivery-box__radio">
									<div class="radio-box radio-box--big-icon">
										<input type="radio" name="delivery-main" class="cart-delivery-box__input-radio radio-box__input"
										       id="cart-delivery-courier" value="tk_kd" <? if ( $deliveryChecked == 42 || $deliveryChecked == 40 ): ?>checked<? endif; ?>>
										<label for="cart-delivery-courier" class="radio-box__label radio-box__label--mini">
											<span class="radio-box__label-icon"></span>
											Курьерская<br>
											доставка
										</label>
									</div>
								</div>
								<div class="cart-delivery-box__tk-list">
									<? if (is_array( $arResult["DELIVERY"][40] )): ?>
										<div class="cart-delivery-box__tk">
											<div class="tk-info<? if ($deliveryChecked == 40): ?> active<? endif; ?>">
												<div class="tk-info__head" data-modal="order-address" data-tk="40">
													<div class="tk-info__logo">
														<img src="<?=SITE_TEMPLATE_PATH?>/img/delivery-2.jpg" alt="">
													</div>
													<div class="tk-info__checked">
														<svg class="icon icon-checked-round">
															<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-checked-round"></use>
														</svg>
													</div>
													<a href="#" class="tk-info__link">Изменить адрес</a>
												</div>
											</div>
											<ul class="tk-info__contacts contacts-list cart-delivery-box__contacts">
												<li class="delivery-my-address<? if ($deliveryChecked == 40): ?> show<? endif; ?>">
													<svg class="icon icon-map-2">
														<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-map-2"></use>
													</svg>
													<span><?=htmlspecialcharsbx( $arResult["ORDER_DATA"]["ORDER_PROP"][23] )?></span>
												</li>
												<li>
													<svg class="icon icon-time-2">
														<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-time-2"></use>
													</svg>
													<? $str = preg_replace( '#(<a.*?>).*?(</a>)#', '', $arResult["JS_DATA"]["DELIVERY"]["39"]["PERIOD_TEXT"] ) ?>
													<?=$deliveryChecked == 40?$str:$arResult["CAD_DELIVERY_INFO"]['UF_BOXBERRY_TRANZIT_KD'] . " дня"?>
												</li>
												<li>
													<svg class="icon icon-purse">
														<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-purse"></use>
													</svg>
													<?=$deliveryChecked == 40?$arResult["DELIVERY"][40]["PRICE_FORMATED"]:"от " . $arResult["CAD_DELIVERY_INFO"]['UF_BOXBERRY_COURIER'] . " руб."?>
												</li>
											</ul>
										</div>
									<? endif; ?>
									<? if (is_array( $arResult["DELIVERY"][42] )): ?>
										<div class="cart-delivery-box__tk">
											<div class="tk-info <? if ($deliveryChecked == 42): ?> active<? endif; ?>">
												<div class="tk-info__head" data-modal="order-address" data-tk="42">
													<div class="tk-info__logo">
														<img src="<?=SITE_TEMPLATE_PATH?>/img/delivery-1.jpg" alt="">
													</div>
													<div class="tk-info__checked">
														<svg class="icon icon-checked-round">
															<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-checked-round"></use>
														</svg>
													</div>
													<a href="#" class="tk-info__link">Изменить адрес</a>
												</div>
											</div>
											<ul class="tk-info__contacts contacts-list cart-delivery-box__contacts">
												<li class="delivery-my-address<? if ($deliveryChecked == 42): ?> show<? endif; ?>">
													<svg class="icon icon-map-2">
														<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-map-2"></use>
													</svg>
													<span><?=htmlspecialcharsbx( $arResult["ORDER_DATA"]["ORDER_PROP"][23] )?></span>
												</li>
												<li>
													<svg class="icon icon-time-2">
														<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-time-2"></use>
													</svg>
													<?=$deliveryChecked == 42?$arResult["DELIVERY"][42]["PERIOD_TEXT"]:$arResult["CAD_DELIVERY_INFO"]['UF_CDEK_TRANZIT_PVZ']?>
												</li>
												<li>
													<svg class="icon icon-purse">
														<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-purse"></use>
													</svg>
													<?=$deliveryChecked == 42?$arResult["DELIVERY"][42]["PRICE_FORMATED"]:"от " . $arResult["CAD_DELIVERY_INFO"]['UF_BOXBERRY_COURIER'] . " руб."?>
												</li>
											</ul>
										</div>
									<? endif; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="cart-page__bottom">
						<a href="/personal/cart/" class="cart-page__back">
							<svg class="icon icon-chevron-double-left">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-chevron-double-left"></use>
							</svg>
							Назад
						</a>
						<a href="javascript:void(0)" class="cart-page__next" onclick="goNextStep($(this)); event.preventDefault()">
							Далее
							<svg class="icon icon-chevron-double-right">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-chevron-double-right"></use>
							</svg>
						</a>
					</div>
				</div>
				<div class="cart-page__sidebar">
					<div class="cart-page__sticky" data-sticky>
						<? include $rootFolder . $this->__folder . "/sidebar.php"; ?>
					</div>
				</div>
			</div>
			<? /*<input type="hidden" name="ORDER_PROP_1" class="location-id" value="<?=$locationID?>">*/ ?>
			<input type="hidden" id="ORDER_PROP_23" name="ORDER_PROP_23" class="delivery-address" value="<?=htmlspecialcharsbx( $arResult["ORDER_DATA"]["ORDER_PROP"][23] )?>">
			<input type="hidden" id="ORDER_PROP_49" name="ORDER_PROP_49" class="delivery-address" value="<?=htmlspecialcharsbx( $arResult["ORDER_DATA"]["ORDER_PROP"][23] )?>">
			<? /*			<input type="hidden" id="ORDER_PROP_22" name="ORDER_PROP_22" class="delivery-zip" value="<?=htmlspecialcharsbx($_REQUEST[ "ORDER_PROP_22" ] ?: $arResult[ "ORDER_DATA" ][ "ORDER_PROP" ][ 22 ])?>">*/
			?>
			<? if ($_REQUEST["cur_step"] == 2): ?>
				<input type="hidden" id="ORDER_PROP_21" name="ORDER_PROP_21" class="delivery-location"
				       value="<?=htmlspecialcharsbx( $_REQUEST["ORDER_PROP_21"]?:$arResult["ORDER_DATA"]["ORDER_PROP"][21] )?>">
			<? endif; ?>
			<? //write($arResult, "a+");
			?>
			<? if ($_POST["is_ajax_post"] == "Y") die; ?>
		</form>
	</div>

<? elseif
($arResult['REDIRECT_URL']):
	$_SESSION['BX_NEW_ORDER'] = true;
	?>
	<script type="text/javascript">window.top.location.href = '<?=CUtil::JSEscape( $arResult['REDIRECT_URL'] )?>';</script>
<? elseif ( !empty( $arResult['ORDER'] )): ?>

	<? include \Bitrix\Main\Application::getDocumentRoot() . $this->__folder . "/cart_thanks.php"; ?>

<? endif; ?>
