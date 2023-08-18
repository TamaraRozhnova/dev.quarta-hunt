<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}

?>
<div class= "bg-white pb-5">
    <div class="container pb-5">
        <div class="row pb-0">
            <div class="col-12">
                <div class="select__wrapper">
                    <div class="select select--shop" data-initial-id="<?= $arResult['ITEMS'][0]['ID'] ?>">
                        <button class="select__main btn">
                            <?= reset($arResult['ITEMS'])['ID'] ?>
                            <div class="select__options">
                                <? foreach ($arResult['ITEMS'] as $item) { ?>
                                    <div class="select__option" data-id="<?= $item['ID'] ?>" tabindex="0">
                                        <span><?= $item['NAME'] ?></span>
                                    </div>
                                <? } ?>
                            </div>
                        </button>
                    </div>
                </div>
                
                <?foreach ($arResult['ITEMS'] as $arItemIndex => $arItem):?>
                    <div data-id = "<?=$arItem['ID']?>" class = "shop-info__wrapper row <?=$arItemIndex == 0 ? "active" : null?>">
                        <div class="col-12 col-md-6">
                            <h3 class = "mb-3 mb-lg-5"><?=$arItem['NAME']?></h3>
                            <span class="contacts__shop-description">
                                <?=$arItem['PROPERTIES']['DESCRIPTION']['~VALUE']['TEXT']?>
                            </span>
                        </div>
                        <div class="shop-info__elements col-12 col-md-6">
                            <div class = "row">
                                <?foreach ($arItem['PROPERTIES'] as $arProp):?>
                                    <?if (in_array($arProp['CODE'], $arResult['SHOW_PROPERTIES']) && !empty($arProp['VALUE'])):?>
                                        <div class = "col-12 mb-3 col-md-6 d-flex mb-lg-5 justify-content-between">
                                            <?if ($arProp['CODE'] == 'EMAIL'): ?>
                                                <svg  width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path  d="M0.574002 1.286L8.074 5.315C8.326 5.45 8.652 5.514 8.98 5.514C9.308 5.514 9.634 5.45 9.886 5.315L17.386 1.286C17.875 1.023 18.337 0 17.44 0H0.521002C-0.375998 0 0.0860016 1.023 0.574002 1.286ZM17.613 3.489L9.886 7.516C9.546 7.694 9.308 7.715 8.98 7.715C8.652 7.715 8.414 7.694 8.074 7.516C7.734 7.338 0.941002 3.777 0.386002 3.488C-0.00399834 3.284 1.61606e-06 3.523 1.61606e-06 3.707V11C1.61606e-06 11.42 0.566002 12 1 12H17C17.434 12 18 11.42 18 11V3.708C18 3.524 18.004 3.285 17.613 3.489Z" fill="#808D9A"></path></svg>
                                            <?elseif($arProp['CODE'] == 'PHONE_NUMBER'):?>
                                                <svg  width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path  d="M15.7061 12.5332L12.0551 9.21369C11.8825 9.05684 11.6558 8.97318 11.4227 8.98038C11.1896 8.98759 10.9684 9.08509 10.8058 9.25231L8.65655 11.4626C8.13922 11.3638 7.09917 11.0396 6.02859 9.97172C4.958 8.90024 4.63377 7.85751 4.53767 7.34378L6.7462 5.19364C6.91363 5.03119 7.01128 4.80998 7.01848 4.57681C7.02569 4.34364 6.94189 4.11681 6.78482 3.94433L3.46619 0.294312C3.30905 0.121292 3.09065 0.0163428 2.85738 0.00175297C2.62411 -0.0128368 2.39434 0.0640823 2.21687 0.216174L0.2679 1.8876C0.112621 2.04344 0.0199401 2.25085 0.00743838 2.47049C-0.00603375 2.69503 -0.262902 8.01378 3.86137 12.1398C7.45933 15.7368 11.9662 16 13.2074 16C13.3889 16 13.5002 15.9946 13.5299 15.9928C13.7495 15.9805 13.9568 15.8874 14.1119 15.7315L15.7824 13.7816C15.9351 13.6047 16.0126 13.3751 15.9983 13.1419C15.9841 12.9086 15.8792 12.6902 15.7061 12.5332Z" fill="#808D9A"></path></svg>
                                            <?else:?>
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path  d="M8 0C10.1217 0 12.1566 0.842855 13.6569 2.34315C15.1571 3.84344 16 5.87827 16 8C16 10.1217 15.1571 12.1566 13.6569 13.6569C12.1566 15.1571 10.1217 16 8 16C5.87827 16 3.84344 15.1571 2.34315 13.6569C0.842855 12.1566 0 10.1217 0 8C0 5.87827 0.842855 3.84344 2.34315 2.34315C3.84344 0.842855 5.87827 0 8 0ZM7.5 3C7.36739 3 7.24021 3.05268 7.14645 3.14645C7.05268 3.24021 7 3.36739 7 3.5V8.5L7.008 8.59C7.02907 8.70511 7.08984 8.80919 7.17974 8.88411C7.26964 8.95903 7.38297 9.00004 7.5 9H10.5L10.59 8.992C10.7129 8.96974 10.8231 8.90225 10.8988 8.80283C10.9745 8.70341 11.0102 8.57926 10.9989 8.45482C10.9876 8.33039 10.9301 8.21469 10.8378 8.13051C10.7455 8.04633 10.6249 7.99977 10.5 8H8V3.5L7.992 3.41C7.97093 3.29489 7.91016 3.19081 7.82026 3.11589C7.73036 3.04097 7.61703 2.99996 7.5 3Z" fill="#808D9A">
                                                    </path>
                                                </svg>
                                            <?endif;?>
                                            <div class="ms-2">
                                                <h6>
                                                    <span><?=$arProp['NAME']?></span>
                                                </h6>
                                                <?if (count($arProp['VALUE']) > 1):?>
                                                    
                                                    <?foreach ($arProp['VALUE'] as $arValueCode => $arValue):?>
                                                        <p class="mb-1">
                                                            <?if ($arProp['CODE'] == 'PHONE_NUMBER'):?>
                                                                <a href="tel: <?=$arValue?>">
                                                                    <?=$arValue?>
                                                                </a>
                                                            <?elseif ($arProp['CODE'] == 'EMAIL'):?>
                                                                <a href="mailto: <?=$arValue?>">
                                                                    <?=$arValue?>
                                                                </a>
                                                            <?else:?>
                                                                
                                                                <?if ($arValueCode != 'TYPE'):?>
                                                                    <?=$arValue?>
                                                                <?endif;?>
                                                                
                                                            <?endif;?>
                                                        </p>
                                                    <?endforeach;?>

                                                <?else:?>
                                                    <p>
                                                        <?if ($arProp['CODE'] == 'PHONE_NUMBER'):?>
                                                            <a href="tel: <?=$arProp['VALUE']?>">
                                                                <?=$arProp['VALUE']?>
                                                            </a>
                                                        <?elseif ($arProp['CODE'] == 'EMAIL'):?>
                                                            <a href="mailto: <?=$arProp['VALUE']?>">
                                                                <?=$arProp['VALUE']?>
                                                            </a>
                                                        <?else:?>
                                                            <span><?=$arProp['VALUE']?></span>
                                                        <?endif;?>
                                                    </p>
                                                <?endif;?>
                                            </div>
                                        </div>
                                    <?endif;?>
                                <?endforeach;?>
                            </div>
                        </div>
                    </div>
                <?endforeach;?>

                <div class = "shop-maps">
                    <?foreach ($arResult['ITEMS'] as $arMapIndex => $arMap):?>

                        <?if ($arMapIndex >= 1):?>
                            <?break?>
                        <?endif?>

                        <div data-id = <?=$arMap['ID']?> class = "shop-map active">
                            <?=$arMap['PROPERTIES']['IFRAME_YA_MAP']['~VALUE']?>
                        </div>  
                    <?endforeach;?>                       
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    const shops = <?= CUtil::PhpToJSObject($arResult['ITEMS']) ?>;
</script>
