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
			
			if (!empty($arPayment)) {
				$firstPayment = reset($arPayment);
				if (isset($firstPayment['PAY_SYSTEM_ID']) && $firstPayment['PAY_SYSTEM_ID'] == 16) {
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
			$basketItems = self::getXmlBasketItems('Order', $arOrder, array('ORDER_ID'=>$arOrder['ID']), array(), $arShipment);

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