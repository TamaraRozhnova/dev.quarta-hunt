<?php

namespace Lib\Russianpost\Post;

use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Text\Encoding;
use Bitrix\Sale\Result;
use Bitrix\Main\Error;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

Loader::includeModule('sale');
ini_set("xdebug.overload_var_dump", "off");
ini_set("xdebug.mode", "off");
class Request
{

    protected $httpClient;

    protected static $url_https = "https://cms.pochta.ru/api/cms/";
    protected static $url_calculate = "https://widget.pochta.ru/api/pvz/courier_tariff_public";
    protected static $url_calculate_pvz = "https://widget.pochta.ru/api/pvz/pick_up_tariff_public";
    protected static $url_calculate_pvz_simple = "https://widget.pochta.ru/api/pvz/index_public";
    const INSTALL_PATH = 'install';

    const UNINSTALL_PATH = 'uninstall';

    const ORDER_PATH = 'orders_public';

    private static $MODULE_ID = 'russianpost.post';

    protected static $orderLogPath = "bitrix/js/russianpost.post/log/log_order.log";
    protected static $calculateLogPath = "bitrix/js/russianpost.post/log/log_calculate.log";
    protected static $keyLogPath = "bitrix/js/russianpost.post/log/log_key.log";

    public function __construct()
    {
        $this->httpClient = new \Bitrix\Main\Web\HttpClient(array(
            "version" => "1.1",
            "socketTimeout" => 30,
            "streamTimeout" => 30,
            "redirect" => true,
            "redirectMax" => 5,
        ));

        //$this->httpClient->setHeader("Content-Type", "application/json");
    }
    /**
     * @param $requestData
     * @return Result
     */
    public function send($requestData, $requestUrl)
    {
        $result = new Result();
        if(strtolower(SITE_CHARSET) != 'utf-8')
            $requestData = Encoding::convertEncodingArray($requestData, SITE_CHARSET, 'UTF-8');
        $httpRes = $this->httpClient->post($requestUrl, $requestData);
        $errors = $this->httpClient->getError();
        if (!$httpRes && !empty($errors))
        {
            $strError = "";

            foreach($errors as $errorCode => $errMes)
                $strError .= $errorCode.": ".$errMes;

            $result->addError(new Error(Loc::getMessage('SALE_DLV_RUSSIANPOST_POST_ERROR_HTTP_PUBLIC')));

            $eventLog = new \CEventLog;
            $eventLog->Add(array(
                "SEVERITY" => $eventLog::SEVERITY_ERROR,
                "AUDIT_TYPE_ID" => "SALE_DELIVERY_HANDLER_SPSR_HTTP_ERROR",
                "MODULE_ID" => self::$MODULE_ID,
                "ITEM_ID" => 'REQUEST',
                "DESCRIPTION" => Loc::getMessage('SALE_DLV_RUSSIANPOST_POST_ERROR_HTTP').":".$strError,
            ));
        }
        else
        {
            $status = $this->httpClient->getStatus();

            if ($status != 200)
            {
                $result->addError(new Error(Loc::getMessage('SALE_DLV_RUSSIANPOST_POST_ERROR_HTTP_PUBLIC')));

                $eventLog = new \CEventLog;
                $eventLog->Add(array(
                    "SEVERITY" => $eventLog::SEVERITY_ERROR,
                    "AUDIT_TYPE_ID" => "SALE_DELIVERY_HANDLER_SPSR_HTTP_STATUS_ERROR",
                    "MODULE_ID" => self::$MODULE_ID,
                    "ITEM_ID" => 'REQUEST',
                    "DESCRIPTION" => Loc::getMessage('SALE_DLV_RUSSIANPOST_POST_ERROR_HTTP_STATUS').": ".$status,
                ));
            }
            else
            {
                $jsonAnswer = json_decode($httpRes, true);
                $result->addData(array($jsonAnswer));
            }


        }

        return $result;
    }

