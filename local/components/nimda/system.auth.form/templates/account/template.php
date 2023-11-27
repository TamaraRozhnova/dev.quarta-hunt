<?php if( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
	die();
}
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
/** @var \CBitrixComponent $component */
/** @var array $templateData */

$this->setFrameMode(true);

CJSCore::Init();

//echo_j($arResult);
?>
<?
if($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR']){
	ShowMessage($arResult['ERROR_MESSAGE']);
}
?>
	<script>
		$(function () {
			let optionsAuthForm<?=$arParams["FORM_ID"]?> = {
				errorElement : "em",
				errorPlacement : function errorPlacement(error, element) {
					error.appendTo(element.parent('label'));
				},
				rules : {
					USER_LOGIN : {
						required : true,
					},
					USER_PASSWORD : {
						required : true
					}
				},
				messages : {
					USER_LOGIN : {
						required : '',
					},
					USER_PASSWORD : {
						required : ''
					}
				},
				submitHandler : function submitHandler(form) {
					let $form = $(form);
					let login = $form.find("input[name=USER_EMAIL]").val()
					let g = $form.find("input[name=GROUP_CODE]").val();
					// $form.find("[name=USER_LOGIN]").val(login+'_'+g);
					$form.find("[name=USER_LOGIN]").val(login);

					// let login = $(form).find('[name=USER_LOGIN]').val();
					// login = login+'_'+$(".js_account_input").data("substr");
					// $(form).find('[name=USER_LOGIN]').val(login);
					//
					// console.log($(form).find('[name=USER_LOGIN]').val());

					let formData = new FormData(form);
					let authFormError = $form.find('.auth-form-error');
					let htmlRes = '';

					$.ajax($form.attr('action'), {
						type : $form.attr('method'),
						data : formData,
						processData : false,
						contentType : false,
						dataType : 'JSON',
						beforeSend : function (data) {
							htmlRes = '';
							authFormError.html(htmlRes);
						},
						success : function (data) {
							if (data.STATUS == 'ERROR' && data.MESSAGES.length > 0) {
								for (let i = 0; data.MESSAGES.length > i; i++) {
									htmlRes += `<p>${data.MESSAGES[i]}</p>`;
								}
								authFormError.html(htmlRes);
							} else {
								location.reload();
								// console.log("reload");
							}
						}, error : function (data) {
							// htmlRes += `<p>Неизвестная ошибка. Обратитесь на горячую линию!</p>`;
							// authFormError.html(htmlRes);
							location.reload();
							// console.log("reload");
						}
					});
					return false;
				}
			};
			$('#<?=$arParams["FORM_ID"]?>').bind('keyup blur click touchstart', function () {
				if ($('#<?=$arParams["FORM_ID"]?>').validate(optionsAuthForm<?=$arParams["FORM_ID"]?>).checkForm()) {
					//$('#authorization').removeClass('is-open');
				} else {
					// $('#person_submit').addClass('button_disabled').attr('disabled', true);
				}
			});
		})
	</script>
	<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>" id="<?=$arParams["FORM_ID"] ?? ""?>">
		<div class="auth-form-error"></div>
		<? if($arResult["BACKURL"] <> ''): ?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>"/>
		<? endif ?>
		<? foreach($arResult["POST"] as $key => $value): ?>
			<input type="hidden" name="<?=$key?>" value="<?=$value?>"/>
		<? endforeach ?>
		<?
		if($arParams["FORM_ID"] <> ''){
			?>
			<input type="hidden" name="form_id" value="<?=$arParams["FORM_ID"]?>"/>
			<?
		}
		?>
		<input type="hidden" name="AUTH_FORM" value="Y"/>
		<input type="hidden" name="TYPE" value="AUTH"/>
		<input type="hidden" name="AJAX-ACTION-AUTH" value="Y"/>
		<input type="hidden" name="USER_REMEMBER" value="Y"/>
		<input type="hidden" name="ACCOUNT" value="<?=$arParams["FORM_ACCOUNT"]?>"/>
		<input type="hidden" name="GROUP_CODE" value="<?=$arParams["FORM_GROUP_CODE"]?>"/>
		<input type="hidden" name="USER_LOGIN" value="">
		<script>
			BX.ready(function () {
				var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
				if (loginCookie) {
					var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
					var loginInput = form.elements["USER_LOGIN"];
					loginInput.value = loginCookie;
				}
			});
		</script>
		<label>
			<input name="USER_EMAIL" type="text" placeholder="E-mail">
			<script>
				BX.ready(function () {
					var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~EMAIL_COOKIE_NAME"])?>");
					if (loginCookie) {
						var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
						var loginInput = form.elements["USER_EMAIL"];
						loginInput.value = loginCookie;
					}
				});
			</script>
		</label>
		<label>
			<input name="USER_PASSWORD" type="password" placeholder="Пароль" required>

			<? if($arResult["SECURE_AUTH"]): ?>
				<span class="bx-auth-secure" id="bx_auth_secure<?=$arResult["RND"]?>" title="<? echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
				<noscript>
					<span class="bx-auth-secure" title="<? echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
						<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
					</span>
				</noscript>
				<script type="text/javascript">
					document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
				</script>
			<? endif ?>
		</label>
		<div style="text-align: left">
			<a class="authorization__link" id="forgetPassword" href="/accaunt/?forgot_password=yes"><b>Забыли пароль?</b></a>
		</div>
		<label>
			<button class="button button-primary inner-border" type="submit">Войти</button>
		</label>
	</form>

	<div class="authorization__phone" style="">
		<form id="auth-phone-bride-<?=$arResult["RND"]?>" class="auth-phone">
			<input type="hidden" name="ACCOUNT" value="<?=$arParams["FORM_ACCOUNT"]?>">
			<p>Авторизация по номеру телефона</p>
			<label>
				<input name="phone" type="tel" placeholder="Введите номер" required>
			</label>
			<label>
				<button class="button button-primary inner-border authorization__phone_button" type="submit">отправить код</button>
			</label>
            <div class="auth-loader hidden">
                <img src="/bitrix/wizards/aspro/max/site/templates/aspro_max/images/loaders/pl3.gif">
            </div>
			<div class="answer hidden" style="padding: 20px;font-size: 15px;"></div>
		</form>
	</div>

<? if($arResult["AUTH_SERVICES"]): ?>
	<div class="authorization__or">или</div>
	<p>Войдите с&nbsp;помощью социальных сетей</p>
	<? $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "flat", array(
			"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
			"AUTH_URL" => $arResult["AUTH_URL"],
			"POST" => $arResult["POST"],
			"POPUP" => "N",
			"SUFFIX" => "form",
		), $component, array("HIDE_ICONS" => "Y")); ?>
<? endif ?>