<?php

use Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

</main>

<footer class="footer">
    <div class="container mb-5">
        <div class="row">
            <div class="col-12 col-xl-3">
                <a href="/">
                    <svg width="249" height="29" fill="none" xmlns="http://www.w3.org/2000/svg" class="footer__logo">
                        <path d="M25.36 15.226c0-6.923-5.688-12.555-12.68-12.555C5.686 2.67 0 8.305 0 15.226c0 6.92 5.689 12.554 12.681 12.554 1.205 0 2.396-.166 3.543-.497l1.396-.402-2.796-3.624-.601.11a8.452 8.452 0 01-1.542.14c-4.614 0-8.367-3.716-8.367-8.283 0-4.568 3.753-8.284 8.367-8.284 4.614 0 8.368 3.716 8.368 8.284a8.257 8.257 0 01-1.93 5.285h-4.684l5.724 7.149.025.004.095.117h5.755l-3.616-4.515a12.477 12.477 0 002.943-8.038zM161.624 2.56c-1.387 0-2.535.463-3.444 1.39-.909.909-1.364 2.036-1.364 3.382 0 1.329.455 2.457 1.364 3.383.909.927 2.057 1.39 3.444 1.39 1.376 0 2.521-.463 3.43-1.39.919-.936 1.377-2.064 1.377-3.383 0-1.328-.46-2.456-1.377-3.383-.909-.926-2.054-1.39-3.43-1.39zm2.04 6.924c-.548.569-1.228.852-2.04.852-.822 0-1.507-.283-2.054-.852-.539-.559-.808-1.277-.808-2.15s.269-1.59.808-2.15c.547-.568 1.232-.852 2.054-.852.812 0 1.492.284 2.04.852.547.569.822 1.285.822 2.15 0 .864-.275 1.582-.822 2.15zm10.899-5.967c-.574-.515-1.36-.774-2.357-.774h-4.053v9.18h1.906V8.29h2.147c.997 0 1.783-.259 2.357-.774.582-.507.874-1.175.874-2.006.002-.822-.29-1.486-.874-1.993zm-1.418 2.864c-.255.197-.613.295-1.073.295h-2.013v-2.28h2.013c.459 0 .816.097 1.073.294.256.198.385.479.385.847 0 .367-.127.649-.385.844zm5.657 3.785c-.23.174-.54.262-.929.262-.415 0-.773-.082-1.073-.249v1.666c.3.174.768.262 1.404.262 1.255 0 2.226-.726 2.914-2.177l3.417-7.187h-2.026l-2.054 4.51-2.346-4.51h-2.102l3.51 6.414c-.255.505-.495.842-.715 1.009zm5.656 1.757h2.477l3.312-4.053v4.053h1.907V7.87l3.312 4.053h2.491l-3.935-4.761 3.537-4.419h-2.344l-3.061 3.868V2.743h-1.907v3.868L187.2 2.743h-2.344l3.523 4.419-3.921 4.761zm21.551-1.693h-5.047V7.87h3.949V6.205h-3.949V4.434h4.902v-1.69h-6.809v9.18h6.954V10.23zm5.537-7.986c.706 0 1.284-.203 1.735-.611.45-.406.68-.951.688-1.633h-1.404c-.01.29-.106.52-.292.695-.186.174-.433.262-.742.262-.31 0-.555-.088-.735-.262-.182-.174-.271-.406-.271-.695h-1.404c.01.682.238 1.225.689 1.633.45.408 1.028.61 1.736.61zm2.131 3.658v6.021h1.895v-9.18h-1.642l-4.492 5.979V2.743h-1.907v9.18h1.603l4.543-6.021zm10.041.276h-4.186V2.743h-1.907v9.18h1.907V7.897h4.186v4.026h1.893v-9.18h-1.893v3.435zm10.202.459c-.644-.576-1.518-.865-2.622-.865h-1.723V2.743h-1.907v9.18h3.63c1.094 0 1.968-.283 2.622-.852.644-.559.967-1.298.967-2.217s-.323-1.658-.967-2.217zm-1.424 3.245c-.313.249-.748.373-1.305.373h-1.616V7.372h1.616c.557 0 .99.127 1.305.381.314.255.47.613.47 1.076 0 .454-.156.804-.47 1.053zm5.41-7.139h-1.907v9.18h1.907v-9.18zm8.452 0l-4.49 5.979V2.743h-1.907v9.18h1.603l4.542-6.021v6.021h1.895v-9.18h-1.643zm-2.386-.499c.706 0 1.284-.203 1.735-.611.45-.406.68-.951.688-1.633h-1.404c-.01.29-.106.52-.292.695-.185.174-.433.262-.742.262-.31 0-.555-.088-.735-.262-.182-.174-.271-.406-.271-.695h-1.404c.01.682.238 1.225.689 1.633.452.408 1.03.61 1.736.61zm-79.184 15.333h-2.33l-3.419 3.618v-3.618h-1.907v9.18h1.907V22.52l3.987 4.237h2.439l-4.61-4.972 3.933-4.208zm7.696 4.116c.335-.14.613-.368.836-.682.22-.314.33-.695.33-1.14 0-.726-.253-1.291-.762-1.693-.508-.402-1.189-.603-2.046-.603h-4.358v9.18h4.662c.988 0 1.771-.24 2.344-.722.582-.48.874-1.11.874-1.888 0-.664-.186-1.21-.557-1.639-.377-.436-.82-.708-1.323-.813zm-4.094-2.543h2.147c.398 0 .71.09.934.268.224.18.338.431.338.755 0 .316-.112.559-.338.735-.224.174-.536.262-.934.262h-2.147v-2.02zm3.512 5.671c-.265.205-.636.308-1.112.308h-2.398v-2.4h2.398c.478 0 .847.105 1.112.314.265.21.398.507.398.892-.001.386-.133.681-.398.886zm7.232-7.298l-3.974 9.231h2l.914-2.125h3.922l.915 2.125h2.026l-3.974-9.231h-1.829zm-.464 5.548l1.365-3.188 1.352 3.188h-2.717zm13.907-4.721c-.574-.515-1.359-.773-2.357-.773h-4.053v9.18h1.907v-3.632h2.146c.998 0 1.783-.259 2.357-.773.583-.508.874-1.176.874-2.007 0-.823-.29-1.487-.874-1.995zm-1.417 2.864c-.255.198-.613.295-1.073.295h-2.013v-2.282h2.013c.458 0 .816.098 1.073.295.255.197.385.479.385.846 0 .368-.128.651-.385.846zm10.889-3.637h-7.776v1.69h2.928v7.49h1.907v-7.49h2.941v-1.69zm3.257-.054l-3.974 9.231h1.999l.915-2.125h3.922l.914 2.125h2.027l-3.974-9.232h-1.829zm-.464 5.547l1.365-3.187 1.352 3.188h-2.717zm8.558-2.805c-.027 1.845-.128 3.113-.304 3.804-.176.674-.512 1.009-1.007 1.009a1.96 1.96 0 01-.675-.106v1.704c.185.079.446.119.781.119 1.094 0 1.858-.406 2.291-1.22.424-.804.671-2.285.743-4.445l.052-1.863h2.808v7.488h1.895v-9.178h-6.544l-.04 2.688zM46.36 17.82c0 1.857-.493 3.285-1.477 4.282-.984.998-2.31 1.497-3.98 1.497-1.645 0-2.96-.5-3.944-1.497-.985-.997-1.478-2.425-1.478-4.282V3.68h-4.97v13.968c0 3.348.973 5.951 2.919 7.809 1.945 1.857 4.436 2.787 7.47 2.787 3.057 0 5.56-.928 7.504-2.787 1.969-1.858 2.953-4.461 2.953-7.81V3.68h-5.004v14.14h.008zM64.672 3.542l-10.425 24.22h5.246l2.398-5.574h10.285l2.398 5.573h5.316L69.465 3.541h-4.793zm-1.217 14.553l3.58-8.36 3.544 8.36h-7.124zm37.965-3.115c.891-1.181 1.338-2.575 1.338-4.179 0-2.11-.752-3.82-2.259-5.125-1.483-1.33-3.52-1.995-6.116-1.995H83.125v24.08h5.004v-9.735h4.204l7.088 9.735h5.803l-7.505-10.286c1.574-.48 2.808-1.314 3.701-2.495zm-4.657-1.874c-.638.505-1.523.756-2.658.756h-5.978V8.014h5.978c1.135 0 2.02.258 2.658.773.637.517.956 1.233.956 2.15 0 .942-.32 1.665-.956 2.169zM126.21 3.68h-20.397v4.437h7.679v19.645h5.005V8.117h7.713V3.68zm8.547-.138l-10.425 24.22h5.247l2.397-5.574h10.286l2.4 5.573h5.315l-10.424-24.22h-4.796zm-1.216 14.553l3.579-8.36 3.545 8.36h-7.124z" fill="currentColor"></path>
                    </svg>
                </a>
                <ul class="footer__free-call">
                    <li>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/footer/description_phone.php",
                            ],
                            false,
                        );?>
                    </li>
                    <li>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/footer/main_phone.php",
                            ],
                            false,
                        );?>
                    </li>
                </ul>
            </div>

            <div class="col-12 col-lg-3">
                <div class="footer-collapse">
                    <div class="footer-collapse-header">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/footer/first_toggle/title.php",
                            ],
                            false,
                        );?>
                    </div>

                    <div class="footer-collapse__content">
                        <div class="row">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/footer/first_toggle/content.php",
                                ],
                                false,
                            );?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12 col-lg-3">
                <div class="footer-collapse">
                    <div class="footer-collapse-header">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/footer/second_toggle/title.php",
                            ],
                            false,
                        );?>
                    </div>

                    <div class="footer-collapse__content">
                        <div class="row">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/footer/second_toggle/content.php",
                                ],
                                false,
                            );?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-auto">

                <div class="footer__nav">
                    <div class="footer-collapse">
                        <div class="footer-collapse-header">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/footer/third_toggle/title.php",
                                ],
                                false,
                            );?>
                        </div>

                        <div class="footer-collapse__content">
                            <?$APPLICATION->IncludeComponent("bitrix:menu",
                                "menu_vertical_footer",
                                array(
                                    "ROOT_MENU_TYPE" => "company_footer",
                                    "MENU_CACHE_TYPE" => "A",
                                    "MENU_CACHE_TIME" => "36000000",
                                    "MENU_CACHE_USE_GROUPS" => "N",
                                    "MAX_LEVEL" => "1",
                                    "USE_EXT" => "Y",
                                    "DELAY" => "N",
                                    "ALLOW_MULTI_SELECT" => "N",
                                )
                            );?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-auto">
                <div class="footer__nav">
                    <div class="footer-collapse">
                        <div class="footer-collapse-header">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/footer/fourth_toggle/title.php",
                                ],
                                false,
                            );?>
                        </div>

                        <div class="footer-collapse__content">
                            <?$APPLICATION->IncludeComponent("bitrix:menu",
                                "menu_vertical_footer",
                                array(
                                    "ROOT_MENU_TYPE" => "info_footer",
                                    "MENU_CACHE_TYPE" => "A",
                                    "MENU_CACHE_TIME" => "36000000",
                                    "MENU_CACHE_USE_GROUPS" => "N",
                                    "MAX_LEVEL" => "1",
                                    "USE_EXT" => "Y",
                                    "DELAY" => "N",
                                    "ALLOW_MULTI_SELECT" => "N",
                                )
                            );?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="d-none d-lg-block"/>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-4 footer__payment-methods">
                Принимаем к оплате
                <figure>
                    <img width="342"
                         src="<?= SITE_TEMPLATE_PATH ?>/assets/images/payment-methods.png"
                         srcset="<?= SITE_TEMPLATE_PATH ?>/assets/images/payment-methods@2x.png 1.5x"
                         alt="Visa, Yandex Money, MasterCard, Qiwi"
                    />
                </figure>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 footer__social">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    [
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/footer/socials.php",
                    ],
                    false,
                );?>
            </div>

        </div>
    </div>

    <?$APPLICATION->IncludeComponent(
        "custom:arrow.up",
        "",
        []
    );?>

    <?php 
    
        if ($APPLICATION->get_cookie('COOKIE_APPLY') != 'Y') {

            $APPLICATION->IncludeComponent(
                "custom:form.cookies",
                "",
                []
            );

        }
    
    ?>

    <?php 
    
        if (IsModuleInstalled('promo2page')) {
            if ($APPLICATION->get_cookie('COOKIE_APPLY') == 'Y') {
                $APPLICATION->IncludeComponent(
                    "custom:promo.page",
                    "",
                    []
                );
            }
        }
        
    ?>

</footer>

    </div>

    <?php 
    /**
     * Виджет Б24
     * 
     * Второй вызов скрипта решает проблему мультидоменности
     */
    ?>
    <script>
        (function(w,d,u){
                var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://crm.quarta-hunt.ru/upload/crm/site_button/loader_2_uee9eu.js');
    </script>

    <script>
        window.addEventListener('onBitrixLiveChat', function(event){
            var widget = event.detail.widget;
            widget.setOption('checkSameDomain', false);
        });
    </script>

    </body>
</html>