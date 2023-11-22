<?

namespace Cadesign\AjaxRequest;

use CSaleBasket;

class Basket extends \CAjaxRequest
{
	/**
	 * @return array
	 */
	public function updateBasket()
	{
		$arResult = &$this->arResult;
		$arParams = &$this->arParams;
		global $APPLICATION;

		$ID = intval($arParams[ "product" ]);
		$quantity = intval($arParams[ "q" ])??1;

		$obBasket = CSaleBasket::GetList(array(), array('FUSER_ID' => CSaleBasket::GetBasketUserID(), 'ORDER_ID' => 'NULL'), false);
		$arBasket = [];
		while ($curItem = $obBasket->Fetch())
		{
			$arBasket[ $curItem[ "PRODUCT_ID" ] ] = $curItem;
		}

		$arResult[ "b_item" ] = $ID;
		if ($arParams[ "method" ] == "add")
		{
			$b_item = $arBasket[ $ID ];

			if ($b_item[ 'ID' ])
				CSaleBasket::Update($b_item[ 'ID' ], array('QUANTITY' => $b_item[ 'QUANTITY' ] + $quantity));
			else
				Add2BasketByProductID($ID, $quantity);
		}
		else
		{
			$b_item = $arBasket[ $ID ];

			if ($b_item[ 'ID' ])
				CSaleBasket::Update($b_item[ 'ID' ], array('QUANTITY' => $quantity));
			else
				Add2BasketByProductID($ID, $quantity);
		}

		ob_start();
		$this->getCurrentBasket();
		$arResult[ "popupBasket" ] = ob_get_contents();
		ob_end_clean();

		if ($arParams[ "extra" ] == "getBigBasket")
		{
			ob_start();
			$this->getBigBasket();
			$arResult[ "bigBasket" ] = ob_get_contents();
			ob_end_clean();
		}

		ob_start();
		echo $APPLICATION->GetViewContent('BASKET_PRODUCT_COUNT');
		$arResult[ "count" ] = ob_get_contents();
		ob_end_clean();

		return $arResult;
	}

	public function deleteProduct()
	{
		$arResult = &$this->arResult;
		$arParams = &$this->arParams;
		global $APPLICATION;

		//		\CSaleBasket::Delete( intval( $arParams[ 'id' ] ) );

		$basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), \Bitrix\Main\Context::getCurrent()->getSite());
		$basket->getItemById(intval($arParams[ 'id' ]))->delete();
		$basket->save();

		ob_start();
		$this->getCurrentBasket();
		$arResult[ "popupBasket" ] = ob_get_contents();
		ob_end_clean();

		ob_start();
		echo $APPLICATION->GetViewContent('BASKET_PRODUCT_COUNT');
		$arResult[ "count" ] = ob_get_contents();
		ob_end_clean();

		if ($arParams[ "extra" ] == "getBigBasket")
		{
			ob_start();
//			printr($basket->getItemById(intval($arParams[ 'id' ])));
			$this->getBigBasket();
			$arResult[ "bigBasket" ] = ob_get_contents();
			ob_end_clean();
		}

		return $arResult;
	}

	public function getCurrentBasket()
	{
		global $APPLICATION;
		$APPLICATION->IncludeFile('/_includes/_modal_cart.php', false, array('SHOW_BORDER' => false));
	}

	private function getBigBasket()
	{
		global $APPLICATION;

		$APPLICATION->IncludeFile('/_includes/cart/_cart.php', false, array('SHOW_BORDER' => false));
	}

	public function applyCoupon()
	{
		$arResult = &$this->arResult;
		$arParams = &$this->arParams;
		global $APPLICATION;

		\Bitrix\Sale\DiscountCouponsManager::clear();
		$discount_coupon = \Bitrix\Sale\Internals\DiscountCouponTable::getRow(array(
			'select' => array("COUPON"),
			'order' => array("ID" => "DESC"),
			'filter' => array("COUPON" => htmlspecialcharsbx(trim($_POST[ 'coupon' ])), "ACTIVE" => "Y",)
		));

		$arResult["CHECK_COUPON"] = "Y";

		if ($discount_coupon[ "COUPON" ])
			$arResult[ 'VALID_COUPON' ] = \Bitrix\Sale\DiscountCouponsManager::add($discount_coupon[ "COUPON" ]);

		if ($arResult[ 'VALID_COUPON' ])
		{
			$arResult[ "result" ] = "success";
		}
		else
		{
			$arResult[ "result" ] = "error";
			$arResult[ "err" ] = "Купон недействителен или указан неверно";
		}

		ob_start();
		$this->getCurrentBasket();
		$arResult[ "popupBasket" ] = ob_get_contents();
		ob_end_clean();

		ob_start();
		echo $APPLICATION->GetViewContent('BASKET_PRODUCT_COUNT');
		$arResult[ "basketCount" ] = ob_get_contents();
		ob_end_clean();

		if ($arParams[ "extra" ] == "getBigBasket")
		{
			ob_start();
			$this->getBigBasket();
			$arResult[ "bigBasket" ] = ob_get_contents();
			ob_end_clean();
		}

		return $arResult;
	}

	public function clearBasket()
	{
		$arResult = &$this->arResult;
		$arParams = &$this->arParams;
		global $APPLICATION;

		CSaleBasket::DeleteAll( CSaleBasket::GetBasketUserID());

		ob_start();
		$this->getCurrentBasket();
		$arResult[ "popupBasket" ] = ob_get_contents();
		ob_end_clean();

		ob_start();
		echo $APPLICATION->GetViewContent('BASKET_PRODUCT_COUNT');
		$arResult[ "basketCount" ] = ob_get_contents();
		ob_end_clean();

		if ($arParams[ "extra" ] == "getBigBasket")
		{
			ob_start();
			$this->getBigBasket();
			$arResult[ "bigBasket" ] = ob_get_contents();
			ob_end_clean();
		}

		return $arResult;
	}
}
