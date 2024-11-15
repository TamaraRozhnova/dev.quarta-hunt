<?

use Bitrix\Sale\BusinessValue;
use Bitrix\Sale\BusinessValueConsumer1C;
use Bitrix\Sale;
use Bitrix\Sale\Exchange\Internals\LoggerDiag;
use Bitrix\Sale\Exchange\Logger\Exchange;

class BitSaleExport extends CSaleExport
{
	public static function ExportOrders2Xml($arFilter = Array(), $nTopCount = 0, $currency = "", $crmMode = false, $time_limit = 0, $version = false, $arOptions = Array())
	{
		$lastOrderPrefix = '';
		$arCharSets = array();
		$lastDateUpdateOrders = array();
		$entityMarker = static::getEntityMarker();

	    self::setVersionSchema($version);
		self::setCrmMode($crmMode);
		self::setCurrencySchema($currency);

		$count = false;
		if(intval($nTopCount) > 0)
			$count = Array("nTopCount" => $nTopCount);

		$end_time = self::getEndTime($time_limit);

		if(intval($time_limit) > 0)
		{
			if(self::$crmMode)
			{
				$lastOrderPrefix = md5(serialize($arFilter));
				if(!empty($_SESSION["BX_CML2_EXPORT"][$lastOrderPrefix]) && intval($nTopCount) > 0)
					$count["nTopCount"] = $count["nTopCount"]+count($_SESSION["BX_CML2_EXPORT"][$lastOrderPrefix]);
			}
		}

		if(!self::$crmMode)
        {
			$arFilter = static::prepareFilter($arFilter);
			$timeUpdate = isset($arFilter[">=DATE_UPDATE"])? $arFilter[">=DATE_UPDATE"]:'';
            $lastDateUpdateOrders = static::getLastOrderExported($timeUpdate);
        }

		self::$arResultStat = array(
			"ORDERS" => 0,
			"CONTACTS" => 0,
			"COMPANIES" => 0,
		);

		$bExportFromCrm = self::isExportFromCRM($arOptions);

		$arStore = self::getCatalogStore();
		$arMeasures = self::getCatalogMeasure();
		self::setCatalogMeasure($arMeasures);
		$arAgent = self::getSaleExport();

		if (self::$crmMode)
		{
			self::setXmlEncoding("UTF-8");
			$arCharSets = self::getSite();
		}

		echo self::getXmlRootName();?>

<<?=CSaleExport::getTagName("SALE_EXPORT_COM_INFORMATION")?> <?=self::getCmrXmlRootNameParams()?>><?

		$arOrder = array("DATE_UPDATE" => "ASC", "ID"=>"ASC");

		$arSelect = array(
			"ID", "LID", "PERSON_TYPE_ID", "PAYED", "DATE_PAYED", "EMP_PAYED_ID", "CANCELED", "DATE_CANCELED",
			"EMP_CANCELED_ID", "REASON_CANCELED", "STATUS_ID", "DATE_STATUS", "PAY_VOUCHER_NUM", "PAY_VOUCHER_DATE", "EMP_STATUS_ID",
			"PRICE_DELIVERY", "ALLOW_DELIVERY", "DATE_ALLOW_DELIVERY", "EMP_ALLOW_DELIVERY_ID", "PRICE", "CURRENCY", "DISCOUNT_VALUE",
			"SUM_PAID", "USER_ID", "PAY_SYSTEM_ID", "DELIVERY_ID", "DATE_INSERT", "DATE_INSERT_FORMAT", "DATE_UPDATE", "USER_DESCRIPTION",
			"ADDITIONAL_INFO",
			"COMMENTS", "TAX_VALUE", "STAT_GID", "RECURRING_ID", "ACCOUNT_NUMBER", "SUM_PAID", "DELIVERY_DOC_DATE", "DELIVERY_DOC_NUM", "TRACKING_NUMBER", "STORE_ID",
			"ID_1C", "VERSION",
			"USER.XML_ID", "USER.TIMESTAMP_X"
		);

		$bCrmModuleIncluded = false;
		if ($bExportFromCrm)
		{
			$arSelect[] = "UF_COMPANY_ID";
			$arSelect[] = "UF_CONTACT_ID";
			if (IsModuleInstalled("crm") && CModule::IncludeModule("crm"))
				$bCrmModuleIncluded = true;
		}

		$arFilter['RUNNING'] = 'N';

		$filter = array(
			'select' => $arSelect,
			'filter' => $arFilter,
			'order'  => $arOrder,
			'limit'  => $count["nTopCount"]
		);

		if (!empty($arOptions['RUNTIME']) && is_array($arOptions['RUNTIME']))
		{
			$filter['runtime'] = $arOptions['RUNTIME'];
		}

		$entity = static::getParentEntityTable();

        $dbOrderList = $entity::getList($filter);

		while($arOrder = $dbOrderList->Fetch())
		{
		    if(!self::$crmMode && (new Exchange(Sale\Exchange\Logger\ProviderType::ONEC_NAME))->isEffected($arOrder, $lastDateUpdateOrders))
            {
				continue;
            }

		    static::$documentsToLog = array();
			$contentToLog = '';

		    $order = static::load($arOrder['ID']);
			$arOrder['DATE_STATUS'] = $arOrder['DATE_STATUS']->toString();
		    $arOrder['DATE_INSERT'] = $arOrder['DATE_INSERT']->toString();
		    $arOrder['DATE_UPDATE'] = $arOrder['DATE_UPDATE']->toString();

			foreach($arOrder as $field=>$value)
			{
			    if(self::isFormattedDateFields('Order', $field))
			    {
			        $arOrder[$field] = self::getFormatDate($value);
			    }
			}

			if (self::$crmMode)
			{
				if(self::getVersionSchema() > self::DEFAULT_VERSION && is_array($_SESSION["BX_CML2_EXPORT"][$lastOrderPrefix]) && in_array($arOrder["ID"], $_SESSION["BX_CML2_EXPORT"][$lastOrderPrefix]) && empty($arFilter["ID"]))
					continue;
				ob_start();
			}

			self::$arResultStat["ORDERS"]++;

			$agentParams = (array_key_exists($arOrder["PERSON_TYPE_ID"], $arAgent) ? $arAgent[$arOrder["PERSON_TYPE_ID"]] : array() );

			$arResultPayment = self::getPayment($arOrder);
			$paySystems = $arResultPayment['paySystems'] ?? [];
			$arPayment = $arResultPayment['payment'] ?? [];
			
			$changedSumTotal = false;
			if (!empty($arPayment)) {
				$firstPayment = reset($arPayment);
				if (isset($firstPayment['PAY_SYSTEM_ID']) && $firstPayment['PAY_SYSTEM_ID'] == 16) {
					$changedSumTotal = [
						'before' => $arOrder['SUM_PAID'],
						'after' => $firstPayment['PS_SUM']
					];
					$arOrder['PRICE'] = $firstPayment['PS_SUM'];
					$arOrder['SUM_PAID'] = $firstPayment['PS_SUM'];
				}
			}

			$arResultShipment = self::getShipment($arOrder);
			$arShipment = $arResultShipment['shipment'] ?? [];
			$delivery = $arResultShipment['deliveryServices'] ?? [];

			self::setDeliveryAddress('');
			self::setSiteNameByOrder($arOrder);

			$arProp = self::prepareSaleProperty($arOrder, $bExportFromCrm, $bCrmModuleIncluded, $paySystems, $delivery, $locationStreetPropertyValue, $order);
			$agent = self::prepareSalePropertyRekv($order, $agentParams, $arProp, $locationStreetPropertyValue);

			$arOrderTax = CSaleExport::getOrderTax($order);
			$xmlResult['OrderTax'] = self::getXMLOrderTax($arOrderTax);
			self::setOrderSumTaxMoney(self::getOrderSumTaxMoney($arOrderTax));

			$xmlResult['Contragents'] = self::getXmlContragents($arOrder, $arProp, $agent, $bExportFromCrm ? array("EXPORT_FROM_CRM" => "Y") : array());
			$xmlResult['OrderDiscount'] = self::getXmlOrderDiscount($arOrder);
			$xmlResult['SaleStoreList'] = $arStore;
			$xmlResult['ShipmentsStoreList'] = self::getShipmentsStoreList($order);
			// self::getXmlSaleStoreBasket($arOrder,$arStore);
			$basketItems = self::getXmlBasketItems('Order', $arOrder, array('ORDER_ID'=>$arOrder['ID']), array(), $arShipment, false, $changedSumTotal);

            $numberItems = array();
            foreach($basketItems['result'] as $basketItem)
            {
                $number = self::getNumberBasketPosition($basketItem["ID"]);

                if(in_array($number, $numberItems))
                {
					$r = new \Bitrix\Sale\Result();
					$r->addWarning(new \Bitrix\Main\Error(GetMessage("SALE_EXPORT_REASON_MARKED_BASKET_PROPERTY").'1C_Exchange:Order.export.basket.properties', 'SALE_EXPORT_REASON_MARKED_BASKET_PROPERTY'));
					$entityMarker::addMarker($order, $order, $r);
					$order->setField('MARKED','Y');
					$order->setField('DATE_UPDATE',null);
					$order->save();
                    break;
                }
                else
                {
                    $numberItems[] = $number;
                }
            }

			$xmlResult['BasketItems'] = $basketItems['outputXML'];
			$xmlResult['SaleProperties'] = self::getXmlSaleProperties($arOrder, $arShipment, $arPayment, $agent, $agentParams, $bExportFromCrm);
			$xmlResult['RekvProperties'] = self::getXmlRekvProperties($agent, $agentParams);


			if(self::getVersionSchema() >= self::CONTAINER_VERSION)
            {
                ob_start();
				echo '<'.CSaleExport::getTagName("SALE_EXPORT_CONTAINER").'>';
            }

			self::OutputXmlDocument('Order', $xmlResult, $arOrder);

			if(self::getVersionSchema() >= self::PARTIAL_VERSION)
			{
				self::OutputXmlDocumentsByType('Payment',$xmlResult, $arOrder, $arPayment, $order, $agentParams, $arProp, $locationStreetPropertyValue);
				self::OutputXmlDocumentsByType('Shipment',$xmlResult, $arOrder, $arShipment, $order, $agentParams, $arProp, $locationStreetPropertyValue);
				self::OutputXmlDocumentRemove('Shipment',$arOrder);
			}

			if(self::getVersionSchema() >= self::CONTAINER_VERSION)
			{
				echo '</'.CSaleExport::getTagName("SALE_EXPORT_CONTAINER").'>';
				$contentToLog = ob_get_contents();
				ob_end_clean();
				echo $contentToLog;
			}

			if (self::$crmMode)
			{
				$c = ob_get_clean();
				$c = CharsetConverter::ConvertCharset($c, $arCharSets[$arOrder["LID"]], "utf-8");
				echo $c;
				$_SESSION["BX_CML2_EXPORT"][$lastOrderPrefix][] = $arOrder["ID"];
			}
			else
			{
				static::saveExportParams($arOrder);
			}

			ksort(static::$documentsToLog);

			foreach (static::$documentsToLog as $entityTypeId=>$documentsToLog)
			{
				foreach ($documentsToLog as $documentToLog)
				{
					$fieldToLog = $documentToLog;
					$fieldToLog['ENTITY_TYPE_ID'] = $entityTypeId;
					if(self::getVersionSchema() >= self::CONTAINER_VERSION)
					{
						if($entityTypeId == \Bitrix\Sale\Exchange\EntityType::ORDER )
							$fieldToLog['MESSAGE'] = $contentToLog;
					}
					static::log($fieldToLog);
				}
			}

			if(self::checkTimeIsOver($time_limit, $end_time))
			{
				break;
			}
		}
		?>

	</<?=CSaleExport::getTagName("SALE_EXPORT_COM_INFORMATION")?>><?

		return self::$arResultStat;
	}
	
