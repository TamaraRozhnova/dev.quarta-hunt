<?php

namespace Sprint\Migration;


class Version20250214145735 extends Version
{
    protected $description = "118927 | Оформление заказа / Новое свойство ИБ Привязки городов к складу";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $iblockId = $helper->Iblock()->getIblockIdIfExists('linkCityToStore', 'quarta_delivery_settings');
        $helper->Iblock()->saveProperty($iblockId, array (
  'NAME' => 'Способы доставки',
  'ACTIVE' => 'Y',
  'SORT' => '600',
  'CODE' => 'DELIVERY_LIST',
  'DEFAULT_VALUE' => '',
  'PROPERTY_TYPE' => 'S',
  'ROW_COUNT' => '1',
  'COL_COUNT' => '30',
  'LIST_TYPE' => 'L',
  'MULTIPLE' => 'Y',
  'XML_ID' => '',
  'FILE_TYPE' => '',
  'MULTIPLE_CNT' => '5',
  'LINK_IBLOCK_ID' => '0',
  'WITH_DESCRIPTION' => 'N',
  'SEARCHABLE' => 'N',
  'FILTRABLE' => 'N',
  'IS_REQUIRED' => 'N',
  'VERSION' => '2',
  'USER_TYPE' => 'EMBXDeliveries',
  'USER_TYPE_SETTINGS' => 
  array (
    'size' => 1,
    'width' => 0,
    'multiple' => 'N',
  ),
  'HINT' => '',
));
    
    }

    public function down()
    {
        //your code ...
    }
}
