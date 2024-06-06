<?php if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global \CMain $APPLICATION */
/** @global \CUser $USER */
/** @global \CDatabase $DB */
/** @var \CBitrixComponent $this */
/** @var \CBitrixComponent $component */
/** @var string $epilogFile */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var array $templateData */

// check compared state
if ($arParams['DISPLAY_COMPARE'])
{
    $compared = false;
    $comparedIds = array();
    $item = $templateData['ITEM'];

    if (!empty($_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]))
    {
        if (!empty($item['JS_OFFERS']))
        {
            foreach ($item['JS_OFFERS'] as $key => $offer)
            {
                if (array_key_exists($offer['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS']))
                {
                    if ($key == $item['OFFERS_SELECTED'])
                    {
                        $compared = true;
                    }

                    $comparedIds[] = $offer['ID'];
                }
            }
        }
        elseif (array_key_exists($item['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS']))
        {
            $compared = true;
        }
    }

    if ($templateData['JS_OBJ'])
    {
        ?>
        <script>
            BX.ready(BX.defer(function(){
                if (!!window.<?=$templateData['JS_OBJ']?>)
                {
                    window.<?=$templateData['JS_OBJ']?>.setCompared('<?=$compared?>');

                    <? if (!empty($comparedIds)): ?>
                    window.<?=$templateData['JS_OBJ']?>.setCompareInfo(<?=CUtil::PhpToJSObject($comparedIds, false, true)?>);
                    <? endif ?>
                }
            }));
        </script>
        <?
    }
}