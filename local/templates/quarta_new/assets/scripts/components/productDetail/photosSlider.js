class PhotosSlider {
    constructor() {
        this.photosSliderSelector = '.photos-slider .swiper-container';
        this.selectedPhoto = document.querySelector('.product-photos__selected-photo');
        this.zoomElement = document.querySelector('.product-photos__zoom');
        this.zoomImageElement = this.zoomElement.querySelector('img');

        this.makeSlider();
    }

    makeSlider() {
        const sliderOptions = {
            default: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            [BaseSlider.breakpointTablet]: {
                slidesPerView: 5,
                spaceBetween: 20,
            },
            [BaseSlider.breakpointMobile]: {
                slidesPerView: 5,
            },
        }
        const baseSlider = new BaseSlider(this.photosSliderSelector, sliderOptions);
        this.photosSlider = baseSlider.makeSlider();
        this.photosSliderCurrentSlide = 0;
        this.photosSlider.slides[0].classList.add('photos-slider__item--active');
        this.hangPhotosSliderEvents();
        this.hangZoomEvents();
    }

    hangPhotosSliderEvents() {
        const changeSlideButton = document.querySelector('.photos-slider__next-button');
        changeSlideButton.addEventListener('click', () => {
            const isLastSlide = this.photosSliderCurrentSlide === this.photosSlider.slides.length - 1
            if (isLastSlide) {
                this.photosSliderCurrentSlide = 0;
            } else {
                this.photosSliderCurrentSlide += 1
            }
            this.photosSlider.slideTo(this.photosSliderCurrentSlide);
            this.handleChangeSlide();
        });
        this.photosSlider.slides.forEach((slide, index) => {
            slide.addEventListener('click', () => {
                this.photosSlider.slideTo(index);
                this.photosSliderCurrentSlide = index;
                this.handleChangeSlide();
            })
        })
    }

    handleChangeSlide() {
        this.photosSlider.slides.forEach((slide, index) => {
            if (this.photosSliderCurrentSlide === index) {
                const imageSrc = slide.style.backgroundImage;
                this.selectedPhoto.style.backgroundImage = imageSrc;
                this.zoomImageElement.src = imageSrc.replace(/(url\(")|("\))/g, '');
                slide.classList.add('photos-slider__item--active');
            } else {
                slide.classList.remove('photos-slider__item--active');
            }
        })
    }

    hangZoomEvents() {
        this.selectedPhoto.addEventListener('mouseenter', () => this.hangChangeMousePositionEvent());
        this.selectedPhoto.addEventListener('mouseleave', () => {
            this.selectedPhoto.removeEventListener('mousemove', () => this.hangChangeMousePositionEvent());
        });
    }

    hangChangeMousePositionEvent() {
        this.selectedPhoto.addEventListener('mousemove', (event) => {
            const rect = this.selectedPhoto.getBoundingClientRect();
            const elementX = event.clientX - rect.left;
            const elementY = event.clientY - rect.top;
            const isOutside = elementX < 0 || elementX > rect.width || elementY < 0 || elementY > rect.height;

            if (isOutside) {
                this.zoomElement.classList.remove('product-photos__zoom--show');
                return;
            }

            this.zoomElement.classList.add('product-photos__zoom--show');
            const shiftX = (elementX / (rect?.width ?? 0) - 0.5) * -75;
            const shiftY = (elementY / (rect?.height ?? 0) - 0.5) * -125;

            this.zoomImageElement.style.transform = `scale(3) translate3d(${shiftX}%,${shiftY}%, 0)`
            this.zoomElement.style.top = `${elementY}px`;
            this.zoomElement.style.left = `${elementX}px`;
        });
    }
}