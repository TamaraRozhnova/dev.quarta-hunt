document.addEventListener("DOMContentLoaded", function(event) {

    /** Функции */
    const fadeIn = (el, timeout, display) => {
        el.style.opacity = 0;
        el.style.display = display || 'block';
        el.style.transition = `opacity ${timeout}ms`;
        setTimeout(() => {
          el.style.opacity = 1;
        }, 10);
    };

    const fadeOut = (el, timeout) => {
        el.style.opacity = 1;
        el.style.transition = `opacity ${timeout}ms`;
        el.style.opacity = 0;
        
        setTimeout(() => {
            el.style.display = 'none';
        }, timeout);
    };

    /** Переменные */
    let arrowUpBtn = document.querySelector(".arrow_to-up");

    /** Обработчики */
    arrowUpBtn.onclick = function() {
        window.scrollTo(0,0);
    }

    document.addEventListener("scroll", function() {
        if (window.pageYOffset > 500) {

            if (arrowUpBtn.style.display != "flex") {
                fadeIn(arrowUpBtn, 250, "flex");
            }

        } else {

            if (arrowUpBtn.style.display == "flex") { 
                fadeOut(arrowUpBtn, 250);
            }
            
        }
    })

});