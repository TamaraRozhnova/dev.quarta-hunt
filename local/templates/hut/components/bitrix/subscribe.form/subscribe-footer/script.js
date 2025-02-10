document.addEventListener("DOMContentLoaded", function () {
  document
    .querySelector("#subscribe-form form")
    .addEventListener("submit", async function (event) {
      event.preventDefault();
      let formContainer = document.querySelector("#subscribe-form");
      let resultElement = document.querySelector("#subscribe_result");
      let resultTitle, resultText;
      let resultTitleElement = resultElement.querySelector(
        ".subscribe_result__title"
      );
      let resultTextElement = resultElement.querySelector(
        ".subscribe_result__subtitle"
      );

      let response = await fetch("/local/ajax/hut/subscribeHandler.php", {
        method: "POST",
        body: new FormData(this),
      });

      let result = await response.json();

      if (result?.status == "success") {
        resultTitle = "Спасибо за подписку!";
        resultText = "Ссылка для подтверждения отправлена <br>вам на почту";
        resultElement.querySelector("svg").style.display = "block";
      } else if (result?.status == "fail") {
        resultTitle = "Ошибка!";
        resultText = "Такой адрес уже присутствует в подписках";
      } else {
        resultTitle = "Ошибка!";
        resultText = "Что-то пошло не так, пожалуйста, попробуйте позже";
      }

      formContainer.style.display = "none";
      resultElement.style.display = "block";
      resultTitleElement.textContent = resultTitle;
      resultTextElement.innerHTML = resultText;
    });
});
