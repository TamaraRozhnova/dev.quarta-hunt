class DescriptionBlock {
    constructor() {
        this.descriptionWrapper = document.querySelector('.product-description__wrapper');
        this.descriptionTextBlock = this.descriptionWrapper.querySelector('.product-description');
        this.descriptionMore = this.descriptionWrapper.querySelector('.product-description__more');
        this.descriptionMoreButton = this.descriptionMore.querySelector('a');

        this.calculateHeightDescriptionBlock();
        this.makeDescriptionBlock();
    }

    makeDescriptionBlock() {
        let openedDescriptionBlock = false;
        this.descriptionMoreButton.addEventListener('click', () => {
            if (openedDescriptionBlock) {
                this.descriptionWrapper.classList.remove('product-description__wrapper--show-more');
                openedDescriptionBlock = false;
                this.descriptionMoreButton.textContent = 'Еще...';
            } else {
                this.descriptionWrapper.classList.add('product-description__wrapper--show-more');
                openedDescriptionBlock = true;
                this.descriptionMoreButton.textContent = 'Свернуть';
            }
        });
    }

    calculateHeightDescriptionBlock() {
        if (this.calculateTimeout) {
            clearTimeout(this.calculateTimeout);
        }
        this.calculateTimeout = setTimeout(() => {
            const wrapperHeight = this.descriptionWrapper.getBoundingClientRect().height;
            let height = this.descriptionTextBlock.getBoundingClientRect().height;
            this.descriptionWrapper.querySelectorAll('table').forEach( (el) => {
                height += el.getBoundingClientRect().height;
            });
            if (height > wrapperHeight) {
                this.descriptionMore.style.display = 'flex';
            }
        }, 500);
    }
}