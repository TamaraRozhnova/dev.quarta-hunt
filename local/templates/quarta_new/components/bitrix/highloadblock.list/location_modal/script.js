(function () {
    window.addEventListener('DOMContentLoaded', () => {
        class LocationModal extends Modal {
            COOKIE_LOCATION_NAME = 'location';

            constructor(modalOpenElementSelector, modalSelector = '.modal') {
                super(modalOpenElementSelector, modalSelector);
                this.cityElements = document.querySelectorAll('.modal-location__item');
                this.openModalElementText = this.openModalElement.querySelector('span');

                this.setLocation();
                this.hangEvents();
            }

            hangEvents() {
                this.searchInput = new Input('#location-search', {
                    onChange: () => this.searchLocation(),
                    onClear: () => this.displayAllLocations()
                });

                this.cityElements.forEach(element => {
                    element.addEventListener('click', () => {
                        super.close();
                        this.selectLocation(element);
                    });
                });
            }

            onClose() {
                this.searchInput.clear();
                this.displayAllLocations();
            }

            setLocation() {
                if (!this.cityElements.length) {
                    return;
                }
                const cookie = Cookies.get(this.COOKIE_LOCATION_NAME);
                if (!cookie) {
                    this.selectLocation(this.cityElements[0]);
                    return;
                }
                const location = JSON.parse(Cookies.get(this.COOKIE_LOCATION_NAME));
                this.openModalElementText.textContent = location.name;
                this.markCurrentLocation(location.code);
            }

            selectLocation(element) {
                const { code, name } = element.dataset;
                this.setCookieAndTextLocation(code, name);
                this.markCurrentLocation(code);
            }

            setCookieAndTextLocation(locationCode, locationName) {
                Cookies.set(this.COOKIE_LOCATION_NAME, JSON.stringify({ code: locationCode, name: locationName }));
                this.openModalElementText.textContent = locationName;
            }

            markCurrentLocation(locationCode) {
                this.cityElements.forEach(element => {
                    if (element.dataset.code === locationCode) {
                        element.classList.add('modal-location__item--current');
                        return;
                    }
                    element.classList.remove('modal-location__item--current');
                })
            }

            searchLocation() {
                const searchText = this.searchInput.getValue();
                if (!searchText) {
                    this.displayAllLocations();
                    return;
                }
                this.cityElements.forEach(element => {
                    if (element.dataset.name.toUpperCase().indexOf(searchText.toUpperCase()) === -1) {
                        element.style.display = 'none';
                        return;
                    }
                    element.style.display = 'block';
                })
            }

            displayAllLocations() {
                this.cityElements.forEach(element => {
                    element.style.display = 'block';
                })
            }
        }

        new LocationModal('.header__city');
    })
})();