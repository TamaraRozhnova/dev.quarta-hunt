<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if ($params['ERROR']): ?>
    <b><?= $params['ERROR'] ?></b>
<? else: ?>
    <form action="<?=$params['URL']?>" method="get" id="payanyway-payment-form" style="text-align: center;">
        <?= $params['HIDDEN_FIELDS'] ?>
        <button type="submit" class="productPage-link 111" style="padding: 5px;"><?= Loc::getMessage('PAYANYWAY_PAY_BUTTON_TEXT') ?></button>
    </form>
<? endif; ?>