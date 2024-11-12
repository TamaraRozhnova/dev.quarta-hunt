class ProductRating {
    #signedParameters = '';
    #componentName = '';

    #blockClasses = {
        btnEstimate: 'default-star__estimate',
        btnCancel: 'click-star__cancel',
        starBlock: 'star-block',
        clickStarBlock: 'click-star',
        starsBlock: 'stars-block',
        activeStar: 'active-star',
        activeStarSetted: 'active-star-setted',
        ratingGrade: 'rating-grade',
    };

    #selectors = {
        btnEstimate: document.querySelector(`.${this.#blockClasses.btnEstimate}`),
        btnCancel: document.querySelector(`.${this.#blockClasses.btnCancel}`),
        starBlock: document.querySelector(`.${this.#blockClasses.starBlock}`),
        ratingGrade: document.querySelector(`.${this.#blockClasses.ratingGrade}`),
        stars: document.querySelectorAll(`.${this.#blockClasses.clickStarBlock} .${this.#blockClasses.starsBlock} svg`),
    };

    #componentActions = {
        setRating: 'setRating',
    }

    constructor(signedParameters, componentName)
    {
        this.#signedParameters = signedParameters;
        this.#componentName = componentName;

        this.#addEventHandler();
    }

    #addEventHandler()
    {
        this.#selectors.btnEstimate.addEventListener('click', () => {
            this.#selectors.starBlock.classList.add('active');
        });

        this.#selectors.btnCancel.addEventListener('click', () => {
            this.#selectors.starBlock.classList.remove('active');
        });

        this.#selectors.stars.forEach((star, index) => {
            star.addEventListener('mouseover', () => {
                for (let i = 0; i <= index; i++) {
                    this.#selectors.stars[i].classList.add('active-star');
                }
            });

            star.addEventListener('mouseout', () => {
                this.#selectors.stars.forEach(star => {
                    star.classList.remove('active-star');
                });
            });

            star.addEventListener('click', () => {
                this.#runComponentAction(
                    this.#componentActions.setRating,
                    {grade: index + 1},
                    () => {},
                    () => {}
                );

                this.#setRating(index + 1);
                this.#selectors.ratingGrade.textContent = index + 1;
            });
        });
    }

    #runComponentAction(action, data, responseHandler, errorHandler)
    {
        BX.ajax.runComponentAction(
            this.#componentName,
            action,
            {
                mode: 'class',
                signedParameters: this.#signedParameters,
                data
            }
        )
        .then(response => responseHandler(response))
        .catch(error => errorHandler(error));
    }

    #setRating(grade)
    {
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