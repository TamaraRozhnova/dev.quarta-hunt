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
	<div class="container">
		<div class="row">	
		<div class="col-8">
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
			<h2>
				<svg width="12" height="13" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon">
					<path d="M3 3.079c0 1.697 1.346 3.079 3 3.079s3-1.382 3-3.08C9 1.382 7.654.001 6 .001s-3 1.38-3 3.078zM11.333 13H12v-.684c0-2.64-2.094-4.79-4.667-4.79H4.667C2.093 7.526 0 9.676 0 12.316V13h11.333z" fill="currentColor">
					</path>
				</svg>
				<?= GetMessage('main_profile');?>
			</h2>
			<?ShowError($arResult["strProfileError"]);?>
			<?if ($arResult['DATA_SAVED'] == 'Y')
				ShowNote(GetMessage('PROFILE_DATA_SAVED'));
			?>
			<?=$arResult["BX_SESSION_CHECK"]?>
			<input type="hidden" name="lang" value="<?=LANG?>" />
			<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />

			<div class="profile-block-<?= mb_strpos($arResult["opened"], "reg") === false ? "hidden" : "shown"?>" id="user_div_reg">
				<div class="col-8">
					<div class="profile-block-item input my-4">
						<label class="form-label"><?=GetMessage('USER_PHONE')?><?if($arResult["EMAIL_REQUIRED"]):?><span class="starrequired">*</span><?endif?></label>
						<span class="input__container">
							<input type="text" id="phone" class="form-control" name="PERSONAL_PHONE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
						</span>
					</div>
					<div class="profile-block-item input my-4">
						<label class="form-label"><?=GetMessage('NAME')?><?if($arResult["EMAIL_REQUIRED"]):?><span class="starrequired">*</span><?endif?></label>
						<span class="input__container">
							<input type="text" class="form-control" name="NAME" maxlength="255" value="<?=$arResult["arUser"]["NAME"]?>" />
						</span>
					</div>
					<div class="profile-block-item input my-4">
						<label class="form-label"><?=GetMessage('LAST_NAME')?><?if($arResult["EMAIL_REQUIRED"]):?><span class="starrequired">*</span><?endif?></label>
						<span class="input__container">
							<input type="text" class="form-control" name="LAST_NAME" maxlength="255" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
						</span>
					</div>
					<div class="profile-block-item input my-4">
						<label class="form-label"><?=GetMessage('EMAIL')?><?if($arResult["EMAIL_REQUIRED"]):?><span class="starrequired">*</span><?endif?></label>
						<span class="input__container">
							<input type="text" class="form-control" name="EMAIL" maxlength="255" value="<?=$arResult["arUser"]["EMAIL"]?>" />
						</span>
					</div>
				</div>
			</div>
			<input class="btn btn-primary px-5" type="submit" name="save" value="<?=GetMessage("SAVE");?>">
		</form>
		</div>
		</div>
	</div>
</div>