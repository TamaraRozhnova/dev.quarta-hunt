<?php
/**
 * Created by PhpStorm.
 * User: akorolev
 * Date: 01.10.2018
 * Time: 16:29
 */

$module_id = 'interlabs.oneclick';

$arJsConfig = array(
    'interlabs_oneclick_popup' => array(
        'js' => [
            "https://code.jquery.com/jquery-3.3.1.min.js",
        ],
        'css' => [],
        'rel' => array(),
    )
);

foreach ($arJsConfig as $ext => $arExt) {
    \CJSCore::RegisterExt($ext, $arExt);
}