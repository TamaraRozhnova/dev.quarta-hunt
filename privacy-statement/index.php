<?php

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');

$APPLICATION->SetTitle('Quarta Hunt');
$APPLICATION->AddChainItem('Положение о Конфиденциальности');

?>

<div class="privacy-policy">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="breadcrumb-wrapper">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:breadcrumb", "", array(
                            "START_FROM" => "0",
                            "PATH" => "",
                            "SITE_ID" => "s1"
                        )
                    ); ?>
                </div>
                <h1 class="mb-5">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/privacy-statement/title.php",
                        ],
                        false,
                    ); ?>
                </h1>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    [
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/privacy-statement/text.php",
                    ],
                    false,
                ); ?>
            </div>
        </div>
    </div>
</div>

<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>