var jshover = function () {
  var menuDiv = document.getElementById("horizontal-catalog-menu");
  if (!menuDiv) return;

  var sfEls = menuDiv.getElementsByTagName("li");
  for (var i = 0; i < sfEls.length; i++) {
    sfEls[i].onmouseover = function () {
      this.className += " jshover";
    };
    sfEls[i].onmouseout = function () {
      this.className = this.className.replace(new RegExp(" jshover\\b"), "");
    };
  }
};

if (window.attachEvent) window.attachEvent("onload", jshover);

/**
 * Работа с меню
 */
class MenuHandler {
  menuElement = document.querySelector(".menu__catalog");
  menuOpener = document.querySelector(".catalog-opener");

  constructor() {
    this.menuOpener.addEventListener("click", (evt) => {
      evt.preventDefault();
      if (this.menuElement.classList.contains("showen")) {
        this.hide();
      } else {
        this.show();
      }
    });
  }

  show = function () {
    this.menuElement.classList.add("showen");
    this.menuOpener.classList.add("showen");
    this.menuElement.style.display = "block";
  };

  hide = function () {
    this.menuElement.classList.remove("showen");
    this.menuOpener.classList.remove("showen");
    this.menuElement.style.display = "none";
  };
}

document.addEventListener("DOMContentLoaded", function () {
  let menuHandler = new MenuHandler();
});
