<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Sale;

$data = [];

if (isset($_GET['id'])){
    $id = $_GET['id'];
    if (CModule::IncludeModule('sale')) {
        $order = Sale\Order::load($id);
        if (!empty($order)){
            $data[] = OrderId::getInfoOrderUser($id);
        } else {
            exit();
        }
    }
}
ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($data);

die();