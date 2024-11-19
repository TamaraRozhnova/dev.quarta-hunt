$( document ).ready(function() {
    $(document).on('input', '.form-control[type="password"]', function () {
        let th = $(this);
        let thWrapper = th.closest('.input');

        removeAllHint(thWrapper);

        if (th.val().length < 6 && th.val().length > 0) {
            createHint(thWrapper, message.ERROR_PASS_LENGTH);
        } else {
            if (this.name === 'NEW_PASSWORD' || this.name === 'NEW_PASSWORD_CONFIRM') {
                let passBlockWrap = th.closest('.cabinet-section__content'),
                    newPassField = passBlockWrap.find('[name="NEW_PASSWORD"]'),
                    confirmPassField = passBlockWrap.find('[name="NEW_PASSWORD_CONFIRM"]'),
                    newPassFieldWrapper = newPassField.closest('.input'),
                    confirmPassFieldWrapper = confirmPassField.closest('.input');

                if (newPassField.val() !== confirmPassField.val() && (newPassField.val().length > 5 || confirmPassField.val().length > 5)) {
                    createHint(newPassFieldWrapper, message.ERROR_PASS_NOT_EQ);
                    createHint(confirmPassFieldWrapper, message.ERROR_PASS_NOT_EQ);
                }
            }
        }
    });
});

function removeAllHint(node) {
    $(node).closest('.cabinet-section__content').find('.main-profile__hint').remove();
}

function createHint(node, title) {
    let hintNode = '<span class="main-profile__hint">' + title + '</span>';
    if (node.prop('tagName') == 'INPUT') {
        node.after(hintNode);
    } else {
        node.append(hintNode);
    }
}
function saveProfileBlock(node) {
    let data = {};

    inputsFieldNode = $(node).closest('.cabinet-section__content');
    inputs = inputsFieldNode.find('input.form-control');

    if (inputs.length) {
        inputs.each(function (i, e) {
            data[e.name] = e.value;
        });
    }

    data['event'] = node.dataset.event;
    
    let editNode = $(node);
    
    ajaxSave(data, editNode);
}

function ajaxSave(data, editNode){
    let node = $(editNode).closest('.cabinet-section__content');

	$.ajax({
        type: 'POST',
        url: params.TEMPLATE_PATH + '/ajax.php',
        data: data,
        dataType: 'json',
        success: function (result) {
            removeAllHint(editNode);
            if (result.success) {
                $(node).find(':input').each(function(i,e) {
                    if ($(e).attr('id') !== 'old-password') {
                        $(e).val('').change()
                    }
                })
            } else {
                if (result.message !== undefined) {
                    createHint(editNode, message.ERROR_UNDEFINED_EVENT);
                } else {
                    
                    $(editNode).text
                    let error = result.error;

                    for (key in error) {
                        createHint(node.find('[name="' + key + '"]'), message[error[key]]);
                    }
                }
            }
        },
        error: function (result) {
            console.log(result);
        }
    });
}
