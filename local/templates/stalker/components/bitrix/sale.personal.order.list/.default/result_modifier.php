<?php
$IDs = [];
foreach ($arResult['ORDERS'] as $key => $order)
{
	foreach ($order['BASKET_ITEMS'] as $index => $item)
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
while ($item1 = $obElList->GetNext())
{
    if(is_array($item1['DETAIL_PICTURE']) || strlen($item1['DETAIL_PICTURE'])){
        $images[ $item1['ID'] ] = CFile::GetPath( $item1['DETAIL_PICTURE'] );
    }else{
        $images[ $item1['ID'] ] = SITE_TEMPLATE_PATH . '/img/no-photo.png';
    }
}

foreach ($arResult['ORDERS'] as $key => $arOrder)
{
	foreach ($arOrder['BASKET_ITEMS'] as $index => $arItem)
	{
        $arResult['ORDERS'][$key]['BASKET_ITEMS'][$index]['IMAGE'] = $images[ $arItem['PRODUCT_ID'] ];

	}
}

unset( $order, $item );
