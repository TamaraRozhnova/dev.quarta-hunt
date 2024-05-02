<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

include_once 'result_modifier.php';

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
$css = $APPLICATION->GetCSSArray();
if(!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css))
{
	$strReturn .= '<link href="'.CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css").'" type="text/css" rel="stylesheet" >'."\n";
}

$itemSize = count($arResult);

if ($itemSize > 2) {
	$strReturn .= '<div class="black-bg" style="display: none;"></div><div class="breadcrumb__popup"><div class="cross"></div>';
}

$strReturn .= '<div class="bx-breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$arrow = ($index > 0? '<i class="fa fa-angle-right"></i>' : '');

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
			<div class="bx-breadcrumb-item" id="bx_breadcrumb_'.$index.'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				'.$arrow.'
				<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="item">
					<span itemprop="name">'.$title.'</span>
				</a>
				<meta itemprop="position" content="'.($index + 1).'" >
			</div>';
	}
	else
	{
		$strReturn .= '
			<div class="bx-breadcrumb-item">
				'.$arrow.'
				<span>'.$title.'</span>
			</div>';
	}
}

unset($index);

$strReturn .= '<div style="clear:both"></div></div>';

if ($itemSize > 2) {
	$strReturn .= '</div><div class="bx-breadcrumb breadcrumb__fake">';
	for($index = 0; $index < $itemSize; $index++) {

		$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
		$arrow = ($index > 0? '<i class="fa fa-angle-right"></i>' : '');

		if ($index > 0 && $index < $itemSize - 1) {
			continue;
		}

		if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1) {
			$strReturn .= '
				<div class="bx-breadcrumb-item">
					'.$arrow.'
					<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">
						<span>'.$title.'</span>
					</a>					
				</div>';
		}
		else
		{
			$strReturn .= '
				<div class="bx-breadcrumb-item">
					'.$arrow.'
					<span>'.$title.'</span>
				</div>';
		}

		if ($index == 0) {
			$strReturn .= '<div class="bx-breadcrumb-item breadcrumbs__dots"><span>...</span></div>';
		}
	}
	$strReturn .= '<div style="clear:both"></div></div>';
}



return $strReturn;
