class BaseSlider{static breakpointMobile=580;constructor(e=".swiper",i={[BaseSlider.breakpointMobile]:{},default:{}}){this.swiperSelector=e,this.options=i}makeSlider(){return new Swiper(this.swiperSelector,{slidesPerView:1,spaceBetween:20,linesCount:2,multiLine:!1,navigation:{nextEl:".base-slider__next",prevEl:".base-slider__prev"},...this.options.default,breakpoints:{[BaseSlider.breakpointMobile]:{slidesPerView:2,...this.options[BaseSlider.breakpointMobile]}}})}}
class DropDownMenu{dropDown;dropdownItems;width=0;height=0;shift=0;constructor(e={element:element,sections:sections,level:level,minHeight:0}){this.element=e.element,this.sections=e.sections,this.level=e.level,this.minHeight=e.minHeight,this.render(),this.makeActionsAfterRender()}makeActionsAfterRender(){this.getNewElements(),this.calculateShift(),this.setExtraStyles(),this.hydrateDropDown(),this.hydrateElements()}getNewElements(){this.dropDown=this.element.querySelector(".nav-dropdown"),this.dropdownItems=this.dropDown.querySelectorAll(".header-nav-item")}hydrateDropDown(){var e=this.dropDown.querySelector("ul");new PerfectScrollbar(e)}hydrateElements(){this.dropdownItems.forEach(e=>{const t=e.dataset.id,i=this.sections[t].SUBSECTIONS;e.addEventListener("mouseenter",()=>{var e=this.dropDown.querySelector(".nav-dropdown__wrapper");e&&e.remove(),t&&i&&new DropDownMenu({element:this.dropDown,sections:i,level:this.level+1,minHeight:this.height})})})}render(){this.element.insertAdjacentHTML("beforeend",this.getHtml())}getHtml(){return`<div class="nav-dropdown__wrapper">
                <div class="nav-dropdown ${this.isOddLevel()&&" nav-dropdown--odd"}">
                    <ul>
                        ${this.getMenuItemsHtml()}
                    </ul>
                </div>
            </div>`}getMenuItemsHtml(){return Object.keys(this.sections).map(e=>{var{NAME:t,LINK:i}=this.sections[e];return`<li>
                    <div class="header-nav-item" data-id="${e}">
                        <a href="${i}">
                            <span>${t}</span>
                        </a>
                    </div>
                </li>`}).join("")}setExtraStyles(){var e=this.width/4>-this.shift,t={};this.minHeight&&(t.minHeight=this.minHeight+"px"),this.shift<0&&(t.transform="translateX(-200%)"),this.shift<0&&(this.level<=1||e)&&(t.transform=`translateX(${this.shift}px)`),this.dropDown.style.transform=t.transform,this.dropDown.style.minHeight=t.minHeight}calculateShift(){var e=this.dropDown.getBoundingClientRect(),e=(this.width=e.width,this.height=e.height,window.innerWidth-e.right);this.shift=e-window.catalogMenuContainer.right}isOddLevel(){return this.level%2!=0}}
