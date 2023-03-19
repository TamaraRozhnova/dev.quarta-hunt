class ReviewAdding {
    constructor(productId) {
        this.ajaxUrl = '/ajax/feedback/addReview.php';
        this.productId = productId;

        this.reviewsApi = new ReviewsApi();
        this.addReviewElement = document.querySelector('.add-review');

        if (!this.addReviewElement) {
            return;
        }

        this.rating = 0;

        this.hangEvents();
        this.createElements();
    }

    createElements() {
        this.inputImages = new InputFile({
            wrapperSelector: '.add-review .input-file',
            maxFiles: 3,
            maxSize: 5242880,
            showAddedFiles: true,
        });
        this.textareaFlaws = new Input({
            wrapperSelector: '.add-review__flaws',
            inputSelector: '#flaws'
        });
        this.textareaDignities = new Input({
            wrapperSelector: '.add-review__dignities',
            inputSelector: '#dignities'
        });
        this.textareaComments = new Input({
            wrapperSelector: '.add-review__comments',
            inputSelector: '#comments'
        });

        this.controls = {
            flaws: this.textareaFlaws,
            dignities: this.textareaDignities,
            comments: this.textareaComments,
            images: this.inputImages
        }
    }

    hangEvents() {
        this.stars = this.addReviewElement.querySelectorAll('.add-review .star');
        this.stars.forEach((star, index) => this.hangStarsEvents(star, index));
        this.form = this.addReviewElement.querySelector('form');
        this.form.addEventListener('submit', (event) => this.handleSubmit(event));
    }

    hangStarsEvents(star, index) {
        this.reviewsStarsElement = this.addReviewElement.querySelector('.add-review__stars');
        this.reviewsStarsElement.addEventListener('mouseleave', () => {
            this.changeHoveredStars(0);
            this.insertDescriptionHtml(0);
        });
        star.addEventListener('mouseenter', () => {
            this.changeHoveredStars(index + 1);
            this.insertDescriptionHtml(index + 1);
        });
        star.addEventListener('click', () => {
            this.rating = index + 1;
            this.changeActiveStars();
        });
    }

    insertDescriptionHtml(hoveredStars) {
        const descriptionElement = this.reviewsStarsElement.querySelector('.add-review__stars-description');
        if (!descriptionElement && hoveredStars) {
            const html = this.createDescriptionRatingHtml(hoveredStars);
            this.reviewsStarsElement.insertAdjacentHTML('beforeend', html);
            this.descriptionRatingELement = this.addReviewElement.querySelector('.add-review__stars-description');
            this.descriptionRatingELement.addEventListener('mouseenter', () => this.changeHoveredStars(0));
            return;
        }
        if (hoveredStars) {
            descriptionElement.innerHTML = this.getDescriptionText(hoveredStars);
            return;
        }
        if (this.rating) {
            descriptionElement.innerHTML = this.getDescriptionText(this.rating);
            return;
        }
        if (descriptionElement) {
            descriptionElement.remove();
        }
    }

    createDescriptionRatingHtml(rating) {
        return (
            `<div class="add-review__stars-description">
                 ${this.getDescriptionText(rating)}
            </div>`
        )
    }

    getDescriptionText(rating) {
        switch (rating) {
            case 1:
                return 'Ужасно';
            case 2:
                return 'Плохо';
            case 3:
                return 'Нормально';
            case 4:
                return 'Хорошо';
            case 5:
                return 'Отлично';
            default:
                return '';
        }
    }

    changeHoveredStars(hoveredStars) {
        this.stars.forEach((star, index) => {
            if (index + 1 <= hoveredStars) {
                star.classList.add('star--hovered');
            } else {
                star.classList.remove('star--hovered');
            }
        });
    }

    changeActiveStars() {
        this.stars.forEach((star, index) => {
            if (index + 1 <= this.rating) {
                star.classList.add('star--active');
            } else {
                star.classList.remove('star--active');
            }
        });
    }

    async handleSubmit(event) {
        event.preventDefault();
        this.setDisableSubmitButton(true);
        if (!this.isValidData()) {
            this.setDisableSubmitButton(false);
            return;
        }
        this.reviewsApi.addReview(this.getDataForSubmit())
            .then(response => {
                if (response) {
                    this.showSuccessBlock();
                }
            })
            .finally(() => this.setDisableSubmitButton(false));
    }

    getDataForSubmit() {
        const formData = new FormData();
        formData.append('productId', this.productId);
        formData.append('rating', this.rating);
        Object.keys(this.controls).forEach(key => {
            const value = this.controls[key].getValue();
            if (!value) {
                return;
            }
            if (key === 'images') {
                value.forEach(image => {
                    formData.append('images[]', image);
                })
            } else {
                formData.append(key, value);
            }
        });
        return formData;
    }

    isValidData() {
        return this.rating;
    }

    setDisableSubmitButton(disabled) {
        const submitButton = this.form.querySelector('button[type="submit"]');
        submitButton.disabled = disabled;
    }

    showSuccessBlock() {
        this.addReviewElement.classList.add('add-review--success');
    }
}