class BaseSlider{swiper;constructor(e=".swiper",i=".base-slider__next",s=".base-slider__prev"){this.swiperSelector=e,this.swiperSlideNextSelector=i,this.swiperSlidePrevSelector=s,this.makeSlider()}makeSlider(){this.swiper=new Swiper(this.swiperSelector,{slidesPerView:2.5,spaceBetween:7,linesCount:2,multiLine:!1,navigation:{nextEl:this.swiperSlideNextSelector,prevEl:this.swiperSlidePrevSelector},breakpoints:{580:{slidesPerView:4,spaceBetween:20}}})}}