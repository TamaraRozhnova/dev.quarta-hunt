<?php
/*
 * пример реализуемого редиректа
https://quarta-hunt.ru/catalog/25351/patronnaya_lenta_patroller_dlya_50_sht_gladkostvolnykh_patronov/ ->
https://quarta-hunt.ru/catalog/products/patronnaya_lenta_patroller_dlya_50_sht_gladkostvolnykh_patronov/
*/

preg_match('/^\/catalog\/(\d+)\/(.*)\//', $_SERVER['REQUEST_URI'], $output_array);

if(!empty($output_array[2])){

    LocalRedirect("/catalog/products/". $output_array[2]."/");
}
