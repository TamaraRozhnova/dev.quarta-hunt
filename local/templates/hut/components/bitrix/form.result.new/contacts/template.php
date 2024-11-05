<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;
?>

<form id="form" class="contacts-form" data-form-id="<?= $arResult['arForm']['ID'] ?>">
    <div class="input__container input--full-name input--required">
        <label for="full-name" class="form-label">
            <?= Loc::getMessage('CONTACT_FIO') ?>
        </label>
        <input
            id="full-name"
            type="text"
            class="form-control input"
            placeholder="<?= Loc::getMessage('CONTACT_FIO_PLACEHOLDER') ?>"
            data-field-id="form_<?= $arResult['CONTROLS'][0]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][0]['ID'] ?>" />
    </div>
    <div class="form__wrap-half">
        <div class="form__half">
            <div class="input__container input--email input--required">
                <label for="email" class="form-label">
                    <?= Loc::getMessage('CONTACT_EMAIL') ?>
                </label>
                <input
                    id="email"
                    type="text"
                    placeholder="<?= Loc::getMessage('CONTACT_EMAIL_PLACEHOLDER') ?>"
                    class="form-control input"
                    data-field-id="form_<?= $arResult['CONTROLS'][1]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][1]['ID'] ?>" />
            </div>
        </div>

        <div class="input__container form__half">
            <div class="input--phone input--required">
                <label for="phone" class="form-label">
                    <?= Loc::getMessage('CONTACT_PHONE') ?>
                </label>
                <input
                    id="phone"
                    type="text"
                    class="form-control input"
                    placeholder="+7"
                    data-field-id="form_<?= $arResult['CONTROLS'][2]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][2]['ID'] ?>" />
            </div>
        </div>
    </div>
    <div class="input__container textarea--letter input--required">
        <label for="letter" class="form-label">
            <?= Loc::getMessage('CONTACT_QUESTION') ?>
        </label>
        <textarea
            id="letter"
            rows="3"
            class="form-control"
            placeholder="<?= Loc::getMessage('CONTACT_QUESTION_PLACEHOLDER') ?>"
            data-field-id="form_<?= $arResult['CONTROLS'][3]['FIELD_TYPE'] . '_' . $arResult['CONTROLS'][3]['ID'] ?>"></textarea>
    </div>
    <button type="submit" class="button contacts__submit">
        <?= Loc::getMessage('CONTACT_SEND') ?>
    </button>
    <div class="contacts-form__agree">
        <?= Loc::getMessage('CONTACT_AGREE') ?>
    </div>
</form>