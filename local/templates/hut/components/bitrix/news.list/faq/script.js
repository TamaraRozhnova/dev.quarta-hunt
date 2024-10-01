document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.faq__questBtn').forEach(item=>{
		console.log(item)
		item.addEventListener('click', function(e){
			if(this.closest('.faq__quest').classList.contains('active')){
				this.closest('.faq__quest').classList.remove('active')
			} else{
				document.querySelectorAll('.faq__quest').forEach(item=>{
					item.classList.remove('active')
				})
				this.closest('.faq__quest').classList.add('active')
			}
		})
	})
});
