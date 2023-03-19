class VideoReviewModal extends Modal {
    constructor(videoSrc) {
        super({
            isCreateMode: true,
            isVideoMode: true,
            isLarge: true
        });

        this.videoSrc = videoSrc;
        if (!this.videoSrc) {
            return;
        }
        this.createModal();
        super.open();
    }

    createModal() {
        const content = this.createModalHtml();
        this.setContent(content);
    }

    createModalHtml() {
        return (
            `<div class="yt-wrapper">
                <div class="yt-container">
                    <iframe src="${this.videoSrc}" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>`
        )
    }

}