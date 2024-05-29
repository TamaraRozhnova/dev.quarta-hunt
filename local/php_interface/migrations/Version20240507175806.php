<?php

namespace Sprint\Migration;


class Version20240507175806 extends Version
{
    protected $description = "109732 | Сайт / Новое меню каталога / Настройка брендов | Польз.поле привязка к бренду";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->UserTypeEntity()->saveUserTypeEntity(array (
  'ENTITY_ID' => 'IBLOCK_1c_catalog:catalog1c_main_SECTION',
  'FIELD_NAME' => 'UF_BRAND_LINK',
  'USER_TYPE_ID' => 'iblock_element',
  'XML_ID' => '',
  'SORT' => '100',
  'MULTIPLE' => 'Y',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 
  array (
    'DISPLAY' => 'LIST',
    'LIST_HEIGHT' => 1,
    'IBLOCK_ID' => 'content:Brands',
    'DEFAULT_VALUE' => '',
    'ACTIVE_FILTER' => 'Y',
  ),
  'EDIT_FORM_LABEL' => 
  array (
    'en' => '',
    'ru' => 'Привязать бренды',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'en' => '',
    'ru' => 'Привязать бренды',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'en' => '',
    'ru' => 'Привязать бренды',
  ),
  'ERROR_MESSAGE' => 
  array (
    'en' => '',
    'ru' => '',
  ),
  'HELP_MESSAGE' => 
  array (
    'en' => '',
    'ru' => '',
  ),
));
    }

    public function down()
    {
        //your code ...
    }
}
