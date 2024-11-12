<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

CJSCore::Init(['masked_input', 'jquery']);
?>

<div class="bx-auth-profile">
	<script type="text/javascript">
		var opened_sections = [<?
		$arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
		$arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
		if ($arResult["opened"] <> ''){
			echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
		}else{
			$arResult["opened"] = "reg";
			echo "'reg'";
		}?>];
		var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
	</script>
	<form method="post" class="form" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
		<?ShowError($arResult["strProfileError"]);?>
		<?if ($arResult['DATA_SAVED'] == 'Y'){?>
			<div class="change-success">
				<div class="change-success-text">
					<?ShowNote(GetMessage('PROFILE_DATA_SAVED'));?>
					<?ShowNote(GetMessage('PROFILE_DATA_UPDATED'));?>
				</div>
				<div class="change-close">
					<svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M16.2929 16.2929C16.6834 15.9024 17.3166 15.9024 17.7071 16.2929L23 21.5858L28.2929 16.2929C28.6834 15.9024 29.3166 15.9024 29.7071 16.2929C30.0976 16.6834 30.0976 17.3166 29.7071 17.7071L24.4142 23L29.7071 28.2929C30.0976 28.6834 30.0976 29.3166 29.7071 29.7071C29.3166 30.0976 28.6834 30.0976 28.2929 29.7071L23 24.4142L17.7071 29.7071C17.3166 30.0976 16.6834 30.0976 16.2929 29.7071C15.9024 29.3166 15.9024 28.6834 16.2929 28.2929L21.5858 23L16.2929 17.7071C15.9024 17.3166 15.9024 16.6834 16.2929 16.2929Z" fill="#9B9EA9"/>
					</svg>
				</div>
			</div>
		<?}?>
		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>" />
		<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />

		<div class="profile-block-<?= mb_strpos($arResult["opened"], "reg") === false ? "hidden" : "shown"?>" id="user_div_reg">
			<div class="profile-block-item">
				<label class="form-label"><?=GetMessage('EMAIL')?><?if($arResult["EMAIL_REQUIRED"]):?><span class="starrequired">*</span><?endif?></label>
				<span class="input__container email">
					<input type="text" class="form-control input" name="EMAIL" placeholder="<?=GetMessage('YOUR_EMAIL')?>" maxlength="255" value="<?=$arResult["arUser"]["EMAIL"]?>" />
				</span>
			</div>
			<div class="profile-block-item">
				<label class="form-label"><?=GetMessage('USER_PHONE')?><?if($arResult["PHONE_REQUIRED"]):?><span class="starrequired">*</span><?endif?></label>
				<span class="input__container phone">
					<input type="text" id="phone" class="form-control input" <?= $arResult["arUser"]["PERSONAL_PHONE"] !== ''? 'placeholder="' .$arResult['arUser']['PERSONAL_PHONE'] . '"': 'placeholder="' . GetMessage('YOUR_PHONE') . '"'?> name="PERSONAL_PHONE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
				</span>
			</div>
			<div class="profile-block-item">
				<label class="form-label"><?=GetMessage('LAST_NAME')?><?if($arResult["LAST_NAME_REQUIRED"]):?><span class="starrequired">*</span><?endif?></label>
				<span class="input__container last">
					<input type="text" class="form-control input" name="LAST_NAME" placeholder="<?=GetMessage('YOUR_LAST')?>" maxlength="255" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
				</span>
			</div>
			<div class="profile-block-item">
				<label class="form-label"><?=GetMessage('NAME')?><?if($arResult["NAME_REQUIRED"]):?><span class="starrequired">*</span><?endif?></label>
				<span class="input__container name">
					<input type="text" class="form-control input" name="NAME" placeholder="<?=GetMessage('YOUR_NAME')?>" maxlength="255" value="<?=$arResult["arUser"]["NAME"]?>" />
				</span>
			</div>
			<div class="profile-block-item">
				<label class="form-label"><?=GetMessage('SECOND_NAME')?><?if($arResult["SECOND_NAME_REQUIRED"]):?><span class="starrequired">*</span><?endif?></label>
				<span class="input__container second">
					<input type="text" class="form-control input" name="SECOND_NAME" placeholder="<?=GetMessage('YOUR_SECOND')?>" maxlength="255" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
				</span>
			</div>
			<div class="profile-block-item birthday">
				<label class="form-label"><?=GetMessage('USER_BIRTHDAY_DT')?></label>
				<span class="input__container">
					<?$APPLICATION->IncludeComponent(
						'bitrix:main.calendar',
						'personal',
						array(
							'SHOW_INPUT' => 'Y',
							'FORM_NAME' => 'form1',
							'INPUT_NAME' => 'PERSONAL_BIRTHDAY',
							'INPUT_VALUE' => $arResult["arUser"]["PERSONAL_BIRTHDAY"],
							'SHOW_TIME' => 'N'
						),
						null,
						array('HIDE_ICONS' => 'Y')
					);?>
				</span>
			</div>
			<div class="profile-block-item gender">
				<label class="form-label"><?=GetMessage('USER_GENDER')?></label>
				<span class="input__container">
					<input type="radio" name="PERSONAL_GENDER" id="M" value="M"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "M" ? " checked=\"checked\"" : ""?>><label for="M"><?=GetMessage("USER_MALE")?></label>
					<input type="radio" name="PERSONAL_GENDER" id="F" value="F"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "F" ? " checked=\"checked\"" : ""?>><label for="F"><?=GetMessage("USER_FEMALE")?></label>
				</span>
			</div>
		</div>
		<input class="button button-primary enter personal-submit-form" type="submit" name="save" value="<?=GetMessage("SAVE");?>">
	</form>
</div>