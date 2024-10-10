<?php

namespace Sprint\Migration;


class Version20241011001454 extends Version
{
    protected $description = "113995 | Всплывающие окно поиска | Свойство каталога для поиска";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->UserTypeEntity()->saveUserTypeEntity(array (
  'ENTITY_ID' => 'IBLOCK_hut:hutcatalog_SECTION',
  'FIELD_NAME' => 'UF_SHOW_IN_SEARCH',
  'USER_TYPE_ID' => 'boolean',
  'XML_ID' => '',
  'SORT' => '100',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 
  array (
    'DEFAULT_VALUE' => 0,
    'DISPLAY' => 'CHECKBOX',
    'LABEL' => 
    array (
      0 => '',
      1 => '',
    ),
    'LABEL_CHECKBOX' => '',
  ),
  'EDIT_FORM_LABEL' => 
  array (
    'en' => '',
    'ru' => 'Показывать в строке поиска',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'en' => '',
    'ru' => 'Показывать в строке поиска',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'en' => '',
    'ru' => 'Показывать в строке поиска',
  ),
  'ERROR_MESSAGE' => 
  array (
    'en' => '',
    'ru' => 'Показывать в строке поиска',
  ),
  'HELP_MESSAGE' => 
  array (
    'en' => '',
    'ru' => 'Показывать в строке поиска',
  ),
));
    }

    public function down()
    {
        //your code ...
    }
}
