<div class="modal modal-reviews" data-modal="reviews">
	<div class="modal__inner" data-modal-inner="reviews">
		<div class="modal__main">
			<div class="modal__header">
				<div class="modal__title">Оставить отзыв</div>
				<div class="modal__close modal__close--in-header" data-modal-close="reviews">
					<svg class="icon icon-close">
						<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-close"></use>
					</svg>
				</div>
			</div>
			<div class="modal__content">
				<div class="modal-reviews__form">
					<div data-form-result></div>
					<form data-ajax-form>

						<input type="hidden" name="action" value="WebForm/addReview">
						<input type="hidden" name="afterCallback" value="afterSubmitReview">
						<input type="hidden" name="productID" value="<?=$GLOBALS['CATALOG_CURRENT_ELEMENT_ID']?>">
						<input type="text" name="name" class="form-group__input form-group__input--right-indent" placeholder="Ваше имя" data-required="">
						<input type="text" name="email" class="form-group__input" placeholder="Ваш e-mail" data-input-email="" data-required="">
						<div id="file-drag" class="files-preview-wrapper">
							<div class="files-preview-wrapper__container">
								<label class="file-input-mini" for="modal-input">
									<svg class="icon icon-plus">
										<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-plus"></use>
									</svg>
								</label>
							</div>
							<label class="file-input file-input--all-wight">
								<input id="modal-input" type="file" name="file" accept=".jpg, .jpeg, .png" data-file-list="">
								<span class="file-input__icon">
									<svg class="icon icon-camera">
									  <use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-camera"></use>
									</svg>
								</span>
								<span class="file-input__text-help"> Перетащите файлы сюда или нажмите для выбора </span>
								<span class="file-input__text-format"> jpg, jpeg, png <br> менее 10 MB </span>
							</label>
						</div>
						<textarea type="text" name="message" class="form-group__textarea" placeholder="Ваш отзывы" data-required=""></textarea>
						<div class="form-group--flex">
							<button type="submit" class="btn-sbm">Отправить</button>
							<div> Кликнув на <span>"Отправить"</span>, Вы соглашаетесь на обработку ваших персональных данных и с правилами комментирования</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
