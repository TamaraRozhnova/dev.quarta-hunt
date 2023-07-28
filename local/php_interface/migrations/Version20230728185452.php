<?php

namespace Sprint\Migration;


class Version20230728185452 extends Version
{
    protected $description = "98435 | ИБ Рекламный блок Слайдеры, разделы";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $iblockId = $helper->Iblock()->getIblockIdIfExists(
            'marketing-block-slider',
            'content'
        );

        $helper->Iblock()->addSectionsFromTree(
            $iblockId,
            array (
  0 => 
  array (
    'NAME' => 'Оружия Primos',
    'CODE' => 'oruzhiya-primos',
    'SORT' => '500',
    'ACTIVE' => 'Y',
    'XML_ID' => '',
    'DESCRIPTION' => '',
    'DESCRIPTION_TYPE' => 'text',
    'UF_SECTION_CATALOG' => '813',
  ),
)        );
    }

    public function down()
    {
        //your code ...
    }
}
