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
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if($arResult["SHOW_SMS_FIELD"] == true)
{
	CJSCore::Init('phone_auth');
}
?>
<div class="bx-auth-reg">

<?if($USER->IsAuthorized()):?>

<p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>

<?else:?>
<?
if (count($arResult["ERRORS"]) > 0):
	foreach ($arResult["ERRORS"] as $key => $error)
		if (intval($key) == 0 && $key !== 0) 
			$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

	ShowError(implode("<br />", $arResult["ERRORS"]));

elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
?>
<p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
<?endif?>

<?if($arResult["SHOW_SMS_FIELD"] == true):?>

<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform">
<?
if($arResult["BACKURL"] <> ''):
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
endif;
?>
<input type="hidden" name="SIGNED_DATA" value="<?=htmlspecialcharsbx($arResult["SIGNED_DATA"])?>" />
<table>
	<tbody>
		<tr>
			<td><?echo GetMessage("main_register_sms")?><span class="starrequired">*</span></td>
			<td><input size="30" type="text" name="SMS_CODE" value="<?=htmlspecialcharsbx($arResult["SMS_CODE"])?>" autocomplete="off" /></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td><input type="submit" name="code_submit_button" value="<?echo GetMessage("main_register_sms_send")?>" /></td>
		</tr>
	</tfoot>
</table>
</form>

<script>
new BX.PhoneAuth({
	containerId: 'bx_register_resend',
	errorContainerId: 'bx_register_error',
	interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
	data:
		<?=CUtil::PhpToJSObject([
			'signedData' => $arResult["SIGNED_DATA"],
		])?>,
	onError:
		function(response)
		{
			var errorDiv = BX('bx_register_error');
			var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
			errorNode.innerHTML = '';
			for(var i = 0; i < response.errors.length; i++)
			{
				errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
			}
			errorDiv.style.display = '';
		}
});
</script>

<div id="bx_register_error" style="display:none"><?ShowError("error")?></div>

<div id="bx_register_resend"></div>

<?else: ?>
<h2><?=GetMessage("AUTH_REGISTER")?></h2>

<div class="client-type">
	<a class="btn" href="/registration/">
	  Розничный покупатель
	</a> 
	<a class="btn active" href="/registration/wholesale/">
	  Оптовый клиент
	</a>
</div>
<form method="post" class="registration__form-wr col-12 col-lg-7" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
<?
if ($arResult["BACKURL"] != ''):
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
endif;
$arResult["SHOW_FIELDS"] = array(
	0 => "WORK_COMPANY",
    1 => "WORK_CITY",
    2 => "WORK_DEPARTMENT",
    3 => "NAME",
	4 => "WORK_POSITION",
	5 => "PERSONAL_PHONE",
	6 => "EMAIL",
	7 => "WORK_WWW",
	8 => "PASSWORD",
	9 => "CONFIRM_PASSWORD",
);
?>
<?foreach ($arResult["SHOW_FIELDS"] as $FIELD): ?>
	<? switch ($FIELD) {
		case "WORK_COMPANY":?>
			<div class="input mb-4 input--lg">
				<label class="form-label">
					<?=GetMessage("REGISTER_FIELD_" . $FIELD)?>:
					<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?>
						<span class="starrequired">*</span>
					<?endif?>
				</label>
				<input type="text" class="form-control" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" />
			</div>
			<?break;
		case "WORK_CITY":?>
			<div class="input mb-4 input--lg">
				<label class="form-label">
					<?=GetMessage("REGISTER_FIELD_" . $FIELD)?>:
					<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?>
						<span class="starrequired">*</span>
					<?endif?>
				</label>
				<input type="text" class="form-control" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" />
			</div>
			<?break;
		case "WORK_DEPARTMENT":?>
			<div class="input mb-4 input--lg">
				<label class="form-label">
					<?=GetMessage("REGISTER_FIELD_" . $FIELD)?>:
					<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?>
						<span class="starrequired">*</span>
					<?endif?>
					<span class="info">
						<span>
							<svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon"><path data-v-236cc743="" d="M8 16A8 8 0 108-.001 8 8 0 008 16zm.93-9.412l-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287H8.93zM8 5.5a1 1 0 110-2 1 1 0 010 2z" fill="currentColor"></path>
							</svg>
						</span> 
						<span class="tooltip" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(34px, -13px);" data-popper-placement="right">
    						Название магазина, ссылка на сайт
  						</span>
					</span>
				</label>
				<input type="text" class="form-control" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" />
			</div>
			<?break;
		case "NAME":?>
			<div class="input mb-4 input--lg">
				<label class="form-label">
					<?=GetMessage("REGISTER_FIELD_" . $FIELD)?>:
					<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?>
						<span class="starrequired">*</span>
					<?endif?>
				</label>
				<input type="text" class="form-control" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" />
			</div>
			<?break;
		case "WORK_POSITION":?>
			<div class="input mb-4 input--lg">
				<label class="form-label">
					<?=GetMessage("REGISTER_FIELD_" . $FIELD)?>:
					<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?>
						<span class="starrequired">*</span>
					<?endif?>
				</label>
				<input type="text" class="form-control" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" />
			</div>
			<?break;
		case "PERSONAL_PHONE":?>
			<div class="input mb-4 input--lg">
				<label class="form-label">
					<?=GetMessage("REGISTER_FIELD_" . $FIELD)?>:
					<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?>
						<span class="starrequired">*</span>
					<?endif?>
				</label>
				<input autocomplete="off" type="text" id="phone" class="form-control" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" placeholder="+7 (___) ___-__-__" />
			</div>
			<?break;
		case "EMAIL":?>
			<div class="input mb-4 input--lg">
				<label class="form-label">
					<?=GetMessage("REGISTER_FIELD_" . $FIELD)?>:
					<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?>
						<span class="starrequired">*</span>
					<?endif?>
				</label>
				<input type="text" class="form-control" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" placeholder="example@gmail.com" />
			</div>
			<?break;
		case "WORK_WWW":?>
			<div class="input mb-4 input--lg">
				<label class="form-label">
					<?=GetMessage("REGISTER_FIELD_" . $FIELD)?>:
					<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?>
						<span class="starrequired">*</span>
					<?endif?>
				</label>
				<input type="text" class="form-control" placeholder="http://..." name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" />
			</div>
			<?break;
		case "PASSWORD":?>
			<div class="input mb-4 input--lg">
				<label class="form-label">
					<?=GetMessage("REGISTER_FIELD_" . $FIELD)?>:
					<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?>
						<span class="starrequired">*</span>
					<?endif?>
				</label>
				<span class="password-eye"></span>
				<input type="password" class="form-control bx-auth-input" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off"  />
				<?if ($arResult["SECURE_AUTH"]): ?>
					<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
						<div class="bx-auth-secure-icon"></div>
					</span>
					<noscript>
						<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
							<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
						</span>
					</noscript>
					<script type="text/javascript">
						document.getElementById('bx_auth_secure').style.display = 'inline-block';
					</script>
				<?endif?>
			</div>
			<? break;
		case "CONFIRM_PASSWORD":?>	
			<div class="input mb-4 input--lg">
				<label class="form-label">
					<?=GetMessage("REGISTER_FIELD_" . $FIELD)?>:
					<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?>
						<span class="starrequired">*</span>
					<?endif?>
				</label>
				<span class="password-eye"></span>
				<input type="password" class="form-control" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" />
			</div>
			<? break;
	    default:?>
		
		<?
	}?>
	
