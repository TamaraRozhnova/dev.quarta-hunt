window.addEventListener("load", (e) => {
  /** Validation fields for login */

  const phoneLogin = new Input({
    wrapperSelector: "#form_auth_phone .phone",
    required: true,
    validMask: /^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/,
    mask: "+7 (###) ###-##-##",
    errorMessage: "Телефон должен быть в указанном формате",
  });

  const emailLogin = new Input({
    wrapperSelector: ".au-email-login",
    required: true,
    validMask: /^([a-zA-Z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/,
    errorMessage: "Введите email в корректном формате",
  });

  const emailPassword = new Input({
    wrapperSelector: ".au-email-password",
    required: true,
    errorMessage: "Поле обязательно к заполнению",
  });

  /** Validation email login */

  $(".au-email-login-btn input").on("click", (e) => {
    if (!emailLogin.isValidValue()) {
      emailLogin.setError();
      e.preventDefault();
    }

    if (!emailPassword.isValidValue()) {
      emailPassword.setError();
      e.preventDefault();
    }
  });

  if (document.querySelector(".phone-input")) {
    $(".phone-input").inputmask({ mask: "+7 (999) 999-99-99" });
  }

  const authPhoneInput = document.querySelector(".phone-input");

  if (authPhoneInput !== null) {
    authPhoneInput.addEventListener("paste", (event) => {
      clipboardData = event.clipboardData || window.clipboardData;

      pastedData = clipboardData.getData("Text");

      if (pastedData.match(/\d+/g) != null) {
        let modifyResult = pastedData.match(/\d+/g).join("");

        if (modifyResult.length == 11) {
          authPhoneInput.value = modifyResult.substring(1);
        }
      }
    });
  }

  $(".auth_email_form").on("click", function (e) {
    e.preventDefault();
    $("#form_auth_phone").hide();
    $(".auth_email_form").hide();
    $("#form_auth").show();
    $(".foggot_pass").show();
    $(".auth_phone_form").show();
  });
  $(".auth_phone_form").on("click", function (e) {
    e.preventDefault();
    $("#form_auth_phone").show();
    $(".auth_email_form").show();
    $("#form_auth").hide();
    $(".foggot_pass").hide();
    $(".auth_phone_form").hide();
  });

  $(".form_auth_phone").on("click", function (e) {
    e.preventDefault();

    /**
     * Если телефон введен
     * корректно по маске, то пропускаем
     */
    if (phoneLogin.isValidValue()) {
      authPhone(null, true);
    } else {
      phoneLogin.setError();
    }
  });

  $(".more_code_phone").on("click", function (e) {
    e.preventDefault();
    authPhone(null, false);
  });

  $(".login_auth_phone").on("click", function (e) {
    e.preventDefault();

    if ($(`[name='CODE']`).is(":visible")) {
      if ($(`[name='CODE']`).val().trim() == "") {
        return;
      }
    }

    authPhone(null, false);
  });

  $(".button.button-secondary.reg").on("click", function (e) {
    e.preventDefault();
    $("#reg").modal({
      closeExisting: true,
    });
  });

  let objModal = "",
    userSelected = null,
    userData;

  function initModalMultiUser(data) {
    if (data.USERS) {
      let hmtlModalListAccounts = "";
      const multiAccountsWindow = document.querySelector(
        "#multi-accounts-window"
      );
      const multiAccountsWindowList = multiAccountsWindow.querySelector(
        ".multi-accounts-content-list"
      );

      data.USERS.forEach((element, index) => {
        hmtlModalListAccounts += `
				<div data-index = "${index}" class="multi-accounts-content-item">
					<div class="multi-accounts-content-item-name-type">
						<span class = "multi-accounts-content-item-name">
							${element?.NAME_DISPLAY}
						</span>
						<span class = "multi-accounts-content-item-type">
							${element?.TYPE_DISPLAY}
						</span>
					</div>
					<span class = "multi-accounts-content-item-email">
						${element?.EMAIL}
					</span>
				</div>
			`;
      });

      if (hmtlModalListAccounts != "" && hmtlModalListAccounts != null) {
        multiAccountsWindowList.innerHTML = hmtlModalListAccounts;
      }

      handleMultiAccounts(data.USERS);

      objModal = new Modal({
        modalSelector: "#multi-accounts-window",
      });

      objModal.open();
    }
  }

  function initModalQuickRegister(data) {
    const modalQuickRegister = document.querySelector("#quick-register-window");

    const objModalQuickRegister = new Modal({
      modalSelector: "#quick-register-window",
    });

    handleQuickRegister(data, modalQuickRegister);

    objModalQuickRegister.open();
  }

  function comparePassword(password, confirmPassword) {
    if (password.value.trim() == "") {
      return false;
    }

    if (confirmPassword.value.trim() == "") {
      return false;
    }

    if (password.value.trim() !== confirmPassword.value.trim()) {
      return false;
    }

    return true;
  }

  function handleQuickRegister(data, modalNode) {
    const btnQuickRegister = document.querySelector(".form_quick_register");

    if (btnQuickRegister != null) {
      const nameQr = new Input({
        wrapperSelector: ".reg-name-qr",
        required: true,
        errorMessage: "Поле обязательно к заполнению",
      });

      const lastNameQr = new Input({
        wrapperSelector: ".reg-last-name-qr",
        required: true,
        errorMessage: "Поле обязательно к заполнению",
      });

      const codeQr = new Input({
        wrapperSelector: ".reg-code-qr",
        required: true,
        errorMessage: "Поле обязательно к заполнению",
      });

      const reqFieldsQr = [nameQr, lastNameQr, codeQr];

      btnQuickRegister.addEventListener("click", (e) => {
        e.preventDefault();

        const inputsModal = [];

        modalNode
          .querySelectorAll("input[type=text], input[type=password]")
          .forEach((input) => {
            inputsModal[input.name] = input.value.trim();
          });

        reqFieldsQr.forEach((field) => {
          if (!field.isValidValue()) {
            field.setError();
          }
        });

        if (modalNode.querySelectorAll("input.is-invalid").length == 0) {
          BX.ajax({
            method: "POST",
            data: {
              FIELDS: inputsModal,
              PROCESS_QUICK_REGISTER: "Y",
              SMS_CODE: data.SMS_CODE,
              PERSONAL_PHONE: data.PERSONAL_PHONE,
              sessid: $('input[name="sessid"]').val(),
            },
            url: "/local/templates/hut/components/bitrix/system.auth.authorize/flat/ajax.php",
            dataType: "json",
            onsuccess: function (data) {
              const modalQuckRegisterMessage = document.querySelector(
                ".quick-register-warning"
              );

              switch (data?.STATUS) {
                case "SUCCESS":
                  modalQuckRegisterMessage.style.display = "none";

                  if (document.referrer.trim() !== "") {
                    window.location.href = document.referrer;
                  } else {
                    location.reload();
                  }

                  break;
                case "ERROR":
                  if (modalQuckRegisterMessage != null) {
                    modalQuckRegisterMessage.innerHTML = data?.ERR;
                  }

                  break;
              }
            },
          });
        }
      });
    }
  }

  function handleMultiAccounts(data) {
    document.addEventListener("click", (event) => {
      if (event.target.closest(".multi-accounts-content-item") != null) {
        let currentItem = event.target.closest(".multi-accounts-content-item");
        let currentItemData = data[currentItem.dataset.index];
        let dataSend = {
          USER: currentItemData,
          USER_SELECTED: "Y",
        };

        userData = dataSend;
        userSelected = "Y";

        authPhone(dataSend);
      }
    });
  }

  function authPhone(data = null, isCaptcha = false) {
    let dataSend;

    if ((data != null && data?.USER_SELECTED) || userSelected == "Y") {
      if (userData?.USER) {
        userData.USER.userCode = $('input[name="CODE"]').val();
        dataSend = userData;
      } else if (data?.USER) {
        data.USER.userCode = $('input[name="CODE"]').val();
        dataSend = data;
      }
    } else {
      dataSend = {
        USER: {
          PERSONAL_PHONE: $('input[name="USER_PHONE"]').val(),
          userCode: $('input[name="CODE"]').val(),
        },
      };
    }

    dataSend.sessid = $('input[name="sessid"]').val();

    if (isCaptcha) {
      dataSend.captcha = $("#form_auth_phone").serialize();
      dataSend.captcha_sid = $('input[name="captcha_sid"]').val();
    }

    BX.ajax({
      method: "POST",
      data: dataSend,
      url: "/local/templates/hut/components/bitrix/system.auth.authorize/flat/ajax.php",
      dataType: "json",
      onsuccess: function (data) {
        if (data?.SHOW_MODAL_QUICK_REGISTER == "Y") {
          /**
           * Быстрая регистрация
           */

          initModalQuickRegister(data);

          return;
        }

        if (data?.MULTI_USER == "Y") {
          /**
           * Несколько аккаунтов
           */

          initModalMultiUser(data);
        } else {
          if (
            typeof objModal != undefined &&
            objModal != null &&
            objModal != ""
          ) {
            objModal.close();
          }

          if (data.error == false) {
            $(".bx-authform-formgroup-container.code").show();
            $(".bx-authform-formgroup-container.phone").hide();
            $(".form_auth_phone").hide();
            $(".login_auth_phone").show();
            $(".more_code_phone").show();
            $(".register-capthca-auth").hide();

            if (data.user) {
              const urlParams = new URLSearchParams(window.location.search);
              if (
                urlParams.has("logout") &&
                urlParams.get("logout") === "yes"
              ) {
                urlParams.delete("logout");
                const newUrl =
                  window.location.origin +
                  window.location.pathname +
                  "?" +
                  urlParams.toString();

                window.location.href = newUrl;
              } else {
                if (document.referrer.trim() !== "") {
                  window.location.href = document.referrer;
                } else {
                  window.location.reload();
                }
              }
            }
          } else if (data?.captcha_error == true) {
            $("input[name='captcha_word'] + .error_message").text(data.message);
          } else {
            if ($("#input_sms_code + .error_message").is(":visible")) {
              $("#input_sms_code + .error_message").text(data.message);
            } else if ($("#phone + .error_message").is(":visible")) {
              $("#phone + .error_message").text(data.message);
            }
          }
        }
      },
    });
  }
});
