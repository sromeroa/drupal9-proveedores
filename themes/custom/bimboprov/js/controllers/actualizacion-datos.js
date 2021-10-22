(function () {

	var formFocus = function () {

		var form = $('.js-datos-focus'),
		    inputs = form.find('.required');
		inputsClass = form.find('.currentInput');

		inputs.addClass('block');
		inputs.attr('disabled', 'disabled');
		inputsClass.addClass('activo');
	};

	var init = function () {

		if ($('.js-form-send').length) {
			formFocus();
			valForm.validate({
				form: $('.js-form-send'),
				success: function () {
					formRegistro();
				}
			});
		}
	};

	init();
})();