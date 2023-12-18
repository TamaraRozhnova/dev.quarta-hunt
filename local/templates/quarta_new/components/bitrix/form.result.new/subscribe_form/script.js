let subscribeForm = document.querySelector(".subscribe__form form");

if (subscribeForm) {
  subscribeForm.addEventListener("submit", function () {
    setTimeout(() => {
      subscribeForm
        .querySelector(".subscribe__button input")
        .setAttribute("disabled", "disabled");
    }, 100);
  });
}
