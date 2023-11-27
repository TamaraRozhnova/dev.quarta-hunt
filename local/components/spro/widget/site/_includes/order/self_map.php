<div class="map-container" id="map-<?=$ID?>" style="    margin-bottom: 30px"></div>

<script type="text/javascript">
    ymaps.ready(init);

    function init() {
        // Создание карты.
        var myMap = new ymaps.Map("map-<?=$ID?>", {
            center: [<?=$GPS_N?>, <?=$GPS_S?>],
            zoom: 17,
        });

        myMap.geoObjects
            .add(new ymaps.Placemark([<?=$GPS_N?>, <?=$GPS_S?>], {
                balloonContent: '<?=$ADDRESS?>'
            }, {
                iconLayout: 'default#image',
                iconImageHref: '<?=SITE_TEMPLATE_PATH ?>/img/placemark.svg',
                iconImageSize: [19, 29],
                iconImageOffset: [-10, -29]
            }))
    }
</script>
