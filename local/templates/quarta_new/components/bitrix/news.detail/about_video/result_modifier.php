<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\VideoUrlHelper;

$videoUrl = $arResult['PROPERTIES']['VIDEO']['VALUE'];

if ($videoUrl) {
    $arResult['VIDEO'] = VideoUrlHelper::convertVideoUrl($videoUrl);
}

