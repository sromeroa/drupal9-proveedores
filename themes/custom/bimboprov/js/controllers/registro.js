(function () {

	var init = function () {
		if ($('.js-agregar-producto').length) agregarProducto();
		if ($('.js-eliminar-producto').length) eliminarProducto();
		if ($('#js-cbo-categoria').length) serviceCategoria();
		if ($('.js-form-send').length) {
			valForm.validate({
				form: $('.js-form-send'),
				success: function () {
					formRegistro();
				}
			});
		}
	};

	/**
  * @description Agrega otro producto al formulario de registro
  * */
	var agregarProducto = function () {
		var numProd = 1,
		    btnAgregar = $('.js-agregar-producto');

		btnAgregar.on('click', function (e) {
			//console.log('clic')
			e.preventDefault();
			var html = '';
			numProd++;

			html += fillView({
				data: { index: numProd },
				view: $('#tplProductos')
			});

			$('.js-template-producto').append(html);
			textareaController();
		});
	};

	/**
  * @description Eliminar producto al formulario de registro
  * */
	var eliminarProducto = function () {

		$('body').on('click', '.js-eliminar-producto', function (e) {
			e.preventDefault();
			var id = $(this).attr('data-id');
			console.log(id);
			$('#c-producto__dinamico-' + id).remove();
		});
	};

	/**
  * @description servicio para el combo de categorias
  * */
	var serviceCategoria = function () {
		var cboCat = $('#js-cbo-categoria'),
		    cboSubCat = $('#js-cbo-subcategoria');

		cboCat.on('change', function (e) {
			var that = $(this);
			if (that.val() != '') {
				cboSubCat.parents('.customSelect').addClass('loading');
				$.ajax({
					url: that.attr('data-service'),
					type: 'get',
					dataType: 'json',
					data: 'subcategoria=' + that.val(),
					success: function (res) {
						setTimeout(function () {
							cboSubCat.parents('.customSelect').removeClass('loading');
						}, 500);

						if (res.success) {
							console.log('ok');
							cboSubCat.empty();
							cboSubCat.append('<option value="">' + cboSubCat.attr('data-name') + '</option>');
							var data = res.object;
							for (key in data) {
								cboSubCat.append('<option value="' + data[key].id + '">' + data[key].subcategoria + '</option>');
							}
							cboSubCat.updateSelect();
						} else {
							Alert.setMessage({
								title: '',
								message: res.message
							});
							Alert.showMessage('modal');
							cboSubCat.parents().removeClass('loading');
						}
					}

				});
			}
		});
	};

	/**
  * @description Funcion para enviar el formulario de registro
  * */
	var formRegistro = function () {
		var form = $('.js-form-send'),
		    urlService = form.attr('action'),
		    methodForm = form.attr('method');
		urlThanks = form.attr('data-thanks');

		initLoad();
		$.ajax({
			url: urlService,
			type: methodForm,
			dataType: 'json',
			data: form.serialize(),
			success: function (res) {
				console.info('success', res);
				if (res.success) {
					//window.location.href = urlThanks;
				} else {
					deleteLoad();
					Alert.setMessage({
						title: '',
						message: res.message
					});
					Alert.showMessage('modal');
					grecaptcha.reset();
				}
			},
			error: function (res) {
				deleteLoad();
				Alert.setMessage({
					title: '',
					message: res.message
				});
				Alert.showMessage('modal');
				grecaptcha.reset();
			}
		});
	};

	init();
})();