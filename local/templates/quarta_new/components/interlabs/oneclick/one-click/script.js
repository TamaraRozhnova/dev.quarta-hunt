"use strict";

let isMultiAccountsElement = "";
let isMultiAccountsIdElement = "";
let isMultiAccounts = "";
let captchaElement = "";
let objModal = "";

/**
 * Слушаем событие на клик по закрытию модального окна
 * об успешном заказе через 1 клик
 */
document.addEventListener('click', (e) => {
  const classTarget = '.success-oneclick .js-interlabs-oneclick__dialog__close'
  const target = e.target

  if (target.closest(classTarget)) {
    window.location.reload()
  }
  
})

function interlabsOneClickComponentApp() {

  /** Поле телефон */
  const phoneInput = new Input({
    wrapperSelector: '.phone-wrapper-click',
    required: true,
    validMask: /^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/,
    mask: '+7 (###) ###-##-##',
    errorMessage: 'Введите телефон в корректном формате'
  });

  /** Поле почта */
  const emailInput = new Input({
    wrapperSelector: '.email-wrapper-click',
    required: true,
    validMask: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
    errorMessage: 'Введите email в корректном формате'
  });

  let oneClickForms = document.querySelectorAll(
    ".interlabs-oneclick__container form"
  );

  oneClickForms.forEach((element) => {

    if (!element.dataset.hasSubmitListener) {

      element.addEventListener("submit", function (evt) {

        // Перед отправкой формы ищем одинаковых пользователей
        let isCaptcha = false;
        if (element.querySelector('input[name="captcha_sid"]')) {
          isCaptcha = true;
        }
        isMultiAccountsElement = element.querySelector('input[name="MULTIUSER"]');
        isMultiAccountsIdElement = element.querySelector(
          'input[name="MULTIUSER_ID"]'
        );
        isMultiAccounts = isMultiAccountsElement.value;
        if (isMultiAccounts == "") {
          evt.preventDefault();
          let dataSend = {
            USER: {
              PERSONAL_PHONE: element.querySelector('input[name="PHONE"]').value,
            },
            IS_BYU_ONE_CLICK: "true",
          };

          /**
           * Добавляем поле с сессией
           */

          // if (!element.querySelector(`[name = 'sessid']`)) {

          let nodeInputSessid = document.createElement('input')

          nodeInputSessid.type = 'hidden'
          nodeInputSessid.name = 'sessid'
          nodeInputSessid.value = BX.bitrix_sessid()

          element.appendChild(
            nodeInputSessid
          )

          // }

          dataSend.sessid = element.querySelector('input[name="sessid"]').value;

          if (isCaptcha) {
            dataSend.captcha = $(element).serialize();
            dataSend.captcha_sid = element.querySelector(
              'input[name="captcha_sid"]'
            ).value;
          }

          if (!phoneInput.isValidValue()) {
            evt.preventDefault();
            phoneInput.setError()
            return false
          }

          if (!emailInput.isValidValue()) {
            evt.preventDefault();
            emailInput.setError()
            return false
          }

          BX.ajax({
            method: "POST",
            data: dataSend,
            url: "/local/templates/quarta_new/components/bitrix/system.auth.authorize/flat/ajax.php",
            dataType: "json",
            onsuccess: function (data) {

              if (data?.MULTI_USER == "Y") {
                initModalMultiUser(data, element);
              } else if (data?.captcha_error) {
                document.querySelector(
                  "#interlabs-oneclick__container .errors.common"
                ).textContent = data.message;
              } else {
                isMultiAccountsElement.value = "N";
                element.submit();
              }

            },
          });
        }
      });

    }

    element.dataset.hasSubmitListener = 'true';


  });

  $(".interlabs-oneclick__container").each(function () {
    var dialog = $(this);
    /**
     * Close action
     */
    dialog
      .find(
        ".js-interlabs-oneclick__dialog__close, .js-interlabs-oneclick__dialog__cancel-button"
      )
      .off("click")
      .on("click", function () {
        dialog.hide();
      });
  });
  /**
   * open dialog
   */
  $(".interlabs-one-click-buy").on("click", function () {
    var buttonEl = $(this);

    var productId = buttonEl.data("productid");
    var dialog = $(".interlabs-oneclick__container");

    dialog.find("input[name='PRODUCT_ID']").val(productId);
    dialog.find(".js-interlabs-oneclick__dialog__send-button").show();
    dialog.find(".js-interlabs-oneclick__result").html("");
    dialog.find(".error").html("");
    dialog.find('.js-step-1 textarea[name="comment"]').val("");
    dialog.find(".js-step-1").show();
    dialog.find(".js-step-2").hide();
    dialog.find(".js-interlabs-oneclick__dialog__send-button").show();

    /**
     * Close action
     */
    dialog
      .find(
        ".js-interlabs-oneclick__dialog__close, .js-interlabs-oneclick__dialog__cancel-button"
      )
      .off("click")
      .on("click", function () {
        dialog.hide();
      });
    dialog.show();
  });

  // Маска для телефона

  // if ($("#click_phone").length != 0) {
  //   $("#click_phone").inputmask({ mask: "+7 (999) 999-99-99" });
  // }

  // const phoneInput = document.querySelector("#click_phone");

  // if (phoneInput !== null) {
  //   phoneInput.addEventListener("paste", (event) => {
  //     clipboardData = event.clipboardData || window.clipboardData;

  //     pastedData = clipboardData.getData("Text");

  //     if (pastedData.match(/\d+/g) != null) {
  //       let modifyResult = pastedData.match(/\d+/g).join("");

  //       if (modifyResult.length == 11) {
  //         phoneInput.value = modifyResult.substring(1);
  //       }
  //     }
  //   });
  // }
}

function initModalMultiUser(data, element) {
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

    handleMultiAccounts(data.USERS, element);

    objModal = new Modal({
      modalSelector: "#multi-accounts-window",
    });

    objModal.open();
  }
}

function handleMultiAccounts(data, element) {
  document.addEventListener("click", (event) => {
    if (event.target.closest(".multi-accounts-content-item") != null) {
      let currentItem = event.target.closest(".multi-accounts-content-item");
      let currentItemData = data[currentItem.dataset.index];
      isMultiAccountsElement.value = "Y";
      isMultiAccountsIdElement.value = currentItemData.ID;
      objModal.close();
      element.submit();
    }
  });
}

$(document).ready(function () {
  interlabsOneClickComponentApp();
});
//# sourceMappingURL=script.js.map
