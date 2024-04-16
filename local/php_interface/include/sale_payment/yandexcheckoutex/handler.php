<?php

namespace Sale\Handlers\PaySystem;
use Sale\Handlers\PaySystem\YandexCheckoutVSHandler;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/vampirus.yandexkassa/payment/yandexcheckoutvs/handler.php");

class YandexCheckoutExHandler extends YandexCheckoutVSHandler
{
	/**
	 * @var const Параметр для кредита/рассрочки
	 */
    const PAYMENT_METHOD_CREDIT = 'sber_loan';

	/**
	 * Возвращает наименования доступных
	 * типов платежных систем
	 * 
	 * @return array
	 */
	public static function getHandlerModeList()
	{
		return [
            static::PAYMENT_METHOD_CREDIT => Loc::getMessage('PAYMENT_METHOD_CREDIT_TITLE'),
		];
	}

}