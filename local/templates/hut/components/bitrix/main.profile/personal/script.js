$( document ).ready(function() {

    let phoneForm = document.querySelector(".bx-auth-profile");

    if (phoneForm) {
        const phonePersonal = new Input({
            wrapperSelector: `.input__container.phone`,
            required: true,
            validMask: /^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/,
            mask: "+7 (###) ###-##-##",
            errorMessage: "Телефон должен быть в указанном формате",
        });

        const emailPersonal = new Input({
            wrapperSelector: `.input__container.email`,
            required: true,
            validMask: /^([a-z0-9_\-\.]+)@([a-z0-9_\-\.]+)$/,
            errorMessage: "Введите email в корректном формате",
        });
    
        const lastNamePersonal = new Input({
            wrapperSelector: `.input__container.name`,
            required: true,
            errorMessage: "Поле обязательно к заполнению",
        });
    
        const lastLastPersonal = new Input({
            wrapperSelector: `.input__container.last`,
            required: true,
            errorMessage: "Поле обязательно к заполнению",
        });
    
        const lastSecondPersonal = new Input({
            wrapperSelector: `.input__container.second`,
            required: true,
            errorMessage: "Поле обязательно к заполнению",
        });
    
        const PersonalReqFields = [
            phonePersonal,
            lastNamePersonal,
            emailPersonal,
            lastLastPersonal,
            lastSecondPersonal,
        ];
    
        $(".personal-submit-form").on("click", (e) => {
            PersonalReqFields.forEach((field) => {
                if (!field.isValidValue()) {
                    field.setError();
                    e.preventDefault();
                }
            });
        });

        $(document).on('click', '.change-close', function () {
            let changeWrap = $('.change-success');
            changeWrap.css('display', 'none');
        });

        setTimeout(function() { 
            $('.change-success').css('display', 'none');
        }, 3000);
    }
});
