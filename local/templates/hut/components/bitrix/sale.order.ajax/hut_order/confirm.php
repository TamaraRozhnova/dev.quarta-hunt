<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();   
}

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

?>

<?php if (!empty($arResult['ORDER'])): ?>
    <div class="confirm-order">
        <div class="circle-icon">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M33.8302 11.032C34.3052 11.507 34.3052 12.277 33.8302 12.752L17.614 28.9682C17.139 29.4432 16.369 29.4432 15.894 28.9682L7.78591 20.8601C7.31095 20.3851 7.31095 19.6151 7.78591 19.1401C8.26087 18.6651 9.03094 18.6651 9.5059 19.1401L16.754 26.3882L32.1102 11.032C32.5852 10.557 33.3553 10.557 33.8302 11.032Z" fill="white"/>
            </svg>
        </div>
        <h3><?= Loc::getMessage('CONFIRM_ORDER_TITLE') ?></h3>
        <p class="status-order-text"><?= Loc::getMessage('STATUS_ORDER_TEXT') ?></p>
        <div class="buttons-block-order">
            <a href="/catalog/" class="catalog-link">
                <?= Loc::getMessage('CATALOG_TEXT') ?>
            </a>
            <a href="/personal/" class="personal-link">
                <?= Loc::getMessage('PERSONAL_TEXT') ?>
            </a>
        </div>
    </div>
<?php else: ?>

	<b><?=Loc::getMessage('SOA_ERROR_ORDER')?></b>
	<br /><br />

	<table class='sale_order_full_table'>
		<tr>
			<td>
				<?=Loc::getMessage('SOA_ERROR_ORDER_LOST', ['#ORDER_ID#' => htmlspecialcharsbx($arResult['ACCOUNT_NUMBER'])])?>
				<?=Loc::getMessage('SOA_ERROR_ORDER_LOST1')?>
			</td>
		</tr>
	</table>

<?php endif ?>