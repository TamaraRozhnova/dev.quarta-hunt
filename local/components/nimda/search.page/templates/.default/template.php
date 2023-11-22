<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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

//echo_r($arResult);
?>

<div class="page_not search-page">
  <div class="d_text">
  <div class="catalog__top">
    <form method="get" action="" autocomplete="off">
      <div class="catalog__search ajaxsearch__wrapper" id="ajaxsearch_id_page">
        <input type="text" class="input js-q ajaxsearch__input" placeholder="Введите название или код товара" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" autocomplete="off">
      </div>
      <button class="btn" type="submit">Найти</button>
      <input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
      <input type="hidden" name="search" value="1" />
    </form>
  </div>

<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
	?>
	<div class="search-language-guess">
		<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
	</div><br /><?
endif;?>
  </div>
</div>

<? 
// print '<pre>'; print_r($arResult); die(); print '</pre>'; 
?>

<? if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false): ?>
  
  <? elseif($arResult["ERROR_CODE"]!=0): ?>

    <div class="page_not">
      <div class="d_text">
        <p><?=GetMessage("SEARCH_ERROR")?></p>
        <?ShowError($arResult["ERROR_TEXT"]);?>
        <p><?=GetMessage("SEARCH_CORRECT_AND_CONTINUE")?></p>
        <br /><br />
        <p><?=GetMessage("SEARCH_SINTAX")?><br /><b><?=GetMessage("SEARCH_LOGIC")?></b></p>
        <table border="0" cellpadding="5">
          <tr>
            <td align="center" valign="top"><?=GetMessage("SEARCH_OPERATOR")?></td><td valign="top"><?=GetMessage("SEARCH_SYNONIM")?></td>
            <td><?=GetMessage("SEARCH_DESCRIPTION")?></td>
          </tr>
          <tr>
            <td align="center" valign="top"><?=GetMessage("SEARCH_AND")?></td><td valign="top">and, &amp;, +</td>
            <td><?=GetMessage("SEARCH_AND_ALT")?></td>
          </tr>
          <tr>
            <td align="center" valign="top"><?=GetMessage("SEARCH_OR")?></td><td valign="top">or, |</td>
            <td><?=GetMessage("SEARCH_OR_ALT")?></td>
          </tr>
          <tr>
            <td align="center" valign="top"><?=GetMessage("SEARCH_NOT")?></td><td valign="top">not, ~</td>
            <td><?=GetMessage("SEARCH_NOT_ALT")?></td>
          </tr>
          <tr>
            <td align="center" valign="top">( )</td>
            <td valign="top">&nbsp;</td>
            <td><?=GetMessage("SEARCH_BRACKETS_ALT")?></td>
          </tr>
        </table>
        <div class="d_space"></div>
      </div>
    </div>

  <? elseif(count($arResult["SEARCH"])>0): ?>

    <div class="d_tabs-m">
      <div class="domtab-m">
        <div class="js-section active" data-id="#t0">
          <!-- <a name="t0" id="t0" class="d_sort"> -->
           <?
           // $APPLICATION->IncludeComponent(
           //  "bitrix:catalog.smart.filter", 
           //  "filter",
           //  array(
           //    "IBLOCK_TYPE" => "catalog",
           //    "IBLOCK_ID" => "13",
           //    "SECTION_ID" => 0,
           //    "FILTER_NAME" => "arrFilter",
           //    "PRICE_CODE" => array(
           //      0 => "Розничная",
           //      1 => "Мелкооптовая",
           //      2 => "Крупнооптовая",
           //      3 => "Мегаоптовая",
           //    ),
           //    "CACHE_TYPE" => "A",
           //    "CACHE_TIME" => "36000000",
           //    "CACHE_GROUPS" => "Y",
           //    "SAVE_IN_SESSION" => "Y",
           //    "INSTANT_RELOAD" => "Y",
           //    "XML_EXPORT" => "Y",
           //    "SECTION_TITLE" => "NAME",
           //    "SECTION_DESCRIPTION" => "DESCRIPTION",
           //    "SHOW_ALL_WO_SECTION" => "Y",
           //    "HIDE_NOT_AVAILABLE" => "N",
           //    "SEARCH"=>$_REQUEST["q"]
           //  ),false);
          ?>
          <!-- </a> -->

          <div class="d_tabproducts">
            <? foreach ($arResult["SEARCH_ITEMS"] as $arItem) {
                //Получаем количество товара
              CModule::IncludeModule("catalog");
              $ar_res = CCatalogProduct::GetByID($arItem['ID']);
              $arItem["CATALOG_QUANTITY"] = $ar_res['QUANTITY'];

              $p = CCatalogProduct::GetOptimalPrice($arItem['ID']);

//              echo_r($arItem);

              $price = $p['PRICE']['PRICE'];
              $art = $arItem["PROPERTIES"]["ARTICLE"]["VALUE"];
              if (!$arItem["PREVIEW_PICTURE"]["SRC"]) $arItem["PREVIEW_PICTURE"]["SRC"] = "/bitrix/components/tehno/catalog.section/templates/.default/images/no_photo.png";
              if ($arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["DEPTH_LEVEL"] == 2)
                $arItem["DETAIL_PAGE_URL"] = $arResult["SECTIONS"][$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["IBLOCK_SECTION_ID"]]["CODE"];
              else
                $arItem["DETAIL_PAGE_URL"] = $arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["CODE"];
                $arItem["DETAIL_PAGE_URL"] = "/catalog/" . $arItem["DETAIL_PAGE_URL"] . "/" . $arItem["CODE"] . "/";
            ?>
              <div class="product">
                <div class="product__pic">
                  <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                    <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>">
                  </a>
                </div>
                <div class="product__title">
                  <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"><?= $arItem["NAME"] ?></a>
                </div>
                <div class="product__code">арт. <?= $art ?></div>
                <div class="product__details">
                    <?if(intval($price) > 0){?>
                        <div class="product__price"><?= $price ?>  &#8381;<i class="icon-rub"></i></div>
                    <?}else{?>
                        <div class="product__price">Цена по запросу</div>
                    <?}?>
                  <div class="product__buy">
                    <a class="btn btn_small btn_green js-add2basket<? if (!$arItem["CATALOG_QUANTITY"]) echo " btn-disable"; ?>" href="<?=$arItem["DETAIL_PAGE_URL"].'?action=ADD2BASKET&id='.$arItem['ID']?>" data-id="<?=$arItem['ID']?>">В корзину</a>
                  </div>
                </div>
              </div>
            <? } ?>
          </div>
          <div class="loader"></div>
          <div class="js-section-end"></div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  <?else:?>
    <div class="page_not">
      <div class="d_text">
        <?ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?>
      </div>
    </div>
  <?endif;?>