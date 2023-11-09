<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

CJSCore::Init(['masked_input', 'jquery']);

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$this->setFrameMode(false);?>


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

					<div class="bx-authform-link-container mb-3 w-100 btn btn-primary btn-lg btn-color-inverse">
						<a href="#" class="mb-5 w-100 text-md-start auth_email_form">
							<?=GetMessage("AUTH_EMAIL_FORM")?>
						</a>
					</div>
				
				<?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"):?>
					<noindex>
						<div class="bx-authform-link-container mb-3 w-100 btn btn-primary btn-lg btn-color-inverse">
							<a href="/registration/" rel="nofollow">
								<?=GetMessage("AUTH_REGISTER")?>
							</a>
						</div>
					</noindex>
				<?endif?>

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

<div id="multi-accounts-window" class="modal">
	<div class="modal-content">
		<div class="modal-body">
			<div class="multi-accounts-header">
				<div class="multi-accounts-header-title">
					<h3><?=Loc::getMessage('MULTI_ACCOUNT_TITLE')?></h3>
				</div>
				<div class = "multi-accounts-header-subtitle">
					<span><?=Loc::getMessage('MULTI_ACCOUNT_SUBTITLE')?></span>
				</div>
			</div>
			<div class="multi-accounts-content">
				<div class = "multi-accounts-content-list">
				</div>
			</div>
		</div>

		<div class="modal__close">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
					class="bi bi-x" viewBox="0 0 16 16">
				<path
					d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
			</svg>
		</div>
	</div>	
</div>

<div id="quick-register-window" class="modal">
	<div class="modal-content">
		<div class="modal-body">
			<div class="quick-register-accounts-header">
				<div class="quick-register-accounts-header-title">
					<h3>Регистрация</h3>
				</div>
				<div class = "quick-register-accounts-header-subtitle">
					<span><?=Loc::getMessage('quick-register_ACCOUNT_SUBTITLE')?></span>
				</div>
			</div>
			<div class="quick-register-accounts-content">
				<div class="bx-authform-formgroup-container input mb-4 input--lg">
					<label class="bx-authform-label-container form-label">
						Имя
					</label>
					<div class="bx-authform-input-container input--lg">
						<input type="text" class="form-control"  name="NAME" maxlength="255" value="" />
					</div>
				</div>
				<div class="bx-authform-formgroup-container input mb-4 input--lg">
					<label class="bx-authform-label-container form-label">
						Фамилия
					</label>
					<div class="bx-authform-input-container input--lg">
						<input type="text" class="form-control"  name="LAST_NAME" maxlength="255" value="" />
					</div>
				</div>
				<hr>
				<div class="bx-authform-formgroup-container input mb-4 input--lg">
					<label class="bx-authform-label-container form-label">
						Код из смс
					</label>
					<div class="bx-authform-input-container input--lg">
						<input type="text" class="form-control"  name="SMS_CODE" maxlength="255" value="" />
					</div>
				</div>

				<div class="quick-register-warning"></div>

				<div class="bx-authform-formgroup-container">
					<div class="input-wrapper-form">
						<input 
							type="submit" 
							class="btn btn-primary btn-lg w-100 form_quick_register" 
							name="send_account_info" 
							value="Завершить регистрацию" 
						/>
					</div>
				</div>

			</div>
		</div>

		<div class="modal__close">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
					class="bi bi-x" viewBox="0 0 16 16">
				<path
					d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
			</svg>
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

