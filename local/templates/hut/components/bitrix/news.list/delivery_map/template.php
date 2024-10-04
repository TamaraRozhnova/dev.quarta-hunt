<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

<div id="map-container" style="width: 100%; height: 587px;"></div>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", () => {
		ymaps.ready(init);		
		function init() {

			var clusterer = new ymaps.Clusterer({
				preset: 'islands#orangeClusterIcons',
			});

			var myMap = new ymaps.Map("map-container", {
				center: [55.755864, 37.617698],
				zoom: 9
			}, {
				searchControlProvider: 'yandex#search'
			});

			<?foreach($arResult["ITEMS"] as $arItem):?>
			var myPlacemark = new ymaps.Placemark([<?=$arItem['PROPERTIES']['CORDS']['VALUE']?>],{
				balloonContentBody: '<?=$arItem['NAME']?>',
			},{
				preset: 'islands#orangeCircleDotIcon'
			});

			clusterer.add(myPlacemark);
			<?endforeach;?>


			myMap.geoObjects.add(clusterer);
		}
	});
</script>