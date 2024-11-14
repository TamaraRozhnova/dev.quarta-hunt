<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\Extension;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var string $componentPath
 */
Extension::load('addamant_thanks.global');
?>
<div class="star-block" id="prod_<?= $arParams['ELEMENT_ID'] ?>">
    <div class="default-star">
        <a class="default-star__estimate" href="javascript:void(0);" <?= count($arResult['CURRENT_USER_RATING']) ? 'style="display: none"' : '' ?>><?= Loc::getMessage('ESTIMATE') ?></a>
    </div>
    <div class="click-star <?= count($arResult['CURRENT_USER_RATING']) ? 'rated' : '' ?>">
        <div class="stars-block">
            <?php for ($grade = 1; $grade <= 5; $grade++) : ?>
                <?php $isActive = $grade <= (int)$arResult['CURRENT_USER_RATING']['GRADE']; ?>
                <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg" class="<?= $isActive ? 'active-star-setted' : '' ?>">
                    <path d="M6.18317 6.00543L1.39817 6.69918L1.31342 6.71643C1.18513 6.75049 1.06817 6.81799 0.974492 6.91203C0.880815 7.00608 0.813776 7.1233 0.78022 7.25172C0.746664 7.38015 0.747794 7.51519 0.783494 7.64303C0.819194 7.77088 0.888186 7.88697 0.983423 7.97943L4.44992 11.3537L3.63242 16.1199L3.62267 16.2024C3.61482 16.3351 3.64237 16.4675 3.70251 16.5861C3.76265 16.7046 3.85321 16.805 3.96493 16.8771C4.07664 16.9491 4.20549 16.9901 4.33828 16.996C4.47108 17.0019 4.60305 16.9723 4.72067 16.9104L9.00017 14.6604L13.2699 16.9104L13.3449 16.9449C13.4687 16.9937 13.6033 17.0086 13.7347 16.9882C13.8662 16.9679 13.9899 16.9129 14.0931 16.8289C14.1963 16.7449 14.2753 16.635 14.3221 16.5104C14.3688 16.3858 14.3815 16.2511 14.3589 16.1199L13.5407 11.3537L17.0087 7.97868L17.0672 7.91493C17.1507 7.81201 17.2055 7.68877 17.226 7.55778C17.2464 7.42678 17.2317 7.29271 17.1835 7.16923C17.1352 7.04574 17.0551 6.93725 16.9513 6.85482C16.8475 6.77238 16.7236 6.71893 16.5924 6.69993L11.8074 6.00543L9.66842 1.67043C9.60653 1.54483 9.51071 1.43907 9.39182 1.36511C9.27292 1.29115 9.1357 1.25195 8.99567 1.25195C8.85565 1.25195 8.71843 1.29115 8.59953 1.36511C8.48064 1.43907 8.38482 1.54483 8.32292 1.67043L6.18317 6.00543Z" fill="var(--color-gray2)"></path>
                </svg>
            <?php endfor; ?>
        </div>
        <a class="click-star__cancel button button-secondary" href="javascript:void(0);"><?= Loc::getMessage('CANCEL') ?></a>
    </div>
</div>
<script type="text/javascript">
    BX.ready(function() {
        new BX.ProductRating(
            '<?= $this->getComponent()->getSignedParameters() ?>',
            '<?= $this->getComponent()->getName() ?>',
            'prod_<?= $arParams['ELEMENT_ID'] ?>',
        );
    });
</script>