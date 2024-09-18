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

class Input {
  constructor(
    e = {
      wrapperSelector: "",
      inputSelector: "",
      initialValue: "",
      debounceTime: 2e3,
      withDebounce: !1,
      required: !1,
      validMask: null,
      mask: null,
      errorMessage: "Поле обязательно для заполнения",
      disabled: !1,
      onChange: (e) => {},
      onClear: () => {},
    }
  ) {
    (this.inputWrapperSelector = e.wrapperSelector),
      (this.inputWrapperElement = document.querySelector(
        this.inputWrapperSelector
      )),
      (this.inputSelector =
        e.inputSelector || this.inputWrapperSelector + " input"),
      (this.inputElement = document.querySelector(this.inputSelector)),
      (this.clearButtonElement = document.querySelector(
        this.inputSelector + " + .input__clear"
      )),
      (this.required = e.required),
      (this.errorMessage = e.errorMessage),
      (this.withDebounce = e.withDebounce),
      (this.debouceTime = e.debounceTime || 2e3),
      (this.validMask = e.validMask),
      (this.onChange = e.onChange),
      (this.onClear = e.onClear),
      this.setMask(e.mask),
      this.setRequired(),
      this.setDisabled(e.disabled),
      this.setInitialValue(e.initialValue),
      this.hangEvents();
  }
  hangEvents() {
    this.handleChange(),
      this.handleClear(),
      this.handleFocus(),
      this.handleBlur();
  }
  setMask(e) {
    e && new Inputmask(e).mask(this.inputSelector);
  }
  setRequired() {
    this.required &&
      this.inputWrapperElement &&
      this.inputWrapperElement.classList.add("input--required");
  }
  getValue() {
    return this.inputElement.value;
  }
  getDataAttribute(e) {
    return this.inputElement.dataset[e];
  }
  setDisabled(e) {
    this.inputElement.disabled = e;
  }
  setInitialValue(e) {
    e && this.setValue(e);
  }
  setValue(e) {
    this.inputElement.value = e;
  }
  clear() {
    this.clearButtonElement && this.clearButtonElement.classList.remove("show"),
      (this.inputElement.value = ""),
      this.onClear && this.onClear();
  }
  handleChange() {
    this.inputElement.addEventListener("input", () => {
      if (
        (this.toggleClearButton(),
        this.debouceTimeout && clearTimeout(this.debouceTimeout),
        this.onChange)
      ) {
        const e = this.getValue();
        this.withDebounce
          ? (this.debouceTimeout = setTimeout(() => {
              this.onChange(e, this);
            }, this.debouceTime))
          : this.onChange(e);
      }
    });
  }
  handleFocus() {
    this.inputElement.addEventListener("focus", () => {
      this.clearError();
    });
  }
  handleBlur() {
    this.inputElement.addEventListener("blur", () => {
      this.isValidValue() || this.setError();
    });
  }
  handleClear() {
    this.clearButtonElement &&
      this.clearButtonElement.addEventListener("click", () => this.clear());
  }
  setError(e) {
    var t;
    this.inputWrapperElement &&
      this.inputWrapperElement.classList.add("is-invalid"),
      this.inputElement.classList.add("is-invalid"),
      document.querySelector(
        this.inputWrapperSelector + " .invalid-feedback"
      ) ||
        ((t = document.createElement("div")).classList.add("invalid-feedback"),
        (t.textContent = e || this.errorMessage),
        this.inputElement.insertAdjacentElement("afterend", t));
  }
  clearError() {
    this.inputElement.classList.remove("is-invalid"),
      this.inputWrapperElement &&
        this.inputWrapperElement.classList.remove("is-invalid");
    var e = document.querySelector(
      this.inputWrapperSelector + " .invalid-feedback"
    );
    e && e.remove();
  }
  isValidValue() {
    var e = this.getValue();
    return !(
      (this.required && !e) ||
      (e && this.validMask && !this.validMask.test(e))
    );
  }
  toggleClearButton() {
    this.clearButtonElement &&
      (this.getValue()
        ? this.clearButtonElement.classList.add("show")
        : this.clearButtonElement.classList.remove("show"));
  }
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
