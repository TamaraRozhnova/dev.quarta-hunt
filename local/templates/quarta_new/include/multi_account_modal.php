<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

use \Bitrix\Main\Localization\Loc;

?>
<div id="multi-accounts-window" class="modal">
	<div class="modal-content">
		<div class="modal-body">
			<div class="multi-accounts-header">
				<div class="multi-accounts-header-title">
					<h3><?=Loc::getMessage('MULTI_ACCOUNT_TITLE')?></h3>
				</div>
				<div class = "multi-accounts-header-subtitle">
					<span><?=Loc::getMessage('MULTI_ACCOUNT_SUBTITLE')?></span>
				</div>
			</div>
			<div class="multi-accounts-content">
				<div class = "multi-accounts-content-list">
				</div>
			</div>
		</div>

		<div class="modal__close">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
					class="bi bi-x" viewBox="0 0 16 16">
				<path
					d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
			</svg>
		</div>
	</div>	
</div>