    public function GetAuthKey($doman)
    {
        $requestData = [
            'subdomain'  => $doman,
            'cmsVersion' => SM_VERSION,
            'cmsType'    => 'bitrix_cms',
        ];
        $guid_id = Option::get(self::$MODULE_ID, "GUID_ID");
        $debugKey = Option::get(self::$MODULE_ID, "RUSSIANPOST_KEY_DEBUG");
        if(trim($guid_id != ''))
        {
            $requestData['guid_id'] = $guid_id;
        }
        $requestUrl = self::$url_https.self::INSTALL_PATH;
        $res = $this->send($requestData, $requestUrl);
        if($debugKey == 'Y')
        {
            $arRes = self::objectToArray($res);
            \Bitrix\Main\Diag\Debug::writeToFile($requestData, "request", self::$keyLogPath);
            \Bitrix\Main\Diag\Debug::writeToFile($arRes, "answer", self::$keyLogPath);
        }
        if($res->isSuccess())
        {
            $data = $res->getData();
            return $data[0];
        }
        else
        {
            return false;
        }
        /*#ПОЛУЧАЕМ ОТВЕТ JSON
        #ЗАГЛУШКА
        $array_response = array('subdomain' => $doman, 'guidId' => 'GUIDIDRRR', 'guidKey' => 'GUIDKEYGGHGHG', 'cmsVersion' => 'version');
        $jsondata = json_encode($array_response);
        #ЗАГЛУШКА
        $result = json_decode($jsondata, true);
        return $result;*/
    }

    public function UnInstallCabinet()
    {
        $guid_id = Option::get(self::$MODULE_ID, "GUID_ID");
        $guid_key = Option::get(self::$MODULE_ID, "GUID_KEY");

        $requestData = [
            'guid_id'  => $guid_id,
            'guid_key' => $guid_key,
        ];

        $requestUrl = self::$url_https.self::UNINSTALL_PATH;
        $res = $this->send($requestData, $requestUrl);

        if($res->isSuccess())
        {
            $data = $res->getData();
            return $data[0];
        }
        else
        {
            return false;
        }
    }

    public function CourierCalculate($arParams)
    {
        $guid_id = Option::get(self::$MODULE_ID, "GUID_ID");
        $debugCalculate = Option::get(self::$MODULE_ID, "RUSSIANPOST_CALCULATE_DEBUG");
        $requestData = ['order'=>[
            'account_id'=>$guid_id,
            'account_type'=>'bitrix_cms',
            'shipping_address'=>[
                'full_locality_name'=>$arParams['ADDRESS'],
                'location'=>[
                    'region_zip'=>$arParams['ZIP']
                ]],
            'items_price'=>$arParams['PRICE'],
            'total_weight'=>$arParams['WEIGHT'],
        ]];

        $res = $this->send($requestData, self::$url_calculate);
        if($debugCalculate == 'Y')
        {
            $arRes = self::objectToArray($res);
            \Bitrix\Main\Diag\Debug::writeToFile($requestData, "requestCourierCalculate", self::$calculateLogPath);
            \Bitrix\Main\Diag\Debug::writeToFile($arRes, "answerCourierCalculate", self::$calculateLogPath);
        }
        if($res->isSuccess())
        {
            $data = $res->getData();
            return $data[0];
        }
        else
        {
            return false;
        }
    }

    public function CourierWorldCalculate($arParams)
    {
        $guid_id = Option::get(self::$MODULE_ID, "GUID_ID");
        $debugCalculate = Option::get(self::$MODULE_ID, "RUSSIANPOST_CALCULATE_DEBUG");
        $requestData = ['order'=>[
            'account_id'=>$guid_id,
            'account_type'=>'bitrix_cms',
            'shipping_address'=>[
                'full_locality_name'=>$arParams['ADDRESS'],
                'location'=>[
                    'country'=>$arParams['DIGITAL_CODE']
                ]],
            'items_price'=>$arParams['PRICE'],
            'total_weight'=>$arParams['WEIGHT'],
        ]];

        $res = $this->send($requestData, self::$url_calculate);
        if($debugCalculate == 'Y')
        {
            $arRes = self::objectToArray($res);
            \Bitrix\Main\Diag\Debug::writeToFile($requestData, "requestWorldCourierCalculate", self::$calculateLogPath);
            \Bitrix\Main\Diag\Debug::writeToFile($arRes, "answerWorldCourierCalculate", self::$calculateLogPath);
        }
        if($res->isSuccess())
        {
            $data = $res->getData();
            return $data[0];
        }
        else
        {
            return false;
        }
    }

