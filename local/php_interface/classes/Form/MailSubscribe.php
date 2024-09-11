<?php

namespace Form;

use Bitrix\Main\Loader;
use CSubscription;
use CUser;

/**
 * Class MailSubscribe
 * @package Form
 *
 * Работа с подписками
 */
class MailSubscribe
{
    /**
     * Обработать e-mail, полученный через форму подписки
     *
     * @param string $email Почта из формы.
     * @return string Результат добавления в базу подписчиков.
     * @throws \Exception Стандартное исключение.
     */
    public static function subcribeEmailHandler(string $email)
    {
        $USER = new CUser;
        $result = '';

        if (Loader::includeModule('subscribe')) {
            $subscribeFields = [
                'USER_ID' => ($USER->IsAuthorized() ? $USER->GetID() : false),
                'FORMAT' => 'html',
                'EMAIL' => $email,
                'ACTIVE' => 'Y',
                'CONFIRMED' => 'N',
                'SEND_CONFIRM' => 'Y',
                'RUB_ID' => [1]
            ];

            $subscribe = new CSubscription;
            $subscribeId = $subscribe->Add($subscribeFields);

            if ($subscribeId > 0) {
                CSubscription::Authorize($subscribeId);
                $result = 'success';
            } else {
                $result = 'fail';
            }
        } else {
            throw new \Exception('Something went wrong');
        }

        return json_encode(['status' => $result]);
    }
}
