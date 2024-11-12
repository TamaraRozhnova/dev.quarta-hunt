class ProductComment {
    #signedParameters = '';
    #componentName = '';

    #commentTextAreaMaxChars = 0;
    #commentTextAreaMinChars = 0;

    #blockClasses = {
        likeBlock: 'like-block',
        likeBlockLiked: 'liked',
        likeBlockCount: 'like-block__count',
        reviewItem: 'reviews-item',
        reviewItemsBlock: 'reviews-list-block',
        reviewTextarea: 'reviews-add-block__textarea',
        reviewAddBlock: 'reviews-add-block',
        reviewWrite: 'write-review',
        reviewTextareaLength: 'length-input-block',
        btnReviewAddBlock: 'button-add-review-block',
        btnReviewClear: 'button-review-clear',
        btnReviewAdd: 'button-review-add',
        btnDeleteReview: 'delete-block',
        reviewsCount: 'reviews-count',
        moreButton: 'reviews-list-block__more',
    };

    #selectors = {
        reviewTextarea: document.querySelector(`.${this.#blockClasses.reviewTextarea}`),
        reviewTextareaLength: document.querySelector(`.${this.#blockClasses.reviewTextareaLength}`),
        btnReviewAddBlock: document.querySelector(`.${this.#blockClasses.btnReviewAddBlock}`),
        btnReviewClear: document.querySelector(`.${this.#blockClasses.btnReviewClear}`),
        btnReviewAdd: document.querySelector(`.${this.#blockClasses.btnReviewAdd}`),
        reviewsCount: document.querySelector(`.${this.#blockClasses.reviewsCount}`),
    };

    #componentActions = {
        likeComment: 'likeComment',
        addComment: 'addComment',
        deleteComment: 'deleteComment',
        moreComment: 'moreComment',
    }

    constructor(signedParameters, componentName, data)
    {
        this.#signedParameters = signedParameters;
        this.#componentName = componentName;

        this.#commentTextAreaMaxChars = data.COMMENT_TEXT_AREA_MAX;
        this.#commentTextAreaMinChars = data.COMMENT_TEXT_AREA_MIN;

        this.#addEventHandler();
    }

    #addEventHandler()
    {
        this.#selectors.reviewTextarea.addEventListener('input', () => {
            const reviewAddBlock = this.#selectors.reviewTextarea.closest(`.${this.#blockClasses.reviewAddBlock}`);
            const commentTextArea = this.#selectors.reviewTextarea;
            const currentChars = commentTextArea.value.length;

            if (currentChars <= 0) {
                this.#disabledReviewTextarea(reviewAddBlock, commentTextArea);
                return;
            }

            this.#selectors.btnReviewAddBlock.classList.remove('hidden');
            reviewAddBlock.classList.add(this.#blockClasses.reviewWrite);
            commentTextArea.rows = 4;

            const maxChars = this.#commentTextAreaMaxChars;

            if (currentChars > maxChars) {
                commentTextArea.value = commentTextArea.value.substring(0, maxChars);
            } else {
                this.#selectors.reviewTextareaLength.textContent = currentChars.toString() + '/' + maxChars.toString();
            }
        });

        this.#selectors.btnReviewClear.addEventListener('click', () => {
            const reviewAddBlock = this.#selectors.reviewTextarea.closest(`.${this.#blockClasses.reviewAddBlock}`);
            const commentTextArea = this.#selectors.reviewTextarea;

            this.#clearReviewTextarea(reviewAddBlock, commentTextArea);
        });

        this.#selectors.btnReviewAdd.addEventListener('click', () => {
            const commentCount = document.querySelectorAll(`.${this.#blockClasses.reviewItem}`).length;

            this.#runComponentAction(
                this.#componentActions.addComment,
                {
                    comment: this.#selectors.reviewTextarea.value,
                    currentCommentCount: commentCount
                },
                response => {
                    this.#addCommentResponse(response);

                    const reviewAddBlock = this.#selectors.reviewTextarea.closest(`.${this.#blockClasses.reviewAddBlock}`);
                    const commentTextArea = this.#selectors.reviewTextarea;

                    this.#clearReviewTextarea(reviewAddBlock, commentTextArea);

                    BX.UI.Notification.Center.notify({
                        content: response.data.RESULT,
                        position: 'bottom-right'
                    });
                },
                () => {}
            );
        });

        this.#addReviewItemsEventHandler();
    }

    #addReviewItemsEventHandler()
    {
        document.querySelectorAll(`.${this.#blockClasses.likeBlock}`).forEach(likeBlock => {
            likeBlock.addEventListener('click', () => {
                const reviewItem = likeBlock.closest(`.${this.#blockClasses.reviewItem}`);
                const commentId = reviewItem.getAttribute('data-comment-id');

                BX.ajax.runComponentAction(
                    this.#componentName,
                    this.#componentActions.likeComment,
                    {
                        mode: 'class',
                        signedParameters: this.#signedParameters,
                        data: {
                            commentId: commentId,
                        }
                    }
                )
                    .then(response => {
                        if (response.data.IS_LIKED) {
                            likeBlock.classList.add(this.#blockClasses.likeBlockLiked);
                        } else {
                            likeBlock.classList.remove(this.#blockClasses.likeBlockLiked);
                        }

                        likeBlock.querySelector(`.${this.#blockClasses.likeBlockCount}`).textContent = response.data.COUNT_LIKED;
                    })
            });
        });

        document.querySelectorAll(`.${this.#blockClasses.btnDeleteReview}`).forEach(btnDeleteReview => {
            btnDeleteReview.addEventListener('click', () => {
                const reviewItem = btnDeleteReview.closest(`.${this.#blockClasses.reviewItem}`);
                const commentId = reviewItem.getAttribute('data-comment-id');
                const commentCount = document.querySelectorAll(`.${this.#blockClasses.reviewItem}`).length;

                this.#runComponentAction(
                    this.#componentActions.deleteComment,
                    {commentId, currentCommentCount: commentCount},
                    response => {
                        this.#addCommentResponse(response);

                        BX.UI.Notification.Center.notify({
                            content: response.data.RESULT,
                            position: 'bottom-right'
                        });
                    },
                    () => {}
                );
            });
        });

        const moreButton = document.querySelector(`.${this.#blockClasses.moreButton}`);

        if (moreButton !== null) {
            moreButton.addEventListener('click', () => {
                const commentCount = document.querySelectorAll(`.${this.#blockClasses.reviewItem}`).length;

                this.#runComponentAction(
                    this.#componentActions.moreComment,
                    {currentCommentCount: commentCount},
                    response => {this.#addCommentResponse(response);},
                    () => {}
                );
            });
        }
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

    #addCommentResponse(response)
    {
        const tempElement = document.createElement('div');
        tempElement.innerHTML = response.data.HTML;

        const reviewItemsBlock = tempElement.querySelector(`.${this.#blockClasses.reviewItemsBlock}`);
        const currentReviewItemsBlock = document.querySelector(`.${this.#blockClasses.reviewItemsBlock}`);

        currentReviewItemsBlock.innerHTML = reviewItemsBlock.innerHTML;

        const reviewsCount = this.#selectors.reviewsCount;

        if (reviewsCount !== null) {
            reviewsCount.textContent = response.data.COMMENTS_COUNT;
        }

        this.#addReviewItemsEventHandler();
    }

    #clearReviewTextarea(reviewAddBlock, commentTextArea)
    {
        commentTextArea.value = '';
        this.#disabledReviewTextarea(reviewAddBlock, commentTextArea);
    }

    #disabledReviewTextarea(reviewAddBlock, commentTextArea)
    {
        this.#selectors.btnReviewAddBlock.classList.add('hidden');
        reviewAddBlock.classList.remove(this.#blockClasses.reviewWrite);
        commentTextArea.rows = 1;
    }
}

BX.ProductComment = ProductComment;