document.addEventListener("DOMContentLoaded", () => {

	const addr__btn = document.querySelectorAll(".addr__btn");
	for (let i = 0; i < addr__btn.length; i++) {
	 addr__btn[i].addEventListener("click", function(e) {
	   let target = e.target

	   if(target.tagName != 'BUTTON'){
			target = target.closest('button')
	   }

		let id = target.getAttribute('data-btn');

		document.querySelector(".addr__btn.active").classList.toggle("active");
		document.querySelector(".addr__map > .active").classList.toggle("active");

		document.querySelector(".addr__btn[data-btn='"+id+"']").classList.toggle("active");
		document.querySelector(".addr__map > [data-id='"+id+"']").classList.toggle("active");
	 });
	}


});