<?endforeach?>
<?// ********************* User properties ***************************************************?>
<?if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y"): ?>
	<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField): 
		$UF_TYPE = false;
		if($arUserField['FIELD_NAME'] == 'UF_TYPE'){
			$arUserField['VALUE'] = 'wholesale';
			$UF_TYPE = true;
		}?>	
		<div <?= ($UF_TYPE = true)? 'style="display:none"':'' ?>>
			<?=$arUserField["EDIT_FORM_LABEL"]?>:
			<?if ($arUserField["MANDATORY"] == "Y"): ?>
				<span class="starrequired">*</span>
			<?endif;?>
		</div>
		<div <?= ($UF_TYPE = true)? 'style="display:none"':'' ?>>
			<?$APPLICATION->IncludeComponent(
    		"bitrix:system.field.edit",
    		$arUserField["USER_TYPE"]["USER_TYPE_ID"],
    		array(
				"bVarsFromForm" => $arResult["bVarsFromForm"], 
				"arUserField" => $arUserField, 
				"form_name" => "regform"), 
				null, 
				array("HIDE_ICONS" => "Y"));
				?>
		</div>
	<?endforeach;?>
<?endif;?>
<?// ******************** /User properties ***************************************************?>
<?
/* CAPTCHA */
if ($arResult["USE_CAPTCHA"] == "Y") {
    ?>
		<div class="register-capthca-auth mb-4">
			<label for="" class="form-label">
				<?=GetMessage("REGISTER_CAPTCHA_TITLE")?>
			</label>

			<div class="mb-4">
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
			</div>
			
			<div class="input mb-4 input--lg">
				<label for="" class="form-label">
					<?=GetMessage("REGISTER_CAPTCHA_PROMT")?>:<span class="starrequired">*</span>
				</label>
				<input class="form-control" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
			</div>
		</div>
	<?
}
/* !CAPTCHA */
?>
<div class="checkbox checkbox--promo form-check mb-4 wholesale__form-checkbox">
        <input id="promo" type="checkbox" class="form-check-input" checked>
        <label for="promo" class="form-check-label">
            Отправлять акции и предложения по email
        </label>
    </div>
<div>
	<input type="submit" class="btn btn-primary btn-lg w-100 mb-3" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" />
</div>
<small >
    Нажимая кнопку «Зарегистрироваться»,
    <a href="/privacy-statement/" >
      я даю свое согласие на обработку моих персональных данных.
    </a>
</small>


<?endif//$arResult["SHOW_SMS_FIELD"] == true ?>


<?endif?>
</div>
