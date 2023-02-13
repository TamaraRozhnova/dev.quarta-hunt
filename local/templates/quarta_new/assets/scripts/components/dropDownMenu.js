class DropDownMenu {
    dropDown;
    dropdownItems;
    width = 0;
    height = 0;
    shift = 0;

    constructor(data = {element, sections, level, minHeight: 0}) {
        this.element = data.element;
        this.sections = data.sections;
        this.level = data.level;
        this.minHeight = data.minHeight;

        this.render();
        this.makeActionsAfterRender();
    }

    makeActionsAfterRender() {
        this.getNewElements();
        this.calculateShift();
        this.setExtraStyles();
        this.hydrateDropDown();
        this.hydrateElements();
    }

    getNewElements() {
        this.dropDown = this.element.querySelector('.nav-dropdown');
        this.dropdownItems = this.dropDown.querySelectorAll('.header-nav-item');
    }

    hydrateDropDown() {
        const list = this.dropDown.querySelector('ul');
        new PerfectScrollbar(list);
    }

    hydrateElements() {
        this.dropdownItems.forEach(item => {
            const sectionId = item.dataset.id;
            const subsections = this.sections[sectionId].SUBSECTIONS;

            item.addEventListener('mouseenter', () => {
                const oldDropDown = this.dropDown.querySelector('.nav-dropdown__wrapper');
                if (oldDropDown) {
                    oldDropDown.remove();
                }
                if (!sectionId || !subsections) {
                    return;
                }
                new DropDownMenu({
                    element: this.dropDown,
                    sections: subsections,
                    level: this.level + 1,
                    minHeight: this.height
                });
            });
        })
    }

    render() {
        this.element.insertAdjacentHTML('beforeend', this.getHtml());
    }

    getHtml() {
        return (
            `<div class="nav-dropdown__wrapper">
                <div class="nav-dropdown ${this.isOddLevel() && ' nav-dropdown--odd'}">
                    <ul>
                        ${this.getMenuItemsHtml()}
                    </ul>
                </div>
            </div>`
        );
    }

    getMenuItemsHtml() {
        return Object.keys(this.sections).map(key => {
            const { NAME, LINK } = this.sections[key];
            return (
                `<li>
                    <div class="header-nav-item" data-id="${key}">
                        <a href="${LINK}">
                            <span>${NAME}</span>
                        </a>
                    </div>
                </li>`
            );
        }).join('');
    }

    setExtraStyles() {
        const haveEnoughSpace = this.width / 4 > -this.shift;
        const styles = {};

        if (this.minHeight) {
            styles.minHeight = `${this.minHeight}px`
        }
        if (this.shift < 0) {
            styles.transform = `translateX(-200%)`;
        }
        if (this.shift < 0 && (this.level <= 1 || haveEnoughSpace)) {
            styles.transform = `translateX(${this.shift}px)`;
        }

        this.dropDown.style.transform = styles.transform;
        this.dropDown.style.minHeight = styles.minHeight;
    }

    calculateShift() {
        const rect = this.dropDown.getBoundingClientRect();
        this.width = rect.width;
        this.height = rect.height;
        const right = window.innerWidth - rect.right;
        this.shift = right - window.catalogMenuContainer.right;
    }

    isOddLevel() {
        return this.level % 2 !== 0;
    }

}