    public function SendOrder($arParams)
    {
        $guid_id = Option::get(self::$MODULE_ID, "GUID_ID");
        $guid_key = Option::get(self::$MODULE_ID, "GUID_KEY");
        $debugOrder = Option::get(self::$MODULE_ID, "RUSSIANPOST_ORDER_DEBUG");
        $arProducts = array();
        foreach ($arParams['PRODUCTS'] as $arProduct)
        {
            if(!empty($arProduct['MARK_CODE']))
            {
                foreach ($arProduct['MARK_CODE'] as $markCode)
                {
                    $product = array();
                    $product['api_order_line_id'] = $arProduct['ID'];
                    $product['api_order_type'] = "bitrix_cms";
                    $product['title'] = $arProduct['NAME'];
                    $product['value'] = $arProduct['PRICE'];
                    $product['weight'] = $arProduct['WEIGHT'];
                    $product['quantity'] = 1;
                    if($arProduct['HEIGHT'] > 0 || $arProduct['WIDTH'] > 0 || $arProduct['LENGTH'] > 0)
                    {
                        if($arProduct['HEIGHT'] > 0)
                            $product['dimension']['height'] = $arProduct['HEIGHT'];
                        if($arProduct['WIDTH'] > 0)
                            $product['dimension']['width'] = $arProduct['WIDTH'];
                        if($arProduct['LENGTH'] > 0)
                            $product['dimension']['length'] = $arProduct['LENGTH'];
                    }
                    $product['code'] = $markCode;
                    $arProducts[] = $product;
                }
            }
            else
            {
                $product = array();
                $product['api_order_line_id'] = $arProduct['ID'];
                $product['api_order_type'] = "bitrix_cms";
                $product['title'] = $arProduct['NAME'];
                $product['value'] = $arProduct['PRICE'];
                $product['weight'] = $arProduct['WEIGHT'];
                $product['quantity'] = $arProduct['QUANTITY'];
                if($arProduct['HEIGHT'] > 0 || $arProduct['WIDTH'] > 0 || $arProduct['LENGTH'] > 0)
                {
                    if($arProduct['HEIGHT'] > 0)
                        $product['dimension']['height'] = $arProduct['HEIGHT'];
                    if($arProduct['WIDTH'] > 0)
                        $product['dimension']['width'] = $arProduct['WIDTH'];
                    if($arProduct['LENGTH'] > 0)
                        $product['dimension']['length'] = $arProduct['LENGTH'];
                }
                if($arProduct['CODE'] != '')
                    $product['code'] = $arProduct['CODE'];
                $arProducts[] = $product;
            }
        }
        $requestData = [
            'user'=>[
                "guid_id" => $guid_id,
                "guid_key" => $guid_key,
                "cms_version" => SM_VERSION,
            ],
            'order'=>[
                "api_order_id" => $arParams['ORDER_ID'],
                "api_order_type" => "bitrix_cms",
                "insales_number" => $arParams['ACCOUNT_NUMBER'],
                "shipment_address_plugin" => $arParams['ADDRESS'],
                "shipment_index_plugin" => $arParams['ZIP'],
                "fio_plugin" => $arParams['NAME'],
                "phone_plugin" => $arParams['PHONE'],
                "weight" => $arParams['WEIGHT'],
                "shipment_type" => $arParams['SHIPMENT_TYPE'],
                "insr_value_plugin" => $arParams['PRICE'],
                "payment_plugin" => $arParams['PRICE'],
                "shop_delivery_cost" => $arParams['DELIVERY_PRICE'],
                "financial_status" => $arParams['FINANCIAL_STATUS'],
                "order_lines" => $arProducts,
            ]
        ];
        if(isset($arParams['WITH_NOTIFICATION']))
        {
            $requestData['order']['with_notification'] = 'true';
        }
        $requestUrl = self::$url_https.self::ORDER_PATH;
        $res = $this->send($requestData, $requestUrl);
        if($debugOrder == 'Y')
        {
            $arRes = self::objectToArray($res);
            \Bitrix\Main\Diag\Debug::writeToFile($requestData, "requestSendOrder", self::$orderLogPath);
            \Bitrix\Main\Diag\Debug::writeToFile($arRes, "answerSendOrder", self::$orderLogPath);
        }
        if($res->isSuccess())
        {
            $data = $res->getData();
            return $data[0];
        }
        else
        {
            return false;
        }
    }

