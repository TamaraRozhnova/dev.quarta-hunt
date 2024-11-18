class ProductRating {
  #signedParameters = "";
  #componentName = "";
  #areaId = "";
  #blockClasses = {};
  #selectors = {};

  #componentActions = {
    setRating: "setRating",
  };

  constructor(signedParameters, componentName, areaId) {
    this.#signedParameters = signedParameters;
    this.#componentName = componentName;
    this.#areaId = areaId;

    this.#blockClasses = {
      btnEstimate: "default-star__estimate",
      btnCancel: "click-star__cancel",
      starBlock: "star-block",
      clickStarBlock: "click-star",
      starsBlock: "stars-block",
      activeStar: "active-star",
      activeStarSetted: "active-star-setted",
    };

    this.#selectors = {
      btnEstimate: document.querySelector(
        `#${this.#areaId} .${this.#blockClasses.btnEstimate}`
      ),
      btnCancel: document.querySelector(
        `#${this.#areaId} .${this.#blockClasses.btnCancel}`
      ),
      starBlock: document.querySelector(`#${this.#areaId}`),
      stars: document.querySelectorAll(
        `#${this.#areaId} .${this.#blockClasses.clickStarBlock} .${
          this.#blockClasses.starsBlock
        } svg`
      ),
      clickStarBlock: document.querySelector(
        `#${this.#areaId} .${this.#blockClasses.clickStarBlock}`
      ),
    };

    this.#addEventHandler();
  }

  #addEventHandler() {
    this.#selectors.btnEstimate.addEventListener("click", () => {
      this.#selectors.starBlock.classList.add("active");
    });

    this.#selectors.btnCancel.addEventListener("click", () => {
      this.#selectors.starBlock.classList.remove("active");
    });

    if (!this.#checkConditions()) {
      this.#selectors.stars.forEach((star, index) => {
        star.addEventListener("mouseover", () => {
          if (!this.#checkConditions()) {
            for (let i = 0; i <= index; i++) {
              this.#selectors.stars[i].classList.add("active-star");
            }
          }
        });

        star.addEventListener("mouseout", () => {
          if (!this.#checkConditions()) {
            this.#selectors.stars.forEach((star) => {
              star.classList.remove("active-star");
            });
          }
        });

        star.addEventListener("click", () => {
          if (!this.#checkConditions()) {
            this.#runComponentAction(
              this.#componentActions.setRating,
              { grade: index + 1 },
              (response) => {
                console.log(response);
              },
              () => {}
            );

            this.#selectors.btnCancel.style.display = "none";
            this.#selectors.clickStarBlock.classList.add("rated");

            this.#setRating(index + 1);
          }
        });
      });
    }
  }

  #checkConditions() {
    return this.#selectors.clickStarBlock.classList.contains("rated");
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
