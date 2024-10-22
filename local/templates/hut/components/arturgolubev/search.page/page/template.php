<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $APPLICATION;
?>
<?/*
<div class="bx-ag-search-page search-page <?=$arResult["VISUAL_PARAMS"]["THEME_CLASS"]?>">
	<form action="" method="get">
		<input placeholder="<?=$arParams["INPUT_PLACEHOLDER"]?>" type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="50" />
		
		&nbsp;<input type="submit" value="<?=GetMessage("SEARCH_GO")?>" />
		<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
	<?if($arParams["SHOW_WHEN"]):?>
		<script>
		var switch_search_params = function()
		{
			var sp = document.getElementById('search_params');
			var flag;

			if(sp.style.display == 'none')
			{
				flag = false;
				sp.style.display = 'block'
			}
			else
			{
				flag = true;
				sp.style.display = 'none';
			}

			var from = document.getElementsByName('from');
			for(var i = 0; i < from.length; i++)
				if(from[i].type.toLowerCase() == 'text')
					from[i].disabled = flag

			var to = document.getElementsByName('to');
			for(var i = 0; i < to.length; i++)
				if(to[i].type.toLowerCase() == 'text')
					to[i].disabled = flag

			return false;
		}
		</script>
		<br /><a class="search-page-params" href="#" onclick="return switch_search_params()"><?echo GetMessage('CT_BSP_ADDITIONAL_PARAMS')?></a>
		<div id="search_params" class="search-page-params" style="display:<?echo $arResult["REQUEST"]["FROM"] || $arResult["REQUEST"]["TO"]? 'block': 'none'?>">
			<?$APPLICATION->IncludeComponent(
				'bitrix:main.calendar',
				'',
				array(
					'SHOW_INPUT' => 'Y',
					'INPUT_NAME' => 'from',
					'INPUT_VALUE' => $arResult["REQUEST"]["~FROM"],
					'INPUT_NAME_FINISH' => 'to',
					'INPUT_VALUE_FINISH' =>$arResult["REQUEST"]["~TO"],
					'INPUT_ADDITIONAL_ATTR' => 'size="10"',
				),
				null,
				array('HIDE_ICONS' => 'Y')
			);?>
		</div>
	<?endif?>
	</form><br />

	<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
		?>
		<div class="search-language-guess">
			<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
		</div><br /><?
	endif;?>
	
	<?if(is_array($arResult["SEARCH_HISTORY"]) && count($arResult["SEARCH_HISTORY"]) > 0):?>
		<div class="ag-spage-history">
			<?=GetMessage("SEARCH_HISTORY_TITLE")?>
			<?foreach($arResult["SEARCH_HISTORY"] as $k=>$v):
				if($k > 0) echo ', ';?><a href="?q=<?=$v?>"><?=$v?></a><?
			endforeach?>
		</div>
	<?endif;?>
	
	<?if(is_array($arResult["CLARIFY_SECTION"]) && count($arResult["CLARIFY_SECTION"]) > 1):?>
		<div class="ag-spage-clarify-list">
			<div class="ag-spage-clarify-title"><?=GetMessage("AG_SPAGE_CLARIFY_SECTION");?></div>
			
			<a class="ag-spage-clarify-item <?if($arResult["SELECTED_SECTION"] == "") echo 'selected';?>" href="<?=$APPLICATION->GetCurPageParam("", array("section"))?>"><?=GetMessage("AG_SPAGE_CLARIFY_SECTION_ALL");?></a>
			
			<?foreach($arResult["CLARIFY_SECTION"] as $section):?>
				<a class="ag-spage-clarify-item <?if($arResult["SELECTED_SECTION"] == $section["ID"]) echo 'selected';?>" href="<?=$APPLICATION->GetCurPageParam('section='.$section["ID"], array("section"))?>"><?=$section["NAME"]?> (<?=$section["CNT"]?>)</a>
			<?endforeach;?>
		</div>
	<?endif;?>	
</div>


<?if($arResult["VISUAL_PARAMS"]["THEME_COLOR"]):?>
	<style>
		.search-page hr, .search-page input[type=text], .search-page input[type=submit], .ag-spage-clarify-item, .ag-spage-clarify-item:hover {
			border-color: <?=$arResult["VISUAL_PARAMS"]["THEME_COLOR"]?> !important;
		}
		.search-page input[type=submit] {
			background-color: <?=$arResult["VISUAL_PARAMS"]["THEME_COLOR"]?> !important;
		}
	</style>
<?endif;?>
*/ ?>