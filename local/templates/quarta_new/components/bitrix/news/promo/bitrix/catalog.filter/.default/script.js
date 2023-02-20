BX.ready(function() {
    var links = document.querySelectorAll('.promo-filter form a')
    for (var i = 0; i < links.length; i++) {
        BX.bind(links[i], 'click', function() {
            var inputs = document.querySelectorAll('.promo-filter form input[name*=DATE_ACTIVE_TO]')

            for (var j = 0; j < inputs.length; j++) {
                inputs[j].value = ''
            }

            var index = this.getAttribute('data-index')
            var input = document.querySelector('.promo-filter form input[name*=DATE_ACTIVE_TO_' + index + ']')
            input.value = input.getAttribute('data-current-date')
            var form = BX.findParent(input, {'tag': 'form'})
            BX.fireEvent(form, 'submit')
        })
    }
    // $('.promo-filter form a').click(funct ion() {
    //     $('.promo-filter form input[name~=DATE_ACTIVE_TO]').val('')
    // })
})