<?
//use Bitrix\Main,
//    Bitrix\Sale;


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

?>

<?
$APPLICATION->IncludeComponent("bitrix:sale.order.payment", "payment", Array());
/*
CModule::IncludeModule('sale');


$bUseAccountNumber = Sale\Integration\Numerator\NumeratorOrder::isUsedNumeratorForOrder();

$arOrder = false;

$registry = Sale\Registry::getInstance(Sale\Registry::REGISTRY_TYPE_ORDER);
$orderClassName = $registry->getOrderClassName();

$orderId = $_REQUEST['ORDER_ID'];

if (!$arOrder)
{
    $arFilter = array(
        "LID" => SITE_ID,
        "ID" => $orderId,
    );

    $arFilter["USER_ID"] = intval($USER->GetID());

    $dbRes = $orderClassName::getList([
        'filter' => $arFilter,
        'order' => [
            "DATE_UPDATE" => "DESC"
        ]
    ]);

    $arOrder = $dbRes->fetch();
}

echo '<pre>';
print_r($arOrder);
echo '</pre>';
*/
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