	public static function getXmlBasketItems($type, $arOrder, $arFilter, $arSelect=array(), $arShipment=array(), $order=null, $changedSum = false)
	{
		$result = array();
		$entity = static::getBasketTable();
		$select = array("ID", "NOTES", "PRODUCT_XML_ID", "CATALOG_XML_ID", "NAME", "PRICE", "QUANTITY", "DISCOUNT_PRICE", "VAT_RATE", "MEASURE_CODE", "SET_PARENT_ID", "TYPE", "VAT_INCLUDED", "MARKING_CODE_GROUP");
		if(count($arSelect)>0)
		    $select = array_merge($arSelect, $select);
		
		$minusDiscountPrice = 0;
		if (is_array($changedSum)) {
			$countItems = 0;
			$dbBasket = $entity::getList(array(
				'select' => $select,
				'filter' => $arFilter,
				'order' => array("NAME" => "ASC")
			));
			while ($arBasket = $dbBasket->fetch()) {
				if(strval($arBasket['TYPE'])!='' && $arBasket['TYPE']== \Bitrix\Sale\BasketItem::TYPE_SET) continue;
				$countItems++;
			}
			$newPriceBetween = $changedSum['before'] - $changedSum['after'];
			if ($newPriceBetween > 0) $minusDiscountPrice = $newPriceBetween/$countItems;
		}

		ob_start();
		?><<?=CSaleExport::getTagName("SALE_EXPORT_ITEMS")?>><?

		

		$dbBasket = $entity::getList(array(
			'select' => $select,
			'filter' => $arFilter,
			'order' => array("NAME" => "ASC")
		));

		$basketSum = 0;
		$priceType = "";
		$bVat = false;
		$vatRate = 0;
		$vatSum = 0;
		while ($arBasket = $dbBasket->fetch())
		{
			if(strval($arBasket['TYPE'])!='' && $arBasket['TYPE']== \Bitrix\Sale\BasketItem::TYPE_SET)
			    continue;
			
			if ($minusDiscountPrice > 0) {
				$arBasket["PRICE"] -= $minusDiscountPrice;
				$arBasket["DISCOUNT_PRICE"] += $minusDiscountPrice;
			}

			$result[] = $arBasket;

			if($priceType == '')
				$priceType = $arBasket["NOTES"];
			?>
			<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ID")?>><?=htmlspecialcharsbx(static::normalizeExternalCode($arBasket["PRODUCT_XML_ID"]))?></<?=CSaleExport::getTagName("SALE_EXPORT_ID")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_CATALOG_ID")?>><?=htmlspecialcharsbx($arBasket["CATALOG_XML_ID"])?></<?=CSaleExport::getTagName("SALE_EXPORT_CATALOG_ID")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=htmlspecialcharsbx($arBasket["NAME"])?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
				<?

            	static::outputXmlUnit($arBasket);
            	
				if($type == 'Order')
				{
					static::outputXmlMarkingCodeGroup($arBasket);
				}
				elseif($type == 'Shipment')
				{	
					static::outputXmlMarkingCode($arBasket['SALE_INTERNALS_BASKET_SHIPMENT_ITEM_ID'], $order);					
				}
				
				if(DoubleVal($arBasket["DISCOUNT_PRICE"]) > 0)
			 	{
					?>
					<<?=CSaleExport::getTagName("SALE_EXPORT_DISCOUNTS")?>>
						<<?=CSaleExport::getTagName("SALE_EXPORT_DISCOUNT")?>>
							<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_ITEM_DISCOUNT")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
							<<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>><?=$arBasket["DISCOUNT_PRICE"]?></<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>>
							<<?=CSaleExport::getTagName("SALE_EXPORT_IN_PRICE")?>>true</<?=CSaleExport::getTagName("SALE_EXPORT_IN_PRICE")?>>
						</<?=CSaleExport::getTagName("SALE_EXPORT_DISCOUNT")?>>
					</<?=CSaleExport::getTagName("SALE_EXPORT_DISCOUNTS")?>>
					<?
				}
				?>
				<?if(self::getVersionSchema() >= self::PARTIAL_VERSION && $type == 'Shipment')
				{?>
				<<?=CSaleExport::getTagName("SALE_EXPORT_PRICE_PER_ITEM")?>><?=$arBasket["PRICE"]?></<?=CSaleExport::getTagName("SALE_EXPORT_PRICE_PER_ITEM")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_QUANTITY")?>><?=$arBasket["SALE_INTERNALS_BASKET_SHIPMENT_ITEM_QUANTITY"]?></<?=CSaleExport::getTagName("SALE_EXPORT_QUANTITY")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>><?=$arBasket["PRICE"]*$arBasket["SALE_INTERNALS_BASKET_SHIPMENT_ITEM_QUANTITY"]?></<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>>
				<?}
				else{
				?>
				<<?=CSaleExport::getTagName("SALE_EXPORT_PRICE_PER_ITEM")?>><?=$arBasket["PRICE"]?></<?=CSaleExport::getTagName("SALE_EXPORT_PRICE_PER_ITEM")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_QUANTITY")?>><?=$arBasket["QUANTITY"]?></<?=CSaleExport::getTagName("SALE_EXPORT_QUANTITY")?>>
				<<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>><?=$arBasket["PRICE"]*$arBasket["QUANTITY"]?></<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>>
				<?}?>
				<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTIES_VALUES")?>>
					<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
						<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_TYPE_NOMENKLATURA")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
						<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=CSaleExport::getTagName("SALE_EXPORT_ITEM")?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
					</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
					<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
						<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_TYPE_OF_NOMENKLATURA")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
						<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=CSaleExport::getTagName("SALE_EXPORT_ITEM")?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
					</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>

					<?
					$number = self::getNumberBasketPosition($arBasket["ID"]);
					?>
					<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
						<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_BASKET_NUMBER")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
						<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=$number?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
					</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
					<?
					$dbProp = CSaleBasket::GetPropsList(Array("SORT" => "ASC", "ID" => "ASC"), Array("BASKET_ID" => $arBasket["ID"]), false, false, array("NAME", "SORT", "VALUE", "CODE"));
					while($arPropBasket = $dbProp->Fetch())
					{
						?>
						<<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
							<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE_BASKET")?>#<?=($arPropBasket["CODE"] != "" ? $arPropBasket["CODE"]:htmlspecialcharsbx($arPropBasket["NAME"]))?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
							<<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>><?=htmlspecialcharsbx($arPropBasket["VALUE"])?></<?=CSaleExport::getTagName("SALE_EXPORT_VALUE")?>>
						</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTY_VALUE")?>>
						<?
					}
					?>
				</<?=CSaleExport::getTagName("SALE_EXPORT_PROPERTIES_VALUES")?>>
				<?if(DoubleVal($arBasket["VAT_RATE"]) > 0)
				{
					$bVat = true;
					$vatRate = DoubleVal($arBasket["VAT_RATE"]);
					$basketVatSum = (($arBasket["PRICE"] / ($arBasket["VAT_RATE"]+1)) * $arBasket["VAT_RATE"]);
					$vatSum += roundEx($basketVatSum * $arBasket["QUANTITY"], 2);
					?>
					<<?=CSaleExport::getTagName("SALE_EXPORT_TAX_RATES")?>>
						<<?=CSaleExport::getTagName("SALE_EXPORT_TAX_RATE")?>>
							<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_VAT")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
							<<?=CSaleExport::getTagName("SALE_EXPORT_RATE")?>><?=$arBasket["VAT_RATE"] * 100?></<?=CSaleExport::getTagName("SALE_EXPORT_RATE")?>>
						</<?=CSaleExport::getTagName("SALE_EXPORT_TAX_RATE")?>>
					</<?=CSaleExport::getTagName("SALE_EXPORT_TAX_RATES")?>>
					<<?=CSaleExport::getTagName("SALE_EXPORT_TAXES")?>>
						<<?=CSaleExport::getTagName("SALE_EXPORT_TAX")?>>
							<<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>><?=CSaleExport::getTagName("SALE_EXPORT_VAT")?></<?=CSaleExport::getTagName("SALE_EXPORT_ITEM_NAME")?>>
							<<?=CSaleExport::getTagName("SALE_EXPORT_IN_PRICE")?>><?=$arBasket["VAT_INCLUDED"]=="Y"?'true':'false'?></<?=CSaleExport::getTagName("SALE_EXPORT_IN_PRICE")?>>
							<<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>><?=roundEx($basketVatSum, 2)?></<?=CSaleExport::getTagName("SALE_EXPORT_AMOUNT")?>>
						</<?=CSaleExport::getTagName("SALE_EXPORT_TAX")?>>
					</<?=CSaleExport::getTagName("SALE_EXPORT_TAXES")?>>
					<?
				}
				?>
				<?//=self::getXmlSaleStoreBasket($arOrder,$arStore)?>
			</<?=CSaleExport::getTagName("SALE_EXPORT_ITEM")?>>
			<?
			$basketSum += $arBasket["PRICE"]*$arBasket["QUANTITY"];
		}

