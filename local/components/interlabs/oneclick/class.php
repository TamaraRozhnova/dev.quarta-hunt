<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Context;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Sale;
use Bitrix\Sale\Order;
use Bitrix\Main\Application;
use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Main\UserTable;

use Personal\Basket;

/**
 * Class Oneclick
 */
class Oneclick extends CBitrixComponent
{
    /**
     * @var string
     */
    const MODULE_ID = 'interlabs.oneclick';

    /**
     * Oneclick constructor.
     * @param null $component
     */
    public function __construct($component = null)
    {
        parent::__construct($component);
    }

    /**
     * @param $result
     */
    public function jsonResponse($result)
    {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        if ($result && isset($result['errors']) && is_array($result['errors']) && count($result['errors']) === 0) {
            $result['errors'] = null;
        }
        ob_end_clean();
        header("Content-Type: application/json; charset=utf8");//windows-1251
        ob_clean();
        echo json_encode($result, JSON_UNESCAPED_SLASHES);
        die();
    }

    /**
     * @param Bitrix\Main\HttpRequest $request
     * @return int
     */
    protected function API_GetAnonymousUserID($request)
    {
        global $USER;
        $bUserExists = false;
        $userPhone = $request->get('PHONE');
        $multiUserId = $request->get('MULTIUSER_ID');

        if ($multiUserId != '') {
            $anonUserID = $multiUserId;
        } else {
            $anonUserID = $USER->GetID();
        }

        if ($anonUserID > 0) {
            $by = "id";
            $order = "asc";
            $dbUser = CUser::GetList($by, $order, array("ID" => $anonUserID), array("FIELDS" => array("ID")));
            if ($arUser = $dbUser->Fetch()) 
                $bUserExists = true;            
        } else {
            $rsUsers = UserTable::getList([
                'select' => [
                    'ID'                    
                ],
                'filter' => [
                    'PERSONAL_PHONE' => $userPhone, 
                    'ACTIVE' => 'Y'
                ]
            ])->fetchAll();

            if (!empty($rsUsers) && count($rsUsers) == 1) {
                $anonUserID = $rsUsers[0]['ID'];
                $bUserExists = true;
            } elseif (!empty($rsUsers) && count($rsUsers) > 1) {                
                $bUserExists = true;
            }
        }
        if (!$bUserExists) {
            $userObj = new CUser();
            if(strlen(strval(trim($userPhone)))>0){
                $rsGroupTable = \Bitrix\Main\GroupTable::getList([
                    'select' => [
                        'ID',
                        'NAME',
                        'STRING_ID'
                    ],
                    'filter' => [
                        'STRING_ID' => 'REGISTERED_USERS'
                    ]
                ])->fetch();                
            
                $groupRegUsersId = $rsGroupTable['ID'];
            
                $randomPass = \Bitrix\Main\Security\Random::getString(10);

                $expFio = explode(' ', $request->get('NAME'));
            
                $arFieldsNewUser = [
                    'NAME' => isset($expFio[0]) ? htmlspecialchars($expFio[0]) : htmlspecialchars($request->get('NAME')),
                    'LAST_NAME' => isset($expFio[1]) ? htmlspecialchars($expFio[1]) : '',
                    'PASSWORD' => $randomPass,
                    'CONFIRM_PASSWORD' => $randomPass,
                    'LOGIN' => $userPhone,
                    'ACTIVE' => 'Y',
                    'UF_TYPE' => 'retail',
		            'PERSONAL_PHONE' => $userPhone,
                    'GROUP_ID' => [$groupRegUsersId],
                ];                
            
                $anonUserID = $userObj->Add($arFieldsNewUser);
            }else{
                $anonUserID=CSaleUser::GetAnonymousUserID();
            }

            if (intval($anonUserID) > 0) {
                return intval($anonUserID);
            } else {                
                $this->arResult['validateErrors'][] = ["message" => Loc::getMessage('ERROR_CREATE_ANONYMOUS_USER')." ".$userObj->LAST_ERROR];
                return 0;
            }
        }

        return intval($anonUserID);
    }

