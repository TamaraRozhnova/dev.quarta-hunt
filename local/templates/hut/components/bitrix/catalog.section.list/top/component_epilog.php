<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<script>
    let curPage = '<?= $APPLICATION->getCurPage() ?>';
    let sections = document.querySelectorAll('.sections-top__list li');

    if (sections.length) {
        sections.forEach(element => {
            element.classList.remove('active');
            if (element.querySelector('a').getAttribute('href') == curPage) {
                element.classList.add('active');
            }
        });
    }
</script>