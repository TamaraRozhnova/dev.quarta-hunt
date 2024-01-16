"use strict";

let oneClickForms = document.querySelectorAll(
  ".interlabs-oneclick__container form"
);
let isMultiAccountsElement = "";
let isMultiAccountsIdElement = "";
let isMultiAccounts = "";
let captchaElement = "";
let objModal = "";

function interlabsOneClickComponentApp() {
  oneClickForms.forEach((element) => {
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

        dataSend.sessid = element.querySelector('input[name="sessid"]').value;

        if (isCaptcha) {
          dataSend.captcha = $(element).serialize();
          dataSend.captcha_sid = element.querySelector(
            'input[name="captcha_sid"]'
          ).value;
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

  if ($("#click_phone").length != 0) {
    $("#click_phone").inputmask({ mask: "+7 (999) 999-99-99" });
  }

  const phoneInput = document.querySelector("#click_phone");

  if (phoneInput !== null) {
    phoneInput.addEventListener("paste", (event) => {
      clipboardData = event.clipboardData || window.clipboardData;

      pastedData = clipboardData.getData("Text");

      if (pastedData.match(/\d+/g) != null) {
        let modifyResult = pastedData.match(/\d+/g).join("");

        if (modifyResult.length == 11) {
          phoneInput.value = modifyResult.substring(1);
        }
      }
    });
  }
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
