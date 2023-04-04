class ReviewsApi {
    constructor() {
        this.ajaxAddReviewUrl = '/ajax/feedback/addReview.php';
        this.ajaxGetReviewsUrl = '/ajax/feedback/getReviews.php';
        this.ajaxUpdateReviewUrl = '/ajax/feedback/updateReview.php';
        this.updateReviewAction = {
            LIKE: 'LIKE',
            DISLIKE: 'DISLIKE',
            RESPONSE: 'RESPONSE'
        }
        this.isAuth = window.isAuth;
    }

    async addReview(data) {
        return await Request.fetchWithFormData(this.ajaxAddReviewUrl, data);
    }

    async addResponseToReview(reviewId, text) {
        const data = { action: this.updateReviewAction.RESPONSE, reviewId, responseText: text }
        return await Request.fetch(this.ajaxUpdateReviewUrl, data);
    }

    async changeLike(reviewId) {
        const data = { action: this.updateReviewAction.LIKE, reviewId }
        return await Request.fetch(this.ajaxUpdateReviewUrl, data);
    }

    async changeDislike(reviewId) {
        const data = { action: this.updateReviewAction.DISLIKE, reviewId }
        return await Request.fetch(this.ajaxUpdateReviewUrl, data);
    }

    async getReviews(productId, sortOrder) {
        const queryParams = { productId, sort: sortOrder }
        return await Request.fetchHtml(this.ajaxGetReviewsUrl, queryParams);
    }
}