<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
global $APPLICATION;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Engine\CurrentUser;

/**
 * $arResult=[
 *   PRODUCT_ID => int
 *   user => [NAME,PHONE, EMAIL]
 *
 *
 * ];
 */

CUtil::InitJSCore(array('interlabs_oneclick_popup'));

?>
<div class="interlabs-oneclick__container" id="interlabs-oneclick__container"        
     style="<?php if ( (isset($arResult['success']) && isset($arResult['success']['message'])) || (isset($arResult['validateErrors']) && count($arResult['validateErrors']) > 0) ) {
     } else {
         echo 'display:none;';
     } ?>">
    <div class="interlabs-oneclick__container__dialog modal-mask">
        <div class="modal-wrapper">
            <div class="modal-container">                 
                <div class="header">
                    <label><?php echo Loc::getMessage("buy_in_1_click") ?></label>
                    <span class="js-interlabs-oneclick__dialog__close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                        </svg>
                    </span>
                </div>
                <div class="body">
                    <div class="errors common js-step-1"
                         style="<?php if (isset($arResult['success']) && isset($arResult['success']['message'])) {
                             echo 'display:none;';
                         } ?>">
                        <?php if (isset($arResult['validateErrors']) && count($arResult['validateErrors']) > 0) {
                            foreach ($arResult['validateErrors'] as $error) {
                                echo "<div>{$error['message']}</div>";
                            } ?>
                        <?php } ?>
                    </div>
                    <form action="" class="js-step-1" method="post" enctype="multipart/form-data" onsubmit=""
                          style="<?php if (isset($arResult['success']) && isset($arResult['success']['message'])) {
                              echo 'display:none;';
                          } ?>">
                        <!--<input name="ONE_CLICK_JSON" value="Y" type="hidden"/>-->
                        <input name="PRODUCT_ID" value="<?php echo $arResult['PRODUCT_ID']; ?>" type="hidden"/>
                        <input name="interlabs__oneclick" value="Y" type="hidden"/>
                        <input type="hidden" name="IS_AUTHORIZED" value="<?=CurrentUser::get()->getId()?>">
                        <input type="hidden" name="MULTIUSER" value="">
                        <input type="hidden" name="MULTIUSER_ID" value="">
                        <input type="hidden" name="MORDOR" value="">
                        <div class="form-group">
                            <label><?php echo Loc::getMessage("fio"); ?><span class="bx-authform-starrequired">*</span></label>
                            <input name="NAME" type="text" class="form-control"
                                   value="<?php echo Oneclick::reqInputByProduct("NAME", $arResult['user']['NAME'], $arResult['PRODUCT_ID']); ?>" required>
                            <div class="error error-NAME"></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo Loc::getMessage("phone"); ?><span class="bx-authform-starrequired">*</span></label>
                            <input id="click_phone" name="PHONE" type="text" class="form-control"
                                   value="<?php echo Oneclick::reqInputByProduct("PHONE", $arResult['user']['PHONE'], $arResult['PRODUCT_ID']); ?>" required>
                            <div class="error error-PHONE"></div>
                        </div>
                        <?php if ($arResult['USE_FIELD_EMAIL'] === 'Y') { ?>
                            <div class="form-group">
                                <label><?php echo Loc::getMessage("email"); ?><span class="bx-authform-starrequired">*</span></label>
                                <input name="EMAIL" type="text" class="form-control"
                                       value="<?php echo Oneclick::reqInputByProduct("EMAIL", $arResult['user']['EMAIL'], $arResult['PRODUCT_ID']); ?>" required>
                                <div class="error error-EMAIL"></div>
                            </div>
                        <?php } ?>

                        <?php if ($arParams['USE_CAPTCHA'] === 'Y' && !CurrentUser::get()->getId()) { ?>                            
                            <div class="register-capthca-auth mb-4">
                                <div class="input input--lg">
									<label for="" class="form-label">
										<?=GetMessage("CAPTCHA_ENTER_CODE")?><span class="starrequired">*</span>
									</label>									
								</div>
								<div class="mb-2">
									<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
									<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
								</div>								
								<div class="input mb-4 input--lg">									
									<input class="form-control" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
									<div class="error_message"></div>
								</div>
							</div>
                        <?php } ?>

                        <?php if ($arResult['USE_FIELD_COMMENT'] === 'Y') { ?>
                            <div class="form-group">
                                <label><?php echo Loc::getMessage("comment"); ?></label>
                                <textarea class="form-control"
                                        name="COMMENT"><?php echo Oneclick::reqInputByProduct("COMMENT", '', $arResult['PRODUCT_ID']); ?></textarea>
                                <div class="error error-COMMENT"></div>
                            </div>
                        <?php } ?>

                        <?php if ($arResult['AGREE_PROCESSING'] === 'Y') {
                            $AGREE_PROCESSING_TEXT_dialog_CSS_ID = 'AGREE_PROCESSING_TEXT_dialog' . uniqid('AGREE_PROCESSING_TEXT_dialog');
                            ?>
                            <div class="form-group agree">
                                <div class="c-checkbox">
                                    <input id="AGREE_PROCESSING" name="AGREE_PROCESSING" value="Y"
                                           type="checkbox" required>
                                    <label for="AGREE_PROCESSING"><?php echo Loc::getMessage("AGREE_PROCESSING"); ?>
                                        <span
                                                class="field-required">*</span></label>
                                </div>

                                <?php if ($arResult['AGREE_PROCESSING_TEXT']) { ?>
                                    <div id="<?php echo $AGREE_PROCESSING_TEXT_dialog_CSS_ID; ?>"
                                         class="interlabs__info-dialog hidden">
                                        <div class="header">
                                            <label><?php echo Loc::getMessage("AGREE_PROCESSING_DIALOG_TITLE"); ?></label>
                                            <span class="close-dialog"
                                                  onclick="document.getElementById('<?php echo $AGREE_PROCESSING_TEXT_dialog_CSS_ID; ?>').className+=' hidden '">
                                         <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                              xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L17 17" stroke="#8B8989" stroke-width="2" stroke-linecap="round"/>
                    <path d="M1 17L17 1" stroke="#8B8989" stroke-width="2" stroke-linecap="round"/>
                </svg>
                                    </span>
                                        </div>
                                        <div class="body">
                                            <div class="form-group scroll-area">
                                                <?php echo $arResult['AGREE_PROCESSING_TEXT']; ?>

                                            </div>
                                            <div class="form-group">
                                                <a class="btn btn-close"
                                                   onclick="document.getElementById('<?php echo $AGREE_PROCESSING_TEXT_dialog_CSS_ID; ?>').className+=' hidden '"><?php echo Loc::getMessage("close"); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <a onclick="document.getElementById('<?php echo $AGREE_PROCESSING_TEXT_dialog_CSS_ID; ?>').className=document.getElementById('<?php echo $AGREE_PROCESSING_TEXT_dialog_CSS_ID; ?>').className.replace('hidden','')">
                                        <?php echo Loc::getMessage("AGREE_PROCESSING_DIALOG_TITLE"); ?>
                                    </a>
                                <?php } else if ($arResult['AGREE_PROCESSING_FILE']) { ?>
                                    <a class="AGREE_PROCESSING_FILE__link"
                                       href=" <?php echo $arResult['AGREE_PROCESSING_FILE']["SRC"]; ?>"
                                       target="_blank">
                                        <?php echo $arResult['AGREE_PROCESSING_FILE']["FILE_NAME"]; ?>
                                    </a>
                                <?php } ?>
                                <div class="error error-AGREE_PROCESSING"></div>
                            </div>
                        <?php } ?>


                        <div class="form-group control-buttons">                            
                            <button class="btn btn-primary btn-lg js-interlabs-oneclick__dialog__send-button"
                                    href="javascript:void(0);"
                                    onclick="ym(30377432,'reachGoal','js-interlabs-oneclick__dialog__send-button'); return true;"
                                    type="submit">
                                <?php echo Loc::getMessage('send'); ?>
                            </button>
                        </div>

                        <small>                            
                            <?=Loc::getMessage('AGREEMENT', ['#LINK#' => '/privacy-statement/'])?>
                            <?=Loc::getMessage('OFERTA', ['#LINK#' => '/about/oferta/'])?>
                        </small>

                    </form>
                    <div class="js-interlabs-oneclick__result js-step-2">
                        <?php if (isset($arResult['success']) && isset($arResult['success']['message'])) {
                            echo $arResult['success']['message'];
                        } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/include/multi_account_modal.php', [], [])?>
<?php if (count($_POST) > 0 && isset($_POST['AJAX_CALL'])) { ?>
    <script type="text/javascript">
        if (typeof window['interlabsOneClickComponentApp'] === 'function') {
            interlabsOneClickComponentApp();
        }
    </script>
<?php } ?>




