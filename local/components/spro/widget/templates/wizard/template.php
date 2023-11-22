<?php if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global \CMain $APPLICATION */
/** @global \CUser $USER */
/** @global \CDatabase $DB */
/** @var \CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var array $templateData */
/** @var array $wizard */
/** @var \CBitrixComponent $component */

$this->setFrameMode( true );
$installSuccess = false;
if ($_POST)
{
	include_once __DIR__ . '/ajax.php';
	/** @var SiteWizard $siteWizard */
	if ($installSuccess)
	{
		LocalRedirect('?success=y');

		return;
	}
	else
	{
		echo 'Произошла ошибка: ';
		echo $siteWizard->LAST_ERROR;
		echo '<br><br>';
	}
}
?>
<?php if ($_REQUEST['success'] == 'y'): ?>
	<h3>Новый сайт успешно развернут</h3>
<?php endif ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
	.buttonload {
		background-color: #4CAF50; /* Green background */
		border: none; /* Remove borders */
		color: white; /* White text */
		padding: 12px 24px; /* Some padding */
		font-size: 16px; /* Set a font-size */
	}

	[data-form-loader]{
		max-width: 130px;
	}

	/* Add a right margin to each icon */
	.fa {
		margin-left: -12px;
		margin-right: 8px;
	}
</style>
<div>

	Перед запуском мастера создания нового сайта он должен быть корректно настроен на сервере. (<a href="https://dev.1c-bitrix.ru/learning/course/?COURSE_ID=103&LESSON_ID=287" target="_blank">Документация Битрикс</a>) <br>
	В настройках сервера должно быть указано
	<ul>
		<li>Доменное имя</li>
		<li>Должен быть известен Document root нового сайта</li>
		<li>В Document root должны быть созданы символические ссылки на папки bitrix, local, upload</li>
	</ul>
</div>
<form action="" method="post" enctype="multipart/form-data" data-form-wizard>
	<table>
		<tr>
			<td>
				Document root
			</td>
			<td>
				<input type="text" name="wizard[document_root]" value="<?=$wizard['document_root']?>" required>
			</td>
		</tr>
		<tr>
			<td>
				Доменное имя
			</td>
			<td>
				<input type="text" name="wizard[domain]" value="<?=$wizard['domain']?>" required>
			</td>
		</tr>
		<tr>
			<td>
				Логотип
			</td>
			<td>
				<input type="file" name="logo" value="" required>
			</td>
		</tr>
		<tr>
			<td>
				Каталог
			</td>
			<td>
				<select name="wizard[catalog]" id="" required>
					<?php foreach ($arResult['catalog'] as $id => $name): ?>
						<option value="<?=$id?>"><?=$name?></option>
					<?php endforeach; ?>

				</select>
			</td>
		</tr>
		<tr>
			<td>
				Вариант главной
			</td>
			<td>
				<select name="wizard[main]" id="" required>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Способ оплаты
			</td>
			<td>
				<select name="wizard[payment][]" multiple id="" required>
					<?php foreach ($arResult['payment'] as $id => $name): ?>
						<option value="<?=$id?>"><?=$name?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Способ доставки
			</td>
			<td>
				<select name="wizard[delivery][]" multiple id="" required>
					<?php foreach ($arResult['delivery'] as $id => $name): ?>
						<option value="<?=$id?>"><?=$name?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>

	</table>

	<button type="submit" class="buttonload">Запустить мастер</button>

	<div class="buttonload" style="display: none" data-form-loader>
		<i class="fa fa-spinner fa-spin"></i>Идет установка
	</div>
</form>
<script src="/bitrix/js/main/jquery/jquery-3.6.0.min.js"></script>
<script>
$(document).on('submit', '[data-form-wizard]', function (e){
    $('[type="submit"]').hide();
    $('[data-form-loader]').show();
})
</script>
