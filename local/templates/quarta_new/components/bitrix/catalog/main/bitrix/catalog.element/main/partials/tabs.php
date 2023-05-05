<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use General\User;

$user = new User();
$isUserAuth = $user->isAuthorized();

?>

<div class="product-about">
    <div class="product-about__tabs">
        <div class="container">
            <button class="product-about__tab product-about__tab--selected" data-tab="1">
                Описание и характеристики
            </button>
<!--            <button class="product-about__tab" data-tab="2">-->
<!--                Посмотреть наличие-->
<!--            </button>-->
            <? if (!empty($result['FILES'])) { ?>
                <button class="product-about__tab" data-tab="3">
                    Инструкции
                </button>
            <? } ?>
            <button class="product-about__tab" data-tab="4">
                Задать вопрос
            </button>
            <button class="product-about__tab" data-tab="5">
                Отзывы
                <span class="product-about__reviews-count"></span>
            </button>
        </div>
    </div>

    <div class="container product-about__tab-container product-about__desc product__tab product__tab--active"
         data-tab="1">
        <div class="row">
            <div class="col-6 pe-5 product-about__tab-inner">
                <h3>Характеристики</h3>
                <table class="table table-striped">
                    <tbody>
                    <? foreach ($result['PROPS'] as $prop) { ?>
                        <tr class="text-dark">
                            <td><?= $prop['NAME'] ?></td>
                            <th scope="row"><?= $prop['VALUE'] ?></th>
                        </tr>
                    <? } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-6 pe-5 product-about__tab-inner">
                <h3>Описание</h3>
                <div class="product-description__wrapper">
                    <div class="product-description">
                        <?= $result['~DETAIL_TEXT'] ?? $result['~PREVIEW_TEXT'] ?>
                    </div>
                    <div class="product-description__more" style="display: none">
                        <a>Еще...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--    <div v-if="availability" class="product-availability product__tab pb-5" data-tab="2">-->
<!--        <div class="container">-->
<!--            <h3>Наличие товара</h3>-->
<!--        </div>-->
<!--        <div class="product-availability__wr">-->
<!--            <div class="container">-->
<!--                <div class="row product-availability__header">-->
<!--                    <div class="col-5 product-availability__cell">Адрес</div>-->
<!--                    <div class="col-2 product-availability__cell">Режим работы</div>-->
<!--                    <div class="col-3 product-availability__cell">Наличие</div>-->
<!--                    <div class="col"></div>-->
<!--                </div>-->
<!---->
<!--                <div-->
<!--                        v-for="store of availability.stores"-->
<!--                        :key="store.id"-->
<!--                        class="row product-availability__spot"-->
<!--                >-->
<!--                    <div class="col-5 product-availability__cell">-->
<!--                        <div class="product-availability__address">-->
<!--                            <LocationIcon class="icon"/>-->
<!--                            <span v-html="store.title"/>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-2 product-availability__cell">-->
<!--                        <span><span class="product-availability__cell-show-on-md">Режим работы:</span> {{ store.schedule }}</span>-->
<!--                    </div>-->
<!--                    <div class="col-3 product-availability__cell">-->
<!--                        <ProductAvailabilityBageVue :avaible="!!store.amount"/>-->
<!--                    </div>-->
<!--                    <div class="col-2 product-availability__cell">-->
<!--                        <button class="btn" :disabled="!store.amount">Выбрать</button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <hr/>-->
<!--    </div>-->

    <? if (!empty($result['FILES'])) { ?>
        <div class="product-instructions container product__tab" data-tab="3">
            <div class="row">
                <div class="col-12">
                    <h3>Инструкции</h3>
                    <div class="product-instructions__files">
                        <? foreach ($result['FILES'] as $file) { ?>
                            <div class="product-instructions__file">
                                <div class="product-instructions__file-icon">
                                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/icons/document-download.svg"
                                         alt="Инструкция"/>
                                </div>
                                <a href="<?= $file['SRC'] ?>" class="product-instructions__file-name" nofollow
                                   target="_blank">
                                    <?= $file['NAME'] ?>
                                </a>
                                <div class="product-instructions__file-size">
                                    <?= $file['SIZE'] ?>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>

    <div class="product-ask container product__tab" data-tab="4">
        <? if (!$isUserAuth) { ?>
            <div class="login-to-continue">
                <h3 class="my-4">Войдите чтобы задать вопрос</h3>
                <a href="/login" class="btn btn-primary px-5 me-2">
                    Войти
                </a>
                <a href="/registration" class="btn bg-white text-primary border-primary px-5">
                    Зарегистрироваться
                </a>
            </div>
        <? } else { ?>
            <div class="row">
                <div class="col-12 col-lg-6 product-ask__form">
                    <h3>Задать вопрос</h3>
                    <p>
                        Нужна дополнительная информация? Пожалуйста, свяжитесь с нами, чтобы
                        задать вопрос.
                    </p>
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <div class="textarea mb-4">
                                    <label for="ask-text" class="form-label">
                                        Введите вопрос
                                    </label>
                                    <textarea id="ask-text" class="form-control" rows="3"></textarea>
                                </div>
                                <input name="productId" value="<?= $result['ID'] ?>" type="text" class="form-control" hidden>
                                <button class="btn btn-primary" type="submit">Отправить</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-6 product-ask__success" style="display: none">
                    <h3>Вопрос успешно отправлен</h3>
                    <p>Ответ придет на электронную почту указанную в аккаунте.</p>
                </div>
            </div>
        <? } ?>
    </div>

    <div class="product-reviews product__tab" data-tab="5">
        <? $APPLICATION->IncludeFile($templateFolder . '/partials/reviews.php', [
            'result' => $result
        ], ['SHOW_BORDER' => false]);
        ?>
    </div>
</div>