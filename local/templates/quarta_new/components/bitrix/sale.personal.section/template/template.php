<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;


if ($arParams["MAIN_CHAIN_NAME"] <> ''){
	$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}
CJSCore::Init(['masked_input', 'jquery']);
$this->addExternalCss("/bitrix/css/main/font-awesome.css");

$availablePages = array();
if ($arParams['SHOW_ACCOUNT_PAGE'] === 'Y'){
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ACCOUNT'],
		"name" => Loc::getMessage("SPS_ACCOUNT_PAGE_NAME"),
		"icon" => '<i class="fa fa-credit-card"></i>'
	);
}

if ($arParams['SHOW_PRIVATE_PAGE'] === 'Y'){
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_PRIVATE'],
		"name" => Loc::getMessage("SPS_PERSONAL_PAGE_NAME"),
		"icon" => '<i class="fa fa-user-secret"></i>'
	);
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y'){
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ORDERS'],
		"name" => Loc::getMessage("SPS_ORDER_PAGE_NAME"),
		"icon" => '<i class="fa fa-calculator"></i>'
	);
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y'){

	$delimeter = ($arParams['SEF_MODE'] === 'Y') ? "?" : "&";
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ORDERS'].$delimeter."filter_history=Y",
		"name" => Loc::getMessage("SPS_ORDER_PAGE_HISTORY"),
		"icon" => '<i class="fa fa-list-alt"></i>'
	);
}

if ($arParams['SHOW_PROFILE_PAGE'] === 'Y'){
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_PROFILE'],
		"name" => Loc::getMessage("SPS_PROFILE_PAGE_NAME"),
		"icon" => '<i class="fa fa-list-ol"></i>'
	);
}


$customPagesList = CUtil::JsObjectToPhp($arParams['~CUSTOM_PAGES']);
if ($customPagesList){
	foreach ($customPagesList as $page){
		$availablePages[] = array(
			"path" => $page[0],
			"name" => $page[1],
			"icon" => (mb_strlen($page[2])) ? '<i class="fa '.htmlspecialcharsbx($page[2]).'"></i>' : ""
		);
	}
}

