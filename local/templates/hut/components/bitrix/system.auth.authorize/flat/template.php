<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

CJSCore::Init(['masked_input', 'jquery']);

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$this->setFrameMode(false); ?>

<div id="auth" class="modal">
	<div class="bx-authform-wrap mb-4">
		<div class="">
			<div class="bx-authform-container">
				<div class="bx-authform">
					<?
					if (!empty($arParams["~AUTH_RESULT"])):
						$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
					?>
						<div class="alert alert-danger"><?= nl2br(htmlspecialcharsbx($text)) ?></div>
					<? endif ?>

					<?
					if ($arResult['ERROR_MESSAGE'] <> ''):
						$text = str_replace(array("<br>", "<br />"), "\n", $arResult['ERROR_MESSAGE']);
					?>
						<div class="alert alert-danger"><?= nl2br(htmlspecialcharsbx($text)) ?></div>
					<? endif ?>

					<div class="auth__title"><?= GetMessage("AUTH_PLEASE_AUTH") ?></div>


					<form name="form_auth_phone" id="form_auth_phone" method="post" enctype="multipart/form-data" action="">
						<?= bitrix_sessid_post() ?>
						<div class="bx-authform-formgroup-container phone">
							<label class="bx-authform-label-container form-label">
								<? echo GetMessage("AUTH_LOGIN_PHONE") ?>
							</label>
							<div class="bx-authform-input-container input--lg">
								<input type="text" class="phone-input input form-control" placeholder="+7 (___) ___-__-__" name="USER_PHONE" maxlength="255" value="" />
								<div class="error_message"></div>
							</div>
						</div>
						<div class="bx-authform-formgroup-container code" style="display:none">
							<label class="bx-authform-label-container form-label">
								<? echo GetMessage("AUTH_LOGIN_CODE") ?>
							</label>
							<div class="bx-authform-input-container input--lg">
								<input id="input_sms_code" type="text" class="input form-control" name="CODE" maxlength="255" value="" placeholder="<?= GetMessage("YOUR_CODE") ?>" />
								<div class="error_message"></div>
							</div>
						</div>
						<? if ($arResult["CAPTCHA_CODE"]): ?>
							<div class="register-capthca-auth" style="display: none">
								<div class="">
									<label for="" class="form-label">
										<?= GetMessage("AUTH_CAPTCHA_PROMT") ?>:<span class="starrequired">*</span>
									</label>
								</div>
								<div class="">
									<input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>" />
									<img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180" height="40" alt="CAPTCHA" />
								</div>
								<div class="">
									<input class="form-control" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
									<div class="error_message"></div>
								</div>
							</div>
						<? endif; ?>
						<div class="bx-authform-formgroup-container">
							<input type="submit" class="button button-primary form_auth_phone hover_1" name="send_account_info" value="<?= GetMessage("AUTH_LOGIN_PHONE_SUBMIT") ?>" />
							<input type="submit" class="button button-primary login_auth_phone hover_1" style="display:none" name="send_account_info" value="<?= GetMessage("AUTH_AUTHORIZE") ?>" />
							<input type="submit" class="button button-secondary more_code_phone hover_2" style="display:none" name="send_account_info" value="<?= GetMessage("AUTH_LOGIN_MORE_CODE") ?>" />
						</div>
					</form>

					<form name="form_auth" id="form_auth" style="display:none" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>">

						<input type="hidden" name="AUTH_FORM" value="Y" />
						<input type="hidden" name="TYPE" value="AUTH" />
						<? if ($arResult["BACKURL"] <> ''): ?>
							<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>" />
						<? endif ?>
						<? foreach ($arResult["POST"] as $key => $value): ?>
							<input type="hidden" name="<?= $key ?>" value="<?= $value ?>" />
						<? endforeach ?>

						<div class="bx-authform-formgroup-container au-email-login">
							<label class="bx-authform-label-container form-label ">
								<?= GetMessage("AUTH_LOGIN") ?>
							</label>
							<div class="bx-authform-input-container">
								<input type="text" class="form-control input" name="USER_LOGIN" maxlength="255" value="<?= $arResult["LAST_LOGIN"] ?>" placeholder="<?= GetMessage("YOUR_MAIL") ?>" />
							</div>
						</div>
						<div class="bx-authform-formgroup-container au-email-password">
							<label class="bx-authform-label-container form-label">
								<?= GetMessage("AUTH_PASSWORD") ?>
							</label>
							<div class="bx-authform-input-container">
								<? if ($arResult["SECURE_AUTH"]): ?>
									<div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none">
										<div class="bx-authform-psw-protected-desc"><span></span>
											<? echo GetMessage("AUTH_SECURE_NOTE") ?>
										</div>
									</div>

									<script type="text/javascript">
										document.getElementById('bx_auth_secure').style.display = '';
									</script>
								<? endif ?>
								<input type="password" class="form-control input" name="USER_PASSWORD" maxlength="255" autocomplete="off" />
							</div>
						</div>

						<div class="bx-authform-formgroup-container au-email-login-btn">
							<input type="submit" class="button button-primary enter hover_1" name="Login" value="<?= GetMessage("AUTH_AUTHORIZE") ?>" />
						</div>
					</form>

					<? if ($arParams["NOT_SHOW_LINKS"] != "Y"): ?>
						<noindex>
							<a
								style="display: none;"
								class="button button-secondary foggot_pass hover_2"
								href="<?= $arResult["AUTH_FORGOT_PASSWORD_URL"] ?>" rel="nofollow">
								<?= GetMessage("AUTH_FORGOT_PASSWORD_2") ?>
							</a>
						</noindex>
					<? endif ?>

					<a
						style="display:none"
						href="#"
						class="button button-secondary auth_phone_form hover_2">
						<?= GetMessage("AUTH_PHONE_FORM") ?>
					</a>

					<a
						href="#"
						class="button button-secondary auth_email_form hover_2">
						<?= GetMessage("AUTH_EMAIL_FORM") ?>
					</a>

					<? if ($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"): ?>
						<noindex>
							<a class="button button-secondary reg hover_2" href="#">
								<?= GetMessage("AUTH_REGISTER") ?>
							</a>
						</noindex>
					<? endif ?>
				</div>

				<div class="auth__or"><span>или</span></div>

				<? if ($arResult["AUTH_SERVICES"]): ?>
					<?
					$APPLICATION->IncludeComponent(
						"bitrix:socserv.auth.form",
						"flat",
						array(
							"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
							"AUTH_URL" => $arResult["AUTH_URL"],
							"POST" => $arResult["POST"],
						),
						$component,
						array("HIDE_ICONS" => "Y")
					);
					?>
				<? endif ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	<? if ($arResult["LAST_LOGIN"] <> ''): ?>
		try {
			document.form_auth.USER_PASSWORD.focus();
		} catch (e) {}
	<? else: ?>
		try {
			document.form_auth.USER_LOGIN.focus();
		} catch (e) {}
	<? endif ?>
</script>