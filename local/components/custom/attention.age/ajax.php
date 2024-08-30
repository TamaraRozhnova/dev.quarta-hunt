<?php 

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

use \Bitrix\Main\Web\Cookie;
use \Bitrix\Main\Context;

if (!empty($_POST['AGE_APPLY'])) {
    if ($_POST['AGE_APPLY'] == 'Y') {

        $cookie = new Cookie("AGE_APPLY", "Y", time() + 3600 * 24 * 365);
        $cookie->setSpread(Cookie::SPREAD_DOMAIN);
        $cookie->setDomain($_SERVER['HTTP_HOST']);
        $cookie->setPath("/"); 
        $cookie->setSecure(false); 
        $cookie->setHttpOnly(false);

        Context::getCurrent()->getResponse()->addCookie(
            $cookie
        );

    }
} 

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); 