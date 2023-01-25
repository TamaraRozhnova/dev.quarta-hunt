<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

function modify_result($inResult)
{
    $defFields = ["ID", "NAME", "ACTIVE", "PREVIEW_TEXT", "~PREVIEW_TEXT", "DETAIL_TEXT", "~DETAIL_TEXT", "DATE_CREATE", "CREATED_BY", "TIMESTAMP_X",
        "IBLOCK_SECTION_ID", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "DETAIL_PRICTURE", "CODE", "VALUE", "~VALUE", "IBLOCK_ID", "SRC", "DESCRIPTION", 'FILE_NAME',
        'FILE_SIZE', 'WIDTH', 'HEIGHT', 'FILE_TYPE', 'TITLE', 'ALT', 'PRICE_ID', 'CURRENCY', 'DISCOUNT_VALUE', 'DISCOUNT_DIFF', 'DISCOUNT_DIFF_PERCENT',
        'PRINT_VALUE', 'PRINT_DISCOUNT_VALUE', 'PRINT_DISCOUNT_DIFF', 'TEXT', 'TYPE'];
    $outResult = [];
    foreach($inResult as $k => $val) {
        if ($k === 'DISPLAY_PROPERTIES') continue;
        if (is_array($val)) {
            if (!empty($val)) $outResult[$k] = modify_result($val);
        } else {
            if (in_array($k, $defFields) || is_int($k)) $outResult[$k] = $val;
        }
    }
    return $outResult;
}

function get_prices()
{
    global $USER;

    if ($USER && $USER->isAuthorized()) {
        if (in_array('9', $USER->GetUserGroup($USER->GetID())))
            $prices = array('OPT_SMALL');
        else
            $prices = array('BASE');
    } else {
        $prices = array('BASE');
    }

    return $prices;
}

function get_user_type()
{
    global $USER;

    if ($USER && $USER->isAuthorized())
        $opt = in_array('9', $USER->GetUserGroup($USER->GetID()));
    else
        $opt = false;

    return $opt;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?$APPLICATION->ShowTitle();?></title>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <?CJSCore::Init();?>
    <?$APPLICATION->ShowHead();?>
    <?$APPLICATION->ShowPanel();?>
</head>
<body>
    <main>

