<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die;
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

Loc::loadMessages(__FILE__); ?>

<?php if ($arResult['FORM_DESCRIPTION']) : ?>
    <h2><?= $arResult['FORM_DESCRIPTION'] ?></h2>
<?php endif; ?>
<div class="opt-form-block">
    <div class="opt-form-container">
        <div class="subtitle-form-block">
            <?= Loc::getMessage('SUBTITLE_FORM') ?>
        </div>
        <?php if ($arResult['isFormNote'] != 'Y') : ?>
            <?= $arResult['FORM_HEADER'] ?>
            <div class="form-opt-block">
                <?php if ($arResult['isFormErrors']) : ?>
                    <div class="errors-form-block">
                        <?= $arResult['FORM_ERRORS_TEXT'] ?>
                    </div>
                <?php endif; ?>
                 <div class="questions-block-form">
                     <?php foreach ($arResult['QUESTIONS'] as $questionId => $question) : ?>
                        <?php if (
                            $questionId === 'FIO' ||
                            $questionId === 'PHONE'
                         ) : ?>
                            <div class="inline-question-block">
                        <?php endif; ?>
                        <div class="question-block">
                            <label class="question-label" for="form_text_<?= $question['STRUCTURE'][0]['ID'] ?>">
                                <?= $question['CAPTION'] ?> <span><?= $question['REQUIRED'] === 'Y' ? '*' : '' ?></span>
                            </label>
                            <?php if ($question['STRUCTURE'][0]['FIELD_TYPE'] === 'text') : ?>
                                <input
                                    id="form_text_<?= $question['STRUCTURE'][0]['ID'] ?>"
                                    type="text" class="inputtext"
                                    name="form_text_<?= $question['STRUCTURE'][0]['ID'] ?>"
                                    placeholder="<?= $question['PLACEHOLDER'] ?: $question['CAPTION'] ?>"
                                    <?= $question['REQUIRED'] === 'Y' ? 'required' : '' ?>
                                >
                            <?php else : ?>
                                <?= $question['HTML_CODE'] ?>
                            <?php endif; ?>
                        </div>
                        <?php if (
                            $questionId === 'WORK' ||
                            $questionId === 'EMAIL'
                        ) : ?>
                            </div>
                        <?php endif; ?>
                     <?php endforeach; ?>
                 </div>
                 <div class="form-bottom-block">
                     <input
                         type="submit"
                         name="web_form_submit"
                         value="<?= htmlspecialcharsbx(trim($arResult['arForm']['BUTTON']) == '' ?: Loc::getMessage('SEND_FORM_BTN_TEXT')) ?>"
                     >
                     <span class="privacy-text"><?= Loc::getMessage('PRIVACY_TEXT') ?></span>
                 </div>
                <?= $arResult['FORM_FOOTER'] ?>
            </div>
        <?php else : ?>
            <?= $arResult['FORM_NOTE'] ?>
        <?php endif; ?>
    </div>
</div>