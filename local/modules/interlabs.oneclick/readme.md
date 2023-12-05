# Модуль покупка в один клик

# Установка
 * поместить в папку local/modules/interlabs.oneclick
 * или поместить в папку .last_version и её в архив .last_version.zip

# Пример
# Пример
```

 <?php
$APPLICATION->IncludeComponent(
   "interlabs:oneclick",
   ".default", //.default | .popup
   Array(
      "ID" => $itemIds['ID'],//#ELEMENT_ID#
      "USE_FIELD_COMMENT" => 'Y',
      "USE_FIELD_EMAIL" => 'Y',
      "BUY_STRATEGY" => 'OnlyProduct' // ProductAndBasket|OnlyProduct|OnlyBasket
   ),
   false
   );
?>

```