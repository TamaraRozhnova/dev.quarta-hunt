<?php

namespace Sprint\Migration;


class Version20250306140117 extends Version
{
    protected $description = "120479 | Переключить сайт на боевой каталог 1С / Изменение поля ASD_IBLOCK";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->UserTypeEntity()->saveUserTypeEntity(array (
  'ENTITY_ID' => 'ASD_IBLOCK',
  'FIELD_NAME' => 'UF_CATALOG_START',
  'USER_TYPE_ID' => 'iblock_section',
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
    'LIST_HEIGHT' => 10,
    'IBLOCK_ID' => 110,
    'DEFAULT_VALUE' => '',
    'ACTIVE_FILTER' => 'N',
  ),
  'EDIT_FORM_LABEL' => 
  array (
    'en' => '',
    'ru' => 'Разделы для отображения на стартовой странице каталога',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'en' => '',
    'ru' => 'Разделы для отображения на стартовой странице каталога',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'en' => '',
    'ru' => 'Разделы для отображения на стартовой странице каталога',
  ),
  'ERROR_MESSAGE' => 
  array (
    'en' => '',
    'ru' => 'Разделы для отображения на стартовой странице каталога',
  ),
  'HELP_MESSAGE' => 
  array (
    'en' => '',
    'ru' => 'Разделы для отображения на стартовой странице каталога',
  ),
));
    }

    public function down()
    {
        //your code ...
    }
}
