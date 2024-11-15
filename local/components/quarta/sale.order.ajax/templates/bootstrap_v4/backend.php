<?php

use Bitrix\Main\Application;
use Bitrix\Main\Web\Json;

define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_STATISTIC", true);
define('NOT_CHECK_PERMISSIONS', true);


require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

CUtil::JSPostUnescape();

$session = Application::getInstance()->getSession();

$couponNotFirstOrder = false;
if ($session->has('couponNotFirstOrder') && $session->get('couponNotFirstOrder') != '' && boolval($session->get('couponNotFirstOrder')) == true) {
    $couponNotFirstOrder = boolval($session->get('couponNotFirstOrder'));
    $session->remove('couponNotFirstOrder');
}

header('Content-Type: application/x-javascript; charset='.LANG_CHARSET);

die(Json::encode(['couponNotFirstOrder' => $couponNotFirstOrder]));
