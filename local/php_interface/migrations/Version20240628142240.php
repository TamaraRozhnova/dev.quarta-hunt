<?php

namespace Sprint\Migration;


class Version20240628142240 extends Version
{
    protected $description = "111796 | Сайт / Изменения баннера | ИБ Слайдеры, свойство";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $iblockId = $helper->Iblock()->getIblockIdIfExists('sliders_all', 'sliders');
        $helper->Iblock()->saveProperty($iblockId, array (
  'NAME' => 'Лейбл',
  'ACTIVE' => 'Y',
  'SORT' => '500',
  'CODE' => 'LABEL',
  'DEFAULT_VALUE' => '',
  'PROPERTY_TYPE' => 'S',
  'ROW_COUNT' => '1',
  'COL_COUNT' => '30',
  'LIST_TYPE' => 'L',
  'MULTIPLE' => 'N',
  'XML_ID' => '',
  'FILE_TYPE' => '',
  'MULTIPLE_CNT' => '5',
  'LINK_IBLOCK_ID' => '0',
  'WITH_DESCRIPTION' => 'N',
  'SEARCHABLE' => 'N',
  'FILTRABLE' => 'N',
  'IS_REQUIRED' => 'N',
  'VERSION' => '1',
  'USER_TYPE' => NULL,
  'USER_TYPE_SETTINGS' => 'a:0:{}',
  'HINT' => '',
));
    
    }

    public function down()
    {
        //your code ...
    }
}
