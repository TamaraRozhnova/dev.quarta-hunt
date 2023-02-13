<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['rows'])) {
    return;
}

?>

<div class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal__close">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
        </div>
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="modal-title">Выберите город</h4>
                <div class="input input--lg">
                    <label for="location-search" class="form-label">
                        Ваш город
                    </label>
                    <div class="input__container">
                        <input id="location-search" type="text" class="form-control"/>
                            <div class="input__clear">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </div>
                    </div>
                </div>

                <? foreach ($arResult['rows'] as $city) { ?>
                    <div class="modal-location__item" data-name="<?= $city['UF_NAME'] ?>" data-code="<?= $city['UF_CODE'] ?>">
                        <?= $city['UF_NAME'] ?>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
</div>


