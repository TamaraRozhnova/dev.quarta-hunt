<?php

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

if (!empty($_POST)) {

    if (!empty($userId = $USER->GetId())) {
        
        $userEntity = new CUser;

        foreach ($_POST as $arFormItemCode => $arFormItem) {

            if (
                $arFormItemCode == 'PERSONAL_STREET'
                ||
                $arFormItemCode == 'PERSONAL_HOME'
            ) continue;

            $arFields[$arFormItemCode] = $arFormItem;

        }

        if (
            !empty($_POST['PERSONAL_STREET'])
            &&
            !empty($_POST['PERSONAL_HOME'])
        ) {
            $arFields['PERSONAL_STREET'] = $_POST['PERSONAL_STREET'] . ', ' . $_POST['PERSONAL_HOME'];
        }

        $rsUpdateUser = $userEntity->Update($userId, $arFields);

        if ($rsUpdateUser) {

            echo \Bitrix\Main\Web\Json::encode([
                "STATUS" => "Y"
            ]);

        }
    }
}