    /**
     * @param HttpRequest $request
     * @return array|null
     * @throws Exception
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\NotSupportedException
     * @throws \Bitrix\Main\ObjectException
     * @throws \Bitrix\Main\ObjectNotFoundException
     * @throws \Bitrix\Main\SystemException
     */
    protected function saveOrder($request)
    {
        $this->arResult['validateErrors'] = [
            //[
            //    'message' => '',
            //    'field' => ''
            //]
        ];
        $data = null;

        $BUY_STRATEGY = $this->arParams['BUY_STRATEGY'];// ProductAndBasket|OnlyProduct|OnlyBasket

        if (CModule::IncludeModule('sale') &&
            CModule::IncludeModule("iblock") &&
            CModule::IncludeModule("catalog")) {


            $siteId = \Bitrix\Main\Context::getCurrent()->getSite();

            $currencyCode = Option::get('sale', 'default_currency', 'RUB');

            DiscountCouponsManager::init();

            $registeredUserID = $this->API_GetAnonymousUserID($request);
            if ($registeredUserID <= 0) {
                // return $this->jsonResponse(['data' => null, 'errors' => $this->arResult['validateErrors']]);
                return $data;
            }

            // if ($this->arParams['USE_CAPTCHA'] === 'Y' && !CurrentUser::get()->getId() && $request->get('MULTIUSER_ID') == '') {
            //     $captcha = new CCaptcha();
            //     if (!strlen($_REQUEST["captcha_word"]) > 0) {                    
            //         $this->arResult['validateErrors']['catpcha'] = ['message' => Loc::getMessage('ERROR_NO_CAPTCHA_CODE')];
            //         return $data;

            //     } elseif (!$captcha->CheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_sid"])) {                    
            //         $this->arResult['validateErrors']['catpcha'] = ['message' => Loc::getMessage('ERROR_CAPTCHA_CODE_WRONG')];
            //         return $data;
            //     }
            // }

            switch ($BUY_STRATEGY) {
                case 'ProductAndBasket':
                    $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());

                    if ($this->getProductId() === 0 && count($basket) === 0) {//
                        $this->arResult['validateErrors'][] = ['message' => Loc::getMessage('ERROR_PRODUCT_ID_REQUIRED')];
                        $this->arResult['validateErrors'][] = ['message' => Loc::getMessage('ERROR_BASKET_IS_EMPTY')];
                        return $data;
                    }

                    if ($item = $basket->getExistsItem('catalog', $this->getProductId())) {// if product in basket add QUANTITY
                        $item->setField('QUANTITY', $item->getQuantity() + 1);
                    } else {
                        $item = $basket->createItem('catalog', intval($request->get('PRODUCT_ID')));
                        $item->setFields(array(
                            'QUANTITY' => 1,
                            'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
                            'LID' => \Bitrix\Main\Context::getCurrent()->getSite(),
                            'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
                        ));
                    }

                    $basket->save();
                    break;
                case 'OnlyProduct':
                    if (intval($request->get('PRODUCT_ID')) === 0) {//
                        $this->arResult['validateErrors'][] = ['message' => Loc::getMessage('ERROR_PRODUCT_ID_REQUIRED')];
                        return $data;
                    }

                    $basket = new Basket();
                    $basket->addProductToBasket($request->get('PRODUCT_ID'));      

                    break;
                case 'OnlyBasket':
                    $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
                    if (count($basket) === 0) {
                        $this->arResult['validateErrors'][] = ['message' => Loc::getMessage('ERROR_BASKET_IS_EMPTY')];
                        return $data;
                    }
                    break;
            }


            $order = Order::create($siteId, $registeredUserID);
            $order->setPersonTypeId(Option::get(Oneclick::MODULE_ID, 'person_type_id', ''));
            $basket = Sale\Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), Bitrix\Main\Context::getCurrent()->getSite())->getOrderableItems();

            $order->setBasket($basket);

            /*Shipment*/
            $shipmentCollection = $order->getShipmentCollection();
            $shipment = $shipmentCollection->createItem();

            $delivery_id = intval(Option::get(Oneclick::MODULE_ID, 'delivery_id', 0));
            if ($delivery_id == 0) {
                $service = Bitrix\Sale\Delivery\Services\Manager::getById(Bitrix\Sale\Delivery\Services\EmptyDeliveryService::getEmptyDeliveryServiceId());

            } else {
                $service = Bitrix\Sale\Delivery\Services\Manager::getById($delivery_id);
            }
            $shipment->setFields(array(
                'DELIVERY_ID' => $service['ID'],
                'DELIVERY_NAME' => $service['NAME'],
                'CURRENCY' => $order->getCurrency()
            ));


            $shipmentItemCollection = $shipment->getShipmentItemCollection();

            foreach ($order->getBasket() as $item) {
                $shipmentItem = $shipmentItemCollection->createItem($item);
                $shipmentItem->setQuantity($item->getQuantity());
            }


            /*Payment*/

            $pay_system_id = intval(Option::get(Oneclick::MODULE_ID, 'pay_system_id', ''));

            if ($pay_system_id == 0) {
                goto skip_payment;
            }

            $paymentCollection = $order->getPaymentCollection();
            $extPayment = $paymentCollection->createItem();

            $payment = \Bitrix\Sale\PaySystem\Manager::getObjectById($pay_system_id);

            $arExtPayment['SUM'] = $order->getPrice();
            $arExtPayment['PAY_SYSTEM_ID'] = $payment->getField("PAY_SYSTEM_ID");
            $arExtPayment['PAY_SYSTEM_NAME'] = $payment->getField("NAME");

            $extPayment->setFields($arExtPayment);

            /**/

            skip_payment:

            $order->doFinalAction(true);

            $locationId = Option::get(Oneclick::MODULE_ID, 'location_id', 0);
            $locations = CSaleLocation::GetList([], ["ID" => $locationId], false, false, array('ID', "CODE","CITY_NAME"));
            $arLocation = $locations->Fetch();
            $propertyCollection = $order->getPropertyCollection();
            foreach ($propertyCollection->getGroups() as $group) {
                foreach ($propertyCollection->getGroupProperties($group['ID']) as $property) {
                    $p = $property->getProperty();
                    if ($p["CODE"] == Option::get(Oneclick::MODULE_ID, 'FIO_CODE', 'FIO')) {
                        $property->setValue($request->get('NAME'));
                    }
                    if ($p["CODE"] == Option::get(Oneclick::MODULE_ID, 'EMAIL_CODE', 'EMAIL')) {
                        $property->setValue($request->get('EMAIL'));
                    }
                    if ($p["CODE"] == Option::get(Oneclick::MODULE_ID, 'PHONE_CODE', 'PHONE')) {
                        $property->setValue($request->get('PHONE'));
                    }
                    if ($p["CODE"] == "CITY") {
                        if ($arLocation) {
                            $property->setValue($arLocation['CITY_NAME']);
                        }
                    }
                }
            }

            if ($propertyCollection->getDeliveryLocation()) {
                $propertyCollection->getDeliveryLocation()->setValue($arLocation['CODE']);
            }


            $order->setField('CURRENCY', $currencyCode);
            $order->setField('COMMENTS', 'One click');
            $order->setField('USER_DESCRIPTION', $request->get('COMMENT'));


            $order->save();
            $orderId = $order->GetId();

            if ($orderId > 0) {
                $data = ['message' => Loc::getMessage('ERROR_ORDER_COMPLETED'), 'orderId' => $orderId];
            } else {
                $this->arResult['validateErrors'][] = ['message' => Loc::getMessage('ERROR_ORDER_PROCESS')];
            }

        } else {
            $this->arResult['validateErrors'][] = ['message' => 'No load module.'];
        }

        return $data;

    }

    public function validateFields($request)
    {

        /**
         * Проверка на заполненность поля
         * Если заполнено - значит бот
         */
        if (!empty($request->get('MORDOR'))) {
            return false;
        }

        /**
         * Проверка формата +7 (999) 111-11-11
         */
        if (
            !$this->validatePhoneNumber($request->get('PHONE'))
            && $request->get('interlabs__oneclick') === 'Y'
        ) {
            $this->arResult['validateErrors'][] = [
                'message' => 'Неверный формат номера',
                'field' => 'PHONE'
            ];
        }

    }

    /**
     * @return mixed|void
     * @throws Exception
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\NotSupportedException
     * @throws \Bitrix\Main\ObjectException
     * @throws \Bitrix\Main\ObjectNotFoundException
     * @throws \Bitrix\Main\SystemException
     */
    public function executeComponent()
    {
        global $APPLICATION;

        $this->arResult['validateErrors'] = [];
        $this->arResult['success'] = null;

        $request = Context::getCurrent()->getRequest();

        $this->validateFields($request);

        if ($request->isPost() && $request->get('interlabs__oneclick') === 'Y') {
            if (!check_bitrix_sessid()) {
                if ($request->get('ONE_CLICK_JSON') === 'Y') {
                    $result = [
                        'data' => [],
                        'errors' => ["message" => 'Error: sessid']
                    ];
                    return $this->jsonResponse($result);
                } else {
                    $this->arResult['validateErrors'][] = ["message" => 'Error: sessid'];
                }
            }            

            if ($this->arParams['AGREE_PROCESSING'] === 'Y') {
                if (isset($_REQUEST['AGREE_PROCESSING']) && strval($_REQUEST['AGREE_PROCESSING']) === 'Y') {
                    // ok
                } else {
                    $this->arResult['validateErrors'][] = [
                        'message' => Loc::getMessage("ERROR_AGREE_REQUIRED"),
                        'field' => 'AGREE_PROCESSING'
                    ];
                }
            }

            if (count($this->arResult['validateErrors']) == 0) {
                $this->arResult['success'] = $this->saveOrder($request);
            }

            if ($request->get('ONE_CLICK_JSON') === 'Y') {
                return $this->jsonResponse(['data' => $this->arResult['success'], 'errors' => $this->arResult['validateErrors']]);
            } else {
                // show result in template
            }

        }

        global $USER;
        $this->arResult['user'] = [
            'NAME' => '',
            'PHONE' => '',
            'EMAIL' => '',
        ];
        if ($USER->IsAuthorized()) {
            $this->arResult['user']['NAME'] = $USER->GetFullName();
            $this->arResult['user']['PHONE'] = '';
            $this->arResult['user']['EMAIL'] = $USER->GetEmail();

            $rsUser = CUser::GetByID($USER->GetID());
            $arUser = $rsUser->Fetch();
            $this->arResult['user']["PHONE"] = $arUser['PERSONAL_PHONE'];
        } else {
            $this->arResult['user']['NAME'] = $request->get('NAME');
            $this->arResult['user']['PHONE'] = $request->get('PHONE');
        }
        $this->arResult['USE_FIELD_EMAIL'] = $this->arParams['USE_FIELD_EMAIL'];
        $this->arResult['USE_FIELD_COMMENT'] = $this->arParams['USE_FIELD_COMMENT'];
        $this->arResult['PRODUCT_ID'] = $this->getProductId($request);


        $this->arResult['AGREE_PROCESSING_TEXT'] = null;
        $this->arResult['AGREE_PROCESSING_FILE'] = null;
        $AGREE_PROCESSING_TEXT = Option::get(Oneclick::MODULE_ID, 'AGREE_PROCESSING_TEXT', '');
        if ($AGREE_PROCESSING_TEXT) {
            $this->arResult['AGREE_PROCESSING_TEXT'] = $AGREE_PROCESSING_TEXT;
        } else {
            $AGREE_PROCESSING_FILE_ID = Option::get(Oneclick::MODULE_ID, 'AGREE_PROCESSING_FILE_ID', '');
            if ($AGREE_PROCESSING_FILE_ID) {
                $arFile = CFile::GetFileArray($AGREE_PROCESSING_FILE_ID);
                if ($arFile) {
                    $this->arResult['AGREE_PROCESSING_FILE'] = $arFile;
                }
            }
        }

        $this->arResult["CAPTCHA_CODE"] = null;
        if (!isset($this->arParams['USE_CAPTCHA'])) {
            $this->arParams['USE_CAPTCHA'] = 'N';
        }
        if ($this->arParams['USE_CAPTCHA'] === 'Y' && !CurrentUser::get()->getId()) {
            $this->arResult["CAPTCHA_CODE"] = htmlspecialchars($APPLICATION->CaptchaGetCode());
        }

        $this->arResult['AGREE_PROCESSING'] = $this->arParams['AGREE_PROCESSING'];


        Loader::includeModule(Oneclick::MODULE_ID);

        $this->includeComponentTemplate();
    }

    /**
     * @return int
     */
    protected function getProductId($request = null)
    {
        if ($this->arParams['PRODUCT_ID']) {
            return intval($this->arParams['PRODUCT_ID']);
        }
        if ($request && $request->get('PRODUCT_ID')) {
            return intval($request->get('PRODUCT_ID'));
        }
        return 0;
    }

    function validatePhoneNumber($phoneNumber) {

        $pattern = '/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/';
    
        if (preg_match($pattern, $phoneNumber)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public static function reqInput($key, $default = null)
    {
        $val = $default;
        if (isset($_GET[$key])) {
            $val = $_GET[$key];
        }
        if (isset($_POST[$key])) {
            $val = $_POST[$key];
        }

        $data = json_decode(file_get_contents('php://input'));
        if ($data !== false) {
            if (is_object($data)) {
                if (isset($data->{$key})) {
                    $val = $data->{$key};
                }
            } elseif (is_array($data)) {
                if (isset($data[$key])) {
                    $val = $data[$key];
                }
            }
        }

        return $val;
    }

    /**
     * @param $key
     * @param null $default
     * @param $PRODUCT_ID
     * @return mixed|null
     */
    public static function reqInputByProduct($key, $default = null, $PRODUCT_ID)
    {
        if ($PRODUCT_ID == $_REQUEST['PRODUCT_ID'] && isset($_REQUEST['interlabs__oneclick'])) {
            return self::reqInput($key, $default);
        }
        return $default;
    }


}