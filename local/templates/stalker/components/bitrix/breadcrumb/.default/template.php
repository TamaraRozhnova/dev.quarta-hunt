<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//echo_j($arResult, 'breadcrumb');

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
//$css = $APPLICATION->GetCSSArray();
//if(!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css))
//{
//	$strReturn .= '<link href="'.CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css").'" type="text/css" rel="stylesheet" />'."\n";
//}

$strReturn .= '<div class="breadcrumbs-row" itemscope itemtype="http://schema.org/BreadcrumbList">';
$title = "Главная";
$strReturn .= '
			<div class="breadcrumbs-item" id="bx_breadcrumb_00" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="/" title="'.$title.'" itemprop="item">
					<span itemprop="name">'.$title.'</span>
				</a>
				<meta itemprop="position" content="0" />
			</div>';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$arrow = ($index > -1? '<div class="breadcrumbs-divider"> / </div>' : '');
//	$arrow = ($index > 0? ' ' : '');


    if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
//        $strReturn .= $arrow;
		$strReturn .= '
			<div class="breadcrumbs-item" id="bx_breadcrumb_'.$index.'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				'.$arrow.'
				<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="item">
					<span itemprop="name">'.$title.'</span>
				</a>
				<meta itemprop="position" content="'.($index + 1).'" />
			</div>';
	}
	else
	{
//		$strReturn .= '
//			<div class="breadcrumbs-divider"> / </div>
//			<div class="breadcrumbs-item">
//				<span>'.$title.'</span>
//			</div>';
	}
}

$strReturn .= '<div style="clear:both"></div></div>';

return $strReturn;
