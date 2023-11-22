<? if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die(); ?><?
?>
<?=ShowError( $arResult["strProfileError"] );?>
<?
if ($arResult['DATA_SAVED'] == 'Y')
{
	echo ShowNote( GetMessage( 'PROFILE_DATA_SAVED' ) );
}
?>

<div class="ajax-content">
	<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data">
		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>"/>
		<input type="hidden" name="ID" value="<?=$arResult["ID"]?>">
		<input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>">
		<input type="hidden" name="EMAIL" value="<?=$arResult["arUser"]["EMAIL"]?>">
		<?php
		$fields = [
			'NAME',
			'LAST_NAME',
			'SECOND_NAME',
			'PERSONAL_PHONE',
		]; ?>
		<div class="checkout__personal">
			<div class="checkout__block-title"> Мои данные</div>
			<div class="checkout__personal-grid checkout__personal-grid--row">
				<?php foreach ($fields as $index => $item): ?>
					<div class="ui-block">
						<div class="ui-block__placeholder"><?=GetMessage( $item )?>*</div>
						<label class="ui-label">
							<input type="text" name="<?=$item?>" class="ui-input" placeholder="Введите <?=GetMessage( $item )?>" value="<?=$arResult["arUser"][ $item ]?>">
						</label>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="checkout__personal">
			<div class="checkout__block-title">Данные для доставки</div>
			<div class="checkout__personal-grid">
				<?php
				$fields = [
					'PERSONAL_CITY',
					'PERSONAL_STREET',
					'PERSONAL_MAILBOX',
				]; ?>
				<?php foreach ($fields as $index => $item): ?>
					<div class="ui-block">
						<div class="ui-block__placeholder"><?=GetMessage( $item )?>*</div>
						<label class="ui-label">
							<input type="text" name="<?=$item?>" class="ui-input" placeholder="Введите <?=GetMessage( $item )?>" value="<?=$arResult["arUser"][ $item ]?>">
						</label>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php /*
						<div class="customers__subscribe">
							<label class="toggle">
								<input type="checkbox" />
								<span class="toggle__item"></span>
							</label>
							<div class="customers__subscribe-text">
								Получать информацию о скидках, новинках и выгодных предложениях
							</div>
						</div>
						*/ ?>
        <div style="display: flex;
    align-items: center;
    justify-content: space-between;">
            <button class="ui-button ui-button--dark" name="save" value="<?=GetMessage( "MAIN_SAVE" )?>">
                Сохранить изменения
            </button>

            <a href="<?=$APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), [
                    "login",
                    "logout",
                    "register",
                    "forgot_password",
                    "change_password"]
            );?>" class="ui-button ui-button--dark" name="save" value="<?=GetMessage( "MAIN_SAVE" )?>">
                Выйти
            </a>

        </div>
	</form>
</div>
