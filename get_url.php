<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Ссылка на товар");

use Bitrix\Main\Context;

?>

<?php
$request = Context::getCurrent()->getRequest();
$xmlId = $request->get("xml_id");

if ($xmlId == '') {
    echo 'Ошибка! Не указан параметр XML_ID.';
} else {
    $prodQuery = \Bitrix\Iblock\Elements\ElementCatalog1cTable::getList([
        'select' => [
            'ID',
            'IBLOCK_ID',
            'CODE',
            'IBLOCK_SECTION_ID',
            'DETAIL_PAGE_URL' => 'IBLOCK.DETAIL_PAGE_URL',
        ],
        'filter' => [
            'XML_ID' => $xmlId,
        ],
    ]);

    if ($prod = $prodQuery->fetch()) {
        $url = CIBlock::ReplaceDetailUrl($prod['DETAIL_PAGE_URL'], $prod, false, 'E');
        LocalRedirect($url);
    } else {
        echo 'Ошибка! Товара с указанным артикулом нет на сайте.';
    }
}
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>