<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */

//one css for all system.auth.* forms
CJSCore::Init(['masked_input', 'jquery']);
?>

<div class="bx-forgot-wrap mb-4">
	<div class="container">
		<div class="bx-forgot-container">
			<div class="bx-forgot">
				<? if(!empty($arParams["~AUTH_RESULT"])):
					$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);?>
					<div class="alert <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
				<?endif?>
			
				<h2 class="bx-title"><?=GetMessage("AUTH_GET_CHECK_STRING")?></h2>
				
				<div class="type">
					<button class="btn px-sm-5 py-sm-2 active forgot_email_form">По Email</button>
					<button class="btn px-sm-5 py-sm-2 forgot_phone_form">По номеру телефона</button>
				</div>

				<form name="bform" id="form_forgot" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
				<?if($arResult["BACKURL"] <> ''):?>
					<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<?endif?>
					<input type="hidden" name="AUTH_FORM" value="Y">
					<input type="hidden" name="TYPE" value="SEND_PWD">
			
					<div class="bx-authform-formgroup-container input input--lg w-100">
						<label class="bx-authform-label-container form-label">
							<?echo GetMessage("AUTH_LOGIN_EMAIL")?>
						</label>
						<div class="bx-authform-input-container">
							<input type="text" class="form-control" name="USER_LOGIN" maxlength="255" value="<?=$arResult["USER_LOGIN"]?>" />
							<input type="hidden" name="USER_EMAIL" />
						</div>
					</div>
			
				<?if($arResult["PHONE_REGISTRATION"]):?>
					<div class="bx-authform-formgroup-container">
						<div class="bx-authform-label-container">
							<?echo GetMessage("forgot_pass_phone_number")?>
						</div>
						<div class="bx-authform-input-container">
							<input type="text" name="USER_PHONE_NUMBER" maxlength="255" value="<?=$arResult["USER_PHONE_NUMBER"]?>" />
						</div>
						<div class="bx-authform-note-container">
							<?echo GetMessage("forgot_pass_phone_number_note")?>
						</div>
					</div>
				<?endif?>
			
				<?if ($arResult["USE_CAPTCHA"]):?>
					<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
			
					<div class="bx-authform-formgroup-container">
						<div class="bx-authform-label-container"><?echo GetMessage("system_auth_captcha")?></div>
						<div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
						<div class="bx-authform-input-container">
							<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
						</div>
					</div>
				<?endif?>

					<div class="bx-authform-formgroup-container">
						<input type="submit" class="btn btn-primary my-4 w-100 recovery__btn" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
					</div>
				</form>

				<form name="bform-phone" id="form_forgot_phone" method="post" enctype="multipart/form-data" action="">
					<div class="bx-authform-formgroup-container phone input input--lg w-100">
						<label class="bx-authform-label-container form-label">
							<?echo GetMessage("FOGGOT_PHONE")?>
						</label>
						<div class="bx-authform-input-container">
							<input type="text" id="phone" class="form-control" placeholder="+7 (___) ___-__-__" name="USER_PHONE" maxlength="255" value="" />
							<div class="error_message"></div>
						</div>
					</div>
					<div class="bx-authform-formgroup-container code input mb-4 input--lg" style="display:none">
						<label class="bx-authform-label-container form-label">
							<?echo GetMessage("FOGGOT_CODE")?>
						</label>
						<div class="bx-authform-input-container code">
							<input type="text" class="form-control" name="CODE" maxlength="255" value="" />
						</div>
					</div>
					<div class="bx-authform-formgroup-container">
						<input type="submit" class="btn btn-primary my-4 w-100 recovery_btn_phone" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
document.bform.onsubmit = function(){document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;};
document.bform.USER_LOGIN.focus();
</script>
