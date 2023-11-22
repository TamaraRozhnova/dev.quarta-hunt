<?php

//AddEventHandler('sale', 'OnSaleComponentOrderOneStepDelivery', ['SproEventHandlers', 'delivery']);
//AddEventHandler('sale', 'OnSaleComponentOrderOneStepPaySystem', ['SproEventHandlers', 'payment']);
AddEventHandler("main", "OnEndBufferContent", ['SproEventHandlers', 'ChangeNbspContent']);
class SproEventHandlers
{
	static function delivery(&$arResult, &$arUserResult, $arParams)
	{
		$delivery = IBLOCKS['delivery'];
		$delivery = json_decode($delivery);
		if($delivery)
		{
			$selectDelete = false;
			foreach ($arResult['DELIVERY'] as $k => $item)
			{
				if ( !in_array( $item['ID'], $delivery ))
				{
					if ($item['CHECKED'] == 'Y')
					{
						$selectDelete = true;
					}
					unset( $arResult['DELIVERY'][ $k ] );
				}
			}

			if ($selectDelete)
			{
				$k = array_key_first( $arResult['DELIVERY'] );

				$arResult['DELIVERY'][ $k ]['CHECKED'] = 'Y';
			}
		}
	}

	static function payment(&$arResult, &$arUserResult, $arParams)
	{
		$payment = IBLOCKS['payment'];
		$payment = json_decode($payment);

		if($payment)
		{
			$selectDelete = false;
			foreach ($arResult['PAY_SYSTEM'] as $k => $item)
			{
				if ( !in_array( $item['ID'], $payment ))
				{
					if ($item['CHECKED'] == 'Y')
					{
						$selectDelete = true;
					}
					unset( $arResult['PAY_SYSTEM'][ $k ] );
				}
			}

			if ($selectDelete)
			{
				$k = array_key_first( $arResult['PAY_SYSTEM'] );

				$arResult['PAY_SYSTEM'][ $k ]['CHECKED'] = 'Y';
			}
		}
	}

	public static function ChangeNbspContent(&$content)
	{
		if (
			!CSite::InDir( '/bitrix/' ) && !CSite::InDir( '/local/' ) && SITE_ID != 's1' && php_sapi_name() != 'cli'
		)
		{
			$content = str_replace('&nbsp;', ' ', $content);
		}
	}

}
