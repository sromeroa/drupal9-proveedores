(function () {

	/**
  * @Description Funcion para enviar el formulario de inicio de sesion
  */
	var validateInputs = function () {

		var form = $('.js-form-send-iniciar-sesion'),
		    inputs = form.find('.required');

		inputs.addClass('success');
	};

	var init = function () {

		//Validacion del formulario
		if ($('.js-form-send-iniciar-sesion').length) {
			valForm.validate({
				form: $('.js-form-send-iniciar-sesion'),
				success: function () {
					validateInputs();
				}
			});
		}
	};

	init();
})();