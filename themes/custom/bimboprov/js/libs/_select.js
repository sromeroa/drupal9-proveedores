var eventoClick = '';

function isiPhone() {
	return navigator.platform.indexOf("iPhone") != -1 || navigator.platform.indexOf("iPod") != -1 || navigator.platform.indexOf("iPad") != -1 || navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1;
}
var customSelect = function () {

	//- - - - - - - - - - - - - - -
	//- EVENTOS
	//- - - - - - - - - - - - - - -
	var _selectEvents = function () {

		//- - - - - - - - - - - - - - -
		//- TOGGLE ABIERTO - CERRADO

		if (isiPhone()) {
			eventoClick = 'touchstart';
		} else {
			eventoClick = 'click tap';
		}

		$(document).on(eventoClick, function (e) {
			_closeSelect($('.customSelect'));
		});

		$('body').on(eventoClick, '.customSelect', function (e) {
			var that = $(this);

			if (that.hasClass('disabled')) {
				return false;
			}

			if (that.hasClass('open')) {
				_closeSelect(that);
			} else {
				if (!isiPhone()) {
					_closeSelect($('.customSelect'));
					that.addClass('open');
					that.find('select').trigger('focus');
				} else {
					//$('body').css({ 'background': 'red' });
					that.find('select').trigger('focus');
				}
			}

			e.stopPropagation();
		});

		//- - - - - - - - - - - - - - -
		//- ABRE - CIERRA CON EL TABULADOR
		$('body').on('focus', 'select, .customSelect-search', function (e) {
			var custom = $(this).closest('.customSelect');

			if (!isiPhone()) {
				_closeSelect($('.customSelect'));
				custom.addClass('open');
			}
			//alert(123);

			e.stopPropagation();
		});

		//- - - - - - - - - - - - - - -
		//- SELECCIONA UNA OPCIÓN
		$('body').on('click tap', '.customSelect-options label:not(.titulo-optgroup)', function (e) {
			var that = $(this),
			    value = that.index(),
			    options = that.parent().children(),
			    select = that.closest('.customSelect').find('select'),
			    label = that.closest('.customSelect').find('.customSelect-label'),
			    multiple = that.closest('.customSelect').hasClass('multiple') ? true : false;

			e.stopPropagation();

			if (!that.hasClass('selected')) {
				if (!multiple) {
					options.removeClass('selected');
					label.text(that.text());
					that.addClass('selected');
					_closeSelect(that.closest('.customSelect'));
				} else {
					console.info('es multiple');
					that.addClass('selected hide');
					_addTag(that);
				}

				if (select.find('optgroup').length === 0) {
					select.find('option').get(value).selected = true;
				} else {
					select.find('option').get(value - that.prevAll('.titulo-optgroup').length).selected = true;
				}

				$(select).trigger('change');
			}
		});
		//if (isiPhone()) {
		$('body').on('change', 'select', function () {
			var that = $(this),
			    customS = that.parents('.customSelect'),
			    labelS = customS.find('.customSelect-label'),
			    txtS = that.val(),
			    txtLab = that.find('option:selected').text();

			labelS.text(txtLab);
		});
		//}


		//- - - - - - - - - - - - - - -
		//- NAVEGACIÓN CON FLECHAS DEL TEClADO
		$('body').on('keydown', 'select', function (e) {
			var key = e.keyCode,
			    select = $(this).closest('.customSelect'),
			    terms;

			switch (key) {
				case 13:
				case 40:
				case 38:
					e.preventDefault();
					_navSelect(select, key);
					break;

				case 39:
				case 37:
					e.preventDefault();
					break;

				case 27:
					_closeSelect(select);
					break;
			}
		});

		//- Prevenir que el formulario se envien con ENTER
		$('body').on('keydown', '.customSelect-search', function (e) {
			var key = e.keyCode;

			if (key == 13) {
				e.preventDefault();
			}
		});

		$('body').on('keyup', '.customSelect-search', function (e) {
			var key = e.keyCode,
			    select = $(this).closest('.customSelect'),
			    terms = select.find('.customSelect-options label').not('.hide');

			switch (key) {
				case 13:
				case 40: //Down
				case 38:
					//UP
					e.preventDefault();
					_navSelect(select, key);
					break;

				case 39: //Right
				case 37:
					//Left
					break;

				default:
					_namespace.filter(select);

					break;
			}
		});

		//- - - - - - - - - - - - - - -
		//- FILTRO
		$('body').on('click tap', '.customSelect input, .customSelect-filter', function (e) {
			e.stopPropagation();
		});

		//- - - - - - - - - - - - - - -
		//- SELECT MULTIPLE TAGS
		$('body').on('click tap', '.customSelect-tag', function (e) {
			var that = $(this),
			    custom = $('#' + that.closest('.customSelect-tagList').attr('id').replace('customTags-', 'custom-')),
			    select = $(custom.find('select')),
			    index = that.attr('data-index');

			$(select.find('option').get(index))[0].selected = false;
			$(custom.find('.customSelect-options label').get(index)).removeClass('selected hide');

			that.remove();
		});
	}();

	var _navSelect = function (select, key) {

		var items = select.find('.customSelect-options label').not('.hide'),
		    current = select.find('.active');

		if (key == 13) {

			if (current.length) {
				try {
					$(current[0]).trigger('click');
				} catch (err) {}
			}
		}

		if (current.length) {

			for (var i = 0, lg = items.length; i < lg; i++) {
				if (current[0] == items[i]) {

					items.removeClass('active');
					switch (key) {
						case 40:
							current = $(items[i + 1]).addClass('active');
							break;

						case 38:
							current = $(items[i - 1]).addClass('active');
							break;
					}

					if (!current.length) {
						$(items[i]).addClass('active');
					}

					break;
				}
			}
		} else {
			$(items[0]).addClass('active');
		}
	};

	var _closeSelect = function (select) {

		select.removeClass('open');
		select.find('label').removeClass('active');
		if (!select.hasClass('multiple')) {
			select.find('label').removeClass('hide');
		}
		select.find('.customSelect-search').val('');
	};

	var _addTag = function (option) {
		var html = '',
		    target,
		    items,
		    current;

		if (option[0].tagName == 'SELECT') {

			items = option.find(':selected');

			for (var i = 0, lg = items.length; i < lg; i++) {
				current = $(items[i]);

				html += '<span class="customSelect-tag" data-val="' + current.val() + '" data-index="' + current.index() + '">' + current.text() + '</span>';
			}

			return html;
		} else {
			html = '<span class="customSelect-tag" data-val="' + option.attr('data-val') + '" data-index="' + option.index() + '">' + option.text() + '</span>';
			target = $('#customTags-' + option.closest('.customSelect').find('select')[0].id);
			target.append(html);
		}
	};

	var _removeTag = function (option) {};

	//- - - - - - - - - - - - - - -
	//- PÚBLICO
	//- - - - - - - - - - - - - - -
	var _namespace = {

		update: function (element) {

			var id;

			var init = function () {
				var item, options;

				if (!isiPhone()) {
					for (var i = 0, lg = element.length; i < lg; i++) {
						item = $(element[i]);

						if (!item.closest('.customSelect').length) {
							_makeSelect(item);
						} else {
							options = _getOptions(item);
							item.closest('.customSelect').find('.customSelect-options').html(options.html);
							item.closest('.customSelect').find('.customSelect-label').html(options.label);
						}
					}
				} else {
					// se hace el cambi de options de manera normal
				}
			};

			var _makeSelect = function (select) {

				var wrapper = $(document.createElement('SPAN')),
				    options = _getOptions(select),
				    html = '',
				    tags = '',
				    autoSelect = select.hasClass('filter') ? true : false,
				    multiple = select.attr('multiple') ? true : false,
				    formId = select[0].form.id ? select[0].form.id : 'form',
				    name;

				if (multiple) {
					select.addClass('multiple');
					wrapper.attr('multiple', true);

					tags = '<div id="customTags-' + select.attr('id') + '" class="customSelect-tagList">' + _addTag(select);+'</div>';
				}

				html = '<span class="currentSelect"></span>' + '<span class="customSelect-label">' + options.label + '</span>' + '<i class="customSelect-arrow"></i>';

				if (autoSelect) {
					html += '<span class="customSelect-filter">' + '<input type="text" class="customSelect-search noLabel" data-name="" id="auto_' + '"  autocomplete="off" />' + '</span>';
				}

				html += '<span class="customSelect-options">' + options.html + '</span>';

				html += '</span>';

				wrapper[0].className = 'customSelect ' + select[0].className + (select.is(':disabled') ? ' disabled' : '');
				if (select.attr('id') !== undefined) {
					wrapper[0].id = 'custom-' + select.attr('id');
				}
				wrapper.html(html);
				select.wrap(wrapper);
				$(tags).insertAfter(select.closest('.customSelect'));
			};

			var _getOptions = function (item) {
				var options = item.find('option'),
				    optgroup = item.find('optgroup'),
				    select = item,
				    html = '',
				    classe,
				    label,
				    item;

				if (optgroup.length === 0) {
					for (var i = 0, lg = options.length; i < lg; i++) {
						item = $(options[i]);
						classe = '';

						if (i == 0) {
							label = item.text();
						}

						if (item.is(':selected')) {
							classe = 'class="selected"';
							label = item.text();

							if (select.attr('multiple')) {
								classe = 'class="selected hide"';
							}
						}

						if (select.attr('multiple')) {
							label = select.attr('data-name');
						}

						html += '<label ' + classe + ' data-val="' + item.val() + '" >' + item.text() + '</label>';
					}
				} else {
					label = select.children('option').text();

					for (var j = 0; j < optgroup.length; j++) {

						var titulo = $(optgroup[j]).attr('label');
						var opciones = $(optgroup[j]).find('option');

						html += "<label class=\"titulo-optgroup\">" + titulo + "</label>";

						for (var k = 0; k < opciones.length; k++) {
							var item = $(opciones[k]);
							classe = '';

							if (item.is(':selected')) {
								classe = 'class="selected"';
								label = item.text();

								if (select.attr('multiple')) {
									classe = 'class="selected hide"';
								}
							}

							if (select.attr('multiple')) {
								label = select.attr('data-name');
							}

							html += '<label ' + classe + ' data-val="' + item.val() + '" >' + item.text() + '</label>';
						}
					}
				}

				return {
					html: html,
					label: label
				};
			};

			init();
		},

		filter: function (element, term) {

			var field = element.find('.customSelect-search'),
			    labels = element.find('.customSelect-options label'),
			    term = term || field.val(),
			    item;

			labels.removeClass('hide active');

			if (element.hasClass('multiple')) {
				element.find('.selected').addClass('hide');
			}

			if (field.val().length < 3) {
				return false;
			}

			for (i = labels.length - 1; i >= 0; i--) {
				item = $(labels[i]);

				if (item.text().toLowerCase().indexOf(term) == -1) {
					item.addClass('hide');
				}
			}
		},

		reset: function (element) {

			var item, select, option;

			for (var i = 0, lg = element.length; i < lg; i++) {
				item = $(element[i]);

				select = item.closest('.customSelect');
				select[0].className = 'customSelect ' + item[0].className;

				$(item.find('options')).attr('selected', false);

				select.find('.customSelect-options label').removeClass('hide active selected');

				if (!select.hasClass('multiple')) {
					select.find('.customSelect-options label:first-child').trigger('click');
				} else {
					$(element.find('option')).attr('selected', false);
					$('#customTags-' + select.attr('id')).find('.customSelect-tag').remove();
				}
			}
		}
	};

	var startAll = function () {
		var selects = $('select').not('.noCustom');

		if (!isiPhone()) {
			for (var i = selects.length - 1; i > -1; i--) {
				_namespace.update($(selects[i]));
			}
		} else {
			for (var i = selects.length - 1; i > -1; i--) {
				$(selects[i]).wrap('<span class="maskSelect"></span>');
				$(selects[i]).addClass('maskSelect');
				$(selects[i]).parent().addClass('maskSelect');
			}
		}
	}();

	return _namespace;
}();

$.fn.extend({
	updateSelect: function () {
		//if(isiPhone()){
		customSelect.update($(this));
		//}
	},

	resetSelect: function () {
		customSelect.reset($(this));
		customFields.reset($(this));
		//$(this).trigger('change');
	}

});

//- - - - - - - - - - - - - - -
//- EJEMPLO
//- - - - - - - - - - - - - - -

//- Update
//customSelect.update( $('#s3') );
//$('#s3').updateSelect();

//- Reset
//customSelect.reset( $('#s3') );
//$('#s3').resetSelect();