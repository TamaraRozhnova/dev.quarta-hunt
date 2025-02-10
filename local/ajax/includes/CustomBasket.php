<?php

use Bitrix\Main\Application;



$request = Application::getInstance()->getContext()->getRequest();

\Bitrix\Main\Diag\Debug::dumpToFile(var_export($request, true), '$request', '_log.txt');