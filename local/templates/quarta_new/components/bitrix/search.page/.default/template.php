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
?>

<div class="search-page">
	
	<?if (count($arResult["SEARCH"])>0):?>

		<div class = "search-page-result-text container">
			<h2>Результаты поиска</h2>
			<p class="mb-4">
				Найдено <?= $arResult["NAV_RESULT"]->SelectedRowsCount() ?> совпадений по вашему запросу
				<span class="text-primary"><?= $arResult['REQUEST']['QUERY'] ?></span>
			</p>
		</div>

		<?if($arParams["DISPLAY_TOP_PAGER"] != "N"):?>
			<?=$arResult["NAV_STRING"]?>
		<?endif;?>

		<?if (!empty($arResult['ELEMENTS_IDS'])):?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"new_search",
				$arResult['PARAMS_CATALOG']
			);?>
		<?endif;?>

		<div class="search-page-other-result">
			<div class = "container">

				<?foreach($arResult["SEARCH"] as $arItem):?>

					<?if ($arItem['PARAM1'] == '1c_catalog') continue;?>

					<div class="search-item">

						<h4><a href="<?echo $arItem["URL"]?>"><?echo $arItem["TITLE_FORMATED"]?></a></h4>

						<div class="search-preview"><?echo $arItem["BODY_FORMATED"]?></div>
						
						<?if(
							($arParams["SHOW_ITEM_DATE_CHANGE"] != "N")
							|| ($arParams["SHOW_ITEM_PATH"] == "Y" && $arItem["CHAIN_PATH"])
							|| ($arParams["SHOW_ITEM_TAGS"] != "N" && !empty($arItem["TAGS"]))
						):?>
							<div class="search-item-meta">

								<?if($arParams["SHOW_ITEM_TAGS"] != "N" && !empty($arItem["TAGS"])):?>
									<div class="search-item-tags"><label><?echo GetMessage("CT_BSP_ITEM_TAGS")?>: </label><?
									foreach ($arItem["TAGS"] as $tags):
										?><a href="<?=$tags["URL"]?>"><?=$tags["TAG_NAME"]?></a> <?
									endforeach;
									?></div>
								<?endif;?>

							</div>
						<?endif?>
					</div>

				<?endforeach;?>

				<?if($arParams["DISPLAY_BOTTOM_PAGER"] != "N"):?>
					<?=$arResult["NAV_STRING"]?>
				<?endif;?>

				<?if($arParams["SHOW_ORDER_BY"] != "N"):?>
					<div class="search-sorting"><label><?echo GetMessage("CT_BSP_ORDER")?>:</label>&nbsp;
				<?if($arResult["REQUEST"]["HOW"]=="d"):?>
					<a href="<?=$arResult["URL"]?>&amp;how=r"><?=GetMessage("CT_BSP_ORDER_BY_RANK")?></a>&nbsp;<b><?=GetMessage("CT_BSP_ORDER_BY_DATE")?></b>
				<?else:?>
					<b><?=GetMessage("CT_BSP_ORDER_BY_RANK")?></b>&nbsp;<a href="<?=$arResult["URL"]?>&amp;how=d"><?=GetMessage("CT_BSP_ORDER_BY_DATE")?></a>
				<?endif;?>
				</div>
				<?endif;?>

			</div>
		</div>
	<?else:?>
		<div class = "search-page-result-text container">
			<h2>Результаты поиска</h2>
			<p class="mb-4">
				<span>Простите, по вашему запросу товаров сейчас нет.</span>
				<br>
				<a href="/">На главную</a>
			</p>
		</div>
	<?endif;?>

</div>
