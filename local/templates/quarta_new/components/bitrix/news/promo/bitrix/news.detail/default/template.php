<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>


<div class="promo-detail">
    <div class="promo-detail__top-wrapper">
        <div class="detail_picture__wrapper">
            <? if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arResult["DETAIL_PICTURE"])): ?>
                <div class="detail_picture__element"
                     style="background-image: url('<?= $arResult["PICTURE"] ?>')"></div>
            <? endif ?>
        </div>
        <div class="deteil_title__wrapper">

        </div>
        <div class="detail_title__body">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="promo-detail__title-top-inner"></div>
                        <? if ($arParams["DISPLAY_DATE"] != "N" && $arResult["DISPLAY_ACTIVE_FROM"]): ?>
                            <span class="promo-date-time">с <?= $arResult["DISPLAY_ACTIVE_FROM"] ?> по <?= date('d.m.Y', strtotime($arResult["DATE_ACTIVE_TO"])) ?></span>
                        <? endif; ?>
                        <? if ($arParams["DISPLAY_NAME"] != "N" && $arResult["NAME"]): ?>
                            <h1 class="mb-2 mb-sm-4"><?= $arResult["NAME"] ?></h1>
                        <? endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="promo-detail__body-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <? if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arResult["FIELDS"]["PREVIEW_TEXT"]): ?>
                        <p><?= $arResult["FIELDS"]["PREVIEW_TEXT"];
                            unset($arResult["FIELDS"]["PREVIEW_TEXT"]); ?></p>
                    <? endif; ?>
                    <? if ($arResult["NAV_RESULT"]): ?>
                        <? if ($arParams["DISPLAY_TOP_PAGER"]): ?><?= $arResult["NAV_STRING"] ?><br/><? endif; ?>
                        <? echo $arResult["NAV_TEXT"]; ?>
                        <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?><br/><?= $arResult["NAV_STRING"] ?><? endif; ?>
                    <? elseif ($arResult["DETAIL_TEXT"] <> ''): ?>
                        <? echo $arResult["DETAIL_TEXT"]; ?>
                    <? else: ?>
                        <? echo $arResult["PREVIEW_TEXT"]; ?>
                    <? endif ?>
                    <div style="clear:both"></div>
                    <br/>
                    <? foreach ($arResult["FIELDS"] as $code => $value):
                        if ($code === 'DATE_ACTIVE_TO')
                            continue;
                        if ('PREVIEW_PICTURE' == $code || 'DETAIL_PICTURE' == $code) {
                            ?><?= GetMessage("IBLOCK_FIELD_" . $code) ?>:&nbsp;<?
                            if (!empty($value) && is_array($value)) {
                                ?><img border="0" src="<?= $value["SRC"] ?>" width="<?= $value["WIDTH"] ?>"
                                       height="<?= $value["HEIGHT"] ?>"><?
                            }
                        } else {
                            ?><?= GetMessage("IBLOCK_FIELD_" . $code) ?>:&nbsp;<?= $value; ?><?
                        }
                        ?><br/>
                    <?endforeach;
                    foreach ($arResult["DISPLAY_PROPERTIES"] as $pid => $arProperty):?>

                        <?= $arProperty["NAME"] ?>:&nbsp;
                        <? if (is_array($arProperty["DISPLAY_VALUE"])): ?>
                            <?= implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]); ?>
                        <? else: ?>
                            <?= $arProperty["DISPLAY_VALUE"]; ?>
                        <? endif ?>
                        <br/>
                    <?endforeach;
                    if (array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y") {
                        ?>
                        <div class="news-detail-share">
                            <noindex>
                                <?
                                $APPLICATION->IncludeComponent("bitrix:main.share", "", array(
                                    "HANDLERS" => $arParams["SHARE_HANDLERS"],
                                    "PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
                                    "PAGE_TITLE" => $arResult["~NAME"],
                                    "SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
                                    "SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                                    "HIDE" => $arParams["SHARE_HIDE"],
                                ),
                                    $component,
                                    array("HIDE_ICONS" => "Y")
                                );
                                ?>
                            </noindex>
                        </div>
                        <?
                    }
                    ?>
                    <p><a class="btn btn-light px-4 bg-gray-200" href="<?=$arParams['RETURN_PATH']?>"><?=GetMessage("T_NEWS_DETAIL_BACK")?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>