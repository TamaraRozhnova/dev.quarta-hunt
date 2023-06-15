<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle('Оферта');?>

<div class="oferta">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-8">

				<h1 class="mb-5" style="text-transform: uppercase">
                    <?=$APPLICATION->ShowTitle()?>    
                </h1>

                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/include/about/oferta/oferta.php"
                    )
                );?>
				
			</div>
		</div>
	</div>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>