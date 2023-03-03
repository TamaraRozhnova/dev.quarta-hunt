<?php

namespace Form;

use Bitrix\Catalog\Product\SubscribeManager;
use Bitrix\Catalog\SubscribeTable;
use CEvent;
use CIBlockElement;
use CModule;
use Exception;

class ProductSubscribeForm
{
    const SUBSCRIBE_MAIL_EVENT_CODE = 'CATALOG_PRODUCT_SUBSCRIBE_NOTIFY_REPEATED';

    /** @var int */
    private $userId = 0;

    /** @var int */
    private int $productId = 0;

    /** @var string */
    private string $userName;

    /** @var string */
    private string $userEmail;

    /** @var string */
    private string $userPhone;

    /** @var SubscribeManager */
    private SubscribeManager $subscribeManager;

    /**
     * @var array - ассоциативный массив, где: ключ - input name, значение - сообщение об ошибке
     */
    private array $errors = [];


    public function __construct()
    {
        CModule::IncludeModule('iblock');
        CModule::IncludeModule('catalog');

        global $USER;
        if ($USER->IsAuthorized()) {
            $this->userId = $USER->GetID();
        }

        $this->subscribeManager = new SubscribeManager();
    }


    /**
     * @param array $data - ассоциативный массив, где:
     * ключ — input name, значение — input value
     * @return array|bool - возвращает true, если подписка прошла успешно, иначе
     * ассоциативный массив с ключом 'errors' и значением -
     * ассоциативный массив, где: ключ — input name, значение — сообщение об ошибке
     */
    public function subscribe(array $data)
    {
        $this->readData($data);
        $this->validateData();

        if (!empty($this->errors)) {
            return ['errors' => $this->errors];
        }

        if (!$this->trySubscribe($data['email'])) {
            $this->handleSubscribeError();
            return ['errors' => $this->errors];
        }

        $this->sendEmail();

        return true;
    }


    private function trySubscribe(string $email): bool
    {
        $subscribeData = [
            'USER_CONTACT' => $email,
            'ITEM_ID' => $this->productId,
            'SITE_ID' => 's1',
            'CONTACT_TYPE' => SubscribeTable::CONTACT_TYPE_EMAIL,
            'USER_ID' => $this->userId,
        ];

        try {
            if ($this->subscribeManager->addSubscribe($subscribeData)) {
                return true;
            }
        } catch (Exception $expected) {
        }

        return false;
    }


    private function sendEmail(): void
    {
        $data = $this->getDataForSendingEmail();
        $event = new CEvent;
        $event->SendImmediate(ProductSubscribeForm::SUBSCRIBE_MAIL_EVENT_CODE, SITE_ID, $data);
    }


    /**
     * @return array - возвращает ассоциативный массив со свойствами для электронного письма
     */
    private function getDataForSendingEmail(): array
    {
        $product = CIBlockElement::GetList([], ['ID' => $this->productId], ['NAME'])->GetNext();
        $productName = $product['NAME'];

        return  [
            'USER_NAME' => $this->userName,
            'EMAIL_TO' => $this->userEmail,
            'NAME' => $productName,
            'PAGE_URL' => '',
            'CHECKOUT_URL' => '',
            'CHECKOUT_URL_PARAMETERS' => '',
            'PRODUCT_ID' => $this->productId,
            'UNSUBSCRIBE_URL' => '',
            'UNSUBSCRIBE_URL_PARAMETERS' => '',
        ];
    }


    private function handleSubscribeError(): void
    {
        $errorObject = current($this->subscribeManager->getErrors());
        $this->errors['message'] = $errorObject->getMessage();
    }


    /**
     * @param array $data - ассоциативный массив, где:
     * ключ — input name, значение — input value
     */
    private function readData(array $data): void
    {
        $this->userName = $data['name'];
        $this->userEmail = $data['email'];
        $this->userPhone = $data['phone'];
        $this->productId = $data['productId'] ?? 0;
    }


    /**
     * Валидирует поля формы с фронта и, в случае ошибок, заполняет массив $errors
     */
    private function validateData(): void
    {
        if (!$this->productId) {
            $this->errors['message'] = 'Неверный идентификатор товара';
        }
        if (!$this->userName) {
            $this->errors['name'] = 'Имя не может быть пустой строкой';
        }
        if ($this->userPhone && !preg_grep('/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', [$this->userPhone])) {
            $this->errors['phone'] = 'Неверный номер телефона';
        }
        if (!preg_grep('/^([a-z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/', [$this->userEmail])) {
            $this->errors['email'] = 'Неверный email';
        }
    }

}