'use strict';

function interlabsOneClickComponentApp() {

    $('.interlabs-oneclick__container').each(function () {
        var dialog = $(this);
        /**
         * Close action
         */
        dialog.find('.js-interlabs-oneclick__dialog__close, .js-interlabs-oneclick__dialog__cancel-button').off('click').on('click', function () {
            dialog.hide();
        });
    });
    /**
     * open dialog
     */
    $('.interlabs-one-click-buy').on('click', function () {
        var buttonEl = $(this);

        var productId = buttonEl.data('productid');
        var dialog = $('#interlabs-oneclick__container-' + productId);

        dialog.find('.js-interlabs-oneclick__dialog__send-button').show();
        dialog.find('.js-interlabs-oneclick__result').html('');
        dialog.find('.error').html('');
        dialog.find('.js-step-1 textarea[name="comment"]').val('');
        dialog.find('.js-step-1').show();
        dialog.find('.js-step-2').hide();
        dialog.find('.js-interlabs-oneclick__dialog__send-button').show();

        /**
         * Close action
         */
        dialog.find('.js-interlabs-oneclick__dialog__close, .js-interlabs-oneclick__dialog__cancel-button').off('click').on('click', function () {
            dialog.hide();
        });
        dialog.show();
    });
}

$(document).ready(function () {
    interlabsOneClickComponentApp();
});
//# sourceMappingURL=script.js.map
