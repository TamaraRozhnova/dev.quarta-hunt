<?php

namespace Sprint\Migration;


class Version20230803175639 extends Version
{
    protected $description = "98435 | Каталог | Свойство \"Дополнительная картинка для рекламного блока на главной\"";

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
  'NAME' => 'Дополнительная картинка для рекламного блока',
  'ACTIVE' => 'Y',
  'SORT' => '500',
  'CODE' => 'DOP_IMAGE_MB',
  'DEFAULT_VALUE' => '',
  'PROPERTY_TYPE' => 'F',
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
