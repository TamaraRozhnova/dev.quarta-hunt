<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */?>


<?if (!empty($arResult['PRODUCTS'])):?>
	<div class = "reviews-cabinet__wrapper">
		<div class="reviews-cabinet__inner">
			<div class="reviews-cabinet">
				<div class="reviews-cabinet__forms">
					<?foreach ($arResult['PRODUCTS'] as $arProductID => $arProduct):?>
						<?if ($arProduct['REVIEW_SEND'] != 'Y'):?>
							<div class="reviews-cabinet__form">
								<div class="reviews-cabinet__form-header">
									<span><?=$arProduct['NAME']?></span>
								</div>
								<form id = "<?=$arProduct['ID']?>">
									<?foreach ($arResult['FORM_FIELDS'] as $arFormFieldCode => $arFormField):?>
										<div 
											class="reviews-cabinet__form-group
											<?=
											$arFormFieldCode == 'RATING' 
												? "is-rating"
												: null
											?>
											<?=
											$arFormFieldCode == 'FILE_UPLOAD' 
												? "is-uploading"
												: null
											?>
											">

											<div class="reviews-cabinet__form-label">
												<span><?=$arFormField['TEXT']?></span>
											</div>

											<?if ($arFormFieldCode == 'RATING'):?>
												
												<div class="reviews-cabinet__form-star-wrapper">
													<?for ($i=0; $i < 5; $i++):?>
														<div data-value = <?=$i + 1?> class="reviews-cabinet__form-star star">
															<svg data-v-1926a9ff="" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill">
																<path data-v-1926a9ff="" d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
																</path>
															</svg>
														</div>
													<?endfor;?>
												</div>

												<div class="reviews-cabinet__form-star-label">
													<span></span>
												</div>

											<?elseif ($arFormFieldCode == 'FILE_UPLOAD'):?>

												<div class="uploading-wrapper-main-container">
													<div class="reviews-cabinet__form-uploading-wrapper uploading-wrapper">
														<div class="reviews-cabinet__form-uploading-icon">
															<svg width="10" height="17" fill="none" xmlns="http://www.w3.org/2000/svg" class="">
																<path d="M6.375 0a3.542 3.542 0 013.542 3.542v8.5a4.958 4.958 0 11-9.917 0V6.375h1.417v5.667a3.542 3.542 0 007.083 0v-8.5a2.125 2.125 0 10-4.25 0v8.5a.708.708 0 001.417 0V4.25h1.416v7.792a2.125 2.125 0 11-4.25 0v-8.5A3.542 3.542 0 016.375 0z" fill="currentColor"></path>
															</svg>
														</div>
														<div class="reviews-cabinet__form-uploading-text">
															<span><?=$arFormField['TEXT']?></span>
														</div>

														<input accept="image/png, image/jpg, image/jpeg" name="images" class="file-input" multiple="multiple" size="5242880" type="file">

													</div>

													<div class="reviews-cabinet__form-uploading-files-container">
														<div class="reviews-cabinet__form-uploading-files-text">
															<span>Добавленные файлы:</span>
														</div>
														<div class="reviews-cabinet__form-uploading-files">
															
														</div>
													</div>
												</div>

											<?else:?>
												<div class="reviews-cabinet__form-input">
													<textarea name="<?=$arFormField['NAME']?>" id="" rows="3"></textarea>
												</div>
											<?endif;?>
										</div>
									<?endforeach;?>
									<div class="reviews-cabinet__form-btn">
										<a href="">Опубликовать отзыв</a>
									</div>
								</form>
							</div>
						<?else:?>
							<div class="reviews-cabinet__form reviews-cabinet__form-header-wrapper">
								<div class="reviews-cabinet__form-header">
									<span><?=$arProduct['NAME']?></span>
								</div>
								<div class="reviews-cabinet__form-header-subtitle">
									<span>Вы уже оставили отзыв</span>
								</div>
							</div>
						<?endif;?>

						<?if ($arProduct != end($arResult['PRODUCTS'])):?>
							<hr>
						<?endif;?>

					<?endforeach;?>
				</div>
			</div>
		</div>
	</div>
<?endif;?>