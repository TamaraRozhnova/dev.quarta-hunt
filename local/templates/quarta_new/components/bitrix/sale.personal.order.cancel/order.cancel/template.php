<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}

/** @var array $arResult */

?>

<div class="bx-order-cancel">
	<?php
	if($arResult["ERROR_MESSAGE"] == ''):
	?>
		<form method="post" action="<?=POST_FORM_ACTION_URI?>">
			<input type="hidden" name="CANCEL" value="Y">
			<?=bitrix_sessid_post()?>
			<input type="hidden" name="ID" value="<?=$arResult["ID"]?>">
			<div class="form-group">
				<textarea hidden value = " " name="REASON_CANCELED" class="form-control" id="orderCancel" rows="3"></textarea>
			</div>
			<input type="submit" name="action" class="btn btn-danger cancel-order btn btn-secondary btn-lg px-5 text-white" value="<?=GetMessage("SALE_CANCEL_ORDER_BTN") ?>">
		</form>
	<?php
	endif;
	?>
</div>
