(function ($) {



$().extend(mpl.params, {

fields: {
	
	render: function (el, params, data) {
		if (typeof params != 'object')
			return false;

		var param, value, atts;

		/* Since ver 2.6.3.3*/
		var events_stack = [];

		for (var index = 0, count = params.length; index < count; index++) {
			param = params[index]; value = '';
			if (data[param.name] !== undefined)
				value = data[param.name];
			else if (param !== undefined && param.value !== undefined) {
				value = param.value.toString();

				if (value.indexOf('%time%') > -1) {
					var d = new Date();
					value = value.replace('%time%', d.getTime());
				}
			}

			if (value == '__empty__')
				value = '';

			if (mpl_param_types_support.indexOf(param.type) == -1)
				param.type = '';

			atts = {
				value: value,
				options: ((param.options !== undefined) ? param.options : []),
				params: ((param.params !== undefined) ? param.params : []),
				sprite: param.sprite,
				name: param.name,
				type: param.type
			};

			if (param.type != 'textarea_html')
				atts.value = mpl.tools.unesc_attr(atts.value);

			var tmpl_html = mpl.template('field', {
				label: param.label,
				content: mpl.template('field-type-' + param.type, atts),
				des: param.description,
				name: param.type,
				base: param.name,
				relation: param.relation
			});
			tmpl_html = tmpl_html.replace(/\&lt\;script/g, '<script').replace(/\&lt\;\/script\&gt\;/g, '</script>');
			var field = $(tmpl_html);
			$(el).append(field);
			events_stack.push([$.extend(true, {}, param), $.extend(true, {}, atts), field, value]);
		}

		setTimeout(function (datas, el) {
			var param, atts, field, value;

			for (var i = 0, count = datas.length; i < count; i++) {
				param = datas[i][0];
				atts = datas[i][1];
				field = datas[i][2];
				value = datas[i][3];

				if (param.relation !== undefined) {
					var thru = false, pr = param.relation;
					
					//relation show/hide
					if (pr.parent !== undefined && (pr.show_when !== undefined || pr.hide_when !== undefined)) {
						var parent = {};
						if (pr.parent.indexOf(':') > -1) {
							var tab_name = pr.parent.split(':')[0];
							var parent_name = pr.parent.split(':')[1];
							var popup = el.closest('.mpl-params-popup');
							var data_tab = popup.find('.mpl-tab-general-' + tab_name).data('tab');
							parent = popup.find('.' + data_tab).find('.field-base-' + parent_name);
						} else {
							parent = el.find('>.field-base-' + pr.parent);
						}
						if (parent.get(0)) {

							if (parent.data('child') !== undefined) {
								var child = parent.data('child');
								child[child.length] = field;
							}
							else {
								var child = [];
								child[0] = field;
							}

							parent.data({ child: child });

							var iparent = parent.find('input.mpl-param[type="radio"],input.mpl-param[type="radio_image"],input.mpl-param[type="checkbox"],select.mpl-param');
							if (pr.show_when !== undefined) {
								if (typeof pr.show_when != 'object')
									pr.show_when = pr.show_when.toString().split(',');
							}
							if (pr.hide_when !== undefined) {
								if (typeof pr.hide_when != 'object')
									pr.hide_when = pr.hide_when.toString().split(',');
							}

							if (iparent.get(0)) {

								thru = true;
								iparent.on('change',
									{
										el: field,
										std: value,
										show: pr.show_when,
										hide: pr.hide_when,
										iparent: iparent,
										parent: parent
									},
									function (e) {
										var vparent = e.data.iparent.serializeArray(), sh, hi;
										if (e.data.show !== undefined)
											sh = false;
										if (e.data.hide !== undefined)
											hi = true;

										for (var n in vparent) {

											if (e.data.show !== undefined) {
												if (e.data.show.indexOf(vparent[n].value) > -1) {
													e.data.el.removeClass('relation-hidden');
													e.data.el.find('.mpl-param').removeClass('mpl-ns-param');
													if (!e.data.el.hasClass('field-panel') && 
														!e.data.el.hasClass('field-mytabs') &&
														!e.data.el.hasClass('field-microwidgets')) {
														e.data.el.find('.mpl-param:not(.mpl-empty-param)').each(function () {
															if (this.value === '') {
																if ($(this).data('encode') == 'base64')
																	e.data.std = mpl.tools.base64.decode(e.data.std);
																$(this).val(mpl.tools.unesc_attr(e.data.std)).change();
																$(this).closest('.m-p-r-content').find('.mpl-attach-field-wrp .img-wrp').remove();
															}
														});
													}
													sh = true;
												}
											}
											if (e.data.hide !== undefined) {
												if (e.data.hide.indexOf(vparent[n].value) > -1) {
													e.data.el.addClass('relation-hidden');
													e.data.el.find('.mpl-param').addClass('mpl-ns-param');
													hi = false;
												}
											}
										}

										if (e.data.show !== undefined) {
											if (sh === false) {
												e.data.el.addClass('relation-hidden');
												e.data.el.find('.mpl-param').addClass('mpl-ns-param');
											}
										}
										if (e.data.hide !== undefined) {
											if (hi === true) {
												e.data.el.removeClass('relation-hidden');
												e.data.el.find('.mpl-param').removeClass('mpl-ns-param');
											}
										}

										if (e.data.parent.hasClass('relation-hidden')) {
											e.data.el.addClass('relation-hidden');
											e.data.el.find('.mpl-param').addClass('mpl-ns-param');
										}

										if (e.data.el.data('child') !== undefined) {
											if (e.data.el.hasClass('relation-hidden')) {

												function hide_children(child) {
													child.forEach(function (_child) {
														_child.addClass('relation-hidden');
														_child.find('.mpl-param').addClass('mpl-ns-param');
														if (_child.data('child') !== undefined) {
															hide_children(_child.data('child'));
														}
													});
												}

												hide_children(e.data.el.data('child'));

											} else {
												e.data.el.find('input.mpl-param[type="radio"],input.mpl-param[type="checkbox"],select.mpl-param').trigger('change');
											}
										}
									}
								).addClass('m-p-rela');

								iparent.trigger('change');
							}
						}
					}
		
					// Show back if invalid config
					if (thru === false) {
						field.removeClass('relation-hidden');
						field.find('.mpl-param').removeClass('mpl-ns-param');
					}
				}

				if (typeof atts.callback == 'function') {
					// callback from field-type template
					//setTimeout( atts.callback, 1, field, $, atts );
					atts.callback(field, $, atts);
				}
			}

			delete datas, param, atts, field, value;

		}, 1, events_stack, el);
	},

	tabs: function (tab, form) {

		form.addClass('fields-edit-form'); // make this form as settings param to save

		//var model = mpl.get.model(tab),
		var tab_content = $(tab).closest('.m-p-wrap').find('.m-p-body').find('>.' + $(tab).data('tab')),
			fields = $(tab).closest('.m-p-wrap').find('.m-p-body').find('>.fields-edit-form');

/*		var cfg = $(tab).data('cfg').split('|'),
			data,
			args = $(tab).data('args'),
			map = $().extend({}, mpl.maps['_std'])

		if (mpl.front) {
			data = mpl.storage[cfg[1]][0];
		}
		else {
			data = mpl.storage[cfg[1]]
		}

		if (data === undefined || mpl.maps[data.name] === undefined)
			return false;

		map = $().extend(map, mpl.maps[cfg[2]]);

		mpl.params.fields.render(tab_content, map.params[cfg[0]], data.args); 
*/
		var cfg = $(tab).data('cfg').split('|'),
			data = {},
			map = {};

		data = $().extend({}, mpl.tools.popup.storage);
		map = $().extend({}, mpl.tools.popup.params);
			
		mpl.params.fields.render(tab_content, map.params[cfg[0]], data); 

		$(tab).data('callback', function (tit, tab) {
			/* ... */
		});

		return tab_content;
	},

},

});
$().extend(mpl.params.fields, {

radiotabs: {
    callback: function (wrp) {
        this.el = wrp;

        mpl.trigger(this);
        //wrp.find('.mpl-radiotabs-row').first().addClass('active');
    },

    events: {
        '.mpl-radiotabs-rows:click': 'actions',
    },

    actions: function (e) {
        var target = $(e.target);

        if (target.data('action')) {
            var wrp = $(this).closest('.mpl-param-row.field-radiotabs');
            switch (target.data('action')) {
                case 'collapse': e.data.collapse(target); break;
            }
        }
    },

    collapse: function (el) {
        var row = el.closest('.mpl-radiotabs-row');

        if (row.hasClass('active')) {
            row.removeClass('active');
        } else {
            el.closest('.mpl-radiotabs-rows')
                .find('.mpl-radiotabs-row.active')
                .removeClass('active');

            row.addClass('active');
        }
    },

    set_index: function (data_params, data_name, index) {
        var params = [];
        for (var i = 0; i < data_params.length; i++) {
            if (data_params[i]['type'] != 'radiotabs') {
                params[params.length] = $().extend({}, data_params[i]);
                if (data_params[i]['name'].indexOf(data_name + '[') == -1)
                    params[params.length - 1]['name'] = data_name + '[' + index + '][' + data_params[i]['name'] + ']';
            }
        }

        return params;
    },
},

});$().extend(mpl.params.fields, {

mytabs: {
    callback: function (wrp) {
        this.el = wrp;
    },

    set_index: function (data_params, data_name, index) {
        var params = [];
        for (var i = 0; i < data_params.length; i++) {
            if (data_params[i]['type'] != 'mytabs') {
                params[params.length] = $().extend({}, data_params[i]);
                if (data_params[i]['name'].indexOf(data_name + '[') == -1)
                    params[params.length - 1]['name'] = data_name + '[' + index + '][' + data_params[i]['name'] + ']';
            }
        }

        return params;
    },
},

});$().extend(mpl.params.fields, {

microwidgets: {
    callback: function (wrp) {
        this.el = wrp;

        mpl.trigger(this);
        wrp.find('.mpl-widgets-row').first().addClass('active');

        this.sortable();
    },

    events: {
        '.mpl-widgets-rows:click': 'actions',
        '.mpl-add-widgets:click': 'add_widget',
    },

    actions: function (e) {
        var target = $(e.target);

        if (target.data('action')) {
            var wrp = $(this).closest('.mpl-param-row.field-widgets');
            switch (target.data('action')) {
                case 'collapse': e.data.collapse(target); break;
                case 'delete': e.data.remove(target, e.data, wrp); break;
            }
        }

        if (!target.hasClass('mpl-add-widgets') && (target.hasClass('mpl-widgets-controls') || target.hasClass('counter'))) {
            e.data.collapse(target);
        }
    },

    collapse: function (el) {
        var row = el.closest('.mpl-widgets-row');

        if (row.hasClass('active')) {
            row.removeClass('active');
        } else {
            el.closest('.mpl-widgets-rows')
                .find('.mpl-widgets-row.active')
                .removeClass('active');

            row.addClass('active');
        }
    },

    remove: function (el, obj, wrp) {
        if (confirm(/* mpl.__.sure*/'Are you sure that you want to delete this item?')) {
            el.closest('.mpl-widgets-row').remove();
        }
    },

    add_widget: function (e) {
        var wrp = $(this).closest('.mpl-param-row.field-microwidgets');
        var grow = $(mpl.template('param-microwidgets'));
        var widget_list = '';

        var pop = mpl.tools.popup.render(this, {
            title: 'Add MicroWidgets',
            class: 'mpl-box-settings-popup mpl-box-subPop',
            width: 400,
            scrollBack: false,
            scrollTo: false,
            float: false,
            footer: false,
            keepCurrentPopups: true,
            drag: false,
        });
        pop.data({
            target: this,
            event: e,
            cancel: function(pop) {
                var ss = 0;
            }
        });
        var row = $(this).closest('.mpl-widgets-rows'),
            values = row.find('.mpl-param').serializeArray(),
            atts = {};
        
        $.map(values, function (n, i) {
            if (n['name'] != undefined)
                atts[n['name']] = n['value'];
        });

        widget_list = '<div class="mpl-microwidgets">';
        widget_list += '<ul class="mpl-microwidgets-list-main mpl-microwidgets-list">';
        for ( var widget in wrp.data('params') ) {
            widget_list += '<li title="" data-support="" data-rule="" class="mpl-element-item mcpn-banner">';
            widget_list += '<div>';
            widget_list += '<i class="cpicon mpl-icon-banner" aria-hidden="true"></i>';
            widget_list += '<span class="cpdes">';
            widget_list += '<strong>' + widget + '</strong>';
            widget_list += '</span>';
            widget_list += '</div>';
            widget_list += '</li>';
        }
        widget_list += '</ul>';
        widget_list += '</div>';
        widget_list = $(widget_list);
        widget_list.on('click', function (e) {
            if (e.target.tagName != 'STRONG')
                return;
            
            var addwidgets = mpl.get.popup(this).data('target');
            var params = mpl.params.fields.microwidgets.set_index(wrp.data('params')[e.target.textContent], wrp.data('name'), e.target.textContent);
            var ct = grow.find('li.counter');
            ct.html(e.target.textContent);
            $(addwidgets).before( grow );
            mpl.params.fields.render( grow.find('.mpl-widgets-body'), params, {} );
            
            var addwidgets_event = mpl.get.popup(this).data('event');
            addwidgets_event.data.collapse( grow.find('li.mpl-collapse') );
            addwidgets_event.data.sortable();

            mpl.get.popup(this, 'close').trigger('click');
        });
        pop.find('.m-p-body').append( widget_list );
        e.preventDefault();
    },

    set_index: function (data_params, data_name, index) {
        var params = [];
        for (var i = 0; i < data_params.length; i++) {
            if (data_params[i]['type'] != 'microwidgets') {
                params[params.length] = $().extend({}, data_params[i]);
                if (data_params[i]['name'].indexOf(data_name + '[') == -1)
                    params[params.length - 1]['name'] = data_name + '[' + index + '][' + data_params[i]['name'] + ']';
            }
        }
        return params;
    },

    sortable: function () {
        mpl.ui.sortable({
            items: 'div.mpl-widgets-rows>div.mpl-widgets-row',
            handle: '>.mpl-widgets-controls',
            helper: ['mpl-ui-handle-image', 25, 25],
            connecting: false,
            vertical: true
        });
    }
},

});$().extend(mpl.params.fields, {

group: {

    callback: function (wrp) {
        this.el = wrp;

        mpl.trigger(this);
        wrp.find('.mpl-group-row').first().addClass('active');

        this.re_index(wrp);
        this.sortable();
    },

    events: {
        '.mpl-group-rows:click': 'actions',
        '.mpl-add-group:click': 'add_group',
    },

    actions: function (e) {

        var target = $(e.target);

        if (target.data('action')) {
            var wrp = $(this).closest('.mpl-param-row.field-group');
            switch (target.data('action')) {
                case 'collapse': e.data.collapse(target); break;
                case 'delete': e.data.remove(target, e.data, wrp); break;
                case 'double': e.data.double(target, e.data, wrp); break;
            }
        }

        if (!target.hasClass('mpl-add-group') && (target.hasClass('mpl-group-controls') || target.hasClass('counter'))) {
            e.data.collapse(target);
        }
    },

    collapse: function (el) {
        var row = el.closest('.mpl-group-row');

        if (row.hasClass('active')) {
            row.removeClass('active');
        }
        else {
            el.closest('.mpl-group-rows').
                find('.mpl-group-row.active').
                removeClass('active');

            row.addClass('active');
        }
    },

    remove: function (el, obj, wrp) {
        if (confirm(/* mpl.__.sure*/'Are you sure that you want to delete this item?')) {
            el.closest('.mpl-group-row').remove();
            obj.re_index(wrp);
        }
    },

    double: function (el, obj, wrp) {
        var row = el.closest('.mpl-group-row'),
            clone_values = row.find('.mpl-param').serializeArray(),
            values = {},
            grow = $(mpl.template('param-group')),
            index = row.find('.mpl-param').get(0).name;

        index = index.substring(index.indexOf('[') + 1, index.indexOf(']'));

        params = mpl.params.fields.group.set_index(wrp.data('params'), wrp.data('name'), index);

        row.after(grow);

        $.map(clone_values, function (n, i) {
            if (n['name'] != undefined)
                values[n['name']] = n['value'];
        });

        mpl.params.fields.render(grow.find('.mpl-group-body'), params, values);

        // reset index of groups list
        mpl.params.fields.group.re_index(wrp);

        obj.collapse(grow.find('li.mpl-collapse'));

        obj.sortable();
    },

    add_group: function (e) {
        var wrp = $(this).closest('.mpl-param-row.field-group');

        var grow = $(mpl.template('param-group'));

        $(this).before(grow);

        var params = mpl.params.fields.group.set_index(wrp.data('params'), wrp.data('name'), 0);

        mpl.params.fields.render(grow.find('.mpl-group-body'), params, {});

        // reset index of groups list
        mpl.params.fields.group.re_index(wrp);

        e.data.collapse(grow.find('li.mpl-collapse'));

        e.data.sortable();
    },

    set_index: function (data_params, data_name, index) {
        var params = [];
        for (var i = 0; i < data_params.length; i++) {
            if (data_params[i]['type'] != 'group') {
                params[params.length] = $().extend({}, data_params[i]);
                if (data_params[i]['name'].indexOf(data_name + '[') == -1)
                    params[params.length - 1]['name'] = data_name + '[' + index + '][' + data_params[i]['name'] + ']';
            }
        }

        return params;
    },

    re_index: function (wrp) {
        var i = 1;
        wrp.find('.mpl-group-row').each(function () {

            $(this).find('input.mpl-param, select.mpl-param, textarea.mpl-param').each(function () {
                if (this.name.indexOf('[') > -1) {

                    var name = this.name.substring(0, this.name.indexOf('[') + 1);
                    name += i;
                    name += this.name.substr(this.name.indexOf(']'));
                    this.name = name;
                }

                this.label = this.name.substr(this.name.indexOf('][') + 2).replace(']', '');

            });

            var label = $(this).find('.mpl-param-row').first().find('input.mpl-param, select.mpl-param, textarea.mpl-param');

            if (label.data('added-change') !== 1) {

                label.data({ 'added-change': 1 });

                label.on('change', function () {
                    var ct = $(this).closest('.mpl-group-row').find('li.counter');
                    var url = this.value;
                    var regex = /^http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?$/i;
                    var is_link = regex.test(this.value);
                    if (is_link) {
                        var tmp = new Array();
                        tmp = url.split("/");
                        var cc = tmp[tmp.length - 1];
                        tmp = cc.split("?");
                        var desc = tmp[0];

                    } else {
                        var desc = mpl.tools.esc(this.value);

                    }

                    var slug = $(this).closest('.mpl-group-row').data('tab');
                    if (slug) {
                        $(this).closest('.mpl-group-rows').find('li[data-tab="' + slug + '"]').html(desc)
                    }
                    else {
                        ct.html(this.label + ': ' + desc);
                    }

                });
            }

            var data = label.serializeArray();

            if (data[0] !== undefined) {
                var url = data[0].value;
                var regex = /^http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?$/i;
                var is_link = regex.test(url);
                if (is_link) {
                    var tmp = new Array();
                    tmp = url.split("/");
                    var cc = tmp[tmp.length - 1];
                    tmp = cc.split("?");
                    var desc = tmp[0];
                } else {
                    var desc = mpl.tools.esc(data[0].value);
                }

                var slug = $(this).closest('.mpl-group-row').data('tab');
                if (slug) {
                    $(this).closest('.mpl-group-rows').find('li[data-tab="' + slug + '"]').html(desc)
                }
                else {
                    $(this).find('li.counter').html(label.get(0).label + ': ' + desc);
                }
            }
            i++;
        });
    },

    sortable: function () {
        mpl.ui.sortable({

            items: 'div.mpl-group-rows>div.mpl-group-row',
            handle: '>.mpl-group-controls',
            helper: ['mpl-ui-handle-image', 25, 25],
            connecting: false,
            vertical: true,
            end: function (e, el) {
                mpl.params.fields.group.re_index($(el).closest('.mpl-param-row.field-group'));
            }
        });
    }
},

});
$().extend(mpl.params.fields, {
/*
    * (!) Field type CSS
    * @ since ver 2.5
*/
css: {

    /*
    *	(!) All screens registered
    */
    screens: {},
    /*
    *	(!) re-map css-field to mpl-fields with default value options
    */
    fields: {

        'undefined': 'text',
        'font-family': 'css_family',
        'font-size': {
            type: 'number',
            options: {
                units: ['px', 'em', '%']
            }
        },
        'font-weight': {
            type: 'select_group',
            options: {
                custom: true,
                tooltip: true,
                buttons: {
                    '': '<i class="fa-ban"></i>',
                    '300': '300',
                    '400': '400',
                    '500': '500',
                    '600': '600',
                    '700': '700',
                    '800': '<strong>800</strong>',
                }
            }
        },
        'font-style': {
            type: 'select_group',
            options: {
                custom: true,
                tooltip: true,
                buttons: {
                    'normal': '<i class="fa-ban"></i>',
                    'italic': '<i style="font-style:italic;font-family:serif">I</i>',
                }
            }
        },
        'text-align': {
            type: 'select_group',
            options: {
                custom: true,
                tooltip: true,
                buttons: {
                    '': '<i class="fa-ban"></i>',
                    'left': '<i class="fa-align-left"></i>',
                    'center': '<i class="fa-align-center"></i>',
                    'right': '<i class="fa-align-right"></i>',
                    'justify': '<i class="fa-align-justify"></i>',
                }
            }
        },
        'text-transform': {
            type: 'select_group',
            options: {
                custom: true,
                tooltip: true,
                buttons: {
                    'none': '<i class="fa-ban"></i>',
                    'uppercase': 'TT',
                    'capitalize': 'Tt',
                    'lowercase': 'tt',
                }
            }
        },
        'text-decoration': {
            type: 'select_group',
            options: {
                custom: true,
                tooltip: true,
                buttons: {
                    'none': '<i class="fa-ban"></i>',
                    'underline': '<u>T</u>',
                    'line-through': '<span style="text-decoration: line-through">T</span>',
                }
            }
        },
        'line-height': {
            type: 'number',
            options: {
                units: ['px', 'em', '%']
            }
        },
        'letter-spacing': {
            type: 'number',
            options: {
                units: ['px', 'em', '%']
            }
        },
        'overflow': {
            type: 'select',
            options: {
                '': '=== Select ===',
                'auto': 'Auto',
                'hidden': 'Hidden',
                'inherit': 'Inherit',
                'initial': 'Initial',
                'overlay': 'Overlay',
                'scroll': 'Scroll',
                'visible': 'Visible'
            }
        },
        'word-break': {
            type: 'select',
            options: {
                '': '=== Select ===',
                'break-all': 'Break All',
                'break-word': 'Break Word',
                'inherit': 'Inherit',
                'initial': 'Initial',
                'normal': 'Normal',
            }
        },
        'color': 'color_picker',
        'background-color': 'color_picker',
        'border-color': 'color_picker',
        'border-top-color': 'color_picker',
        'border-right-color': 'color_picker',
        'border-bottom-color': 'color_picker',
        'border-left-color': 'color_picker',
        'border-style': {
            type: 'select',
            options: {
                'none': 'None',
                'solid': 'Solid',
                'dotted': 'Dotted',
                'dashed': 'Dashed',
                'double': 'Double',
                'groove': 'Groove',
                'ridge': 'Ridge',
                'inset': 'Inset',
                'outset': 'Outset',
                'initial': 'Initial',
                'inherit': 'Inherit',
            }
        },
        'align-items': {
            type: 'select',
            options: {
                '': '=== Select ===',
                'inherit': 'Inherit',
                'baseline': 'Baseline',
                'center': 'Center',
                'flex-end': 'Flex-end',
                'flex-start': 'Flex-start',
                'initial': 'Tnitial',
                'stretch': 'Stretch',
            }
        },
        'border-width': {
            type: 'number',
            options: {
                units: ['px', 'em', '%']
            }
        },
        'background': {
            type: 'css_background',
            label: ''
        },
        'video-background': {
            type: 'css_video_background',
            label: ''
        },
        'width': {
            type: 'number',
            options: {
                units: ['px', 'em', '%']
            }
        },
        'height': {
            type: 'number',
            options: {
                units: ['px', 'em', '%']
            }
        },
        'margin': {
            type: 'corners',
            options: {
                'margin-top': 'Top',
                'margin-right': 'Right',
                'margin-bottom': 'Bottom',
                'margin-left': 'Left',
            },
            des: 'Drag on input to change the value, double click to remove value'
        },
        'margin-right': {
            type: 'number',
            options: {
                units: ['px', 'em']
            }
        },
        'padding': {
            type: 'corners',
            options: {
                'padding-top': 'Top',
                'padding-right': 'Right',
                'padding-bottom': 'Bottom',
                'padding-left': 'Left',
            },
            des: 'Drag on input to change the value, double click to remove value'
        },
        'border': 'css_border',
        'border-radius': {
            type: 'corners',
            options: {
                'border-top-left-radius': 'Top Left',
                'border-top-right-radius': 'Top Right',
                'border-bottom-right-radius': 'Bottom Right',
                'border-bottom-left-radius': 'Bottom Left',
            }
        },
        'float': {
            type: 'select_group',
            options: {
                custom: true,
                tooltip: true,
                buttons: {
                    '': '<i class="fa-ban"></i>',
                    'left': 'Left',
                    'right': 'Right',
                    'inherit': 'Inherit',
                    'initial': 'Initial',
                    'none': 'None',
                }
            }
        },
        'display': {
            type: 'select_group',
            options: {
                custom: true,
                tooltip: true,
                buttons: {
                    '': '<i class="fa-ban"></i>',
                    'inline-block': 'IB',
                    'inline': 'Inline',
                    'block': 'Block',
                    'flex': 'Flex',
                    'none': 'None',
                }
            }
        },
        'cursor': {
            type: 'select_group',
            options: {
                custom: true,
                tooltip: true,
                buttons: {
                    '': '<i class="fa-ban"></i>',
                    'pointer': 'Pointer',
                    'default': 'Default',
                    'text': 'Text',
                    'help': 'Help',
                }
            }
        },
        'opacity': {
            type: 'number_slider',
            options: {
                min: 0,
                max: 100,
                ratio: 0.01
            },
            value: ''
        },
        'box-shadow': 'text',
        'text-shadow': 'text',
        'gap': {
            type: 'number',
            options: {
                units: ['px', 'em']
            }
        },
        'max-width': {
            type: 'number',
            options: {
                units: ['px', 'em', '%']
            }
        },
        'custom': {
            type: 'custom',
            des: '<ul><li>- Click outside of the textarea to apply changes.</li><li>- This has a higher priority than the visual selection</li></ul>'
        }

    },

    /*
        * (!) remap structure { 
            screen: { 
                property|selector: { selector, label, group }  
                color|a:hover: { selector, label, group }  
            } 
        }
    */
    remap: function (ops) {

        this.screens = {};
        // loop sections
        for (var i = 0; i < ops.length; i++) {
            this.remap_screen(ops[i]);
        }

        return this.screens;

    },

    remap_screen: function (op) {

        var np, i, gr, itm, scr, screens = ['any'], properties, prs;

        if (op.screens !== undefined)
            screens = op.screens.split(',');

        for (gr in op) { // loop grs

            if (gr != 'screens') {

                for (itm = 0; itm < op[gr].length; itm++) { // loop in itms

                    if (op[gr][itm].property !== undefined) {
                        /* start update multiple properties */
                        properties = op[gr][itm].property.replace(/\ /g, '').split(',');
                        labels = (op[gr][itm].label !== undefined) ? op[gr][itm].label.split(',') : [];

                        for (prs in properties) {

                            if (labels[prs] !== undefined)
                                op[gr][itm].label = labels[prs];
                            else op[gr][itm].label = properties[prs].replace(/\-/g, ' ').replace(/\_/g, ' ');

                            np = properties[prs] + '|';
                            /* end update multiple properties */
                            if (op[gr][itm].selector !== undefined && op[gr][itm].selector !== '')
                                np += op[gr][itm].selector;

                            for (i = 0; i < screens.length; i++) { // loop screens

                                scr = screens[i].trim();

                                if (this.screens[scr] === undefined)
                                    this.screens[scr] = {};

                                if (this.screens[scr][gr] === undefined)
                                    this.screens[scr][gr] = {};

                                this.screens[scr][gr][np] = $.extend({}, op[gr][itm]);

                            }

                        }

                    }

                }
            }
        }

    },

    render: function (data, wrp) {

        var screens = this.remap(data.options), i, li, values,
            scr_nav = $('<ul class="mpl-css-screens-nav"></ul>'),
            keys = Object.keys(screens).sort(function (a, b) { return parseInt(a, 10) < parseInt(b, 10); });

        try {

            values = JSON.parse(data.value.replace(/(?:\r\n|\r|\n)/g, '').replace(/\`/g, '"'));

            if (values['mpl-css'] === undefined || typeof values['mpl-css'] != 'object')
                values = {};
            else values = values['mpl-css'];

        } catch (ex) { values = {}; }

        for (i = 0; i < keys.length; i++) {

            li = $('<li data-screen="' + keys[i] + '">' + this.responsive_icon(keys[i]) + '</li>');

            if (keys[i] == 'any')
                scr_nav.prepend(li);
            else scr_nav.append(li);

            li.data('predatas', [
                screens[keys[i]],
                wrp.get(0),
                keys[i],
                (values[keys[i]] !== undefined ? values[keys[i]] : {})
            ]);

            /*
            this.render_groups( 
                screens[keys[i]], 
                wrp, 
                keys[i], 
                (values[keys[i]] !== undefined ? values[keys[i]] : {}) 
            );*/

        }

        /*
        *	If there are only screen "any", then hidden the screens nav
        */

        if (keys.length === 1 && keys[0] == 'any')
            scr_nav.addClass('mpl-css-hidden');

        wrp.prepend(scr_nav);

        // return to default height, 
        // set a default height to prevent flash screen when switching tabs
        wrp.css({ 'min-height': '' });

        // Add events after everything has been rendered
        mpl.trigger({

            el: wrp,
            events: {
                'click': 'click',
                '.mpl-css-screens-nav li:click': 'screen_tabs'
            },

            click: function (e) {

                if (e.target.className == 'mpl-css-important') {

                    var prow = $(e.target).closest('.mpl-param-row');

                    if (prow.hasClass('is-important'))
                        prow.removeClass('is-important');
                    else prow.addClass('is-important');

                    $(e.target).parent().find('.mpl-css-param').trigger('change');

                }
            },

            screen_tabs: function (e) {

                var el = $(this), sc = el.data('screen'), pd = el.data('predatas');

                if (pd !== null) {
                    mpl.params.fields.css.render_groups(pd[0], $(pd[1]), pd[2], pd[3]);
                    el.data('predatas', null);
                }

                el.parent().find('>li.active').removeClass('active');
                el.addClass('active');

                var rows = el.closest('.mpl-css-rows').find('.mpl-css-screen');

                rows.addClass('mpl-css-hidden');
                rows.filter('.mpl-css-screen-' + sc).removeClass('mpl-css-hidden');

            }

        });

        var screen = $('body').data('screen-size');

        if ($('#mpl-top-toolbar li.active').length > 0)
            screen = $('#mpl-top-toolbar li.active').data('screen');

        if (screen == '100%')
            screen = 'any';
        else if (screen == '768')
            screen = '999';

        if (screen !== undefined && scr_nav.find('li[data-screen="' + screen + '"]').length > 0) {

            scr_nav.find('li[data-screen="' + screen + '"]').trigger('click');

        } else wrp.find('.mpl-css-screens-nav li').first().trigger('click');

    },

    render_groups: function (groups, wrp, sc, values) {

        var screen_el = $('<div data-screen="' + sc + '" class="mpl-css-screen mpl-css-hidden mpl-css-screen-' + sc + '"></div>'),
            nav = $('<ul class="mpl-css-group-nav"></ul>'),
            grps = Object.keys(groups),
            name, des, type, n, label, value, is_impt, i;

        for (n in grps)
            nav.append('<li>' + grps[n].replace(/\_/g, ' ') + '</li>');

        if (sc == 'any')
            nav.append('<li class="right">any screens</li>');
        else if (sc.indexOf('-') > -1)
            nav.append('<li class="right">screen ' + sc.replace('-', '=>') + '</li>');
        else nav.append('<li class="right">screen Max ' + sc + 'px</li>');

        screen_el.append(nav);

        if (grps.length <= 1)
            nav.addClass('mpl-css-hidden');

        for (i in groups) {

            for (n in groups[i]) {

                name = n.split('|')[0];
                des = '';
                is_impt = false;

                label = name.replace(/\-/g, ' ');
                atts = mpl.params.fields.css.fields[name];

                if (atts === undefined) {
                    console.error('MPL: The css property ' + name + ' is not defined.');
                    atts = mpl.params.fields.css.fields['undefined'];
                }

                if (values[mpl.tools.esc_slug(i)] !== undefined && values[mpl.tools.esc_slug(i)][n] !== undefined)
                    value = values[mpl.tools.esc_slug(i)][n];
                else if (groups[i][n].value !== undefined)
                    value = groups[i][n].value;
                else if (atts.value !== undefined)
                    value = atts.value;
                else value = '';

                if (atts === undefined) {
                    type = 'underfined';
                    atts = [];
                } else if (typeof atts == 'string')
                    type = atts;
                else if (atts.type !== undefined)
                    type = atts.type;
                else if (atts.type === undefined)
                    type = 'text';

                if (atts.label !== undefined)
                    label = atts.label;

                if (groups[i][n].label !== undefined)
                    label = groups[i][n].label;

                if (atts.des !== undefined)
                    des = atts.des;

                if (groups[i][n].des !== undefined)
                    des = groups[i][n].des;

                if (mpl_param_types_support.indexOf(type) == -1)
                    type = 'text';

                if (value.toString().indexOf('!important') > -1) {
                    value = value.replace('!important', '').trim();
                    is_impt = true;
                }

                if (type == 'custom') {
                    value = value.replace(/\;/g, ";\n");
                }

                atts = {
                    value: value,
                    options: ((atts.options !== undefined) ? atts.options : []),
                    params: [],
                    name: 'mpl-css[' + sc + '][' + mpl.tools.esc_slug(i) + '][' + n + ']',
                    type: type,
                    label: label
                };

                if (type != 'textarea_html')
                    atts.value = mpl.tools.unesc_attr(atts.value);

                var tmpl_html = mpl.template('field', {
                    label: label,
                    content: mpl.template('field-type-' + type, atts),
                    name: type,
                    des: des,
                    base: n,
                });

                tmpl_html = tmpl_html
                    .replace(/\&lt\;script/g, '<script')
                    .replace(/\&lt\;\/script\&gt\;/g, '</script>')
                    .replace(/mpl\-param\"/g, 'mpl-css-param"')
                    .replace(/mpl\-param /g, 'mpl-css-param ');

                var field = $(tmpl_html);

                screen_el.append(field);

                if (is_impt === true)
                    field.addClass('is-important');

                field.addClass('mpl-css-group-' + mpl.tools.esc_slug(i) + ' mpl-css-hidden')
                    .attr({ 'data-name': n.replace(/\"/g, '') })
                    .append('<span class="mpl-css-important" title="Important"></span>');

                if (typeof atts.callback == 'function')
                    setTimeout(atts.callback, 1, field, $, atts);

                //if has refer field
                if (undefined != groups[i][n]['refer']) {
                    for (rf in groups[i][n]['refer']) {
                        var rfn = groups[i][n]['refer'][rf]['property'] + '|' + groups[i][n]['refer'][rf]['selector'];
                        atts = {
                            value: rfn,
                            options: ((atts.options !== undefined) ? atts.options : []),
                            params: [],
                            name: 'mpl-css[' + sc + '][' + mpl.tools.esc_slug(i) + '][' + n + ']',
                            type: 'hidden',
                            label: ''
                        };

                        var rftmpl_html = mpl.template('field-type-hidden', atts);

                        rftmpl_html = rftmpl_html
                            .replace(/\&lt\;script/g, '<script')
                            .replace(/\&lt\;\/script\&gt\;/g, '</script>')
                            .replace(/mpl\-param\"/g, 'mpl-css-refer"')
                            .replace(/mpl\-param /g, 'mpl-css-refer');

                        var rfield = $(rftmpl_html);
                        screen_el.append(rfield);
                    }

                }

            }

        }

        wrp.append(screen_el);

        screen_el.find('.mpl-css-group-nav li').on('click', function (e) {

            var el = $(this),
                rows = el.closest('.mpl-css-screen').find('>.mpl-param-row');
            slug = mpl.tools.esc_slug(el.html());

            if (el.hasClass('right'))
                return;

            el.parent().find('>li.active').removeClass('active');
            el.addClass('active');

            rows.addClass('mpl-css-hidden');
            rows.filter('.mpl-css-group-' + slug).removeClass('mpl-css-hidden');

        }).first().trigger('click');

        mpl.do_action('mpl-css-field-change', wrp, wrp.closest('.mpl-params-popup'));

        delete n, nav, name, des, type, value, grps, i;

    },

    responsive_icon: function (sc) {

        if (sc == 'any')
            return '<i class="fa-desktop"></i>';

        sc = parseInt(sc, 10);

        if (sc < 480)
            return '<i class="fa-mobile"></i>';
        else if (sc < 768)
            return '<i style="transform:rotate(90deg)" class="fa-mobile"></i>';
        else if (sc < 1000)
            return '<i class="fa-tablet"></i>';
        else if (sc < 1025)
            return '<i style="transform:rotate(90deg)" class="fa-tablet"></i>';

        return '<i class="fa-desktop"></i>';

    },

    save_fields: function (pop) {

        pop.find('.mpl-param-row.field-css').each(function () {

            $(this).find('.mpl-field-css-value').val(mpl.params.fields.css.field_values(this));

        });

        /*
        *	when use new css system, we will remove all data of old css system
        */

        try {
            delete mpl.storage[pop.data('model')].args.css;
        } catch (err) { }
    },

    field_values: function (field) {

        var el = $(field).find('.mpl-field-css-value'),
            newcss = this.get_fields($(field), true),
            css = el.val();

        try {
            css = JSON.parse(css.replace(/(?:\r\n|\r|\n)/g, '').replace(/\`/g, '"'));
            if (css['mpl-css'] === undefined)
                css = { 'mpl-css': {} };
        } catch (ex) {
            css = { 'mpl-css': {} };
        }

        if (newcss['mpl-css'] !== undefined) {

            for (var scr in newcss['mpl-css']) {
                css['mpl-css'][scr] = newcss['mpl-css'][scr];
            }

            css = mpl.params.fields.css.sort_screens(css);
            css = JSON.stringify(css).replace(/\"/g, '`');
            //el.val(css);

            return css;
        }
        return '';
    },

    get_fields: function (wrp, isobj) {

        var impt = {},
            inputs = wrp.find('.mpl-css-param').serializeArray(),
            refers = wrp.find('.mpl-css-refer').serializeArray(),
            values = mpl.tools.reIndexForm(inputs, []),
            rf_values = mpl.tools.reIndexForm(refers, []),
            s, g, p, rfp, rfps;
        wrp.find('.mpl-param-row.is-important').each(function () {
            impt[$(this).find('.mpl-css-param').attr('name')] = true;
        });

        for (s in values['mpl-css']) { // loop screen

            if (typeof values['mpl-css'][s] == 'object') {

                for (g in values['mpl-css'][s]) { // loop group

                    if (typeof values['mpl-css'][s][g] == 'object') {

                        for (p in values['mpl-css'][s][g]) { // loop properties
                            values['mpl-css'][s][g][p] = values['mpl-css'][s][g][p]
                                .toString().replace(/(?:\r\n|\r|\n)/g, '')
                                .replace(/\`/g, '');

                            if (values['mpl-css'][s][g][p] === '')
                                delete values['mpl-css'][s][g][p];
                            // This field has been marked as important
                            else if (impt['mpl-css[' + s + '][' + g + '][' + p + ']'] === true && values['mpl-css'][s][g][p] !== '')
                                values['mpl-css'][s][g][p] = values['mpl-css'][s][g][p] + ' !important';

                            //add refer values
                            if (values['mpl-css'][s][g][p] != '' &&
                                typeof rf_values['mpl-css'] == 'object' &&
                                typeof rf_values['mpl-css'][s] == 'object' &&
                                typeof rf_values['mpl-css'][s][g] == 'object' &&
                                typeof rf_values['mpl-css'][s][g][p] == 'string') {

                                rfps = rf_values['mpl-css'][s][g][p].split(',');
                                for (rfp in rfps) {
                                    values['mpl-css'][s][g][rfps[rfp]] = values['mpl-css'][s][g][p];
                                }
                            }
                        }
                    }

                    if (Object.keys(values['mpl-css'][s][g]).length === 0)
                        delete values['mpl-css'][s][g];

                }

                if (Object.keys(values['mpl-css'][s]).length === 0)
                    delete values['mpl-css'][s];

            } else if (values['mpl-css'][s] === '')
                delete values['mpl-css'][s];

        }

        if (Object.keys(values['mpl-css']).length > 0) {
            if (isobj === true)
                return values;
            else return JSON.stringify(values).replace(/\"/g, '`');
        } else return '';

    },

    sort_screens: function (css) {

        var keys = [], scr, sort = { 'mpl-css': {} }, i, j, t;

        for (scr in css['mpl-css']) {
            if (scr == 'any')
                sort['mpl-css']['any'] = css['mpl-css']['any'];
            else keys.push(parseInt(scr, 10))
        }

        for (i = 0; i < keys.length; i++) {
            for (j = i + 1; j < keys.length; j++) {
                if (keys[i] < keys[j]) {
                    t = keys[j];
                    keys[j] = keys[i];
                    keys[i] = t;
                }
            }
        }

        for (scr in keys) {
            sort['mpl-css'][keys[scr].toString()] = css['mpl-css'][keys[scr].toString()];
        }
        return sort;
    }
}

});$().extend(mpl.params, {

admin_label: {

    render: function (data) {

        var html = '', item = '';
        /**
        *	register admin view
        */
        if (data.map.admin_view !== undefined) {
            if (typeof (window[data.map.admin_view]) == 'function')
                item = window[data.map.admin_view](data.params.args, data.el);
            else if (typeof mpl.params.admin_view[data.map.admin_view] == 'function')
                item = mpl.params.admin_view[data.map.admin_view](data.params.args, data.el);
            else console.log('MPL Error: the admin_view function "' + data.map.admin_view + '" is undefined');

            if (item !== '') {
                return '<div class="admin-view custom-admin-view ' + data.map.admin_view + '">' + item + '</div>';
            }

        }

        var dmp = mpl.params.merge(data.map.params), dp = data.params, mpa = mpl.params.admin_label;

        for (var n in dmp) {

            item = '';

            if (dmp[n].name == 'image' && dp.args[dmp[n].name] === undefined)
                dp.args[dmp[n].name] = '';

            if (dmp[n].admin_label === true && dp.args[dmp[n].name] !== undefined && dp.args[dmp[n].name] != '__empty__') {
                if (typeof mpa[dmp[n].type] == 'function') {
                    item = mpa[dmp[n].type](
                        dp.args[dmp[n].name], dmp[n].label, data.el
                    );
                }
                else {
                    item = '<span class="admin-view-label"><strong>' + dmp[n].name + '</strong></span> : ';
                    item += mpl.tools.unesc_attr(dp.args[dmp[n].name]);
                }

                if (item !== '') {

                    html += '<div class="admin-view ' + dmp[n].name + '" data-name="' + dmp[n].name + '">' + item + '</div>';

                }
            }
        }

        return html;

    },

    update: function () {

        clearTimeout(this.timer);

        this.timer = setTimeout(function (el) {

            var name = $(el).data('name').trim(),
                model = mpl.get.model(el);

            if (mpl.storage[model] === undefined)
                return;

            mpl.storage[model].args[name] = el.innerHTML;

            if (name == 'content')
                mpl.storage[model].content = el.innerHTML;

            mpl.confirm(true);

        }, 500, this);

    },

    attach_image: function (id) {

        return '<img src="' + mpl_ajax_url + '?action=mpl_get_thumbn&id=' + id + '" />';
    },

    attach_images: function (ids) {

        if (ids === undefined || ids === '')
            return '<img src="' + mpl_ajax_url + '?action=mpl_get_thumbn&id=undefined" />';

        var html = '';
        ids.split(',').forEach(function (id) {
            html += '<img src="' + mpl_ajax_url + '?action=mpl_get_thumbn&id=' + id + '&size=thumbnail" />';
        });
        return html;

    },

    textarea_html: function (content) {
        return content;
    },

    editor: function (content) {
        return mpl.tools.base64.decode(content);
    },

    textarea: function (content, label) {
        var string = mpl.tools.esc(mpl.tools.base64.decode(content.replace(/(?:\r\n|\r|\n)/g, ''))).toString();
        string = '<span class="admin-view-label"><strong>' + label + ' : </strong></span>' + string;
        if (string.length < 350)
            return string;
        else return string.substr(0, 347) + '...';
    },

    mpl_box: function (content) {

        var html = '', obj;
        try {
            content = mpl.tools.base64.decode(content.replace(/(?:\r\n|\r|\n)/g, '')).toString();
            content = content.replace(/\%SITE\_URL\%/g, mpl_site_url).replace(/\%SITE\_URI\%/g, mpl_site_url);
            obj = JSON.parse(content);
        } catch (e) {
            obj = [{ tag: 'div', children: [{ tag: 'text', content: 'There was an error with content structure.' }] }];
        }
        function loop(items) {

            if (items === undefined || items === null)
                return '';

            var html = '';

            items.forEach(function (n) {

                if (n.tag != 'text') {

                    html += '<' + n.tag;

                    if (typeof n.attributes != 'object')
                        n.attributes = {};

                    if (n.tag == 'column') {
                        n.attributes.class += ' ' + n.attributes.cols;
                    } else if (n.tag == 'img') {
                        if (n.attributes.src === undefined || n.attributes.src === '')
                            n.attributes.src = mpl_plugin_url + '/assets/images/get_start.jpg';
                    }

                    for (var i in n.attributes)
                        html += ' ' + i + '="' + n.attributes[i] + '"';

                    if (n.tag == 'img')
                        html += '/';

                    html += '>';

                    if (typeof n.children == 'object')
                        html += loop(n.children);

                    if (n.tag != 'img')
                        html += '</' + n.tag + '>';

                } else html += n.content;

            });

            return html;

        }

        return loop(obj);
    },

    wp_widget: function (data) {

        var obj;
        try {
            obj = JSON.parse(mpl.tools.base64.decode(data));
        } catch (e) {
            return 'There was an error with content structure.';
        }
        var html = '', vl, prp;
        for (var n in obj) {
            html += '<strong class="prime">' + n.replace(/\-/g, ' ').replace(/\_/g, ' ') + '</strong>: ';
            prp = [];
            for (var m in obj[n]) {
                if (obj[n][m] !== '') {
                    vl = mpl.tools.esc(obj[n][m]);
                    if (vl.length > 250)
                        vl = vl.substr(0, 247) + '...';
                    prp[prp.length] = '<strong>' + m + '</strong>: ' + vl;
                }
            }
            html += prp.join(', ');
        }
        return html;
    },

    icon_picker: function (data, label, el) {

        return '<i class="' + data + '" style="font-size: 14px;margin: 0px;font-weight: bold;"></i>';

    },

    color_picker: function (data, label) {
        return '<strong>' + label + '</strong>: ' + data + ' <span style="background: ' + data + '"></span>';
    }

},

admin_view: {

    image: function (params, el) {

        var url = mpl_ajax_url + '?action=mpl_get_thumbn&id=undefined',
            mid = (params.image !== undefined) ? params.image : '',
            featured_img_id = $("#_thumbnail_id").val();

        if (params.image_source !== undefined) {

            switch (params.image_source) {

                case 'media_library':
                    url = mpl_ajax_url + '?action=mpl_get_thumbn&id=' + mid;
                    break;

                case 'featured_image':
                    url = mpl_ajax_url + '?action=mpl_get_thumbn&id=' + featured_img_id;
                    break;

                case 'external_link':
                    url = params.image_external_link;
                    break;

            }

        }

        setTimeout(function (el) {

            el.find('.admin-view.custom-admin-view img')
                .attr({ title: 'Click to select media from library' })
                .css({ cursor: 'pointer' })
                .on('click', {
                    callback: function (atts) {

                        var url = atts.url;

                        if (typeof atts.sizes.medium == 'object')
                            url = atts.sizes.medium.url;

                        this.el.src = url;
                        var model = mpl.get.model(this.el);

                        if (mpl.storage[model] === undefined)
                            return;

                        mpl.storage[model].args['image'] = atts.id;
                        mpl.storage[model].args['image_source'] = 'media_library';

                        $(this.el).parent().find('.mpl-param').val(atts.id);

                        mpl.confirm(true);

                    }, atts: { frame: 'select' }
                }, mpl.tools.media.open);

        }, 10, el);

        return '<input type="hidden" class="mpl-param" value="' + mid + '" /><img src="' + url + '" />';

    },

    gmaps: function (params, el) {

        var value = '', html = '';

        if (typeof (params['title']) != 'undefined' && params['title'] !== '')
            html += '<strong>Title</strong>: ' + params['title'] + ' ';

        if (typeof (params['map_location']) != 'undefined' && params['map_location'] !== '')
            value = mpl.tools.base64.decode(params['map_location']);

        if (value !== '') {
            value = value.match(/src\=\"([^\s]*)\"\s/);
            if (value !== null && typeof (value[1]) != 'undefined') {
                value = value[1].split('!');
                value = value[value.length - 6].substr(2);
                if (value.match(/[^0-9,.]/) !== null)
                    html += '<strong>Location</strong>: ' + mpl.tools.base64.decode(value);
            }
        }

        return html;
    },

    text: function (params, el) {

        setTimeout(function (el) {

            el.find('.admin-view.custom-admin-view')
                .attr({ contentEditable: true })
                .data({ name: 'content' })
                .on('keyup', mpl.params.admin_label.update);

            if (window.chrome === undefined) {

                el.find('.admin-view.custom-admin-view')
                    .on('mousedown', function (e) {
                        var el = this;
                        while (el.parentNode) {
                            el = el.parentNode;
                            if (el.draggable === true) {
                                el.draggable = false;
                                el.templDraggable = true;
                            }
                        }
                    }).on('blur', function (e) {
                        var el = this;
                        while (el.parentNode) {
                            el = el.parentNode;
                            if (el.templDraggable === true) {
                                el.draggable = true;
                                el.templDraggable = null;
                            }
                        }
                    });
            }

        }, 10, el);

        if (window.switchEditors !== undefined)
            return switchEditors.wpautop(params['content']);
        else return params['content'];

    }

},

});
$().extend(mpl.params, {

process: function () {
	/*
	*	Start getting the content to process 
	*/
	if (typeof (tinyMCE) != 'undefined')
		tinyMCE.triggerSave();

	var content = $('#content').val();
	/*
	*	do not process empty content
	*/
	if (content === undefined || content.trim() === '')
		return;
	/*
	*	basic convert the format of another page builders
	*/
	content = content.replace(/\[vc\_/g, '[mpl_')
		.replace(/\[\/vc\_/g, '[/mpl_')
		.replace(/\[mini\_/g, '[mpl_')
		.replace(/\[\/mini\_/g, '[/mpl_')
		.replace(/\[mpl\_section\_service\_2/g, '[mpl_section_service')
		.replace(/\[mpl\_section\_service\_3/g, '[mpl_section_service')
		.replace(/\[mpl\_section\_service\_4/g, '[mpl_section_service')
		.replace(/\[mpl\_section\_service\_5/g, '[mpl_section_service')
		.replace(/\[mpl\_section\_post\_carousel\_2/g, '[mpl_section_post_carousel')
		.replace(/\[mpl\_section\_carousel\_post/g, '[mpl_section_post_carousel')
		.toString().trim();
	/*
	* Trim all htmls outside
	*/
	if (content.indexOf('[mpl_row') > 0) {
		content = content.substring(content.indexOf('[mpl_row'));
		// reverse string to check ending
		content = mpl.tools.reverse(content);
		if (content.indexOf(']wor_ck/[') > 0) {
			content = content.substring(content.indexOf(']wor_ck/['));
		}
		// reverse back
		content = mpl.tools.reverse(content);
	}

	/*
	* Start to process all rows level 1
	*/
	this.process_rows(content);

},

process_rows: function (content) {

	if (content.indexOf('[mpl_row') !== 0) {

		/*
		*	Make sure the content wrapped inside [mpl_row]...[/mpl_row]
		*/
		content = '[mpl_row' + this.get_atts('mpl_row') + ']' + content.replace(/mpl_row/g, 'mpl_row#') + '[/mpl_row]';

	}
	/*
	*	render rows level 1
	*/
	this.process_shortcodes(content, function (args) {

		mpl.views.row.render(args);

	}, 'mpl_row');

},

process_columns: function (content, parent_row) {

	this.process_shortcodes(content, function (args) {

		parent_row.append(mpl.views.column.render(args));

	}, 'mpl_column');

},

process_all: function (content, wrp, js_views) {

	if (content === '')
		return false;

	if (wrp === undefined)
		return false;

	var thru = false, first = true, sys = mpl_plugin_url, id, btn, js_view;

	mpl.params.process_shortcodes(content, function (args) {

		thru = true;
		args.parent_wrp = wrp;
		args.first = first;
		first = false;

		if (mpl.maps[args.name] === undefined) {
			args.name = 'mpl_undefined';
			args.end = '[/mpl_undefined]';
			args.args.content = args.full;
		}

		if (_.isUndefined(js_views)) {

			js_view = args.name;

			if (mpl.maps[args.name].views !== undefined) {
				if (mpl.maps[args.name].views.type !== undefined)
					js_view = mpl.maps[args.name].views.type;
				if (mpl.maps[args.name].views.default !== undefined && args.args.content === '')
					args.args.content = mpl.maps[args.name].views.default;
			}

		}
		else {
			js_view = js_views;
		}
		var el;
		if (typeof mpl.views[js_view] == 'object') {
			el = mpl.views[js_view].render(args);
		}
		else {
			el = mpl.views.mpl_element.render(args);
		}



		id = el.data('model');
		wrp.append(el);

		if (js_view == 'views_section') {
			setTimeout(function (content, el) {
				mpl.params.process_all(content, el);
			}, 1, args.args.content, el.find('> .mpl-views-section-wrap'));

			mpl.views.views_section.init(args, el);
		}

	}, mpl.tags);

	if (thru === false) {
		var el = mpl.views.
			mpl_undefined.
			render({
				args: { content: content },
				name: 'mpl_undefined',
				end: '[/mpl_undefined]',
				full: content
			});

		id = el.data('model');

		wrp.append(el);

	} else if (js_views === 'views_section') {
		setTimeout(function (el) { mpl.ui.views_sections(el); }, 1, wrp);
	}

	return id;
},

process_alter: function (input, tag) {

	if (input === undefined)
		input = '';

	/* remove ### of containers loop */
	var start = input.indexOf('[' + tag + '#');
	if (start > -1) {
		var str = input.substring(start + 1, input.indexOf(']', start)).split(' ')[0];
		var exp = new RegExp(str, 'g');
		input = input.replace(exp, tag);
	}

	return input;

},

process_shortcodes: function (input, callback, tags) {

	if (_.isUndefined(input))
		return null;

	var regx = new RegExp('\\[(\\[?)(' + tags + ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)', 'g'), result, agrs, content = input;
	var split_arguments = /([a-zA-Z0-9\-\_\.]+)="([^"]+)+"/gi;

	while (result = regx.exec(input)) {

		var paramesArg = [];
		while (agrs = split_arguments.exec(result[3])) {
			//paramesArg[ agrs[1] ] = agrs[2];原代码
			//magee start
			if (agrs[1] === 'css_custom') {
				var start = input.indexOf('{');
				var end = input.lastIndexOf('}');
				paramesArg[agrs[1]] = input.substring(start, end + 1).replace(/"/g, "`");
			} else {
				paramesArg[agrs[1]] = agrs[2];
			}
			//magee end
		}

		/*
		*	(!) Make sure that the id of each element is not identical
		*/
		if (!paramesArg['_id']) {
			paramesArg['_id'] = Math.round(Math.random() * 1000000);
		}

		var args = {
			full: result[0],
			name: result[2],
			/*parames 	: result[3],*/
			/*content 	: result[5],*/
			end: result[6],
			args: paramesArg,
			/*input		: input,
			result		: result*/
		};

		if (!_.isUndefined(result[5]))
			args.args.content = mpl.params.process_alter(result[5], result[2]);

		callback(args);
		content = content.replace(result[0], '');

	}

	if (content !== '')
		callback({ full: content, name: 'mpl_column_text', end: '[/mpl_column_text]', args: { content: content } });
},

merge: function (input) {
	if (input === undefined || input == '')
		return [];

	var params = [], merge = [];

	if (typeof input == 'object')
		params = input;
	else if (mpl.maps[input] !== undefined)
		params = mpl.maps[input].params;

	if (params[0] !== undefined) {
		return params;
	} else {
		var i, j;
		for (i in params) {
			if (params[i][0] !== undefined) {
				j = 0;
				for (j in params[i])
					merge.push(params[i][j]);
			}
		}
	}

	return merge;
},

get_types: function (name) {

	var merge = this.merge(name), params = {};

	for (var i in merge) {
		if (merge[i].name !== undefined) {
			params[merge[i].name] = merge[i].type;
		}
	}

	return params;
},

get_values: function (name) {
	var merge = this.merge(name), params = {};

	for (var i in merge) {
		if (merge[i].name !== undefined && merge[i].value !== undefined) {
			params[merge[i].name] = merge[i].value;
		}
	}
	return params;
},

get_atts: function (name) {
	var atts = '', params = this.get_values('mpl_row');

	for (var name in params)
		atts += ' ' + name + '="' + mpl.tools.esc_attr(params[name]) + '"';
	return atts;
}

});

})(jQuery);

