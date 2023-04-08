<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\VideoUrlHelper;

$videoLink = $arResult['PROPERTIES']['VIDEO_LINK']['VALUE'];

if ($videoLink) {
    $arResult['VIDEO_LINK'] = VideoUrlHelper::convertVideoUrl($videoLink);
}

