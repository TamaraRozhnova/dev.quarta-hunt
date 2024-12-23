<?php
$arUrlRewrite=array (
  27 => 
  array (
    'CONDITION' => '#^={$params["SEF_URL_TEMPLATES"]["smart_filter"]}\\??(.*)#',
    'RULE' => '&$1',
    'ID' => 'bitrix:catalog.smart.filter',
    'PATH' => '/local/templates/quarta_new/components/bitrix/catalog/main/include/catalog_smart_filter.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/video([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobileapp/jn.php',
    'SORT' => 100,
  ),
  31 => 
  array (
    'CONDITION' => '#^/test_shop/personal/order/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/test_shop/personal/order/index.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  19 => 
  array (
    'CONDITION' => '#^/brendy/([0-9]+)/?.*#',
    'RULE' => 'BRAND_ID=$1',
    'ID' => 'bitrix:catalog',
    'PATH' => '/brendy/brand/index.php',
    'SORT' => 100,
  ),
  32 => 
  array (
    'CONDITION' => '#^/test_shop/personal/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.section',
    'PATH' => '/test_shop/personal/index.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  34 => 
  array (
    'CONDITION' => '#^/test_shop/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/test_shop/catalog/index.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  33 => 
  array (
    'CONDITION' => '#^/test_shop/store/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.store',
    'PATH' => '/test_shop/store/index.php',
    'SORT' => 100,
  ),
  29 => 
  array (
    'CONDITION' => '#^/test_shop/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/test_shop/news/index.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/cabinet/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.section',
    'PATH' => '/cabinet/index.php',
    'SORT' => 100,
  ),
  18 => 
  array (
    'CONDITION' => '#^/brendy/$#',
    'RULE' => '',
    'ID' => 'custom:brands.index',
    'PATH' => '/brendy/index.php',
    'SORT' => 100,
  ),
  28 => 
  array (
    'CONDITION' => '#^/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/store/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.store',
    'PATH' => '/store/index.php',
    'SORT' => 100,
  ),
  13 => 
  array (
    'CONDITION' => '#^/promo/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/promo/index.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/jobs/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/jobs/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
  14 => 
  array (
    'CONDITION' => '#^/blog/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/blog/index.php',
    'SORT' => 100,
  ),
);
