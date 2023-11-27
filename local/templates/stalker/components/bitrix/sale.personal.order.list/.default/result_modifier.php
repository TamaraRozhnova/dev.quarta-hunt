<?php
$IDs = [];
foreach ($arResult['ORDERS'] as $key => &$order)
{
	foreach ($order['BASKET_ITEMS'] as $index => &$item)
	{
		$IDs[] = $item['PRODUCT_ID'];
	}
}

$obElList = CIBlockElement::GetList(
	[],
	[ 'ID' => $IDs ],
	false,
	false,
	[
		'ID', 'DETAIL_PICTURE',
	]
);
$images = [];
while ($item = $obElList->GetNext())
{
	$images[ $item['ID'] ] = CFile::GetPath( $item['DETAIL_PICTURE'] );
}

foreach ($arResult['ORDERS'] as $key => &$order)
{
	foreach ($order['BASKET_ITEMS'] as $index => &$item)
	{
		$item['IMAGE'] = $images[ $item['PRODUCT_ID'] ];

	}
}

unset( $order, $item );
