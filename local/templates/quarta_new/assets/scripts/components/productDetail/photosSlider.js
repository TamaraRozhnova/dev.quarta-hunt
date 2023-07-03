
class PhotosSlider {
    constructor() {
        this.photosSliderSelector = '.photos-slider .swiper-container';
        this.selectedPhoto = document.querySelector('.product-photos__selected-photo');
        this.photosSliderElements = document.querySelectorAll('.photos-slider__item');

        this.imageElementSrc = null;

        this.makeSlider();

        if (document.querySelector('[data-hide]') == null) {
            this.hangSelectedPhotoEvent();
            this.hangPhotosInSlider()
        }

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
    }

    hangPhotosInSlider() {
        this.photosSliderElements.forEach( (photo) => {
            photo.addEventListener('click' , () => {
                this.selectedPhoto.setAttribute('data-modal-index', photo.dataset.modalIndex)
            })
        })
    }

    hangSelectedPhotoEvent() {
        this.selectedPhoto.addEventListener('click', (event) => {
            const selectedModalIndex = event.target.dataset.modalIndex
            const sliderPhotoSelected = document.querySelector(`.photos-slider__item[data-modal-index="${selectedModalIndex}"]`)

            sliderPhotoSelected.click()

        })
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
            this.selectedPhoto.setAttribute('data-modal-index', this.photosSliderCurrentSlide)
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
                
                this.imageElementSrc = imageSrc.replace(/(url\(")|("\))/g, '');
                
                slide.classList.add('photos-slider__item--active');
            } else {
                slide.classList.remove('photos-slider__item--active');
            }
        })
    }

}