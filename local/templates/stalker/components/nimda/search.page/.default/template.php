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
<div class="sf__wrapper" style="width: 100%">
    <form method="get" action="/search/" autocomplete="off" class="sf__form">
        <div class="input-wrapper">
            <input type="text" class="search-input"  placeholder="Введите запрос для поиска" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" autocomplete="off">
        </div>
        <input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
        <input type="hidden" name="search" value="1" />
        <button class="btn" type="submit"><div class="lupa"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.0574 0.0398782C16.8844 0.358295 19.3027 1.89874 20.7484 4.29548C21.3423 5.28085 21.708 6.28774 21.9231 7.50117C22.035 8.15091 22.0221 9.65263 21.9016 10.3196C21.3853 13.1466 19.7157 15.4272 17.2243 16.718C15.8904 17.4065 14.6813 17.6991 13.1581 17.6948C11.3035 17.6948 9.78026 17.2344 8.2312 16.2103L7.71915 15.8704L4.72431 18.8523C2.70623 20.8661 1.67783 21.8644 1.56165 21.9203C1.32929 22.0279 0.84306 22.0279 0.636518 21.9203C0.120167 21.6492 -0.116495 21.0898 0.0556222 20.5563C0.128773 20.3368 0.287981 20.1647 3.14083 17.3075L6.14858 14.2912L5.81726 13.8007C4.22087 11.4427 3.86803 8.49084 4.862 5.75847C5.18472 4.86346 5.80435 3.82216 6.4756 3.04332C7.59437 1.75244 9.17785 0.749862 10.8001 0.315265C11.7897 0.0484839 13.1322 -0.0676964 14.0574 0.0398782ZM12.5212 2.23437C10.8861 2.41079 9.60814 3.01751 8.46356 4.16209C7.29747 5.32818 6.67784 6.65349 6.52294 8.30581C6.38524 9.78172 6.78111 11.2877 7.65461 12.6001C8.01606 13.1466 8.86804 13.9986 9.41451 14.36C11.6176 15.8273 14.3328 15.9048 16.5746 14.5623C18.1925 13.5984 19.3328 11.9719 19.7071 10.0915C19.8448 9.40306 19.8448 8.31012 19.7071 7.62165C19.3199 5.68102 18.128 4.0287 16.4068 3.05193C15.2579 2.39789 13.8078 2.09238 12.5212 2.23437Z" fill="#2A2B2B"/></svg></div></button>
    </form>
</div>
<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
    ?>
    <div class="search-language-guess">
        <?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
    </div><br /><?
endif;?>

<?/*?>
<div class="page_not search-page">
  <div class="d_text">
  <div class="catalog__top">
    <form method="get" action="" autocomplete="off">
      <div class="catalog__search ajaxsearch__wrapper" id="ajaxsearch_id_page">
        <input type="text" class="input js-q- ajaxsearch__input_" placeholder="Введите название или код товара" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" autocomplete="off">
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
<?*/?>

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
              $art = $arItem["PROPERTIES"]["CML2_ARTICLE"]["VALUE"];
              if (!$arItem["PREVIEW_PICTURE"]["SRC"]) $arItem["PREVIEW_PICTURE"]["SRC"] = SITE_TEMPLATE_PATH . '/img/no-photo.png';
              if ($arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["DEPTH_LEVEL"] == 2)
                $arItem["DETAIL_PAGE_URL"] = $arResult["SECTIONS"][$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["IBLOCK_SECTION_ID"]]["CODE"];
              else
                $arItem["DETAIL_PAGE_URL"] = $arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["CODE"];
//                $arItem["DETAIL_PAGE_URL"] = "/catalog/" . $arItem["DETAIL_PAGE_URL"] . "/" . $arItem["CODE"] . "/";
                $arItem["DETAIL_PAGE_URL"] = "/catalog/?SECTION_ID=" . $arItem["IBLOCK_SECTION_ID"] . "&ELEMENT_ID=" . $arItem["ID"];
            ?>
              <div class="product">
                <div class="product__pic">
                  <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
<!--                    <img src="--><?//= $arItem["PREVIEW_PICTURE"]["SRC"] ?><!--" alt="--><?//= $arItem["NAME"] ?><!--">-->
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
<!--                    <a class="btn btn_small btn_green js-add2basket--><?// if (!$arItem["CATALOG_QUANTITY"]) echo " btn-disable"; ?><!--" href="--><?//=$arItem["DETAIL_PAGE_URL"].'?action=ADD2BASKET&id='.$arItem['ID']?><!--" data-id="--><?//=$arItem['ID']?><!--">В корзину</a>-->
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