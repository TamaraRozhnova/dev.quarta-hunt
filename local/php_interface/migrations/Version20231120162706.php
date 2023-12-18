<?php

namespace Sprint\Migration;


class Version20231120162706 extends Version
{
    protected $description = "102721 | Каталог / Добавить новые типы сортировок товаров | Свойство Рейтинг для каталога";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $iblockId = $helper->Iblock()->getIblockIdIfExists('catalog1c_main', '1c_catalog');
        $helper->Iblock()->saveProperty($iblockId, array (
  'NAME' => 'Рейтинг',
  'ACTIVE' => 'Y',
  'SORT' => '500',
  'CODE' => 'RATING',
  'DEFAULT_VALUE' => '',
  'PROPERTY_TYPE' => 'N',
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
  'USER_TYPE_SETTINGS' => NULL,
  'HINT' => '',
));
    
    }

    public function down()
    {
        //your code ...
    }
}
