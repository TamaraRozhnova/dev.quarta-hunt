<?if (!empty($arResult['BRANDS_ALPHABET'])):?>
    <div class="brands-index__alph-words">
        <?if (!empty($arResult['BRANDS_ALPHABET']['ENG_WORDS'])):?>
            <?foreach ($arResult['BRANDS_ALPHABET']['ENG_WORDS'] as $engWordKey => $endWord):?>
                <div class="brands-index__alph-word">
                    <a href="#" data-word = '<?=$engWordKey?>'>
                        <?=$engWordKey?>
                    </a>
                </div>
            <?endforeach;?>

        <?endif;?>
        <?if (!empty($arResult['BRANDS_ALPHABET']['RUS_WORDS'])):?>
            <div class="brands-index__alph-word">
                <a href="#" data-word="А-Я">
                    А-Я
                </a>
            </div>
        <?endif;?>
        <?if (!empty($arResult['BRANDS_ALPHABET']['NUMERIC'])):?>
            <div class="brands-index__alph-word">
                <a href="#" data-word="0-9">
                    0-9
                </a>
            </div>
        <?endif;?>
    </div>
<?endif;?>