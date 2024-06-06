<?php

namespace Sprint\Migration;


class Version20240606122407 extends Version
{
    protected $description = "110611 | Сайт / Изменение шаблонов письма | Почтовые события";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->Event()->saveEventType('USER_PASS_REQUEST', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Запрос на смену пароля',
  'DESCRIPTION' => '

#USER_ID# - ID пользователя
#STATUS# - Статус логина
#MESSAGE# - Сообщение пользователю
#LOGIN# - Логин
#URL_LOGIN# - Логин, закодированный для использования в URL
#CHECKWORD# - Контрольная строка для смены пароля
#NAME# - Имя
#LAST_NAME# - Фамилия
#EMAIL# - E-Mail пользователя
',
  'SORT' => '4',
));
            $helper->Event()->saveEventType('USER_PASS_REQUEST', array (
  'LID' => 'en',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Password Change Request',
  'DESCRIPTION' => '

#USER_ID# - User ID
#STATUS# - Account status
#MESSAGE# - Message for user
#LOGIN# - Login
#URL_LOGIN# - Encoded login for use in URL
#CHECKWORD# - Check string for password change
#NAME# - Name
#LAST_NAME# - Last Name
#EMAIL# - User E-Mail
',
  'SORT' => '4',
));
            $helper->Event()->saveEventMessage('USER_PASS_REQUEST', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Запрос на смену пароля',
  'MESSAGE' => '<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
</p>
<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 100%; margin: auto;">
 <img src="/include/images/email_banners/9.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
	 Здравствуйте, #NAME#!
</p>
 <br>
 <br>
 Для смены пароля перейдите по следующей ссылке:<br>
 <a href="http://#SERVER_NAME#/login/index.php?change_password=yes&lang=ru&USER_CHECKWORD=#CHECKWORD#&USER_LOGIN=#URL_LOGIN#">http://#SERVER_NAME#/login/index.php?change_password=yes&amp;amp;lang=ru&amp;amp;USER_CHECKWORD=#CHE...</a><br>
 <br>
 Ваша регистрационная информация:<br>
 <br>
 ID пользователя: #USER_ID#<br>
 Статус профиля: #STATUS#<br>
 Login: #LOGIN#<br>
 <br>
 Если Вы не отправляли запрос на смену пароля, то проигнорируйте это письмо.<br>
 <br>
 Сообщение сгенерировано автоматически.<br>
 <br>
 С уважением,<br>
 интернет-магазин&nbsp;#SITE_NAME# !<br>
 E-mail:&nbsp;<a href="mailto:sales@quarta-hunt.ru">shop@quarta-hunt.ru</a><br>
 Тел.:&nbsp;<a href="tel:+78007750304">+7 (800) 775-03-04</a><br>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>
 <br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ USER_PASS_REQUEST ] Запрос на смену пароля',
));
            $helper->Event()->saveEventMessage('USER_PASS_REQUEST', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Запрос на смену пароля',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------
#NAME# #LAST_NAME#,

#MESSAGE#

Для смены пароля перейдите по следующей ссылке:
http://#SERVER_NAME#/login/index.php?change_password=yes&lang=ru&USER_CHECKWORD=#CHECKWORD#&USER_LOGIN=#URL_LOGIN#

Ваша регистрационная информация:

ID пользователя: #USER_ID#
Статус профиля: #STATUS#
Login: #LOGIN#

Сообщение сгенерировано автоматически.',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ USER_PASS_REQUEST ] Запрос на смену пароля',
));
            $helper->Event()->saveEventMessage('USER_PASS_REQUEST', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Запрос на смену пароля',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------
#NAME# #LAST_NAME#,

#MESSAGE#

Для смены пароля перейдите по следующей ссылке:
http://#SERVER_NAME#/login/index.php?change_password=yes&lang=ru&USER_CHECKWORD=#CHECKWORD#&USER_LOGIN=#URL_LOGIN#

Ваша регистрационная информация:

ID пользователя: #USER_ID#
Статус профиля: #STATUS#
Login: #LOGIN#

Сообщение сгенерировано автоматически.',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ USER_PASS_REQUEST ] Запрос на смену пароля',
));
            $helper->Event()->saveEventType('USER_PASS_CHANGED', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Подтверждение смены пароля',
  'DESCRIPTION' => '

#USER_ID# - ID пользователя
#STATUS# - Статус логина
#MESSAGE# - Сообщение пользователю
#LOGIN# - Логин
#URL_LOGIN# - Логин, закодированный для использования в URL
#CHECKWORD# - Контрольная строка для смены пароля
#NAME# - Имя
#LAST_NAME# - Фамилия
#EMAIL# - E-Mail пользователя
',
  'SORT' => '5',
));
            $helper->Event()->saveEventType('USER_PASS_CHANGED', array (
  'LID' => 'en',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Password Change Confirmation',
  'DESCRIPTION' => '

#USER_ID# - User ID
#STATUS# - Account status
#MESSAGE# - Message for user
#LOGIN# - Login
#URL_LOGIN# - Encoded login for use in URL
#CHECKWORD# - Check string for password change
#NAME# - Name
#LAST_NAME# - Last Name
#EMAIL# - User E-Mail
',
  'SORT' => '5',
));
            $helper->Event()->saveEventMessage('USER_PASS_CHANGED', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Подтверждение смены пароля',
  'MESSAGE' => '<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
</p>
<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 100%;">
 <img src="/include/images/email_banners/10.jpg" style="width: 100%; height: auto; object-fit: contain;">
</div>
<p>
</p>
<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
	 Здравствуйте, #NAME#!
</p>
 Ваш пароль успешно изменён.<br>
 <br>
 Ваша регистрационная информация:<br>
 <br>
 ID пользователя: #USER_ID#<br>
 Статус профиля: #STATUS#<br>
 Login: #LOGIN#<br>
 <br>
 Сообщение сгенерировано автоматически.<br>
 <br>
 С уважением,<br>
 интернет-магазин&nbsp;#SITE_NAME# !<br>
 E-mail:&nbsp;<a href="mailto:sales@quarta-hunt.ru">shop@quarta-hunt.ru</a><br>
 Тел.:&nbsp;<a href="tel:+78007750304">+7 (800) 775-03-04</a><br>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			 Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			 График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
 <br>
 <br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ USER_PASS_CHANGED ] Подтверждение смены пароля',
));
            $helper->Event()->saveEventMessage('USER_PASS_CHANGED', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Подтверждение смены пароля',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------
#NAME# #LAST_NAME#,

#MESSAGE#

Ваша регистрационная информация:

ID пользователя: #USER_ID#
Статус профиля: #STATUS#
Login: #LOGIN#

Сообщение сгенерировано автоматически.',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ USER_PASS_CHANGED ] Подтверждение смены пароля',
));
            $helper->Event()->saveEventMessage('USER_PASS_CHANGED', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Подтверждение смены пароля',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------
#NAME# #LAST_NAME#,

#MESSAGE#

Ваша регистрационная информация:

ID пользователя: #USER_ID#
Статус профиля: #STATUS#
Login: #LOGIN#

Сообщение сгенерировано автоматически.',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ USER_PASS_CHANGED ] Подтверждение смены пароля',
));
            $helper->Event()->saveEventType('SALE_ORDER_CANCEL', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Отмена заказа',
  'DESCRIPTION' => '#ORDER_ID# - код заказа
#ORDER_ACCOUNT_NUMBER_ENCODE# - код заказа(для ссылок)
#ORDER_REAL_ID# - реальный ID заказа
#ORDER_DATE# - дата заказа
#EMAIL# - E-Mail пользователя
#ORDER_CANCEL_DESCRIPTION# - причина отмены
#ORDER_PUBLIC_URL# - ссылка для просмотра заказа без авторизации (требуется настройка в модуле интернет-магазина)
#SALE_EMAIL# - E-Mail отдела продаж',
  'SORT' => '100',
));
            $helper->Event()->saveEventType('SALE_ORDER_CANCEL', array (
  'LID' => 'en',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Cancel order',
  'DESCRIPTION' => '#ORDER_ID# - order ID
#ORDER_ACCOUNT_NUMBER_ENCODE# - order ID (for URL\'s)
#ORDER_REAL_ID# - real order ID
#ORDER_DATE# - order date
#EMAIL# - customer e-mail
#ORDER_LIST# - order contents
#ORDER_CANCEL_DESCRIPTION# - reason for cancellation
#ORDER_PUBLIC_URL# - order view link for unauthorized users (requires configuration in the e-Store module settings)
#SALE_EMAIL# - sales dept. e-mail
',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('SALE_ORDER_CANCEL', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Отмена заказа N#ORDER_ID#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style> <br>
<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 850px;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 850px; margin: auto;">
 <img src="/include/images/email_banners/5.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 #SITE_NAME#: Отмена заказа N#ORDER_ID#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
			 Здравствуйте, #ORDER_FIO#!<br>
		</p>
		<p>
			 Заказ номер #ORDER_ID# от #ORDER_DATE# отменён.
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 #ORDER_CANCEL_DESCRIPTION#
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 коллектив интернет-магазина #SITE_NAME# !<br>
			 E-mail:&nbsp;<a href="mailto:sales@quarta-hunt.ru">shop@quarta-hunt.ru</a><br>
			 Тел.:&nbsp;<a href="tel:+78007750304">+7 (800) 775-03-04</a><br>
		</p>
	</td>
</tr>
</tbody>
</table>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '#BCC#',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_ORDER_CANCEL ] Отмена заказа',
));
            $helper->Event()->saveEventMessage('SALE_ORDER_CANCEL', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Отмена заказа N#ORDER_ID#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 #SITE_NAME#: Отмена заказа N#ORDER_ID#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
			 Заказ номер #ORDER_ID# от #ORDER_DATE# отменен.
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 #ORDER_CANCEL_DESCRIPTION#<br>
 <br>
			 Для получения подробной информации по заказу пройдите на сайт <a href="http://#SERVER_NAME#/pcabinet">http://#SERVER_NAME#/</a>cabinet/history/#ORDER_ID#/<br>
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br>
			 E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
		</p>
	</td>
</tr>
</tbody>
</table>',
  'BODY_TYPE' => 'html',
  'BCC' => '#BCC#',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_ORDER_CANCEL ] Отмена заказа',
));
            $helper->Event()->saveEventMessage('SALE_ORDER_CANCEL', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Отмена заказа N#ORDER_ID#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 #SITE_NAME#: Отмена заказа N#ORDER_ID#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
			 Заказ номер #ORDER_ID# от #ORDER_DATE# отменен.
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 #ORDER_CANCEL_DESCRIPTION#<br>
 <br>
			 Для получения подробной информации по заказу пройдите на сайт <a href="http://#SERVER_NAME#/pcabinet">http://#SERVER_NAME#/</a>cabinet/history/#ORDER_ID#/<br>
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br>
			 E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
		</p>
	</td>
</tr>
</tbody>
</table>',
  'BODY_TYPE' => 'html',
  'BCC' => '#BCC#',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_ORDER_CANCEL ] Отмена заказа',
));
            $helper->Event()->saveEventType('SALE_ORDER_PAID', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Заказ оплачен',
  'DESCRIPTION' => '#ORDER_ID# - код заказа
#ORDER_ACCOUNT_NUMBER_ENCODE# - код заказа(для ссылок)
#ORDER_REAL_ID# - реальный ID заказа
#ORDER_DATE# - дата заказа
#EMAIL# - E-Mail пользователя
#ORDER_PUBLIC_URL# - ссылка для просмотра заказа без авторизации (требуется настройка в модуле интернет-магазина)
#SALE_EMAIL# - E-Mail отдела продаж',
  'SORT' => '100',
));
            $helper->Event()->saveEventType('SALE_ORDER_PAID', array (
  'LID' => 'en',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Paid order',
  'DESCRIPTION' => '#ORDER_ID# - order ID
#ORDER_ACCOUNT_NUMBER_ENCODE# - order ID (for URL\'s)
#ORDER_REAL_ID# - real order ID
#ORDER_DATE# - order date
#EMAIL# - customer e-mail
#ORDER_PUBLIC_URL# - order view link for unauthorized users (requires configuration in the e-Store module settings)
#SALE_EMAIL# - sales dept. e-mail',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('SALE_ORDER_PAID', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Заказ N#ORDER_ID# оплачен',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style> <br>
<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 850px;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 850px; margin: auto;">
 <img src="/include/images/email_banners/8.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 Вы оплатили заказ на сайте #SITE_NAME#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
			 Здравствуйте, #ORDER_FIO#!<br>
		</p>
		<p>
			 Ваш заказ <b>№&nbsp;</b><b>#ORDER_ID#</b> от <b>#ORDER_DATE#</b> полностью оплачен.
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 Для получения подробной информации по заказу перейдите на сайт в личный кабине:&nbsp;<u><a href="https://quarta-hunt.ru/cabinet/orders/">https://quarta-hunt.ru/cabinet/orders/</a></u>
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 коллектив интернет-магазина #SITE_NAME# !<br>
			 E-mail:&nbsp;<a href="mailto:sales@quarta-hunt.ru">shop@quarta-hunt.ru</a><br>
			 Тел.:&nbsp;<a href="tel:+78007750304">+7 (800) 775-03-04</a><br>
		</p>
	</td>
</tr>
</tbody>
</table>
<br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '#BCC#',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_ORDER_PAID ] Заказ оплачен',
));
            $helper->Event()->saveEventMessage('SALE_ORDER_PAID', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Заказ N#ORDER_ID# оплачен',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 Вы оплатили заказ на сайте #SITE_NAME#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
			 Заказ номер #ORDER_ID# от #ORDER_DATE# оплачен.
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 Для получения подробной информации по заказу пройдите на сайт <a href="http://#SERVER_NAME#/cabinet/history/">http://#SERVER_NAME#/cabinet/history</a>/#ORDER_ID#/
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br>
			 E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
		</p>
	</td>
</tr>
</tbody>
</table>',
  'BODY_TYPE' => 'html',
  'BCC' => '#BCC#',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_ORDER_PAID ] Заказ оплачен',
));
            $helper->Event()->saveEventMessage('SALE_ORDER_PAID', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Заказ N#ORDER_ID# оплачен',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 Вы оплатили заказ на сайте #SITE_NAME#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
			 Заказ номер #ORDER_ID# от #ORDER_DATE# оплачен.
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 Для получения подробной информации по заказу пройдите на сайт <a href="http://#SERVER_NAME#/cabinet/history/">http://#SERVER_NAME#/cabinet/history</a>/#ORDER_ID#/
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br>
			 E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
		</p>
	</td>
</tr>
</tbody>
</table>',
  'BODY_TYPE' => 'html',
  'BCC' => '#BCC#',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_ORDER_PAID ] Заказ оплачен',
));
            $helper->Event()->saveEventType('SALE_ORDER_TRACKING_NUMBER', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Уведомление об изменении идентификатора почтового отправления',
  'DESCRIPTION' => '#ORDER_ID# - код заказа
#ORDER_ACCOUNT_NUMBER_ENCODE# - код заказа(для ссылок)
#ORDER_REAL_ID# - реальный ID заказа
#ORDER_DATE# - дата заказа
#ORDER_USER# - заказчик
#ORDER_TRACKING_NUMBER# - идентификатор почтового отправления
#ORDER_PUBLIC_URL# - ссылка для просмотра заказа без авторизации (требуется настройка в модуле интернет-магазина)
#EMAIL# - E-Mail заказчика
#BCC# - E-Mail скрытой копии
#SALE_EMAIL# - E-Mail отдела продаж',
  'SORT' => '100',
));
            $helper->Event()->saveEventType('SALE_ORDER_TRACKING_NUMBER', array (
  'LID' => 'en',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Notification of change in tracking number ',
  'DESCRIPTION' => '#ORDER_ID# - order ID
#ORDER_ACCOUNT_NUMBER_ENCODE# - order ID (for URL\'s)
#ORDER_REAL_ID# - real order ID
#ORDER_DATE# - order date
#ORDER_USER# - customer
#ORDER_TRACKING_NUMBER# - tracking number
#ORDER_PUBLIC_URL# - order view link for unauthorized users (requires configuration in the e-Store module settings)
#EMAIL# - customer e-mail
#BCC# - BCC e-mail
#SALE_EMAIL# - sales dept. e-mail',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('SALE_ORDER_TRACKING_NUMBER', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => 'Номер идентификатора отправления вашего заказа на сайте #SITE_NAME#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
<div>
 <br>
	<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 850px;">
 <img src="/include/images/header-snippet-email.png">
	</div>
 <br>
	<div style="width: 850px; margin: auto;">
 <img src="/include/images/email_banners/11.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
	</div>
	<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
	<tbody>
	<tr>
		<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
			<table cellpadding="0" cellspacing="0" width="100%">
			<tbody>
			<tr>
				<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
					 Номер идентификатора отправления вашего заказа на сайте #SITE_NAME#
				</td>
			</tr>
			<tr>
				<td bgcolor="#bad3df" height="11">
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
			<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
				 Здравствуйте&nbsp;#ORDER_USER#!
			</p>
			<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
				 &nbsp;Ваш заказ № #ORDER_ID# от #ORDER_DATE# передан в доставку.<br>
 <br>
				 Номер идентификатора отправления: #ORDER_TRACKING_NUMBER#<br>
 <br>
				 Подробную информацию о статусе заказа Вы можете уточнить в <a href="https://quarta-hunt.ru/cabinet/orders/#">личном кабинете</a>, в чате или по телефону:&nbsp;<a href="tel:+78007750304">+7 (800) 775-03-04</a><br>
			</p>
		</td>
	</tr>
	<tr>
		<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
			<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
				 С уважением,<br>
				 коллектив интернет-магазина #SITE_NAME# !<br>
				 E-mail:&nbsp;<a href="mailto:sales@quarta-hunt.ru">shop@quarta-hunt.ru</a><br>
				 Тел.:&nbsp;<a href="tel:+78007750304">+7 (800) 775-03-04</a><br>
			</p>
		</td>
	</tr>
	</tbody>
	</table>
</div>
 <br>
<div style="display: flex;align-items: center;justify-content: space-between;max-width: 80%;margin: 0 auto;">
</div>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 850px; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			 Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			 График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
 <br>',
  'BODY_TYPE' => 'html',
  'BCC' => '#BCC#',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_ORDER_TRACKING_NUMBER ] Уведомление об изменении идентификатора почтового отправления',
));
            $helper->Event()->saveEventMessage('SALE_ORDER_TRACKING_NUMBER', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => 'Номер идентификатора отправления вашего заказа на сайте #SITE_NAME#',
  'MESSAGE' => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
</head>
<body>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
	<tr>
		<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">Номер идентификатора отправления вашего заказа на сайте #SITE_NAME#</td>
				</tr>
				<tr>
					<td bgcolor="#bad3df" height="11"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
			<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">Уважаемый #ORDER_USER#,</p>
			<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">Произошла почтовая отправка заказа N #ORDER_ID# от #ORDER_DATE#.<br />
<br />
Номер идентификатора отправления: #ORDER_TRACKING_NUMBER#.<br />
<br />
Для получения подробной информации по заказу пройдите на сайт http://#SERVER_NAME#/personal/order/detail/#ORDER_ACCOUNT_NUMBER_ENCODE#/<br />
<br />
E-mail: #SALE_EMAIL#<br />
</p>
		</td>
	</tr>
	<tr>
		<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
			<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">С уважением,<br />администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br />
				E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
			</p>
		</td>
	</tr>
</table>
</body>
</html>',
  'BODY_TYPE' => 'html',
  'BCC' => '#BCC#',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_ORDER_TRACKING_NUMBER ] Уведомление об изменении идентификатора почтового отправления',
));
            $helper->Event()->saveEventMessage('SALE_ORDER_TRACKING_NUMBER', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => 'Номер идентификатора отправления вашего заказа на сайте #SITE_NAME#',
  'MESSAGE' => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
</head>
<body>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
	<tr>
		<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">Номер идентификатора отправления вашего заказа на сайте #SITE_NAME#</td>
				</tr>
				<tr>
					<td bgcolor="#bad3df" height="11"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
			<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">Уважаемый #ORDER_USER#,</p>
			<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">Произошла почтовая отправка заказа N #ORDER_ID# от #ORDER_DATE#.<br />
<br />
Номер идентификатора отправления: #ORDER_TRACKING_NUMBER#.<br />
<br />
Для получения подробной информации по заказу пройдите на сайт http://#SERVER_NAME#/personal/order/detail/#ORDER_ACCOUNT_NUMBER_ENCODE#/<br />
<br />
E-mail: #SALE_EMAIL#<br />
</p>
		</td>
	</tr>
	<tr>
		<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
			<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">С уважением,<br />администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br />
				E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
			</p>
		</td>
	</tr>
</table>
</body>
</html>',
  'BODY_TYPE' => 'html',
  'BCC' => '#BCC#',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_ORDER_TRACKING_NUMBER ] Уведомление об изменении идентификатора почтового отправления',
));
            $helper->Event()->saveEventType('SALE_STATUS_CHANGED_F', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Изменение статуса заказа на  "Выполнен"',
  'DESCRIPTION' => '#ORDER_ID# - код заказа
#ORDER_DATE# - дата заказа
#ORDER_STATUS# - статус заказа
#EMAIL# - E-Mail пользователя
#ORDER_DESCRIPTION# - описание статуса заказа
#TEXT# - текст
#SALE_EMAIL# - E-Mail отдела продаж
#ORDER_PUBLIC_URL# - ссылка для просмотра заказа без авторизации (требуется настройка в модуле интернет-магазина)
',
  'SORT' => '100',
));
            $helper->Event()->saveEventType('SALE_STATUS_CHANGED_F', array (
  'LID' => 'en',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Changing order status to ""',
  'DESCRIPTION' => '#ORDER_ID# - order ID
#ORDER_DATE# - order date
#ORDER_STATUS# - order status
#EMAIL# - customer e-mail
#ORDER_DESCRIPTION# - order status description
#TEXT# - text
#SALE_EMAIL# - Sales department e-mail
#ORDER_PUBLIC_URL# - order view link for unauthorized users (requires configuration in the e-Store module settings)
',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_F', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style> <br>
<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 850px;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 850px; margin: auto;">
 <img src="/include/images/email_banners/1.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 Изменение статуса заказа в магазине #SITE_NAME#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 Информационное сообщение сайта #SITE_NAME#<br>
			 ------------------------------------------<br>
 <br>
			 Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.<br>
 <br>
			 Новый статус заказа:<br>
			 #ORDER_STATUS#<br>
			 #ORDER_DESCRIPTION#<br>
			 #TEXT#<br>
 <br>
			 Для получения подробной информации по заказу пройдите на сайт #SERVER_NAME#/cabinet/history/#ORDER_ID#/<br>
 <br>
			 Спасибо за ваш выбор!<br>
			 #SITE_NAME#<br>
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br>
			 E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
		</p>
	</td>
</tr>
</tbody>
</table>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_F ] Изменение статуса заказа на  "Выполнен"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_F', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 Изменение статуса заказа в магазине #SITE_NAME#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 Информационное сообщение сайта #SITE_NAME#<br>
			 ------------------------------------------<br>
 <br>
			 Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.<br>
 <br>
			 Новый статус заказа:<br>
			 #ORDER_STATUS#<br>
			 #ORDER_DESCRIPTION#<br>
			 #TEXT#<br>
 <br>
			 Для получения подробной информации по заказу пройдите на сайт #SERVER_NAME#/cabinet/history/#ORDER_ID#/<br>
 <br>
			 Спасибо за ваш выбор!<br>
			 #SITE_NAME#<br>
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br>
			 E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
		</p>
	</td>
</tr>
</tbody>
</table>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_F ] Изменение статуса заказа на  "Выполнен"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_F', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 Изменение статуса заказа в магазине #SITE_NAME#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 Информационное сообщение сайта #SITE_NAME#<br>
			 ------------------------------------------<br>
 <br>
			 Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.<br>
 <br>
			 Новый статус заказа:<br>
			 #ORDER_STATUS#<br>
			 #ORDER_DESCRIPTION#<br>
			 #TEXT#<br>
 <br>
			 Для получения подробной информации по заказу пройдите на сайт #SERVER_NAME#/cabinet/history/#ORDER_ID#/<br>
 <br>
			 Спасибо за ваш выбор!<br>
			 #SITE_NAME#<br>
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br>
			 E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
		</p>
	</td>
