<?php

namespace Sprint\Migration;


class Version20241025214113 extends Version
{
    protected $description = "113979 | Товар детальная / Блок выбора предложения и покупки | Справочник размеров";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $hlblockId = $helper->Hlblock()->saveHlblock(array (
  'NAME' => 'Hutclothessize',
  'TABLE_NAME' => 'b_hlbd_hutclothessize',
));
        $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_NAME',
  'USER_TYPE_ID' => 'string',
  'XML_ID' => '',
  'SORT' => '200',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'Y',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 
  array (
    'SIZE' => 20,
    'ROWS' => 1,
    'REGEXP' => '',
    'MIN_LENGTH' => 0,
    'MAX_LENGTH' => 0,
    'DEFAULT_VALUE' => NULL,
  ),
  'EDIT_FORM_LABEL' => 
  array (
    'ru' => 'Название',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'ru' => 'Название',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'ru' => 'Название',
  ),
  'ERROR_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
  'HELP_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_SORT',
  'USER_TYPE_ID' => 'integer',
  'XML_ID' => '',
  'SORT' => '300',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 
  array (
    'SIZE' => 20,
    'MIN_VALUE' => 0,
    'MAX_VALUE' => 0,
    'DEFAULT_VALUE' => NULL,
  ),
  'EDIT_FORM_LABEL' => 
  array (
    'ru' => 'Сортировка',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'ru' => 'Сортировка',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'ru' => 'Сортировка',
  ),
  'ERROR_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
  'HELP_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_XML_ID',
  'USER_TYPE_ID' => 'string',
  'XML_ID' => '',
  'SORT' => '400',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'Y',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 
  array (
    'SIZE' => 20,
    'ROWS' => 1,
    'REGEXP' => '',
    'MIN_LENGTH' => 0,
    'MAX_LENGTH' => 0,
    'DEFAULT_VALUE' => NULL,
  ),
  'EDIT_FORM_LABEL' => 
  array (
    'ru' => 'Внешний код',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'ru' => 'Внешний код',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'ru' => 'Внешний код',
  ),
  'ERROR_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
  'HELP_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_LINK',
  'USER_TYPE_ID' => 'string',
  'XML_ID' => '',
  'SORT' => '500',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 
  array (
    'SIZE' => 20,
    'ROWS' => 1,
    'REGEXP' => '',
    'MIN_LENGTH' => 0,
    'MAX_LENGTH' => 0,
    'DEFAULT_VALUE' => NULL,
  ),
  'EDIT_FORM_LABEL' => 
  array (
    'ru' => 'Ссылка',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'ru' => 'Ссылка',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'ru' => 'Ссылка',
  ),
  'ERROR_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
  'HELP_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_DESCRIPTION',
  'USER_TYPE_ID' => 'string',
  'XML_ID' => '',
  'SORT' => '600',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 
  array (
    'SIZE' => 20,
    'ROWS' => 1,
    'REGEXP' => '',
    'MIN_LENGTH' => 0,
    'MAX_LENGTH' => 0,
    'DEFAULT_VALUE' => NULL,
  ),
  'EDIT_FORM_LABEL' => 
  array (
    'ru' => 'Описание',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'ru' => 'Описание',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'ru' => 'Описание',
  ),
  'ERROR_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
  'HELP_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_FULL_DESCRIPTION',
  'USER_TYPE_ID' => 'string',
  'XML_ID' => '',
  'SORT' => '700',
  'MULTIPLE' => 'N',
  'MANDATORY' => 'N',
  'SHOW_FILTER' => 'N',
  'SHOW_IN_LIST' => 'Y',
  'EDIT_IN_LIST' => 'Y',
  'IS_SEARCHABLE' => 'N',
  'SETTINGS' => 
  array (
    'SIZE' => 20,
    'ROWS' => 1,
    'REGEXP' => '',
    'MIN_LENGTH' => 0,
    'MAX_LENGTH' => 0,
    'DEFAULT_VALUE' => NULL,
  ),
  'EDIT_FORM_LABEL' => 
  array (
    'ru' => 'Полное описание',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'ru' => 'Полное описание',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'ru' => 'Полное описание',
  ),
  'ERROR_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
  'HELP_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
));
            $helper->Hlblock()->saveField($hlblockId, array (
  'FIELD_NAME' => 'UF_DEF',
  'USER_TYPE_ID' => 'boolean',
  'XML_ID' => '',
  'SORT' => '800',
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
    'ru' => 'По умолчанию',
  ),
  'LIST_COLUMN_LABEL' => 
  array (
    'ru' => 'По умолчанию',
  ),
  'LIST_FILTER_LABEL' => 
  array (
    'ru' => 'По умолчанию',
  ),
  'ERROR_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
  'HELP_MESSAGE' => 
  array (
    'ru' => NULL,
  ),
));
        }

    public function down()
    {
        //your code ...
    }
}
