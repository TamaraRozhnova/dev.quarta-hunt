<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);


?>
<div class="row promo-filter">
    <div class="col-12">
        <form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>">
            <div class="promo__select-type">
                <span class="promo-filter__title">Показать:</span>
                <a href="/promo/"
                    class="ms-1 nuxt-link-active <?=$_GET['type'] == 'ended' ? null : 'disabled' ?>"
                    data-index="1">Актуальные акции</a>
                <a href="?type=ended"
                    class="ms-1 nuxt-link-active <?=$_GET['type'] == 'ended' ? 'disabled' : null ?> ended"
                    data-index="2">Завершенные акции</a>
            </div>
        </form>
    </div>
</div>