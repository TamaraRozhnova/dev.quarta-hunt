class ProductRating {
  #signedParameters = "";
  #componentName = "";
  #countRating = 0;
  #sumRating = 0;

  #blockClasses = {
    btnEstimate: "default-star__estimate",
    btnCancel: "click-star__cancel",
    starBlock: "star-block",
    clickStarBlock: "click-star",
    starsBlock: "stars-block",
    activeStar: "active-star",
    activeStarSetted: "active-star-setted",
    ratingGrade: "rating-grade",
    topRating: "element__rating-link",
  };

  #selectors = {
    btnEstimate: document.querySelector(`.${this.#blockClasses.btnEstimate}`),
    btnCancel: document.querySelector(`.${this.#blockClasses.btnCancel}`),
    starBlock: document.querySelector(`.${this.#blockClasses.starBlock}`),
    ratingGrade: document.querySelector(`.${this.#blockClasses.ratingGrade}`),
    stars: document.querySelectorAll(
      `.${this.#blockClasses.clickStarBlock} .${
        this.#blockClasses.starsBlock
      } svg`
    ),
    topRating: document.querySelector(`.${this.#blockClasses.topRating}`),
  };

  #componentActions = {
    setRating: "setRating",
  };

  constructor(signedParameters, componentName, countRating, sumRating) {
    this.#signedParameters = signedParameters;
    this.#componentName = componentName;
    this.#countRating = countRating;
    this.#sumRating = sumRating;

    this.#addEventHandler();
    this.#selectors.topRating.textContent =
      this.#countRating +
      " " +
      this.#num_word(this.#countRating, ["оценка", "оценки", "оценок"]);
  }

  #addEventHandler() {
    this.#selectors.btnEstimate.addEventListener("click", () => {
      this.#selectors.starBlock.classList.add("active");
    });

    this.#selectors.btnCancel.addEventListener("click", () => {
      this.#selectors.starBlock.classList.remove("active");
    });

    this.#selectors.stars.forEach((star, index) => {
      star.addEventListener("mouseover", () => {
        for (let i = 0; i <= index; i++) {
          this.#selectors.stars[i].classList.add("active-star");
        }
      });

      star.addEventListener("mouseout", () => {
        this.#selectors.stars.forEach((star) => {
          star.classList.remove("active-star");
        });
      });

      star.addEventListener("click", () => {
        this.#runComponentAction(
          this.#componentActions.setRating,
          { grade: index + 1 },
          (response) => {
            console.log(response);
          },
          () => {}
        );

        this.#setRating(index + 1);
        let level = document.querySelectorAll(".rating__level")[index];

        // Меняем общую оценку
        let newRating =
          Math.round(
            ((+this.#sumRating + index + 1) / (+this.#countRating + 1)) * 10
          ) / 10;
        this.#selectors.ratingGrade.textContent = newRating;
        document
          .querySelectorAll(".element__stars--color")
          .forEach((element) => {
            element.style.width = (newRating / 5) * 100 + "%";
          });
        this.#selectors.topRating.textContent =
          +this.#countRating +
          1 +
          " " +
          this.#num_word(+this.#countRating + 1, [
            "оценка",
            "оценки",
            "оценок",
          ]);

        // Меняем количество оценок в выбранном уровне
        level.querySelector(".rating__level-num").textContent =
          +level.getAttribute("count") + 1;

        // Рисуем полоску уровня
        level.querySelector(".rating__level-active").style.width =
          ((+level.getAttribute("count") + 1) / (+this.#countRating + 1)) *
            100 +
          "%";

        // Прячем звёзды для оценки
        document.querySelector(
          `.${this.#blockClasses.clickStarBlock}`
        ).style.display = "none";
      });
    });
  }

  #num_word(value, words) {
    value = Math.abs(value) % 100;
    var num = value % 10;
    if (value > 10 && value < 20) return words[2];
    if (num > 1 && num < 5) return words[1];
    if (num == 1) return words[0];
    return words[2];
  }

  #runComponentAction(action, data, responseHandler, errorHandler) {
    BX.ajax
      .runComponentAction(this.#componentName, action, {
        mode: "class",
        signedParameters: this.#signedParameters,
        data,
      })
      .then((response) => responseHandler(response))
      .catch((error) => errorHandler(error));
  }

  #setRating(grade) {
    this.#selectors.stars.forEach((star, index) => {
      if (index < grade) {
        star.classList.add(this.#blockClasses.activeStarSetted);
      } else {
        star.classList.remove(this.#blockClasses.activeStarSetted);
      }
    });
  }
}

BX.ProductRating = ProductRating;