        if(self::getVersionSchema() >= self::PARTIAL_VERSION)
        {
            if(count($arShipment)>0)
            {
                foreach($arShipment as $shipment)
                {
                    self::getOrderDeliveryItem($shipment, $bVat, $vatRate, $vatSum);
                }
            }
        }
        else
		    self::getOrderDeliveryItem($arOrder, $bVat, $vatRate, $vatSum);

		?>
		</<?=CSaleExport::getTagName("SALE_EXPORT_ITEMS")?>><?

		$bufer = ob_get_clean();
		return array('outputXML'=>$bufer,'result'=>$result);
	}
	
	public static function getPayment($arOrder)
	{
		$result = array();
		$entity = static::getPaymentTable();

		$PaymentParam['select'] =
			array(
				"ID",
				"ID_1C",
				"PAID",
				"DATE_BILL",
				"ORDER_ID",
				"CURRENCY",
				"SUM",
				"COMMENTS",
				"DATE_PAID",
				"PAY_SYSTEM_ID",
				"PAY_SYSTEM_NAME",
				"IS_RETURN",
				"PAY_RETURN_COMMENT",
				"PAY_VOUCHER_NUM",
				"PAY_VOUCHER_DATE",
				"PS_SUM",
			);


		$PaymentParam['filter']['ORDER_ID'] = $arOrder['ID'];
		$PaymentParam['filter']['!=EXTERNAL_PAYMENT'] = 'F';
		$innerPS = 0;
		$limit = 0;
		$inc = 0;

		if(self::getVersionSchema() < self::PARTIAL_VERSION)
		{
			$innerPS = \Bitrix\Sale\PaySystem\Manager::getInnerPaySystemId();
			$limit = 1;
		}

		$resPayment = $entity::getList($PaymentParam);

		while($arPayment = $resPayment->fetch())
		{
			foreach($arPayment as $field=>$value)
			{
			    if(self::isFormattedDateFields('Payment', $field))
			    {
			        $arPayment[$field] = self::getFormatDate($value);
			    }
			}
			
			if ($arPayment['PAY_SYSTEM_ID'] == 16 && $arPayment['PS_SUM'] != '') {
				$arPayment['SUM'] = $arPayment['PS_SUM'];
			}

            $result['paySystems'][$arPayment['PAY_SYSTEM_ID']] = $arPayment['PAY_SYSTEM_NAME'];

			if($innerPS == 0 || $innerPS!=$arPayment['PAY_SYSTEM_ID'])
			{
			    if($limit == 0 || $inc < $limit)
			        $result['payment'][] = $arPayment;

			    $inc++;
			}
		}
		return $result;
	}
	
}