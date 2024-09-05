<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<div class="subscribe-form" id="subscribe-form">
	<?
	$frame = $this->createFrame("subscribe-form", false)->begin();
	?>
	<div class="subscribe-form__title"><?= GetMessage("subscr_form_title") ?></div>
	<form action="<?= $arResult["FORM_ACTION"] ?>">

		<? foreach ($arResult["RUBRICS"] as $itemID => $itemValue): ?>
			<label class="subscribe__label" for="sf_RUB_ID_<?= $itemValue["ID"] ?>">
				<input type="checkbox" name="sf_RUB_ID[]" id="sf_RUB_ID_<?= $itemValue["ID"] ?>" value="<?= $itemValue["ID"] ?>" <? if ($itemValue["CHECKED"]) echo " checked" ?> /> <?= $itemValue["NAME"] ?>
			</label>
		<? endforeach; ?>
		<input required class="input white subscribe__input" type="email" name="sf_EMAIL" size="20" value="<?= $arResult["EMAIL"] ?>" placeholder="<?= GetMessage("subscr_form_email_title") ?>" title="<?= GetMessage("subscr_form_email_title") ?>" />
		<input class="button subscribe__submit" type="submit" name="OK" value="<?= GetMessage("subscr_form_button") ?>" /></td>
	</form>
	<div class="subscribe-form__agree"><?= GetMessage("subscr_form_agree") ?></div>
	<?
	$frame->beginStub();
	?>
	<form action="<?= $arResult["FORM_ACTION"] ?>">
		<? foreach ($arResult["RUBRICS"] as $itemID => $itemValue): ?>
			<label for="sf_RUB_ID_<?= $itemValue["ID"] ?>">
				<input type="checkbox" name="sf_RUB_ID[]" id="sf_RUB_ID_<?= $itemValue["ID"] ?>" value="<?= $itemValue["ID"] ?>" /> <?= $itemValue["NAME"] ?>
			</label><br />
		<? endforeach; ?>
		<input class="subscribe__input" required type="text" name="sf_EMAIL" size="20" value="" placeholder="<?= GetMessage("subscr_form_email_title") ?>" title="<?= GetMessage("subscr_form_email_title") ?>" /></td>
		<input class="button subscribe__submit" type="submit" name="OK" value="<?= GetMessage("subscr_form_button") ?>" /></td>
	</form>
	<?
	$frame->end();
	?>
</div>
<div id="subscribe_result" style="display: none">
	<div class="subscribe_result__text">
		<svg style="display: none" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
			<rect width="40" height="40" rx="20" fill="#171A1F" />
			<path fill-rule="evenodd" clip-rule="evenodd" d="M28.7071 14.2929C29.0976 14.6834 29.0976 15.3166 28.7071 15.7071L18.7071 25.7071C18.3166 26.0976 17.6834 26.0976 17.2929 25.7071L12.2929 20.7071C11.9024 20.3166 11.9024 19.6834 12.2929 19.2929C12.6834 18.9024 13.3166 18.9024 13.7071 19.2929L18 23.5858L27.2929 14.2929C27.6834 13.9024 28.3166 13.9024 28.7071 14.2929Z" fill="white" />
		</svg>
		<p class="subscribe_result__title"></p>
		<p class="subscribe_result__subtitle"></p>
	</div>
</div>