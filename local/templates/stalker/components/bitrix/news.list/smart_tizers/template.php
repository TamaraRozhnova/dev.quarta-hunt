<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
CModule::IncludeModule('iblock');
?>
 <section class="section section-plus">
          <div class="container">
            <div class="section-plus__grid">
				<?
$arSelect = Array("ID", "IBLOCK_ID", "CODE", "NAME", "DETAIL_TEXT");
$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIblockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, $arPages, $arSelect);
 while($ob = $res->GetNextElement()){
   $arFields = $ob->GetFields();
?>

              <div class="section-plus__item">
                <div class="section-plus__item-title"><?=$arFields['NAME'];?></div>
                <div class="section-plus__item-text"><?=$arFields['DETAIL_TEXT'];?></div>
                <div class="plus plus--top-left">
                  <svg class="icon icon-plus">
                    <use xlink:href="/bitrix/templates/stalker/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--top-right">
                  <svg class="icon icon-plus">
                    <use xlink:href="/bitrix/templates/stalker/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--bottom-left">
                  <svg class="icon icon-plus">
                    <use xlink:href="/bitrix/templates/stalker/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
                <div class="plus plus--bottom-right">
                  <svg class="icon icon-plus">
                    <use xlink:href="/bitrix/templates/stalker/img/sprite.svg#icon-plus"></use>
                  </svg>
                </div>
              </div>
 <?}?>

             </div>
          </div>
        </section>