    public function SendOrderWorld($arParams)
    {
        $guid_id = Option::get(self::$MODULE_ID, "GUID_ID");
        $guid_key = Option::get(self::$MODULE_ID, "GUID_KEY");
        $debugOrder = Option::get(self::$MODULE_ID, "RUSSIANPOST_ORDER_DEBUG");
        $arProducts = array();
        foreach ($arParams['PRODUCTS'] as $arProduct)
        {
            $product = array();
            $product['api_order_line_id'] = $arProduct['ID'];
            $product['api_order_type'] = "bitrix_cms";
            $product['title'] = $arProduct['NAME'];
            $product['value'] = $arProduct['PRICE'];
            $product['weight'] = $arProduct['WEIGHT'];
            $product['quantity'] = $arProduct['QUANTITY'];
            if($arProduct['HEIGHT'] > 0 || $arProduct['WIDTH'] > 0 || $arProduct['LENGTH'] > 0)
            {
                if($arProduct['HEIGHT'] > 0)
                    $product['dimension']['height'] = $arProduct['HEIGHT'];
                if($arProduct['WIDTH'] > 0)
                    $product['dimension']['width'] = $arProduct['WIDTH'];
                if($arProduct['LENGTH'] > 0)
                    $product['dimension']['length'] = $arProduct['LENGTH'];
            }
            if($arProduct['CODE'] != '')
                $product['code'] = $arProduct['CODE'];
            $arProducts[] = $product;
        }

        $requestData = [
            'user'=>[
                "guid_id" => $guid_id,
                "guid_key" => $guid_key,
                "cms_version" => SM_VERSION,
            ],
            'order'=>[
                "api_order_id" => $arParams['ORDER_ID'],
                "api_order_type" => "bitrix_cms",
                "insales_number" => $arParams['ACCOUNT_NUMBER'],
                "shipment_address_plugin" => $arParams['ADDRESS'],
                "shipment_index_plugin" => $arParams['DIGITAL_CODE'],
                "fio_plugin" => $arParams['NAME'],
                "phone_plugin" => $arParams['PHONE'],
                "weight" => $arParams['WEIGHT'],
                "shipment_type" => $arParams['SHIPMENT_TYPE'],
                "insr_value_plugin" => $arParams['PRICE'],
                "payment_plugin" => $arParams['PRICE'],
                "shop_delivery_cost" => $arParams['DELIVERY_PRICE'],
                "financial_status" => $arParams['FINANCIAL_STATUS'],
                "order_lines" => $arProducts,
            ]
        ];
        $requestUrl = self::$url_https.self::ORDER_PATH;
        $res = $this->send($requestData, $requestUrl);
        if($debugOrder == 'Y')
        {
            $arRes = self::objectToArray($res);
            \Bitrix\Main\Diag\Debug::writeToFile($requestData, "requestWorldSendOrder", self::$orderLogPath);
            \Bitrix\Main\Diag\Debug::writeToFile($arRes, "answerWorldSendOrder", self::$orderLogPath);
        }
        if($res->isSuccess())
        {
            $data = $res->getData();
            return $data[0];
        }
        else
        {
            return false;
        }
    }

