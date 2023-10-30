<?php if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;


if ($arParams["MAIN_CHAIN_NAME"] <> '')
{
	$APPLICATION->AddChainItem( htmlspecialcharsbx( $arParams["MAIN_CHAIN_NAME"] ), $arResult['SEF_FOLDER'] );
}

//$this->addExternalCss( "/bitrix/css/main/font-awesome.css" );
//$theme = Bitrix\Main\Config\Option::get( "main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID );

$availablePages = [];

if ($arParams['SHOW_PRIVATE_PAGE'] === 'Y')
{
	$availablePages[] = [
		"path" => $arResult['PATH_TO_PRIVATE'],
		"name" => Loc::getMessage( "SPS_PERSONAL_PAGE_NAME" ),
		"icon" => '<i class="fa fa-user-secret"></i>',
	];
}
if ($arParams['SHOW_ORDER_PAGE'] === 'Y')
{
	$availablePages[] = [
		"path" => $arResult['PATH_TO_ORDERS'],
		"name" => Loc::getMessage( "SPS_ORDER_PAGE_NAME" ),
		"icon" => '<i class="fa fa-calculator"></i>',
	];
}

if ($arParams['SHOW_ACCOUNT_PAGE'] === 'Y')
{
	$availablePages[] = [
		"path" => $arResult['PATH_TO_ACCOUNT'],
		"name" => Loc::getMessage( "SPS_ACCOUNT_PAGE_NAME" ),
		"icon" => '<i class="fa fa-credit-card"></i>',
	];
}

/*
if ($arParams['SHOW_ORDER_PAGE'] === 'Y')
{

	$delimeter = ( $arParams['SEF_MODE'] === 'Y' )?"?":"&";
	$availablePages[] = [
		"path" => $arResult['PATH_TO_ORDERS'] . $delimeter . "filter_history=Y",
		"name" => Loc::getMessage( "SPS_ORDER_PAGE_HISTORY" ),
		"icon" => '<i class="fa fa-list-alt"></i>',
	];
}*/

if ($arParams['SHOW_PROFILE_PAGE'] === 'Y')
{
	$availablePages[] = [
		"path" => $arResult['PATH_TO_PROFILE'],
		"name" => Loc::getMessage( "SPS_PROFILE_PAGE_NAME" ),
		"icon" => '<i class="fa fa-list-ol"></i>',
	];
}

if ($arParams['SHOW_BASKET_PAGE'] === 'Y')
{
	$availablePages[] = [
		"path" => $arParams['PATH_TO_BASKET'],
		"name" => Loc::getMessage( "SPS_BASKET_PAGE_NAME" ),
		"icon" => '<i class="fa fa-shopping-cart"></i>',
	];
}

if ($arParams['SHOW_SUBSCRIBE_PAGE'] === 'Y')
{
	$availablePages[] = [
		"path" => $arResult['PATH_TO_SUBSCRIBE'],
		"name" => Loc::getMessage( "SPS_SUBSCRIBE_PAGE_NAME" ),
		"icon" => '<i class="fa fa-envelope"></i>',
	];
}

if ($arParams['SHOW_CONTACT_PAGE'] === 'Y')
{
	$availablePages[] = [
		"path" => $arParams['PATH_TO_CONTACT'],
		"name" => Loc::getMessage( "SPS_CONTACT_PAGE_NAME" ),
		"icon" => '<i class="fa fa-info-circle"></i>',
	];
}

$customPagesList = CUtil::JsObjectToPhp( $arParams['~CUSTOM_PAGES'] );
if ($customPagesList)
{
	foreach ($customPagesList as $page)
	{
		$availablePages[] = [
			"path" => $page[0],
			"name" => $page[1],
			"icon" => ( mb_strlen( $page[2] ) )?'<i class="fa ' . htmlspecialcharsbx( $page[2] ) . '"></i>':"",
		];
	}
}

if (empty( $availablePages ))
{
	ShowError( Loc::getMessage( "SPS_ERROR_NOT_CHOSEN_ELEMENT" ) );
}
else
{
	?>
	<?php $this->SetViewTarget( 'PERSONAL_MENU' ); ?>
	<ul class="customers-list">
		<?php foreach ($availablePages as $blockElement)
		{
			?>
			<li class="customers-item">
				<a href="<?=htmlspecialcharsbx( $blockElement['path'] )?>" class="customers-link">
					<span class="customers-link__text"><?=htmlspecialcharsbx( $blockElement['name'] )?></span>
				</a>
			</li>
			<?php
		}
		?>
	</ul>
	<?php $this->EndViewTarget(); ?>
	<?php
	$APPLICATION->IncludeComponent(
		"bitrix:main.profile",
		"",
		Array(
			"SET_TITLE" =>$arParams["SET_TITLE"],
			"AJAX_MODE" => $arParams['AJAX_MODE_PRIVATE'],
			"SEND_INFO" => $arParams["SEND_INFO_PRIVATE"],
			"CHECK_RIGHTS" => $arParams['CHECK_RIGHTS_PRIVATE'],
			"EDITABLE_EXTERNAL_AUTH_ID" => $arParams['EDITABLE_EXTERNAL_AUTH_ID'],
			"DISABLE_SOCSERV_AUTH" => $arParams['DISABLE_SOCSERV_AUTH']
		),
		false
	);
}
?>
