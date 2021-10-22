/**
 * [[Archivo global del proyecto]]
 * @private
 * @author Brian Eduardo Palomar <eduardo.palomar@ingenia.com>
 * @author Edith Ramirez <edith.ramirez@ingenia.com> 
 */

(function ($) {
	var init = function () {
		if ($('img.lazy').length) lazyLoadAssets();
		if ($('img.imgResp').length) changeImageResp();
		if ($('.contrasena').length) mostrarOcultarContrasena();
		if ($('.formularioToolkit').length) valForm.validate({ form: $('.formularioToolkit') });
		if ($('.js-textarea').length) textareaController();;
		if ($('.js-form-search').length) toogleSearchMenu();
		if ($('.js-accordion').length) accordion();
		if ($('.js-header-aside').length) openHeader();
		if ($('.js-notificacion').length) openNotificacion();
		if ($('.js-slider-noticias').length) sliderNoticias();
		if ($('.c-modal').length) modalOff();
	};

	/**
  * @description Carga diferida de imagenes
  * */
	var lazyLoadAssets = function () {
		document.addEventListener("DOMContentLoaded", function () {
			var lazyloadImages;
			if ("IntersectionObserver" in window) {
				lazyloadImages = document.querySelectorAll(".lazy");
				var imageObserver = new IntersectionObserver(function (entries, observer) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							var image = entry.target;
							image.src = image.dataset.src;
							image.classList.remove("lazy");
							imageObserver.unobserve(image);
						}
					});
				});
				lazyloadImages.forEach(function (image) {
					imageObserver.observe(image);
				});
			} else {
				console.info('no soportado');
				notSupportedLazy();
				$(document).on('scroll', function () {
					notSupportedLazy();
				});
			}
		});
	};

	/**
  * @description Si no es soportada la carga diferida de imagenes
  * */
	var notSupportedLazy = function () {
		var imgLazy = $('.lazy'),
		    timeLazy,
		    scrollTop;
		scrollTop = $(window).scrollTop();
		for (var i = 0; i < imgLazy.length; i++) {
			if ($(imgLazy[i]).offset().top < $(window).height() + scrollTop) {
				$(imgLazy[i]).attr('src', $(imgLazy[i]).attr('data-src'));
				$(imgLazy[i]).removeClass('lazy');
			}
		}
	};

	/**
  * @description Manejo de images responsive
  * */
	var changeImageResp = function () {
		var image = $('.imgResp'),
		    imgDesk,
		    imgMob;

		for (var i = 0; i < image.length; i++) {
			imgDesk = $(image[i]).attr('data-desktop');
			imgMob = $(image[i]).attr('data-mobile');

			if ($(window).width() <= 768) {
				$(image[i]).attr('src', imgMob);
			} else {
				$(image[i]).attr('src', imgDesk);
			}
		}
	};
	/**
  * @description funcion general para agregar Load
  * */
	initLoad = function () {
		html = '<div class="o-loading__container"><div class="o-loading__table"><div class="o-loading__table-cell"><div class="o-loading__gif"><div></div><div></div><div></div><div></div></div></div></div></div>';
		$('body').append(html);
	};
	/**
  * @description funcion general para quitar Load
  * */
	deleteLoad = function () {
		$('body').find('.o-loading__container').remove();
	};
	/**
  * @description funcion para mostrar contraseña
  * */
	mostrarOcultarContrasena = function () {
		var boton = $('.js-mostrar-pass'),
		    contador = 0;

		boton.on('click', function (e) {
			e.preventDefault();
			var typePass = $(this).parent('.js-contrasena').find('input').attr('type');
			//console.log(typePass);
			if (typePass == 'text') {
				$(this).parent('.js-contrasena').find('input').attr('type', 'password');
			} else {
				$(this).parent('.js-contrasena').find('input').attr('type', 'text');
			}
		});
	};
	/**
  * @description funcion para contar los caracteres del textarea e incremento del height
  * */
	textareaController = function () {
		var num = 0,
		    letras = 0,
		    res = 0;

		$('body').on('keyup', '.js-textarea', function (e) {
			letras = $(this).val().length;
			res = num + letras;
			$(this).parent().parent().find('.js-incremento').text(res);
		});

		var offset = $('.js-textarea').outerHeight() - $('.js-textarea').innerHeight();
		$('.js-textarea').on('keyup input focus', function () {
			$(this).css('height', 'auto').css('height', $(this)[0].scrollHeight + offset);
		});
	};

	/**
  * @description funcion para accordion de todo el sitio
  * */
	var accordion = function () {
		var accordion = $('.js-accordion'),
		    contenido = $('.js-accordion-content');

		accordion.on('click', 'a', function (e) {
			e.preventDefault();
			var thatLi = $(this).parent();
			thatLi.toggleClass('is-active');

			if (thatLi.hasClass('is-active')) {
				thatLi.find(contenido).slideDown();
				thatLi.siblings('li').removeClass('is-active').find(contenido).slideUp();
			} else {
				thatLi.removeClass('active').find(contenido).slideUp();
			}
		});
	};

	/**
  * @description funcion mostrar el search
  * */
	var toogleSearchMenu = function () {
		var btnMostrar = $('.js-open-search'),
		    btnCerrar = $('.js-close-search'),
		    form = $('.js-form-search');

		btnMostrar.on('click', function (e) {
			e.preventDefault();
			form.fadeIn();
		});

		btnCerrar.on('click', function (e) {
			e.preventDefault();
			form.fadeOut();
		});
	};

	/**
  * @description funcion mostrar el search
  * */
	var openHeader = function () {
		var mobileContainer = $('.js-header-aside'),
		    openMenu = $('.js-open-menu'),
		    closeMenu = $('.js-close-menu');

		openMenu.on('click', function (e) {
			e.preventDefault();
			mobileContainer.addClass('is-active');
		});
		closeMenu.on('click', function (e) {
			e.preventDefault();
			mobileContainer.removeClass('is-active');
		});
	};

	/**
  * @description funcion mostrar el search
  * */
	var openNotificacion = function () {
		var btnOpenBox = $('.js-open-notificacion');

		btnOpenBox.on('click', function (e) {
			e.preventDefault();
			that = $(this);

			parent = $(this).parent();
			parent.toggleClass('is-visible');

			if (parent.hasClass('is-visible')) {
				that.siblings('.js-notificacion').slideDown();
				that.addClass('is-active');
				parent.siblings().removeClass('is-visible');
				parent.siblings().find('.js-notificacion').slideUp();
				parent.siblings().find('.js-open-notificacion').removeClass('is-active');
			} else {
				that.siblings('.js-notificacion').slideUp();
				that.removeClass('is-active');
			}
		});
	};
	/**
  * @description Funcion crear slider solo mobile de las noticias
  * */
	var sliderNoticias = function () {
		$('.js-slider-noticias').slick({
			lazyLoad: 'ondemand',
			dots: false,
			arrows: false,
			infinite: true,
			autoplay: true,
			speed: 300,
			slidesToShow: 2,
			slidesToScroll: 1,
			variableWidth: true,
			mobileFirst: true,
			responsive: [{
				breakpoint: 1023,
				settings: 'unslick'

			}]

		});
		$(window).on('resize orientationchange', function () {
			if ($(this).width() <= 1023) {
				$('.js-slider-noticias').slick('init');
			}
		});
	};

	/**
  * @Description Funcion para remover el modal
  */
	var modalOff = function () {

		$('body').addClass('modal-active');

		var btn = $('.js-modal');

		btn.on('click', function () {

			$('.c-modal').fadeOut();
			$('body').removeClass('modal-active');
		});
	};

	init();
})(jQuery);