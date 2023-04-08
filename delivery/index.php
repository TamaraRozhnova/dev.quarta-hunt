<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle('Доставка');

?>

<div class="delivery">
    <div class="jumbotron-vue"
         style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/static/delivery.jpg');">
        <div class="container">
            <div class="jumbotron-vue__body">
                <div class="jumbotron-vue__q">
                    <svg width="562" height="542" viewBox="0 0 562 542" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g filter="url(#filter0_b_164:3)">
                            <path d="M547.473 271C547.473 121.574 424.662 0 273.716 0C122.769 0 0 121.615 0 271C0 420.385 122.811 542 273.757 542C299.764 542 325.478 538.405 350.233 531.256L380.372 522.578L320.01 444.352L307.027 446.749C296.132 448.774 284.945 449.766 273.757 449.766C174.156 449.766 93.131 369.557 93.131 270.959C93.131 172.361 174.156 92.1516 273.757 92.1516C373.359 92.1516 454.384 172.361 454.384 270.959C454.384 312.737 439.398 353.151 412.723 385.053H311.619L435.182 539.355L435.724 539.438L437.77 541.959H562L483.939 444.518C524.681 396.169 547.473 334.845 547.473 271Z"
                                  fill="#004989" fill-opacity="0.28"></path>
                        </g>
                        <defs>
                            <filter id="filter0_b_164:3" x="-4" y="-4" width="570" height="550"
                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                <feGaussianBlur in="BackgroundImage" stdDeviation="2"></feGaussianBlur>
                                <feComposite in2="SourceAlpha" operator="in"
                                             result="effect1_backgroundBlur_164:3"></feComposite>
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur_164:3"
                                         result="shape"></feBlend>
                            </filter>
                        </defs>
                    </svg>
                </div>
                <h1>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/title.php",
                        ],
                        false
                    ); ?>
                </h1>
            </div>
        </div>
    </div>
    <div class="bg-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h2>
                        <svg class="me-3" width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M51.3126 40.6989C51.2514 38.3925 50.4571 36.1656 49.0449 34.341C47.6327 32.5165 45.6761 31.1893 43.4587 30.5517L42.8338 30.3717L41.8573 28.3989C41.7992 28.2814 41.7094 28.1825 41.5981 28.1133C41.4867 28.0442 41.3583 28.0075 41.2273 28.0075H35.5085V25.5817C37.3835 24.0582 38.6992 21.7571 38.8491 19.1598C39.4605 18.8999 39.9612 18.4335 40.2637 17.842C40.5663 17.2505 40.6515 16.5716 40.5044 15.9237C40.4262 15.5688 40.2605 15.239 40.0224 14.9644C39.7844 14.6897 39.4815 14.4789 39.1413 14.351V11.5158L39.2207 11.3457C39.3856 11.1425 39.5071 10.9075 39.5775 10.6553C39.6478 10.4032 39.6657 10.1393 39.6299 9.87995C39.5063 8.98017 39.2689 8.09973 38.9235 7.25976C37.4478 3.66691 33.9463 1.34531 30.0046 1.34531C26.0628 1.34531 22.5616 3.6689 21.084 7.26527C20.738 8.1081 20.5005 8.99145 20.3771 9.89413C20.3389 10.1587 20.3568 10.4284 20.4296 10.6857C20.5024 10.9429 20.6284 11.182 20.7996 11.3873L20.8601 11.5267V14.3485C20.5192 14.4764 20.2158 14.6875 19.9773 14.9625C19.7388 15.2376 19.5729 15.5679 19.4946 15.9234C19.3437 16.5722 19.4276 17.2535 19.7314 17.8463C20.0351 18.4392 20.5391 18.9052 21.1539 19.1617C21.3041 21.7563 22.6179 24.0543 24.4929 25.578V28.0075H18.7741C18.6431 28.0075 18.5146 28.0441 18.4033 28.1133C18.2919 28.1825 18.2021 28.2814 18.144 28.3989L17.1687 30.37L16.543 30.5498C14.3261 31.1864 12.3696 32.5127 10.9574 34.3363C9.54513 36.1599 8.75059 38.386 8.68898 40.6917C8.68898 40.6963 8.68898 40.701 8.68898 40.7055L8.58023 56.1743C8.57299 56.8388 8.82955 57.4791 9.29367 57.9548C9.52046 58.19 9.79164 58.3779 10.0915 58.5076C10.3914 58.6374 10.714 58.7063 11.0407 58.7106H48.9607C49.2873 58.7063 49.6099 58.6373 49.9097 58.5076C50.2095 58.3778 50.4806 58.19 50.7074 57.9548C50.9366 57.7277 51.1179 57.4569 51.2406 57.1584C51.3633 56.8599 51.4249 56.5399 51.4216 56.2172L51.3129 40.7197C51.3129 40.7151 51.3128 40.7034 51.3126 40.6989ZM49.9866 52.0834C49.4529 51.708 48.8269 51.4854 48.1761 51.4396L44.8835 51.1997V48.3981H49.9607L49.9866 52.0834ZM40.7906 29.4137L43.0523 33.984H30.7038V29.4137H40.7906ZM33.3991 35.3903V38.5543H26.9538V35.3903H33.3991ZM25.8991 28.0075V26.4957C27.168 27.1522 28.5748 27.4977 30.0035 27.5035C31.4317 27.5116 32.8398 27.1663 34.1023 26.4983V28.0075H25.8991ZM21.7701 10.0843C21.8772 9.29968 22.0835 8.53182 22.3841 7.79917C23.6441 4.73285 26.6348 2.75144 30.0033 2.75144C33.3717 2.75144 36.3621 4.73074 37.6205 7.79402C37.9197 8.52387 38.1251 9.28878 38.2317 10.0704C38.2416 10.1426 38.2358 10.2161 38.2147 10.2859C38.1936 10.3557 38.1576 10.4201 38.1092 10.4747C38.0594 10.5315 37.9978 10.577 37.9288 10.6078C37.8597 10.6387 37.7848 10.6543 37.7092 10.6535L22.2935 10.6637C22.2179 10.6646 22.143 10.6491 22.0739 10.6183C22.0048 10.5875 21.9432 10.5421 21.8933 10.4853C21.8448 10.4315 21.8086 10.3678 21.7873 10.2985C21.766 10.2292 21.7602 10.1561 21.7701 10.0843V10.0843ZM37.2429 12.0354L36.4084 13.5934H23.593L22.7647 12.034L37.2429 12.0354ZM22.5007 18.6442V18.6318C22.506 18.4688 22.4527 18.3093 22.3506 18.1822C22.2484 18.0552 22.104 17.9689 21.9437 17.9392C21.6269 17.883 21.3403 17.7163 21.1349 17.4686C20.9294 17.221 20.8185 16.9086 20.8218 16.5868C20.8237 16.476 20.839 16.3658 20.8673 16.2587C20.9082 16.0809 21.0051 15.921 21.1438 15.8026C21.2825 15.6842 21.4556 15.6135 21.6376 15.601C21.8113 15.5845 21.9724 15.5033 22.0889 15.3734C22.2054 15.2435 22.2687 15.0746 22.2663 14.9002V14.1982L22.5334 14.6525C22.5975 14.7629 22.6906 14.8536 22.8026 14.9148C22.9146 14.976 23.0412 15.0053 23.1687 14.9996H36.8327C36.9599 15.0054 37.0862 14.976 37.1978 14.9148C37.3094 14.8536 37.402 14.7628 37.4655 14.6525L37.7351 14.1874V14.9007C37.7328 15.0746 37.7959 15.243 37.9118 15.3726C38.0278 15.5022 38.1881 15.5836 38.3612 15.6007C38.5431 15.6137 38.7162 15.6845 38.855 15.8028C38.9939 15.9211 39.0913 16.0807 39.133 16.2582C39.1584 16.3657 39.1707 16.4759 39.1698 16.5864C39.1751 16.9067 39.0663 17.2185 38.8631 17.4661C38.6598 17.7137 38.3751 17.881 38.0599 17.9382C37.8995 17.9681 37.7551 18.0542 37.6526 18.1811C37.55 18.308 37.4962 18.4674 37.5007 18.6305V18.6436C37.5007 22.7532 34.1102 26.0967 30.0013 26.0967C25.8923 26.0967 22.5007 22.7532 22.5007 18.6442ZM10.0407 48.3981H15.1179V51.2177L12.3757 51.4663C11.5077 51.5387 10.6827 51.8754 10.0119 52.431L10.0407 48.3981ZM16.2898 57.3043H11.0407C10.756 57.2946 10.4868 57.1724 10.2921 56.9645C10.1939 56.8676 10.1161 56.752 10.0635 56.6244C10.011 56.4969 9.98459 56.3601 9.98601 56.2221L9.99175 55.4293H10.0233C10.0233 54.0231 11.0662 53.0185 12.5044 52.8869L15.1176 52.6386V54.8751C15.1176 54.9633 15.135 55.0507 15.1688 55.1321C15.2025 55.2136 15.252 55.2876 15.3144 55.35C15.3767 55.4123 15.4508 55.4618 15.5323 55.4955C15.6137 55.5292 15.7011 55.5465 15.7893 55.5465H16.2898V57.3043ZM15.1591 34.4293C15.0793 34.5905 15.0645 34.7762 15.1179 34.948V46.9918H10.0506L10.0946 40.7173C10.1467 38.8233 10.7674 36.9888 11.876 35.4524C12.9847 33.9159 14.53 32.7486 16.311 32.1022L15.1591 34.4293ZM42.3054 57.3043H17.696V55.5465H42.3054V57.3043ZM27.1882 54.1403V50.1108C27.3054 50.2353 27.5358 50.2731 27.7155 50.2731H27.7213C27.8137 50.2762 27.9057 50.2607 27.992 50.2274C28.0782 50.1942 28.1569 50.1439 28.2232 50.0795L28.9491 49.3481L29.6639 50.0897C29.7291 50.1576 29.8074 50.2117 29.8939 50.2487C29.9805 50.2858 30.0736 50.305 30.1678 50.3053C30.262 50.3056 30.3552 50.287 30.442 50.2505C30.5289 50.214 30.6074 50.1604 30.6731 50.093L31.388 49.3562L32.1138 50.0791C32.1803 50.1437 32.2592 50.1942 32.3457 50.2276C32.4322 50.2609 32.5245 50.2764 32.6171 50.2731H32.6229C32.7013 50.2798 32.7803 50.2687 32.8538 50.2406C32.9274 50.2125 32.9936 50.1681 33.0476 50.1108V54.1403H27.1882ZM43.4773 54.1403H34.4538V48.3499C34.4603 48.2116 34.4239 48.0746 34.3497 47.9576C34.2754 47.8407 34.1669 47.7495 34.0389 47.6966C33.9109 47.6436 33.7697 47.6315 33.6345 47.6618C33.4994 47.6921 33.3769 47.7633 33.2837 47.8658L32.6017 48.5917L31.8851 47.8816C31.819 47.8183 31.7408 47.7691 31.6551 47.737C31.5694 47.7049 31.4781 47.6906 31.3867 47.695H31.3848C31.2925 47.6907 31.2004 47.7053 31.1139 47.7379C31.0275 47.7704 30.9486 47.8203 30.8821 47.8843L30.1694 48.6067L29.4568 47.8903C29.3906 47.8254 29.3119 47.7746 29.2255 47.741C29.1391 47.7075 29.0468 47.6918 28.9541 47.695H28.9522C28.8603 47.6906 28.7684 47.7049 28.6822 47.737C28.5959 47.769 28.517 47.8183 28.4503 47.8816L27.7301 48.6037L27.041 47.8718C26.9398 47.769 26.8109 47.698 26.6699 47.6675C26.529 47.6369 26.3822 47.6482 26.2475 47.6999C26.1144 47.7501 25.9991 47.8387 25.9163 47.9544C25.8334 48.0701 25.7867 48.2077 25.7819 48.3499V54.1403H16.5241V35.3903H19.4538C19.6403 35.3903 19.8191 35.3162 19.951 35.1843C20.0829 35.0525 20.1569 34.8736 20.1569 34.6871C20.1569 34.5007 20.0829 34.3218 19.951 34.19C19.8191 34.0581 19.6403 33.984 19.4538 33.984H16.9487L19.2104 29.4137H29.2976V33.984H24.1413C23.9548 33.984 23.776 34.0581 23.6441 34.19C23.5123 34.3218 23.4382 34.5007 23.4382 34.6871C23.4382 34.8736 23.5123 35.0525 23.6441 35.1843C23.776 35.3162 23.9548 35.3903 24.1413 35.3903H25.5476V39.2787C25.554 39.4654 25.6341 39.642 25.7704 39.7698C25.9067 39.8976 26.0881 39.9662 26.2748 39.9606H34.0641C34.4524 39.9606 34.8054 39.6669 34.8054 39.2787V35.3903H43.4773V54.1403ZM47.239 34.3983C48.8918 36.0939 49.8446 38.3503 49.9073 40.7174L49.9508 46.9918H44.8835V34.948C44.9369 34.7763 44.9221 34.5906 44.8423 34.4294L43.6914 32.1041C45.0317 32.5917 46.2444 33.376 47.239 34.3983V34.3983ZM49.7093 56.9645C49.5146 57.1724 49.2454 57.2946 48.9607 57.3043H43.7116V55.5465H44.2121C44.3902 55.5465 44.561 55.4758 44.6869 55.3499C44.8128 55.224 44.8835 55.0532 44.8835 54.8751V52.6106L48.0735 52.845C49.0746 52.9182 49.9009 53.6848 50.0041 54.5953L50.0158 56.1853C50.0188 56.475 49.9088 56.7545 49.7093 56.9645V56.9645Z" fill="#004989"/>
                            <path d="M19.8047 36.8866C19.6182 36.8866 19.4394 36.9606 19.3075 37.0925C19.1756 37.2244 19.1016 37.4032 19.1016 37.5897V38.328C19.1016 38.5145 19.1756 38.6933 19.3075 38.8252C19.4394 38.957 19.6182 39.0311 19.8047 39.0311C19.9912 39.0311 20.17 38.957 20.3019 38.8252C20.4337 38.6933 20.5078 38.5145 20.5078 38.328V37.5897C20.5078 37.4032 20.4337 37.2244 20.3019 37.0925C20.17 36.9606 19.9912 36.8866 19.8047 36.8866Z" fill="#004989"/>
                            <path d="M19.8047 39.8509C19.6182 39.8509 19.4394 39.925 19.3075 40.0568C19.1756 40.1887 19.1016 40.3675 19.1016 40.554V48.2884C19.1016 48.4749 19.1756 48.6537 19.3075 48.7856C19.4394 48.9174 19.6182 48.9915 19.8047 48.9915C19.9912 48.9915 20.17 48.9174 20.3019 48.7856C20.4337 48.6537 20.5078 48.4749 20.5078 48.2884V40.554C20.5078 40.3675 20.4337 40.1887 20.3019 40.0568C20.17 39.925 19.9912 39.8509 19.8047 39.8509Z" fill="#004989"/>
                        </svg>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/delivery/first_section/title.php",
                            ],
                            false
                        ); ?>
                    </h2>
                </div>
                <div class="col-12 col-sm-6">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/first_section/description.php",
                        ],
                        false
                    ); ?>
                </div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/delivery/first_section/first_city/title.php",
                            ],
                            false
                        ); ?>
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/first_section/first_city/text.php",
                        ],
                        false
                    ); ?>
                </div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/delivery/first_section/second_city/title.php",
                            ],
                            false
                        ); ?>
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/first_section/second_city/text.php",
                        ],
                        false
                    ); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-5">
                    <h2>
                        <svg class="me-3" width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M40.6867 37.0852C40.6404 36.8727 40.5118 36.6873 40.3291 36.5694C40.1463 36.4516 39.9243 36.411 39.7117 36.4566L38.2145 36.7796C38.108 36.8011 38.0069 36.8435 37.9169 36.9044C37.827 36.9653 37.7501 37.0435 37.6906 37.1344C37.6311 37.2253 37.5902 37.3271 37.5704 37.4339C37.5506 37.5407 37.5522 37.6504 37.5751 37.7566C37.598 37.8628 37.6418 37.9634 37.7039 38.0525C37.766 38.1417 37.8451 38.2176 37.9368 38.2759C38.0285 38.3341 38.1308 38.3737 38.2379 38.3921C38.3449 38.4105 38.4546 38.4075 38.5605 38.3832L40.0581 38.0602C40.2708 38.0142 40.4564 37.8857 40.5743 37.7029C40.6922 37.52 40.7326 37.2978 40.6867 37.0852Z" fill="#004989"/>
                            <path d="M35.3594 37.3954L31.2087 38.2907C31.1022 38.3122 31.001 38.3547 30.9111 38.4156C30.8211 38.4765 30.7442 38.5547 30.6847 38.6456C30.6252 38.7365 30.5844 38.8383 30.5646 38.9451C30.5447 39.0519 30.5463 39.1616 30.5692 39.2678C30.5921 39.3739 30.6359 39.4745 30.698 39.5637C30.7601 39.6528 30.8393 39.7287 30.9309 39.787C31.0226 39.8453 31.1249 39.8848 31.232 39.9032C31.3391 39.9216 31.4487 39.9186 31.5546 39.8943L35.7054 38.999C35.9156 38.9507 36.0984 38.8216 36.2141 38.6396C36.3298 38.4576 36.3692 38.2373 36.3237 38.0265C36.2782 37.8156 36.1515 37.6312 35.9711 37.5131C35.7906 37.395 35.5709 37.3527 35.3594 37.3954Z" fill="#004989"/>
                            <path d="M22.3789 43.0159C21.3795 43.2312 20.4665 43.738 19.7552 44.4722C19.0438 45.2065 18.5662 46.1352 18.3828 47.1408C18.1993 48.1465 18.3182 49.184 18.7243 50.1221C19.1305 51.0602 19.8058 51.8568 20.6648 52.4111C21.5237 52.9655 22.5277 53.2526 23.5499 53.2363C24.572 53.2199 25.5664 52.9008 26.4072 52.3193C27.248 51.7378 27.8974 50.9201 28.2734 49.9694C28.6494 49.0188 28.7351 47.9781 28.5195 46.9788C28.2293 45.6398 27.4198 44.4705 26.2686 43.7276C25.1174 42.9847 23.7186 42.7288 22.3789 43.0159ZM24.2122 51.5158C23.5301 51.663 22.8198 51.6046 22.1709 51.3481C21.522 51.0915 20.9638 50.6484 20.5668 50.0746C20.1698 49.5008 19.9519 48.8221 19.9406 48.1245C19.9293 47.4268 20.1251 46.7415 20.5033 46.1552C20.8815 45.5688 21.4251 45.1078 22.0654 44.8304C22.7056 44.553 23.4137 44.4716 24.1001 44.5967C24.7866 44.7217 25.4205 45.0475 25.9218 45.5328C26.4231 46.0182 26.7692 46.6412 26.9164 47.3233C27.1124 48.2377 26.9379 49.1926 26.4309 49.9785C25.924 50.7644 25.1261 51.3173 24.2122 51.5158Z" fill="#004989"/>
                            <path d="M57.8424 40.6546L57.1426 37.409C57.1199 37.3036 57.0767 37.2038 57.0154 37.1152C56.9541 37.0266 56.8759 36.9509 56.7854 36.8925C56.6949 36.834 56.5937 36.794 56.4877 36.7747C56.3817 36.7554 56.2729 36.7572 56.1676 36.7799L53.0771 37.4465L47.5501 11.8129C47.504 11.6004 47.3755 11.4149 47.1928 11.297C47.0101 11.1792 46.7881 11.1386 46.5756 11.1843L30.1393 14.728L20.9415 16.7118L17.9377 2.78382C17.8981 2.60053 17.7969 2.43634 17.651 2.31856C17.5051 2.20078 17.3232 2.13652 17.1357 2.13647H2.95508C2.84734 2.13641 2.74064 2.15759 2.64109 2.19879C2.54153 2.23999 2.45108 2.30042 2.37489 2.3766C2.29871 2.45279 2.23829 2.54324 2.19708 2.64279C2.15588 2.74235 2.1347 2.84904 2.13477 2.95679V6.27694C2.13477 6.4945 2.22119 6.70315 2.37503 6.85699C2.52887 7.01083 2.73752 7.09726 2.95508 7.09726H13.793L20.6101 38.7079C18.8241 39.2519 17.2309 40.2953 16.0184 41.7149C14.8058 43.1346 14.0245 44.8713 13.7664 46.7204C13.5083 48.5695 13.7843 50.4538 14.5618 52.1512C15.3394 53.8486 16.586 55.2883 18.1548 56.3005C19.7235 57.3128 21.549 57.8554 23.416 57.8644C25.2829 57.8734 27.1136 57.3484 28.692 56.3513C30.2705 55.3542 31.5309 53.9266 32.3248 52.2368C33.1186 50.547 33.4128 48.6655 33.1726 46.814L57.2134 41.6291C57.426 41.5833 57.6117 41.4549 57.7297 41.2721C57.8477 41.0894 57.8882 40.8672 57.8424 40.6546ZM25.6473 38.5316L22.733 25.0251L31.1293 23.2143L32.3616 28.9223C32.3953 29.0794 32.4745 29.2231 32.5893 29.3355C32.704 29.448 32.8494 29.5241 33.0071 29.5546C33.0585 29.5647 33.1108 29.5697 33.1632 29.5696C33.2974 29.5696 33.4295 29.5367 33.548 29.4737C33.6665 29.4108 33.7677 29.3198 33.8429 29.2087L36.0488 25.9462L39.1393 28.0387C39.2748 28.1304 39.4347 28.1794 39.5983 28.1795C39.7619 28.1797 39.9219 28.1309 40.0575 28.0394C40.1932 27.9479 40.2984 27.818 40.3597 27.6662C40.4209 27.5145 40.4354 27.3479 40.4012 27.1879L39.1702 21.4799L47.5665 19.6691L51.4754 37.7924L31.2596 42.1518C29.8679 40.3279 27.8828 39.0475 25.6473 38.5316ZM36.1196 15.1166L37.3937 21.0229L38.3663 25.5323L36.2888 24.126C36.1086 24.0041 35.8872 23.9588 35.6735 24C35.4599 24.0412 35.2713 24.1656 35.1493 24.3458L33.5612 26.6966L31.2873 16.1587L36.1196 15.1166ZM47.2206 18.0655L38.8243 19.8754L37.7232 14.7707L46.1195 12.9599L47.2206 18.0655ZM29.6837 16.5046L30.7848 21.6098L22.3885 23.4215L21.2874 18.3154L29.6837 16.5046ZM14.4549 5.45663H3.77539V3.7771H16.4734L19.5104 17.8598L23.9166 38.2935C23.3477 38.266 22.7773 38.2884 22.2123 38.3605L15.257 6.10397C15.2174 5.92065 15.1162 5.7564 14.9703 5.63861C14.8244 5.52082 14.6425 5.45659 14.4549 5.45663ZM25.1893 56.039C23.6123 56.38 21.9696 56.2457 20.469 55.6529C18.9684 55.0602 17.6773 54.0358 16.759 52.7091C15.8407 51.3825 15.3365 49.8134 15.3102 48.2001C15.2838 46.5869 15.7365 45.0021 16.611 43.6462C17.4855 42.2904 18.7425 41.2243 20.223 40.5829C21.7034 39.9415 23.3409 39.7536 24.9282 40.043C26.5154 40.3324 27.9812 41.086 29.1401 42.2086C30.299 43.3311 31.0989 44.7722 31.4387 46.3494C31.8917 48.4631 31.488 50.6702 30.316 52.4867C29.144 54.3031 27.2995 55.5806 25.187 56.039H25.1893ZM32.8299 45.2108C32.6627 44.6663 32.448 44.1376 32.1882 43.6307L55.7143 38.5569L56.0687 40.1976L32.8299 45.2108Z" fill="#004989"/>
                        </svg>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/delivery/second_section/title.php",
                            ],
                            false
                        ); ?>
                    </h2>
                </div>
                <div class="col-12 col-sm-6">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/second_section/left_text.php",
                        ],
                        false
                    ); ?>
                </div>
                <div class="col-12 col-sm-6">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/second_section/right_text.php",
                        ],
                        false
                    ); ?>
                </div>
            </div>
        </div>
    </div>

    <? $APPLICATION->IncludeComponent("bitrix:news.list", "delivery_shops", [
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "N",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "N",
        "DISPLAY_PICTURE" => "N",
        "DISPLAY_PREVIEW_TEXT" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => [
            0 => "ID",
            1 => "CODE",
            2 => "NAME",
            3 => "PREVIEW_TEXT",
            4 => "PREVIEW_PICTURE",
            5 => "DETAIL_TEXT",
            6 => "DETAIL_PICTURE",
            7 => "IBLOCK_TYPE_ID",
            8 => "IBLOCK_ID",
            9 => "IBLOCK_CODE",
            10 => "IBLOCK_NAME",
        ],
        "FILTER_NAME" => "",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "30",
        "IBLOCK_TYPE" => "about",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "100",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Новости",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => [
            0 => "DESCRIPTION",
        ],
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "SORT",
        "SORT_BY2" => "",
        "SORT_ORDER1" => "ASC",
        "SORT_ORDER2" => "",
        "STRICT_SECTION_CHECK" => "N",
        "COMPACT" => "N"
    ],
        false
    ); ?>

    <div class="bg-gray-100 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="d-flex mb-5">
                        <h2>
                            <svg class="icon me-4" width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                    "PATH" => "/include/delivery/fourth_section/title.php",
                                ],
                                false
                            ); ?>
                        </h2>
                    </div>

                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/fourth_section/description.php",
                        ],
                        false
                    ); ?>
                </div>
                <div class="col-12 col-sm-6">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/fourth_section/text.php",
                        ],
                        false
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
