<?php

namespace Sprint\Migration;


class Version20250227132326 extends Version
{
    protected $description = "120450 | Создать страницу для оптового предложения / Форма";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $formHelper = $helper->Form();
        $formId = $formHelper->saveForm(array (
  'NAME' => 'HUT - Оптовикам',
  'SID' => 'HUT_OPT',
  'BUTTON' => 'Отправить',
  'C_SORT' => '600',
  'FIRST_SITE_ID' => NULL,
  'IMAGE_ID' => NULL,
  'USE_CAPTCHA' => 'N',
  'DESCRIPTION' => 'ЗАПОЛНИТЕ ЗАЯВКУ И ОТКРОЙТЕ<br>
<span>ДОСТУП</span> К <span>СПЕЦИАЛЬНЫМ</span> УСЛОВИЯМ',
  'DESCRIPTION_TYPE' => 'html',
  'FORM_TEMPLATE' => '',
  'USE_DEFAULT_TEMPLATE' => 'Y',
  'SHOW_TEMPLATE' => NULL,
  'MAIL_EVENT_TYPE' => 'FORM_FILLING_HUT_OPT',
  'SHOW_RESULT_TEMPLATE' => NULL,
  'PRINT_RESULT_TEMPLATE' => NULL,
  'EDIT_RESULT_TEMPLATE' => NULL,
  'FILTER_RESULT_TEMPLATE' => '',
  'TABLE_RESULT_TEMPLATE' => '',
  'USE_RESTRICTIONS' => 'N',
  'RESTRICT_USER' => '0',
  'RESTRICT_TIME' => '0',
  'RESTRICT_STATUS' => '',
  'STAT_EVENT1' => 'form',
  'STAT_EVENT2' => 'hut_opt',
  'STAT_EVENT3' => '',
  'LID' => NULL,
  'C_FIELDS' => '0',
  'QUESTIONS' => '7',
  'STATUSES' => '1',
  'arSITE' => 
  array (
    0 => 'ht',
  ),
  'arMENU' => 
  array (
    'en' => '',
    'ru' => '',
  ),
  'arGROUP' => 
  array (
  ),
  'arMAIL_TEMPLATE' => 
  array (
  ),
));
        $formHelper->saveStatuses($formId, array (
  0 => 
  array (
    'CSS' => 'statusgreen',
    'C_SORT' => '100',
    'ACTIVE' => 'Y',
    'TITLE' => 'DEFAULT',
    'DESCRIPTION' => 'DEFAULT',
    'DEFAULT_VALUE' => 'Y',
    'HANDLER_OUT' => 'statusgreen',
    'HANDLER_IN' => '',
  ),
));
        $formHelper->saveFields($formId, array (
  0 => 
  array (
    'ACTIVE' => 'Y',
    'TITLE' => 'Компания',
    'TITLE_TYPE' => 'text',
    'SID' => 'COMPANY',
    'C_SORT' => '100',
    'ADDITIONAL' => 'N',
    'REQUIRED' => 'Y',
    'IN_FILTER' => 'N',
    'IN_RESULTS_TABLE' => 'Y',
    'IN_EXCEL_TABLE' => 'Y',
    'FIELD_TYPE' => '',
    'IMAGE_ID' => NULL,
    'COMMENTS' => 'Название вашей компании',
    'FILTER_TITLE' => '',
    'RESULTS_TABLE_TITLE' => '',
    'ANSWERS' => 
    array (
      0 => 
      array (
        'MESSAGE' => ' ',
        'VALUE' => '',
        'FIELD_TYPE' => 'text',
        'FIELD_WIDTH' => '0',
        'FIELD_HEIGHT' => '0',
        'FIELD_PARAM' => '',
        'C_SORT' => '100',
        'ACTIVE' => 'Y',
      ),
    ),
    'VALIDATORS' => 
    array (
    ),
  ),
  1 => 
  array (
    'ACTIVE' => 'Y',
    'TITLE' => 'Адрес',
    'TITLE_TYPE' => 'text',
    'SID' => 'ADDRESS',
    'C_SORT' => '200',
    'ADDITIONAL' => 'N',
    'REQUIRED' => 'N',
    'IN_FILTER' => 'N',
    'IN_RESULTS_TABLE' => 'Y',
    'IN_EXCEL_TABLE' => 'Y',
    'FIELD_TYPE' => '',
    'IMAGE_ID' => NULL,
    'COMMENTS' => 'Адрес вашей компании',
    'FILTER_TITLE' => '',
    'RESULTS_TABLE_TITLE' => '',
    'ANSWERS' => 
    array (
      0 => 
      array (
        'MESSAGE' => ' ',
        'VALUE' => '',
        'FIELD_TYPE' => 'text',
        'FIELD_WIDTH' => '0',
        'FIELD_HEIGHT' => '0',
        'FIELD_PARAM' => '',
        'C_SORT' => '100',
        'ACTIVE' => 'Y',
      ),
    ),
    'VALIDATORS' => 
    array (
    ),
  ),
  2 => 
  array (
    'ACTIVE' => 'Y',
    'TITLE' => 'Торговая площадка',
    'TITLE_TYPE' => 'text',
    'SID' => 'SHOP_PLACE',
    'C_SORT' => '300',
    'ADDITIONAL' => 'N',
    'REQUIRED' => 'Y',
    'IN_FILTER' => 'N',
    'IN_RESULTS_TABLE' => 'Y',
    'IN_EXCEL_TABLE' => 'Y',
    'FIELD_TYPE' => '',
    'IMAGE_ID' => NULL,
    'COMMENTS' => 'Название магазина, ссылка на сайт',
    'FILTER_TITLE' => '',
    'RESULTS_TABLE_TITLE' => '',
    'ANSWERS' => 
    array (
      0 => 
      array (
        'MESSAGE' => ' ',
        'VALUE' => '',
        'FIELD_TYPE' => 'text',
        'FIELD_WIDTH' => '0',
        'FIELD_HEIGHT' => '0',
        'FIELD_PARAM' => '',
        'C_SORT' => '100',
        'ACTIVE' => 'Y',
      ),
    ),
    'VALIDATORS' => 
    array (
    ),
  ),
  3 => 
  array (
    'ACTIVE' => 'Y',
    'TITLE' => 'Контактное лицо',
    'TITLE_TYPE' => 'text',
    'SID' => 'FIO',
    'C_SORT' => '400',
    'ADDITIONAL' => 'N',
    'REQUIRED' => 'Y',
    'IN_FILTER' => 'N',
    'IN_RESULTS_TABLE' => 'Y',
    'IN_EXCEL_TABLE' => 'Y',
    'FIELD_TYPE' => '',
    'IMAGE_ID' => NULL,
    'COMMENTS' => 'ФИО',
    'FILTER_TITLE' => '',
    'RESULTS_TABLE_TITLE' => '',
    'ANSWERS' => 
    array (
      0 => 
      array (
        'MESSAGE' => ' ',
        'VALUE' => '',
        'FIELD_TYPE' => 'text',
        'FIELD_WIDTH' => '0',
        'FIELD_HEIGHT' => '0',
        'FIELD_PARAM' => '',
        'C_SORT' => '100',
        'ACTIVE' => 'Y',
      ),
    ),
    'VALIDATORS' => 
    array (
    ),
  ),
  4 => 
  array (
    'ACTIVE' => 'Y',
    'TITLE' => 'Должность',
    'TITLE_TYPE' => 'text',
    'SID' => 'WORK',
    'C_SORT' => '500',
    'ADDITIONAL' => 'N',
    'REQUIRED' => 'Y',
    'IN_FILTER' => 'N',
    'IN_RESULTS_TABLE' => 'Y',
    'IN_EXCEL_TABLE' => 'Y',
    'FIELD_TYPE' => '',
    'IMAGE_ID' => NULL,
    'COMMENTS' => 'Должность контактного лица',
    'FILTER_TITLE' => '',
    'RESULTS_TABLE_TITLE' => '',
    'ANSWERS' => 
    array (
      0 => 
      array (
        'MESSAGE' => ' ',
        'VALUE' => '',
        'FIELD_TYPE' => 'text',
        'FIELD_WIDTH' => '0',
        'FIELD_HEIGHT' => '0',
        'FIELD_PARAM' => '',
        'C_SORT' => '100',
        'ACTIVE' => 'Y',
      ),
    ),
    'VALIDATORS' => 
    array (
    ),
  ),
  5 => 
  array (
    'ACTIVE' => 'Y',
    'TITLE' => 'Телефон',
    'TITLE_TYPE' => 'text',
    'SID' => 'PHONE',
    'C_SORT' => '600',
    'ADDITIONAL' => 'N',
    'REQUIRED' => 'Y',
    'IN_FILTER' => 'N',
    'IN_RESULTS_TABLE' => 'Y',
    'IN_EXCEL_TABLE' => 'Y',
    'FIELD_TYPE' => '',
    'IMAGE_ID' => NULL,
    'COMMENTS' => '+7',
    'FILTER_TITLE' => '',
    'RESULTS_TABLE_TITLE' => '',
    'ANSWERS' => 
    array (
      0 => 
      array (
        'MESSAGE' => ' ',
        'VALUE' => '',
        'FIELD_TYPE' => 'text',
        'FIELD_WIDTH' => '0',
        'FIELD_HEIGHT' => '0',
        'FIELD_PARAM' => '',
        'C_SORT' => '100',
        'ACTIVE' => 'Y',
      ),
    ),
    'VALIDATORS' => 
    array (
    ),
  ),
  6 => 
  array (
    'ACTIVE' => 'Y',
    'TITLE' => 'Email',
    'TITLE_TYPE' => 'text',
    'SID' => 'EMAIL',
    'C_SORT' => '700',
    'ADDITIONAL' => 'N',
    'REQUIRED' => 'Y',
    'IN_FILTER' => 'N',
    'IN_RESULTS_TABLE' => 'Y',
    'IN_EXCEL_TABLE' => 'Y',
    'FIELD_TYPE' => '',
    'IMAGE_ID' => NULL,
    'COMMENTS' => 'Контактный email',
    'FILTER_TITLE' => '',
    'RESULTS_TABLE_TITLE' => '',
    'ANSWERS' => 
    array (
      0 => 
      array (
        'MESSAGE' => ' ',
        'VALUE' => '',
        'FIELD_TYPE' => 'text',
        'FIELD_WIDTH' => '0',
        'FIELD_HEIGHT' => '0',
        'FIELD_PARAM' => '',
        'C_SORT' => '100',
        'ACTIVE' => 'Y',
      ),
    ),
    'VALIDATORS' => 
    array (
    ),
  ),
));
    }

    public function down()
    {
        //your code ...
    }
}

