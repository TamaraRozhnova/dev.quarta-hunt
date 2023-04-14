<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}

?>

<div class="bg-white">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>
                    <svg class="me-3" width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1742_101)">
                            <path d="M0.450188 58.28V58.43C0.655597 59.3643 1.49384 60.0223 2.45019 60H57.5802C58.2318 59.9997 58.8424 59.682 59.2167 59.1486C59.5909 58.6151 59.6817 57.9328 59.4602 57.32L55.9202 47.39C55.9078 47.3484 55.8911 47.3081 55.8702 47.27L50.1802 31.33C49.8972 30.5342 49.1448 30.0019 48.3002 30H44.3002C46.0771 25.9488 46.9964 21.5738 47.0002 17.15C47.0002 7.76118 39.389 0.150024 30.0002 0.150024C20.6113 0.150024 13.0002 7.76118 13.0002 17.15C13.0143 21.5747 13.9403 25.9491 15.7202 30H11.7202C10.8719 29.9977 10.1144 30.5307 9.83019 31.33L2.52019 51.78C2.51453 51.8232 2.51453 51.8669 2.52019 51.91L0.540188 57.31C0.444881 57.593 0.414129 57.8936 0.450188 58.19V58.28ZM6.00019 48.08L8.28019 49.08L5.14019 50.41L6.00019 48.08ZM4.20019 53L11.2002 50C11.5689 49.8429 11.8083 49.4808 11.8083 49.08C11.8083 48.6792 11.5689 48.3171 11.2002 48.16L6.67019 46.16L7.58019 43.63L16.3202 47.41C16.4476 47.4605 16.5831 47.4876 16.7202 47.49C16.8573 47.4885 16.993 47.4614 17.1202 47.41L25.6802 43.71C26.5502 44.52 27.3202 45.16 27.9402 45.65L25.1802 46.84C24.8114 46.9971 24.5721 47.3592 24.5721 47.76C24.5721 48.1608 24.8114 48.5229 25.1802 48.68L46.6802 58H39.9202L20.0602 49.42C19.8051 49.3087 19.5152 49.3087 19.2602 49.42L3.00019 56.46L4.20019 53ZM10.7102 34.82L21.7102 39.57C22.5302 40.57 23.3502 41.45 24.1302 42.24L16.7202 45.44L8.22019 41.77L10.7102 34.82ZM39.8502 37.62L48.9102 33.71L49.8102 36.24L45.8102 37.95C45.4414 38.1071 45.2021 38.4692 45.2021 38.87C45.2021 39.2708 45.4414 39.6329 45.8102 39.79L52.0002 42.45L53.2402 45.9L40.7502 40.5C40.4951 40.3887 40.2052 40.3887 39.9502 40.5L35.8802 42.25C37.3132 40.8007 38.64 39.25 39.8502 37.61V37.62ZM51.1102 39.88L48.7602 38.88L50.4802 38.14L51.1102 39.88ZM34.8802 58H4.46019L19.6602 51.43L34.8802 58ZM51.7202 58L28.0802 47.79L29.9302 46.99H30.0002C30.1996 46.9905 30.3946 46.9313 30.5602 46.82L30.9502 46.54L40.3502 42.54L54.1902 48.54L57.5802 58H51.7202ZM47.8102 32L41.9302 34.54C42.4402 33.7 42.9302 32.85 43.3302 32H47.8102ZM16.3302 10.93C19.2429 4.48171 26.2657 0.945755 33.1805 2.44593C40.0953 3.94611 45.0215 10.0744 45.0002 17.15C45.0002 26.54 39.8402 37.42 30.0002 44.77C28.7975 43.8611 27.6489 42.8828 26.5602 41.84C19.6402 35.25 15.0002 26.63 15.0002 17.15C14.9938 15.0055 15.4473 12.8844 16.3302 10.93ZM16.6602 32C17.4043 33.502 18.26 34.9461 19.2202 36.32L11.3802 32.92L11.7102 32H16.6602Z" fill="#004989"/>
                            <path d="M22.86 24.39C22.9396 24.794 23.1464 25.1619 23.45 25.44C22.7111 26.631 22.8954 28.1749 23.8938 29.1586C24.8922 30.1422 26.4387 30.3035 27.6185 29.547C28.7984 28.7905 29.2972 27.3178 28.82 26H33.18C32.7707 27.128 33.073 28.3914 33.9485 29.2121C34.824 30.0327 36.1043 30.2527 37.2035 29.7713C38.3027 29.29 39.0093 28.2 39 27C38.9964 26.6376 38.9287 26.2788 38.8 25.94C40.0814 25.6715 41.0407 24.6029 41.17 23.3L41.88 16.2C41.9379 15.6391 41.7563 15.0799 41.38 14.66C40.9995 14.2385 40.4578 13.9985 39.89 14H22.82L22.54 12.61C22.3513 11.6598 21.5086 10.9814 20.54 11H18C17.4477 11 17 11.4477 17 12C17 12.5523 17.4477 13 18 13H20.58L22.86 24.39ZM27 27C27 27.5523 26.5523 28 26 28C25.4477 28 25 27.5523 25 27C25 26.4477 25.4477 26 26 26C26.5523 26 27 26.4477 27 27ZM36 28C35.4477 28 35 27.5523 35 27C35 26.4477 35.4477 26 36 26C36.5523 26 37 26.4477 37 27C37 27.5523 36.5523 28 36 28ZM39.89 16L39.18 23.1C39.1285 23.6129 38.6955 24.0026 38.18 24H24.82L23.22 16H39.89Z" fill="#004989"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_1742_101">
                                <rect width="60" height="60" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/third_section/title.php",
                        ],
                        false
                    ); ?>
                </h2>
            </div>
            <div class="col-12 mt-5">
                <div class="select__wrapper">
                    <div class="select select--shop" data-initial-id="<?= $arResult['ITEMS'][0]['ID'] ?>">
                        <button class="select__main btn">
                            <?= $arResult['ITEMS'][0]['ID'] ?>
                            <div class="select__options">
                                <? foreach ($arResult['ITEMS'] as $item) { ?>
                                    <div class="select__option" data-id="<?= $item['ID'] ?>" tabindex="0">
                                        <span><?= $item['NAME'] ?></span>
                                    </div>
                                <? } ?>
                            </div>
                        </button>
                    </div>
                </div>

                <div id="yandex-map" class="yandex-map mt-5">
                    <div id="shop-map"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const shops = <?= CUtil::PhpToJSObject($arResult['ITEMS']) ?>;
</script>