class MainSlider {
    swiper = null;
    delay = 5000;
    isHovered = false;
    timerProgress = 0;
    fps = 30;
    timer = 0;
    interval = null;
    perimeter = 62.831853072;

    progressItems = [];
    wrapperDotItems = [];
    dotItems = [];
    circleItems = [];
    sliderProgressScroller = null;

    constructor(swiperSelector = '.swiper', sliderImages = [], compact = false) {
        this.swiperSelector = swiperSelector;
        this.sliderImages = sliderImages;
        this.compact = compact;
    }

    get getCurrentIndexSlider() {
        return this.swiper.realIndex ?? 0;
    }

    get countSlides() {
        return this.sliderImages.length;
    }

    get timePerTick() {
        return 1000 / this.fps;
    }

    getExtraElements() {
        this.progressItems = document.querySelectorAll(`.main-slider-progress__item`);
        this.wrapperDotItems = document.querySelectorAll(`.main-slider__dot`);
        this.dotItems = document.querySelectorAll(`.main-slider-dot`);
        this.circleItems = document.querySelectorAll(`.main-slider-dot svg circle:last-of-type`);
        this.sliderProgressScroller = document.querySelector(`.main-slider-progress__scroller-inner`);
    }

    makeSlider() {
        this.displayImages();
        this.swiper = new Swiper(this.swiperSelector, {
            slidesPerView: 1,
            direction: 'horizontal',
            height: this.compact ? 455 : 511,
            loop: true,
            navigation: {
                nextEl: '.main-slider__arrow-next',
                prevEl: '.main-slider__arrow-prev',
            },
            on: {
                slideChangeTransitionEnd: () => this.changeSlideTransitionEnd(),
            },
            breakpoints: {
                576: {
                    height: this.compact ? 482 : 964,
                },
                992: {
                    height: this.compact ? 318 : 635,
                }
            }
        });
        this.getExtraElements();
        this.hangEvents();
        this.startTimer();
    }

    hangEvents() {
        const slider = document.querySelector('.main-slider');
        slider.addEventListener('mouseenter', () => {
            this.isHovered = true;
            this.stopTimer();
        });
        slider.addEventListener('mouseleave', () => {
            this.isHovered = false;
            this.startTimer();
        });

        this.progressItems.forEach((element, index) => {
            element.addEventListener('click', () => this.swiper.slideTo(index + 1))
        });
        this.wrapperDotItems.forEach((element, index) => {
            element.addEventListener('click', () => this.swiper.slideTo(index + 1))
        });
    }

    displayImages() {
        const slides = document.querySelectorAll('.main-slider .swiper-slide');
        if (window.innerWidth > 992) {
            slides.forEach((slide, index) => slide.style.backgroundImage = `url(${this.sliderImages[index].IMAGE})`);
            return;
        }
        slides.forEach((slide, index) => slide.style.backgroundImage = `url(${this.sliderImages[index].IMAGE_MOBILE})`);
    }

    startTimer() {
        if (this.interval) {
            return;
        }
        this.interval = setInterval(() => this.tick(), 1000 / this.fps);
    }

    stopTimer() {
        clearInterval(this.interval);
        this.interval = null;
    }

    clearTimer() {
        this.timer = 0;
    }

    changeSlideTransitionEnd() {
        setTimeout(() => {
            this.handleActiveClasses()
            this.handleProgressScrollerPosition();
            this.stopTimer();
            this.clearTimer();
            if (!this.isHovered) {
                this.startTimer();
            }
        })
    }

    handleActiveClasses() {
        const currentIndex = this.getCurrentIndexSlider;
        this.progressItems.forEach((element, index) => {
            if (index === currentIndex) {
                element.classList.add('main-slider-progress__item--active');
                return;
            }
            element.classList.remove('main-slider-progress__item--active');
        });
        this.dotItems.forEach((element, index) => {
            if (index === currentIndex) {
                element.classList.add('main-slider-dot_active');
                return;
            }
            element.classList.remove('main-slider-dot_active');
        });

    }

    handleProgressScrollerPosition() {
        if (!this.sliderProgressScroller) {
            return;
        }
        const currentIndex = this.getCurrentIndexSlider;
        const countSlides = this.countSlides;
        const perItem = 100 / countSlides
        this.sliderProgressScroller.style.left = `${perItem * currentIndex}%`;
        this.sliderProgressScroller.style.right = `${perItem * (countSlides - currentIndex - 1)}%`;
    }

    tick() {
        this.timer = this.timer + this.timePerTick;
        this.timerProgress = this.timer / this.delay;
        this.fillProgress();
        if (this.timer >= this.delay) {
            this.stopTimer();
            this.clearTimer();
            this.swiper.slideNext(300);
        }
    }

    fillProgress() {
        if (!this.circleItems.length) {
            return;
        }
        const currentIndex = this.getCurrentIndexSlider;
        this.circleItems[currentIndex].setAttribute(
            'stroke-dasharray',
            `${this.perimeter * this.timerProgress} ${
                this.perimeter - this.perimeter * this.timerProgress
            }`
        )
    }
}