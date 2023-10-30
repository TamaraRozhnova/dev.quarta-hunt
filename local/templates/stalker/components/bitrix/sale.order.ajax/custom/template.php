<?php if ( !defined( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true) die();

use Spro\Image;

/**
 * @var array         $arParams
 * @var array         $arResult
 * @var CMain         $APPLICATION
 * @var CUser         $USER
 * @var SaleOrderAjax $component
 * @var string        $templateFolder
 */

$deliveryChecked = 3;

?>
<div class="main">
	<div class="checkout">
		<div class="container">
			<h1 class="section__title sm-block">
				Оформление заказа
			</h1>
			<?php if ( empty( $arResult['ORDER'] )): ?>
			<a href="/personal/cart/" class="back-button sm-flex">
				<span class="ui-swiper-button">
					<?php Image::showSVG( 'arrow-prev' ); ?>
				</span>
				Вернуться в корзину
			</a>
			<?php endif;?>
			<div class="checkout__wrapper">
				<div class="checkout__left">
					<div class="section__title">
						Оформление заказа
					</div>
					<?php if ( empty( $arResult['ORDER'] )): ?>
					<a href="/personal/cart/" class="back-button">
                        <span class="ui-swiper-button">
                            <?php Image::showSVG( 'arrow-prev' ); ?>
                        </span>
						Вернуться в корзину
					</a>
					<?php endif;?>
					<div class="checkout__block">
						<?php if (empty( $arResult['ORDER'] )): ?>
							<form action="" id="ORDER_FORM" name="ORDER_FORM" enctype="multipart/form-data">
								<?php
								if ($_POST["is_ajax_post"] == "Y")
								{
									$APPLICATION->RestartBuffer();
								}
								echo bitrix_sessid_post();
								?>
								<?php
								if ( !empty( $arResult["ERROR"] ))
								{
									echo '<div style="margin-bottom: 20px">';
									foreach ($arResult["ERROR"] as $v)
									{
										ShowError( $v );
									}
									echo '</div>';
								} ?>
								<?php foreach ($arResult["PERSON_TYPE"] as $type):
									if ($type["CHECKED"] == "Y"):
										?>
										<input type="hidden" name="PERSON_TYPE" value="<?=$type["ID"]?>">
									<?php endif;
								endforeach ?>
								<input type="hidden" name="confirmorder" id="confirmorder" value="N">
								<input type="hidden" name="order_form" id="order_form" value="Y">
								<input type="hidden" name="profile_change" id="profile_change" value="Y">
								<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
								<input type="hidden" name="json" value="N">

								<?php foreach ($arResult["PAY_SYSTEM"] as $paySystem):
									if ($paySystem["CHECKED"] == "Y"):
										?>
										<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$paySystem["ID"]?>">
									<?php endif;
								endforeach ?>

								<?php include 'delivery.php' ?>
								<?php include 'order_props.php' ?>
								<?php include 'order_resume.php' ?>
								<?php if ($_POST["is_ajax_post"] == "Y")
								{
									die;
								} ?>
							</form>
						<?php elseif ( $arResult['REDIRECT_URL'] ): ?>
							<?php $_SESSION['BX_NEW_ORDER'] = true; ?>
							<script type="text/javascript">window.top.location.href = '<?=CUtil::JSEscape( $arResult['REDIRECT_URL'] )?>';</script>
						<?php elseif ( !empty( $arResult['ORDER'] )): ?>
							<?php include "cart_thanks.php"; ?>
						<?php endif; ?>
					</div>
				</div>
				<?php if ( empty( $arResult['ORDER'] )): ?>
					<?php include 'sidebar.php'; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
