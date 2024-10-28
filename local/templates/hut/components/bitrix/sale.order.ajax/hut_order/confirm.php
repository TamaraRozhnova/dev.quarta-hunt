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
    <div class="container">

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