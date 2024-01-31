<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

    <div>
        <img style="max-width: 100%" src="<?= $templateFolder ?>/cartBannerNoDiscount.png" alt="">
    </div>
    <br><br>

<?php if ($arResult["ShowReady"] == "Y" || $arResult["ShowDelay"] == "Y" || $arResult["ShowSubscribe"] == "Y" || $arResult["ShowNotAvail"] == "Y") {
    foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
        $arHeader["name"] = (isset($arHeader["name"]) ? (string)$arHeader["name"] : '');
        if ($arHeader["name"] == '') {
            $arResult["GRID"]["HEADERS"][$id]["name"] = GetMessage("SALE_" . $arHeader["id"]);
            if ($arResult["GRID"]["HEADERS"][$id]["name"] == '')
                $arResult["GRID"]["HEADERS"][$id]["name"] = GetMessage("SALE_" . str_replace("_FORMATED", "", $arHeader["id"]));
        }
    endforeach;

    ?>
    <?php if (!$arResult['IS_LICENCE_PRODUCT']) { ?>
        <div style="text-align: center">
            <div class="promocode" style="
            filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
            border: 1px solid #E05E1F;
            border-radius: 7px;
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 130%;
            padding: 5px;
            width: 100%;
            color: #E05E1F;
            margin: 0 auto;"><?= GetMessage("TSBS_2PROMOCODE", ['#CODE#' => $arResult['PROMOCODE']]) ?></div>
        </div>
        <br><br>
    <?php } ?>

    <table class="sale_basket_small" style="
            border-collapse: collapse;
            background-color: #F9F9FA;
            border-radius: 7px;
            font-family: Arial, Helvetica, sans-serif;
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 130%;
            color: #3C3C3C;
            max-width: 90%;
            margin: 0 auto;
"><?php
    if ($arResult["ShowReady"] == "Y") {
        ?>
        <tr>
            <td style="
            padding: 23px;
            vertical-align: middle;">
                <ul style="
            list-style: none;"><?php
                    foreach ($arResult["ITEMS"]["AnDelCanBuy"] as &$v) {
                        ?>
                        <li style="
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #EEEFF3;
            padding: 30px 0;
"><?php
                        foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader) {
                            if (isset($v[$arHeader['id']]) && !empty($v[$arHeader['id']])) {
                                if (in_array($arHeader['id'], array("NAME"))) {
                                    if ('' != $v["DETAIL_PAGE_URL"]) {
                                        ?><a class="productName" style="
            font-family: Arial, Helvetica, sans-serif;
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 130%;
            color: #3C3C3C;
            text-decoration: none;
            padding: 0 12px;"  href="<?php echo $v["DETAIL_PAGE_URL"]; ?>">
                                        <?php echo $v[$arHeader['id']] ?>
                                        </a><?php
                                    } else {
                                        ?><span class="productName" style="
            font-family: Arial, Helvetica, sans-serif;
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 130%;
            color: #3C3C3C;
            text-decoration: none;
            padding: 0 12px;"></span><?php echo $v[$arHeader['id']] ?></span><?php
                                    }
                                } else if (in_array($arHeader['id'], array("PRICE_FORMATED"))) {
                                    ?><span class="productPrice"><?php echo $v[$arHeader['id']] ?></span><?php
                                } else if (in_array($arHeader['id'], ["DETAIL_PICTURE", "PREVIEW_PICTURE"]) && !empty($v[$arHeader['id'] . "_SRC"])) {
                                    ?>
                                    <div class="productImage" style="
            border-radius: 7px;"><img src="<?php echo $v[$arHeader['id'] . "_SRC"] ?>">
                                    </div><?php
                                } else {
                                    ?><span class="productSumm" style="
            font-family: Arial, Helvetica, sans-serif;
            font-style: normal;
            font-weight: 600;
            font-size: 16px;
            line-height: 130%;
            color: #000000;
            white-space: nowrap;"><?php echo $v[$arHeader['id']] ?></span><?php
                                }
                            }
                        }
                        ?></li><?php
                    }
                    if (isset($v))
                        unset($v);
                    ?></ul>
            </td>
        </tr>


        <?php if ('' != $arParams["PATH_TO_ORDER"]) { ?>
            <tr>
                <td align="center" style="
            padding: 23px;
            vertical-align: middle;
">
                    <a class="basket-btn" style="
            display: block;
            text-decoration: none;
            box-sizing: border-box;
            background: #004989;
            border-radius: 4px;
            color: #fff;
            padding: 12px;
            width: 100%;" href="<?= $arParams["PATH_TO_ORDER"] ?>"><?= GetMessage("TSBS_2ORDER") ?></a>
                </td>
            </tr>
        <?php }
    }
    ?></table><?php
}
?>