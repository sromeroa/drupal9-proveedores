(function () {

	var init = function () {

		/*
  if($('.js-mostrar-noticia').length) {
  		mostrarNoticia('.js-mostrar-noticia', '#js-noticia-detalle', '#js-ocultar-noticias');
  	regresarContenido('#js-regresar-noticias', '#js-ocultar-noticias', '#js-noticia-detalle');
  	}
  	if($('.js-mostrar-programa').length) {
  		mostrarNoticia('.js-mostrar-programa', '#js-mostrar-subprogramas', '#js-ocultar-programas');
  	regresarContenido('#js-regresar-programas', '#js-ocultar-programas', '#js-mostrar-subprogramas');
  	}
  */

	};

	/**
  * @description Muestra la noticia al momento de dar click
  * */

	var mostrarNoticia = function (clickNoticia, noticiaDetalle, ocultarNoticia) {

		$('body').on('click', clickNoticia, function (e) {

			e.preventDefault();

			$(noticiaDetalle).addClass('is-active');
			$(ocultarNoticia).addClass('u-hidden');

			console.log('Di click en boton mostrar noticia');
		});
	};

	var regresarContenido = function (enlaceRegresar, contenidoMostrado, contenidoOcultado) {

		$('body').on('click', enlaceRegresar, function (e) {

			e.preventDefault();

			$(contenidoMostrado).removeClass('u-hidden');
			$(contenidoOcultado).removeClass('is-active');
		});
	};

	init();
})();