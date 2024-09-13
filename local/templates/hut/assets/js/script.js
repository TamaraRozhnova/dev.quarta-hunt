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

let popup = new Popup();

document.addEventListener("DOMContentLoaded", function () {
  let cookiePopup = document.querySelector(".cookie-popup");
  let isCookieShowen = localStorage.getItem("cookieShowen");

  /**
   * Показать куки
   */
  if (cookiePopup && isCookieShowen != "Y") {
    setTimeout(() => {
      popup.show(cookiePopup);
      localStorage.setItem("cookieShowen", "Y");
    }, 3000);
  }
});
