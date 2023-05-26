class PhotosSlider {
    constructor() {
        this.photosSliderSelector = '.photos-slider .swiper-container';
        this.selectedPhoto = document.querySelector('.product-photos__selected-photo');
        this.detailCardPhotoModal = document.querySelector('#detail-card-modal-photo');
        this.entityModal = null;
        this.imageElementSrc = null;

        this.makeSlider();
        this.initModalCardPhoto();
        this.initModalCardPhotoMobile();
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

    initModalCardPhoto() {
        this.imageElementSrc = this.photosSlider.slides[0].style.backgroundImage.replace(/(url\(")|("\))/g, '');

        if (typeof this.imageElementSrc != "undefined") {
            if (this.detailCardPhotoModal.length != 0) {
                this.detailCardPhotoModal.querySelector('.detail-card-image').src = this.imageElementSrc
            }
        }

        if (this.detailCardPhotoModal.length != 0) {
  
            this.entityModal = new Modal ({
                modalOpenElementSelector: '.product-photos__selected-photo',
                modalSelector: "#detail-card-modal-photo"
            })
            
        }
    }

    initModalCardPhotoMobile() {
        if (window.innerWidth <= 575) {
            
            this.photosSlider.slides.forEach((slide, index) => {

                if (this.detailCardPhotoModal.length != 0) {
  
                    this.entityModal = new Modal ({
                        modalOpenElementSelector: `.detail-card-open-modal-mobile-${slide.getAttribute('modal-index')}`,
                        modalSelector: "#detail-card-modal-photo"
                    })
                    
                }
                
            })
        }
    }

    changeModalCardPhoto() {
        if (this.detailCardPhotoModal.length != 0) {
            if (this.detailCardPhotoModal.querySelector('.detail-card-image').length != 0) {
                this.detailCardPhotoModal.querySelector('.detail-card-image').src = this.imageElementSrc
            }
        }
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
                
                this.imageElementSrc = imageSrc.replace(/(url\(")|("\))/g, '');
                this.changeModalCardPhoto()
                
                slide.classList.add('photos-slider__item--active');
            } else {
                slide.classList.remove('photos-slider__item--active');
            }
        })
    }

}