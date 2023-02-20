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
$FILTER_NAME = $arParams["FILTER_NAME"];
global ${$FILTER_NAME};
?>
<div class="row promo-filter">
    <div class="col-12">
        <form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>"
              method="get">
            <? foreach ($arResult["ITEMS"] as $arItem):
                if (array_key_exists("HIDDEN", $arItem)):
                    echo $arItem["INPUT"];
                endif;
            endforeach; ?>

            <? foreach ($arResult["ITEMS"] as $arItem): ?>
                <? if (stripos($arItem['INPUT_NAME'], 'DATE_ACTIVE_TO') !== false): ?>
                    <? $time = date('d.m.Y H:i:s');
                    if (empty($arItem['INPUT_VALUES'][0]) && empty($arItem['INPUT_VALUES'][1])) {
                        ${$FILTER_NAME}['>=DATE_ACTIVE_TO'] = $time;

                        $arItem['INPUT_VALUES'][0] = $time;
                    } ?>
                    <div class="promo__select-type">
                        <span class="promo-filter__title">Показать:</span>
                        <a href="javascript:void(0)"
                           class="ms-1 nuxt-link-active <?= empty($arItem['INPUT_VALUES'][0]) ? '' : 'nuxt-link-exact-active disabled' ?>"
                           data-index="1">Актуальные акции</a>
                        <a href="javascript:void(0)"
                           class="ms-1 <?= empty($arItem['INPUT_VALUES'][1]) ? '' : 'nuxt-link-exact-active nuxt-link-active disabled' ?>"
                           data-index="2">Завершенные акции</a>
                        <input type="hidden" name="<?= $arItem['INPUT_NAMES'][0] ?>"
                               value="<?= $arItem['INPUT_VALUES'][0] ?>" data-current-date="<?= $time ?>">
                        <input type="hidden" name="<?= $arItem['INPUT_NAMES'][1] ?>"
                               value="<?= $arItem['INPUT_VALUES'][1] ?>" data-current-date="<?= $time ?>">
                    </div>
                <? endif; ?>

            <? endforeach; ?>
            <input type="hidden" name="set_filter" value="Y"/>&nbsp;&nbsp;
        </form>
    </div>
</div>