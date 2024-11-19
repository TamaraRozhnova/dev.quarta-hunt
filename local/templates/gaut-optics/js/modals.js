let swiper = undefined;



var htmlElement = document.querySelector('html');
var modals = document.querySelectorAll('.modal');
var messages = document.querySelectorAll('.message');

function modalClose(modal) {
	modal.classList.remove('is-open');
	htmlElement.classList.remove('is-clipped');
}

function messageClose(message) {
	message.classList.remove('is-open');
	htmlElement.classList.remove('message-open');
}

window.addEventListener('click', function (event) {
	if (document.querySelector('.message.is-open')) {
		var messageOpened = document.querySelector('.message.is-open'),
			activeBtn = document.querySelector('.message-call.is-active');
		if (!messageOpened.contains(event.target) && !activeBtn.contains(event.target)) {
			// Ниже код, который нужно выполнить при срабатывании события.
			messageOpened.classList.remove('is-open');
			htmlElement.classList.remove('message-open');
		}
	}
});

modals.forEach(function (modal) {
	modal.addEventListener('click', function (event) {
		let isClickInside = modal.contains(event.target);
		if (!isClickInside && modal.classList.contains('is-open')) {
			//modalClose(modal);
		}
	});
});

$(function () {
	var headerSubMenu = document.querySelectorAll('.header-drop__submenu');
	var hasMenuItems = document.querySelectorAll('.header-drop__menu .has-menu');
	var menuBackButton = document.querySelector('.header-drop__back');
	var submenuContainer = document.querySelector('.header-drop__submenu_container');

	function CloseModal(modal) {
		var modalForm = modal.querySelectorAll('form'),
			dangerInputs = modal.querySelectorAll('.error'),
			dangerInputs2 = modal.querySelectorAll('.form-error');

		modal.classList.remove('is-open');
		htmlElement.classList.remove('is-clipped', 'modal-open');
		$('.article__comments-form__text-res').removeClass('alert-success alert-danger').addClass('hidden').html('');
		if (modalForm) {
			modalForm.forEach(function (form) {
				form.reset();
				var inputs = form.querySelectorAll('input');
				inputs.forEach(function (input) {
					input.classList.remove('valid');
				});
			});
		}

		dangerInputs.forEach(function (el) {
			el.classList.remove('error');
		});

		$(dangerInputs2).html('');
	}

	$(document).on('click', function (event) {
		if (typeof (event.target.className.indexOf) != "undefined" && event.target.className.indexOf('is-clipped') != -1) {
			var opened = event.target.querySelectorAll('.is-open');
			opened.forEach(function (item) {
				item.classList.remove('is-open');
			});
			event.target.classList.remove('is-clipped');
		}
	});

	$('.modal-dialog__close').on('click', function () {
		CloseModal($(this).closest('.modal')[0]);
	});

	var modalBtns = document.querySelectorAll('.modal-call');

	$(document).on('click', '.modal-call', function (e) {
		e.preventDefault();

		btn = this;
		var modal = btn.getAttribute('data-modal'),
			container = document.getElementById(modal).querySelector('.modal-container'),
			openModals = document.querySelectorAll('.modal.is-open'),
			openHeader = document.querySelector('.header'),
			// openBurger = document.querySelector('.header__burger'),
			openMessages = document.querySelectorAll('.message.is-open');
		document.getElementById(modal).classList.add('is-open');
		if (window.innerWidth <= 640 && window.pageYOffset > 500) {
			//container.style.top = 0;
		}
		else {
			container.style = '';
		}

		$('#' + modal).data('btn', $(this))

		//console.log(container);


	});

	var closeBtns = document.querySelectorAll('.modal-close');

	closeBtns.forEach(function (btn) {
		btn.onclick = function () {
			var modal = btn.closest('.modal');
			CloseModal(modal);
		};
	});

	var messageBtns = document.querySelectorAll('.message-call');
	messageBtns.forEach(function (btn) {
		btn.onclick = function (e) {
			e.preventDefault();
			var message = btn.getAttribute('data-message'),
				openModals = document.querySelectorAll('.modal.is-open'),
				openHeader = document.querySelector('.header'),
				openBurger = document.querySelector('.header__burger'),
				openMessages = document.querySelectorAll('.message.is-open');

			htmlElement.classList.remove('is-clipped', 'modal-open');
			openMessages.forEach(function (el) {
				el.classList.remove('is-open');
				htmlElement.classList.remove('message-open');
			});

			messageBtns.forEach(function (btn) {
				btn.classList.remove('is-active');
			});
			openModals.forEach(function (el) {
				el.classList.remove('is-open');
			});
			this.classList.add('is-active');
			document.getElementById(message).classList.add('is-open');
			htmlElement.classList.add('message-open');
			openHeader.classList.remove('is-open');
			openBurger.classList.remove('is-open');
		};
	});

	var moveTo = document.querySelectorAll('.scroll-to');

	moveTo.forEach(function (btn) {
		btn.onclick = function () {
			var tar = btn.getAttribute('data-scroll');
			var elem = document.getElementById(tar);
			var topOfElement = elem.offsetTop/* - document.querySelector('.header-invisible').offsetHeight*/;

			var headerHeight = +$('.header').height() + 15;

			// elem.scrollIntoView({
			//   behavior: 'smooth',
			//   block: 'start'
			// });

			// console.log(topOfElement, headerHeight, topOfElement + headerHeight);
			window.scroll({ top: topOfElement/* + headerHeight*/, behavior: "smooth" });

			if (elem.classList.contains('accordion')) {
				elem.classList.toggle('is-open');
				var elemParent = elem.parentElement;
				var elemNext = elem.nextElementSibling;
				if ($(elemNext).is(':hidden')) {
					$(elemNext).slideDown(300);
				} else {
					$(elemNext).slideUp(300);
					elemParent.style.maxHeight = parseInt(elemParent.style.maxHeight) + elemNext.scrollHeight + 'px';
				}
			}
		}
	});


	$(document).on("click", '.shade', function (e) {
		$('.filters__section').removeClass('is-active');
		// $('.filters__button').parents('.filters__section').removeClass('is-active');
		$(e.target).removeClass('is-visible');
	});



	function sklonenie(num, words) {
		num = num % 100;
		if (num > 19) {
			num = num % 10;
		}
		switch (num) {
			case 1: {
				return (words[0]);
			}
			case 2: case 3: case 4: {
				return (words[1]);
			}
			default: {
				return (words[2]);
			}
		}
	}

});

