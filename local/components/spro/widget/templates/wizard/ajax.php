<?php

$wizard = $_POST['wizard'];
include_once __DIR__ . '/SiteWizard.php';

$siteWizard = new SiteWizard( $wizard );
$installSuccess = $siteWizard->run();
