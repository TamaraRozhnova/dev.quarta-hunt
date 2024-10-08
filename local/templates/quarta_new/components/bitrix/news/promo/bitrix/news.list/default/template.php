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
$this->setFrameMode(true);
?>
<div class="promo-list">
    <? if ($arParams["DISPLAY_TOP_PAGER"]): ?>
        <?= $arResult["NAV_STRING"] ?><br/>
    <? endif; ?>
    <? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
        <div class="row promo__item <?= time() > strtotime($arItem['FIELDS']["DATE_ACTIVE_TO"]) ? 'item-disable' : '' ?>"
             id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="col-12 col-md-6">
                <? if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arItem["PREVIEW_PICTURE"])): ?>
                    <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="preview_picture__wrapper"><img
                                    class="preview_picture"
                                    border="0"
                                    src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                    width="100%"
                                    alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                    title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                            /></a>
                    <? else: ?>
                        <img
                                class="preview_picture"
                                border="0"
                                src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                width="100%>"
                                alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                        />
                    <? endif; ?>
                <? endif; ?>
            </div>
            <div class="col-12 col-md-6 promo__item-body">
                <div class="promo__item-body-inner">
                    <? if ($arParams["DISPLAY_DATE"] != "N" && $arItem["DISPLAY_ACTIVE_FROM"]): ?>
                        <small> с <? echo $arItem["DISPLAY_ACTIVE_FROM"] ?>
                            по <? echo date('d.m.Y', strtotime($arItem['FIELDS']["DATE_ACTIVE_TO"])) ?></small>
                    <? endif ?>
                    <? if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
                        <h3><? echo $arItem["NAME"] ?></h3>
                    <? endif; ?>
                    <? if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
                        <p class="promo__item-preview-text">
                            <? echo $arItem["PREVIEW_TEXT"]; ?>
                        </p>
                    <? endif; ?>
                    <? if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arItem["PREVIEW_PICTURE"])): ?>
                        <div style="clear:both"></div>
                    <? endif ?>
                    <!--                    --><? // foreach ($arItem["FIELDS"] as $code => $value): ?>
                    <!--                        <small>-->
                    <!--                            -->
                    <? //= GetMessage("IBLOCK_FIELD_" . $code) ?><!--:&nbsp;--><? //= $value; ?>
                    <!--                        </small><br/>-->
                    <!--                    --><? // endforeach; ?>
                    <? foreach ($arItem["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>
                        <small>
                            <?= $arProperty["NAME"] ?>:&nbsp;
                            <? if (is_array($arProperty["DISPLAY_VALUE"])): ?>
                                <?= implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]); ?>
                            <? else: ?>
                                <?= $arProperty["DISPLAY_VALUE"]; ?>
                            <? endif ?>
                        </small><br/>
                    <? endforeach; ?>
                </div>
                <div class="promo__item-body-more-wrapper">
                    <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="btn btn-light px-4 bg-gray-200">Читать
                        подробнее</a>
                </div>
            </div>
        </div>
    <? endforeach; ?>
    <? if ($arParams["DISPLAY_BOTTOM_PAGER"] && !empty(trim($arResult["NAV_STRING"]))): ?>
        <div class="list__pagination">
            <?= $arResult["NAV_STRING"] ?>
        </div>
    <? endif; ?>
</div>
