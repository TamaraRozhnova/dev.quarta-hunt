<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<div class="jobs">
    <div class="container">
        <h1><?= $APPLICATION->GetTitle() ?></h1>

        <div class="jobs__filters">
            <div class="select__wrapper me-3 select__wrapper--medium">
                <div class="select select--vacancy select--medium" data-placeholder="Вакансия">
                    <button class="select__main btn">
                        Вакансия
                        <div class="select__options">
                            <div class="select__option" tabindex="0" data-id="">
                                <span>Все</span>
                            </div>
                            <? foreach ($arResult['ITEMS'] as $option) { ?>
                                <div class="select__option" tabindex="0" data-id="<?= $option['NAME'] ?>">
                                    <span><?= $option['NAME'] ?></span>
                                </div>
                            <? } ?>
                        </div>
                    </button>
                </div>
            </div>
            <div class="select__wrapper select__wrapper--medium">
                <div class="select select--schedule select--medium" data-placeholder="График работы">
                    <button class="select__main btn">
                        График работы
                        <div class="select__options">
                            <div class="select__option" tabindex="0" data-id="">
                                <span>Все</span>
                            </div>
                            <? foreach ($arResult['SCHEDULE_OPTIONS'] as $option) { ?>
                                <div class="select__option" tabindex="0" data-id="<?= $option ?>">
                                    <span><?= $option ?></span>
                                </div>
                            <? } ?>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <div class="jobs__main">
            <? if (!empty($arResult['ITEMS'])) { ?>
                <div class="jobs__items">
                    <? foreach ($arResult['ITEMS'] as $item) { ?>
                        <div class="jobs__item card my-5 border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="jobs__item-tags order-3 col-12 row mb-5 order-lg-0">
                                        <div class="col-12 d-flex flex-column d-lg-block col-lg-6">
                                            <span><?= $item['PROPERTIES']['CITY']['VALUE'] ?></span>
                                            <span>
                                                <svg style="transform: translateY(-1px)" width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5 0C2.23969 0 0 2.01594 0 4.5C0 8.5 5 14 5 14C5 14 10 8.5 10 4.5C10 2.01594 7.76031 0 5 0ZM5 7C4.60444 7 4.21776 6.8827 3.88886 6.66294C3.55996 6.44318 3.30362 6.13082 3.15224 5.76537C3.00087 5.39991 2.96126 4.99778 3.03843 4.60982C3.1156 4.22186 3.30608 3.86549 3.58579 3.58579C3.86549 3.30608 4.22186 3.1156 4.60982 3.03843C4.99778 2.96126 5.39991 3.00087 5.76537 3.15224C6.13082 3.30362 6.44318 3.55996 6.66294 3.88886C6.8827 4.21776 7 4.60444 7 5C6.99942 5.53026 6.78852 6.03863 6.41357 6.41357C6.03863 6.78852 5.53026 6.99942 5 7Z" fill="#808D9A"/>
                                                </svg>
                                                <?= $item['PROPERTIES']['ADDRESS']['VALUE'] ?>
                                            </span>
                                        </div>
                                        <? foreach ($item['PROPERTIES']['TAGS']['VALUE'] as $tag) { ?>
                                            <div class="col pe-5">
                                                <?= $tag ?>
                                            </div>
                                        <? } ?>
                                    </div>
                                    <div class="col-12 order-1 col-lg-4 jobs__item-head order-lg-0">
                                        <h4><?= $item['NAME'] ?></h4>
                                        <p><?= $item['PROPERTIES']['SALARY']['VALUE'] ?></p>
                                    </div>
                                    <div class="d-none col-lg-2 d-lg-block order-lg-0"></div>
                                    <div class="col-12 order-2 col-lg-6 order-lg-0">
                                        <figure class="jobs__item-image">
                                            <img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $item['NAME'] ?>" />
                                        </figure>
                                    </div>
                                    <div class="jobs__item-actions order-4 order-lg-0">
                                        <a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="btn btn-light px-4 me-lg-2">
                                            Читать подробнее
                                        </a>
                                        <a href="<?= $item['DETAIL_PAGE_URL'] ?>#form" class="btn btn-primary px-4">
                                            Откликнуться
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                </div>
            <? } else { ?>
                <p class="text-dark fs-6 mt-5">
                    На данный момент вакансий нет
                </p>
            <? } ?>
        </div>
        <div class="loading">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Загрузка</span>
            </div>
            <div class="loading__text">
                Загрузка
            </div>
        </div>
    </div>
</div>