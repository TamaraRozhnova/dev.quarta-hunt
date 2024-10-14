<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
	<ul class="left-menu">

		<?
		foreach ($arResult as $arItem):
			if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
				continue;
		?>
			<li class="<?= $arItem["PARAMS"]['CLASS'] ?>">
				<a href="<?= $arItem["LINK"] ?>" class="<?= $arItem["SELECTED"] ? 'selected' : '' ?> ">
					<? if ($arItem["PARAMS"]['DROPDOWN']) { ?>
						<span class="burger opener"><?= buildSVG('burger', SITE_TEMPLATE_PATH . ICON_PATH) ?></span>
						<span class="burger closer"><?= buildSVG('close', SITE_TEMPLATE_PATH . ICON_PATH) ?></span>
					<? } ?>
					<?= $arItem["TEXT"] ?>
					<? if ($arItem["PARAMS"]['HOT']) { ?>
						<span class="label">hot</span>
					<? } ?>
				</a>
			</li>
		<? endforeach ?>

	</ul>
<? endif ?>