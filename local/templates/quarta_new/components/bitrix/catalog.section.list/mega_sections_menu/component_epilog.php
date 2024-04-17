<script>
	let currentUrl = window.location.pathname;
	let currentUrlArr = currentUrl.split('/');
	let searchUrl = '/' + currentUrlArr[1] + '/' + currentUrlArr[2] + '/';

	document.querySelectorAll('.header-categories .header-nav-item').forEach((element) => {
		if (element.classList && !element.classList.contains('mega-menu-opener')) {
			let elementHref = element.querySelectorAll('a')[0].href;
			let elementHrefArr = elementHref.split('/');

			let currentUrlElement = '/' + elementHrefArr[3] + '/' + elementHrefArr[4] + '/';

			if (searchUrl == currentUrlElement) {
				element.classList.add('active-link');
			} else {
				element.classList.remove('active-link');
			}
		}
	});
</script>