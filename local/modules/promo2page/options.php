<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

if (!$USER->isAdmin()) {
    $APPLICATION->authForm('Nope');
}

if (!Loader::includeModule('promo2page')) {
    throw new SystemException('Module promo2page is not initialized');
}

Loc::loadMessages(__FILE__);

$tabControl = new CAdminTabControl('tabControl', [
    [
        'DIV' => 'edit1',
        'TAB' => Loc::getMessage('TAB_TITLE'),
        'TITLE' => '',
    ],
]);

$instancePromo = Promo\PromoPage::getInstance();
$instancePromo::setStyles();

$optionsModule = $instancePromo->getOptionsModule();?>

<form method="post"
      action="<?php echo $APPLICATION->GetCurPage() ?>?mid=<?=htmlspecialchars($mid)?>&amp;lang=<?php echo LANG; ?>"
      enctype="multipart/form-data">
    <?php

    $tabControl->Begin();
    $tabControl->BeginNextTab();

    include __DIR__ . '/inc/begin_wrapper.php';

    foreach($optionsModule as $arOptionKey => $arOption) {
        include __DIR__ . $arOption['FILE_PATH'];
    }
    
    include __DIR__ . '/inc/begin_wrapper.php';

    $tabControl->Buttons();
    
    ?>

    <div align="left">
        <input type="hidden" name="save" value="Y">
        <input type="submit" <?php if(!$USER->IsAdmin()) echo " disabled "; ?> name="save" value="<?php echo GetMessage('MAIN_SAVE'); ?>">
    </div>

    <?php $tabControl->End(); ?>
    <?= bitrix_sessid_post(); ?>
</form>
