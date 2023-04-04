class Reviews {
    constructor() {
        this.reviewsBlock = document.querySelector('.reviews-list__content');
        this.loader = document.querySelector('.loading');
        this.productId = this.reviewsBlock.dataset.productId;

        this.reviewsApi = new ReviewsApi();
        this.createSelectorSort();
        this.getReviews();
        new ReviewAdding(this.productId);
    }

    createSelectorSort() {
        this.selectorSort = new Select({
            selector: '.select--reviews',
            onSelect: (sortId) => {
                this.getReviews(sortId);
            }
        });
    }

    hangEvents() {
        this.reviews = this.reviewsBlock.querySelectorAll('.review');
        this.reviews.forEach(reviewElement => {
            this.hangLikesAndDislikesEvents(reviewElement);
            this.hangResponseButtonEvent(reviewElement);
        })
    }

    hangLikesAndDislikesEvents(reviewElement) {
        const reviewId = reviewElement.dataset.id;
        const likeIcon = reviewElement.querySelector('.review__reaction--like svg');
        const dislikeIcon = reviewElement.querySelector('.review__reaction--dislike svg');
        likeIcon.addEventListener('click', () => {
            this.reviewsApi.changeLike(reviewId)
                .then(response => {
                    if (!response) {
                        return;
                    }
                    this.setLikesAndDislikesForReview(likeIcon, dislikeIcon, response);
                })
        });
        dislikeIcon.addEventListener('click', () => {
            this.reviewsApi.changeDislike(reviewId)
                .then(response => {
                    if (!response) {
                        return;
                    }
                    this.setLikesAndDislikesForReview(likeIcon, dislikeIcon, response);
                })
        })
    }

    setLikesAndDislikesForReview(likeIcon, dislikeIcon, response) {
        switch (response.ACTIVE) {
            case 'LIKE':
                likeIcon.classList.add('review__mark-btn--active');
                dislikeIcon.classList.remove('review__mark-btn--active');
                break;
            case 'DISLIKE':
                likeIcon.classList.remove('review__mark-btn--active');
                dislikeIcon.classList.add('review__mark-btn--active');
                break;
            default:
                likeIcon.classList.remove('review__mark-btn--active');
                dislikeIcon.classList.remove('review__mark-btn--active');
        }
        likeIcon.nextElementSibling.textContent = response.LIKES;
        dislikeIcon.nextElementSibling.textContent = response.DISLIKES;
    }

    getReviews(sortId = 'high') {
        this.setLoader(true);
        this.reviewsApi.getReviews(this.productId, sortId)
            .then(html => {
                this.insertHtml(html);
                this.hangEvents();
            });
        this.setLoader(false);
    }

    insertHtml(html) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const data = doc.querySelector('.reviews-list__content');
        this.reviewsBlock.innerHTML = data.innerHTML;
    }

    createElementsForResponse() {
        this.responseTextarea = new Input({
            wrapperSelector: '.review__reply-form .textarea',
            inputSelector: '.review__reply-form textarea',
            required: true,
            errorMessage: 'Поле обязательно к заполнению'
        });
    }

    createResponseToReviewHtml() {
        return (
            `<div class="card review__reply-form">
                <div class="card-body">
                    <div class="textarea mb-4">
                        <label for="response-text" class="form-label">
                            Введите ответ
                        </label>
                        <textarea id="response-text" rows="3" class="form-control"></textarea>
                    </div>
                    <button class="btn btn-primary">Отправить</button>
                </div>
                <div class="review__reply-form-success card-body">
                    <p>Спасибо Ваш отзыв отправлен</p>
                </div>
            </div>`
        )
    }

    hangResponseButtonEvent(reviewElement) {
        const buttons = reviewElement.querySelectorAll('.review__reply-button');
        buttons.forEach(button => button.addEventListener('click', () => {
            const replyFormBlock = reviewElement.querySelector('.review__reply-form');
            if (replyFormBlock) {
                replyFormBlock.remove();
                return;
            }
            const replyBlock = reviewElement.querySelector('.review__reply');
            const html = this.createResponseToReviewHtml();
            replyBlock.insertAdjacentHTML('beforeend', html);
            this.createElementsForResponse();
            this.hangResponseFormEvents(reviewElement);
        }));
    }

    hangResponseFormEvents(reviewElement) {
        const reviewId = reviewElement.dataset.id;
        const replyFormBlock = reviewElement.querySelector('.review__reply-form');
        const submitButton = replyFormBlock.querySelector('button');
        submitButton.addEventListener('click', () => {
            if (!this.responseTextarea.isValidValue()) {
                this.responseTextarea.setError();
                return;
            }
            this.reviewsApi.addResponseToReview(reviewId, this.responseTextarea.getValue())
                .then(response => {
                    if (response) {
                        replyFormBlock.classList.add('review__reply-form--success');
                        this.hideResponseButtons(reviewElement);
                    } else {
                        this.responseTextarea.setError('Ошибка, попробуйте позже');
                    }
                })
        });
    }

    hideResponseButtons(reviewElement) {
        const buttons = reviewElement.querySelectorAll('.review__reply-button');
        buttons.forEach(button => button.remove());
    }

    setLoader(state = false) {
        if (state) {
            this.loader.classList.add('loading--show');
            this.reviewsBlock.classList.remove('reviews-list__content--show');
        } else {
            this.loader.classList.remove('loading--show');
            this.reviewsBlock.classList.add('reviews-list__content--show');
        }
    }
}