    public function PickUpCalculate($arParams)
    {
        $guid_id = Option::get(self::$MODULE_ID, "GUID_ID");
        $debugCalculate = Option::get(self::$MODULE_ID, "RUSSIANPOST_CALCULATE_DEBUG");
        $requestData = ['order'=>[
            'account_id'=>$guid_id,
            'account_type'=>'bitrix_cms',
            'shipping_address'=>[
                'full_locality_name'=>$arParams['ADDRESS'],
                'location'=>[
                    'region_zip'=>$arParams['ZIP']
                ]],
            'items_price'=>$arParams['PRICE'],
            'total_weight'=>$arParams['WEIGHT'],
        ]];
        $res = $this->send($requestData, self::$url_calculate_pvz);
        if($debugCalculate == 'Y')
        {
            $arRes = self::objectToArray($res);
            \Bitrix\Main\Diag\Debug::writeToFile($requestData, "requestPickUpCalculate", self::$calculateLogPath);
            \Bitrix\Main\Diag\Debug::writeToFile($arRes, "answerPickUpCalculate", self::$calculateLogPath);
        }
        if($res->isSuccess())
        {
            $data = $res->getData();
            return $data[0];
        }
        else
        {
            return false;
        }
    }

    public function PickUpWorldCalculate($arParams)
    {
        $guid_id = Option::get(self::$MODULE_ID, "GUID_ID");
        $debugCalculate = Option::get(self::$MODULE_ID, "RUSSIANPOST_CALCULATE_DEBUG");
        $requestData = ['order'=>[
            'account_id'=>$guid_id,
            'account_type'=>'bitrix_cms',
            'shipping_address'=>[
                'full_locality_name'=>$arParams['ADDRESS'],
                'location'=>[
                    'country'=>$arParams['DIGITAL_CODE']
                ]],
            'items_price'=>$arParams['PRICE'],
            'total_weight'=>$arParams['WEIGHT'],
        ]];

        $res = $this->send($requestData, self::$url_calculate_pvz);
        if($debugCalculate == 'Y')
        {
            $arRes = self::objectToArray($res);
            \Bitrix\Main\Diag\Debug::writeToFile($requestData, "requestWorldPickUpCalculate", self::$calculateLogPath);
            \Bitrix\Main\Diag\Debug::writeToFile($arRes, "answerWorldPickUpCalculate", self::$calculateLogPath);
        }
        if($res->isSuccess())
        {
            $data = $res->getData();
            return $data[0];
        }
        else
        {
            return false;
        }
    }

    public function PickUpCalculateSimple($arParams)
    {
        $guid_id = Option::get(self::$MODULE_ID, "GUID_ID");
        $debugCalculate = Option::get(self::$MODULE_ID, "RUSSIANPOST_CALCULATE_DEBUG");
        $requestData = ['order'=>[
            'account_id'=>$guid_id,
            'account_type'=>'bitrix_cms',
            'shipping_address'=>[
                'full_locality_name'=>$arParams['ADDRESS'],
                'location'=>[
                    'region_zip'=>$arParams['ZIP']
                ]],
            'items_price'=>$arParams['PRICE'],
            'total_weight'=>$arParams['WEIGHT'],
        ]];
        $res = $this->send($requestData, self::$url_calculate_pvz_simple);
        if($debugCalculate == 'Y')
        {
            $arRes = self::objectToArray($res);
            \Bitrix\Main\Diag\Debug::writeToFile($requestData, "requestPickUpSimpleCalculate", self::$calculateLogPath);
            \Bitrix\Main\Diag\Debug::writeToFile($arRes, "answerPickUpSimpleCalculate", self::$calculateLogPath);
        }
        if($res->isSuccess())
        {
            $data = $res->getData();
            return $data[0];
        }
        else
        {
            return false;
        }
    }

    protected static function objectToArray($obj) {
        if ( is_array( $obj ) || is_object( $obj ) )
        {
            $text = print_r($obj, true);
        }
        else
        {
            $text = $obj;
        }
        return $text;
    }
}