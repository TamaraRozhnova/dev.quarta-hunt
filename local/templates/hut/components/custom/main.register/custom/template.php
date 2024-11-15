<?

/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */
CJSCore::Init(['masked_input', 'jquery']);
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

if ($arResult["SHOW_SMS_FIELD"] == true) {
	CJSCore::Init('phone_auth');
}
?>
<div id="reg" class="modal bx-auth-reg">

	<? if ($USER->IsAuthorized()): ?>

		<p><? echo GetMessage("MAIN_REGISTER_AUTH") ?></p>

	<? else: ?>
		<?
		if (count($arResult["ERRORS"]) > 0):
			foreach ($arResult["ERRORS"] as $key => $error) {
				if (intval($key) == 0 && $key !== 0) {
					$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;" . GetMessage("REGISTER_FIELD_" . $key) . "&quot;", $error);
				}
			}

			ShowError(implode("<br />", $arResult["ERRORS"]));

		elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
		?>
			<p><? echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT") ?></p>
		<? endif ?>

		<? if ($arResult["SHOW_SMS_FIELD"] == true): ?>

			<form method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regform">
				<?
				if ($arResult["BACKURL"] != ''):
				?>
					<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>" />
				<?
				endif;
				?>
				<input type="hidden" name="SIGNED_DATA" value="<?= htmlspecialcharsbx($arResult["SIGNED_DATA"]) ?>" />
				<table>
					<tbody>
						<tr>
							<td><? echo GetMessage("main_register_sms") ?><span class="starrequired">*</span></td>
							<td><input type="text" name="SMS_CODE" value="<?= htmlspecialcharsbx($arResult["SMS_CODE"]) ?>" autocomplete="off" /></td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td></td>
							<td><input type="submit" name="code_submit_button" value="<? echo GetMessage("main_register_sms_send") ?>" /></td>
						</tr>
					</tfoot>
				</table>
			</form>

			<script>
				new BX.PhoneAuth({
					containerId: 'bx_register_resend',
					errorContainerId: 'bx_register_error',
					interval: <?= $arResult["PHONE_CODE_RESEND_INTERVAL"] ?>,
					data: <?= CUtil::PhpToJSObject([
								'signedData' => $arResult["SIGNED_DATA"],
							]) ?>,
					onError: function(response) {
						var errorDiv = BX('bx_register_error');
						var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
						errorNode.innerHTML = '';
						for (var i = 0; i < response.errors.length; i++) {
							errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
						}
						errorDiv.style.display = '';
					}
				});
			</script>

			<div id="bx_register_error" style="display:none"><? ShowError("error") ?></div>

			<div id="bx_register_resend"></div>

		<? else: ?>

			<div class="reg__title"><?= GetMessage("AUTH_REGISTER") ?></div>

			<div class="reg__form">

				<form method="post" class="registration__form-wr col-12 col-lg-7" action="<?= POST_FORM_ACTION_URI ?>" name="regform" enctype="multipart/form-data">
					<?
					if ($arResult["BACKURL"] != ''):
					?>
						<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>" />
					<?
					endif;
					$arResult["SHOW_FIELDS"] = array(
						0 => "PERSONAL_PHONE",
						1 => "EMAIL",
						2 => "NAME",
						4 => "LAST_NAME",
						5 => "PASSWORD",
						6 => "CONFIRM_PASSWORD",
					);
					?>

					<? foreach ($arResult["SHOW_FIELDS"] as $FIELD): ?>

						<? switch ($FIELD) {
							case "PERSONAL_PHONE": ?>
								<div class="re-phone-reg">
									<label class="form-label">
										<?= GetMessage("REGISTER_FIELD_" . $FIELD) ?>:
									</label>
									<input autocomplete="off" type="text" class="input reg-phone-input form-control" name="REGISTER[<?= $FIELD ?>]" value="<?= $arResult["VALUES"][$FIELD] ?>" placeholder="+7 (___) ___-__-__" />
								</div>
							<? break;
							case "NAME": ?>
								<div class="re-name-reg">
									<label class="form-label">
										<?= GetMessage("REGISTER_FIELD_" . $FIELD) ?>:
									</label>
									<input type="text" class="input form-control" name="REGISTER[<?= $FIELD ?>]" value="<?= $arResult["VALUES"][$FIELD] ?>" placeholder="<?= GetMessage("REGISTER_FIELD_NAME_PLACEHOLDER") ?>" />
								</div>
							<? break;
							case "LAST_NAME": ?>
								<div class="re-last-name-reg">
									<label class="form-label">
										<?= GetMessage("REGISTER_FIELD_" . $FIELD) ?>:
									</label>
									<input type="text" class="input form-control" name="REGISTER[<?= $FIELD ?>]" value="<?= $arResult["VALUES"][$FIELD] ?>" placeholder="<?= GetMessage("REGISTER_FIELD_LAST_NAME_PLACEHOLDER") ?>" />
								</div>
							<? break;
							case "EMAIL": ?>
								<div class="re-email-reg">
									<label class="form-label">
										<?= GetMessage("REGISTER_FIELD_" . $FIELD) ?>:
									</label>
									<input type="text" class="input form-control" name="REGISTER[<?= $FIELD ?>]" value="<?= $arResult["VALUES"][$FIELD] ?>" placeholder="username@mail.ru" />
								</div>
							<? break;
							case "PASSWORD": ?>
								<div class="re-pass-reg">
									<label class="form-label">
										<?= GetMessage("REGISTER_FIELD_" . $FIELD) ?>:
									</label>
									<span class="password-eye"></span>
									<input type="password" class="input form-control bx-auth-input" name="REGISTER[<?= $FIELD ?>]" value="<?= $arResult["VALUES"][$FIELD] ?>" autocomplete="off" />
									<? if ($arResult["SECURE_AUTH"]): ?>
										<span class="bx-auth-secure" id="bx_auth_secure" title="<? echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
											<div class="bx-auth-secure-icon"></div>
										</span>
										<noscript>
											<span class="bx-auth-secure" title="<? echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
												<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
											</span>
										</noscript>
										<script type="text/javascript">
											document.getElementById('bx_auth_secure').style.display = 'inline-block';
										</script>
									<? endif ?>
								</div>
							<? break;
							case "CONFIRM_PASSWORD": ?>
								<div class="re-conf-pass-reg">
									<label class="form-label">
										<?= GetMessage("REGISTER_FIELD_" . $FIELD) ?>:
									</label>
									<span class="password-eye"></span>
									<input type="password" class="input form-control" name="REGISTER[<?= $FIELD ?>]" value="<?= $arResult["VALUES"][$FIELD] ?>" autocomplete="off" />
								</div>
							<? break;
							default: ?>

						<?
						} ?>


					<? endforeach ?>
					<? // ********************* User properties ***************************************************
					?>
					<? if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y"): ?>
						<? foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):
							$UF_TYPE = false;
							if ($arUserField['FIELD_NAME'] == 'UF_TYPE') {
								$arUserField['VALUE'] = 'retail';
								$UF_TYPE = true;
							} ?>
							<div <?= ($UF_TYPE = true) ? 'style="display:none"' : '' ?>>
								<?= $arUserField["EDIT_FORM_LABEL"] ?>:
								<? if ($arUserField["MANDATORY"] == "Y"): ?>
									<span class="starrequired">*</span>
								<? endif; ?>
							</div>
							<div <?= ($UF_TYPE = true) ? 'style="display:none"' : '' ?>>
								<? $APPLICATION->IncludeComponent(
									"bitrix:system.field.edit",
									$arUserField["USER_TYPE"]["USER_TYPE_ID"],
									array(
										"bVarsFromForm" => $arResult["bVarsFromForm"],
										"arUserField" => $arUserField,
										"form_name" => "regform"
									),
									null,
									array("HIDE_ICONS" => "Y")
								);
								?>
							</div>
						<? endforeach; ?>
					<? endif; ?>
					<? // ******************** /User properties ***************************************************
					?>
					<?
					/* CAPTCHA */
					if ($arResult["USE_CAPTCHA"] == "Y") {
					?>
						<div class="register-capthca-auth mb-4" style="display: none">
							<label for="" class="form-label">
								<?= GetMessage("REGISTER_CAPTCHA_TITLE") ?>
							</label>

							<div class="mb-4">
								<input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>" />
								<img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180" height="40" alt="CAPTCHA" />
							</div>

							<div class="">
								<label for="" class="form-label">
									<?= GetMessage("REGISTER_CAPTCHA_PROMT") ?>:<span class="starrequired">*</span>
								</label>
								<input class="form-control" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
							</div>
						</div>
					<?
					}
					/* !CAPTCHA */
					?>
			</div>

			<div class="reg__bottom">
				<div>
					<input type="submit" class="reg-submit-form button button-primary" name="register_submit_button" value="<?= GetMessage("AUTH_REGISTER") ?>" />
				</div>
				<div class="reg__agree">
					<?= GetMessage("AGREE", array("#LINK#" => "/policy/")) ?>
				</div>
				<a href="#auth" class="reg__back button button-secondary" rel="modal:open"><?= GetMessage("BACK") ?></a>
			</div>

		<? endif ?>
	<? endif ?>
</div>