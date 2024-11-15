<?php

namespace Sprint\Migration;


class Version20240911194701 extends Version
{
    protected $description = "113933 | Главная страница Меню | категории ИБ каталога";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $iblockId = $helper->Iblock()->getIblockIdIfExists(
            'hutcatalog',
            'hut'
        );

        $helper->Iblock()->addSectionsFromTree(
            $iblockId,
            array (
  0 => 
  array (
    'NAME' => 'Одежда',
    'CODE' => 'odezhda',
    'SORT' => '5',
    'ACTIVE' => 'Y',
    'XML_ID' => '',
    'DESCRIPTION' => '',
    'DESCRIPTION_TYPE' => 'text',
    'CHILDS' => 
    array (
      0 => 
      array (
        'NAME' => 'Куртки',
        'CODE' => 'kurtki',
        'SORT' => '500',
        'ACTIVE' => 'Y',
        'XML_ID' => '',
        'DESCRIPTION' => '',
        'DESCRIPTION_TYPE' => 'text',
        'CHILDS' => 
        array (
          0 => 
          array (
            'NAME' => 'Мембранные куртки',
            'CODE' => 'membrannye-kurtki',
            'SORT' => '500',
            'ACTIVE' => 'Y',
            'XML_ID' => '',
            'DESCRIPTION' => '',
            'DESCRIPTION_TYPE' => 'text',
          ),
        ),
      ),
      1 => 
      array (
        'NAME' => 'Брюки',
        'CODE' => 'bryuki',
        'SORT' => '500',
        'ACTIVE' => 'Y',
        'XML_ID' => '',
        'DESCRIPTION' => '',
        'DESCRIPTION_TYPE' => 'text',
        'CHILDS' => 
        array (
          0 => 
          array (
            'NAME' => 'Мембранные куртки',
            'CODE' => 'membrannye-kurtki',
            'SORT' => '500',
            'ACTIVE' => 'Y',
            'XML_ID' => '',
            'DESCRIPTION' => '',
            'DESCRIPTION_TYPE' => 'text',
          ),
        ),
      ),
      2 => 
      array (
        'NAME' => 'Жилеты',
        'CODE' => 'zhilety',
        'SORT' => '500',
        'ACTIVE' => 'Y',
        'XML_ID' => '',
        'DESCRIPTION' => '',
        'DESCRIPTION_TYPE' => 'text',
      ),
    ),
  ),
  1 => 
  array (
    'NAME' => 'Аксессуары',
    'CODE' => 'aksessuary',
    'SORT' => '10',
    'ACTIVE' => 'Y',
    'XML_ID' => '',
    'DESCRIPTION' => '',
    'DESCRIPTION_TYPE' => 'text',
    'CHILDS' => 
    array (
      0 => 
      array (
        'NAME' => 'Раздел аксессуаров',
        'CODE' => 'razdel-aksessuarov',
        'SORT' => '500',
        'ACTIVE' => 'Y',
        'XML_ID' => '',
        'DESCRIPTION' => '',
        'DESCRIPTION_TYPE' => 'text',
        'CHILDS' => 
        array (
          0 => 
          array (
            'NAME' => 'Раздел аксессуаров 3',
            'CODE' => 'razdel-aksessuarov-3',
            'SORT' => '500',
            'ACTIVE' => 'Y',
            'XML_ID' => '',
            'DESCRIPTION' => '',
            'DESCRIPTION_TYPE' => 'text',
          ),
          1 => 
          array (
            'NAME' => 'Раздел аксессуаров 4',
            'CODE' => 'razdel-aksessuarov-4',
            'SORT' => '500',
            'ACTIVE' => 'Y',
            'XML_ID' => '',
            'DESCRIPTION' => '',
            'DESCRIPTION_TYPE' => 'text',
          ),
        ),
      ),
    ),
  ),
  2 => 
  array (
    'NAME' => 'Сумки',
    'CODE' => 'sumki',
    'SORT' => '15',
    'ACTIVE' => 'Y',
    'XML_ID' => '',
    'DESCRIPTION' => '',
    'DESCRIPTION_TYPE' => 'text',
  ),
  3 => 
  array (
    'NAME' => 'Обувь',
    'CODE' => 'obuv',
    'SORT' => '20',
    'ACTIVE' => 'Y',
    'XML_ID' => '',
    'DESCRIPTION' => '',
    'DESCRIPTION_TYPE' => 'text',
  ),
  4 => 
  array (
    'NAME' => 'Род занятий',
    'CODE' => 'rod-zanyatiy',
    'SORT' => '25',
    'ACTIVE' => 'Y',
    'XML_ID' => '',
    'DESCRIPTION' => '',
    'DESCRIPTION_TYPE' => 'text',
  ),
  5 => 
  array (
    'NAME' => 'Рекомендации',
    'CODE' => 'rekomendatsii',
    'SORT' => '30',
    'ACTIVE' => 'Y',
    'XML_ID' => '',
    'DESCRIPTION' => '',
    'DESCRIPTION_TYPE' => 'text',
  ),
  6 => 
  array (
    'NAME' => 'Весь каталог',
    'CODE' => 'ves-katalog',
    'SORT' => '35',
    'ACTIVE' => 'Y',
    'XML_ID' => '',
    'DESCRIPTION' => '',
    'DESCRIPTION_TYPE' => 'text',
  ),
)        );
    }

    public function down()
    {
        //your code ...
    }
}
