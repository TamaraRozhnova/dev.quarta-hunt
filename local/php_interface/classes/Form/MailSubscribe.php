<?php

namespace Form;

use Bitrix\Main\Loader;
use CSubscription;

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
        global $USER;
        $result = '';

        if (Loader::includeModule('subscribe')) {
            $subscribeFields = array(
                'USER_ID' => ($USER->IsAuthorized() ? $USER->GetID() : false),
                'FORMAT' => 'html',
                'EMAIL' => $email,
                'ACTIVE' => 'Y',
                'CONFIRMED' => 'N',
                'SEND_CONFIRM' => 'Y',
                'RUB_ID' => array(1)
            );

            $subscr = new CSubscription;
            $ID = $subscr->Add($subscribeFields);

            if ($ID > 0) {
                CSubscription::Authorize($ID);
                $result = 'success';
            } else {
                $result = 'fail';
            }
        } else {
            throw new \Exception('Something went wrong');
        }

        return $result;
    }
}