window.addEventListener("DOMContentLoaded",()=>{document.querySelectorAll(".footer-collapse").forEach(e=>{e.querySelector(".footer-collapse__toggle--mobile").addEventListener("click",()=>{e.classList.toggle("footer-collapse--expanded")})})});
window.addEventListener("DOMContentLoaded",()=>{const t=document.querySelector(".header__spot"),o=t.querySelector(".header__spot-dropdown");var e=t.querySelector(".header__spot > span"),c=document.querySelectorAll(".catalog-category-mobile");const a=document.querySelector(".mobile-nav");var r=document.querySelector(".header__button-mobile"),s=document.querySelector(".mobile-nav__close");const n=document.querySelector(".header__contacts");var d=document.querySelector(".header__button-contacts");e.addEventListener("click",e=>{e.stopPropagation(),t.classList.toggle("header__spot--show")}),window.addEventListener("click",e=>{o.contains(e.target)||t.classList.remove("header__spot--show")}),c.forEach(e=>{e.querySelector(".catalog-category-mobile__title").addEventListener("click",()=>{e.classList.toggle("catalog-category-mobile--expanded")})}),r.addEventListener("click",()=>{a.classList.add("mobile-nav--show")}),s.addEventListener("click",()=>{a.classList.remove("mobile-nav--show"),n.classList.remove("header__contacts--show")}),d.addEventListener("click",()=>{n.classList.toggle("header__contacts--show")})});
class Input{constructor(t,e={onChange:()=>{},onClear:()=>{}}){this.inputElement=document.querySelector(t),this.clearButtonElement=document.querySelector(t+" + .input__clear"),this.options=e,this.hangEvents()}hangEvents(){this.handleChange(),this.handleClear()}getValue(){return this.inputElement.value}setValue(t){this.inputElement.value=t,this.options.onChange()}clear(){this.inputElement.value="",this.clearButtonElement.classList.remove("show"),this.options.onClear()}handleChange(){this.inputElement.addEventListener("input",()=>{this.toggleClearButton(),this.options.onChange()})}handleClear(){this.clearButtonElement&&this.clearButtonElement.addEventListener("click",()=>this.clear())}toggleClearButton(){this.clearButtonElement&&(this.getValue()?this.clearButtonElement.classList.add("show"):this.clearButtonElement.classList.remove("show"))}}
class MainSlider{swiper=null;delay=5e3;isHovered=!1;timerProgress=0;fps=30;timer=0;interval=null;perimeter=62.831853072;progressItems=[];wrapperDotItems=[];dotItems=[];circleItems=[];sliderProgressScroller=null;constructor(e=".swiper",s=[],t=!1){this.swiperSelector=e,this.sliderImages=s,this.compact=t}get getCurrentIndexSlider(){return this.swiper.realIndex??0}get countSlides(){return this.sliderImages.length}get timePerTick(){return 1e3/this.fps}getExtraElements(){this.progressItems=document.querySelectorAll(".main-slider-progress__item"),this.wrapperDotItems=document.querySelectorAll(".main-slider__dot"),this.dotItems=document.querySelectorAll(".main-slider-dot"),this.circleItems=document.querySelectorAll(".main-slider-dot svg circle:last-of-type"),this.sliderProgressScroller=document.querySelector(".main-slider-progress__scroller-inner")}makeSlider(){this.displayImages(),this.swiper=new Swiper(this.swiperSelector,{slidesPerView:1,direction:"vertical",height:this.compact?455:511,loop:!0,navigation:{nextEl:".main-slider__arrow-next",prevEl:".main-slider__arrow-prev"},on:{slideChangeTransitionEnd:()=>this.changeSlideTransitionEnd()},breakpoints:{580:{height:this.compact?482:964},992:{height:this.compact?318:635}}}),this.getExtraElements(),this.hangEvents(),this.startTimer()}hangEvents(){var e=document.querySelector(".main-slider");e.addEventListener("mouseenter",()=>{this.isHovered=!0,this.stopTimer()}),e.addEventListener("mouseleave",()=>{this.isHovered=!1,this.startTimer()}),this.progressItems.forEach((e,s)=>{e.addEventListener("click",()=>this.swiper.slideTo(s+1))}),this.wrapperDotItems.forEach((e,s)=>{e.addEventListener("click",()=>this.swiper.slideTo(s+1))})}displayImages(){var e=document.querySelectorAll(".main-slider .swiper-slide");992<window.innerWidth?e.forEach((e,s)=>e.style.backgroundImage=`url(${this.sliderImages[s].IMAGE})`):e.forEach((e,s)=>e.style.backgroundImage=`url(${this.sliderImages[s].IMAGE_MOBILE})`)}startTimer(){this.interval||(this.interval=setInterval(()=>this.tick(),1e3/this.fps))}stopTimer(){clearInterval(this.interval),this.interval=null}clearTimer(){this.timer=0}changeSlideTransitionEnd(){setTimeout(()=>{this.handleActiveClasses(),this.handleProgressScrollerPosition(),this.stopTimer(),this.clearTimer(),this.isHovered||this.startTimer()})}handleActiveClasses(){const t=this.getCurrentIndexSlider;this.progressItems.forEach((e,s)=>{s===t?e.classList.add("main-slider-progress__item--active"):e.classList.remove("main-slider-progress__item--active")}),this.dotItems.forEach((e,s)=>{s===t?e.classList.add("main-slider-dot_active"):e.classList.remove("main-slider-dot_active")})}handleProgressScrollerPosition(){var e,s,t;this.sliderProgressScroller&&(e=this.getCurrentIndexSlider,s=this.countSlides,this.sliderProgressScroller.style.left=(t=100/s)*e+"%",this.sliderProgressScroller.style.right=t*(s-e-1)+"%")}tick(){this.timer=this.timer+this.timePerTick,this.timerProgress=this.timer/this.delay,this.fillProgress(),this.timer>=this.delay&&(this.stopTimer(),this.clearTimer(),this.swiper.slideNext(300))}fillProgress(){var e;this.circleItems.length&&(e=this.getCurrentIndexSlider,this.circleItems[e].setAttribute("stroke-dasharray",this.perimeter*this.timerProgress+" "+(this.perimeter-this.perimeter*this.timerProgress)))}}
class Modal{constructor(e,t=".modal"){this.modalElement=document.querySelector(t),this.openModalElement=document.querySelector(e),this.closeModalElement=this.modalElement.querySelector(".modal__close"),this.modalContentElement=this.modalElement.querySelector(".modal-content"),this.#hangEvents()}#hangEvents(){this.openModalElement.addEventListener("click",()=>this.open()),this.closeModalElement.addEventListener("click",()=>this.close()),window.addEventListener("click",e=>this.handleWindowClick(e))}open(){this.createOverlay(),this.modalElement.classList.add("show")}close(){this.removeOverlay(),this.modalElement.classList.remove("show"),this.onClose()}createOverlay(){var e=document.createElement("div");e.classList.add("modal-overlay"),document.body.appendChild(e)}removeOverlay(){var e=document.querySelector(".modal-overlay");e&&e.remove()}handleWindowClick(e){this.modalContentElement.contains(e.target)||this.openModalElement.contains(e.target)||this.close()}onClose(){}}