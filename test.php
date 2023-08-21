<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?
use Bitrix\Main\Loader;
Loader::includeModule("logictim.balls"); 

    $user = \Bitrix\Main\UserTable::getList(array(
        'filter' => array(),        
        'select'=>array('ID','UF_BONUS_POINTS', 'UF_LOGICTIM_BONUS'),    
    ));

    while ($arUser = $user->fetch()) {               
        $Users[] = $arUser;
    }

    foreach ($Users as $one) {
        if ($one['ID'] != 12 && $one['UF_BONUS_POINTS'] != 0 && $one['UF_BONUS_POINTS'] != '') {
            $arFields = array(
                "ADD_BONUS" => $one['UF_BONUS_POINTS'],
                "USER_ID" => $one['ID'],
                "OPERATION_TYPE" => 'USER_BALLANCE_CHANGE',
                "OPERATION_NAME" => 'Первоначальное начисление',                
              );
            logictimBonusApi::AddBonus($arFields);
        }                
    }    
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
