<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<section class="main-slider swiper">
	<div class="swiper-wrapper">
		<? foreach ($arResult["ITEMS"] as $arItem): ?>
			<div class="main-slider__slide swiper-slide" style="background-image:url('.<?= $arItem['DETAIL_PICTURE']['SRC'] ?>');">
				<div class="container">
					<?
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					?>
					<div class="main-slider__item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
						<div class="main-slider__item-left">
							<div class="main-slider__item-title"><?= $arItem['DETAIL_TEXT'] ?></div>
							<div class="main-slider__item-subtitle"><?= $arItem['PREVIEW_TEXT'] ?></div>
							<div class="main-slider__item-buttons">
								<? if ($arItem['PROPERTIES']['MAIN_BUTTON_TEXT']['VALUE']) { ?>
									<a href="<?= $arItem['PROPERTIES']['MAIN_BUTTON_LINK']['VALUE'] ?>" class="button button-primary"><?= $arItem['PROPERTIES']['MAIN_BUTTON_TEXT']['VALUE'] ?></a>
								<? } ?>
								<? if ($arItem['PROPERTIES']['SECOND_BUTTON_TEXT']['VALUE']) { ?>
									<a href="<?= $arItem['PROPERTIES']['SECOND_BUTTON_LINK']['VALUE'] ?>" class="button button-secondary"><?= $arItem['PROPERTIES']['SECOND_BUTTON_TEXT']['VALUE'] ?></a>
								<? } ?>
							</div>
						</div>
						<div class="main-slider__item-right">
							<div class="main-slider__item-text">
								<?= $arItem['PROPERTIES']['RIGHT_TEXT']['VALUE'] ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<? endforeach; ?>
	</div>
	<div class="container main-slider__buttons-wrap">
		<div class="main-slider__buttons">
			<div class="main-slider__left">
				<svg xmlns="http://www.w3.org/2000/svg" width="88" height="88" viewBox="0 0 88 88" fill="none">
					<rect x="0.5" y="0.5" width="87" height="87" rx="43.5" stroke="white" />
					<path fill-rule="evenodd" clip-rule="evenodd" d="M48.7071 35.2929C49.0976 35.6834 49.0976 36.3166 48.7071 36.7071L41.4142 44L48.7071 51.2929C49.0976 51.6834 49.0976 52.3166 48.7071 52.7071C48.3166 53.0976 47.6834 53.0976 47.2929 52.7071L39.2929 44.7071C38.9024 44.3166 38.9024 43.6834 39.2929 43.2929L47.2929 35.2929C47.6834 34.9024 48.3166 34.9024 48.7071 35.2929Z" fill="white" />
				</svg>
			</div>
			<div class="main-slider__count">
				<span class="main-slider__current">1</span> из <?= count($arResult['ITEMS']) ?>
			</div>
			<div class="main-slider__right">
				<svg xmlns="http://www.w3.org/2000/svg" width="88" height="88" viewBox="0 0 88 88" fill="none">
					<rect x="0.5" y="0.5" width="87" height="87" rx="43.5" stroke="white" />
					<path fill-rule="evenodd" clip-rule="evenodd" d="M39.2929 35.2929C39.6834 34.9024 40.3166 34.9024 40.7071 35.2929L48.7071 43.2929C49.0976 43.6834 49.0976 44.3166 48.7071 44.7071L40.7071 52.7071C40.3166 53.0976 39.6834 53.0976 39.2929 52.7071C38.9024 52.3166 38.9024 51.6834 39.2929 51.2929L46.5858 44L39.2929 36.7071C38.9024 36.3166 38.9024 35.6834 39.2929 35.2929Z" fill="white" />
				</svg>
			</div>
		</div>
	</div>
	<div class="main-slider__progress"><span class="main-slider__percent"></span></div>
</section>