</tr>
</tbody>
</table>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_F ] Изменение статуса заказа на  "Выполнен"',
));
            $helper->Event()->saveEventType('SALE_STATUS_CHANGED_N', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Изменение статуса заказа на  "Принят, ожидается оплата"',
  'DESCRIPTION' => '#ORDER_ID# - код заказа
#ORDER_DATE# - дата заказа
#ORDER_STATUS# - статус заказа
#EMAIL# - E-Mail пользователя
#ORDER_DESCRIPTION# - описание статуса заказа
#TEXT# - текст
#SALE_EMAIL# - E-Mail отдела продаж
#ORDER_PUBLIC_URL# - ссылка для просмотра заказа без авторизации (требуется настройка в модуле интернет-магазина)
',
  'SORT' => '100',
));
            $helper->Event()->saveEventType('SALE_STATUS_CHANGED_N', array (
  'LID' => 'en',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Changing order status to ""',
  'DESCRIPTION' => '#ORDER_ID# - order ID
#ORDER_DATE# - order date
#ORDER_STATUS# - order status
#EMAIL# - customer e-mail
#ORDER_DESCRIPTION# - order status description
#TEXT# - text
#SALE_EMAIL# - Sales department e-mail
#ORDER_PUBLIC_URL# - order view link for unauthorized users (requires configuration in the e-Store module settings)
',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_N', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'N',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 850px;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 850px; margin: auto;">
 <img src="/include/images/email_banners/1.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 Изменение статуса заказа в магазине #SITE_NAME#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 Информационное сообщение сайта #SITE_NAME#<br>
			 ------------------------------------------<br>
 <br>
			 Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.<br>
 <br>
			 Новый статус заказа:<br>
			 #ORDER_STATUS#<br>
			 #ORDER_DESCRIPTION#<br>
			 #TEXT#<br>
 <br>
			 Для получения подробной информации по заказу пройдите на сайт #SERVER_NAME#/cabinet/history/#ORDER_ID#/<br>
 <br>
			 Спасибо за ваш выбор!<br>
			 #SITE_NAME#<br>
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br>
			 E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
		</p>
	</td>
</tr>
</tbody>
</table>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			 Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			 График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
 <br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_N ] Изменение статуса заказа на  "Принят, ожидается оплата"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_N', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'N',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 Изменение статуса заказа в магазине #SITE_NAME#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 Информационное сообщение сайта #SITE_NAME#<br>
			 ------------------------------------------<br>
 <br>
			 Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.<br>
 <br>
			 Новый статус заказа:<br>
			 #ORDER_STATUS#<br>
			 #ORDER_DESCRIPTION#<br>
			 #TEXT#<br>
 <br>
			 Для получения подробной информации по заказу пройдите на сайт #SERVER_NAME#/cabinet/history/#ORDER_ID#/<br>
 <br>
			 Спасибо за ваш выбор!<br>
			 #SITE_NAME#<br>
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br>
			 E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
		</p>
	</td>
</tr>
</tbody>
</table>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_N ] Изменение статуса заказа на  "Принят, ожидается оплата"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_N', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'N',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 Изменение статуса заказа в магазине #SITE_NAME#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 Информационное сообщение сайта #SITE_NAME#<br>
			 ------------------------------------------<br>
 <br>
			 Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.<br>
 <br>
			 Новый статус заказа:<br>
			 #ORDER_STATUS#<br>
			 #ORDER_DESCRIPTION#<br>
			 #TEXT#<br>
 <br>
			 Для получения подробной информации по заказу пройдите на сайт #SERVER_NAME#/cabinet/history/#ORDER_ID#/<br>
 <br>
			 Спасибо за ваш выбор!<br>
			 #SITE_NAME#<br>
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br>
			 E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
		</p>
	</td>
