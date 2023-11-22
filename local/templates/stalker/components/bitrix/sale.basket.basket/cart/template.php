<?php if ( !defined( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true) die();

$q = 0;

echo_j($arResult, 'cart');
?>
<div class="main">
	<div class="basket">
		<div class="container">
			<h1 class="section__title">
				Корзина
			</h1>

			<div class="basket__inner">
				<div class="basket__list">
					<div class="basket__list-head">
						<div class="basket__list-item basket__info">Товар</div>
						<div class="basket__list-item basket__price">Цена</div>
						<div class="basket__list-item basket__count">Количество</div>
						<div class="basket__list-item basket__total">Итого</div>
					</div>

					<div class="basket__body">
						<?php foreach ($arResult['ITEMS']['AnDelCanBuy'] as $index => $arItem):
							$q += $arItem['QUANTITY'];
							?>
							<div class="basket__item">
								<div class="basket__item-info basket__info">
									<div class="basket__item-img">
										<img src="<?=$arItem['DETAIL_PICTURE_SRC']?>" alt="">
									</div>
                                    <div class="basket__item-block">
                                        <div class="basket__item-text">
                                            <div class="basket__item-name">
                                                <?=$arItem['NAME']?>
                                            </div>
                                        </div>
                                        <?if(isset($arItem["arProps"])){?>
                                        <div class="catalog__item-characteristic characteristic-small">
                                            <ul class="characteristic-small__list">
                                                <?php foreach ($arItem["arProps"] as $property): ?>
                                                    <?php if($property['VALUE']):?>
                                                        <li class="characteristic-small__item">
                                                            <div class="characteristic-small__name">
                                                                <?=$property['NAME']?>
                                                            </div>
                                                            <div class="characteristic-small__empty"></div>
                                                            <div class="characteristic-small__value"><?=$property['VALUE']?></div>
                                                        </li>
                                                    <? endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>

                                        <?}?>

                                    </div>
								</div>
								<div class="basket__item-price basket__price">
									<div class="basket__item-title">
										Цена
									</div>
									<div class="price">
										<div class="price-new">
                                            <span class="value"><?=priceFormat( $arItem['PRICE'] )?> ₽</span>
										</div>
									</div>
								</div>
								<div class="basket__item-count basket__count">
									<div class="basket__item-title">
										Количество
									</div>
									<div class="card__count count">
										<div class="ui-block">
											<label class="ui-label">
												<input type="number" name="q" class="ui-input" value="<?=$arItem["QUANTITY"]?>" min="1"
													   data-basket_item="<?=$arItem["PRODUCT_ID"]?>">
											</label>
										</div>
									</div>
								</div>
								<div class="basket__item-total basket__total">
									<div class="basket__item-title">
										Итого
									</div>
									<div class="price">
										<div class="price-new">
											<span class="value"><?=priceFormat( $arItem['PRICE'] * $arItem["QUANTITY"] )?> ₽</span>
										</div>
									</div>
								</div>
								<div class="basket__remove" data-delete-basket="<?=$arItem['ID']?>">
									<?php \Spro\Image::showSVG( 'close' ); ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="basket__order order">
					<div class="order__title">
						Цена
					</div>

					<div class="order__promocode">
						<label class="ui-label">
							<?php
							$arDiscount = reset($arResult['APPLIED_DISCOUNT_LIST']);
							$coupon = $arDiscount['COUPON']['COUPON'];
							?>
							<input type="text" class="ui-input <?php if($coupon):?>promo-good<?php endif;?>" placeholder="Промокод" data-promo-input value="<?=$coupon?>"/>

						</label>
						<button class="order__promocode-apply ui-button ui-button--dark" data-promo-apply>
							<?php \Spro\Image::showSVG( 'arrow-right' ); ?>
						</button>
					</div>

					<div class="order__info">
						<div class="order__info-item">
							<div class="order__info-name">Всего <?=$q?> товара(ов)</div>
							<div class="order__info-value"><?=priceFormat($arResult['allSum']+$arResult['DISCOUNT_PRICE_ALL'])?> ₽</div>
						</div>
						<div class="order__info-item">
							<div class="order__info-name">Скидка</div>
							<div class="order__info-value"><?=priceFormat($arResult['DISCOUNT_PRICE_ALL'])?> ₽</div>
						</div>
					</div>

					<div class="order__bottom">
						<div class="order__total">
							<div class="order__total-name">
								Итого к оплате
							</div>

							<div class="order__total-value">
								<div class="price">
									<div class="price-new">
										<span class="value"><?=priceFormat($arResult['allSum'])?> ₽</span>
									</div>
								</div>
							</div>
						</div>

						<a href="/personal/order/make/" type="submit" class="ui-button ui-button--red">
							ОФОРМИТЬ ЗАКАЗ
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