if (empty($availablePages)){
	ShowError(Loc::getMessage("SPS_ERROR_NOT_CHOSEN_ELEMENT"));
}else{ ?>
	<div class="personal-wrap cabinet-page">
		<div class="container">
			<h1 class = "small-h2">
				<?=$APPLICATION->ShowTitle()?>
			</h2>
			<div class="sale-personal-section-index">
				<? /*<div class="sale-personal-section-row-flex">
					<? foreach ($availablePages as $blockElement) { ?>
						<div class="sale-personal-section-index-block">
							<a class="sale-personal-section-index-block-link" href="<?=htmlspecialcharsbx($blockElement['path'])?>">
								<span class="sale-personal-section-index-block-ico">
									<?=$blockElement['icon']?>
								</span>
								<h2 class="sale-personal-section-index-block-name">
									<?=htmlspecialcharsbx($blockElement['name'])?>
								</h2>
							</a>
						</div>
					<? } ?>
				</div>*/?>
				<div class="sale-personal-section-half">
				<div class="cabinet-section">
					<div class="cabinet-section__header">
						<span>
							<svg  width="12" height="13" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon">
								<path  d="M3 3.079c0 1.697 1.346 3.079 3 3.079s3-1.382 3-3.08C9 1.382 7.654.001 6 .001s-3 1.38-3 3.078zM11.333 13H12v-.684c0-2.64-2.094-4.79-4.667-4.79H4.667C2.093 7.526 0 9.676 0 12.316V13h11.333z" fill="currentColor"></path>
							</svg> 
							<h6 ><?= Loc::getMessage('SPS_PERSONAL_PAGE_NAME');?></h6>
						</span>
						<a href="<?= $arResult['PATH_TO_PRIVATE'];?>" class="btn btn-light bg-gray-200 cabinet__button">
							<span><?= Loc::getMessage('SPS_CHANGE');?></span>
							<span class="cabinet-mobile-button">
								<svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M-3.82963e-07 1.23883L3.61719 5L-5.41509e-08 8.76117L1.19141 10L6 5L1.19141 -5.2078e-08L-3.82963e-07 1.23883Z" fill="#333333"></path>
								</svg>
							</span>
							
						</a>
					</div> 
					<div class="cabinet-section__content"> 
						<p class="text-dark"><?= $arResult['USER']['FIRST_NAME'].' '.$arResult['USER']['LAST_NAME'];?></p> 
						<p class="text-dark"><?= $arResult['USER']['EMAIL'];?><br > тел.: <?= $arResult['USER']['PERSONAL_PHONE'];?><br ></p>
						<p>
							<a href="/cabinet/?logout=yes" class="cabinet-btn-exit">
								Выход
							</a>
						</p>
					</div>
				</div>
				<div class="cabinet-section">
					<div class="cabinet-section__header">
						<span>
							<svg width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon">
								<path d="M13.5 1.78a.78.78 0 00-.785-.78h-9.93A.78.78 0 002 1.78v12.44a.78.78 0 00.785.78h.26V2.035H13.5V1.78z" fill="currentColor"></path>
								<path d="M14.75 3h-10a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h10a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75z" fill="currentColor"></path>
							</svg> 
							<h6><?= Loc::getMessage('SPS_ORDER_PAGE_HISTORY');?></h6> 
						</span>
						<a href="<?= $arResult['PATH_TO_ORDERS'];?>" class="btn btn-light bg-gray-200 cabinet__button" >
							<span><?= Loc::getMessage('SPS_MORE');?></span>
							<span class="cabinet-mobile-button">
								<svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M-3.82963e-07 1.23883L3.61719 5L-5.41509e-08 8.76117L1.19141 10L6 5L1.19141 -5.2078e-08L-3.82963e-07 1.23883Z" fill="#333333"></path>
								</svg>
							</span>
						</a>
					</div> 
					<div class="cabinet-section__content"> 
						<? foreach ($arResult['ORDERS'] as $order) {?>
							<a href="<?= $arResult['PATH_TO_ORDERS'].$order['ID']?>" class="cabinet__history-item" >
								<figure style="background-image: url(&quot;<?= $order['PICTURE_PATH']?>&quot;);"></figure> 
								<div class="cabinet__history-texts">
									<div class="cabinet__history-title"><?= Loc::getMessage('SPS_ORDER_OT');?> <?= $order['DATE_INSERT']?> <br ><?= $order['ACCOUNT_NUMBER']?></div> 
									<div class="cabinet__history-price"><?= CurrencyFormat($order['PRICE'], "RUB");?></div>
								</div>
							</a>
						<?}?>
						<a href="<?= $arResult['PATH_TO_ORDERS'];?>" class="my-4">
							<?if($arResult['USER']['ORDERS'] > 3){
								$ordersCount = $arResult['USER']['ORDERS'] - 3;
								$quantityText = num_declension($ordersCount, array('заказ', 'заказа', 'заказов'));?>
								<?= Loc::getMessage('SPS_WATCH', array('#COUNT_ORDER#' => $quantityText));?>
							<?}?>
						</a> 
					</div>
				</div>

				<div class="cabinet-section">
					<div class="cabinet-section__header">
						<span>
							<svg  width="15" height="11" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon">
								<path d="M11.59 9.969c-.27 0-.53-.109-.722-.302a1.036 1.036 0 010-1.459 1.019 1.019 0 011.446 0 1.036 1.036 0 010 1.459 1.018 1.018 0 01-.723.302zm1.024-6.188L13.95 5.5h-3.04V3.781h1.704zM3.409 9.97a1.02 1.02 0 01-.723-.302 1.036 1.036 0 010-1.459 1.018 1.018 0 011.446 0 1.036 1.036 0 010 1.459 1.018 1.018 0 01-.723.302zm9.546-7.219h-2.046V0H1.364C.607 0 0 .612 0 1.375v7.563h1.364c0 .547.215 1.071.599 1.458a2.037 2.037 0 002.892 0c.384-.387.6-.911.6-1.459h4.09c0 .548.216 1.072.6 1.459a2.037 2.037 0 002.892 0c.384-.387.6-.911.6-1.459H15V5.5l-2.046-2.75z" fill="#808d9a"></path>
							</svg>
							<h6><?= Loc::getMessage('SPS_ADDRESSES_DELIVERY');?></h6> 
						</span>

						<a href="<?= $arParams['SEF_FOLDER'].$arParams['PATH_TO_ADDRESSES']?>" class="btn btn-light bg-gray-200 cabinet__button" >
							<span>
								<?= 
								!empty($arResult['USER_ADDRESS'])
									? Loc::getMessage('SPS_CHANGE')
									: Loc::getMessage('SPS_ADD')
								?>
							</span>
							<span class="cabinet-mobile-button">
								<svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M-3.82963e-07 1.23883L3.61719 5L-5.41509e-08 8.76117L1.19141 10L6 5L1.19141 -5.2078e-08L-3.82963e-07 1.23883Z" fill="#333333"></path>
								</svg>
							</span>
						</a>

					</div> 
					<div class="cabinet-section__content"> 
						<?if (!empty($arResult['USER_ADDRESS'])):?>
							<p class="text-dark" style="margin: initial">
								<?=$arResult['USER_ADDRESS']['PERSONAL_STREET']?>,
								<?=$arResult['USER_ADDRESS']['PERSONAL_MAILBOX']?>.
								<?=$arResult['USER_ADDRESS']['PERSONAL_CITY']?>;
								<?=$arResult['USER_ADDRESS']['PERSONAL_ZIP']?>
							</p>
						<?else:?>
							<p class="text-dark" style="margin: initial">
								Укажите ваш адрес для доставки курьером или определения ближайщего пункта CДЭК
							</p>
						<?endif;?>
					</div>
				</div>

				</div>
				<div class="sale-personal-section-half">
					<div class = "cabinet-section bonus-main-wrapper">
						<div class = "cabinet-section__content blue-back">
							<div class = "bonuses-cabinet-wrapper">
								<div class = "bonuses-cabinet-text-ico">
									<div class = "bonuses-cabinet-ico">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g clip-path="url(#clip0_2602_45324)">
										<path d="M5.80983 11.4198C6.37188 11.4198 6.91516 11.3835 7.42925 11.3159V5.68098C6.91521 5.61345 6.37188 5.57715 5.80983 5.57715C2.60062 5.57715 -0.000976562 6.75708 -0.000976562 8.21266V8.78422C-0.000976562 10.2398 2.60062 11.4198 5.80983 11.4198Z" fill="white" fill-opacity="0.59"/>
										<path d="M5.80983 14.3631C6.37188 14.3631 6.91516 14.3268 7.42925 14.2593V12.6076C6.91506 12.6751 6.37203 12.7119 5.80983 12.7119C3.00854 12.7119 0.670438 11.8128 0.121235 10.6162C0.0412545 10.7905 -0.000976562 10.971 -0.000976562 11.156V11.7276C-0.000976562 13.1831 2.60062 14.3631 5.80983 14.3631Z" fill="white" fill-opacity="0.59"/>
										<path d="M7.43023 15.6784V15.55C6.91604 15.6175 6.37301 15.6543 5.81081 15.6543C3.00951 15.6543 0.671414 14.7552 0.122211 13.5586C0.0422311 13.7328 0 13.9133 0 14.0983V14.6699C0 16.1255 2.60159 17.3055 5.81081 17.3055C6.45259 17.3055 7.06987 17.2581 7.64711 17.171C7.50403 16.8783 7.43023 16.5697 7.43023 16.2499V15.6784Z" fill="white" fill-opacity="0.59"/>
										<path d="M14.1897 1.11426C10.9805 1.11426 8.37891 2.29419 8.37891 3.74977V4.32133C8.37891 5.77691 10.9805 6.95684 14.1897 6.95684C17.3989 6.95684 20.0005 5.77691 20.0005 4.32133V3.74977C20.0005 2.29419 17.3989 1.11426 14.1897 1.11426Z" fill="white" fill-opacity="0.59"/>
										<path d="M14.1897 8.24903C11.3884 8.24903 9.05032 7.34998 8.50112 6.15332C8.42114 6.32757 8.37891 6.50805 8.37891 6.69311V7.26467C8.37891 8.72025 10.9805 9.90018 14.1897 9.90018C17.3989 9.90018 20.0005 8.72025 20.0005 7.26467V6.69311C20.0005 6.50805 19.9583 6.32757 19.8783 6.15332C19.3291 7.34998 16.991 8.24903 14.1897 8.24903Z" fill="white" fill-opacity="0.59"/>
										<path d="M14.1897 11.1914C11.3884 11.1914 9.05032 10.2923 8.50112 9.0957C8.42114 9.26996 8.37891 9.45044 8.37891 9.6355V10.2071C8.37891 11.6627 10.9805 12.8426 14.1897 12.8426C17.3989 12.8426 20.0005 11.6627 20.0005 10.2071V9.6355C20.0005 9.45044 19.9583 9.26996 19.8783 9.0957C19.3291 10.2924 16.991 11.1914 14.1897 11.1914Z" fill="white" fill-opacity="0.59"/>
										<path d="M14.1897 14.292C11.3884 14.292 9.05032 13.3929 8.50112 12.1963C8.42114 12.3706 8.37891 12.551 8.37891 12.736V13.3076C8.37891 14.7632 10.9805 15.9432 14.1897 15.9432C17.3989 15.9432 20.0005 14.7632 20.0005 13.3076V12.736C20.0005 12.551 19.9583 12.3705 19.8783 12.1963C19.3291 13.3929 16.991 14.292 14.1897 14.292Z" fill="white" fill-opacity="0.59"/>
										<path d="M14.1897 17.2334C11.3884 17.2334 9.05032 16.3344 8.50112 15.1377C8.42114 15.312 8.37891 15.4926 8.37891 15.6775V16.249C8.37891 17.7046 10.9805 18.8846 14.1897 18.8846C17.3989 18.8846 20.0005 17.7046 20.0005 16.249V15.6774C20.0005 15.4924 19.9583 15.3119 19.8783 15.1377C19.3291 16.3343 16.991 17.2334 14.1897 17.2334Z" fill="white" fill-opacity="0.59"/>
										</g>
										<defs>
										<clipPath id="clip0_2602_45324">
										<rect width="20" height="20" fill="white"/>
										</clipPath>
										</defs>
									</svg>

									</div>
									<div class = "bonuses-cabinet-text">
										<span>
											<?=Loc::getMessage('BONUS_TEXT')?>
										</span>
									</div>
								</div>

								<div class = "bonuses-cabinet-count">
									<span>
										<?=$arResult['BONUS_DISPLAY']?>
									</span>
								</div>

							</div>
						</div>
					</div>

				<div class="cabinet-section">
					<div class="cabinet-section__content">
						<p> <?= Loc::getMessage('SPS_BONUS_TEXT');?></p> 
		  				<p><a href="/promo/bonusnaya-nakopitelnaya-sistema-"><?= Loc::getMessage('SPS_BONUS_READMORE');?></a></p>
					</div>
				</div>
				<div class="cabinet-section">
					<div class="cabinet-section__header">
						<span>
							<svg width="20" height="9" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon" >
								<path d="M4.375 8.627a4.711 4.711 0 01-2.226-.553A4.181 4.181 0 01.543 6.568a3.693 3.693 0 01-.54-2.04 3.727 3.727 0 01.675-2.006 4.252 4.252 0 011.704-1.415 4.745 4.745 0 012.259-.43 4.67 4.67 0 012.184.675A4.112 4.112 0 018.33 2.943h9.17l1.876 1.706L17.5 6.354l-1.25-1.137L15 6.354l-1.25-1.137-1.25 1.137-1.25-1.137L10 6.354H8.329a4.13 4.13 0 01-1.615 1.658 4.7 4.7 0 01-2.34.615zm-1.25-2.842c.331 0 .65-.12.884-.333.234-.213.366-.502.366-.803 0-.302-.132-.591-.366-.804a1.316 1.316 0 00-.884-.333c-.332 0-.65.12-.884.333a1.087 1.087 0 00-.366.804c0 .301.132.59.366.803.234.214.552.333.884.333z" fill="currentColor" ></path>
							</svg> 
							<h6 class="py-3" ><?=  Loc::getMessage('SPS_PERSONAL_PASSWORD');?></h6>
						</span>
					</div> 
					<div class="cabinet-section__content"> 
						<div class="input my-4" >
							<label for="old-password" class="form-label"><?= Loc::getMessage('SPS_OLD_PASSWORD');?></label>  
							<span class="input__container">
								<input id="old-password" masked="true" type="password" name="CURRENT_PASSWORD" value="" class="form-control">
							</span>
						</div> 
						<div class="input my-4" >
							<label for="new-password" class="form-label"><?= Loc::getMessage('SPS_NEW_PASSWORD');?></label> 
							<span class="input__container">
								<input id="new-password" masked="true" type="password" name="NEW_PASSWORD" value="" class="form-control">  
							</span>
						</div> 
						<div class="input my-4" >
							<label for="repeat-password" class="form-label"><?= Loc::getMessage('SPS_REPEAT_PASSWORD');?></label> 
							<span class="input__container">
								<input id="repeat-password" masked="true" type="password" name="NEW_PASSWORD_CONFIRM" value="" class="form-control">  
							</span>
						</div> 
						<div class="btn btn-primary px-5 cabinet__submit" data-event="UPDATE_PASSWORD" onclick="saveProfileBlock(this)"><?= Loc::getMessage('SPS_SAVE');?></div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
<? } ?>

<script>
    var message = {
        ERROR_PASS_LENGTH: "<?= Loc::getMessage("ERROR_PASS_LENGTH") ?>",
        ERROR_PASS_INVALID: "<?= Loc::getMessage("ERROR_PASS_INVALID") ?>",
        ERROR_PASS_NOT_EQ: "<?= Loc::getMessage("ERROR_PASS_NOT_EQ") ?>",
		AJAX_SAVED: "<?= Loc::getMessage("AJAX_SAVED") ?>",
		AJAX_SAVING: "<?= Loc::getMessage("AJAX_SAVING") ?>",
		ERROR_EMPTY_FIELD: "<?= Loc::getMessage("ERROR_EMPTY_FIELD") ?>",
    }
    var params = {
        TEMPLATE_PATH: '<?=$templateFolder?>'
    };
</script>