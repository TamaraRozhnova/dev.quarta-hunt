<?php if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Sale\Delivery;
use Bitrix\Sale\PaySystem;

/** @var array $arParams */
/** @var array $arResult */
/** @global \CMain $APPLICATION */
/** @global \CUser $USER */
/** @global \CDatabase $DB */
/** @var CBitrixComponentTemplate $this */

/**
 * 1. Список ИБ
 * 2. Список оплат
 * 3. список доставок
 */
CModule::IncludeModule( 'iblock' );
CModule::IncludeModule( 'catalog' );
CModule::IncludeModule( 'sale' );

$iblockCatalogs = CCatalog::GetList(
	[],
	[ '=PRODUCT_IBLOCK_ID' => false ],
	false,
	false,
	[ 'IBLOCK_ID' ]
);
$IDs = [];
// перебираем список и выводим информацию о каждом инфоблоке
while ($catalog = $iblockCatalogs->GetNext())
{
	$IDs[] = $catalog['IBLOCK_ID'];

}
if ($IDs)
{
	$res = CIBlock::GetList(
		[ 'SORT' => 'ASC' ],
		[
			'ID' => $IDs,
			'ACTIVE' => 'Y',
		]
	);

	while ($item = $res->Fetch())
	{
		$arResult['catalog'][ $item['ID'] ] = '[' . $item['ID'] . '] ' . $item['NAME'];
	}
}

$paymentsList = PaySystem\Manager::getList( [
	'filter' => [ 'ACTIVE' => 'Y' ],
] )->fetchAll();
foreach ($paymentsList as $item)
{
	$arResult['payment'][ $item['ID'] ] = '[' . $item['ID'] . '] ' . $item['NAME'];
}

$requestParams = [
	"filter" => [
		"ACTIVE" => "Y",
	],
	"select" => [
		"ID",
		"NAME",
	],
];
$deliveryList = Delivery\Services\Manager::getList( $requestParams )->fetchAll();

foreach ($deliveryList as $item)
{
	$arResult['delivery'][ $item['ID'] ] = '[' . $item['ID'] . '] ' . $item['NAME'];
}


