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
  menuParents = this.menuElement.querySelectorAll(".is-parent");
  menuOpener = document.querySelector(".catalog-opener");
  mobileMenuOpener = document.querySelector(".menu-toggler");
  mobileMenuCloser = document.querySelector(".mobile-menu-toggler");
  menuOverlay = document.querySelector(".menu__overlay");
  menuMobileCloseChild = document.querySelectorAll(".parent-back");

  constructor() {
    this.menuOpener.addEventListener("click", (evt) => {
      evt.preventDefault();
      this.menuHandler();
    });

    this.mobileMenuOpener.addEventListener("click", (evt) => {
      evt.preventDefault();
      this.menuHandler();
    });

    this.menuOverlay.addEventListener("click", () => {
      this.hide();
    });

    this.mobileMenuCloser.addEventListener("click", () => {
      this.hide();
    });

    if (window.innerWidth < 1025) {
      if (this.menuParents.length) {
        this.menuParents.forEach((element) => {
          element.addEventListener("click", (evt) => {
            evt.preventDefault();
            evt.target.classList.add("opened");
            evt.target.closest("li").classList.add("opened");
          });
        });
      }

      if (this.menuMobileCloseChild.length) {
        this.menuMobileCloseChild.forEach((element) => {
          element.addEventListener("click", (evt) => {
            evt.preventDefault();
            evt.stopPropagation();
            evt.target.closest(".is-parent").classList.remove("opened");
            evt.target.closest("li").classList.remove("opened");
          });
        });
      }
    }
  }

  menuHandler = function () {
    if (this.menuElement.classList.contains("showen")) {
      this.hide();
    } else {
      this.show();
    }
  };

  show = function () {
    this.menuElement.classList.add("showen");
    this.menuOpener.classList.add("showen");
    this.menuElement.style.display = "block";
    this.menuOverlay.style.display = "block";
  };

  hide = function () {
    this.menuElement.classList.remove("showen");
    this.menuOpener.classList.remove("showen");
    this.menuElement.style.display = "none";
    this.menuOverlay.style.display = "none";
  };
}

document.addEventListener("DOMContentLoaded", function () {
  let menuHandler = new MenuHandler();
});
