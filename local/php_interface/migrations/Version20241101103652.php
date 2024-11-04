<?php

namespace Sprint\Migration;


class Version20241101103652 extends Version
{
    protected $description = "#43704 | Настройка отображения акций для физических и юридических лиц на сайте. / Свойство ИБ новостей";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $iblockId = $helper->Iblock()->getIblockIdIfExists('news-code', 'news');
        $helper->Iblock()->saveProperty($iblockId, array (
          'NAME' => 'Скрыть у физ. лиц',
          'ACTIVE' => 'Y',
          'SORT' => '500',
          'CODE' => 'HIDE_ON_PRIVATE_PERSON',
          'DEFAULT_VALUE' => '',
          'PROPERTY_TYPE' => 'L',
          'ROW_COUNT' => '1',
          'COL_COUNT' => '30',
          'LIST_TYPE' => 'C',
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
          'VALUES' => 
          array (
            0 => 
            array (
              'VALUE' => 'Y',
              'DEF' => 'N',
              'SORT' => '500',
              'XML_ID' => 'Y',
            ),
          ),
        ));

        $helper->Iblock()->saveProperty($iblockId, array (
          'NAME' => 'Скрыть у гостей сайта',
          'ACTIVE' => 'Y',
          'SORT' => '500',
          'CODE' => 'HIDE_ON_GUEST',
          'DEFAULT_VALUE' => '',
          'PROPERTY_TYPE' => 'L',
          'ROW_COUNT' => '1',
          'COL_COUNT' => '30',
          'LIST_TYPE' => 'C',
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
          'VALUES' => 
          array (
            0 => 
            array (
              'VALUE' => 'Y',
              'DEF' => 'N',
              'SORT' => '500',
              'XML_ID' => 'Y',
            ),
          ),
        ));
    
    }

    public function down()
    {
        //your code ...
    }
}
