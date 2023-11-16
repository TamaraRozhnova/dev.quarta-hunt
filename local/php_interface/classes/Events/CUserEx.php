<?php 

namespace CustomEvents;

use \Bitrix\Sale\Internals\DiscountCouponTable,
    \Bitrix\Main\Loader,
    \Bitrix\Main\Mail\Event;

class CUserEx
{
    
    static function OnBeforeUserLogin($arFields)
    {

        $filter = Array("EMAIL" => $arFields["LOGIN"]);
        $rsUsers = \CUser::GetList(($by="LAST_NAME"), ($order="asc"), $filter);

        if($user = $rsUsers->GetNext()) {
            $arFields["LOGIN"] = $user["LOGIN"];
        }

    }

    static function OnBeforeUserRegister(&$arFields)
    {
        $arFields["LOGIN"] = $arFields["EMAIL"];

        if ($arFields['UF_TYPE'] == 'wholesale'){
            $arFields["GROUP_ID"] = [];
            $arFields["GROUP_ID"][] = 9;
        };
    }
    
    static function onAfterUserRegister(&$arFields) 
    {

        if ($arFields["USER_ID"] > 0) {

            Loader::includeModule("catalog");
            Loader::includeModule("sale");

            $discountID = 42;

            $coupon = DiscountCouponTable::generateCoupon(true);

            $arCoupon = [
                'DISCOUNT_ID' => $discountID,
                'COUPON'      => $coupon,
                'TYPE'        => DiscountCouponTable::TYPE_ONE_ORDER,
                'MAX_USE'     => 1,
                'USER_ID'     => $arFields["USER_ID"],
                'DESCRIPTION' => ''
            ];

            $addDb = DiscountCouponTable::add($arCoupon);

            if (!$addDb->isSuccess()) {
//                echo $addDb->getErrorMessages();
            } else {

                Event::send(array(
                    "EVENT_NAME" => "NEW_USER_COUPON", 
                    "LID" => "s1", 
                    "C_FIELDS" => array( 
                        "EMAIL" => $arFields["EMAIL"], 
                        "USER_ID" => $arFields["USER_ID"],
                        "PROMO_CODE" => $coupon,
                    ), 
                ));

            }
  
        }
    }
}