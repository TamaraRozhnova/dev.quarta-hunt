/**
 * Работа со всплывающими окнами
 */
class Popup {
  show = function (element) {
    element.style.display = "block";
  };

  hide = function (element) {
    element.closest(".popup").style.display = "none";
  };
}

document.addEventListener("DOMContentLoaded", function () {
  let popup = new Popup();

  /**
   * Показать куки
   */
  let cookiePopup = document.querySelector(".cookie-popup");
  let isCookieShowen = localStorage.getItem("cookieShowen");

  if (cookiePopup && isCookieShowen != "Y") {
    setTimeout(() => {
      popup.show(cookiePopup);
      localStorage.setItem("cookieShowen", "Y");
    }, 3000);
  }

  /**
   * Отслеживание скролла
   */
  window.addEventListener("scroll", function () {
    const scrollPosition = window.scrollY;
    if (scrollPosition > 50) {
      document.querySelector("body").classList.add("scrolled");
    } else {
      document.querySelector("body").classList.remove("scrolled");
    }
  });
});
