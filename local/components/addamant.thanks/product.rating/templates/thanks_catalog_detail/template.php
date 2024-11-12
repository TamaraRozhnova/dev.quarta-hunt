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
<div class="star-block">
    <div class="default-star">
        <div class="stars-block">
            <span class="rating-grade"><?= $arResult['AVERAGE_RATING'] ?></span>
            <svg width="18" height="17" viewBox="0 0 18 17" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M9 0L11.116 6.08754L17.5595 6.21885L12.4238 10.1125L14.2901 16.2812L9 12.6L3.70993 16.2812L5.5762 10.1125L0.440492 6.21885L6.88397 6.08754L9 0Z"
                    fill="var(--color-primary)" />
            </svg>
        </div>
        <a class="default-star__estimate" href="javascript:void(0);"><?= Loc::getMessage('ESTIMATE') ?></a>
    </div>
    <div class="click-star">
        <div class="stars-block">
            <?php for ($grade = 1; $grade <= 5; $grade++) : ?>
                <?php $isActive = $grade <= (int)$arResult['CURRENT_USER_RATING']['GRADE']; ?>
                <svg width="18" height="17" viewBox="0 0 18 17" fill="none"
                    class="<?= $isActive ? 'active-star-setted' : '' ?>"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 0L11.116 6.08754L17.5595 6.21885L12.4238 10.1125L14.2901 16.2812L9 12.6L3.70993 16.2812L5.5762 10.1125L0.440492 6.21885L6.88397 6.08754L9 0Z"
                        fill="var(--color-gray2)" />
                </svg>
            <?php endfor; ?>
        </div>
        <a class="click-star__cancel" href="javascript:void(0);"><?= Loc::getMessage('CANCEL') ?></a>
    </div>
</div>
<script type="text/javascript">
    BX.ready(function() {
        new BX.ProductRating(
            '<?= $this->getComponent()->getSignedParameters() ?>',
            '<?= $this->getComponent()->getName() ?>',
        );
    });
</script>