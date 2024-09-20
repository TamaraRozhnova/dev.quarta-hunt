$(document).ready(function () {
  /**
   * Validation fields for registration
   */

  const phoneReg = new Input({
    wrapperSelector: `.re-phone-reg`,
    required: true,
    validMask: /^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/,
    mask: "+7 (###) ###-##-##",
    errorMessage: "Телефон должен быть в указанном формате",
  });

  const nameReg = new Input({
    wrapperSelector: `.re-name-reg`,
    required: true,
    errorMessage: "Поле обязательно к заполнению",
  });

  const lastNameReg = new Input({
    wrapperSelector: `.re-last-name-reg`,
    required: true,
    errorMessage: "Поле обязательно к заполнению",
  });

  const emailReg = new Input({
    wrapperSelector: `.re-email-reg`,
    required: true,
    validMask: /^([a-z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/,
    errorMessage: "Введите email в корректном формате",
  });

  const passReg = new Input({
    wrapperSelector: `.re-pass-reg`,
    required: true,
    errorMessage: "Поле обязательно к заполнению",
  });

  const confPassReg = new Input({
    wrapperSelector: `.re-conf-pass-reg`,
    required: true,
    errorMessage: "Поле обязательно к заполнению",
  });

  const regReqFields = [
    phoneReg,
    nameReg,
    lastNameReg,
    emailReg,
    passReg,
    confPassReg,
  ];

  $(".reg-submit-form").on("click", (e) => {
    regReqFields.forEach((field) => {
      if (!field.isValidValue()) {
        field.setError();
        e.preventDefault();
      }
    });
  });

  if ($(".reg-phone-input").length != 0) {
    $(".reg-phone-input").inputmask({ mask: "+7 (999) 999-99-99" });
    $(".reg-phone-input").val("");
  }

  $(".reg__back.button.button-secondary").on("click", function (e) {
    e.preventDefault();
    $("#auth").modal({
      closeExisting: true,
    });
  });

  const regPhoneInput = document.querySelector(".reg-phone-input");

  if (regPhoneInput !== null) {
    regPhoneInput.addEventListener("paste", (event) => {
      clipboardData = event.clipboardData || window.clipboardData;

      pastedData = clipboardData.getData("Text");

      if (pastedData.match(/\d+/g) != null) {
        let modifyResult = pastedData.match(/\d+/g).join("");

        if (modifyResult.length == 11) {
          regPhoneInput.value = modifyResult.substring(1);
        }
      }
    });
  }

  $(".password-eye").on("click", function () {
    showPassword(this);
    $(this).toggleClass("active");
  });

  function showPassword(node) {
    inputPass = $(node).siblings("input");
    if ($(node).hasClass("active")) {
      inputPass.prop("type", "password");
    } else {
      inputPass.prop("type", "text");
    }
  }
});
