<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

if(empty($arResult))
	return "";

$strReturn = '';



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
	$arrow = ($index > -1? '<span class="breadcrumbs-divider"> / </span>' : '');

    if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{

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
/*		$strReturn .= '
			<div class="breadcrumbs-divider"> / </div>
			<div class="breadcrumbs-item">
				<span>'.$title.'</span>
			</div>';*/
	}
}

$strReturn .= '<div style="clear:both"></div></div>';

return $strReturn;
