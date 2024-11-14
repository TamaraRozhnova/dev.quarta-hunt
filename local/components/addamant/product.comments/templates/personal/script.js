class ProductComment {
  #signedParameters = "";
  #componentName = "";
  #areaId = "";
  #commentTextAreaMaxChars = 0;
  #commentTextAreaMinChars = 0;
  #commentCount = 0;

  #blockClasses = {};
  #selectors = {};

  #componentActions = {
    addComment: "addComment",
    deleteComment: "deleteComment",
    moreComment: "moreComment",
  };

  constructor(signedParameters, componentName, data, areaId) {
    this.#signedParameters = signedParameters;
    this.#componentName = componentName;

    this.#commentTextAreaMaxChars = data.COMMENT_TEXT_AREA_MAX;
    this.#commentTextAreaMinChars = data.COMMENT_TEXT_AREA_MIN;
    this.#commentCount = data.COMMENTS_COUNT;

    this.#areaId = areaId;

    this.#blockClasses = {
      reviewItem: "reviews-item",
      reviewItemsBlock: "reviews-list-block",
      reviewTextarea: "reviews-add-block__textarea",
      reviewAddBlock: "reviews-add-block",
      reviewWrite: "write-review",
      reviewTextareaLength: "length-input-block",
      btnReviewAddBlock: "button-add-review-block",
      btnReviewClear: "button-review-clear",
      btnReviewAdd: "button-review-add",
      reviewsCount: "element__reviews-count",
    };

    this.#selectors = {
      reviewTextarea: document.querySelector(
        `#${this.#areaId} .${this.#blockClasses.reviewTextarea}`
      ),
      reviewTextareaLength: document.querySelector(
        `#${this.#areaId} .${this.#blockClasses.reviewTextareaLength}`
      ),
      btnReviewAddBlock: document.querySelector(
        `#${this.#areaId} .${this.#blockClasses.btnReviewAddBlock}`
      ),
      btnReviewClear: document.querySelector(
        `#${this.#areaId} .${this.#blockClasses.btnReviewClear}`
      ),
      btnReviewAdd: document.querySelector(
        `#${this.#areaId} .${this.#blockClasses.btnReviewAdd}`
      ),
      reviewsCount: document.querySelector(
        `#${this.#areaId} .${this.#blockClasses.reviewsCount}`
      ),
    };

    this.#addEventHandler();

    if (this.#commentCount != 0) {
      this.#changeReviewsCount(this.#commentCount);
    }
  }

  #addEventHandler() {
    this.#selectors.reviewTextarea.addEventListener("input", () => {
      const reviewAddBlock = this.#selectors.reviewTextarea.closest(
        `.${this.#blockClasses.reviewAddBlock}`
      );
      const commentTextArea = this.#selectors.reviewTextarea;
      const currentChars = commentTextArea.value.length;

      if (currentChars <= 0) {
        this.#disabledReviewTextarea(reviewAddBlock, commentTextArea);
        return;
      }

      this.#selectors.btnReviewAddBlock.classList.remove("hidden");
      reviewAddBlock.classList.add(this.#blockClasses.reviewWrite);
      commentTextArea.rows = 4;

      const maxChars = this.#commentTextAreaMaxChars;

      if (currentChars > maxChars) {
        commentTextArea.value = commentTextArea.value.substring(0, maxChars);
      } else {
        this.#selectors.reviewTextareaLength.textContent =
          currentChars.toString() + "/" + maxChars.toString();
      }
    });

    this.#selectors.btnReviewClear.addEventListener("click", () => {
      const reviewAddBlock = this.#selectors.reviewTextarea.closest(
        `.${this.#blockClasses.reviewAddBlock}`
      );
      const commentTextArea = this.#selectors.reviewTextarea;

      this.#clearReviewTextarea(reviewAddBlock, commentTextArea);
    });

    this.#selectors.btnReviewAdd.addEventListener("click", () => {
      const commentCount = document.querySelectorAll(
        `#${this.#areaId} .${this.#blockClasses.reviewItem}`
      ).length;

      this.#runComponentAction(
        this.#componentActions.addComment,
        {
          comment: this.#selectors.reviewTextarea.value,
          currentCommentCount: commentCount,
        },
        (response) => {
          this.#addCommentResponse(response);

          const reviewAddBlock = this.#selectors.reviewTextarea.closest(
            `.${this.#blockClasses.reviewAddBlock}`
          );
          const commentTextArea = this.#selectors.reviewTextarea;

          this.#clearReviewTextarea(reviewAddBlock, commentTextArea);

          reviewAddBlock.style.display = "none";

          BX.UI.Notification.Center.notify({
            content: response.data.RESULT,
            position: "bottom-center",
          });
        },
        () => {}
      );
    });
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

  #addCommentResponse(response) {
    const tempElement = document.createElement("div");
    tempElement.innerHTML = response.data.HTML;

    const reviewItemsBlock = tempElement.querySelector(
      `.${this.#blockClasses.reviewItemsBlock}`
    );
    const currentReviewItemsBlock = document.querySelector(
      `#${this.#areaId} .${this.#blockClasses.reviewItemsBlock}`
    );

    currentReviewItemsBlock.innerHTML = reviewItemsBlock.innerHTML;

    this.#changeReviewsCount(response.data.COMMENTS_COUNT);
  }

  #changeReviewsCount(count) {
    const reviewsCount = this.#selectors.reviewsCount;

    if (reviewsCount !== null) {
      reviewsCount.textContent = count;
    }
  }

  #clearReviewTextarea(reviewAddBlock, commentTextArea) {
    commentTextArea.value = "";
    this.#disabledReviewTextarea(reviewAddBlock, commentTextArea);
  }

  #disabledReviewTextarea(reviewAddBlock, commentTextArea) {
    this.#selectors.btnReviewAddBlock.classList.add("hidden");
    reviewAddBlock.classList.remove(this.#blockClasses.reviewWrite);
    commentTextArea.rows = 1;
  }
}

BX.ProductComment = ProductComment;
