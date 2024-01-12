<?php use Spro\Image;

if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global \CMain $APPLICATION */
/** @global \CUser $USER */
/** @global \CDatabase $DB */
/** @var \CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var array $templateData */
/** @var \CBitrixComponent $component */
$this->setFrameMode( true );
//echo '<pre>';
//print_r( $arResult );
//echo '</pre>';

$arPrice = reset( $arResult['ITEM_PRICES'] );

//echo_j($arResult, '$arResult');

$arPhotos = [];

if(isset($arResult['DETAIL_PICTURE']['SRC'])){
    $arPhotos[] = $arResult['DETAIL_PICTURE']['SRC'];
}
if(isset($arResult['PROPERTIES']) && isset($arResult['PROPERTIES']['MORE_PHOTO']) && isset($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])){
    foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $index => $item){
        $arPhotos[] = CFile::GetPath( $item );
    }
}


?>
<div class="card <?=($arResult['PROPERTIES']['MORE_PHOTO']['VALUE']?'js-have-slider':'')?>">
	<div class="card-left">
		<div class="card__slider">
			<?if(isset($arResult['PROPERTIES']) && isset($arResult['PROPERTIES']['MORE_PHOTO']) && isset($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])): ?>
				<div class="swiper swiper-slider">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="card__slider-img">
								<picture>
									<img class="lazy" data-src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt=""/>
								</picture>
							</div>
						</div>
						<? foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $index => $item): ?>
							<div class="swiper-slide">
								<div class="card__slider-img">
									<picture>
										<img class="lazy" data-src="<?=CFile::GetPath( $item )?>" alt=""/>
									</picture>
								</div>
							</div>
						<? endforeach; ?>
					</div>
					<div class="card__slider-navigation">
						<button class="swiper-button-prev ui-swiper-button">
							<? Image::showSVG( 'arrow-prev' ) ?>
						</button>
						<button class="swiper-button-next ui-swiper-button">
							<? Image::showSVG( 'arrow-next' ) ?>
						</button>
					</div>
				</div>
			<? elseif($arResult['DETAIL_PICTURE']['SRC']): ?>
				<img class="lazy" data-src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt=""/>
			<? else: ?>
				<img class="lazy" data-src="<?=SITE_TEMPLATE_PATH?>/img/no-photo.png" alt=""/>
			<? endif; ?>
			<div class="dot dot--top-left"></div>
			<div class="dot dot--top-right"></div>
			<div class="dot dot--bottom-left"></div>
			<div class="dot dot--bottom-right"></div>
		</div>
		<? if ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE']): ?>
			<div class="card__thumbnail">
				<div class="swiper swiper-thumbs">
					<div class="swiper-wrapper">
						<? $img = Spro\Image::ResizeImageGet( $arResult['DETAIL_PICTURE']['ID']??'0', [ 'width' => 138, 'height' => 78 ], BX_RESIZE_IMAGE_EXACT ) ?>
						<div class="swiper-slide swiper-slide-thumb">
							<div class="card__thumbnail-img">
								<picture>
									<img class="lazy" src="<?=$img['src']?>" alt=""/>
								</picture>
								<div class="dot dot--top-left"></div>
								<div class="dot dot--top-right"></div>
								<div class="dot dot--bottom-left"></div>
								<div class="dot dot--bottom-right"></div>
							</div>
						</div>
						<? foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $index => $item):
                            $img = Spro\Image::ResizeImageGet( $item??'0', [ 'width' => 138, 'height' => 78 ], BX_RESIZE_IMAGE_EXACT )
							?>
							<div class="swiper-slide swiper-slide-thumb">
								<div class="card__thumbnail-img">
									<picture>
										<img class="lazy" src="<?=$img['src']?>" alt=""/>
									</picture>
									<div class="dot dot--top-left"></div>
									<div class="dot dot--top-right"></div>
									<div class="dot dot--bottom-left"></div>
									<div class="dot dot--bottom-right"></div>
								</div>
							</div>
						<? endforeach; ?>
					</div>
				</div>
			</div>
		<? endif; ?>
	</div>

    <div class="card-right">
		<div class="card__description">
			<? if ($arPrice['DISCOUNT']): ?>
				<div class="tip tip-sale">
					-<?=$arPrice['PERCENT']?>%
				</div>
			<? endif; ?>

			<div class="card__name">
				<?=$arResult['NAME']?>
			</div>
			<div class="card__code">
				АРТ <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?>
			</div>

			<div class="card__text">
				<?=$arResult['PREVIEW_TEXT']?>
			</div>

			<div class="card__price price">

				<? if ($arPrice['DISCOUNT']): ?>
					<div class="price-new"><span class="value"><?=priceFormat( $arPrice['PRICE'] )?></span> ₽</div>
					<div class="price-old"><span class="value"><?=priceFormat( $arPrice['BASE_PRICE'] )?></span> ₽</div>
				<? else: ?>
					<div class="price-new"><span class="value"><?=priceFormat( $arPrice['PRICE'] )?></span> ₽</div>
				<? endif; ?>
			</div>

			<div class="card__actions">
				<div class="card__count count">
					<label class="ui-label">
						<input type="number" name="q" data-q class="ui-input" placeholder="Кол-во">
					</label>
					<?php /*
					<div class="select" data-select>
						<div class="select__head" data-select-head>
							<div class="select__head-value" data-select-value data-q>
								1
							</div>
							<div class="select__head-controller">
								Кол <? Image::showSVG( 'chevron-down' ) ?>
							</div>
						</div>
						<div class="select__body" data-select-body>
							<div class="select__item" data-select-item data-select-item-value="1">1</div>
							<div class="select__item" data-select-item data-select-item-value="2">2</div>
							<div class="select__item" data-select-item data-select-item-value="3">3</div>
							<div class="select__item" data-select-item data-select-item-value="4">4</div>
							<div class="select__item" data-select-item data-select-item-value="5">5</div>
							<div class="select__item" data-select-item data-select-item-value="6">6</div>
						</div>
					</div>
					*/ ?>
				</div>
				<button type="button" class="ui-button card__basket ui-button--red" data-add-basket="<?=$arResult['ID']?>">
					В корзину
				</button>
				<?php /*
				<button type="button" class="ui-button card__like ui-button--transparent" data-add-favorite="<?=$arResult['ID']?>">
					<? Image::showSVG( 'like' ) ?>
				</button>
				*/ ?>
			</div>
			<?
			$arShowProps = [
				/*'length',
				'barrel_length',
				'CO2_balloon',
				'clip',
				'CALIBER',
				'VES',*/
			];
			?>
            <?/*?>
			<div class="card__characteristic">
				<?php foreach ($arShowProps as $prop): ?>
					<?php if ($arResult['PROPERTIES'][ $prop ]['VALUE']): ?>
						<div class="card__characteristic-item">
							<div class="card__characteristic-title">
								<?=$arResult['PROPERTIES'][ $prop ]['NAME']?>
							</div>
							<div class="card__characteristic-value">
								<?=$arResult['PROPERTIES'][ $prop ]['VALUE']?>
							</div>
						</div>
					<?php endif ?>
				<?php endforeach; ?>
			</div>
            <?*/?>
			<div class="card__characteristic">
				<?php foreach ($arResult["DISPLAY_PROPERTIES"] as $prop): ?>
					<?php if (1): ?>
						<div class="card__characteristic-item">
							<div class="card__characteristic-title">
								<?=$prop['NAME']?>
							</div>
							<div class="card__characteristic-value">
								<?=$prop['VALUE']?>
							</div>
						</div>
					<?php endif ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
