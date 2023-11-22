<?php use Bitrix\Main\Application;

if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global \CMain $APPLICATION */
/** @global \CUser $USER */
/** @global \CDatabase $DB */
/** @var CBitrixComponentTemplate $this */

$connection = Application::getConnection();
$sqlHelper = $connection->getSqlHelper();
$sql = "SELECT * FROM sp_social_" . SITE_ID . " WHERE UF_ACTIVE=1 ORDER BY UF_SORT ASC";
$recordset = $connection->query( $sql );
$arResult = [];
while ($record = $recordset->fetch())
{
	$arResult[] = $record;
}
