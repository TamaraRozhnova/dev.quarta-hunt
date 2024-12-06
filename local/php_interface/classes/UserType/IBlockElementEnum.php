<?php

namespace UserType;

class IBlockElementEnum extends \CDBResult
{
    function getNext($textHtmlAuto = true, $useTilda = true)
    {
        $result = parent::getNext($textHtmlAuto, $useTilda);

        if($result)
        {
            $result['VALUE'] = $result['NAME'] . ' [' . $result['ID'] . ']';
        }

        return $result;
    }
}