<div class="card-info custom-text">
	<div class="card-info__block card-info__description">
		<?=$arResult['DETAIL_TEXT']?>
	</div>

	<?php if (isset($arResult["DISPLAY_PROPERTIES"]) && is_array($arResult["DISPLAY_PROPERTIES"])): ?>
		<div class="card-info__block card-info__characteristic">
            <div class="title">Характеристики</div>
			<ul>
                <?/*?>
				<?
				$detailProps = [
					'CALIBER',
					'BULLET',
					'VES',
					'length',
					'barrel_length',
					'CO2_balloon',
					'clip',
				];
				?>
				<?php foreach ($arResult['SHOW_PROPS'] as $prop): ?>
					<?php if ($arResult['PROPERTIES'][ $prop ]['VALUE']): ?>
						<li>
							<div class="name">
								<?=$arResult['PROPERTIES'][ $prop ]['NAME']?>
							</div>
							<div class="empty"></div>
							<div class="value"><?=$arResult['PROPERTIES'][ $prop ]['VALUE']?></div>
						</li>
					<?php endif ?>
				<?php endforeach; ?>
                <?*/?>
				<?php foreach ($arResult["DISPLAY_PROPERTIES"] as $prop): ?>
					<?php if (1): ?>
						<li>
							<div class="name"><?=$prop['NAME']?></div>
							<div class="empty"></div>
							<div class="value"><?=$prop['VALUE']?></div>
						</li>
					<?php endif ?>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif ?>
	<?php if ($arResult['PROPERTIES']['review_video']['VALUE']): ?>
		<div class="card-info__block section section-media">
			<div class="section-media__head">
				<h2 class="section__title">
					Обзор
				</h2>
			</div>

			<div class="section-media__body">
				<div class="section-media__video video">
					<div class="video-block">
						<img class="lazy" data-src="https://img.youtube.com/vi/<?=$arResult['PROPERTIES']['review_video']['VALUE']?>/maxresdefault.jpg" alt=""/>
					</div>
					<div class="video-btn">
						<a href="https://www.youtube.com/watch?v=<?=$arResult['PROPERTIES']['review_video']['VALUE']?>" target="_blank">
							<? Image::showSVG( 'play' ) ?>
						</a>
					</div>
				</div>
				<div class="section-media__description">
					<div class="play">
						<? Image::showSVG( 'play' ) ?>
					</div>

					<?php if ($arResult['PROPERTIES']['review_title']['VALUE']): ?>
						<h3 class="section__title">
							<?=$arResult['PROPERTIES']['review_title']['VALUE']?>
						</h3>
					<?php endif ?>

					<?php if ($arResult['PROPERTIES']['review_subtitle']['VALUE']): ?>
						<div class="section__text">
							<?=$arResult['PROPERTIES']['review_subtitle']['VALUE']?>
						</div>
					<?php endif ?>

					<a href="https://www.youtube.com/watch?v=<?=$arResult['PROPERTIES']['review_video']['VALUE']?>" target="_blank" class="ui-button ui-button--dark">
						Смотреть
					</a>
				</div>
			</div>

		</div>
	<?php endif ?>

	<div class="card-info__block card-info__review review">
		<h2>Отзывы</h2>

        <?
