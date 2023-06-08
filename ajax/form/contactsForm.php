<?php

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

use Form\WebForm;

$data = array_merge($_POST, $_FILES);

$webForm = new WebForm($data['formId']);

unset($data['formId']);

$response = $webForm->saveResult($data);

echo json_encode($response);