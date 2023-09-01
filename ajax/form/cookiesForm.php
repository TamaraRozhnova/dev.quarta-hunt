<?php 

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

if (!empty($_POST['COOKIE_APPLY'])) {
    if ($_POST['COOKIE_APPLY'] == 'Y') {

        $cookie = new \Bitrix\Main\Web\Cookie("COOKIE_APPLY", "Y", time()+60*60*24*365*10);
        $cookie->setSpread(\Bitrix\Main\Web\Cookie::SPREAD_DOMAIN);
        $cookie->setDomain($_SERVER['SERVER_NAME']);
        $cookie->setPath("/"); 
        $cookie->setSecure(false); 
        $cookie->setHttpOnly(false);

        \Bitrix\Main\Context::getCurrent()->getResponse()->addCookie(
            $cookie
        );

    }
} 

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); 

