class ActionProductsSlider {
  constructor() {
    this.actionSliderSelector = ".swiper-container_action";
    this.makeSlider();
  }

  makeSlider() {
    const sliderOptions = {
      default: {
        slidesPerView: 2,
        spaceBetween: 15,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      },
      [BaseSlider.breakpointMobile]: {
        spaceBetween: 20,
      },
    };
    const baseSlider = new BaseSlider(this.actionSliderSelector, sliderOptions);
    baseSlider.makeSlider();
  }
}
