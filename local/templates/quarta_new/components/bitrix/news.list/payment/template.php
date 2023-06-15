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
    <?foreach ($arResult['ITEMS'] as $arPaymentIndex => $arPayment):?>

        <?
        /** 
         * У элемента проставляется опция "Выделить блок серым цветом
         * Мы выходим из блока, чтобы переопределить класс-обертку для элемента
         * и обратно возвращаемся */    
        ?>
        <?if ($arPayment['PROPERTIES']['PA_SET_GRAY']['VALUE'] == 'Y'):?>

                </div>
            </div>

            <div class="bg-gray-100 py-5 payment__section">
                <div class="container py-5">
                    
        <?endif;?>

        <?
        /** 
         * У элемента проставляется опция "Выделить блок белым цветом
         * Мы выходим из блока, чтобы переопределить класс-обертку для элемента
         * и обратно возвращаемся */    
        ?>
        <?if ($arPayment['PROPERTIES']['PA_SET_WHITE']['VALUE'] == 'Y'):?>

            <div class="bg-white pt-5 payment__section">
                <div class="container pt-5">
                    
        <?endif;?>

        <div class="row">
            <div class="col-6 payment__flex-item">
                <h2 class="mb-5">
                    <?=$arPayment['NAME']?>
                </h2> 
                <div class="payment__imgs">
                    <?if (!empty($arPayment['PROPERTIES']['PA_ICON']['VALUE'])):?>
                        <?if (count($arPayment['PROPERTIES']['PA_ICON']['VALUE']) > 1):?>
                            <?foreach ($arPayment['PROPERTIES']['PA_ICON']['VALUE'] as $arIcon):?>
                                <img src="<?=CFile::GetPath($arIcon)?>" alt="Visa">
                            <?endforeach;?>
                        <?else:?>
                            <img src="<?=CFile::GetPath($arPayment['PROPERTIES']['PA_ICON']['VALUE'])?>" alt="Visa">
                        <?endif;?>
                    <?endif;?>
                </div>
            </div> 
            <div class="col-6 pt-2 payment__flex-item">
                <?if (!empty($arPayment['PREVIEW_TEXT'])):?>
                    <?=$arPayment['PREVIEW_TEXT']?>
                <?endif;?>
            </div>
        </div>

        <?if ($arPayment['PROPERTIES']['PA_SET_GRAY']['VALUE'] == 'Y'):?>
                </div>
            </div>
        <?endif;?>

        <?if (
            $arPayment != end($arResult['ITEMS'])
            &&
            $arResult['ITEMS'][$arPaymentIndex + 1]['PROPERTIES']['PA_SET_GRAY']['VALUE'] != 'Y'
            &&
            $arResult['ITEMS'][$arPaymentIndex + 1]['PROPERTIES']['PA_SET_WHITE']['VALUE'] != 'Y'
        ):?>
            <hr>
        <?endif;?>

    <?endforeach;?>
<?endif;?>