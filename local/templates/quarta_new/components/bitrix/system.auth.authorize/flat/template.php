<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */
CJSCore::Init(['masked_input', 'jquery']);
//one css for all system.auth.* forms
?>
<div class="bx-authform-wrap mb-4">
	<div class="container">
		<div class="bx-authform-container">
			<div class="bx-authform">
				<?
				if(!empty($arParams["~AUTH_RESULT"])):
					$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
				?>
					<div class="alert alert-danger"><?=nl2br(htmlspecialcharsbx($text))?></div>
				<?endif?>
				
				<?
				if($arResult['ERROR_MESSAGE'] <> ''):
					$text = str_replace(array("<br>", "<br />"), "\n", $arResult['ERROR_MESSAGE']);
				?>
					<div class="alert alert-danger"><?=nl2br(htmlspecialcharsbx($text))?></div>
				<?endif?>
				
					<h2 class="bx-title"><?=GetMessage("AUTH_PLEASE_AUTH")?></h2>
				
				<?if($arResult["AUTH_SERVICES"]):?>
				<?
				$APPLICATION->IncludeComponent("bitrix:socserv.auth.form",
					"flat",
					array(
						"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
						"AUTH_URL" => $arResult["AUTH_URL"],
						"POST" => $arResult["POST"],
					),
					$component,
					array("HIDE_ICONS"=>"Y")
				);
				?>
            
	
				<?endif?>
					<form name="form_auth_phone" id="form_auth_phone" method="post" enctype="multipart/form-data" action="">
						
						<div class="bx-authform-formgroup-container phone input mb-4 input--lg">
							<label class="bx-authform-label-container form-label">
								<?echo GetMessage("AUTH_LOGIN_PHONE")?>
							</label>
							<div class="bx-authform-input-container input--lg">
								<input type="text" id="phone" class="form-control" placeholder="+7 (___) ___-__-__" name="USER_PHONE" maxlength="255" value="" />
								<div class="error_message"></div>
							</div>
						</div>
						<div class="bx-authform-formgroup-container code input mb-4 input--lg" style="display:none">
							<label class="bx-authform-label-container form-label">
								<?echo GetMessage("AUTH_LOGIN_CODE")?>
							</label>
							<div class="bx-authform-input-container input--lg">
								<input type="text" class="form-control" name="CODE" maxlength="255" value="" />
							</div>
						</div>
						<div class="bx-authform-formgroup-container">
							<input type="submit" class="btn btn-primary btn-lg w-100 mb-3 form_auth_phone" name="send_account_info" value="<?=GetMessage("AUTH_LOGIN_PHONE_SUBMIT")?>" />
							<input type="submit" class="btn btn-primary btn-lg w-100 mb-3 login_auth_phone" style="display:none" name="send_account_info" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
							<input type="submit" class="btn btn-primary btn-lg w-100 mb-3 more_code_phone" style="display:none" name="send_account_info" value="<?=GetMessage("AUTH_LOGIN_MORE_CODE")?>" />
						</div>
					</form>

					<form name="form_auth" id="form_auth" style="display:none" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
			
						<input type="hidden" name="AUTH_FORM" value="Y" />
						<input type="hidden" name="TYPE" value="AUTH" />
				<?if ($arResult["BACKURL"] <> ''):?>
						<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<?endif?>
				<?foreach ($arResult["POST"] as $key => $value):?>
						<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
				<?endforeach?>
				
						<div class="bx-authform-formgroup-container input mb-4 input--lg">
							<label class="bx-authform-label-container form-label">
								<?=GetMessage("AUTH_LOGIN")?>
							</label>
							<div class="bx-authform-input-container">
								<input type="text" class="form-control" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
							</div>
						</div>
						<div class="bx-authform-formgroup-container input mb-4 input--lg">
							<label class="bx-authform-label-container form-label">
								<?=GetMessage("AUTH_PASSWORD")?>
							</label>
							<div class="bx-authform-input-container">
								<?if($arResult["SECURE_AUTH"]):?>
									<div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none">
										<div class="bx-authform-psw-protected-desc"><span></span>
											<?echo GetMessage("AUTH_SECURE_NOTE")?>
										</div>
									</div>
								
								<script type="text/javascript">
									document.getElementById('bx_auth_secure').style.display = '';
								</script>
								<?endif?>
								<input type="password" class="form-control" name="USER_PASSWORD" maxlength="255" autocomplete="off" />
							</div>
						</div>
				
				<?if($arResult["CAPTCHA_CODE"]):?>
						<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
				
						<div class="bx-authform-formgroup-container dbg_captha">
							<div class="bx-authform-label-container">
								<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>
							</div>
							<div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
							<div class="bx-authform-input-container">
								<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
							</div>
						</div>
				<?endif;?>
				
					<?/*if ($arResult["STORE_PASSWORD"] == "Y"):?>
						<div class="bx-authform-formgroup-container">
							<div class="checkbox">
								<label class="bx-filter-param-label form-label">
									<input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" />
									<span class="bx-filter-param-text"><?=GetMessage("AUTH_REMEMBER_ME")?></span>
								</label>
							</div>
						</div>
					<?endif*/?>
						<div class="bx-authform-formgroup-container">
							<input type="submit" class="btn btn-primary btn-lg w-100 mb-3" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
						</div>
					</form>
				
				<?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"):?>
					<noindex>
						<div class="bx-authform-link-container mb-5 w-100 text-md-left">
							<a href="/registration/" rel="nofollow">
								<?=GetMessage("AUTH_REGISTER")?>
							</a>
						</div>
					</noindex>
				<?endif?>
				<a href="#" class="mb-5 w-100 text-md-start auth_email_form">
				<?=GetMessage("AUTH_EMAIL_FORM")?>
				</a>
				<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
					<noindex>
						<div style="display:none" class="bx-authform-link-container mb-5 w-100 text-md-left foggot_pass">
							<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow">
								<?=GetMessage("AUTH_FORGOT_PASSWORD_2")?>
							</a>
						</div>
					</noindex>
				<?endif?>
				<a href="#" style="display:none" class="mb-5 w-100 text-md-left auth_phone_form">
					<?=GetMessage("AUTH_PHONE_FORM")?>
              	</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
<?if ($arResult["LAST_LOGIN"] <> ''):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>

</script>

