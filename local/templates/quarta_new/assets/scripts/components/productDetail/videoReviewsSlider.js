class VideoReviewsSlider {
    constructor() {
        this.sliderSelector = '.swiper-container_video-reviews';
        this.videoWrappers = document.querySelectorAll('.video-preview__wrapper');

        this.makeSlider();
        this.hangEvents();
    }

    hangEvents() {
        this.videoWrappers.forEach(wrapper => {
            wrapper.addEventListener('click', (event) => {
                event.stopPropagation();
                const videoSrc = wrapper.dataset.videoSrc;
                new VideoReviewModal(videoSrc);
            })
        })
    }

    makeSlider() {
        const sliderOptions = {
            default: {
                slidesPerView: 1.05,
                spaceBetween: 15,
            },
            [BaseSlider.breakpointMobile]: {
                spaceBetween: 20,
                slidesPerView: 2
            }
        }
        const baseSlider = new BaseSlider(this.sliderSelector, sliderOptions);
        this.photosSlider = baseSlider.makeSlider();
    }
}