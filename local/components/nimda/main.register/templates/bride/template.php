<?
/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var array $arParams
 * @var array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

CJSCore::Init(array("jquery"));

//echo_j($arResult);


//if (count($arResult["ERRORS"]) > 0 || !empty($arResult["MESSAGE"])) {
//    $APPLICATION->RestartBuffer();
//    echo("ERRORS");
//    die();
//}

?>

        <form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data" id="<?=$arParams["FORM_ID"]??""?>">
            <div class="auth-form-error"></div>

<!--            <input name="REGISTER[LOGIN]" type="hidden" value="1">-->
            <?
            if($arResult["BACKURL"] <> ''){
                ?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                <?
            }
            ?>
            <?
            if($arParams["FORM_ID"] <> ''){
                ?>
                <input type="hidden" name="form_id" value="<?=$arParams["FORM_ID"]?>" />
                <?
            }
            ?>
            <input type="hidden" name="AJAX-ACTION" value="REGISTER"/>
            <input type="hidden" name="TYPE" value="REGISTRATION"/>
            <input type="hidden" name="ACCOUNT_TYPE" value="BRIDE"/>
            <input type="hidden" name="GROUP_CODE" value="sv_brides"/>
            <input type="hidden" name="REGISTER[LOGIN]" value=""/>
            <input type="hidden" name="register_submit_button" value="Y"/>

            <div class="hashtag-form__field">
                <label class="hashtag-form__field-block-input">
                    <input name="REGISTER[NAME]" type="text" placeholder="Имя" required>
                    <span class="hashtag-form__field-block-input-checkbox"></span>
                </label>
            </div>

            <div class="hashtag-form__field">
                <label class="hashtag-form__field-block-input">
                    <input name="REGISTER[LAST_NAME]" type="text" placeholder="Фамилия" required>
                    <span class="hashtag-form__field-block-input-checkbox"></span>
                </label>
            </div>

            <div class="hashtag-form__field">
                <label class="hashtag-form__field-block-input">
                    <input name="REGISTER[PERSONAL_PHONE]" type="tel" placeholder="Номер телефона" required>
                    <span class="hashtag-form__field-block-input-checkbox"></span>
                </label>
            </div>

            <div class="hashtag-form__field">
                <label class="hashtag-form__field-block-input">
                    <input name="REGISTER[EMAIL]" type="email" placeholder="E-mail" required>
                    <span class="hashtag-form__field-block-input-checkbox"></span>
                </label>
            </div>

            <div class="hashtag-form__field">
                <label class="hashtag-form__field-block-input">
                    <input name="REGISTER[PASSWORD]" type="password" placeholder="Пароль" class="passwordOne" required autocomplete="false">
                    <span class="hashtag-form__field-block-input-checkbox"></span>
                </label>
            </div>

            <div class="hashtag-form__field">
                <label class="hashtag-form__field-block-input">
                    <input name="REGISTER[CONFIRM_PASSWORD]" type="password" placeholder="Подтверждение пароля" class="passwordTwo" required autocomplete="false">
                    <span class="hashtag-form__field-block-input-checkbox"></span>
                </label>
            </div>

            <?
            /* CAPTCHA */
            if ($arResult["USE_CAPTCHA"] == "Y")
            {
                ?>
                <div class="hashtag-form__field captcha captchaBlock">
                    <label class="hashtag-form__field-block-input">
                        <div class="input">
                            <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" placeholder="Символы" required />
                        </div>
                        <div class="image">
                            <div class="loaderBlock" style="background-image: url(<?=SITE_TEMPLATE_PATH?>/img/ajax-loader.gif)"></div>
                            <input class="captchaSid" type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                            <img class="captchaImg" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                        </div>
                        <span class="hashtag-form__field-block-input-checkbox"></span>
                    </label>
                    <label class="hashtag-form__field-block-input">

                    <div class="input">
                    </div>
                    <div class="image">
                        <a class="reloadCaptcha" href="javascript:;" style="color: #D83559;">Поменять картинку</a>
                    </div>
                    </label>

                </div>
                <?
            }
            /* !CAPTCHA */
            ?>

            <?
            /* CAPTCHA *//*
            if ($arResult["USE_CAPTCHA"] == "Y")
            {
                ?>
                <tr>
                    <td colspan="2"><b><?=GetMessage("REGISTER_CAPTCHA_TITLE")?></b></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                    </td>
                </tr>
                <tr>
                    <td><?=GetMessage("REGISTER_CAPTCHA_PROMT")?>:<span class="starrequired">*</span></td>
                    <td><input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" /></td>
                </tr>
                <?

            }
            *//* !CAPTCHA */
            ?>

            <label>
                <button class="button button-primary inner-border" type="submit">Зарегистрироваться</button>
            </label>
            <label>
                <input type="checkbox" name="agree">
                <div class="modal-checkbox">Я даю <a href="https://585svadba.ru/upload/agreement.pdf" target="_blank">согласие</a> на обработку моих персональных данных, принимаю условия <a href="https://585svadba.ru/upload/terms_of_use.pdf" target="_blank">Пользовательского соглашения</a> и ознакомлен с <a href="https://585svadba.ru/upload/personal_data_processing_policy.pdf" target="_blank">Политикой</a> в отношении обработки персональных данных</div>
            </label>
        </form>
