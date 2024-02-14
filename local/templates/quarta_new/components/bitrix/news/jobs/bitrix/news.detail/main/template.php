<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<div class="job">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-5 job__head">
                <div class="job__head-top">
                    <h2><?= $arResult['NAME'] ?></h2>

                    <p class="job__salary">
                        <?= $arResult['PROPERTIES']['SALARY']['VALUE'] ?>
                    </p>
                </div>

                <figure class="job__head-img">
                    <img src="<?= $arResult['DETAIL_PICTURE']['SRC'] ?>" alt=""/>
                </figure>

                <p class="job__head-where">
                    <span>
                        <?= $arResult['PROPERTIES']['CITY']['VALUE'] ?>
                    </span>
                    <span>
                        <svg class="icon ms-sm-4 me-2" width="10" height="14" viewBox="0 0 10 14" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 0C2.23969 0 0 2.01594 0 4.5C0 8.5 5 14 5 14C5 14 10 8.5 10 4.5C10 2.01594 7.76031 0 5 0ZM5 7C4.60444 7 4.21776 6.8827 3.88886 6.66294C3.55996 6.44318 3.30362 6.13082 3.15224 5.76537C3.00087 5.39991 2.96126 4.99778 3.03843 4.60982C3.1156 4.22186 3.30608 3.86549 3.58579 3.58579C3.86549 3.30608 4.22186 3.1156 4.60982 3.03843C4.99778 2.96126 5.39991 3.00087 5.76537 3.15224C6.13082 3.30362 6.44318 3.55996 6.66294 3.88886C6.8827 4.21776 7 4.60444 7 5C6.99942 5.53026 6.78852 6.03863 6.41357 6.41357C6.03863 6.78852 5.53026 6.99942 5 7Z"
                                  fill="#808D9A"/>
                        </svg>
                        <?= $arResult['PROPERTIES']['ADDRESS']['VALUE'] ?>
                        <br class="d-none d-sm-block"/><br class="d-none d-sm-block"/>
                    </span>
                    <span><?= $arResult['PROPERTIES']['DEPARTMENT']['VALUE'] ?></span>
                </p>

                <? if (!empty($arResult['WORK_PROS'])) { ?>
                    <div class="job__work-is">
                        <h4 class="mb-5">Работа в компании Quarta - это</h4>
                        <? foreach ($arResult['WORK_PROS'] as $item) { ?>
                            <div class="job__work-is-item">
                                <h4>
                                    <img src="<?= $item['PICTURE'] ?>" class="icon" alt="<?= $item['NAME'] ?>"/>
                                    <?= $item['NAME'] ?>
                                </h4>
                                <p><?= $item['TEXT'] ?></p>
                            </div>
                        <? } ?>
                    </div>
                <? } ?>
            </div>
            <div class="col-12 col-lg-7 job__body">
                <figure class="job__image">
                    <img src="<?= $arResult['DETAIL_PICTURE']['SRC'] ?>" alt=""/>
                </figure>

                <div class="py-lg-5 pb-3">
                    <?= $arResult['DETAIL_TEXT'] ?>
                </div>

                <div class="job__responsibilities py-3">
                    <h6 class="mb-4">Обязаности:</h6>
                    <div>
                        <?= $arResult['PROPERTIES']['RESPONSIBILITIES']['~VALUE']['TEXT'] ?>
                    </div>
                </div>
                <div class="job__requirements py-3">
                    <h6 class="mb-4">Требования:</h6>
                    <div>
                        <?= $arResult['PROPERTIES']['REQUIREMENTS']['~VALUE']['TEXT'] ?>
                    </div>
                </div>
                <div class="job__conditions py-3">
                    <h6 class="mb-4">Условия:</h6>
                    <div>
                        <?= $arResult['PROPERTIES']['CONDITIONS']['~VALUE']['TEXT'] ?>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-body">
                        <? $APPLICATION->IncludeComponent("bitrix:form.result.new", "resume", [
                                "SEF_MODE" => "N",
                                "WEB_FORM_ID" => $arParams['RESUME_FORM_ID'],
                                "VACANCY_NAME" => $arResult['NAME'],
                                "LIST_URL" => "",
                                "CHAIN_ITEM_TEXT" => "",
                                "CHAIN_ITEM_LINK" => "",
                                "CACHE_TYPE" => "N",
                                "VARIABLE_ALIASES" => [],
                                "AJAX_MODE" => "Y"
                            ]
                        ); ?>
                    </div>
                </div>
                <? if (!empty($arResult['WORK_PROS'])) { ?>
                    <div class="job__work-is job__work-is--lg">
                        <h4 class="mb-5">Работа в компании Quarta - это</h4>
                        <? foreach ($arResult['WORK_PROS'] as $item) { ?>
                            <div class="job__work-is-item">
                                <h4>
                                    <img src="<?= $item['PICTURE'] ?>" class="icon" alt="<?= $item['NAME'] ?>"/>
                                    <?= $item['NAME'] ?>
                                </h4>
                                <p><?= $item['TEXT'] ?></p>
                            </div>
                        <? } ?>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
</div>
