<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

if (empty($arResult))
	return;
?>
 <ul class="mobile-menu__list">
<?foreach($arResult as $itemIdex => $arItem):?>
			<?if ($arItem["DEPTH_LEVEL"] == "1"):?>
              <li>
                <a href="<?=htmlspecialcharsbx($arItem["LINK"])?>"><?=htmlspecialcharsbx($arItem["TEXT"], ENT_COMPAT, false)?><svg class="icon icon-chevron-right">
                    <use xlink:href="bitrix/templates/stalker/img/sprite.svg#icon-chevron-right"></use>
                  </svg>
                </a>
              </li>
<?endif?>
		<?endforeach;?>
            </ul>