class YandexMap {
    constructor(selectorId, points) {
        this.selectorIdMap = selectorId;
        this.points = points;

        this.apiKey = 'c38076c2-06f1-4e49-992b-4e4156255a1d';
        this.zoom = 16;

        this.createMapScript();
    }

    createMapScript() {
        const mapScriptElement = document.createElement('script');
        mapScriptElement.src = `https://api-maps.yandex.ru/2.1/?apikey=${this.apiKey}&lang=ru_RU`;
        document.body.append(mapScriptElement);
        mapScriptElement.onload = () => this.initMap();
    }

    initMap() {
        ymaps.ready(() => {
            this.map = new ymaps.Map(this.selectorIdMap, this.createMapOptions());
            this.map.controls.add('zoomControl', {
                size: 'small',
            });
            this.createPlacemarks();
            this.setLocation(this.points[0]);
        });
    }

    createMapOptions() {
        return {
            center: this.getLocation(this.points[0]),
            zoom: this.zoom,
            controls: ['fullscreenControl', 'geolocationControl'],
        }
    }

    createPlacemarks() {
        this.points.forEach(point => {
            this.map?.geoObjects.add(
                new ymaps.Placemark(
                    this.getLocation(point),
                    {
                        balloonContent: this.makeBalloonContent(point)
                    },
                    {
                        iconColor: '#004989'
                    }
                )
            )
        })
    }

    makeBalloonContent(point) {
        let html = `Адрес: <b>${point.NAME}</b><br/><br/>`;
        const schedule = point.PROPERTIES.SCHEDULE.VALUE.TEXT;
        if (schedule) {
            html += `Режим работы: <span>${schedule}</span>`
        }
        return html;
    }

    getLocation(point) {
        return [point.PROPERTIES.LATITUDE.VALUE, point.PROPERTIES.LONGITUDE.VALUE];
    }

    setLocation(point) {
        this.map?.setCenter(this.getLocation(point), this.zoom);
    }

}