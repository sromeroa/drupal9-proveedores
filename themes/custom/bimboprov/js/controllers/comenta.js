(function () {

	var formComenta = function () {

		var form = $('.js-form-comenta'),
		    inputs = form.find('.required');

		inputs.addClass('success');
	};

	var init = function () {

		if ($('.js-form-comenta').length) {
			valForm.validate({
				form: $('.js-form-comenta'),
				success: function () {
					formComenta();
				}
			});
		}
	};

	init();
})();