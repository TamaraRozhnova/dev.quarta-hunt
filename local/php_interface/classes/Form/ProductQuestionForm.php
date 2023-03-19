<?php

namespace Form;

use CEvent;
use CIBlockElement;
use CModule;
use CUser;

class ProductQuestionForm
{
    const QUESTION_MAIL_EVENT_CODE = 'PRODUCT_QUESTION';

    /** @var CUser */
    private CUser $user;

    /** @var int */
    private int $productId = 0;

    /** @var string */
    private string $text;

    /**
     * @var array - ассоциативный массив, где: ключ - input name, значение - сообщение об ошибке
     */
    private array $errors = [];


    public function __construct()
    {
        CModule::IncludeModule('iblock');

        global $USER;
        $this->user = $USER;
    }


    /**
     * @param array $data - ассоциативный массив, где:
     * ключ — input name, значение — input value
     * @return array|bool - возвращает true, если вопрос ушел успешно, иначе
     * ассоциативный массив с ключом 'error' и значением - текст ошибки
     */
    public function sendQuestion(array $data)
    {
        if (!$this->user->IsAuthorized()) {
            $this->errors['message'] = 'Пользователь неавторизован';
            return ['errors' => $this->errors];
        }

        $this->readData($data);
        $this->validateData();

        if (!empty($this->errors)) {
            return ['errors' => $this->errors];
        }

        $this->sendEmail();

        if ($this->errors) {
            return ['errors' => $this->errors];
        }

        return true;
    }


    private function sendEmail(): void
    {
        $mailData = $this->getDataForSendingEmail();

        if (!$mailData) {
            $this->errors['message'] = 'Товар не найден';
            return;
        }

        $event = new CEvent;
        $event->SendImmediate(ProductQuestionForm::QUESTION_MAIL_EVENT_CODE, SITE_ID, $mailData);
    }


    /**
     * @return array|false - возвращает ассоциативный массив со полями для электронного письма
     * или false, если товар не найден
     */
    private function getDataForSendingEmail()
    {
        $productResource = CIBlockElement::GetByID($this->productId);
        if ($product = $productResource->GetNextElement()) {
            $fields = $product->GetFields();
            $props = $product->GetProperties();
            $productName = $fields['NAME'];
            $productArticle = $props['CML2_ARTICLE']['VALUE'];

            return [
                'NAME' => $this->user->GetFirstName(),
                'LAST_NAME' => $this->user->GetLastName(),
                'EMAIL' => $this->user->GetEmail(),
                'PRODUCT_ART' => $productArticle,
                'PRODUCT_NAME' => $productName,
                'TEXT' => $this->text,
            ];
        }

        return false;
    }


    /**
     * @param array $data - ассоциативный массив, где:
     * ключ — input name, значение — input value
     */
    private function readData(array $data): void
    {
        $this->productId = $data['productId'];
        $this->text = $data['text'];
    }


    /**
     * Валидирует поля формы с фронта и, в случае ошибок, заполняет массив $errors
     */
    private function validateData(): void
    {
        $minTextLength = 10;
        if (!$this->productId) {
            $this->errors['message'] = 'Товар не найден';
            return;
        }
        if (!$this->text || strlen($this->text) < $minTextLength) {
            $this->errors['text'] = 'Не менее 10 символов';
        }
    }

}