window.addEventListener('DOMContentLoaded', () => {
    const shopsWrapper = document.querySelector('.header__spot');
    const shops = shopsWrapper.querySelector('.header__spot-dropdown');
    const shopsButton = shopsWrapper.querySelector('.header__spot > span');

    const categories = document.querySelectorAll('.catalog-category-mobile');

    const mobileHeader = document.querySelector('.mobile-nav');
    const openMobileHeaderButton = document.querySelector('.header__button-mobile');
    const closeMobileHeaderButton = document.querySelector('.mobile-nav__close');

    const contacts = document.querySelector('.header__contacts');
    const contactsButton = document.querySelector('.header__button-contacts');

    const searchInputWrappers = document.querySelectorAll('.header .search-input');

    shopsButton.addEventListener('click', (event) => {
        event.stopPropagation();
        shopsWrapper.classList.toggle('header__spot--show');
    });

    window.addEventListener('click', (event) => {
        if (!shops.contains(event.target)) {
            shopsWrapper.classList.remove('header__spot--show');
        }
    });

    categories.forEach(category => {
        const button = category.querySelector('.catalog-category-mobile__title');
        button.addEventListener('click', () => {
            category.classList.toggle('catalog-category-mobile--expanded');
        })
    });

    openMobileHeaderButton.addEventListener('click', () => {
        mobileHeader.classList.add('mobile-nav--show');
    });

    closeMobileHeaderButton.addEventListener('click', () => {
        mobileHeader.classList.remove('mobile-nav--show');
        contacts.classList.remove('header__contacts--show');
    });

    contactsButton.addEventListener('click', () => {
        contacts.classList.toggle('header__contacts--show');
    });

    searchInputWrappers.forEach(wrapper => {
        const input = wrapper.querySelector('input');
        const buttonSearch = wrapper.querySelector('button');

        input.addEventListener('keyup', (event) => {
            const enterCode = 13;
            if (event.keyCode === enterCode) {
                window.location.href = `/search?q=${input.value}`;
            }
        });
        buttonSearch.addEventListener('click', (event) => {
            event.preventDefault();
            window.location.href = `/search?q=${input.value}`;
        })
    })

})