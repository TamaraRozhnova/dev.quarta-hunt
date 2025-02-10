document.addEventListener('click', function(event) {
    // Проверяем, является ли клик по элементу с классом nav-catalog-cont2__tab и без класса active
    if (event.target.classList.contains('nav-catalog-cont2__tab') && !event.target.classList.contains('active')) {
        var cat_id = event.target.getAttribute('data-id');

        // Удаляем класс active у текущего активного элемента
        var activeTab = document.querySelector('.nav-catalog-cont2__tab_cont.active');
        if (activeTab) {
            activeTab.classList.remove('active');
        }
        var activeTabLink = document.querySelectorAll('.nav-catalog-cont2__tab.active');
        for (let elem of activeTabLink) {
            if (elem) {
                elem.classList.remove('active');
            }
        }


        // Добавляем класс active к текущему табу
        event.target.classList.add('active');


        var tabContent = document.querySelector('.nav-catalog-cont2__tab_cont.tab_cont_' + cat_id);
        if (tabContent) {
            tabContent.classList.add('active');
        }
    }
});