</tr>
</tbody>
</table>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_N ] Изменение статуса заказа на  "Принят, ожидается оплата"',
));
            $helper->Event()->saveEventType('SALE_STATUS_CHANGED_P', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Изменение статуса заказа на  "Оплачен, формируется к отправке"',
  'DESCRIPTION' => '#ORDER_ID# - код заказа
#ORDER_DATE# - дата заказа
#ORDER_STATUS# - статус заказа
#EMAIL# - E-Mail пользователя
#ORDER_DESCRIPTION# - описание статуса заказа
#TEXT# - текст
#SALE_EMAIL# - E-Mail отдела продаж
#ORDER_PUBLIC_URL# - ссылка для просмотра заказа без авторизации (требуется настройка в модуле интернет-магазина)
',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_P', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => '<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 100%; margin: auto;">
 <img src="/include/images/email_banners/1.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
 <br>
 Информационное сообщение сайта #SITE_NAME#<br>
 ------------------------------------------<br>
 <br>
 Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.<br>
 <br>
 Новый статус заказа:<br>
 #ORDER_STATUS#<br>
 #ORDER_DESCRIPTION#<br>
 #TEXT#<br>
 <br>
 #SITE_NAME#<br>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_P ] Изменение статуса заказа на  "Оплачен, формируется к отправке"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_P', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_P ] Изменение статуса заказа на  "Оплачен, формируется к отправке"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_P', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_P ] Изменение статуса заказа на  "Оплачен, формируется к отправке"',
));
            $helper->Event()->saveEventType('USER_RESTORE_PASSWORD', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Восстановление пароля',
  'DESCRIPTION' => '#NAME# - Имя
#LAST_NAME# - Фамилия
#EMAIL# - Email
#CODE# - Код для восстановления',
  'SORT' => '150',
));
            $helper->Event()->saveEventType('USER_RESTORE_PASSWORD', array (
  'LID' => 'en',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Restore password',
  'DESCRIPTION' => '#NAME# - Name
#LAST_NAME# - Last name
#EMAIL# - Email
#CODE# - Restore code',
  'SORT' => '150',
));
            $helper->Event()->saveEventMessage('USER_RESTORE_PASSWORD', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Восстановление пароля',
  'MESSAGE' => '<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
</p>
<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 100%; margin: auto;">
 <img src="/include/images/email_banners/9.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
	 Здравствуйте, #NAME# !
</p>
 Для смены пароля перейдите по ссылке:<br>
 <a href="https://#SERVER_NAME#/recovery/?EMAIL=#EMAIL#&CODE=#CODE#">https://#SERVER_NAME#/recovery/?EMAIL=#EMAIL#&amp;amp;CODE=#CODE#</a><br>
 <br>
 Сообщение сгенерировано автоматически.<br>
 <br>
 С уважением,<br>
 интернет-магазин #SITE_NAME# !<br>
 E-mail:&nbsp;<a href="mailto:sales@quarta-hunt.ru">shop@quarta-hunt.ru</a><br>
 Тел.:&nbsp;<a href="tel:+78007750304">+7 (800) 775-03-04</a><br>
 <br>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			 Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			 График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
 <br>
 <br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ USER_RESTORE_PASSWORD ] Восстановление пароля',
));
            $helper->Event()->saveEventMessage('USER_RESTORE_PASSWORD', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Восстановление пароля',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------
#NAME# #LAST_NAME#

Для смены пароля перейдите по следующей ссылке:
https://#SERVER_NAME#/recovery/?EMAIL=#EMAIL#&CODE=#CODE#

Сообщение сгенерировано автоматически.',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ USER_RESTORE_PASSWORD ] Восстановление пароля',
));
            $helper->Event()->saveEventMessage('USER_RESTORE_PASSWORD', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Восстановление пароля',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------
#NAME# #LAST_NAME#

Для смены пароля перейдите по следующей ссылке:
https://#SERVER_NAME#/recovery/?EMAIL=#EMAIL#&CODE=#CODE#

Сообщение сгенерировано автоматически.',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ USER_RESTORE_PASSWORD ] Восстановление пароля',
));
            $helper->Event()->saveEventType('GOODS_ARRIVAL_REPORT', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Сообщить о поступлении товара',
  'DESCRIPTION' => '#PRODUCT_ID# - ID товара
#PRODUCT_ART# - Артикул товара
#PRODUCT_NAME# - Наименование товара
#EMAIL# - Email пользователя
#NAME# - Имя пользователя
#PHONE# - Телефон',
  'SORT' => '150',
));
            $helper->Event()->saveEventType('GOODS_ARRIVAL_REPORT', array (
  'LID' => 'en',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Report the arrival of goods',
  'DESCRIPTION' => '#PRODUCT_ID# - Product ID
#PRODUCT_ART# - Product art
#PRODUCT_NAME# - Product name
#EMAIL# - User email
#NAME# - User name
#PHONE# - Phone',
  'SORT' => '150',
));
            $helper->Event()->saveEventMessage('GOODS_ARRIVAL_REPORT', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => 'shop@quarta-hunt.ru',
  'SUBJECT' => '#SITE_NAME#: Поступление товара',
  'MESSAGE' => '<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png"><br>
</div>
<div style="width: 100%; margin: auto;">
	<img src="/include/images/email_banners/6.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
 <br>
 <br>
 Информационное сообщение сайта #SITE_NAME#<br>
 ------------------------------------------<br>
 #NAME# (#PHONE#) (#EMAIL#)<br>
 <br>
 Сообщить о поступление товара:<br>
 <br>
 ID товара: #PRODUCT_ID#<br>
 Артикул: #PRODUCT_ART#<br>
 Наименование товара: #PRODUCT_NAME#<br>
 <br>
 Сообщение сгенерировано автоматически.<br>
<br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ GOODS_ARRIVAL_REPORT ] Сообщить о поступлении товара',
));
            $helper->Event()->saveEventMessage('GOODS_ARRIVAL_REPORT', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => 'shop@quarta-hunt.ru',
  'SUBJECT' => '#SITE_NAME#: Поступление товара',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------
#NAME# (#PHONE#) (#EMAIL#)

Сообщить о поступление товара:

ID товара: #PRODUCT_ID#
Артикул: #PRODUCT_ART#
Наименование товара: #PRODUCT_NAME#

Сообщение сгенерировано автоматически.',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ GOODS_ARRIVAL_REPORT ] Сообщить о поступлении товара',
));
            $helper->Event()->saveEventMessage('GOODS_ARRIVAL_REPORT', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => 'shop@quarta-hunt.ru',
  'SUBJECT' => '#SITE_NAME#: Поступление товара',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------
#NAME# (#PHONE#) (#EMAIL#)

Сообщить о поступление товара:

ID товара: #PRODUCT_ID#
Артикул: #PRODUCT_ART#
Наименование товара: #PRODUCT_NAME#

Сообщение сгенерировано автоматически.',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ GOODS_ARRIVAL_REPORT ] Сообщить о поступлении товара',
));
            $helper->Event()->saveEventType('SALE_STATUS_CHANGED_SV', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Изменение статуса заказа на  "Ожидает самовывоза из магазина"',
  'DESCRIPTION' => '#ORDER_ID# - код заказа
#ORDER_DATE# - дата заказа
#ORDER_STATUS# - статус заказа
#EMAIL# - E-Mail пользователя
#ORDER_DESCRIPTION# - описание статуса заказа
#TEXT# - текст
#SALE_EMAIL# - E-Mail отдела продаж
#ORDER_PUBLIC_URL# - ссылка для просмотра заказа без авторизации (требуется настройка в модуле интернет-магазина)
',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_SV', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => '<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 100%; margin: auto;">
 <img src="/include/images/email_banners/1.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
 <br>
 Информационное сообщение сайта #SITE_NAME#<br>
 ------------------------------------------<br>
 <br>
 Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.<br>
 <br>
 Новый статус заказа:<br>
 #ORDER_STATUS#<br>
 #ORDER_DESCRIPTION#<br>
 #TEXT#<br>
 <br>
 #SITE_NAME#<br>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_SV ] Изменение статуса заказа на  "Ожидает самовывоза из магазина"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_SV', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_SV ] Изменение статуса заказа на  "Ожидает самовывоза из магазина"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_SV', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_SV ] Изменение статуса заказа на  "Ожидает самовывоза из магазина"',
));
            $helper->Event()->saveEventType('SALE_STATUS_CHANGED_ZO', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Изменение статуса заказа на  "Заказ отправлен"',
  'DESCRIPTION' => '#ORDER_ID# - код заказа
#ORDER_DATE# - дата заказа
#ORDER_STATUS# - статус заказа
#EMAIL# - E-Mail пользователя
#ORDER_DESCRIPTION# - описание статуса заказа
#TEXT# - текст
#SALE_EMAIL# - E-Mail отдела продаж
#ORDER_PUBLIC_URL# - ссылка для просмотра заказа без авторизации (требуется настройка в модуле интернет-магазина)
',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_ZO', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => '<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 100%; margin: auto;">
 <img src="/include/images/email_banners/1.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
 <br>
 Информационное сообщение сайта #SITE_NAME#<br>
 ------------------------------------------<br>
 <br>
 Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.<br>
 <br>
 Новый статус заказа:<br>
 #ORDER_STATUS#<br>
 #ORDER_DESCRIPTION#<br>
 #TEXT#<br>
 <br>
 #SITE_NAME#<br>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_ZO ] Изменение статуса заказа на  "Заказ отправлен"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_ZO', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_ZO ] Изменение статуса заказа на  "Заказ отправлен"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_ZO', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_ZO ] Изменение статуса заказа на  "Заказ отправлен"',
));
            $helper->Event()->saveEventType('SALE_NEW_ORDER_RETAIL', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Новый заказ (розничный)',
  'DESCRIPTION' => '#ORDER_ID# - Номер заказа
#ORDER_DATE# - Дата
#ORDER_FIO# - Имя клиента
#ORDER_PHONE# - Телефон
#ORDER_EMAIL# - Email
#EMAIL# - Email
#ORDER_ZIP# - Индекс
#ORDER_CITY# - Город
#ORDER_ADDRESS# - Адрес
#ORDER_PRICE# - Сумма заказа
#ORDER_LIST# - Состав заказа
#SALE_EMAIL# - Email отдела продаж
#COMPANY# - Название компании
#BANK_INN# - ИНН
#BANK_KPP# - КПП
#BANK_ORGN# - ОРГН
#BANK_PAYMENT_ACCOUNT# - Счет
#BANK_NAME# - Название банка
#BANK_BIK# - БИК
#BANK_CORRESCPONDENT_ACCOUNT# - Корреспонденский счет
#BANK_PHONE# - Телефон банка
#BANK_CEO# - CEO',
  'SORT' => '150',
));
            $helper->Event()->saveEventType('SALE_NEW_ORDER_RETAIL', array (
  'LID' => 'en',
  'EVENT_TYPE' => 'email',
  'NAME' => 'New order (retail)',
  'DESCRIPTION' => '#ORDER_ID# - Order number
#ORDER_DATE# - Date
#ORDER_FIO# - Client name
#ORDER_PHONE# - Phone
#ORDER_EMAIL# - Email
#EMAIL# - Email
#ORDER_ZIP# - Zip
#ORDER_CITY# - City
#ORDER_ADDRESS# - Address
#ORDER_PRICE# - Order sum
#ORDER_LIST# - Order list
#SALE_EMAIL# - Sale email
#COMPANY# - Company name
#BANK_INN# - INN
#BANK_KPP# - KPP
#BANK_ORGN# - ORGN
#BANK_PAYMENT_ACCOUNT# - Account
#BANK_NAME# - Bank name
#BANK_BIK# - BIK
#BANK_CORRESCPONDENT_ACCOUNT# - Correscpondent account
#BANK_PHONE# - Bank phone
#BANK_CEO# - CEO',
  'SORT' => '150',
));
            $helper->Event()->saveEventMessage('SALE_NEW_ORDER_RETAIL', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Новый заказ N#ORDER_ID#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style> <br>
<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 850px; margin: auto;">
 <img src="/include/images/email_banners/4.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 Вами оформлен заказ в магазине #SITE_NAME#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
			 Здравствуйте, #ORDER_FIO#!
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 Благодарим Вас за заказ&nbsp;<b>№&nbsp;</b>#ORDER_ID# от #ORDER_DATE# в интернет-магазине quarta-hunt.ru<br>
 <br>
			 Телефон: #ORDER_PHONE#<br>
			 Email: #ORDER_EMAIL#<br>
			 Город: #ORDER_CITY#<br>
			 Адрес: #ORDER_ADDRESS#<br>
 <br>
			 Стоимость заказа: #ORDER_PRICE# рублей.<br>
 <br>
			 Состав заказа:<br>
			 #ORDER_LIST#<br>
 <br>
			 Вы можете следить за выполнением своего заказа (на какой стадии выполнения он находится)&nbsp;в&nbsp;личном кабинете на сайте #SITE_NAME#.<br>
 <br>
			 Обратите внимание, что для входа в этот раздел Вам необходимо будет ввести логин и пароль пользователя сайта #SITE_NAME#.<br>
 <br>
			 Пожалуйста, при обращении в поддержку #SITE_NAME# ОБЯЗАТЕЛЬНО указывайте номер Вашего заказа - #ORDER_ID#.<br>
 <br>
			 Спасибо за покупку!<br>
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 коллектив интернет-магазина #SITE_NAME# !<br>
			 E-mail: <a href="mailto:sales@quarta-hunt.ru">shop@quarta-hunt.ru</a><br>
			 Тел.:&nbsp;<a href="tel:+78007750304">+7 (800) 775-03-04</a>
		</p>
	</td>
</tr>
</tbody>
</table>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => 'shop@quarta-hunt.ru',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_NEW_ORDER_RETAIL ] Новый заказ (розничный)',
));
            $helper->Event()->saveEventMessage('SALE_NEW_ORDER_RETAIL', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => 'stalker@stalker.ru',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Новый заказ N#ORDER_ID#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 Вами оформлен заказ в магазине #SITE_NAME#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
			 Здравствуйте, #ORDER_FIO#,
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 Ваш заказ номер #ORDER_ID# от #ORDER_DATE# принят.<br>
 <br>
			 Телефон: #ORDER_PHONE#<br>
			 Email: #ORDER_EMAIL#<br>
			 Город: #ORDER_CITY#<br>
			 Адрес: #ORDER_ADDRESS#<br>
 <br>
			 Стоимость заказа: #ORDER_PRICE#.<br>
 <br>
			 Состав заказа:<br>
			 #ORDER_LIST#<br>
 <br>
			 Вы можете следить за выполнением своего заказа (на какой стадии выполнения он находится), войдя в Ваш персональный раздел сайта #SITE_NAME#.<br>
 <br>
			 Обратите внимание, что для входа в этот раздел Вам необходимо будет ввести логин и пароль пользователя сайта #SITE_NAME#.<br>
 <br>
			 Для того, чтобы аннулировать заказ, воспользуйтесь функцией отмены заказа, которая доступна в Вашем персональном разделе сайта #SITE_NAME#.<br>
 <br>
			 Пожалуйста, при обращении к администрации сайта #SITE_NAME# ОБЯЗАТЕЛЬНО указывайте номер Вашего заказа - #ORDER_ID#.<br>
 <br>
			 Спасибо за покупку!<br>
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br>
			 E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
		</p>
	</td>
</tr>
</tbody>
</table>',
  'BODY_TYPE' => 'html',
  'BCC' => 'shop@stalker.ru',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_NEW_ORDER_RETAIL ] Новый заказ (розничный)',
));
            $helper->Event()->saveEventMessage('SALE_NEW_ORDER_RETAIL', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => 'stalker@stalker.ru',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Новый заказ N#ORDER_ID#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 Вами оформлен заказ в магазине #SITE_NAME#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
			 Здравствуйте, #ORDER_FIO#,
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 Ваш заказ номер #ORDER_ID# от #ORDER_DATE# принят.<br>
 <br>
			 Телефон: #ORDER_PHONE#<br>
			 Email: #ORDER_EMAIL#<br>
			 Город: #ORDER_CITY#<br>
			 Адрес: #ORDER_ADDRESS#<br>
 <br>
			 Стоимость заказа: #ORDER_PRICE#.<br>
 <br>
			 Состав заказа:<br>
			 #ORDER_LIST#<br>
 <br>
			 Вы можете следить за выполнением своего заказа (на какой стадии выполнения он находится), войдя в Ваш персональный раздел сайта #SITE_NAME#.<br>
 <br>
			 Обратите внимание, что для входа в этот раздел Вам необходимо будет ввести логин и пароль пользователя сайта #SITE_NAME#.<br>
 <br>
			 Для того, чтобы аннулировать заказ, воспользуйтесь функцией отмены заказа, которая доступна в Вашем персональном разделе сайта #SITE_NAME#.<br>
 <br>
			 Пожалуйста, при обращении к администрации сайта #SITE_NAME# ОБЯЗАТЕЛЬНО указывайте номер Вашего заказа - #ORDER_ID#.<br>
 <br>
			 Спасибо за покупку!<br>
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br>
			 E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
		</p>
	</td>
</tr>
</tbody>
</table>',
  'BODY_TYPE' => 'html',
  'BCC' => 'shop@stalker.ru',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_NEW_ORDER_RETAIL ] Новый заказ (розничный)',
));
            $helper->Event()->saveEventType('SALE_STATUS_CHANGED_OT', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Изменение статуса заказа на  "Отменён"',
  'DESCRIPTION' => '#ORDER_ID# - код заказа
#ORDER_DATE# - дата заказа
#ORDER_STATUS# - статус заказа
#EMAIL# - E-Mail пользователя
#ORDER_DESCRIPTION# - описание статуса заказа
#TEXT# - текст
#SALE_EMAIL# - E-Mail отдела продаж
#ORDER_PUBLIC_URL# - ссылка для просмотра заказа без авторизации (требуется настройка в модуле интернет-магазина)
',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_OT', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => '<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 100%; margin: auto;">
 <img src="/include/images/email_banners/1.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;"><br>
 <br>
</div>
 Информационное сообщение сайта #SITE_NAME#<br>
 ------------------------------------------<br>
 <br>
 Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.<br>
 <br>
 Новый статус заказа:<br>
 #ORDER_STATUS#<br>
 #ORDER_DESCRIPTION#<br>
 #TEXT#<br>
 <br>
 #SITE_NAME# <br>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_OT ] Изменение статуса заказа на  "Отменён"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_OT', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_OT ] Изменение статуса заказа на  "Отменён"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_OT', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_OT ] Изменение статуса заказа на  "Отменён"',
));
            $helper->Event()->saveEventType('SALE_STATUS_CHANGED_H', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Изменение статуса заказа на  "Не удалось дозвониться"',
  'DESCRIPTION' => '#ORDER_ID# - код заказа
#ORDER_DATE# - дата заказа
#ORDER_STATUS# - статус заказа
#EMAIL# - E-Mail пользователя
#ORDER_DESCRIPTION# - описание статуса заказа
#TEXT# - текст
#SALE_EMAIL# - E-Mail отдела продаж
#ORDER_PUBLIC_URL# - ссылка для просмотра заказа без авторизации (требуется настройка в модуле интернет-магазина)
',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_H', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => '<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 100%; margin: auto;">
 <img src="/include/images/email_banners/1.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;"><br>
 <br>
</div>
 Информационное сообщение сайта #SITE_NAME#<br>
 ------------------------------------------<br>
 <br>
 Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.<br>
 <br>
 Новый статус заказа:<br>
 #ORDER_STATUS#<br>
 #ORDER_DESCRIPTION#<br>
 #TEXT#<br>
 <br>
 #SITE_NAME#<br>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_H ] Изменение статуса заказа на  "Не удалось дозвониться"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_H', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_H ] Изменение статуса заказа на  "Не удалось дозвониться"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_H', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_H ] Изменение статуса заказа на  "Не удалось дозвониться"',
));
            $helper->Event()->saveEventType('SALE_STATUS_CHANGED_PP', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Изменение статуса заказа на  "Оплачен"',
  'DESCRIPTION' => '#ORDER_ID# - код заказа
#ORDER_DATE# - дата заказа
#ORDER_STATUS# - статус заказа
#EMAIL# - E-Mail пользователя
#ORDER_DESCRIPTION# - описание статуса заказа
#TEXT# - текст
#SALE_EMAIL# - E-Mail отдела продаж
#ORDER_PUBLIC_URL# - ссылка для просмотра заказа без авторизации (требуется настройка в модуле интернет-магазина)
',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_PP', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => '<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 100%; margin: auto;">
 <img src="/include/images/email_banners/1.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
 <br>
 Информационное сообщение сайта #SITE_NAME#<br>
 ------------------------------------------<br>
 <br>
 Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.<br>
 <br>
 Новый статус заказа:<br>
 #ORDER_STATUS#<br>
 #ORDER_DESCRIPTION#<br>
 #TEXT#<br>
 <br>
 #SITE_NAME#<br>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_PP ] Изменение статуса заказа на  "Оплачен"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_PP', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_PP ] Изменение статуса заказа на  "Оплачен"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_PP', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_PP ] Изменение статуса заказа на  "Оплачен"',
));
            $helper->Event()->saveEventType('LOGICTIM_BONUS_FROM_ORDER_ADD', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Начислены бонусы за заказ',
  'DESCRIPTION' => '#ORDER_ID# - Номер заказа (ID)
#ORDER_NUM# - Номер заказа при использовании шаблона генерации номера заказа
#BONUS# - Начислено бонусов
#BALLANCE_BEFORE# - Бонусов на счету пользователя до начисления
#BALLANCE_AFTER# - Бонусов на счету пользователя после начисления
#OPERATION_NAME# - Наименование операции
#NAME# - Имя пользователя
#LAST_NAME# - Фамилия пользователя
#SECOND_NAME# - Отчество пользователя
#LOGIN# - Логин пользователя
#EMAIL# - E-mail пользователя
#DETAIL# - Состав начисления баллов
#SITE# - Адрес сайта
#BONUS_LIVE_DATE# - Дата окончания срока активности бонусов',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('LOGICTIM_BONUS_FROM_ORDER_ADD', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => 'order@quarta-hunt.ru',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => 'Бонусы за заказ №#ORDER_ID#',
  'MESSAGE' => '<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 100%; margin: auto;">
 <img src="/include/images/email_banners/2.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
 <br>
 Здравствуйте, <b>#LAST_NAME# #NAME# #SECOND_NAME#</b>!<br>
 <br>
 Вам начислены бонусы по заказу №#ORDER_ID# на сайте <a href="http://#SITE#">#SITE#</a> !<br>
 <br>
 Начислено бонусов: #BONUS#<br>
 Начисленные бонусы активны до: #BONUS_LIVE_DATE#<br>
 Всего бонусов на Вашем счете: #BALLANCE_AFTER#<br>
 <br>
 Ваш логин на сайте: #LOGIN#<br>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ LOGICTIM_BONUS_FROM_ORDER_ADD ] Начислены бонусы за заказ',
));
            $helper->Event()->saveEventMessage('LOGICTIM_BONUS_FROM_ORDER_ADD', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => 'Бонусы за заказ №#ORDER_ID#',
  'MESSAGE' => 'Здравствуйте, <b>#LAST_NAME# #NAME#  #SECOND_NAME#</b>!<br><br>
Вам начислены бонусы по заказу №#ORDER_ID# на сайте <a href="http://#SITE#">#SITE#</a> !<br><br>
Начислено бонусов: #BONUS#<br>
Начисленные бонусы активны до: #BONUS_LIVE_DATE#<br>
Всего бонусов на Вашем счете: #BALLANCE_AFTER#<br><br>
Ваш логин на сайте: #LOGIN# ',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ LOGICTIM_BONUS_FROM_ORDER_ADD ] Начислены бонусы за заказ',
));
            $helper->Event()->saveEventMessage('LOGICTIM_BONUS_FROM_ORDER_ADD', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => 'Бонусы за заказ №#ORDER_ID#',
  'MESSAGE' => 'Здравствуйте, <b>#LAST_NAME# #NAME#  #SECOND_NAME#</b>!<br><br>
Вам начислены бонусы по заказу №#ORDER_ID# на сайте <a href="http://#SITE#">#SITE#</a> !<br><br>
Начислено бонусов: #BONUS#<br>
Начисленные бонусы активны до: #BONUS_LIVE_DATE#<br>
Всего бонусов на Вашем счете: #BALLANCE_AFTER#<br><br>
Ваш логин на сайте: #LOGIN# ',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ LOGICTIM_BONUS_FROM_ORDER_ADD ] Начислены бонусы за заказ',
));
            $helper->Event()->saveEventType('LOGICTIM_BONUS_WARNING_END_TIME', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Бонусные баллы скоро сгорят! Успей потратить!',
  'DESCRIPTION' => '#BONUS# - Сколько бонусов сгорит в ближайшее время
#BALLANCE_USER# - Бонусов на счету пользователя
#NAME# - Имя пользователя
#LAST_NAME# - Фамилия пользователя
#LOGIN# - Логин пользователя
#EMAIL# - E-mail пользователя
#SITE# - Адрес сайта
#BONUS_LIVE_DATE# - Дата окончания срока активности бонусов',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('LOGICTIM_BONUS_WARNING_END_TIME', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => 'order@quarta-hunt.ru',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => 'Ваши бонусы скоро исчезнут⏰',
  'MESSAGE' => '<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 100%; margin: auto;">
 <img src="/include/images/email_banners/3.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
 <br>
 Здравствуйте, <b>#NAME#</b>!<br>
 <br>
 Успейте потратить их до #BONUS_LIVE_DATE#!<br>
 <br>
 Скоро сгорят: #BONUS# бонусов.<br>
 Активны до: #BONUS_LIVE_DATE#<br>
 <br>
 Всего на Вашем счете: #BALLANCE_USER# бонусов.<br>
 <br>
 Ваш логин на сайте: #LOGIN#<br>
 <br>
 С уважением,<br>
 коллектив интернет-магазина&nbsp;#SITE#&nbsp;!<br>
 E-mail:&nbsp;<a href="mailto:sales@quarta-hunt.ru">shop@quarta-hunt.ru</a><br>
 Тел.:&nbsp;<a href="tel:+78007750304">+7 (800) 775-03-04</a><br>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ LOGICTIM_BONUS_WARNING_END_TIME ] Бонусные баллы скоро сгорят! Успей потратить!',
));
            $helper->Event()->saveEventMessage('LOGICTIM_BONUS_WARNING_END_TIME', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => 'Предупреждение об окончании срока действия бонусов на сайте #SITE#',
  'MESSAGE' => 'Здравствуйте, <b>#LAST_NAME# #NAME#  #SECOND_NAME#</b>!<br><br>
У Вас имеются не использованные бонусы на сайте <a href="http://#SITE#">#SITE#</a> !<br><br>
Подходит к концу срок действия бонусов суммой: #BONUS#<br>
Начисленные бонусы активны до: #BONUS_LIVE_DATE#<br><br>
Всего бонусов на Вашем счете: #BALLANCE_USER#<br><br>
Ваш логин на сайте: #LOGIN# ',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ LOGICTIM_BONUS_WARNING_END_TIME ] Бонусные баллы скоро сгорят! Успей потратить!',
));
            $helper->Event()->saveEventMessage('LOGICTIM_BONUS_WARNING_END_TIME', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => 'Предупреждение об окончании срока действия бонусов на сайте #SITE#',
  'MESSAGE' => 'Здравствуйте, <b>#LAST_NAME# #NAME#  #SECOND_NAME#</b>!<br><br>
У Вас имеются не использованные бонусы на сайте <a href="http://#SITE#">#SITE#</a> !<br><br>
Подходит к концу срок действия бонусов суммой: #BONUS#<br>
Начисленные бонусы активны до: #BONUS_LIVE_DATE#<br><br>
Всего бонусов на Вашем счете: #BALLANCE_USER#<br><br>
Ваш логин на сайте: #LOGIN# ',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ LOGICTIM_BONUS_WARNING_END_TIME ] Бонусные баллы скоро сгорят! Успей потратить!',
));
            $helper->Event()->saveEventType('SALE_STATUS_CHANGED_W', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Изменение статуса заказа на  "Принят, ожидается оплата"',
  'DESCRIPTION' => '#ORDER_ID# - код заказа
#ORDER_DATE# - дата заказа
#ORDER_STATUS# - статус заказа
#EMAIL# - E-Mail пользователя
#ORDER_DESCRIPTION# - описание статуса заказа
#TEXT# - текст
#SALE_EMAIL# - E-Mail отдела продаж
#ORDER_PUBLIC_URL# - ссылка для просмотра заказа без авторизации (требуется настройка в модуле интернет-магазина)
',
  'SORT' => '100',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_W', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => '<div style="display: flex; justify-content: center; align-items: center; text-align: center; margin: auto; width: 100%;">
 <img src="/include/images/header-snippet-email.png">
</div>
<div style="width: 100%; margin: auto;">
 <img src="/include/images/email_banners/1.jpg" style="width: 100%; height: auto; object-fit: contain; margin: auto;">
</div>
<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
	 Здравствуйте, #NAME#!
</p>
 Статус заказ&nbsp;№ #ORDER_ID# от #ORDER_DATE# успешно изменен.<br>
 <br>
 Новый статус заказа:<br>
 #ORDER_STATUS#<br>
 #ORDER_DESCRIPTION#<br>
 <br>
 Подробную информацию о статусе заказа Вы можете уточнить в&nbsp;<a href="https://quarta-hunt.ru/cabinet/orders/#">личном кабинете</a>, в чате или по телефону:&nbsp;<a href="tel:+78007750304">+7 (800) 775-03-04</a><br>
 <br>
 С уважением,<br>
 интернет-магазин&nbsp;#SITE_NAME# !<br>
 E-mail:&nbsp;<a href="mailto:sales@quarta-hunt.ru">shop@quarta-hunt.ru</a><br>
 Тел.:&nbsp;<a href="tel:+78007750304">+7 (800) 775-03-04</a><br>
 <br>
<div style="display: flex; align-items: center; justify-content: center; margin: auto; width: 100%; flex-direction: column;">
	<table align="center" cellpadding="0" cellspacing="0" class="bxBlockContentEdgeSocial" style="border: 0;">
	<tbody>
	<tr>
		<td valign="top" class="bxBlockPadding" style="border: 0;">
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://vk.com/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="vk.com">vk.com</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://www.youtube.com/channel/UCiZRW21PB-OK1CY6Rrv88nw" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="YouTube">YouTube</a>
				</td>
			</tr>
			</tbody>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" style="border-collapse: separate !important; margin-right: 10px; border: 0;">
			<tbody>
			<tr>
				<td valign="top" style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; border: 0;">
 <a class="bxBlockContentSocial" href="https://t.me/quarta_hunt_official" target="_blank" style="font-weight: bold; letter-spacing: normal; line-height: 100%; text-align: center; font-size: 12px; text-decoration: none; color: #949da9;" title="Telegram">Telegram</a>
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	</tbody>
	</table>
 <br>
	<div style="display: flex;align-items: flex-start;justify-content: space-between;max-width: 80%;margin: 0 auto;">
		<div>
			Магазин по адресу: г. Санкт-Петербург, Московский проспект, д.222А
		</div>
		<div>
			График работы по будням 10:00-20:00, по выходным 10:00-18:00
		</div>
	</div>
</div>
<br>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_W ] Изменение статуса заказа на  "Принят, ожидается оплата"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_W', array (
  'LID' => 
  array (
    0 => 'st',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => NULL,
  'REPLY_TO' => NULL,
  'CC' => NULL,
  'IN_REPLY_TO' => NULL,
  'PRIORITY' => NULL,
  'FIELD1_NAME' => NULL,
  'FIELD1_VALUE' => NULL,
  'FIELD2_NAME' => NULL,
  'FIELD2_VALUE' => NULL,
  'SITE_TEMPLATE_ID' => NULL,
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => NULL,
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_W ] Изменение статуса заказа на  "Принят, ожидается оплата"',
));
            $helper->Event()->saveEventMessage('SALE_STATUS_CHANGED_W', array (
  'LID' => 
  array (
    0 => 'sh',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SERVER_NAME#: Изменение статуса заказа N#ORDER_ID#',
  'MESSAGE' => 'Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Статус заказа номер #ORDER_ID# от #ORDER_DATE# изменен.

Новый статус заказа:
#ORDER_STATUS#
#ORDER_DESCRIPTION#
#TEXT#

#SITE_NAME#
',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ SALE_STATUS_CHANGED_W ] Изменение статуса заказа на  "Принят, ожидается оплата"',
));
        }

    public function down()
    {
        //your code ...
    }
}
