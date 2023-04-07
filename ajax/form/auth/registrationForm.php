<?php

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

use Form\Auth\RegistrationForm;

$requestBody = (array)json_decode(file_get_contents('php://input'));

$registrationForm = new RegistrationForm();

$response = $registrationForm->registerUser($requestBody);

echo json_encode($response);