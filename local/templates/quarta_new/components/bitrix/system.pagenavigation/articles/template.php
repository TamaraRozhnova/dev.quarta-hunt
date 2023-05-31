<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->createFrame()->begin("Загрузка навигации");?>


<?if($arResult["NavPageCount"] > 1):?>

    <?if ($arResult["NavPageNomer"]+1 <= $arResult["nEndPage"]):?>
        <?
            $plus = $arResult["NavPageNomer"]+1;
            $url = $arResult["sUrlPathParams"] . "PAGEN_".$arResult["NavNum"]."=".$plus;
        ?>

        <div class="article-btn-more load_more" data-url="<?=$url?>">
            <div class="article-btn-more-text">
                <span>Показать ещё</span>
            </div>
        </div>
    <?endif?>

<?endif?>