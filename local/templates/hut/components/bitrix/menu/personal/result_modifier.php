<?php

global $APPLICATION;

foreach($arResult as &$arItem):
    if($arItem['LINK'] == '/exit'){
        $arItem['LINK'] = $APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), [
            "login",
            "logout",
            "register",
            "forgot_password",
            "change_password"]
          );
    }
endforeach;