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

    const headerDesktop = document.querySelector('.header--desktop');

    if (window.innerWidth > 1200) {
        window.addEventListener('scroll', function() {

            if (window.scrollY > 50) {

                if (document.querySelector('.modal-overlay') != null) {
                    return false;
                }
    
                if (
                    document.documentElement.scrollTop > headerDesktop.offsetHeight + 50 
                    && headerDesktop.style.position == 'initial' 
                    || headerDesktop.style.position == ''
                ) {
                    headerDesktop.style.transform = 'translateY(-100%)'
    
                    setTimeout(() => {
                        headerDesktop.style.position = 'sticky';
                        headerDesktop.style.transform = 'initial'
                    }, 250);
                    
                }
                
            } 
    
            if (document.documentElement.scrollTop < headerDesktop.offsetHeight - 100) {
                headerDesktop.style.position = 'initial';
            }
    
        })
    }



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
        button.addEventListener('click', (e) => {
            if (e.target.classList.contains('expand')) {
                category.classList.remove('catalog-category-mobile--expanded');
                e.target.classList.remove('expand')

                let children = e.target.nextSibling;
                if (children) {
                    children.nextSibling.style.display = 'block';
                }

                e.preventDefault();
            } else {
                category.classList.toggle('catalog-category-mobile--expanded');
                e.target.classList.toggle('expand')

                let children = e.target.nextSibling;
                if (children) {
                    children.nextSibling.style.display = 'none';
                }

                e.preventDefault();
            }
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