//        echo_j($arResult['REVIEWS'], '$arResult[REVIEWS]');
        ?>

		<?if ($arResult['REVIEWS']): ?>
			<div class="swiper">
				<div class="swiper-wrapper">
					<?foreach ($arResult['REVIEWS'] as $arReview):

                        $stars = 0;
                        if(isset($arReview['PROPERTY_STARS_VALUE'])){
                            $stars = $arReview['PROPERTY_STARS_VALUE'];
                        }
                        ?>
						<div class="swiper-slide">
							<div class="review-item">
								<div class="review-item__wrapper">
									<div class="review-item__head">
										<div class="review-item__title">
											<?=$arReview['NAME']?>
										</div>
										<div class="review-item__stars">
                                            <div class="stars-wrapper">
                                                <div class="stars stars-<?=$stars?>"></div>
                                            </div>
										</div>
									</div>

									<div class="review-item__body">
										<div class="review-item__img">

											<?php if (isset($arReview['PREVIEW_PICTURE'])): ?>
												<? $img = Spro\Image::ResizeImageGet( $arReview['PREVIEW_PICTURE'], [ 'width' => 138, 'height' => 78 ] ) ?>
												<img class="lazy" data-src="<?=$img['src']?>" alt=""/>
											<? else: ?>
												<? Image::showSVG( 'camera', 'review-camera' ) ?>
											<?php endif ?>

											<div class="dot dot--top-left"></div>
											<div class="dot dot--top-right"></div>
											<div class="dot dot--bottom-left"></div>
											<div class="dot dot--bottom-right"></div>
										</div>
										<div class="review-item__text">
											<p>
												<?=$arReview['PREVIEW_TEXT']?>
											</p>
										</div>
									</div>
								</div>
								<time class="review-item__date">
									<?
									[ $date, $time ] = explode( ' ', $arReview['ACTIVE_FROM'] );
									?>
									<?=$date?>
								</time>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
		<?php endif ?>

		<button class="ui-button ui-button--dark" data-modal-open="reviews">
			Оставить отзыв
		</button>
	</div>
</div>
