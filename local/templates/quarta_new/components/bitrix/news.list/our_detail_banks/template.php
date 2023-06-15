<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
/** @var CBitrixComponent $component */?>

<?if (!empty($arResult['ITEMS'])):?>
    <table class="table table-striped" >
        <tbody >
            <?foreach ($arResult['ITEMS'] as $arDetailBankIndex => $arDetailBank):?>
                <?if (!empty($arDetailBank['PREVIEW_TEXT'])):?>
                    <tr >
                        <td class="w-50" ><?=$arDetailBank['NAME']?></td>
                        <td class="w-50" ><?=$arDetailBank['PREVIEW_TEXT']?></td>
                    </tr>
                <?else:?>
                    <tr >
                        <td colspan="2" >
                            <?=$arDetailBank['NAME']?>
                        </td>
                    </tr>
                <?endif;?>
            <?endforeach;?>
        </tbody>
    </table>
<?endif;?>