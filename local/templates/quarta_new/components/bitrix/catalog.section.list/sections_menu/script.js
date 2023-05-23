(function () {
    window.addEventListener('DOMContentLoaded', () => {
        class CatalogMenu {
            constructor(sections) {
                this.sections = sections;
                this.mainElement = document.querySelector('.header-categories');
                this.mainCatalogElements = document.querySelectorAll('.header-nav-item:not(.non-dropmenu)');
                this.levelMenu = 1;
                this.initMenuContainerObject();
                this.hangEvents();
            }

            hangEvents() {
               this.hangMouseEvents();
               this.hangResizeEvent();
            }

            hangResizeEvent() {
                window.addEventListener('resize', () => {
                    clearTimeout(this.lastResizeHandling);
                    this.lastResizeHandling = setTimeout(() => {
                        const rect = this.mainElement.getBoundingClientRect();
                        const windowWidth = window.innerWidth;

                        window.catalogMenuContainer = {
                            width: rect.width,
                            left: rect.left,
                            right: windowWidth - rect.left - rect.width
                        }
                    }, 250);
                });
            }

            hangMouseEvents() {
                this.mainCatalogElements.forEach(element => {
                    element.addEventListener('mouseenter', () => {
                        const sectionId = element.dataset.id;
                        if (!sectionId) {
                            new DropDownMenu({element, sections: this.sections, level: this.levelMenu});
                            return;
                        }
                        const subsections = this.sections[sectionId].SUBSECTIONS;

                        const sortedSubsections = Object.values(subsections).sort((a, b) => a.SORT - b.SORT);

                        if (!subsections) {
                            return;
                        }
                        new DropDownMenu({element, sections: sortedSubsections, level: this.levelMenu});
                    });

                    element.addEventListener('mouseleave', () => {
                        const dropDownElement = element.querySelector('.nav-dropdown__wrapper');
                        dropDownElement.remove();
                    });
                });
            }

            initMenuContainerObject() {
                window.catalogMenuContainer = {
                    width: 0,
                    left: 0,
                    right: 0
                }
            }
        }

        new CatalogMenu(window.catalogListMenu);
    })
})()

