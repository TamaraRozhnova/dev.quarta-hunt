window.addEventListener('DOMContentLoaded', () => {
    const desktopSectionsBlock = document.querySelector('.subcategory-selector__container--desktop');
    const showMoreButton = document.querySelector('.subcategory-selector__more');

    const isOverflown =
        desktopSectionsBlock.scrollHeight > desktopSectionsBlock.clientHeight
        || desktopSectionsBlock.scrollWidth > desktopSectionsBlock.clientWidth;

    if (!isOverflown) {
        showMoreButton.style.display = 'none';
    }

    showMoreButton.addEventListener('click', () => {
        desktopSectionsBlock.classList.add('subcategory-selector__container--more');
        showMoreButton.style.display = 'none';
    });
});