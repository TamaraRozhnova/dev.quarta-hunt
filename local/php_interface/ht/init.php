<?php

use \Bitrix\Main\Loader;

include($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/constants.php');
include($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/functions.php');

Loader::registerAutoLoadClasses(null, [
    'Helpers\IblockHelper' => '/local/php_interface/classes/Helpers/IblockHelper.php',
    'Form\MailSubscribe' => '/local/php_interface/classes/Form/MailSubscribe.php',
    'Personal\Favorites' => '/local/php_interface/classes/Personal/Favorites.php'
]);

function debug($var)
{
    if (Bitrix\Main\Engine\CurrentUser::get()->isAdmin()) {
        print_r('<pre>');
        print_r($var);
        print_r('</pre>');
    }
}
