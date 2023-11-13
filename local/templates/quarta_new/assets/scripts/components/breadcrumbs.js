class Breadcrumbs {
  constructor(params = {}) {
    this.body = document.querySelector("body");
    this.dots = document.querySelector(".breadcrumbs__dots");
    this.blackBg = document.querySelector(".black-bg");
    this.breadPopup = document.querySelector(".breadcrumb__popup");
    if (this.breadPopup) {
      this.cross = this.breadPopup.querySelector(".cross");
    }

    this.bindEvents();
  }

  bindEvents() {
    this.openBreadPopup();
    this.closeBreadPopup();
    this.closeBreadPopupOnBack();
  }

  openBreadPopupHandler() {
    this.breadPopup.classList.add("open");
    this.body.classList.add("stop-scrolling-bread");
    this.blackBg.style.display = "block";
  }

  closeBreadPopupHandler() {
    this.breadPopup.classList.remove("open");
    this.body.classList.remove("stop-scrolling-bread");
    this.blackBg.style.display = "none";
  }

  openBreadPopup() {
    if (this.dots) {
      this.dots.addEventListener(
        "click",
        this.openBreadPopupHandler.bind(this),
        false
      );
    }
  }

  closeBreadPopupOnBack() {
    if (this.blackBg) {
      this.blackBg.addEventListener(
        "click",
        this.closeBreadPopupHandler.bind(this),
        false
      );
    }
  }

  closeBreadPopup() {
    if (this.cross) {
      this.cross.addEventListener(
        "click",
        this.closeBreadPopupHandler.bind(this),
        false
      );
    }
  }
}

window.addEventListener("DOMContentLoaded", () => {
  if (window.innerWidth < 500) {
    new Breadcrumbs();
  }
});
