<?php

use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses(
	"promo2page",
    [
        'Promo\\PromoPage' =>  '/classes/PromoPage.php'
    ]
);
