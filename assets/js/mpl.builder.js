(function ($) {



window.mpl = $.extend({
backbone: {

	views: function (ismodel) {

		this.ismodel = ismodel;
		this.el = null;
		this.events = null;
		this.render = function (params, p1, p2, p3, p4, p5) {

			var rended = this._render(params, p1, p2, p3, p4, p5);

			if (this.el === null)
				this.el = rended;

			if (typeof this.events == 'object') {
				mpl.trigger(this);
			}

			if (this.ismodel != 'no-model') {
				if (mpl.front) {
					params = $().extend($().extend({ args: {}, model: id }, params));
					if (params.name !== 'mpl_row' && params.name !== 'mpl_column') {
						mpl.front.id = null;
						mpl.front.id = mpl.front.model++;
						mpl.section_name = params.name;
						mpl.storage[mpl.front.id] = [];
						mpl.storage[mpl.front.id].push(params);
						params.section_num = mpl.front.id;
					}
					else {
						mpl.storage[mpl.front.id].push(params);
					}
				}
				else {
					var id = mpl.model++;
					rended.attr({ id: 'model-' + id }).addClass('mpl-model').data({ 'model': id });
					params = $().extend($().extend({ args: {}, model: id }, params));
					mpl.storage[id] = params;
				}
			}

			return rended;
		};
		this.extend = function (obj) {
			for (var i in obj) {
				if (i == 'render') {
					this._render = obj.render;
				} else {
					this[i] = obj[i];
				}
			}
			return this;
		};
	},

	save: function (pop) {
		var mid = pop.data('model');
		if (mid !== undefined) {
			if (mpl.front) {
				mpl.front.save_value = true;
				if (mpl.storage[mid][0]) {

					var datas = mpl.tools.getFormData(pop, true),
						prev = {},
						hidden = [],
						exp = new RegExp(mpl_site_url, "g");
					map_values = mpl.params.get_values(mpl.storage[mid][0].name);

					pop.find('form.fields-edit-form .mpl-param-row').each(function () {
						if ($(this).hasClass('relation-hidden')) {
							$(this).find('.mpl-param').each(function () {
								hidden.push(this.name);
							});
						}
					});

					for (var name in datas) {

						if (typeof (name) == 'undefined' || name === '')
							continue;

						if (hidden.indexOf(name) > -1)
							datas[name] = '';

						if (datas[name] !== '') {
							if (typeof datas[name] == 'object') {
								if (typeof (datas[name][0]) == 'string' && datas[name][0] === '')
									delete datas[name][0];

								datas[name] = mpl.tools.base64.encode(JSON.stringify(datas[name]).toString().replace(exp, '%SITE_URL%'));

							}
							prev[name] = datas[name];

						}
						else if (hidden.indexOf(name) == -1) {
							if (map_values[name] !== undefined && map_values[name] !== '' && typeof (prev[name]) == 'undefined')
								prev[name] = '__empty__';
						}

						if (datas[name] === '' && typeof (prev[name]) == 'undefined') {
							if (typeof (mpl.storage[mid][0].args[name]) == 'undefined')
								continue;
							else delete mpl.storage[mid][0].args[name];
						}
						else {

							mpl.storage[mid][0].args[name] = prev[name];

							if (name == 'content' && mpl.maps[mpl.storage[mid][0].name].is_container === true) {
								mpl.storage[mid][0].end = '[/' + mpl.storage[mid][0].name + ']';
							} else {
								if( mpl.storage[mid][0].name !=='mpl_section_html' )
								mpl.storage[mid][0].args[name] = mpl.tools.esc_attr(mpl.storage[mid][0].args[name]);
							}
						}
					}

					delete map_values, exp, hidden, datas;

					mpl.confirm(true);
				}
			}
			else {
				if (mpl.storage[mid]) {

					var datas = mpl.tools.getFormData(pop, true),
						prev = {},
						hidden = [],
						exp = new RegExp(mpl_site_url, "g");
					map_values = mpl.params.get_values(mpl.storage[mid].name);

					pop.find('form.fields-edit-form .mpl-param-row').each(function () {
						if ($(this).hasClass('relation-hidden')) {
							$(this).find('.mpl-param').each(function () {
								hidden.push(this.name);
							});
						}
					});

					for (var name in datas) {

						if (typeof (name) == 'undefined' || name === '')
							continue;

						if (hidden.indexOf(name) > -1)
							datas[name] = '';

						if (datas[name] !== '') {
							if (typeof datas[name] == 'object') {
								if (typeof (datas[name][0]) == 'string' && datas[name][0] === '')
									delete datas[name][0];

								datas[name] = mpl.tools.base64.encode(JSON.stringify(datas[name]).toString().replace(exp, '%SITE_URL%'));

							}
							prev[name] = datas[name];

						}
						else if (hidden.indexOf(name) == -1) {
							if (map_values[name] !== undefined && map_values[name] !== '' && typeof (prev[name]) == 'undefined')
								prev[name] = '__empty__';
						}

						if (datas[name] === '' && typeof (prev[name]) == 'undefined') {
							if (typeof (mpl.storage[mid].args[name]) == 'undefined')
								continue;
							else delete mpl.storage[mid].args[name];
						}
						else {

							mpl.storage[mid].args[name] = prev[name];

							if (name == 'content' && mpl.maps[mpl.storage[mid].name].is_container === true) {
								mpl.storage[mid].end = '[/' + mpl.storage[mid].name + ']';
							} else {
								mpl.storage[mid].args[name] =
									mpl.tools.esc_attr(mpl.storage[mid].args[name]);
							}
						}
					}
					delete map_values, exp, hidden, datas;

					mpl.confirm(true);

				}
			}
		}
	},

	/* View Events */
	settings: function (e, atts) {
		if (e === undefined)
			return;

		var el = (typeof (e.tagName) != 'undefined') ? e : this;
		var mid = {},
			data = {},
			popup = {};
		if (mpl.front) {
			mid = mpl.front.get.front_model(el);
			data = mpl.storage[mid][0];
			popup = mpl.tools.popup;
		} else {
			mid = mpl.get.model(el);
			data = mpl.storage[mid];
			popup = mpl.tools.popup;
		}

		if (mpl.maps[data.name] === undefined)
			return false;

		var map = $().extend({}, mpl.maps['_std']);
		map = $().extend(map, mpl.maps[data.name]);

		if (map.title === undefined)
			map.title = map.name + ' Settings';
		var attz = {
			title: map.title,
			width: map.pop_width,
			height: 400,
			scrollBack: false,
			scrollTo: false,
			storage: data.args,
			params: map,
			class: data.name + '_wrpop mpl-elm-settings-popup',
		};
		//if (mpl.front) {
		//	attz['no_cancel'] = true;
		//}
		if (atts !== undefined)
			attz = $.extend(attz, atts);

		var pop = popup.render(el, attz);

		mpl.ui.fix_position_popup(pop);

		pop.data({ model: mid, callback: mpl.backbone.save });

		if (mpl.front) {
			pop.data({ el: $('section[data-front-model="' + mid + '"]') });
		}
		var form = $('<form class="fields-edit-form mpl-pop-tab form-active"></form>'), tab_icon = 'et-puzzle';

		if (map.params[0] !== undefined) {

			mpl.params.fields.render(form, map.params, data.args);

		} else {
			for (var n in map.params) {
				popup.add_tab(pop, {
					title: n,
					class: 'mpl-tab-general-' + mpl.tools.esc_slug(n),
					cfg: n + '|' + mid + '|' + data.name,
					callback: mpl.params.fields.tabs
				});
			}

			pop.find('.m-p-wrap>.mpl-pop-tabs>li').first().trigger('click');
		}

		pop.find('.m-p-body').append(form);

		delete groups, map;

		return pop;
	},

	double: function (e, exp) {

		if (e === undefined)
			return false;

		var el = (typeof (e.tagName) != 'undefined') ? e : this;

		var id = mpl.get.model(el),
			data = mpl.storage[id],
			cdata = $().extend(true, {}, data),
			cel, func, is_col = (['mpl_column', 'mpl_column_inner'].indexOf(data.name) > -1);


		cdata.args._id = Math.round(Math.random() * 1000000);

		if (exp === undefined)
			var exp = mpl.backbone.export(id);


		if (data.name != 'mpl_column_text')
			cdata.args.content = mpl.params.process_alter(exp.content, data.name);



		el = $('#model-' + id);

		if (is_col && el.parent().find('>.mpl-model').length >= 10) {
			alert(mpl.__.i54);
			return;
		}

		cdata.model = mpl.model++;

		if (data.name == 'mpl_row') {
			cel = mpl.views.row.render(cdata, true);
		} else if (data.name == 'mpl_column') {
			cel = mpl.views.column.render(cdata, true);
		} else if (mpl.tags.indexOf(cdata.name)) {
			try {
				func = mpl.maps[cdata.name].views.type;
			} catch (ex) {
				func = cdata.name;
			}
			if (typeof mpl.views[func] == 'object')
				cel = mpl.views[func].render(cdata);
			else cel = mpl.views.mpl_element.render(cdata);

		} else {

			cel = mpl.views.
				mpl_undefined
				.render({
					args: { content: cdata.content },
					name: 'mpl_undefined',
					end: '[/mpl_undefined]',
					full: cdata.content
				});
		}

		el.after(cel);

		if (is_col)
			mpl.views.column.reset_view(el.parent());

		if (el.height() > 300 && !el.hasClass('mpl-column'))
			$('html,body').scrollTop($(window).scrollTop() + el.height());

		mpl.ui.sortInit();

		return cel;

	},

	add: function (e) {

		e.preventDefault();

		var el = (typeof (e.tagName) != 'undefined') ? e : this;

		var atts = { title: mpl.__.i02, width: 1300, class: 'no-footer mpl-adding-elements', float: true };

		if ($(window).width() < 1350) {
			atts.class += ' mpl-small-screen-pop';
			atts.width = 950;
		}

		var pop = mpl.tools.popup.render(el, atts);

		var pos = 'bottom',
			model = mpl.get.model(el);
		if ($(el).closest('.pos-top').length > 0)
			pos = 'top';

		pop.data({ model: model, pos: pos });

		pop.find('h3.m-p-header').append(

			$('<input type="search" class="mpl-components-search" placeholder="' + mpl.__.i03 + '" />')
				.on('keyup', mpl.ui.search_elements)

		).append('<i class="sl-magnifier"></i>');

		var components = $(mpl.template('components', { model: model, pos: pos }));

		pop.find('.m-p-body').append(components);

		mpl.trigger({

			el: components,
			events: {
				'ul.mpl-components-categories li[data-category]:click': 'categories',
				'ul.mpl-components-list-main li:click': 'items',
			},

			categories: function (e) {

				var category = $(this).data('category'), atts = {}, el;
				mpl.cfg.elmTabActive = category;
				mpl.backbone.stack.set('MPL_Configs', mpl.cfg);

				$(this).parent().find('.active').removeClass('active');
				$(this).addClass('active');

				e.data.el.find('#mpl-clipboard,.mpl-wp-widgets-pop').remove();

				if ($(this).hasClass('mcl-clipboard')) {

					e.data.el.find('.mpl-components-list-main').css({ display: 'none' });

					el = $(mpl.template('clipboard', atts));

					e.data.el.append(el);

					if (typeof atts.callback == 'function')
						atts.callback(el);

					return;

				}
				else if ($(this).hasClass('mcl-wp-widgets')) {

					e.data.el.find('.mpl-components-list-main').css({ display: 'none' });

					el = $(mpl.template('wp-widgets-element', atts));

					e.data.el.append(el);

					if (typeof atts.callback == 'function')
						atts.callback(el, e);

					return;

				}

				e.data.el.find('.mpl-components-list-main').show();

				if (category == 'all') {
					e.data.el.find('.mpl-components-list-main li').show();
				} else {
					e.data.el.find('.mpl-components-list-main li, #mpl-clipboard').css({ display: 'none' });
					e.data.el.find('.mpl-components-list-main .mcpn-' + category).show();
				}

			},

			items: function (e) {
				if ($(this).data('rule') == 'pro') {
					var title = $(this).find(".cpdes").text();
					mpl.msg(title + ' only available in pro version.<br/><a style="margin-top:20px;" class="button button-primary" href="https://www.mageewp.com/peony-theme.html" target="_blank">Get Peony Pro</a>', 'MPL Pro Support', 'sl-close', 3000);
				}
				else {
					var full = mpl.ui.prepare($(this).data('name'), $(this).data('data'));
					if (mpl.front) {
						$.ajax({
							url: mpl_ajax_url,
							method: 'POST',
							dataType: 'html',
							data: { action: 'mpl_front_section_data', shortcode: full },
							success: function (html) {
								var new_css = html.match(/<style type="text\/css">(.)*<\/style>/)[0];
								new_css = new_css
									.replace(/<style type="text\/css">/, '')
									.replace(/<\/style>/, '');
								html = html.replace(/<style type="text\/css">(.)*<\/style>/, '');
								var section = mpl._$(html);
								mpl._$(section).attr('data-front-model', mpl.front.id);
								var css_content = mpl._$('#mpl-css-render').html();
								mpl._$('#mpl-css-render').html(css_content + new_css);
								mpl._$(".mpl-content-wrap").append(section);
								//var iframe_body = $('#mpl-live-frame').get(0).contentWindow.document.body;
								//iframe_body.scrollTop = iframe_body.offsetHeight;
								var h = mpl._$('body').height() - mpl._$(window).height();
								if (h > 0) {
									mpl._$("html").css("overflow", "");
									mpl._$('body').scrollTop(h);
								}
								//mpl_front.init($);
								//$('#mpl-live-frame').get(0).contentWindow.mpl_front.init(mpl._$);
								$('#mpl-live-frame').get(0).contentWindow.mpl_front.refresh('.mpl-content-wrap section[data-front-model="' + mpl.front.id + '"]');
								mpl.front.addToolsListener();
							}
						});
					}
					mpl.backbone.dopush(full, this);
				}
			},
		});

		pop.find('.mpl-components-search').focus();

		if (mpl.cfg.elmTabActive !== undefined) {
			pop.find('.mpl-components-categories li[data-category="' + mpl.cfg.elmTabActive + '"]').trigger('click');
		}

		return pop;

	},

	remove: function (e) {
		var rs = true;
		var cf = null;
		cf = confirm('Are you sure that you want to delete this section?');

		if (cf === false) {
			rs = false;
		}
		if (rs === false) {
			return false;
		}

		/*magee-end*/

		var el = (typeof (e.tagName) != 'undefined') ? e : this;

		var und = $('#mpl-undo-deleted-element'),
			stg = $('#mpl-storage-prepare'),
			elm = $('#model-' + mpl.get.model(el)),
			relate = { parent: elm.parent().get(0) },

			limitRestore = 10;


		if (elm.next().hasClass('mpl-model')) {
			relate.next = elm.next().get(0);
		}
		if (elm.prev().hasClass('mpl-model')) {
			relate.prev = elm.prev().get(0);
		}
		var i = 1;
		stg.find('>.mpl-model').each(function () {
			i++;
			if (i > mpl.cfg.limitDeleteRestore) {
				var id = $(this).data('model');
				delete mpl.storage[id];
				$('#model-' + id).remove();
			}
		});

		elm.data({ relate: relate });

		stg.prepend(elm);
		und.find('span.amount').html(stg.find('>.mpl-model').length);


		und.css({ top: 0 });

		if (und.find('.do-action').data('event') === undefined) {

			/*Make sure add event only one time*/

			und.find('.sl-close').off('click').on('click', function () {
				$('#mpl-undo-deleted-element').css({ top: -132 });
			});

			und.find('.do-action').off('click').on('click', function () {

				var elm = $('#mpl-storage-prepare>.mpl-model').first();
				if (!elm.get(0)) {
					$(this.parentNode).find('.sl-close').trigger('click');
					return false;
				}
				var relate = elm.data('relate');

				if (typeof (relate.next) != 'undefined') {
					$(relate.next).before(elm);
				} else if (typeof (relate.prev) != 'undefined') {
					$(relate.prev).after(elm);
				} else if (typeof (relate.parent) != 'undefined') {
					$(relate.parent).append(elm);
				} else {
					$(this.parentNode).find('.sl-close').trigger('click');
					var id = $(this).data('model');
					delete mpl.storage[id];
					$('#model-' + id).remove();
					return false;
				}

				$('.show-drag-helper').removeClass('show-drag-helper');

				mpl.ui.scrollAssistive(elm);

				var al = $('#mpl-storage-prepare>.mpl-model').length;

				$(this).find('span.amount').html(al);

				if (al === 0)
					$(this.parentNode).find('.sl-close').trigger('click');

			});

			und.find('.do-action').data({ 'event': 'added' });

		}

		mpl.confirm(true);

	},

	copy: function (e) {

		var el = (typeof (e.tagName) != 'undefined') ? e : this;

		var model = mpl.get.model(el),
			exp = mpl.backbone.export(model),
			admin_view = '', lm = 0, stack = mpl.backbone.stack,
			list = stack.get('MPL_ClipBoard'),
			ish;

		$('#model-' + model + ' .admin-view').each(function () {
			lm++;
			if (lm < 2) {
				if ($(this).find('img').length === 0) {
					ish = mpl.tools.esc($(this).text());
					if (ish.length > 38)
						ish = ish.substring(0, 35) + '...';
				} else if ($(this).hasClass('gmaps')) {

					ish = $(this).find('.gm-style img');
					ish = '<img src="' + ish.eq(parseInt(ish.length / 2, 10)).attr('src') + '" />';

				} else {
					ish = '<img src="' + $(this).find('img').first().attr('src') + '" />';
				}
				admin_view += '<i>' + ish + '</i>';
			}
		});

		if (list.length > mpl.cfg.limitClipboard - 2) {

			list = list.reverse();
			var new_list = [];
			for (var i = 0; i < mpl.cfg.limitClipboard - 2; i++) {
				new_list[i] = list[i];
			}

			stack.set('MPL_ClipBoard', new_list.reverse());

		}

		var page = $('#title').val() ? mpl.tools.esc($('#title').val().trim()) : 'Mageewp Page Builder',
			content = (exp.begin + exp.content + exp.end);

		stack.clipboard.add({
			page: page,
			content: mpl.tools.base64.encode(content),
			title: mpl.storage[model].name,
			des: admin_view
		});

		// Push to row stack & OS clipboard
		mpl.backbone.stack.set('MPL_RowClipboard', content);
		mpl.tools.toClipboard(content);

	},

	cut: function (e) {

		var el = (typeof (e.tagName) != 'undefined') ? e : this;
		mpl.backbone.copy(el);

		$(el).parent().find('.delete').trigger('click');

		mpl.msg(mpl.__.i60);

	},

	more: function (e) {

		var el = (typeof (e.tagName) != 'undefined') ? e : this;

		if ($(el).hasClass('active'))
			$(el).removeClass('active');
		else $(el).addClass('active');

	},

	/* End View Events */

	dopush: function (full, el) {

		var model = mpl.get.model(el),
			fid = mpl.backbone.push(full, model, $(el).closest('.mpl-params-popup').data('pos'));

		if (fid !== null) {

			$(el).closest('.mpl-params-popup').data({ 'scrolltop': null });

			var edit = $('#model-' + fid + '>.mpl-element-control>.mpl-controls>.edit');
			edit.trigger('click');

			mpl.confirm(true);

		}

		$(el).closest('.mpl-params-popup').find('.m-p-header .sl-close.sl-func').trigger('click');

	},

	push: function (content, model, pos) {
		/* Push elements to grid */

		if (mpl.front !== undefined && mpl.front.push !== undefined && typeof (mpl.front.push) == 'function') {
			return mpl.front.push(content, model, pos);
		}
		/*
		*	Set unsaved warning
		*/
		mpl.confirm(true);
		/*
		*	If model is defined, push to column or wrapper
		*/
		if (model !== undefined && model !== null && document.getElementById('model-' + model) !== null) {

			var parent = ($('#model-' + model + ' .mpl-column-wrap').length > 0 ? $('#model-' + model + ' .mpl-column-wrap').first() : $('#model-' + model).parent()), fid = mpl.params.process_all(content, parent);


			if ($('#model-' + model + ' .mpl-column-wrap').length === 0) {
				/* Add element after an element */
				$('#model-' + model).after($('#model-' + fid));
			} else if (pos == 'top') {
				$('#model-' + fid).parent().prepend($('#model-' + fid));
			}

			mpl.ui.sortInit();

			mpl.ui.scrollAssistive($('#model-' + fid));

			return fid;

		}
		else {

			/*
			*	Push to bottom of builder
			*/

			mpl.params.process_shortcodes(content, function (args) {
				mpl.views.row.render(args);
			}, 'mpl_row');

			var target = $('#mpl-rows .mpl-row').last();

			mpl.ui.scrollAssistive(target);
			target.addClass('mpl-bounceIn');
			setTimeout(function (target) {
				target.removeClass('mpl-bounceIn');
			}, 1200, target);

			mpl.ui.sortInit();

			return target.data('model');

		}
		return null;
	},

	extend: function (obj, ext, accept) {

		if (accept === undefined)
			accept = [];

		if (typeof ext != 'object') {
			return ext;
		} else {
			for (var i in ext) {
				if (accept.indexOf(i) > -1 || accept.length === 0) {
					/*Except jQuery object*/
					if (ext[i].selector !== undefined)
						obj[i] = ext[i];
					else obj[i] = mpl.backbone.extend({}, ext[i]);
				}
			}
			return obj;
		}
	},

	export: function (id, ignored) {
		var storage = mpl.storage[id];

		if (_.isUndefined(storage))
			return null;

		if (_.isUndefined(storage.name))
			return storage.full;

		if (_.isUndefined(ignored))
			ignored = [];

		if (mpl.maps[name] !== undefined)
			return storage.full;

		var name = storage.name;

		if (name == 'mpl_undefined')
			return { begin: '', content: mpl.storage[id].args.content, end: '' };

		if (mpl.maps[name] !== undefined && mpl.maps[name].is_container === true) {
			while (ignored.indexOf(storage.name) > -1) {
				storage.name += '#';
				storage.end = '[/' + storage.name + ']';
			}
		}

		var el = $('#model-' + id),
			params = mpl.params.get_types(name),
			_begin = '[' + storage.name,
			_content = '',
			_end = '';

		for (var n in storage.args) {

			if (n != 'content' || params[n] !== undefined) {
				if (params[n] !== undefined && params[n] == 'textarea_html') {
					// stuff
					storage.args.content = switchEditors.wpautop(storage.args.content);
					_content = storage.args.content;
				} else {
					_begin += ' ' + n + '="' + storage.args[n] + '"';
				}
			}

		}

		_begin += ']';

		if (mpl.maps[name] !== undefined && mpl.maps[name].is_container === true) {
			/* shortcode container */
			ignored[ignored.length] = storage.name;
			var children = el.find('.mpl-model').first().parent().find('> .mpl-model');

			if (children.length > 0) {

				_content = '';
				children.each(function () {
					var mid = $(this).data('model');
					if (!_.isUndefined(mid)) {
						var _exp = mpl.backbone.export(mid, $().extend([], ignored));
						_content += _exp.begin + _exp.content + _exp.end;
					}
				});

				mpl.storage[id].args.content = _content;

			}

			_end = '[/' + storage.name + ']';
			mpl.storage[id].content = _content;
			mpl.storage[id].end = '[/' + name + ']';

		}


		mpl.storage[id].name = name;

		return { begin: _begin, content: _content, end: _end };

	},
},
}, window.mpl);

window.mpl.backbone = $.extend({

stack: {

	clipboard: {

		sort: function () {

			var list = [];

			$('#mpl-clipboard>.ms-list>li').each(function () {

				list[list.length] = $(this).data('sid');

			});

			mpl.backbone.stack.sort('MPL_ClipBoard', list);

		},

		add: function (obj) {

			var stack = mpl.backbone.stack.get('MPL_ClipBoard'), istack = [], i = -1;

			if (typeof stack == 'object') {
				if (stack.length > mpl.cfg.limitClipboard) {
					for (var n in stack) {
						i++;
						if (stack.length - i < mpl.cfg.limitClipboard)
							istack[istack.length] = stack[n];
					}
					mpl.backbone.stack.set('MPL_ClipBoard', istack);
				}
			}

			mpl.backbone.stack.add('MPL_ClipBoard', obj);

		}

	},

	sections: {


	},

	add: function (sid, obj) {

		if (typeof (Storage) !== "undefined") {

			var stack = this.get(sid);

			if (stack === '')
				stack = [];
			else if (typeof stack != 'object')
				stack = [stack];

			stack[stack.length] = obj;

			this.set(sid, stack);

		} else {
			alert(mpl.__.i04);
		}

	},

	update: function (sid, key, value) {

		if (typeof (Storage) !== "undefined") {

			var stack = this.get(sid);

			if (stack === '')
				stack = {};
			else if (typeof stack != 'object') {
				var ist = {}; ist[sid] = stack; stack = ist;
			}

			stack[key] = value;

			this.set(sid, stack);

		} else {
			alert(mpl.__.i04);
		}

	},

	get: function (sid, index) {

		if (typeof (Storage) !== "undefined") {

			var data = localStorage[sid], dataObj;
			if (data === undefined)
				return '';

			data = data.toString().trim();

			if (data !== undefined && data !== '' && (data.indexOf('[') === 0 || data.indexOf('{') === 0)) {
				try {
					dataObj = JSON.parse(data);
				} catch (e) {
					dataObj = data;
				}
				if (index === undefined)
					return dataObj;
				else if (dataObj[index] !== undefined)
					return dataObj[index];
				else return '';

			} else return data;

		} else {
			alert(mpl.__.i04);
			return '';
		}

	},

	set: function (sid, obj) {

		if (typeof obj == 'object')
			obj = JSON.stringify(obj);

		localStorage.removeItem(sid);
		localStorage.setItem(sid, obj);

	},

	sort: function (sid, list) {

		var stack = this.get(sid), istack = [];

		for (var n in list) {
			if (stack[list[n]] !== undefined)
				istack[istack.length] = stack[list[n]];
		}

		this.set(sid, istack);

	},

	remove: function (sid, id) {

		var stack = this.get(sid);
		delete stack[id];

		this.set(sid, stack);

	},

	reset: function (sid) {

		var stack = this.get(sid), istack = [];

		if (stack === '') {
			this.clear(sid);
		} else {
			for (var i in stack) {
				if (stack[i] !== null)
					istack[istack.length] = stack[i];
			}
		}
		this.set(sid, istack);
	},

	clear: function (sid) {

		if (typeof (Storage) !== "undefined") {

			localStorage.removeItem(sid);

		} else {
			alert(mpl.__.i04);
			return {};
		}
	}

},

}, window.mpl.backbone);
window.mpl = $.extend({
ui: {
	elm_start: null, elm_drag: null, elm_over: null, over_delay: false, over_timer: null, key_down: false,/*magee*/elm_prev: null, elm_next: null,
	/* This is element clicked when mousedown on builder */

	init: function () {
		mpl.body = document.querySelectorAll('body')[0];
		mpl.html = document.querySelectorAll('html')[0];

		$(document).on('mousedown', function (e) { mpl.ui.elm_start = e.target; });

		$(window).on('scroll', document.getElementById('major-publishing-actions'), mpl.ui.publishAction);

		$(window).on('keydown', this.keys_press);
	},

	keys_press: function (e) {
		if (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey) {

			var incase = false;

			if (e.keyCode === 83) {

				mpl.do_action('mpl-ctrl-s', e);

				e.preventDefault();
				e.stopPropagation();
				return false;
			}//ctrl+s

			if (e.target.tagName == 'INPUT' || e.target.tagName == 'TEXTAREA')
				return true;

			if (e.keyCode === 90) {
				if (mpl.id('mpl-instantor') !== null)
					return true;

				if (e.shiftKey)
					mpl.do_action('mpl-shift-ctrl-z', e);
				else mpl.do_action('mpl-ctrl-z', e);
				incase = true;
			}//ctrl+z
			else if (e.keyCode === 69) {
				mpl.do_action('mpl-ctrl-e', e);
				incase = true;
			}//ctrl+e

			if (incase) {
				e.preventDefault();
				e.stopPropagation();
				return false;
			}

		}
		else if (e.keyCode === 13) {
			// enter
			mpl.do_action('mpl-enter');

			var last = $('.mpl-params-popup').
				not('.no-footer').
				find('>.m-p-wrap>.m-p-header>.sl-check.sl-func').
				last(),
				posible = true,
				el = e.target;

			if (el.tagName == 'INPUT') {
				var inlast = $(el)
					.closest('.mpl-params-popup')
					.not('.no-footer')
					.find('>.m-p-wrap>.m-p-header>.sl-check.sl-func');
				if (inlast.length > 0) {
					last = inlast;
					$(el).trigger('change');
				}
			}

			while (el !== undefined && el.parentNode) {

				el_type = (el.tagName !== undefined) ? el.tagName : '';

				if (el_type == 'TEXTAREA' || $(el).attr('contenteditable') == 'true') {
					posible = false;
					break;
				}
				el = el.parentNode;
			}

			if (last.length > 0 && posible === true) {

				last.trigger('click');

				e.preventDefault();
				e.stopPropagation();

				return false;

			}

		}//enter
		else if (e.keyCode === 27) {

			// esc

			$('.mpl-params-popup').
				find('>.m-p-wrap>.m-p-header>.sl-close.sl-func').
				last().trigger('click');

			mpl.do_action('mpl-esc');

			e.preventDefault();
			e.stopPropagation();

			return false;

		}//esc

		return true;

	},//按键函数

	views_sections: function (wrp) {
		wrp.find('>.mpl-views-sections-label .section-label').off('click').on('click', wrp, function (e) {

			$(this).closest('.mpl-views-sections-wrap')
				.find('>.mpl-views-section.mpl-model')
				.removeClass('mpl-section-active');

			$('#model-' + $(this).data('pmodel')).addClass('mpl-section-active');
			e.data.find('>.mpl-views-sections-label .section-label').removeClass('sl-active');
			$(this).addClass('sl-active');

		});

		wrp.find('>.mpl-views-section > .mpl-vertical-label').off('click').on('click', wrp, function (e) {

			var itsactive = false;
			if ($(this).parent().hasClass('mpl-section-active')) {
				itsactive = true;
			}

			$(this).closest('.mpl-views-sections-wrap')
				.find('>.mpl-views-section.mpl-model')
				.removeClass('mpl-section-active');

			if (itsactive === true)
				return;

			$(this).parent().addClass('mpl-section-active');

			var coor = mpl.tools.popup.coordinates(this, 100);
			if ($(window).scrollTop() - coor[0] > 100)
				$('html,body').scrollTop(coor[0] - 200);

		});

		var pwrp = wrp.closest('.mpl-views-sections');

		if (!pwrp.hasClass('mpl-views-vertical')) {

			mpl.ui.sortable({

				items: 'div.mpl-views-sections-label>div.section-label',
				vertical: false,

				end: function (e, el) {

					$(el).closest('.mpl-views-sections-label')
						.find('>.section-label').each(function () {
							var id = $(this).data('pmodel');
							var el = $('#model-' + id);
							el.parent().append(el);
						});

				}

			});


		}
		else {

			mpl.ui.sortable({

				items: 'div.mpl-views-vertical > div.mpl-views-sections-wrap > div.mpl-views-section',
				handle: '>h3.mpl-vertical-label',
				connecting: false,
				vertical: true,
				helper: ['mpl-ui-handle-image', 25, 25],

				start: function (e, el) {
					$(el).parent().addClass('mpl-sorting');
				},

				end: function (e, el) {
					$(el).parent().removeClass('mpl-sorting');
				}

			});

		}

	},

	clipboard: function (el) {

		mpl.ui.sortable({

			items: '#mpl-clipboard > ul.ms-list > li',
			connecting: false,
			vertical: false,
			placeholder: 'mpl-ui-cb-placeholder',

			end: function () {
				mpl.backbone.stack.clipboard.sort();
			}

		});

		el.find('>ul.ms-list>li').on('click', function (e) {

			if ($(e.target).hasClass('ms-quick-paste')) {

				$(this).addClass('active');

				var stack = mpl.backbone.stack.get('MPL_ClipBoard'), model = mpl.get.model(this), content = '', sid;

				list = $(this).closest('#mpl-clipboard').find('ul.ms-list>li.active').each(function () {

					sid = $(this).data('sid');
					if (typeof stack[sid] == 'object')
						content += mpl.tools.base64.decode(stack[sid].content);

				});

				content = content.trim();

				if (content === '') {
					alert(mpl.__.i06);
					return false;
				}

				if (model !== undefined) {
					mpl.backbone.push(content, model, $(this).closest('.mpl-params-popup').data('pos'));
				} else {
					mpl.backbone.push(content);
				}

				mpl.tools.popup.close_all();

				return;

			}

			if ($(this).hasClass('active'))
				$(this).removeClass('active');
			else $(this).addClass('active');
		});

		mpl.trigger({

			el: el.find('>ul.ms-funcs'),
			list: el.find('ul.ms-list>li'),

			events: {
				'>li.select:click': 'select',
				'>li.unselect:click': 'unselect',
				'>li.delete:click': 'delete',

				'>li.latest:click': 'latest',
				'>li.paste:click': 'paste',
				'>li.pasteall:click': 'pasteall',
			},

			select: function (e) {
				e.data.list.addClass('active');
			},

			unselect: function (e) {
				e.data.list.removeClass('active');
			},

			delete: function (e) {

				e.data.list.each(function () {
					if ($(this).hasClass('active')) {
						mpl.backbone.stack.remove('MPL_ClipBoard', $(this).data('sid'));
						$(this).remove();
					}
				});

				mpl.backbone.stack.reset('MPL_ClipBoard');

			},

			latest: function (e) {

				var stack = mpl.backbone.stack.get('MPL_ClipBoard'),
					latest = stack[stack.length - 1],
					content = mpl.tools.base64.decode(latest.content),
					model = mpl.get.model(this);

				if (model) {
					mpl.backbone.push(content, model, $(this).closest('.mpl-params-popup').data('pos'));
				} else {
					mpl.backbone.push(content);
				}

				$('.mpl-params-popup').remove();

			},

			pasteall: function (e) {

				var stack = mpl.backbone.stack.get('MPL_ClipBoard'), model = mpl.get.model(this), content = '';

				for (var n in stack) {
					if (typeof stack[n] == 'object')
						content += mpl.tools.base64.decode(stack[n].content);
				}

				content = content.trim();

				if (content === '') {
					alert(mpl.__.i05);
					return false;
				}

				if (model) {
					mpl.backbone.push(content, model, $(this).closest('.mpl-params-popup').data('pos'));
				} else {
					mpl.backbone.push(content);
				}

				$('.mpl-params-popup').remove();

			},

			paste: function (e) {

				var stack = mpl.backbone.stack.get('MPL_ClipBoard'), model = mpl.get.model(this), content = '', sid;

				list = $(this).closest('#mpl-clipboard').find('ul.ms-list>li.active').each(function () {

					sid = $(this).data('sid');
					if (typeof stack[sid] == 'object')
						content += mpl.tools.base64.decode(stack[sid].content);

				});

				content = content.trim();

				if (content === '') {
					alert(mpl.__.i06);
					return false;
				}

				if (model) {
					mpl.backbone.push(content, model, $(this).closest('.mpl-params-popup').data('pos'));
				} else {
					mpl.backbone.push(content);
				}

				$('.mpl-params-popup').remove();

			}

		});


	},

	scrollAssistive: function (ctop, eff) {

		if (mpl.cfg.scrollAssistive != 1)
			return false;

		if (typeof ctop == 'object') {
			if ($(ctop).get(0)) {
				var coor = $(ctop).get(0).getBoundingClientRect();
				ctop = (coor.top + $(window).scrollTop() - 100);
			}
		}

		if (undefined !== eff && eff === false)
			$('html,body').scrollTop(ctop);
		else $('html,body').stop().animate({ scrollTop: ctop });

	},

	preventScroll: function (el) {

		if (mpl.cfg.preventScrollPopup == 1 && $.browser.chrome === true) {

			el.addClass('mpl-prevent-scroll');

			el.off('mousewheel DOMMouseScroll').on('mousewheel DOMMouseScroll',

				function (e) {

					if (this.scrollHeight > this.offsetHeight) {

						if ($('body').hasClass('mpl-ui-dragging'))
							return true;

						var curS = this.scrollTop;
						if (this.scrollCalc === undefined)
							this.scrollCalc = 0;

						var e0 = e.originalEvent,
							delta = e0.wheelDelta || -e0.detail;

						if (delta !== 0) {

							//this.scrollTop += ( delta <= 0 ? 1 : -1 ) * e.data.st;
							this.scrollTop -= delta;

							if (curS == this.scrollTop) {

								var pop = this.parentNode.parentNode,
									top = pop.offsetTop - 80,
									bottom = pop.offsetTop + (pop.offsetHeight - window.innerHeight) + 100;

								if (delta < 0) {
									//scroll down

									if (mpl.body.scrollTop - delta < bottom)
										mpl.body.scrollTop -= delta;
									else mpl.body.scrollTop = bottom;

									if (mpl.html.scrollTop - delta < bottom)
										mpl.html.scrollTop -= delta;
									else mpl.html.scrollTop = bottom;

								} else {

									if (mpl.body.scrollTop - delta > top)
										mpl.body.scrollTop -= delta;
									else mpl.body.scrollTop = top;

									if (mpl.html.scrollTop - delta > top)
										mpl.html.scrollTop -= delta;
									else mpl.html.scrollTop = top;
								}

							}

						}

						if (e.target !== null && (e.target.tagName === 'OPTION' || e.target.tagName === 'SELECT' || e.target.className.indexOf('mpl-free-scroll') > -1)) {
							return true;
						}

						e.preventDefault();
						e.stopPropagation();

						return false;

					}

				});

		}
	},

	scroll: function (st) {

		if (typeof st == 'object') {

			if (st.top !== undefined) {
				mpl.body.scrollTop = st.top;
				mpl.html.scrollTop = st.top;
			}

			if (st.left !== undefined) {
				mpl.body.scrollLeft = st.left;
				mpl.html.scrollLeft = st.left;
			}

		} else {
			return {
				top: (mpl.body.scrollTop ? mpl.body.scrollTop : mpl.html.scrollTop),
				left: (mpl.body.scrollLeft ? mpl.body.scrollLeft : mpl.html.scrollLeft)
			};
		}
	},

	mpl_box: {

		sort: function () {

			mpl.ui.sortable({

				items: '.mpl-box:not(.mpl-box-column)',
				connecting: true,
				handle: '>ul.mb-header',
				helper: ['mpl-ui-handle-image', 25, 25],
				detectEdge: 30

			});

			if (window.chrome === undefined) {

				$('.mpl-box-body .mpl-box-inner-text').off('mousedown').on('mousedown', function (e) {
					var el = this;
					while (el.parentNode) {
						el = el.parentNode;
						if (el.draggable === true) {
							el.draggable = false;
							el.templDraggable = true;
						}
					}
				}).off('blur').on('blur', function (e) {
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

		},

		renderBack: function (pop) {

			var exp = JSON.stringify(
				mpl.ui.mpl_box.accessNodesVisual(pop.find('.mpl-box-render'))
			).toString(), rex = new RegExp(mpl_site_url, "g");

			exp = exp.replace(rex, '%SITE_URL%');

			pop.find('.mpl-param.mpl-box-area').val(mpl.tools.base64.encode(exp));

		},

		wrapFreeText: function (el) {

			var nodes = el.childNodes, text, n, ind;

			if (nodes === undefined)
				return null;

			for (var i = 0; i < nodes.length; i++) {
				/* node text has type = 3 */

				n = nodes[i];

				if (nodes[i].nodeType == 3) {

					if (n.parentNode.tagName != 'TEXT' && n.textContent.trim() !== '') {

						text = document.createElement('text');

						if (n.nextElementSibling !== null)
							$(n.nextElementSibling).before(text);
						else if (n.previousElementSibling !== null)
							$(n.previousElementSibling).after(text);
						else n.parentNode.appendChild(text);

						text.appendChild(n);

					}
				} else {

					if (['input', 'br', 'select', 'textarea', 'button'].indexOf(nodes[i].tagName.toLowerCase()) > -1) {

						ind = false;

						if (n.previousElementSibling !== null) {
							if (n.previousElementSibling.tagName == 'TEXT') {
								$(n.previousElementSibling).append(nodes[i]);
								ind = true;
							}
						} if (n.nextElementSibling !== null) {
							if (n.nextElementSibling.tagName == 'TEXT') {
								$(n.nextElementSibling).prepend(nodes[i]);
								ind = true;
							}
						}

						if (ind === false) {

							text = document.createElement('text');
							$(nodes[i]).after(text);

							text.appendChild(nodes[i]);

						}

					} else mpl.ui.mpl_box.wrapFreeText(nodes[i]);
				}
			}

			return el;

		},

		accessNodes: function (node, thru) {

			if (node === null)
				return [];

			var nodes = node.childNodes, nod, ncl, atts;

			if (thru === undefined)
				thru = [];

			if (nodes === null)
				return thru;

			for (var i = 0; i < nodes.length; i++) {
				/* node element has type = 1 */
				if (nodes[i].nodeType == 1) {

					atts = {};

					for (var j = 0; j < nodes[i].attributes.length; j++) {
						atts[nodes[i].attributes[j].name] = nodes[i].attributes[j].value;
					}

					nod = {
						tag: nodes[i].tagName.toLowerCase(),
						attributes: atts,
					};

					if (nod.tag != 'text')
						nod.children = mpl.ui.mpl_box.accessNodes(nodes[i]);

					ncl = (typeof (nodes[i].className) != 'undefined') ? nodes[i].className : '';

					if (nod.tag == 'text')
						nod.content = nodes[i].innerHTML;
					else if (nod.tag == 'img')
						nod.tag = 'image';
					else if (ncl.indexOf('fa-') > -1 || ncl.indexOf('et-') > -1 || ncl.indexOf('sl-') > -1)
						nod.tag = 'icon';
					else if (nod.tag == 'column') {
						if (ncl === '')
							ncl = 'one-one';
						['one-one', 'one-second', 'one-third', 'two-third'].forEach(function (c) {
							if (ncl.indexOf(c) > -1) {
								ncl = ncl.replace(c, '').trim();
								nod.attributes.cols = c;
								nod.attributes.class = ncl;
							}
						});
					}

					thru[thru.length] = nod;

				}
			}

			return thru;

		},

		accessNodesVisual: function (wrp) {

			var nodes = wrp.find('>.mpl-box:not(.mb-helper)'), nod, thru = [];

			if (nodes.length === 0)
				return thru;

			nodes.each(function () {

				nod = {
					tag: $(this).data('tag'),
					attributes: $(this).data('attributes'),
					children: mpl.ui.mpl_box.accessNodesVisual($(this).find('>.mpl-box-body'))
				};

				if (nod.attributes === undefined)
					nod.attributes = {};

				if (nod.tag == 'text')
					nod.content = $(this).find('.mpl-box-inner-text').html();
				else if (nod.tag == 'icon')
					nod.attributes.class = $(this).find('>.mpl-box-body i').attr('class');
				else if (nod.tag == 'image')
					nod.attributes.src = $(this).find('>.mpl-box-body img').attr('src');

				thru[thru.length] = nod;

			});

			return thru;

		},

		exportCode: function (visual, cols) {

			var thru = '';
			if (cols === undefined)
				cols = '';
			var incol = cols + '	', count = 0;

			visual.forEach(function (n) {

				if (n.tag == 'text') {
					if (n.content !== '')
						thru += cols + '<text>' + n.content.trim().replace(/\<text\>/g, '').replace(/\<\/text\>/g, '') + '</text>';
				} else {
					if (n.attributes.cols == 'one-one') {
						if (n.children.length > 0) {
							thru += mpl.ui.mpl_box.exportCode(n.children, cols);
						}
					} else {

						if (n.attributes.cols !== undefined) {
							n.attributes.class = (n.attributes.class !== undefined) ?
								(n.attributes.class + ' ' + n.attributes.cols) : n.attributes.cols;
							delete n.attributes.cols;
						}

						thru += cols + '<' + n.tag;
						for (var i in n.attributes)
							thru += ' ' + i + '="' + mpl.tools.esc(n.attributes[i]) + '"';
						thru += '>';
						if (n.children.length > 0) {
							thru += "\n" + mpl.ui.mpl_box.exportCode(n.children, incol) + "\n" + cols;
						}

						thru += '</' + n.tag + '>';

					}
				}
				if (count++ < visual.length - 1)
					thru += "\n";

			});

			return thru;

		},

		setColumns: function (e) {

			var el = mpl.get.popup(this).data('el').closest('.mpl-box'),
				wrp = el.find('>.mpl-box-body'),
				cols = $(this).data('cols').split(' '),
				objCols = wrp.find('>.mpl-box.mpl-box-column'),
				elms, colElm, i, j, atts;

			for (i = 0; i < cols.length; i++) {

				if (objCols.get(i)) {

					objCols
						.eq(i)
						.attr({ 'class': 'mpl-box mpl-box-column mpl-column-' + cols[i] })
						.data('attributes').cols = cols[i];

				} else {
					wrp.append(
						mpl.template(
							'box-design', [{ tag: 'column', attributes: { cols: cols[i] } }]
						)
					);
				}
			}
			if (i < objCols.length) {

				for (j = i; j < objCols.length; j++) {
					objCols.eq(j).find('>.mpl-box-body>.mpl-box:not(.mb-helper)').each(function () {
						objCols.eq(i - 1).append(this);
					});
					objCols.eq(j).remove();
				}

			}

			mpl.get.popup(this, 'close').trigger('click');

			mpl.ui.mpl_box.sort();

		},

		actions: function (el, e) {

			var wrp = el.closest('.mpl-param-row').find('.mpl-box-render'), pos, btns, pop, cols, atts;

			switch (el.data('action')) {

				case 'add':

					$('.mpl-box-subPop').remove();
					el.closest('.mb-header').addClass('editting');
					pos = el.data('pos');
					btns = '<div class="mpl-nodes">';
					pop = mpl.tools.popup.render(el.get(0), {
						title: 'Select Node Tag',
						class: 'no-footer mpl-nodes mpl-box-subPop',
						scrollBack: true,
						keepCurrentPopups: true,
						drag: false,
					});

					pop.data({
						pos: pos, el: el, cancel: function (pop) {
							pop.data('el').closest('.mb-header').removeClass('editting');
						}
					});

					['text', 'image', 'icon', 'div', 'span', 'a', 'ul', 'ol', 'li', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6']
						.forEach(function (n) {
							btns += '<button class="button">' + n + '</button> ';
						});

					btns += '</div>';

					btns = $(btns);

					pop.find('.m-p-body').append(btns);

					btns.find('button').on('click', function (e) {

						var html = mpl.template('box-design', [{ tag: this.innerHTML }]),
							pop = mpl.get.popup(this),
							pos = pop.data('pos'),
							el = pop.data('el');

						if (pos == 'top')
							wrp.prepend(html);
						else if (pos == 'bottom')
							wrp.append(html);
						else if (pos == 'inner') {
							el.closest('.mpl-box:not(.mb-helper)').find('>.mpl-box-body').append(html);
						}

						mpl.ui.mpl_box.sort();

						mpl.get.popup(this, 'close').trigger('click');

						e.preventDefault();
						return false;

					});

					e.preventDefault();

					break;

				case 'columns':

					$('.mpl-box-subPop').remove();
					el.closest('.mb-header').addClass('editting');
					btns = '<div class="mpl-nodes">';
					pop = mpl.tools.popup.render(el.get(0), {
						title: 'Select Layout - Columns',
						class: 'no-footer mpl-nodes mpl-columns mpl-box-subPop',
						scrollBack: true,
						keepCurrentPopups: true,
						drag: false,
					});

					pop.data({
						el: el, cancel: function (pop) {
							pop.data('el').closest('.mb-header').removeClass('editting');
						}
					});

					[['one-one', '1/1'],
					['one-second one-second', '1/2 + 1/2'],
					['one-third two-third', '1/3 + 2/3'],
					['two-third one-third', '2/3 + 1/3'],
					['one-third one-third one-third', '1/3 + 1/3 + 1/3']].forEach(function (n) {
						btns += '<button data-cols="' + n[0] + '" class="button ' + n[0].replace(' ', '') +
							'"><span>' + n[1] + '</span></button> ';
					});

					btns += '</div>';

					btns = $(btns);

					pop.find('.m-p-body').append(btns);

					btns.find('button').on('click', mpl.ui.mpl_box.setColumns);

					e.preventDefault();

					break;

				case 'remove':

					if (el.closest('.mpl-box').data('tag') == 'column') {

						if (el.closest('.mpl-box').find('>.mpl-box-body>.mpl-box:not(.mb-helper)').length > 0) {

							if (!confirm(mpl.__.i23))
								return;
						}

						cols = el.closest('.mpl-box').parent().get(0);
						el.closest('.mpl-box').remove();
						var _cols = $(cols).find('>.mpl-box.mpl-box-column'), _clas = 'one-one';

						if (_cols.length == 2)
							_clas = 'one-second';

						_cols.each(function () {
							$(this).attr({ 'class': 'mpl-box mpl-box-column mpl-column-' + _clas })
								.data('attributes').cols = _clas;
						});

						return;
					}

					var trash = el.closest('.mpl-param-row').find('.mpl-box-trash'),
						item = el.closest('.mpl-box').get(0);

					pos = {};

					pos.parent = item.parentNode;
					if (item.nextElementSibling)
						pos.next = item.nextElementSibling;
					if (item.previousElementSibling)
						pos.prev = item.previousElementSibling;

					$(item).data({ pos: pos });

					trash.append(item);
					trash.find('a.button')
						.html('<i class="sl-action-undo"></i> ' + mpl.__.i24 + '(' + trash.find('>.mpl-box').length + ')')
						.removeClass('forceHide');


					break;

				case 'undo':

					trash = el.closest('.mpl-param-row').find('.mpl-box-trash');
					var last = trash.find('>.mpl-box').last().get(0);
					pos = $(last).data('pos');

					if (!last)
						return;

					if (pos.next !== undefined)
						$(pos.next).before(last);
					else if (pos.prev !== undefined)
						$(pos.prev).after(last);
					else if (pos.parent !== undefined)
						$(pos.parent).append(last);

					var nu = trash.find('>.mpl-box').length;

					trash.find('a.button')
						.html('<i class="sl-action-undo"></i> ' + mpl.__.i24 + '(' + nu + ')');

					if (nu === 0)
						trash.find('a.button').addClass('forceHide');

					e.preventDefault();

					break;

				case 'double':

					var clone = el.closest('.mpl-box').clone(true);
					clone.attr({ draggable: '', dropable: '' });
					clone.find('.mpl-box').attr({ draggable: '', dropable: '' });

					el.closest('.mpl-box').after(clone);
					mpl.ui.mpl_box.sort();

					break;

				case 'settings':

					$('.mpl-box-subPop').remove();
					el.closest('.mb-header').addClass('editting');
					atts = el.closest('.mpl-box').data('attributes');
					pop = mpl.tools.popup.render(el.get(0), {
						title: 'Node Settings',
						class: 'mpl-box-settings-popup mpl-box-subPop',
						scrollBack: true,
						keepCurrentPopups: true,
						drag: false,
					});

					pop.data({

						model: null,

						el: el,

						cancel: function (pop) {

							pop.data('el').closest('.mb-header').removeClass('editting');

						},

						callback: function (pop) {

							pop.data('el').closest('.mb-header').removeClass('editting');

							var el = pop.data('el').closest('.mpl-box'),
								attrs = {};

							pop.find('.fields-edit-form .mpl-param').each(function () {
								if (this.value !== '')
									attrs[this.name] = mpl.tools.esc(this.value);
							});

							if (pop.data('css') !== undefined && pop.data('css') !== '')
								attrs.style = pop.data('css');

							if (el.data('attributes').cols !== undefined)
								attrs.cols = el.data('attributes').cols;

							el.data({ attributes: attrs });

							['id', 'class', 'href'].forEach(function (n) {
								if (attrs[n] !== undefined) {
									var elm = el.find('>.mb-header>.mb-' + n), str = attrs[n].substr(0, 30) + '..';

									if (elm.length > 0)
										elm.find('span').html(str).attr({ title: attrs[n] });
									else
										el.find('>.mb-header>.mb-funcs')
											.before('<li class="mb-' + n + '">' + n +
											': <span title="' + mpl.tools.esc(attrs[n]) + '">' + str + '</span></li>');
								}
							});

						},

						css: (typeof (atts.style) != 'undefined') ? atts.style : ''

					});

					wrp = $('<div class="fields-edit-form mpl-pop-tab form-active"></div>');

					var form = $('<form class="attrs-edit"><input type="submit" class="forceHide" /></form>'),

						field = function (n, v) {
							var field = $('<div class="mpl-param-row"><div class="m-p-r-label"><label>' +
								mpl.tools.esc(n) + ':</label></div><div class="m-p-r-content"><input name="' +
								mpl.tools.esc(n) + '" class="mpl-param" value="' +
								v + '" style="width:90%;" type="text">' +
								' &nbsp; <a href="#"><i class="fa-times"></i></a></div></div>');
							field.find('a').on('click', function (e) {
								$(this).closest('.mpl-param-row').remove();
								e.preventDefault();
							});

							return field;

						},

						addInput = function () {

							var add = $('<div style="padding: 10px 0 10px" class="mpl-param-row align-right"><div class="m-p-r-label"></div><form class="m-p-r-content">' +
								'<input style="height: 34px;width: 52.5%;" type="text" placeholder="' + mpl.__.i25 + '" /> ' +
								'<button style="margin-right: 33px;height: 34px;" class="button button-primary">' + mpl.__.i26 + '</button>' +
								'<input type="submit" class="forceHide" /></form></div>');

							add.find('button').on('click', function (e) {

								var input = $(this.parentNode).find('input'),
									val = input.val().replace(/[^a-z-]/g, '');

								input.val('');

								if (val === '' ||
									$(this).closest('.m-p-body').find('input[name=' + val + ']').length > 0 ||
									val == 'style') {

									$(this).stop()
										.animate({ marginRight: 50 }, 100)
										.animate({ marginRight: 28 }, 100)
										.animate({ marginRight: 38 }, 80)
										.animate({ marginRight: 30 }, 80)
										.animate({ marginRight: 33 }, 50);
									return false;
								}

								$(this).closest('.mpl-param-row').before(field(val, ''));

								e.preventDefault();
								return false;
							});

							add.find('form').on('submit', function () {
								$(this).find('button').trigger('click');
								return false;
							});

							return add;
						};

					form.append(field('id', (typeof (atts['id']) != 'undefined') ? atts['id'] : ''));
					form.append(field('class', (typeof (atts['class']) != 'undefined') ? atts['class'] : ''));

					if (el.closest('.mpl-box').get(0).tagName == 'A')
						form.append(field('href', (typeof (atts['href']) != 'undefined') ? atts['href'] : ''));

					for (var i in atts) {
						if (i != 'id' && i != 'class' && i != 'style' && i != 'cols')
							form.append(field(i, atts[i]));
					}

					wrp.append(form);
					wrp.append(addInput());

					form.on('submit', function (e) {
						mpl.get.popup(this, 'save').trigger('click');
						e.preventDefault();
						return false;
					});

					pop.find('.m-p-body').append(wrp);
					break;

				case 'editor':

					$('.mpl-box-subPop').remove();
					el.closest('.mb-header').addClass('editting');
					atts = el.closest('.mpl-box').data('attributes');
					pop = mpl.tools.popup.render(el.get(0), {
						title: 'Node Settings',
						class: 'mpl-box-editor-popup mpl-box-subPop',
						scrollBack: true,
						keepCurrentPopups: true,
						drag: false,
						width: 750
					});

					pop.data({

						model: null,

						el: el,

						cancel: function (pop) {

							pop.data('el').closest('.mb-header').removeClass('editting');

						},

						callback: function (pop) {

							var txt = pop.find('textarea.mpl-param'), content = txt.val().toString().trim();

							if (pop.find('.wp-editor-wrap').hasClass('tmce-active'))
								content = tinyMCE.get(txt.attr('id')).getContent();

							var inner = pop.data('el').closest('.mpl-box').find('.mpl-box-inner-text');

							inner.html(content);

						}

					});

					atts = {

						value: el.closest('.mpl-box').find('.mpl-box-inner-text').html(),
						options: [],
						name: 'content',
						type: 'textarea_html'

					};
					field = mpl.template('field', {
						label: '',
						content: mpl.template('field-type-textarea_html', atts),
						des: '',
						name: 'textarea_html',
						base: 'content'
					});

					pop.find('.m-p-body').append(field);

					if (typeof atts.callback == 'function') {
						/* callback from field-type template */
						setTimeout(atts.callback, 1, pop.find('.m-p-body'), $);
					}

					break;

				case 'toggle':

					wrp = el.closest('.mpl-box');
					if (wrp.hasClass('mpl-box-toggled'))
						wrp.removeClass('mpl-box-toggled');
					else wrp.addClass('mpl-box-toggled');

					break;

				case 'html-code':

					$('.mpl-box-html-code').remove();

					atts = {
						title: mpl.__.i29,
						width: 700,
						class: 'mpl-box-html-code',
						keepCurrentPopups: true,
						drag: false
					};

					pop = mpl.tools.popup.render(el.get(0), atts);
					pop.data({ target: el, scrolltop: $(window).scrollTop() });

					/*Render from Visual*/
					var code = mpl.ui.mpl_box.exportCode(
						mpl.ui.mpl_box.accessNodesVisual(
							mpl.get.popup(el).find('.mpl-box-render')
						)
					);

					pop.find('.m-p-body').html('<textarea>' + code + '</textarea>');

					pop.data({
						popParent: mpl.get.popup(el), callback: function (pop) {

							var code = '<div>' + pop.find('.m-p-body textarea').val().trim() + '</div>',
								visual = mpl.ui.mpl_box.wrapFreeText($(code).get(0)),
								items = mpl.ui.mpl_box.accessNodes(visual),
								popParent = pop.data('popParent');

							popParent.find('.mpl-box-render').html(
								mpl.template('box-design', items)
							);

							mpl.ui.mpl_box.sort();

							/* Clear Trash */
							popParent.find('.mpl-box-trash .mpl-box').remove();
							popParent.find('.mpl-box-trash>a.button').addClass('forceHide');

						}
					});

					break;

				case 'css-code':

					$('.mpl-box-html-code').remove();

					atts = {
						title: mpl.__.i30,
						width: 700,
						class: 'mpl-box-html-code',
						keepCurrentPopups: true,
						drag: false
					};

					var popParent = mpl.get.popup(el);

					pop = mpl.tools.popup.render(el.get(0), atts);
					pop.data({ target: el, scrolltop: $(window).scrollTop() });

					var css = popParent.find('.field-hidden.field-base-css_code input').val(), css_code = '';

					pop.find('.m-p-body').html('<p></p><textarea>' + mpl.tools.decode_css(css) + '</textarea><i class="ntips">' + mpl.__.i31 + '</i>');

					var btn = $('<button class="button button-larger"><i class="sl-energy"></i> ' + mpl.__.i32 + '</button>');

					pop.find('.m-p-body').prepend(btn);

					btn.on('click', function () {
						var txta = $(this).parent().find('textarea');
						txta.val(mpl.tools.decode_css(txta.val()));
					});

					pop.data({
						popParent: mpl.get.popup(el), callback: function (pop) {


							var css = mpl.tools.encode_css(pop.find('textarea').val());

							pop.data('popParent').find('.field-hidden.field-base-css_code input').val(css);

						}
					});

					break;

				case 'icon-picker':

					$('.mpl-icons-picker-popup,.mpl-box-subPop').remove();

					var listObj = $('<div class="icons-list noneuser">' + mpl.tools.get_icons() + '</div>');

					atts = { title: 'Select Icons', width: 600, class: 'no-footer mpl-icons-picker-popup mpl-box-subPop', keepCurrentPopups: true };
					pop = mpl.tools.popup.render(el.get(0), atts);
					pop.data({ target: el, scrolltop: jQuery(window).scrollTop() });

					var search = $('<input type="search" class="mpl-components-search" placeholder="Search by Name" />');
					pop.find('.m-p-header').append(search);
					search.after('<i class="sl-magnifier"></i>');
					search.data({ list: listObj });

					search.on('keyup', listObj, function (e) {

						clearTimeout(this.timer);
						this.timer = setTimeout(function (el, list) {
							var sr;
							if (list.find('.seach-results').length === 0) {

								sr = $('<div class="seach-results"></div>');
								list.prepend(sr);

							} else sr = list.find('.seach-results');

							var found = ['<span class="label">' + mpl.__.i33 + '</span>'];
							list.find('>i').each(function () {

								if (this.className.indexOf(el.value.trim()) > -1 &&
									found.length < 14 &&
									$.inArray(this.className, found)
								) found.push('<span data-icon="' + this.className + '"><i class="' + this.className + '"></i>' + this.className + '</span>');

							});
							if (found.length > 1) {
								sr.html(found.join(''));
								sr.find('span').on('click', function () {
									var tar = mpl.get.popup(this).data('target');
									tar.find('i').attr({ class: $(this).data('icon') });
									mpl.get.popup(this, 'close').trigger('click');
								});
							}
							else sr.html('<span class="label">' + mpl.__.i34 + '</span>');

						}, 150, this, e.data);

					});

					listObj.find('i').on('click', function () {

						var tar = mpl.get.popup(this).data('target');
						tar.find('i').attr({ class: this.className });
						mpl.get.popup(this, 'close').trigger('click');

					});

					setTimeout(function (el, list) {
						el.append(list);
					}, 10, pop.find('.m-p-body'), listObj);

					break;

				case 'select-image':

					var media = mpl.tools.media.open({
						data: {
							callback: function (atts) {

								var url = atts.url;

								if (atts.size !== undefined && atts.size !== null && atts.sizes[atts.size] !== undefined) {
									url = atts.sizes[atts.size].url;
								} else if (typeof atts.sizes.medium == 'object') {
									url = atts.sizes.medium.url;
								}

								if (url !== undefined && url !== '') {

									el.attr({ src: url });

								}
							}, atts: { frame: 'post' }
						}
					});

					media.$el.addClass('mpl-box-media-modal');

					break;
			}

			if (el.hasClass('mpl-box-toggled') && el.hasClass('mpl-box'))
				el.removeClass('mpl-box-toggled');

			e.preventDefault();
			return false;
		}
	},

	elms: function (e, el) {

		var type = $(el).data('type'),
			cfg = $(el).data('cfg'),
			value = '';

		if (e.target.tagName == 'LI' && type == 'radio') {

			var wrp = $(e.target).parent();
			wrp.find('.active').removeClass('active');
			wrp.find('input[type="radio"]').attr({ checked: false });
			$(e.target).addClass('active');

			value = $(e.target).find('input[type="radio"]').attr({ checked: true }).val();

		}

		if (type == 'select') {
			value = el.value;
		}

		if (value !== '' && cfg !== '' && cfg !== undefined) {
			mpl.cfg[cfg] = value;
			mpl.backbone.stack.set('MPL_Configs', mpl.cfg);
		}
	},

	prepare: function (name, data, content) {
		var maps = mpl.maps[name] !== undefined ? mpl.maps[name] : {},
			map_params = mpl.params.merge(name),
			full = '[' + name,
			id = Math.round(Math.random() * 1000000);

		full += ' _id="' + id + '"';
		if (content === undefined) {
			if (name == 'mpl_row')
				content = '[mpl_column width="100%"][/mpl_column]';
			else if (name == 'mpl_row_inner')
				content = '[mpl_column_inner width="100%"][/mpl_column_inner]';
			else content = '';
		}

		if (mpl.maps[name] !== undefined && mpl.maps[name].content !== undefined && content === '')
			content = mpl.maps[name].content;

		for (var i in map_params) {
			if (map_params[i].type == 'random') {
				full += ' ' + map_params[i].name + '="' + parseInt(Math.random() * 1000000, 10) + '"';
			} else if (!_.isUndefined(map_params[i].value)) {
				if (map_params[i].name == 'content' && maps.is_container === true) {
					content = map_params[i].value;
				} else {
					full += ' ' + map_params[i].name + '="' + map_params[i].value + '"';
				}
			}
			if (map_params[i].type == 'css') {
				var Obj = {};
				if (map_params[i].options) {
					Obj['mpl-css'] = {};
					if (map_params[i].options[0] instanceof Object) {
						if (map_params[i].options[0].screens) {
							Obj['mpl-css'][map_params[i].options[0].screens] = {};
						}
						for (var attr in map_params[i].options[0]) {
							if (attr === 'screens') {
								continue
							}
							else {
								if (map_params[i].options[0][attr] instanceof Array) {
									for (var j = 0; j < map_params[i].options[0][attr].length; j++) {
										for (var subattr in map_params[i].options[0][attr][j]) {
											if (map_params[i].options[0][attr][j].value) {
												if (!Obj['mpl-css'][map_params[i].options[0].screens][attr.toLocaleLowerCase()]) {
													Obj['mpl-css'][map_params[i].options[0].screens][attr.toLocaleLowerCase()] = {};
												}
												if (map_params[i].options[0][attr][j].selector) {
													Obj['mpl-css'][map_params[i].options[0].screens][attr.toLocaleLowerCase()][map_params[i].options[0][attr][j].property + '|' + map_params[i].options[0][attr][j].selector] = {};
													Obj['mpl-css'][map_params[i].options[0].screens][attr.toLocaleLowerCase()][map_params[i].options[0][attr][j].property + '|' + map_params[i].options[0][attr][j].selector] = map_params[i].options[0][attr][j].value;
												} else {
													Obj['mpl-css'][map_params[i].options[0].screens][attr.toLocaleLowerCase()][map_params[i].options[0][attr][j].property + '|'] = {};
													Obj['mpl-css'][map_params[i].options[0].screens][attr.toLocaleLowerCase()][map_params[i].options[0][attr][j].property + '|'] = map_params[i].options[0][attr][j].value;
												}
											}
										}
									}
								}
							}
						}
					}
				}
				full += ' ' + map_params[i].name + '="' + JSON.stringify(Obj).replace(/\"/g, '`') + '"';
			}
			//magee end
		}

		if (name == 'mpl_wp_widget')
			full += ' data="' + data + '"';

		full += ']';

		if (maps.is_container === true) {
			full += content + '[/' + name + ']';
		}

		delete map_params;

		return full;

	},

	publishAction: function (e) {

		if (e.data) {
			var rect = e.data.getBoundingClientRect();
			var sctop = $(window).scrollTop();
			if (e.data.sctop === undefined)
				e.data.sctop = rect.top + sctop;

			if (e.data.sctop < sctop + 35)
				$(e.data).addClass('float_publish_action');
			else
				$(e.data).removeClass('float_publish_action');
		}

	},

	search_elements: function (e) {

		var key = this.value.toLowerCase()

		if (this.pop === undefined)
			this.pop = mpl.get.popup(this) !== null ? mpl.get.popup(this) : $(this).closest('#mpl-elements-list');

		if (this.items === undefined)
			this.items = this.pop.find('.mpl-components .mpl-components-list-main li');

		this.pop.find('#mpl-clipboard,.mpl-wp-widgets-pop').hide();
		this.pop.find('.mpl-components .mpl-components-list-main').show();

		this.pop.find('.mpl-components .mpl-components-categories .active').removeClass('active');

		this.items.css({ display: 'none' });
		this.items.each(function () {
			var find = $(this).find('strong').html().toLowerCase();
			if (find.indexOf(key) > -1 || key === '')
				this.style.display = 'block';
		});

	},

	upgrade_notice: function (old_version) { },

	lightbox: function (cfg) {

		var wrp = $('#mpl-preload .mpl-preload-body');

		if (wrp.length === 0) {

			$('#wpwrap').append('<div id="mpl-preload"><div id="mpl-welcome" style="display: block;" class="mpl-preload-body"><a href="#" class="close"><i class="sl-close"></i></a></div></div>');

			wrp = $('#mpl-preload .mpl-preload-body');
			wrp.find('a.close').on('click', function () {
				$(this).closest('#mpl-preload').remove();
				$('.mpl-ui-blur').removeClass('mpl-ui-blur');
			});

			$('#mpl-preload').on('click', function (e) {
				if (e.target.id == 'mpl-preload') {
					$(this).remove();
					$('.mpl-ui-blur').removeClass('mpl-ui-blur');
				}
			});

		}

		wrp.find('>*:not(a.close)').remove();

		cfg = $.extend({
			width: '1000',
			height: '576',
			padding: '10',
			iframe: false,
			url: '',
			msg: ''
		}, cfg);

		if (cfg.iframe === true) {
			cfg.msg = '<iframe width="' + cfg.width + '" height="' + cfg.height + '" src="' + cfg.url + '" frameborder="0" allowfullscreen></iframe>'
		}

		wrp.css({ width: cfg.width + 'px', height: cfg.height + 'px', padding: cfg.padding + 'px' }).append(cfg.msg);

		return wrp;

	},

	fonts_callback: function (datas) {

		window.mpl_fonts = datas;

		var uri = '//fonts.googleapis.com/css?family=', link, fid;

		for (var family in datas) {

			fid = decodeURIComponent(family);
			fid = fid.replace(/\ /g, '-').toLowerCase();

			if (document.getElementById(fid + '-css') === null) {
				link = family.replace(/ /g, '+') + ':' + datas[family][1] + encodeURIComponent('&subset=') + datas[family][1];
				link = '<link rel="stylesheet" id="' + fid + '-css" href="' + (uri + link) + '" type="text/css" media="all" />';
				$('head').append(link);
				if (mpl.frame !== undefined) {
					mpl.frame.$('head').append(link);
				}
			}
		}

	},

	right_click: function (e) {

		// remove exist menus
		$('.mpl-right-click-dialog').remove();

		var ob = $(e.target).hasClass('mpl-model') ? $(e.target) : $(e.target).closest('.mpl-model');

		if (ob.length > 0) {

			var ww = $(window).width(),
				wh = $(window).height(),
				model = ob.attr('id').toString().replace('model-', ''),
				css = {
					position: 'fixed',
					zIndex: 99999,
					left: e.clientX + 'px',
					top: e.clientY + 'px'
				}

			if (mpl.storage[model] === undefined)
				return false;
			/*
				Close all popup before open panel
			*/
			$('.mpl-params-popup .sl-close.sl-func').trigger('click');

			var name = mpl.storage[model].name,
				actions = {
					edit: '<li data-act="edit"><i class="fa-edit"></i> Edit</li>',
					insert: '<li data-act="insert"><i class="fa-columns"></i> New ' + name.replace('mpl_', '').replace(/\_/g, ' ') + '</li>',
					copy: '<li data-act="copy"><i class="fa-copy"></i> Copy ' +
					'<ul class="sub">' +
					'<li data-act="copystyle"><i class="fa-paint-brush"></i> ' +
					'Copy style only</li>' +
					'</ul></li>',
					copystyle: '<li data-act="copystyle"><i class="fa-paint-brush"></i> Copy style only</li>',
					paste: '<li data-act="paste"><i class="fa-paste"></i> Paste ' +
					'<ul class="sub">' +
					'<li data-act="pastestyle"><i class="fa-paint-brush"></i> ' +
					'Paste style only</li>' +
					'</ul></li>',
					double: '<li data-act="double"><i class="fa-clone"></i> Double</li>',
					add: '<li data-act="add"><i class="fa-plus"></i> Add Sections</li>',
					cut: '<li data-act="cut"><i class="fa-cut"></i> Cut</li>',
					clear: '<li data-act="clear"><i class="fa-eraser"></i> Clear style</li>',
					delete: '<li data-act="delete"><i class="fa-trash"></i> Delete</li>'
				};

			if (['mpl_column', 'mpl_column_inner'].indexOf(name) > -1) {
				delete actions.copy;
				delete actions.cut;
			} else if (mpl_maps_view.indexOf(name) > -1) {
				delete actions.copystyle;
			} else {
				delete actions.insert;
				delete actions.copystyle;
			}

			var actions_content = '';
			for (var n in actions) {
				actions_content += actions[n];
			}

			var dialog = '<div id="mpl-elms-breadcrumn" class="mpl-right-click-dialog">\
							<ul>\
								<li class="item active">\
									<span class="pointer">\
										<i class="fa-dot-circle-o"></i> \
										' + name.replace(/_/g, ' ') + '\
									</span>\
									<ul>' + actions_content + '</ul>\
								</li>\
							</ul>\
						</div>';


			dialog = $(dialog);

			$('#mpl-right-click-helper').show().html('').append(dialog);

			dialog.css(css).on('mouseover', function (e) {
				ob.addClass('mpl-hover-me');
			}).on('mouseout', function (e) {
				ob.removeClass('mpl-hover-me');
			}).on('click', function (e) {

				var act = $(e.target).data('act');

				if (act === undefined)
					return;
				switch (act) {

					case 'edit':
						ob.find('.edit').first().trigger('click');
						break;

					case 'add':
						mpl.backbone.add(ob.get(0));
						break;

					case 'cut':
						mpl.backbone.cut(ob.find('div').get(0));
						break;

					case 'copy':
						mpl.backbone.copy(ob.find('div').get(0));
						break;

					case 'copystyle':

						if (mpl.cfg.copied_style === undefined)
							mpl.cfg.copied_style = {};

						var name = mpl.storage[model].name,
							atts = mpl.storage[model].args,
							params = mpl.params.merge(name),
							is_css = [], values = {};

						if (atts['_id'] === undefined) {
							console.warn('MPL: Missing id of the element when trying to render css');
							return '';
						}

						for (n in params) {
							if (params[n].type == 'css')
								is_css.push(params[n].name);
						}

						for (n in atts) {

							if (is_css.indexOf(n) > -1 || n.indexOf('_css_inspector') === 0)
								values[n] = atts[n];

						}

						mpl.cfg.copied_style[name] = values;
						// update to storage
						mpl.backbone.stack.set('MPL_Configs', mpl.cfg);

						break;

					case 'paste':

						content = mpl.backbone.stack.get('MPL_RowClipboard');
						if (content === undefined || content == '') {
							alert(mpl.__.i38);
							return;
						}
						if (content.trim().indexOf('[mpl_row ') === 0 || content.trim().indexOf('[mpl_row ') === 0) {
							var fid = mpl.backbone.push(content);
							ob.closest('.mpl-row').after($('#model-' + fid));
							mpl.ui.scrollAssistive($('#model-' + fid));
						} else mpl.backbone.push(content, model, 'bottom');

						break;

					case 'pastestyle':

						if (mpl.cfg.copied_style === undefined)
							return;

						var name = mpl.storage[model].name,
							atts = mpl.storage[model].args;

						if (mpl.cfg.copied_style[name] === undefined)
							return;

						for (n in mpl.cfg.copied_style[name]) {
							mpl.storage[model].args[n] = mpl.cfg.copied_style[name][n];
						}

						break;

					case 'double':
						var name = mpl.storage[model].name;
						if (mpl_maps_view.indexOf(name) > -1)
							ob.find('>.mpl-vs-control .double').trigger('click');
						else mpl.backbone.double(ob.get(0));
						break;

					case 'insert':

						var name = mpl.storage[model].name;
						if (mpl_maps_view.indexOf(name) > -1) {
							mpl.views.views_sections.do_add_section(ob.closest('.mpl-views-sections-wrap').get(0));
						} else mpl.views.column.insert(model);

						break;

					case 'clear':

						var atts = mpl.storage[model].args,
							params = mpl.params.merge(mpl.storage[model].name),
							is_css = [], n;

						if (atts['_id'] === undefined) {
							console.warn('MPL: Missing id of the element when trying to clear css');
							return '';
						}

						for (n in params) {
							if (params[n].type == 'css')
								is_css.push(params[n].name);
						}

						for (n in atts) {

							if (is_css.indexOf(n) > -1 || n.indexOf('_css_inspector') === 0) {
								delete mpl.storage[model].args[n];
							}

						}

						break;

					case 'delete':
						ob.find('.delete').first().trigger('click');
						break;
				}

				mpl.ui.exit_right_click(true);

			});

			if (e.clientX > ww / 2)
				dialog.css({ left: (e.clientX - dialog.width()) + 'px' });
			else
				dialog.addClass('mpl-rc-left');

			if (e.clientY + 32 + dialog.height() > wh)
				dialog.css({ top: (wh - 32 - dialog.height()) + 'px' });
			else
				dialog.addClass('mpl-rc-top');

		}

		$('body').css({ overflow: 'hidden' });

	},

	exit_right_click: function (e) {
		if (e == 'force' || $(e.target).closest('.mpl-right-click-dialog').length === 0) {
			$('.mpl-right-click-dialog').remove();
			$('#mpl-right-click-helper').hide();
			$('.mpl-hover-me').removeClass('mpl-hover-me');
			$('body').css({ overflow: '' });
		}
	},

	verify_tmpl: function () {

		var cfg = $().extend(mpl.cfg, mpl.backbone.stack.get('MPL_Configs'));
		localStorage['MPL_TMPL_CACHE'] = '';
		if (cfg.version != mpl_version || localStorage['MPL_TMPL_CACHE'] === undefined || localStorage['MPL_TMPL_CACHE'] === '') {

			mpl.msg('Initializing', 'loading');

			$.post(
				mpl_ajax_url,
				{
					'action': 'mpl_tmpl_storage',
					'security': mpl_ajax_nonce
				},
				function (result) {
					$('#mpl-preload').remove();

					if (result != -1 && result != 0) {

						mpl.ui.upgrade_notice(parseFloat(cfg.version));

						cfg.version = mpl_version;

						mpl.backbone.stack.set('MPL_Configs', cfg);
						mpl.backbone.stack.set('MPL_TMPL_CACHE', result);

						mpl.init();
					}
				}
			);
		} else return true;
	},

	get_tmpl_cache: function (tmpl_id) {

		if (localStorage['MPL_TMPL_CACHE'] !== undefined && localStorage['MPL_TMPL_CACHE'].indexOf('id="' + tmpl_id + '"') > -1) {

			var s1 = localStorage['MPL_TMPL_CACHE'].indexOf('>', localStorage['MPL_TMPL_CACHE'].indexOf('id="' + tmpl_id + '"')) + 1,

				s2 = localStorage['MPL_TMPL_CACHE'].indexOf('</script>', s1),

				string = localStorage['MPL_TMPL_CACHE'].substring(s1, s2),
				options = {
					evaluate: /<#([\s\S]+?)#>/g,
					interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
					escape: /\{\{([^\}]+?)\}\}(?!\})/g,
					variable: 'data'
				};

			return _.template(string, null, options);

		}

		return 'exit';

	},

	uncache: function () {

		localStorage.removeItem('MPL_TMPL_CACHE');
		window.location.href = window.location.href;

		return 'Successfull, reloading now...';
	},	

	fix_position_popup: function (pop) {
		/*
		*	Add class identify
		*/
		//pop.addClass('mpl-live-editor-popup');
		/*
		*	Resizable popup
		*/

		pop.find('.wp-pointer-arrow').on('mousedown', function (e) {

			if (e.which !== undefined && e.which !== 1)
				return false;

			$('html,body').css({ cursor: 'col-resize' }).addClass('mpl_dragging noneuser mpl-ui-dragging');

			var mouseUp = function (e) {

				$(document).off('mousemove');
				$(window).off('mouseup');

				setTimeout(function () {
					$('html,body').css({ cursor: '' }).removeClass('mpl_dragging noneuser mpl-ui-dragging');
				}, 200);

			},

				mouseMove = function (e) {

					e.preventDefault();
					var d = e.data;
					d.offset = e.clientX - d.left;

					var _w = (d.width + d.offset);
					// pop width > 1000
					if (_w >= 1000)
						return;

					if (_w <= 400) {

						_w = 400;

					}

					d.el.style.width = _w + 'px';
					mpl.cfg.live_popup.width = _w + 'px';

				};

			$(document).off('mousemove').on('mousemove',
				{

					el: pop.get(0),
					width: parseInt(pop.width(), 10),
					eleft: parseInt(pop.css('left'), 10),
					left: e.clientX

				}, mouseMove);


			$(window).off('mouseup').on('mouseup',
				{
					frame: $('#mpl-live-frame').get(0),
					el: pop
				}, mouseUp);

		});

		if (mpl.cfg.live_popup === undefined)
			mpl.cfg.live_popup = {
				top: '50px',
				left: '750px',
				width: '661px'
			};

		var w_ = $(window).width(),
			_l = parseInt(mpl.cfg.live_popup.left, 10),
			_w = parseInt(mpl.cfg.live_popup.width, 10);

		if (_w + _l > w_) {
			mpl.cfg.live_popup.left = (w_ - _w) + 'px';
		} else if (_l < 10) {
			mpl.cfg.live_popup.left = '0px';
		}

		pop.css(mpl.cfg.live_popup);

		if (mpl.cfg.live_popup.sticky === true) {
			pop.addClass('mpl-popup-stickLeft');
		}

	},

	instantor: {

		mainTmpl: '<span class="instmore">\
			<select class="format">\
				<option value="p">Paragraph</option>\
				<option value="h1">Heading 1</option>\
				<option value="h2">Heading 2</option>\
				<option value="h3">Heading 3</option>\
				<option value="h4">Heading 4</option>\
				<option value="h5">Heading 5</option>\
				<option value="h6">Heading 6</option>\
				<option value="pre">Preformatted</option>\
			</select>\
			<i class="fa-align-justify" data-format="justifyfull" title="Text align justify"></i> \
			<i class="fa-font" title="Fill color"></i> \
			<i class="fa-underline" data-format="underline" title="Underline"></i> \
			<i class="fa-strikethrough" data-format="strikethrough" title="Strike through"></i> \
			<i class="fa-eraser" data-act="clearformat" title="Clear formatting"></i> \
			<i class="fa-outdent" data-format="outdent" title="Decrease indent"></i> \
			<i class="fa-indent" data-format="indent" title="Increase indent"></i> \
			<i class="sl-cursor-move" data-act="move" title="Move dialog" style="float:right"></i> \
		</span> \
		<span class="instmostuse">\
			<i class="fa-bold" title="Bold" data-format="bold"></i> \
				<i class="fa-italic" title="Italic" data-format="italic"></i> \
				<i class="fa-list-ul" title="Bulleted list" data-format="insertunorderedlist"></i> \
				<i class="fa-list-ol" title="Numbered list" data-format="insertorderedlist"></i> \
				<i class="fa-quote-left" title="Blockquote" data-format="formatblock:blockquote"></i> \
				<i class="fa-link" title="Insert link" data-act="insertlink"></i> \
				<i class="fa-align-left" title="Text align left" data-format="justifyleft"></i> \
				<i class="fa-align-center" title="Text align center" data-format="justifycenter"></i> \
				<i class="fa-align-right" title="Text align right" data-format="justifyright"></i> \
				<i class="fa-image" data-act="insertimages" title="Insert images"></i> \
				<i class="sl-options" data-act="more" title="More"></i>\
		</span>',

		imageTmpl: '<span class="instmostuse"> \
			<i class="fa-pencil" title="Change image" data-act="changeimage"></i> \
			<i class="fa-align-left" title="Text align left" data-format="justifyleft"></i> \
			<i class="fa-align-center" title="Text align center" data-format="justifycenter"></i> \
			<i class="fa-align-right" title="Text align right" data-format="justifyright"></i> \
			<i class="fa-times" title="Remove image" data-act="removeimage"></i> \
			<label>Width:</label> <input style="width:80px" type="number" data-act="imagewidth" /> \
		</span>',

		onclick: function (e, el) {

			if (e.target.tagName == 'IMG') {
				el.setAttribute('data-live-editor', '');
				el.setAttribute('contenteditable', true);
				el.focus();
				return this.clickImage(e, el);
			}

			if (el.getAttribute('data-live-editor') != 'open') {
				el.setAttribute('data-live-editor', 'open');
				el.setAttribute('contenteditable', true);
				el.focus();
			} else {
				return false;
			}

			if (mpl.id('mpl-instantor') !== null)
				$('#mpl-instantor').remove();

			$('body').append('<div id="mpl-instantor">' + this.mainTmpl + '</div>');

			this.possition(e, el, false);

			var inst = $('#mpl-instantor');

			if (mpl.cfg.instmore)
				inst.addClass('ismore');

			inst.data({ el: el });

			inst.on('click', function (e) {
				var act = $(e.target).data('act'),
					format = $(e.target).data('format');
				switch (act) {
					case 'more':
						if ($(this).hasClass('ismore')) {
							mpl.cfg.instmore = false;
							$(this).removeClass('ismore')
						} else {
							mpl.cfg.instmore = true;
							$(this).addClass('ismore')
						}
						mpl.backbone.stack.set('MPL_Configs', mpl.cfg);
						break;
					case 'insertlink':
						var sLnk = prompt('Write the URL here', 'http:\/\/');
						if (sLnk && sLnk != '' && sLnk != 'http://')
							mpl.ui.instantor.format('createlink', sLnk);
						break;
					case 'clearformat':

						mpl.ui.instantor.clearformat();

						break;
					case 'insertimages':
						mpl.tools.media.opens({
							data: function (atts) {
								mpl.ui.instantor.format('insertHTML', wp.media.string.image(atts));
							}
						});
						break;
				}

				if (format !== undefined) {
					format = format.split(':');
					mpl.ui.instantor.format(format[0], format[1]);
				}

			});

			inst.find('select.format').on('change', function (e) {
				mpl.ui.instantor.format('formatblock', this.value);
			});

			mpl.ui.draggable(inst.get(0), 'i[data-act="move"]');
			mpl.add_action('mpl-draggable-end', 'fgE6td4wS', function (e) {
				mpl.ui.instantor.pos = { top: e.data.style.top, left: e.data.style.left };
			});

			// update current target to toolbars
			this.target(e);

			return inst;

		},

		clickImage: function (e, el) {

			if (mpl.id('mpl-instantor') !== null)
				$('#mpl-instantor').remove();

			$('body').append('<div id="mpl-instantor">' + this.imageTmpl + '</div>');

			var inst = $('#mpl-instantor');
			inst.data({ el: el });

			inst.on('click', e.target, function (e) {

				var act = $(e.target).data('act'),
					format = $(e.target).data('format'),
					el = e.data,
					$this = $(this);

				if (format !== undefined)
					return mpl.ui.instantor.format(format, null);

				if (act == 'removeimage') {

					if (el.parentNode.tagName == 'A')
						el = el.parentNode;

					var selection = mpl.ui.instantor.selection(),
						range = mpl.ui.instantor.range();

					selection.removeAllRanges();
					range.selectNode(el);
					selection.addRange(range);

					mpl.ui.instantor.format('delete', null);

					$(this).data('el').setAttribute('data-live-editor', '');
					$(this).remove();
				}

				if (act == 'changeimage') {
					mpl.tools.media.opens({
						data: function (atts) {

							if (el.parentNode.tagName == 'A')
								el = el.parentNode;

							var selection = mpl.ui.instantor.selection(),
								range = mpl.ui.instantor.range();

							selection.removeAllRanges();
							range.selectNode(el);
							selection.addRange(range);

							mpl.ui.instantor.format('delete', null);
							mpl.ui.instantor.format('insertHTML', wp.media.string.image(atts));
							$('#mpl-instantor').data('el').setAttribute('data-live-editor', '');
							$('#mpl-instantor').remove();

						}
					});
				}

			});

			inst.find('input[data-act="imagewidth"]').val(e.target.getAttribute('width')).on('change', e.target, function (e) {
				if (e.data.getAttribute('height') !== undefined)
					e.data.removeAttribute('height');
				e.data.setAttribute('width', this.value.replace(/\D/g, ''));
			});

			inst.addClass('imgclick').css({ top: e.clientY + 'px', left: (e.clientX - (inst.width() / 2)) + 'px' });

		},

		possition: function (e, el, dy) {

			if (mpl.id('mpl-instantor') !== null) {

				if (dy === false && mpl.ui.instantor.pos !== undefined) {
					$('#mpl-instantor').css(mpl.ui.instantor.pos);
					return;
				}

				var coor = el.getBoundingClientRect(),
					left = coor.left + (coor.width / 2) - 187,
					top = coor.top > 100 ? coor.top : 100;

				$('#mpl-instantor').css({ top: top + 'px', left: left + 'px' });

			}

		},

		target: function (e) {

			if (mpl.id('mpl-instantor') !== null) {

				var el = e.target,
					pop = $('#mpl-instantor');

				pop.data({ clicked: e.target });
				pop.find('i').removeClass('active');

				while (el !== null && el.getAttribute('contenteditable') === null) {

					switch (el.tagName) {
						case 'I': pop.find('i[data-format="italic"]').addClass('active'); break;
						case 'B': pop.find('i[data-format="bold"]').addClass('active'); break;
						case 'U': pop.find('i[data-format="underline"]').addClass('active'); break;
						case 'BLOCKQUOTE': pop.find('i[data-format="formatblock:blockquote"]').addClass('active'); break;
						case 'A': pop.find('i[data-act="insertlink"]').addClass('active'); break;
						case 'OL': pop.find('i[data-format="insertorderedlist"]').addClass('active'); break;
						case 'UL': pop.find('i[data-format="insertunorderedlist"]').addClass('active'); break;
						case 'STRIKE': pop.find('i[data-format="strikethrough"]').addClass('active'); break;
					}

					switch (el.style.textAlign) {
						case 'left': pop.find('i[data-format="justifyleft"]').addClass('active'); break;
						case 'center': pop.find('i[data-format="justifycenter"]').addClass('active'); break;
						case 'right': pop.find('i[data-format="justifyright"]').addClass('active'); break;
						case 'justify': pop.find('i[data-format="justifyfull"]').addClass('active'); break;
					}

					el = el.parentNode;

				}
			}
		},

		format: function (cmd, value) {

			if (mpl.id('mpl-instantor') !== null) {

				var relm = this.elmAtRange(), el = $('#mpl-instantor').data('el');
				if (cmd == 'formatblock' && relm !== null) {
					if ($(relm).closest(value.toLowerCase()).length > 0)
						value = '<p>';
				}

				if (mpl.front !== undefined)
					mpl.frame.doc.execCommand(cmd, false, value);
				else document.execCommand(cmd, false, value);

				if (el !== undefined)
					el.focus();
			}

		},

		elmAtRange: function () {

			try {
				var selection = this.selection();
				var range = selection.getRangeAt(0);

				if (range !== 0) {
					var containerElement = range.commonAncestorContainer;
					if (containerElement.nodeType != 1) {
						containerElement = containerElement.parentNode;
					}
					return containerElement;
				}
			} catch (ex) { };

			return null;

		},

		selection: function () {
			if (mpl.front !== undefined)
				return mpl.frame.doc.getSelection();
			else document.getSelection();
		},

		range: function () {
			if (mpl.front !== undefined)
				return mpl.frame.doc.createRange();
			else document.createRange();
		},

		clearformat: function () {

			var html = "";
			var sel = this.selection();
			if (sel.rangeCount) {
				var container = document.createElement("p");
				for (var i = 0, len = sel.rangeCount; i < len; ++i) {
					container.appendChild(sel.getRangeAt(i).cloneContents());
				}
				html = container.innerText;
			}
			if (html === '') {

				var select = this.selection().getRangeAt(0),
					el = select['startContainer'].parentNode,
					txt = el.innerText;

				if (el.tagName !== 'P') {

					if (el.tagName == 'LI') {
						el = el.parentNode;
						txt = el.innerText;
					}

					var selection = this.selection(),
						range = this.range();

					selection.removeAllRanges();
					range.selectNode(el);
					selection.addRange(range);

					this.format('delete', null);
					$(el).remove();
					this.format('insertHTML', '<p>' + txt + '</p>');

				}
				return;
			}

			this.format('delete', null);
			this.format('insertHTML', '<p>' + html + '</p>');
		}
	},
},
}, window.mpl);
window.mpl.ui = $.extend({
sections: {
	render: function (pop) {

		var arg = { pop: pop },
			wrp = $(mpl.template('sections', arg)),
			imgs = wrp.find('img');

		pop.find('.m-p-body').html(wrp);

		if (typeof arg.callback == 'function')
			arg.callback(wrp, $, arg);

		mpl.tools.popup.callback(pop, {
			cancel: function (pop, e) {

				mpl.sections.scroll_top = pop.find('.m-p-body').scrollTop();

			}
		}, 'dgRw26e');

		mpl.sections.imags_total = imgs.length;
		mpl.sections.imags_ready = 0;
		imgs.each(function () {

			this.onload = function () {
				mpl.sections.imags_ready++;
				if (mpl.sections.imags_ready == mpl.sections.imags_total) {
					new Masonry(wrp.get(0), {
						itemSelector: '.mpl-sections-item',
						columnWidth: '.mpl-sections-item',
					});
					pop.find('.m-p-body').scrollTop(mpl.sections.scroll_top);
				}
			}

		});

	},

	render_callback: function (wrp, $, data) {

		data.pop.find('h3.m-p-header .mpl-section-control').remove();

		mpl.trigger({

			el: wrp.find('.mpl-section-control'),
			events: {
				'.reload:click': mpl.ui.sections.reload,
				'.content-type:change': 'type',
				'.category:change': 'category',
				'.mpl-add-new-section:click': 'add_new',
				'.more-options ul.items-per-page li:click': 'per_page',
				'.more-options ul.grid-columns li:click': 'columns',
				'.keyword:keyup': 'keyword',
			},

			type: function (e) {

				mpl.cfg.sectionsType = $(this).val();
				mpl.cfg.sectionsTerm = '';

				e.data.el.find('.category').val('');
				mpl.ui.sections.reload(e);

				/* Update config */
				mpl.backbone.stack.set('MPL_Configs', mpl.cfg);

			},

			category: function (e) {

				mpl.cfg.sectionsTerm = $(this).val();

				mpl.ui.sections.reload(e);

				/* Update config */
				mpl.backbone.stack.set('MPL_Configs', mpl.cfg);

			},

			add_new: function (e) {

				var pop = mpl.get.popup(e.target), full = '',
					content_type = pop.find('.mpl-section-control select.content-type').val();

				if (content_type.indexOf('prebuilt-templates-(') === 0) {
					alert(mpl.__.i71);
					return false;
				}

				if (pop.hasClass('mpl-save-row-to-section')) {

					if (mpl.front !== undefined) {
						full = mpl.front.build_shortcode(pop.data('model'));
					} else {

						/*
						*	Save all content to new
						*/
						if (pop.data('model') == 'all') {

							var exp;

							$('#mpl-container > #mpl-rows > .mpl-row').each(function () {
								exp = mpl.backbone.export($(this).data('model'));
								full += exp.begin + exp.content + exp.end;
							});

							if (full === '') {
								alert('__EMPTY_ERROR');
								return false;
							}

						} else {
							full = mpl.backbone.export(pop.data('model'));
							full = full.begin + full.content + full.end;
						}
					}

					mpl.backbone.stack.set('MPL_RowNewSection', full);
					pop.find('.sl-close').trigger('click');
					window.open($(this).attr('href') + '&mpl_action=content_from_row');

					e.preventDefault();
					return false;

				}

				return true;

			},

			per_page: function (e) {

				$(this).parent().find('.active').removeClass('active');
				$(this).addClass('active');

				mpl.cfg.sectionsPerpage = $(this).data('amount');

				mpl.ui.sections.reload(e);

				/* Update config */
				mpl.backbone.stack.set('MPL_Configs', mpl.cfg);

			},

			columns: function (e) {

				$(this).parent().find('.active').removeClass('active');
				$(this).addClass('active');

				mpl.sections.cols = $(this).data('amount');
				mpl.cfg.sectionsLayout = $(this).data('amount');
				mpl.ui.sections.render(data.pop);

				/* Update config */
				mpl.backbone.stack.set('MPL_Configs', mpl.cfg);

			},

			keyword: function (e) {

				if (e.keyCode === 13) {
					mpl.ui.sections.reload(e);
					e.preventDefault();
					return false;
				}

			},

		});

		mpl.trigger({

			el: wrp.find('.mpl-section-share'),
			events: {
				'.mpl-ss-share-submit:click': 'share',
				'.mpl-ss-share-cancel:click': 'cancel_share',
			},

			share: function (e) { },

			cancel_share: function (e) {
				$(this).closest('.mpl-section-share').hide();
				e.preventDefault();
				return false;
			}


		});

		wrp.on('click', function (e) {
			switch ($(e.target).data('action')) {

				case 'link': mpl.do_action('mpl-link-section', e); break;
				case 'clone': mpl.do_action('mpl-clone-section', e); break;

				case 'push': mpl.ui.sections.push(e, false); break;
				case 'overwrite': mpl.ui.sections.push(e, true); break;

				case 'delete': mpl.ui.sections.delete(e); break;
				case 'page': mpl.ui.sections.page(e); break;

				case 'prebuilt': mpl.ui.sections.prebuilt(e); break;
				case 'share': mpl.ui.sections.share(e); break;

			}

		});

		wrp.find('.pages-select select').on('change', function (e) {
			mpl.ui.sections.reload(e, this.value);
		});

		data.pop.find('h3.m-p-header').append(wrp.find('.mpl-section-control'));

		if (data.pop.hasClass('mpl-save-row-to-section')) {
			data.pop.find(".mpl-section-control select.content-type option[value^='prebuilt-templates-']").remove();
		}

	},

	reload: function (e, paged, isdelete) {

		var pop = e.target ? mpl.get.popup(e.target) : e,
			s = pop.find('.mpl-section-control .keyword').val(),
			term = pop.find('.mpl-section-control .category').val(),
			type = pop.find('.mpl-section-control .content-type').val(),
			per_page = pop.find('.mpl-section-control .more-options .items-per-page li.active').data('amount'),
			cols = pop.find('.mpl-section-control .more-options .grid-columns li.active').data('amount');

		if (per_page === undefined && mpl.cfg.sectionsPerpage !== undefined) {
			per_page = mpl.cfg.sectionsPerpage;
		}

		if (cols === undefined && mpl.cfg.sectionsLayout !== undefined) {
			cols = mpl.cfg.sectionsLayout;
		}

		if (term === undefined && mpl.cfg.sectionsTerm !== undefined) {
			term = mpl.cfg.sectionsTerm;
		}

		if (type === undefined && mpl.cfg.sectionsType !== undefined) {
			type = mpl.cfg.sectionsType;
		}

		if (paged === undefined)
			paged = 1;

		pop.find('.m-p-wrap.wp-pointer-content')
			.append('<div class="mpl-popup-loading" style="display:block"><span class="mpl-loader"></span></div>');

		$.ajax({
			url: ajaxurl,
			data: {
				security: mpl_ajax_nonce,
				action: 'mpl_load_sections',
				s: s,
				term: term,
				type: type,
				paged: paged,
				per_page: per_page,
				cols: cols,
				isdelete: isdelete
			},
			pop: pop,
			method: 'POST',
			dataType: 'json',
			success: function (json) {

				this.pop.find('.mpl-popup-loading').remove();

				if (json !== -1 && json != '-1') {

					mpl.sections = json.data;
					mpl.ui.sections.render(this.pop);

					if (json.stt !== 1)
						this.pop.find('.m-p-body').html('<div class="align-center">' + json.message + '</div>');

					this.pop.find('.m-p-body').css({ 'overflow-x': 'hidden' });
					mpl.trigger({
						el: $('.mpl-templates'),
						events: {
							'.mpl-template-import:click': 'import',
							'.mpl-templates-categories li:click': 'categories'
						},
						import: function (e) {

							var template = $(this).data('name'),
								support = $(this).data('rule'),
								title = $(this).parents(".mpl-template-item").find(".cpdes").text();
							if (support !== undefined && support == 'pro')
								mpl.msg(title + ' only available in pro version.<br/><a style="margin-top:20px;" class="button button-primary" href="https://www.mageewp.com/peony-theme.html" target="_blank">Get Peony Pro</a>', 'MPL Pro Support', 'sl-close', 3000);
							else
								$.ajax({
									url: mpl_ajax_url,
									method: 'POST',
									dataType: 'json',
									data: { action: 'mpl_get_template', template: template },
									success: function (response_data) {
										var _$ = mpl._$;
										if (mpl.front && response_data.fonts !== undefined) {
											mpl_fonts = JSON.parse(response_data.fonts);
										}
										if (mpl.front && response_data.html !== undefined) {
											var start = mpl.front.id + 1;
											//console.log(response_data.html);
											var import_template = _$(response_data.html);
											var style_pos = 0;
											for (var i = 0; i < import_template.length; i++) {
												if (import_template[i].tagName == 'STYLE') {
													var new_css_content = _$(import_template[i]).html();
													var css_content = _$('#mpl-css-render').html();
													_$('#mpl-css-render').html(css_content + new_css_content);
													style_pos = i;
												}
												else {
													var cls_arr = _$(import_template[i]).attr('class');
													if (cls_arr) {
														if (cls_arr.indexOf('mpl-elm') > -1) {
															_$(import_template[i]).attr('data-front-model', start++);
														}
														else {
															_$(import_template[i]).find('.mpl-elm').attr('data-front-model', start++);
														}
													}
												}
											}
											import_template.splice(style_pos, 1);
											_$(".mpl-content-wrap").append(import_template);
											//mpl_front.init($);
											$('#mpl-live-frame').get(0).contentWindow.mpl_front.init(_$);
											mpl.front.addToolsListener();
										}
										$('.save-post-settings').trigger('click');
										mpl.backbone.push(response_data.content);
										$('.mpl-params-popup').remove();
										_$('html').css({ 'overflow': 'scroll' });
									}
								});
						},
						categories: function (e) {
							var category = $(this).data('category');
							$(this).parent().find('.active').removeClass('active');
							$(this).addClass('active');
							if (category === 'all') {
								$('.mpl-templates>.mpl-templates-list').find('li[data-category]').show();
							}
							else {
								$('.mpl-templates>.mpl-templates-list').find('li[data-category]').hide();
								$('.mpl-templates>.mpl-templates-list').find('li[data-category="' + category + '"]').show();
							}
						}

					});
				} else {
					mpl.msg(mpl.__.security, 'error', 'sl-close');
				}

			}
		});

	},

	link: function (e) {

		var id = $(e.target).closest('.mpl-sections-item').data('id');
		title = $(e.target).closest('.mpl-sections-item').data('title'),
			pop = mpl.get.popup(e.target),
			model = pop.data('model');

		if (window.mpl_post_id !== undefined && window.mpl_post_ID == id) {
			mpl.msg(mpl.__.i62, 'error', 'sl-close', 5000);
			return;
		}

		pop.find('button.cancel').trigger('click');

		if (model !== undefined && model !== null) {

			var row = $('#mpl-rows #model-' + model);

			mpl.storage[model].args.__section_link = id;
			mpl.storage[model].args.__section_title = title;

			var new_row = mpl.views.row.render(mpl.storage[model]);

			row.after(new_row).remove();

			mpl.ui.scrollAssistive(new_row);

		} else mpl.backbone.push('[mpl_row __section_link="' + id + '" __section_title="' + title + '"][/mpl_row]');

	},

	clone: function (e) {

		var id = $(e.target).closest('.mpl-sections-item').data('id');

		mpl.get.popup(e.target, 'close').trigger('click');

		mpl.msg(mpl.__.processing, 'loading');

		$.ajax({
			url: ajaxurl,
			data: {
				security: mpl_ajax_nonce,
				action: 'mpl_load_section',
				id: id
			},
			method: 'POST',
			dataType: 'json',
			success: function (json) {

				if (json !== -1 && json != '-1') {
					if (json.stt === 1) {
						mpl.backbone.push(json.data);
						$('#mpl-preload').remove();
					} else {
						mpl.msg(json.message, 'error', 'sl-close');
					}

				} else {
					mpl.msg(mpl.__.security, 'error', 'sl-close');
				}
			}
		});
	},

	push: function (e, overwrite) {

		var pop = mpl.get.popup(e.target),
			model = pop.data('model'),
			id = $(e.target).closest('.mpl-sections-item').data('id'),
			full = '';


		if (mpl.front !== undefined) {
			full = mpl.front.build_shortcode(model);
		} else {

			if (model == 'all') {

				var exp;

				$('#mpl-container > #mpl-rows > .mpl-row').each(function () {
					exp = mpl.backbone.export($(this).data('model'));
					full += exp.begin + exp.content + exp.end;
				});

				if (full === '') {
					alert('__EMPTY_ERROR');
					return false;
				}

			} else {
				full = mpl.backbone.export(model);
				full = full.begin + full.content + full.end;
			}
		}

		mpl.get.popup(e.target, 'close').trigger('click');

		mpl.msg(mpl.__.processing, 'loading');

		$.ajax({
			url: ajaxurl,
			data: {
				security: mpl_ajax_nonce,
				action: 'mpl_push_section',
				content: full,
				id: id,
				overwrite: (overwrite) ? 'true' : 'false'
			},
			method: 'POST',
			dataType: 'json',
			success: function (json) {

				if (json !== -1 && json != '-1') {
					if (json.stt === 1) {
						mpl.msg(json.message, 'success', 'sl-check');
					} else {
						mpl.msg(json.message, 'error', 'sl-close');
					}

				} else {
					mpl.msg(mpl.__.security, 'error', 'sl-close');
				}

			}
		});


	},

	delete: function (e) {

		if (confirm(mpl.__.sure)) {

			var id = $(e.target).closest('.mpl-sections-item').data('id');

			this.reload(e, 1, id);

		}

		e.preventDefault();
		return false;
	},

	page: function (e) {

		var el = $(e.target),
			paged = el.html(),
			active = el.closest('.mpl-section-pagination').find('.active');

		if (el.data('page') == 'next') {

			if (active.next().data('page') != 'next')
				mpl.ui.sections.reload(e, active.next().html());

		} else if (el.data('page') == 'prev') {

			if (active.prev().data('page') != 'prev')
				mpl.ui.sections.reload(e, active.prev().html());

		} else if (!el.hasClass('active')) {

			mpl.ui.sections.reload(e, el.html());

		}

	},

	prebuilt: function (e) {

		var id = $(e.target).closest('.mpl-sections-item').data('id'),
			pack = $(e.target).closest('.mpl-params-popup').find('.mpl-section-control select.category').val();

		mpl.get.popup(e.target, 'close').trigger('click');

		mpl.msg(mpl.__.processing, 'loading');

		$.ajax({
			url: ajaxurl,
			data: {
				security: mpl_ajax_nonce,
				action: 'mpl_load_section',
				id: id,
				xml_pack: pack,
			},
			method: 'POST',
			dataType: 'json',
			success: function (json) {

				if (json !== -1 && json != '-1') {
					if (json.stt === 1) {

						mpl.backbone.push(json.data);

						if (typeof json.meta == 'object') {
							for (var n in json.meta) {
								if (json.meta[n] !== '' && $('#mpl-page-cfg-' + n).length > 0) {
									$('#mpl-page-cfg-' + n).val(json.meta[n]);
								}
							}
						}

						$('#mpl-preload').remove();

					} else {
						mpl.msg(json.message, 'error', 'sl-close');
					}

				} else {
					mpl.msg(mpl.__.security, 'error', 'sl-close');
				}
			}
		});
	},

	share: function (e) {

		var id = $(e.target).closest('.mpl-sections-item').data('id'),
			label = $(e.target).closest('.mpl-section-info').find('>span').html(),
			thumbn = $(e.target).closest('.mpl-sections-item').find('>.mpl-section-sceenshot img').attr('src'),
			sswrp = $(e.target).closest('#mpl-sections').find('.mpl-section-share');

		$(e.target).closest('.m-p-body').scrollTop('1px');

		sswrp.show().find('.mpl-ss-section span').html(label);
		sswrp.find('.mpl-ss-thumbnail').html('<img src="' + thumbn + '" />');
		sswrp.data({ id: id, label: label });

		sswrp.find('.mpl-ss-name input,.mpl-ss-email input').val('').first().focus();

		if ($('#mpl-sections').height() < 550)
			$('#mpl-sections').height('550px');

		e.preventDefault();
		return false;
	}

},
}, window.mpl.ui);

window.mpl.ui = $.extend({

sortInit: function () {

	setTimeout(function () {

		/*Sort elements*/
		mpl.ui.sortable({

			items: '.mpl-element.mpl-model,.mpl-views-sections.mpl-model,.mpl-row-inner.mpl-model,.mpl-element.drag-helper',
			connecting: true,
			handle: '>ul>li.move',
			helper: ['mpl-ui-handle-image', 25, 25],
			detectEdge: 80,

			start: function (e, el) {

				$('#mpl-undo-deleted-element').addClass('drop-to-delete');

				var elm = $(el), relate = { parent: elm.parent().get(0) };

				if (elm.next().hasClass('mpl-model'))
					relate.next = elm.next().get(0);
				if (elm.prev().hasClass('mpl-model'))
					relate.prev = elm.prev().get(0);

				elm.data({ relate2: relate });

			},

			end: function () {
				$('#mpl-undo-deleted-element').removeClass('drop-to-delete');
			}

		});

		/*Trigger even drop to delete element*/
		if (document.getElementById('drop-to-delete').droppable !== true) {

			var dtd = document.getElementById('drop-to-delete');

			dtd.setAttribute('droppable', 'true');
			dtd.setAttribute('draggable', 'true');

			var args = {

				dragover: function (e) {
					e.dataTransfer.dropEffect = 'copy';
					this.className = 'over';
					e.preventDefault();
					return false;
				},

				dragleave: function (e) {
					e.preventDefault();
					this.className = '';
					return false;
				},

				drop: function (e) {

					this.className = '';
					$('#mpl-undo-deleted-element').removeClass('drop-to-delete');

					if (mpl.ui.elm_drag !== null) {

						var atts = $(mpl.ui.elm_drag).data('atts');

						$(mpl.ui.elm_drag)
							.removeClass(atts.placeholder)
							.find('li.delete')
							.first()
							.trigger('click');

						$(mpl.ui.elm_drag).data({ relate: $(mpl.ui.elm_drag).data('relate2') });

						e.preventDefault();

					}
				}

			};

			for (var ev in args) {
				dtd.addEventListener(ev, args[ev], false);
			}
		}

		/*Sort Rows*/
		mpl.ui.sortable({

			items: '#mpl-rows>.mpl-row',
			vertical: true,
			connecting: false,
			handle: '>ul>li.move',
			helper: ['mpl-ui-handle-image', 25, 25],

			start: function () {
				$('#mpl-rows').addClass('sorting');
			},

			end: function () {
				$('#mpl-rows').removeClass('sorting');
			}

		});

		/*Sort Columns*/
		mpl.ui.sortable({

			items: '.mpl-column,.mpl-column-inner',
			vertical: false,
			connecting: false,
			handle: '>.mpl-column-control',
			helper: ['mpl-ui-handle-image', 25, 25],
			detectEdge: 'auto',
			start: function (e, el) {
				$(el).parent().addClass('mpl-sorting');
			},

			end: function (e, el) {
				$(el).parent().removeClass('mpl-sorting');
			}
		});

	}, 100);

},

sortable_events: {

	mousedown: function (e) {

		if (window.chrome !== undefined || this.draggable === true)
			return;

		var atts = $(this).data('atts'), handle;
		if (atts.handle !== undefined && atts.handle !== '') {
			handle = $(this).find(atts.handle);
			if (handle.length > 0) {
				if (e.target == handle.get(0) || $.contains(handle.get(0), e.target)) {
					this.draggable = true;
					mpl.ui.sortable_events.dragstart(e);
				}
			}
		}

	},

	dragstart: function (e) {

		/**
		*	We will get the start element from mousedown of mouses
		*/

		if (mpl.ui.elm_start === null) {
			e.preventDefault();
			return false;
		}

		mpl.ui.over_delay = true;

		var atts = $(this).data('atts'), handle, okGo = false;

		if (atts.handle !== '' && atts.handle !== undefined) {

			handle = $(this).find(atts.handle);

			if (handle.length > 0) {
				if (mpl.ui.elm_start == handle.get(0) || $.contains(handle.get(0), mpl.ui.elm_start))
					okGo = true; else okGo = false;

			} else okGo = false;

		} else okGo = true;

		if (okGo === true) {

			$('body').addClass('mpl-ui-dragging');

			/* Disable prevent scroll -> able to roll mouse when drag */
			if ($(this).closest('.mpl-prevent-scroll').length > 0) {
				$(this).closest('.mpl-prevent-scroll').off('mousewheel DOMMouseScroll');
			}

			if (atts.helperClass !== '') {
				if ($(mpl.ui.elm_start).closest(atts.items).get(0) == this) {
					$(mpl.ui.elm_start).closest(atts.items).addClass(atts.helperClass);
				}
			}

			mpl.ui.elm_drag = this;
			var prevElm = $(this).prev();
			var nextElm = $(this).next();
			if (prevElm) {
				mpl.ui.elm_prev = prevElm;
			}
			if (nextElm) {
				mpl.ui.elm_next = nextElm;
			}
			/*e.dataTransfer.effectAllowed = 'none';
			e.dataTransfer.dropEffect = 'none';
			e.dataTransfer.endEffect = 'none';*/
			if (e.dataTransfer !== undefined && typeof e.dataTransfer.setData == 'function')
				e.dataTransfer.setData('text/plain', '');

			if (typeof atts.helper == 'object'
				&& e.dataTransfer !== undefined
				&& typeof e.dataTransfer.setDragImage == 'function') {
				e.dataTransfer.setDragImage(
					document.getElementById(atts.helper[0]),
					atts.helper[1],
					atts.helper[2]
				);
			}

			if (typeof atts.start == 'function')
				atts.start(e, this);

		}
		else {

			var check = mpl.ui.elm_start;
			while (check.draggable !== true && check.tagName != 'BODY') {
				check = check.parentNode;
			}

			if (check == this) {

				e.preventDefault();
				return false;

			}

		}

	},

	dragover: function (e) {

		var u = mpl.ui;

		if (u.elm_drag === null) {

			e.preventDefault();
			return false;

		}

		if (u.over_delay === false) {

			if (u.over_timer === null)
				u.over_timer = setTimeout(function () { mpl.ui.over_delay = true; mpl.ui.over_timer = null; }, 50);

			return false;

		} else u.over_delay = false;

		u.elm_over = this;

		var oatts = $(this).data('atts'), atts = $(u.elm_drag).data('atts');

		if (!e) e = window.event;

		if (this == u.elm_drag || $.contains(u.elm_drag, this) || oatts.items != atts.items) {

			// prevent actions when hover it self or hover its children
			e.preventDefault();
			return false;

		} else {

			var rect = this.getBoundingClientRect();

			if (atts.connecting === false && this.parentNode != u.elm_drag.parentNode) {
				e.preventDefault();
				return false;
			}

			var detectEdge = atts.detectEdge;

			if (atts.vertical === true) {

				if (detectEdge === undefined || detectEdge == 'auto' || detectEdge > (rect.height / 2))
					detectEdge = (rect.height / 2);

				if ((rect.bottom - e.clientY) < detectEdge) {

					if (this.nextElementSibling != u.elm_drag) {
						$(this).after(u.elm_drag);
						if (atts.preventFlicker !== false)
							mpl.ui.preventFlicker(e, u.elm_drag);

					}

					if (typeof atts.over == 'function')
						atts.over(e, this);

				} else if ((e.clientY - rect.top) < detectEdge) {

					if (this.previousElementSibling != u.elm_drag) {
						$(this).before(u.elm_drag);
						if (atts.preventFlicker !== false)
							mpl.ui.preventFlicker(e, u.elm_drag);
					}

					if (typeof atts.over == 'function')
						atts.over(e, this);

				}

			} else {

				if (detectEdge === undefined || detectEdge == 'auto' || detectEdge > (rect.width / 2))
					detectEdge = (rect.width / 2);

				if ((rect.right - e.clientX) < detectEdge) {

					if (this.nextElementSibling != u.elm_drag) {
						$(this).after(u.elm_drag);
					}


					if (typeof atts.over == 'function')
						atts.over(e, this);

				} else if ((e.clientX - rect.left) < detectEdge) {

					if (this.previousElementSibling != u.elm_drag) {
						$(this).before(u.elm_drag);
					}

					if (typeof atts.over == 'function')
						atts.over(e, this);

				}

			}

		}

		e.preventDefault();
		return false;

	},

	drag: function (e) {

		var atts = $(this).data('atts'),
			h = atts.helperClass,
			p = atts.placeholder,
			el = mpl.ui.elm_drag;

		if (h !== '' && el !== null) {

			if (el.className.indexOf(h) > -1) {

				$(el).removeClass(h);

				if (p !== '')
					$(el).addClass(p);
			}
		}

		if (typeof atts.drag == 'function')
			atts.drag(e, this);

		e.preventDefault();
		return false;

	},

	dragleave: function (e) {
		var atts = $(this).data('atts');
		if (typeof atts.leave == 'function')
			atts.leave(e, this);

		e.preventDefault();
		return false;
	},

	dragend: function (e) {

		var atts = $(this).data('atts');

		$(this).removeClass(atts.helperClass);
		$(this).removeClass(atts.placeholder);


		mpl.ui.elm_drag = null;
		mpl.ui.elm_over = null;
		mpl.ui.elm_start = null;


		mpl.ui.key_down = false;

		$('body').removeClass('mpl-ui-dragging');


		if (typeof atts.end == 'function')
			atts.end(e, this);

		e.preventDefault();
		return false;

	},

	drop: function (e) {

		var atts = $(this).data('atts');

		if (typeof atts.drop == 'function')
			atts.drop(e, this);

		e.preventDefault();
		return false;

	}


},

/*
*
* (c) copyright by king-theme.com
*
*/

sortable: function (atts) {


	atts = $().extend({

		items: '',
		handle: '',
		helper: '',
		helperClass: 'mpl-ui-helper',
		placeholder: 'mpl-ui-placeholder',
		vertical: true,
		connecting: false,
		detectEdge: 50,
		preventFlicker: false,

	}, atts);

	if (atts.items === '')
		return;


	var elms = document.querySelectorAll(atts.items);

	[].forEach.call(elms, function (el) {

		if (el.draggable !== true) {

			el.setAttribute('droppable', 'true');
			el.setAttribute('draggable', 'true');

			$(el).data({ atts: atts });

			for (var ev in mpl.ui.sortable_events)
				el.addEventListener(ev, mpl.ui.sortable_events[ev], false);

		}

	});

},

draggable: function (el, handle) {

	if (el === undefined)
		return;

	var args = {

		mousedown: function (e) {

			if (e.which !== undefined && e.which !== 1)
				return false;

			if (e.target.getAttribute('data-prevent-drag') == 'true')
				return false;

			if (this.handle !== '' && this.handle !== undefined) {
				if (e.target != $(this).find(this.handle).get(0) && $(e.target).closest(this.handle).length === 0) {
					return false;
				}
			}

			if (e.target.tagName == 'INPUT')
				return false;

			$('html,body').addClass('mpl_dragging noneuser');

			mpl.do_action('mpl-draggable-start', this, e);

			var rect = this.getBoundingClientRect(),
				scroll = mpl.ui.scroll(),
				left = rect.left,
				top = rect.top,
				style = window.getComputedStyle(this);

			this.pos = [e.clientY - rect.top, e.clientX - rect.left];
			this.position = style.getPropertyValue('position');
			this.transform = style.getPropertyValue('transform');

			if (typeof this.transform == 'string' && this.transform.indexOf('matrix') === 0) {
				this.transform = this.transform.replace('matrix(', '').replace(')', '').replace(/\ /g, '').split(',');

				if (this.transform[4] !== undefined) {
					left -= parseFloat(this.transform[4]);
					this.pos[1] += parseFloat(this.transform[4]);
				}
				if (this.transform[5] !== undefined) {
					top -= parseFloat(this.transform[5]);
					this.pos[0] += parseFloat(this.transform[5]);
				}
			}

			if (this.position != 'fixed') {
				left += scroll.left;
				top += scroll.top - mpl.html.offsetTop;
			}


			$(this).css({ position: this.position != 'fixed' ? 'absolute' : 'fixed', top: top + 'px', left: left + 'px' });

			$(document).off('mousemove').on('mousemove', this, function (e) {

				var scroll = mpl.ui.scroll(),
					left = e.clientX,
					top = e.clientY;

				if (e.data.position != 'fixed') {
					left += scroll.left;
					top += scroll.top - mpl.html.offsetTop;
				}

				if (top < e.data.pos[0])
					top = e.data.pos[0];

				e.data.style.top = (top - e.data.pos[0]) + 'px';
				e.data.style.left = (left - e.data.pos[1]) + 'px';

				mpl.do_action('mpl-draggable-move', e);

			});

			$(window).off('mouseup').on('mouseup', this, function (e) {

				$(document).off('mousemove');
				$(window).off('mouseup');
				$('html,body').removeClass('mpl_dragging noneuser');

				mpl.do_action('mpl-draggable-end', e);

			});

		}

	};

	if (el.kcdraggable !== true) {

		el.kcdraggable = true;
		el.handle = handle;
		for (var ev in args) {
			el.addEventListener(ev, args[ev], false);
		}
	}

},

preventFlicker: function (e, el) {

	if (el === undefined)
		return;

	var rect = el.getBoundingClientRect(), st = 0;

	if (e.clientY < rect.top) {
		st = (rect.top - e.clientY) + (rect.height / 10);
	} else if (e.clientY > (rect.top + rect.height)) {
		st = -((e.clientY - (rect.top + rect.height)) + (rect.height / 10));
	}

	if (st !== 0) {
		mpl.body.scrollTop += st;
		mpl.html.scrollTop += st;
	}

},

mouses: {

	load: function () {

		if ($('#mpl-container').length > 0) {
			$('#mpl-container')
				.off('mousedown')
				.on('mousedown', this.down)
				.get(0).oncontextmenu = function (e) {
					if ($(e.target).closest('.mpl-model').length == 0 && $(e.target).closest('.mpl-right-click-dialog').length == 0)
						return true;
					return false;
				};
		}

	},

	down: function (e) {


		if (e.button == 2) {
			//setTimeout(mpl.ui.right_click, 10, e);
			//return false; 
		}

		if (e.which !== undefined && e.which !== 1)
			return false;

		$('.mpl-params-popup:not(.preventCancel) .m-p-header .sl-close').trigger('click');

		$('html,body').stop();

		if (e.target.className.indexOf('mpl-add-elements-inner') > -1) {
			mpl.backbone.add(e.target);
			e.preventDefault();
			return false;
		}

		if (e.target.className.indexOf('column-resize') == -1) {
			return;
		}

		var ge = mpl.ui.mouses, el = $(e.target).parent();

		$(document).on('mouseup', ge.up);
		$(document).on('mousemove', {
			el: el,
			pel: el.prev(),
			nel: el.next(),
			emodel: el.data('model'),
			nmodel: el.next().data('model'),
			pmodel: el.prev().data('model'),

			einfo: el.find('>.mpl-cols-info'),
			ninfo: el.next().find('>.mpl-cols-info'),
			pinfo: el.prev().find('>.mpl-cols-info'),

			left: e.clientX,
			width: parseFloat(e.target.parentNode.style.width),
			nwidth: parseFloat($(e.target.parentNode).next().get(0) ? $(e.target.parentNode).next().get(0).style.width : 0),
			pwidth: parseFloat($(e.target.parentNode).prev().get(0) ? $(e.target.parentNode).prev().get(0).style.width : 0),
			direct: $(e.target).hasClass('cr-left'),
			offset: 1
		}, ge.move);

		$('body').addClass('mpl-column-resizing').css({ cursor: 'col-resize' });

		$(window).off('mouseup').on('mouseup', function () {
			$(document).off('mousemove');
			$(window).off('mouseup');
			$('html,body').removeClass('mpl_dragging noneuser');
		});

	},

	up: function (e) {

		$(document).off('mousemove').off('mouseup');
		$('body').removeClass('mpl-column-resizing').css({ cursor: '' });
	},

	move: function (e) {
		e.preventDefault();
		e.data.offset = e.clientX - e.data.left;

		var d = e.data,
			ratio = parseFloat(d.el.get(0).style.width) / d.el.get(0).offsetWidth,
			p1 = (d.width - (d.offset * ratio)),
			p2 = d.pwidth + (d.offset * ratio),
			p3 = (d.width + (d.offset * ratio)),
			p4 = d.nwidth - (d.offset * ratio);

		if (d.direct) {
			// on  right
			if (p1 > 9 && p2 > 9) {
				// update width of cols
				d.el.width(p1 + '%');
				d.pel.width(p2 + '%');
				// update info 
				d.einfo.html(Math.round(p1) + '%');
				d.pinfo.html(Math.round(p2) + '%');

				mpl.storage[d.emodel].args.width = mpl.tools.nfloat(p1) + '%';
				mpl.storage[d.pmodel].args.width = mpl.tools.nfloat(p2) + '%';

			}

		} else {
			// on left
			if (p3 > 9 && p4 > 9) {

				d.el.width(p3 + '%');
				d.nel.width(p4 + '%');

				d.einfo.html(Math.round(p3) + '%');
				d.ninfo.html(Math.round(p4) + '%');

				mpl.storage[d.emodel].args.width = mpl.tools.nfloat(p3) + '%';
				mpl.storage[d.nmodel].args.width = mpl.tools.nfloat(p4) + '%';
			}
		}
	},
},
}, window.mpl.ui);
window.mpl.ui = $.extend({
callbacks: {

	upload_image: function (el, $) {
		el.find('.media').on('click', {
			callback: function (atts) {

				var wrp = $(this.el).closest('.mpl-attach-field-wrp'), 
					url = atts.url;

				wrp.find('input.mpl-param').val(atts.id).change();
				if (typeof atts.sizes.medium == 'object')
					url = atts.sizes.medium.url;

				if (!wrp.find('img').get(0)) {
					wrp.prepend('<div class="img-wrp"><img src="' + url + '" alt="" /><i title="' + mpl.__.i50 + '" class="sl-close"></i></div>');
					wrp.find('img').on('click', el, function (e) {
						el.find('.media').trigger('click');
					});
					wrp.find('div.img-wrp .sl-close').on('click', el, function (e) {
						e.data.find('input.mpl-param').val('').change();
						$(this).closest('div.img-wrp').remove();
					});
				} else wrp.find('img').attr({ src: url });

			}, atts: { frame: 'select' }
		}, mpl.tools.media.open);

		el.find('div.img-wrp .sl-close').on('click', el, function (e) {
			e.data.find('input.mpl-param').val('').change();
			$(this).closest('div.img-wrp').remove();
		});

		el.find('div.img-wrp img').on('click', el, function (e) {
			el.find('.media').trigger('click');
		});

	},

	upload_image_url: function (el, $) {

		el.find('.media').on('click', {
			callback: function (atts) {

				var wrp = $(this.el).closest('.mpl-attach-field-wrp'), 
					url = atts.url;

				if (atts.size !== undefined && atts.size !== null && atts.sizes[atts.size] !== undefined) {
					url = atts.sizes[atts.size].url;
				} else if (typeof atts.sizes.medium == 'object') {
					url = atts.sizes.medium.url;
				}

				if (url !== undefined && url !== '') {
					wrp.find('input[data-mpl-param]').val(url).change();
				}

				if (!wrp.find('img').get(0)) {
					wrp.prepend('<div class="img-wrp"><img src="' + url + '" alt="" /><i title="' + mpl.__.i50 + '" class="sl-close"></i><div class="img-sizes"></div></div>');
					el.find('div.img-wrp img').on('click', el, function (e) {
						el.find('.media').trigger('click');
					});
					el.find('div.img-wrp .sl-close').on('click', el, function (e) {
						$(this).closest('div.img-wrp').remove();
						e.data.find('input[data-mpl-param]').val('').change();
					});
				} else {
					wrp.find('img').attr({ src: url });
					wrp.find('.img-sizes').html('');
				}

				var btn, wrpsizes = wrp.find('.img-sizes');
				for (var si in atts.sizes) {
					btn = $('<button data-url="' + atts.sizes[si].url +
						'" class="button">' + atts.sizes[si].width + 'x' +
						atts.sizes[si].height + '</button>');

					if (atts.size !== undefined && atts.size) {

						if (atts.size == si)
							btn.addClass('button-primary');

					} else if (si == 'medium') {
						btn.addClass('button-primary');
					}

					btn.on('click', function (e) {

						var wrp = $(this).closest('.mpl-attach-field-wrp'), url = $(this).data('url');

						$(this).parent().find('button').removeClass('button-primary');
						$(this).addClass('button-primary');

						wrp.find('img').attr({ src: url });
						wrp.find('input[data-mpl-param]').val(url).change();

						e.preventDefault();
						return false;
					});
					wrpsizes.append(btn);
				}

			}, atts: { frame: 'post' }
		}, mpl.tools.media.open);

		el.find('div.img-wrp .sl-close').on('click', el, function (e) {
			$(this).closest('div.img-wrp').remove();
			e.data.find('input[data-mpl-param]').val('').change();
		});

		el.find('div.img-wrp img').on('click', el, function (e) {
			el.find('.media').trigger('click');
		});

	},

	upload_images: function (el) {

		el.find('.media').on('click', function (atts) {

			var wrp = jQuery(this.els).closest('.mpl-attach-field-wrp'), url = atts.url;

			//wrp.find('input.mpl-param').val(atts.id).change();
			if (typeof atts.sizes.thumbnail == 'object')
				url = atts.sizes.thumbnail.url;

			wrp.prepend('<div data-id="' + atts.id + '" class="img-wrp"><img title="Drag image to sort" src="' + url + '" alt="" /><i title="' + mpl.__.i50 + '" class="sl-close"></i></div>');
			helper(wrp);

		}, mpl.tools.media.opens);

		function helper(el) {

			mpl.ui.sortable({

				items: 'div.mpl-attach-field-wrp>div.img-wrp',
				helper: ['mpl-ui-handle-image', 25, 25],
				connecting: false,
				vertical: false,
				end: function (e, el) {
					refresh(jQuery(el).closest('.mpl-attach-field-wrp'));
				}

			});


			el.find('div.img-wrp i.sl-close').off('click').on('click', el, function (e) {
				jQuery(this).closest('div.img-wrp').remove();
				refresh(e.data);
			});

			refresh(el);

		}

		function refresh(el) {
			var val = [];
			el.find('div.img-wrp').each(function () {
				val[val.length] = jQuery(this).data('id');
			});
			if (val.length <= 4) {
				el.removeClass('img-wrp-medium').removeClass('img-wrp-large');
			} else if (val.length > 4 && val.length < 9) {
				el.addClass('img-wrp-medium').removeClass('img-wrp-large');
			} else if (val.length >= 9) {
				el.removeClass('img-wrp-medium').addClass('img-wrp-large');
			}

			el.find('input.mpl-param').val(val.join(',')).change();

			el.find('div.img-wrp img').on('click', el, function (e) {
				el.find('.media').trigger('click');
			});
		}

		helper(el.find('.mpl-attach-field-wrp'));

	},

	select_group: function (el, $) {

		el.find('button').on('click', el, function (e) {

			e.data.find('input').val(this.getAttribute('data-value')).trigger('change');
			e.data.find('button.active').removeClass('active');
			$(this).addClass('active');

			e.preventDefault();
			return false;

		});
	},

	number: function (el, $) {

		el.find('input[type=number]').on('mousedown', function (e) {

			if (e.which !== undefined && e.which !== 1)
				return false;

			$(document).on('mouseup', function () {
				$(document).off('mousemove').off('mouseup');
				$('body').removeClass('noneuser').css({ cursor: '' });
			});

			$(document).on('mousemove', {
				el: this,
				cur: parseInt(this.value !== '' ? this.value : 0, 10),
				top: e.clientY
			}, function (e) {
				var offset = Math.round((e.clientY - e.data.top) / 2);
				e.data.el.value = (e.data.cur - offset);
				$(e.data.el).trigger('change');
			});

			$('body').css({ cursor: 'ns-resize' });

			$(window).off('mouseup').on('mouseup', function () {
				$(document).off('mousemove');
				$(window).off('mouseup');
				$('html,body').removeClass('mpl_dragging noneuser');
			});

		}).on('change', function () {

			var unit = $(this).parent().find('li.active').html(),
				val = this.value;

			if (val !== '')
				val += unit;

			$(this).parent().find('input[type=hidden]').val(val).trigger('change');

		});

		el.find('ul li').on('click', function () {

			$(this).parent().find('.active').removeClass('active');
			$(this).addClass('active');
			var inp = $(this).closest('.m-p-r-content').find('input[type=hidden]'),
				val = inp.val().replace(/[^0-9\.]/g, '');

			if (val !== '')
				val += this.innerHTML;

			inp.val(val).trigger('change');

		});

	},

	number_slider: function (el, $, data) {

		var el_slider = el.find('.mpl_percent_slider'),
			values = data.value.toString().split('|'),
			options = {
				range: (typeof data.options['range'] == 'undefined') ? false : data.options['range'],
				unit: (typeof data.options['unit'] == 'undefined') ? '' : data.options['unit'],
				ratio: (typeof data.options['ratio'] == 'undefined') ? 1 : parseFloat(data.options['ratio']),
				min: (typeof data.options['min'] == 'undefined') ? 0 : parseFloat(data.options['min']),
				max: (typeof data.options['max'] == 'undefined') ? 100 : parseFloat(data.options['max']),
				enabled: (typeof data.options['max'] == 'enabled') ? true : data.options['enabled'],
				step: 1
			},
			mpl_number_slider = function (el, set_val) {

				var op = el.data('options');
				op.onchange = function (left, right) {

					if (op.range === true)
						el.next('input')
							.val((mpl.tools.nfloat(left * op.ratio) + op.unit) + '|' + (mpl.tools.nfloat(right * op.ratio) + op.unit))
							.trigger('change', 'globe');
					else el.next('input')
						.val(mpl.tools.nfloat(left * op.ratio) + op.unit)
						.trigger('change', 'globe');

					el.find('.fscaret').text('');
				};

				if (isNaN(set_val)) {
					op.value = parseFloat(op['max']);
				} else {
					if (set_val.length === 1)
						op.value = parseFloat(set_val[0]) / op.ratio;
					else op.value = [parseFloat(set_val[0]) / op.ratio, parseFloat(set_val[1]) / op.ratio];
				}

				el.off('mouseup').on('mouseup', function () {
					$(this).next('input').change();
				}).freshslider(op);

			};

		el_slider.data({ options: options });

		for (var i in values) {
			values[i] = parseFloat(values[i]);
		}

		mpl_number_slider(el_slider, values);

		el_slider.next('input').on('change', { el: el, el_slider: el_slider, data: data },

			function (e, data) {

				// This is not native event
				if (data !== undefined && data == 'globe')
					return;

				var _value = $(this).val(),
					op = e.data.el_slider.data('options');

				if (/^\d+$/.test(_value) && _value !== '') {

					if (this.value !== _value)
						$(this).val(parseInt(_value, 10));

					if (_value / op.ratio > op['max'])
						_value = op['max'] * op.ratio;

					_value = _value.toString().split('|');
					for (var i in _value) {
						_value[i] = parseInt(_value[i], 10) / op.ratio;
					}

					mpl_number_slider(e.data.el_slider, _value);

				} else {
					e.data.el_slider.next('input').val('');
				}

			}

		);

		el_slider.next('input').val(data.value).trigger('change', 'globe');

	},

	autocomplete: function (wrp, $, data) {

		function render(data, wrp) {

			var out = '', post_type = 'any', category = '', category_name = '', numberposts = 120, taxonomy = '', multiple = true;

			if (data.options !== undefined) {
				if (data.options.post_type !== undefined)
					post_type = data.options.post_type;
				if (data.options.category !== undefined)
					category = data.options.category;
				if (data.options.category_name !== undefined)
					category_name = data.options.category_name;
				if (data.options.taxonomy !== undefined)
					taxonomy = data.options.taxonomy;
				if (data.options.multiple !== undefined)
					multiple = data.options.multiple;
			}

			if (data.value !== '') {
				var items = data.value.split(','), item, id;
				for (var i = 0; i < items.length; i++) {
					item = items[i].split(':');
					id = item[0];
					if (item[1] !== undefined)
						item = item[1];
					else item = '';
					out += '<li data-id="' + id + '"><span>' + mpl.tools.esc_attr(item) + '</span><i class="sl-close mpl-ac-remove" title="Remove item"></i></li>';
				}
			}

			wrp.find('ul.autcp-items').html(out);
			helper(wrp.find('.mpl_autocomplete_wrp'));

			wrp.find('.mpl-autp-enter').on('focus', function () {
				$(this.parentNode).find('.mpl-autp-suggestion').show();
			}).on('blur', function () {
				setTimeout(function (el) {
					el.hide();
				}, 200, $(this.parentNode).find('.mpl-autp-suggestion'));
			}).on('keyup', function () {

				if (this.value === '')
					return;

				if ($(this.parentNode).find('.mpl-autp-suggestion .fa-spinner').length === 0) {
					$(this.parentNode).find('.mpl-autp-suggestion ul').prepend('<li class="sg-loading mpl-free-scroll"><i class="fa fa-spinner fa-spin"></i> searching...</li>');
				}
				clearTimeout(this.timer);
				this.session = Math.random();
				this.timer = setTimeout(function (el) {

					$.post(

						mpl_ajax_url,

						{
							'action': 'mpl_suggestion',
							'security': mpl_ajax_nonce,
							'post_type': post_type,
							'category': category,
							'category_name': category_name,
							'numberposts': numberposts,
							'taxonomy': taxonomy,
							's': el.value,
							'field_name': data.name,
							'session': el.session,
						},

						function (result) {

							$(el.parentNode).find('.sg-loading').remove();

							if (el.session == result.__session) {

								var ex = [],
									out = [],
									item;

								for (var n in result) {
									if (n !== '__session') {
										if (ex.indexOf(n) === -1) {
											ex.push(n);
											out.push('<li class="label mpl-free-scroll">' + n + '</li>');
										}
										for (var m in result[n]) {
											item = result[n][m].split(':');
											out.push('<li class="mpl-free-scroll" ' +
													'data-multiple="' + multiple + '"' + 
													'data-value="' + mpl.tools.esc_attr(result[n][m]) + '">' + item[1] + '</li>');
										}
									}
								}

								if (out.length === 0)
									out.push('<li>Nothing found</li>');

								$(el.parentNode).find('.mpl-autp-suggestion ul')
									.html(out.join('')).find('li')
									.on('click', function () {

										var value = $(this).data('value');
										if (value === null || value === undefined)
											return;

										var wrp = $(this).closest('.mpl_autocomplete_wrp').find('ul.autcp-items');

										value = value.split(':');

										if ($(this).data('multiple') === false)
											wrp.find('i.mpl-ac-remove').trigger('click');

										wrp.append('<li data-id="' + value[0] + '"><span>' + 
											mpl.tools.esc_attr(value[1]) + '</span>' + 
											'<i class="sl-close mpl-ac-remove" title="Remove item"></i></li>');

										helper($(this).closest('.mpl_autocomplete_wrp'));

									});
							}
						}
					);

				}, 250, this);
			});

		}

		function helper(el) {

			mpl.ui.sortable({

				items: 'div.mpl_autocomplete_wrp>ul>li',
				connecting: false,
				vertical: false,
				end: function (e, el) {
					refresh($(el).closest('.mpl_autocomplete_wrp'));
				}

			});


			el.find('i.mpl-ac-remove').off('click').on('click', el, function (e) {
				$(this).closest('li').remove();
				refresh(e.data);
			});

			refresh(el);

		}

		function refresh(el) {

			var val = [];

			el.find('>ul.autcp-items>li').each(function () {
				val[val.length] = $(this).data('id') + ':' + $(this).find('>span').html();
			});

			el.find('input.mpl-param').val(val.join(','));

		}

		render(data, wrp);

	},

	taxonomy: function (wrp, $, data) {

		// Action for changing content type
		wrp.find('.mpl-content-type').on('change', wrp, function (e) {

			var type = this.value;

			e.data.find('.mpl-taxonomies-select option').each(function () {

				this.selected = false;

				if ($(this).hasClass(type))
					this.style.display = '';
				else this.style.display = 'none';

				if (this.value == type) {
					this.checked = true;
					e.data.find('input.mpl-param').val(type);
				}
			});

		});
		// Action for changing taxonomies
		wrp.find('.mpl-taxonomies-select').on('change', wrp, function (e) {

			var value = [];
			$(this).find('option:selected').each(function () {

				value.push(this.value);

			});

			e.data.find('input.mpl-param').val(value.join(','));

		});
		// Action remove selection
		wrp.find('.unselected').on('click', wrp, function (e) {

			e.data.find('.mpl-taxonomies-select option:selected').attr({ selected: false });
			e.data.find('input.mpl-param').val('');
			//e.data.next().find('.mpl-param option:selected').attr({ selected: false });
			e.preventDefault();

		});

		var values = data.value.split(','),
			valuez = data.value + ',';

		// Active selected taxonomies
		if (values.length > 0) {

			selected = values[0].split(':')[0];

			// Active selected content type
			if (selected !== '')
				wrp.find('.mpl-content-type option[value=' + selected + ']').attr('selected', 'selected').trigger('change');
			else wrp.find('.mpl-content-type').trigger('change');

			wrp.find('.mpl-taxonomies-select option').each(function () {
				if (valuez.indexOf(this.value + ',') > -1) {
					this.selected = true;
				} else this.selected = false;
			});
		}

		wrp.find('.mpl-select-wrp')
			.append('<input class="mpl-param" name="' + data.name + '" type="hidden" value="' + data.value + '" />');

	},

	corners: function (el, $) {

		var value_render = function (wrp) {

			var val = [], empty = true;
			wrp.find('.mpl-corners-wrp input[data-css-corners]').each(function () {
				if (this.value !== '') {
					val.push(this.value);
					empty = false;
				} else val.push('inherit');
			});

			if (empty === true)
				val = [];

			wrp.find('input[data-css-corners-value]').val(val.join(' ')).change();

		};

		el.find('input[data-css-corners]').on('keyup change', el, function (e) {

			if (this.value.trim() == 'px') {
				this.value = '';
			}
			if (isNaN(this.value) === false) {
				this.value += 'px';
				this.setSelectionRange((this.value.length - 2), 1);
			}
			if (this.value.trim() == 'px') {
				this.value = '';
			}
			if (this.value.indexOf('%') > -1 || this.value.indexOf('em') > -1) {
				this.value = this.value.replace(/\p\x/g, '');
			}

			$(this).data({ unit: this.value.replace(/[^a-z\%]/g, '') });

			if (e.data.find('.m-f-u-li-link').hasClass('active')) {
				var cur = this;
				e.data.find('input[data-css-corners]').each(function () {
					if (this != cur) {
						this.value = cur.value;
						$(this).data({ unit: this.value.replace(/[^a-z\%]/g, '') });
					}
				});
			}

			value_render(e.data);

		})
			.on('mousedown', function (e) {

				if (e.which !== undefined && e.which !== 1)
					return false;

				$(document).on('mouseup', function () {
					$(document).off('mousemove').off('mouseup');
					$('body').css({ cursor: '' });
				});

				$(document).on('mousemove', {
					el: $(this),
					cur: parseInt(this.value !== '' ? this.value : 0, 10),
					top: e.clientY
				}, function (e) {

					var offset = (e.clientY - e.data.top);
					if (e.data.el.val().replace(/[^a-z\%]/g, '') === '')
						e.data.el.data({ unit: 'px' });
					else e.data.el.data({ unit: e.data.el.val().replace(/[^a-z\%]/g, '') });

					e.data.el.val((e.data.cur - offset) + e.data.el.data('unit'));

					$(e.data.el).trigger('change');

				});

				$('body').css({ cursor: 'ns-resize' });

				$(window).off('mouseup').on('mouseup', function () {
					$(document).off('mousemove');
					$(window).off('mouseup');
					$('html,body').removeClass('mpl_dragging noneuser');
				});

			})
			.on('dblclick', function () {
				$(this).val('').change();
			});

		el.find('.m-f-u-li-link span').on('click', el, function (e) {
			if ($(this).parent().hasClass('active')) {
				$(this).parent().removeClass('active');
			} else {
				$(this).parent().addClass('active');
				var inps = $(this).closest('.mpl-corners-wrp').find('input[data-css-corners]'), val = '';
				inps.each(function () {
					if (this.value !== '' && val === '')
						val = this.value;
				});
				inps.val(val).trigger('change');
			}
		});

	},

	background: function (wrp, $, data) {

		var inputs = wrp.find('input[data-css-background],select[data-css-background]'), p, values = {},
			update_values = function (e) {
				// transparent none 0% 0%/auto repeat scroll
				var factory = {
					color: 'transparent',
					linearGradient: [''],
					image: 'none',
					position: '0% 0%',
					size: 'auto',
					repeat: 'repeat',
					attachment: 'scroll',
					advanced: 0,
					parallax_scrolling: 'no'
				},
					inputs = e.data.find('input[data-css-background],select[data-css-background]'), val;
					
				if (e.data.find('.field-toggle input[type="checkbox"]').get(0).checked === true) {

					factory.advanced = 1;

					for (var f in factory) {
						val = inputs.filter('[name="' + f + '"]').val();
						
						if (val !== null && val !== undefined && val !== '' && val != factory[f]) {
							if (f == 'linearGradient') {

								factory[f] = [];
								if (e.data.find('input.degrees').length > 0 && e.data.find('input.degrees').val() !== '') {
									factory[f].push(e.data.find('input.degrees').val().replace(/[^0-9\-]/g, '') + 'deg');
								}

								if (e.data.find('.color-row input.grdcolor').length === 1) {
									if (e.data.find('.color-row input.grdcolor').val() !== '') {
										factory[f].push(e.data.find('.color-row input.grdcolor').val());
									}
								} else {
									e.data.find('.color-row input.grdcolor').each(function () {
										if (this.value !== '')
											factory[f].push(this.value);
									});
								}

							} else if (f == 'image') {
								factory[f] = val.replace(mpl_site_url, '%SITE_URL%');
							} else factory[f] = val;
						}
					}

				} else {
					
					val = inputs.filter('[name="color"]').val();
					if (val !== null && val !== undefined && val !== '' && val != factory[f])
						factory['color'] = val;
				}
				
				e.data.find('input[data-css-background-value]')
					.val(mpl.tools.base64.encode(JSON.stringify(factory))).change();

			};

		wrp.find('.add-more-color').on('click', wrp, function (e) {

			var input = $('<span class="color-row"><input class="grdcolor" value="" placeholder="Select color" type="search" /><i class="fa-times remove" title="Delete"></i></span>');

			$(this.parentNode).find('.mpl-param-bg-gradient-colors .color-row').last().after(input);

			var incl = $(this.parentNode).find('.color-row input').last().get(0);
			incl.color = new jscolor.color(incl, {});

			e.data.find('input.grdcolor').each(function () {
				if (this.color === undefined)
					this.color = new jscolor.color(this, {});
			});

			input.find('input').first().on('change', e.data, update_values);

			e.preventDefault();
			return false;

		});

		wrp.find('.custom-degrees').on('click', wrp, function (e) {

			if ($(this.parentNode).find('.degrees-row').length === 0) {
				var input = $('<span class="degrees-row"><input class="degrees" value="90" placeholder="Custom degrees" style="width: 45%" type="search" autocomplete="off" /><i class="fa-times remove" title="Delete"></i></span>');

				$(this.parentNode).find('.mpl-param-bg-gradient-colors .color-row').last().after(input);

				input.find('input').on('change', e.data, update_values);

				update_values(e);

			}
			e.preventDefault();
			return false;

		});

		wrp.find('.mpl-param-bg-gradient-colors').on('click', wrp, function (e) {
			if (e.target.className.indexOf('remove') > -1) {
				$(e.target).closest('span').remove();
				update_values(e);
			}
		});

		wrp.find('.field-toggle input').on('change', wrp, function (e) {
			if (this.checked === true)
				e.data.find('.mpl-control-field').removeClass('mpl-hidden');
			else e.data.find('.mpl-control-field').addClass('mpl-hidden');
			e.data.find('input[data-css-background]').first().change();
		});

		wrp.find('.field-attach_image_url').each(function () {
			mpl.ui.callbacks.upload_image_url($(this), $);
		});

		wrp.find('.field-select_group').each(function () {

			var el = $(this), val = el.find('input[data-css-background]').val();

			mpl.ui.callbacks.select_group(el, $);

			if (el !== undefined && el !== '')
				el.find('button').removeClass('active').filter('[data-value="' + val + '"]').addClass('active');

		});

		inputs.on('change', wrp, update_values);

		/*
		*
		* Fill values to form
		*
		*/
		try {
			values = JSON.parse(mpl.tools.base64.decode(data.value));
		} catch (ex) { };

		values = $.extend({
			color: 'transparent',
			linearGradient: [''],
			image: 'none',
			position: '0% 0%',
			size: 'auto',
			repeat: 'repeat',
			attachment: 'scroll',
			parallax_scrolling: 'no'
		}, values);
		

		for (var f in values) {

			if (values[f] !== undefined && f == 'image' && values[f] !== '' && values[f] != 'none') {

				if (values[f].indexOf('%SITE_URL%') > -1) {

					values[f] = values[f].replace('%SITE_URL%', mpl_site_url);

					if (values[f].indexOf(mpl_ajax_url) === -1)
						values[f] = mpl_ajax_url + '?action=mpl_get_thumbn&type=filter_url&id=' + encodeURIComponent(values[f].replace(mpl_site_url, ''));
				}

				wrp.find('.field-attach_image_url img').attr({ src: values[f] });
				wrp.find('.mpl-toggle-field-wrp input').attr({ checked: true });
				wrp.find('.box-bg.mpl-hidden').removeClass('mpl-hidden');
			}

			if (f == 'color' && (values[f] == 'rgba(0, 0, 0, 0)' || values[f] == 'transparent')) {
				values[f] = '';
				inputs.filter('[name="' + f + '"]').val('');
			}
			else if (f == 'advanced' && values[f] == 1) {
				wrp.find('.field-toggle input[type="checkbox"]').attr({ checked: true });
				wrp.find('.box-bg.mpl-hidden').removeClass('mpl-hidden');
			}
			else if (f == 'linearGradient') {
				if (typeof values[f] == 'object' && values[f][0] !== undefined) {
					if (values[f][0].indexOf('deg') > -1) {

						if (wrp.find('.degrees-row').length === 0) {
							var inp_deg = $('<span class="degrees-row"><input class="degrees" value="' + values[f][0].replace(/[^0-9\-]/g, '') + '" placeholder="Custom degrees" style="width: 45%" type="search" autocomplete="off" /><i class="fa-times remove" title="Delete"></i></span>');
							wrp.find('.mpl-param-bg-gradient-colors .color-row').last().after(inp_deg);
							inp_deg.on('change', wrp, update_values);
						}
						values[f] = values[f].slice(1);
					}

					wrp.find('.color-row').find('input.grdcolor').val(values[f][0]);

					var inp_col;
					for (var i = 1; i < values[f].length; i++) {

						inp_col = $('<span class="color-row"><input class="grdcolor" value="' + values[f][i] + '" placeholder="Select color" type="search" style="background:' + values[f][i] + '" /><i class="fa-times remove" title="Delete"></i></span>');

						wrp.find('.mpl-param-bg-gradient-colors .color-row').last().after(inp_col);
						new jscolor.color(inp_col.find('input').get(0), {});

						inp_col.find('input').first().on('change', wrp, update_values);

					}
				}
			} 
			
			else if( f == 'parallax_scrolling' ){
				
				wrp.find('[name="' + f + '"]').val(values[f]);
				wrp.find('[name="' + f + '"]').on('change', wrp, update_values);
				}else {
				inputs.filter('[name="' + f + '"]').val(values[f]).parent().find('button').removeClass('active');
				inputs.filter('[name="' + f + '"]').parent().find('button[data-value="' + values[f] + '"]').addClass('active');
			}

		}
		

		wrp.find('.field-color_picker input, input.grdcolor').each(function () {
			if (this.color === undefined)
				this.color = new jscolor.color(this, {});
		});

	},

	video_background: function (wrp, $, data) {

		var inputs = 
		wrp.find('input[data-css-video-background],select[data-css-video-background]'), 
			p, values = {},
			update_values = function (e) {
				// transparent none 0% 0%/auto repeat scroll
				var factory = {
						video_type: 'youtube',
						video_url: 'XDLmLYXuIDM',
						mp4_url: '',
						ogv_url: '',
						webm_url: '',
						start_time: '',
						stop_time: '',
						video_mute: 'yes',
						video_loop: 'yes',
						enable_video_bg: '',
					},
					inputs = e.data.find('input[data-css-video-background],select[data-css-video-background]'), val;

				for (var f in factory) {
					if (f == 'video_mute' || f == 'video_loop' || f == 'enable_video_bg') {
						if (wrp.find('input[name="' + f + '"]').attr("checked")) {
							factory[f] = 'yes';
						} else {
							factory[f] = '';
						}
					} else {
						val = inputs.filter('[name="' + f + '"]').val();
						if (val !== null && val !== undefined && val !== '' && val != factory[f]) {
							factory[f] = val;
						}
					}
				}

				e.data.find('input[data-css-video-background-value]')
					.val(mpl.tools.base64.encode(JSON.stringify(factory))).change();
			};

		wrp.find('.field-toggle input[name="enable_video_bg"]').on('change', wrp, function (e) {
			if (this.checked === true)
				e.data.find('.mpl-control-field').removeClass('mpl-hidden');
			else e.data.find('.mpl-control-field').addClass('mpl-hidden');
		});
//@if NODE_ENV == 'pro'
		wrp.find('.field-select select[name="video_type"]').on('change', wrp, function (e) {
			if (this.value === 'html5') {
				e.data.find('.mpl-video_url-field').addClass('mpl-hidden');
				e.data.find('.mpl-mp4_url-field').removeClass('mpl-hidden');
				e.data.find('.mpl-ogv_url-field').removeClass('mpl-hidden');
				e.data.find('.mpl-webm_url-field').removeClass('mpl-hidden');
			} else { 
				e.data.find('.mpl-video_url-field').removeClass('mpl-hidden');
				e.data.find('.mpl-mp4_url-field').addClass('mpl-hidden');
				e.data.find('.mpl-ogv_url-field').addClass('mpl-hidden');
				e.data.find('.mpl-webm_url-field').addClass('mpl-hidden');
			}
		});
//@endif
		wrp.find('.field-toggle input[type="checkbox"]').on('change', wrp, function (e) {
			if (this.checked === true) $(this).attr({ checked: true });
			else $(this).attr({ checked: false });
		});

		inputs.on('change', wrp, update_values);

		/*
		*
		* Fill values to form
		*
		*/
		try {
			values = JSON.parse(mpl.tools.base64.decode(data.value));
		} catch (ex) { };

		values = $.extend({
			video_type: 'youtube',
			video_url: 'XDLmLYXuIDM',
			mp4_url: '',
			ogv_url: '',
			webm_url: '',
			start_time: '',
			stop_time: '',
			video_mute: 'yes',
			video_loop: 'yes',
			enable_video_bg: '',
		}, values);

		for (var f in values) {
			if (values[f] !== undefined) {
				if (f == 'video_mute' || f == 'video_loop' || f == 'enable_video_bg') {
					if (values[f] == 'yes' || values[f] == 1) {
						inputs.filter('[name="' + f + '"]').attr({ checked: true });
						if (f == 'enable_video_bg')
							wrp.find('.mpl-control-field').removeClass('mpl-hidden');

					} else {
						inputs.filter('[name="' + f + '"]').attr({ checked: false });
						if (f == 'enable_video_bg')
							wrp.find('.mpl-control-field').addClass('mpl-hidden');
					}
//@if NODE_ENV == 'pro'
				} else if (f == 'video_type') {
					inputs.filter('[name="' + f + '"]').val(values[f]);
					if (values[f] == 'html5') {
						wrp.find('.mpl-video_url-field').addClass('mpl-hidden');
						wrp.find('.mpl-mp4_url-field').removeClass('mpl-hidden');
						wrp.find('.mpl-ogv_url-field').removeClass('mpl-hidden');
						wrp.find('.mpl-webm_url-field').removeClass('mpl-hidden');
					} else {
						wrp.find('.mpl-video_url-field').removeClass('mpl-hidden');
						wrp.find('.mpl-mp4_url-field').addClass('mpl-hidden');
						wrp.find('.mpl-ogv_url-field').addClass('mpl-hidden');
						wrp.find('.mpl-webm_url-field').addClass('mpl-hidden');
					}
//@endif
				} else {
					inputs.filter('[name="' + f + '"]').val(values[f]);
				}
			}
		}
	},

	css: function (wrp, $, data) {

		if (data.options.length === 0)
			data.options = mpl.maps._styling.options;

		mpl.params.fields.css.render(data, wrp.find('.mpl-css-rows'));

		var pop = wrp.closest('.mpl-params-popup'), model = pop.data('model');

		mpl.tools.popup.callback(pop, {

			before_callback: mpl.params.fields.css.save_fields

		}, 'field-css-callback');
	},

	css_fonts: function (wrp, $, data) {

		wrp.find('input').on('focus', function () {

			var ul = $(this).parent().find('.mpl-fonts-list');
			ul.html('').show();

			if (typeof mpl_fonts == 'object' && Object.keys(mpl_fonts).length > 0) {
				for (var i in mpl_fonts) {
					i = decodeURIComponent(i);
					if (i == this.value)
						ul.append('<li style="background: #42BCE2;font-family: \'' + i + '\'">' + i + '</li>');
					else ul.append('<li style="font-family: \'' + i + '\'">' + i + '</li>');
				}
				ul.find('li').on('click', function () {
					$(this).closest('.mpl-fonts-picker').find('input').val(this.innerHTML).change();
				});
			} else {
				ul.append('<li class="align-center"><h1>\\(^Д^)/</h1>No fonts in list<br />Add fonts via "Fonts Manager"</li>');
			}


		}).on('blur', function () {
			setTimeout(function (el) { el.hide(); }, 200, $(this).parent().find('.mpl-fonts-list'));
		});

		wrp.find('button').on('click', function (e) {

			mpl.ui.lightbox({
				iframe: true,
				url: mpl_site_url + '/wp-admin/admin.php?page=mageewp_page_layout&mpl_action=fonts-manager'
			});

			e.preventDefault();
		});

	},
	radio_image: function (wrp) {
		wrp.find('.clear-selected').on('click', wrp, function (e) {
			e.data.find('input.mpl-param.empty-value').attr({ 'checked': true });
			e.preventDefault();
		});

		var preview = wrp.find('img.large-view'),
			win_width = $(window).width();

		wrp.find('label.rbtn img').on('mouseover mousemove', 
			{
				el: preview,
				wd: win_width
			}, 
			function (e) {

				if (e.data.el.attr('src') != this.src)
					e.data.el.attr('src', this.src);

				e.data.el.show();

				if (e.data.el.width() == this.offsetWidth) {
					e.data.el.hide();
					return;
				}

				e.data.left = e.clientX - (e.data.el.width() / 2);

				if (e.data.left + e.data.el.width() > e.data.wd - 10)
					e.data.left = (e.data.wd - 10 - e.data.el.width());

				if (e.data.left < 10)
					e.data.left = 10;

				e.data.el.css({ display: 'block', left: e.data.left + 'px', top: (e.clientY + 20) + 'px' });

			}).on('mouseout', preview, function (e) {
				e.data.hide();
			});
	},

	css_border: function (wrp, $, data) {

		var inputs = wrp.find('.multi-fields-ul [data-css-border]'),
			input = wrp.find('input[data-css-border="value"]'),
			map = { top: 0, right: 1, bottom: 2, left: 3 },
			_get = function () {

				var vals = [inputs.eq(0).val(), inputs.eq(1).val(), inputs.eq(2).val()];

				if (vals[0] !== '' && !isNaN(vals[0]))
					vals[0] += 'px';

				if (vals[0] !== '' && vals[2] !== '')
					vals = vals.join(' ');
				else vals = '';

				return vals;

			},
			_render = function (val) {

				if (val === undefined || val === '')
					val = '   ';

				val = val.trim().split(' ');

				inputs.eq(0).val(val[0]);
				inputs.eq(1).val(val[1]);

				val[0] = '';
				val[1] = '';
				val = val.join(' ').trim();

				inputs.eq(2).val(val).css({ 'background': val }).change();
			};

		inputs.on('change', function (e) {
			var vals = _get(), 
				val = input.val();

			var dir = wrp.find('.active').data('dir');

			if (dir === undefined) {
				val = vals;
			} else {
				val = val.split('|');
				for (var i = 0; i < 4; i++) {
					if (i == map[dir])
						val[i] = vals;
					else if (val[i] === undefined)
						val[i] = '';
				}
				val = val.join('|');
			}

			input.val(val).change();

		});

		wrp.find('.mpl-corners-pos button,.m-f-u-li-link').on('click', function (e) {

			wrp.find('.active').removeClass('active');
			$(this).addClass('active');

			var val = input.val().toString().trim().split('|');

			if ($(this).data('dir') === undefined) {
				_render(val[0]);
			} else {
				if (val.length === 1) {
					input.val('');
					_render(val[0]);
				} else _render(val[map[$(this).data('dir')]]);
			}

			return false;
		});

		wrp.find('.css-border-advanced').on('click', wrp, function (e) {
			e.data.find('.mpl-corners-wrp').removeClass('hidden');
			e.data.find('.css-border-advanced').remove();
			e.preventDefault();
			return false;
		});

		if (data.value.indexOf('|') === -1) {
			wrp.find('.m-f-u-li-link').addClass('active');
			_render(data.value);
		} else {

			wrp.find('.mpl-corners-wrp').removeClass('hidden');
			wrp.find('.css-border-advanced').remove();

			var value = data.value.split('|');
			for (var i = 0; i < 4; i++) {
				if (value[i] !== undefined && value[i] !== '') {
					wrp.find('.mpl-corners-wrp .mpl-corners-pos').eq(i).find('button').trigger('click');
					break;
				}
			}
		}

		wrp.find('input.m-f-bb-color').each(function () {
			this.color = new jscolor.color(this, {});
		});

	},

	animate: function (wrp, $, data) {

		if (data.value === undefined)
			data.value = '';

		var preview = wrp.find('.mpl-animate-preview'),
			eff = wrp.find('.mpl-animate-effect'),
			delay = wrp.find('.mpl-animate-delay'),
			speed = wrp.find('.mpl-animate-speed'),
			param = wrp.find('.mpl-param'),
			value = data.value.split('|');

		wrp.find('.mpl-animate-field select,.mpl-animate-field input').on('change keydown', function (e) {

			if (e.keyCode !== undefined && e.keyCode !== 13)
				return;

			if (delay.val() !== '')
				preview.css({ 'animation-delay': delay.val() + 'ms' });
			else preview.css({ 'animation-delay': '' });

			if (speed.val() !== '')
				preview.css({ 'animation-duration': speed.val() });
			else preview.css({ 'animation-duration': '' });

			if (eff.val() !== '')
				preview.attr({ 'class': '' }).attr({ 'class': 'mpl-animate-preview animated ' + this.value });

			param.val(eff.val() + '|' + delay.val() + '|' + speed.val()).change();

		});

		if (value[0] !== undefined && value[0] !== '')
			eff.val(value[0]);
		if (value[1] !== undefined && value[1] !== '')
			delay.val(value[1]);
		if (value[2] !== undefined && value[2] !== '')
			speed.val(value[2]);

	},

	icon_picker: function (wrp, $, data) {

		wrp.find('input.mpl-param, .icons-preview').on('click', wrp.find('input.mpl-param').get(0), function (e) {

			$('.mpl-icons-picker-popup').remove();

			var html = '<div class="icons-list noneuser">' +
				'<ul class="mpl-icon-picker-tabs mpl-pop-tabs"></ul>' +
				mpl.tools.get_icons() +
				'</div>';

			var listObj = jQuery(html);

			var atts = {
				title: 'Icon Picker',
				width: 600,
				class: 'no-footer mpl-icons-picker-popup',
				float: true,
				keepCurrentPopups: true
			};
			var pop = mpl.tools.popup.render(this, atts);

			pop.data({ target: e.data/*, scrolltop: jQuery(window).scrollTop() */ });

			pop.find('.m-p-header').append('<input type="search" class="mpl-components-search mpl-icons-search" placeholder="Search by Name"><i class="sl-magnifier"></i>');

			pop.find('.m-p-body').off('mousedown').on('mousedown', function (e) {
				e.preventDefault();
				return false;
			});

			pop.find('input.mpl-icons-search').off('keyup').on('keyup', listObj, function (e) {

				clearTimeout(this.timer);

				if (this.value === '') {
					e.data.find('.seach-results').remove();
					return;
				}

				this.timer = setTimeout(function (el, list) {
					var sr;
					if (list.find('.seach-results').length === 0) {

						sr = $('<div class="seach-results"></div>');
						list.prepend(sr);

					} else sr = list.find('.seach-results');

					var found = ['<span class="label">Search Results:</span>'];
					list.find('>i').each(function () {

						if (this.className.indexOf(el.value.trim()) > -1 && 
							found.length < 16 && 
							$.inArray(this.className, found)) 
							found.push('<span data-icon="' + this.className + '"><i class="' + this.className + '"></i>' + this.className + '</span>');

					});
					if (found.length > 1) {
						sr.html(found.join(''));
						sr.find('span').on('click', function () {

							if ($(this).data('icon') === undefined) {
								e.preventDefault();
								return false;
							}
							var tar = mpl.get.popup(this).data('target');
							tar.value = $(this).data('icon');
							$(tar).trigger('change');
							mpl.get.popup(this, 'close').trigger('click');
						});
					}
					else sr.html('<span class="label">The key you entered was not found.</span>');

				}, 150, this, e.data);

			}).focus();

			listObj.on('click', function (e) {

				if (e.target.tagName != 'I')
					return;

				var tar = mpl.get.popup(this).data('target');
				tar.value = e.target.title;
				$(tar).trigger('change');

				mpl.get.popup(this, 'close').trigger('click');

			});

			var args = [], cl, tabs = '';
			listObj.find('i').each(function () {
				if (this.className !== undefined && this.className.indexOf('-') > -1) {
					cl = this.className.substr(0, this.className.indexOf('-')).trim();
					if (cl !== '' && args.indexOf(cl) === -1) {
						args.push(cl);
						tabs += '<li>' + cl + '</li>';
					}
				}
			});

			listObj.find('ul.mpl-icon-picker-tabs').html(tabs);
			listObj.find('ul.mpl-icon-picker-tabs li').on('click', function () {
				$(this).parent().find('.active').removeClass('active');
				$(this).addClass('active');
				listObj.find('i').hide();
				listObj.find("i[class^='" + this.innerHTML + "-']").css({ 'display': '' });
			}).first().trigger('click');
			pop.find('.m-p-body').append(listObj);

		}).on('change', function () {
			jQuery(this).parent().find('.icons-preview i').attr({ class: this.value });
		})/*.on('blur', function() {
		mpl.cfg.icon_picker_scrolltop = $('.mpl-icons-picker-popup .m-p-body').scrollTop();
		$('.mpl-icons-picker-popup').remove();
	})*/;

	},

	wp_widgets: function (wrp, $) {

		var container = wrp.find('.mpl-widgets-container'),
			pop = mpl.get.popup(wrp);

		container.find('*[data-value]').each(function () {
			switch (this.tagName) {
				case 'INPUT':
					if (this.type == 'radio' || this.type == 'checkbox')
						this.checked = true;
					else this.value = $(this).data('value');
					break;
				case 'TEXTAREA':
					this.value = $(this).data('value');
					break;
				case 'SELECT':
					var vls = $(this).data('value');
					if (vls) vls = vls.toString().split(',');
					else vls = [''];

					if (vls.length > 1)
						this.multiple = 'multiple';
					$(this).find('option').each(function () {
						if (vls.indexOf(this.value) > -1)
							this.selected = true;
						else this.selected = false;
					});
					break;
			}
		});

		mpl.tools.popup.callback(pop, {

			before_callback: function (wrp) {

				var name = container.data('name'),
					fields = container.closest('form').serializeArray(),
					data = {};

				data[name] = {};

				fields.forEach(function (n) {
					if (data[name][n.name] === undefined)
						data[name][n.name] = n.value;
					else data[name][n.name] += ',' + n.value;
				});

				var string = mpl.tools.base64.encode(JSON.stringify(data));

				container.append('<textarea name="data" class="mpl-param mpl-widget-area forceHide">' + string + '</textarea>');

			},
			after_callback: function (wrp) {
				container.find('.mpl-param.mpl-widget-area.forceHide').remove();
			}

		}, 'field-wp-widget-callback');

	},

	optimize_settings: function (wrp) {

		wrp.find('input[data-optimized]').on('change', function () {

			if (this.checked)
				mpl_global_optimized[$(this).data('optimized')] = this.value;
			else mpl_global_optimized[$(this).data('optimized')] = '';

			var mp = wrp.closest('.m-p-wrap');
			if (mp.find('.mpl-popup-loading').length === 0)
				mp.append('<div class="mpl-popup-loading"><span class="mpl-loader"></span></div>');

			mp.find('.mpl-popup-loading').show();

			$.post(

				mpl_ajax_url,

				{
					'action': 'mpl_enable_optimized',
					'security': mpl_ajax_nonce,
					'settings': mpl_global_optimized,
					'id': $('#post_ID').val()
				},

				function (result) {

					wrp.find('.m-warning, .m-success').remove();
					mp.find('.mpl-popup-loading').hide();

					if (result == '-1') {
						wrp.find('h1.mgs-t02').after('<div style="display: block" class="m-settings-row m-warning">Error: secure session is invalid. Reload and try again</div>');
						$('input[data-optimized="enable"]').attr({ checked: false });
					} else if (result.stt === undefined) {
						wrp.find('h1.mgs-t02').after('<div style="display: block" class="m-settings-row m-warning">Error: unknow reason</div>');
						$('input[data-optimized="enable"]').attr({ checked: false });
					} else if (result.stt == '0') {
						wrp.find('h1.mgs-t02').after('<div style="display: block" class="m-settings-row m-warning">Error: ' + result.msg + '</div>');
						$('input[data-optimized="enable"]').attr({ checked: false });
					} else {
						wrp.find('h1.mgs-t02').after('<div style="display: block" class="m-settings-row m-success">' + result.msg + '</div>');
						if (mpl_global_optimized.enable == 'on')
							$('#mpl-page-settings').addClass('mpl-optimized-on');
						else $('#mpl-page-settings').removeClass('mpl-optimized-on');
					}

				}
			).complete(function (data) {

				if (data.status !== 200) {
					mpl.msg('Please check all of your code and make sure there are no errors. ', 'error', 'sl-close');
				}
			});


		});

		wrp.find('select[data-optimized="this_page"]').on('change', function () {
			$('#mpl-page-cfg-optimized').val(this.value);
			mpl.instant_submit();
		});

		wrp.find('button.clear-cache').on('click', function () {

			if (!confirm(mpl.__.i72)) return;

			mpl_global_optimized.clear_cache = 'on';
			wrp.find('input[data-optimized]').first().trigger('change');

		});

	}

},
}, window.mpl.ui);

window.mpl = $.extend({
	ver: '0',
	auth: 'king-theme.com',
	model: 1,
	tags: '',
	storage: [],
	maps: {},
	views: {},
	params: {},
	tools: {},
	header: {},
	mode: '',
	widgets: null,
	live_preview: true,
	ready: [],
	objs: {},
	__: {},
	_$: null,
	cfg: {
		version: 0,
		limitDeleteRestore: 10,
		limitClipboard: 9,
		sectionsPerpage: 10,
		scrollAssistive: 1,
		preventScrollPopup: 1,
		showTips: 1,
		live_preview: true,
		columnDoubleContent: 'checked',
		columnKeepContent: 'checked',
		profile: 'Mageewp Page Layout',
		profile_slug: 'mageewp-page-layout',
		sectionsLayout: 'grid',
		mode: '',
		defaultImg: mpl_plugin_url + '/assets/images/get_start.jpg'
	},

	init: function () {

		if (typeof (mpl_maps) == 'undefined')
			return;

		this.tags = shortcode_tags;
		this.maps = mpl_maps;
		this.cfg = $().extend(this.cfg, this.backbone.stack.get('MPL_Configs'));
		
		mpl.ui.init();

		if (typeof (mpl_js_languages) == 'object')
			this.__ = mpl_js_languages;
		
		if ($('#post_ID').length > 0 && $('#post_ID').val() !== '') {
			window.mpl_post_id = $('#post_ID').val();
		}

		if ($('#mpl-page-cfg-mode').length > 0) {
			this.cfg.mode = $('#mpl-page-cfg-mode').val();
		}
	},

	trigger: function (obj) {
		var func;


		for (var ev in obj.events) {

			if (typeof obj.events[ev] == 'function')
				func = obj.events[ev];
			else if (typeof obj[obj.events[ev]] == 'function')
				func = obj[obj.events[ev]];
			else if (typeof mpl.backbone[obj.events[ev]] == 'function')
				func = mpl.backbone[obj.events[ev]];
			else return false;

			ev = ev.split(':');


			if (ev.length == 1)
				obj.el.off(ev[0]).on(ev[0], func);
			else
				obj.el.find(ev[0]).off(ev[1]).on(ev[1], obj, func);

		}
	},

	template: function (name, atts) {
		var _name = '_' + name;

		if (this[_name] == 'exit')
			return null;

		if (this[_name] === undefined) {
			if (document.getElementById('tmpl-mpl-' + name + '-template')) {
				this[_name] = wp.template('mpl-' + name + '-template');
			}
			else {
				this[_name] = mpl.ui.get_tmpl_cache('tmpl-mpl-' + name + '-template');
			}
		}

		if (atts === undefined)
			atts = {};


		if (typeof this[_name] == 'function') {
			return this[_name](atts);
		}

		return null;
	},

	get: {

		model: function (el) {

			var id = $(el).data('model');
			if (id !== undefined && id !== -1)
				return id;
			else if (el.parentNode) {
				if (el.parentNode.id != 'mpl-container')
					return this.model(el.parentNode);
				else
					return null;
			} else return null;
		},

		storage: function (el) {
			return mpl.storage[this.model(el)];
		},
		/*magee start*/
		section_name: function (el) {
			var cls = $(el).closest('.mpl-elm').attr('class').split(' ');
			return cls[1].replace(/-/g, '_');
		},
		/*magee end*/

		maps: function (el) {
			return mpl.maps[this.storage(el).name];
		},

		popup: function (el, btn) {

			var pop = $(el).closest('.mpl-params-popup');

			if (pop.length === 0)
				return null;

			if (btn == 'close')
				return pop.find('.m-p-header .sl-close.sl-func');
			else if (btn == 'save')
				return pop.find('.m-p-header .sl-check.sl-func');
			else return pop;

		}

	},

	add_action: function (name, unique, action) {

		if (this.actions === undefined)
			this.actions = {};

		if (this.actions[name] === undefined)
			this.actions[name] = {};

		if (this.actions[name][unique] === undefined) {
			this.actions[name][unique] = action;
			return true;
		}

		return false;

	},

	do_action: function (name, var1, var2, var3, var4, var5) {

		if (this.actions === undefined || this.actions[name] === undefined)
			return false;

		for (var uni in this.actions[name]) {
			if (typeof this.actions[name][uni] == 'function')
				this.actions[name][uni](var1, var2, var3, var4, var5);
		}

		return true;

	},

	remove_action: function (name) {

		if (this.actions === undefined || this.actions[name] === undefined)
			return false;

		delete this.actions[name];

		return true;

	},

	delete_action: function (name) {

		return this.remove_action(name);

	},

	submit: function () {

		/*
		*	This action runs before the form submit
		*	Disable unsaved warning
		*/

		mpl.confirm(false);

		$('#mpl-page-cfg-mode').val(mpl.cfg.mode);
		/*
		*	Do not need to do any actions if the builder is inactive
		*/
		if (mpl.cfg.mode != 'mpl')
			return;

		/*
		*	Remove all input to prevent unused post content from the builder
		*/
		$('#mpl-container').find('form,input,select,textarea').remove();
		/*
		*	Export content from the builder
		*/
		var content = '';
		$('#mpl-container > #mpl-rows > .mpl-row').each(function () {
			var exp = mpl.backbone.export($(this).data('model'));
			content += exp.begin + exp.content + exp.end;
		});

		/*
		*	Warning if the content is empty	
		*/
		//if ( content === '' && !confirm( mpl.__.i53 ) )
		//	return false;
		if (content === '')
			return false;

		/*
		*	Update wp-editor content
		*/
		$('#content').val(content);

		try {
			tinyMCE.get('content').setContent(content);
		} catch (ex) { }

	},

	instant_submit: function () {

		$('#mpl-page-cfg-mode').val(mpl.cfg.mode);


		/*
		*	Editing sections
		*/
		if (mpl.curentContentType !== undefined && mpl.curentContentType == 'mpl-sections') {
			$('#publishing-action button').trigger('click');
			return;
		}

		/*
		*	do not work while saving content
		*/
		if ($('#mpl-preload').length > 0 || mpl.cfg.mode != 'mpl') {
			return;
		}
		/*
		*	do not work if missing important field
		*/
		if ($('#post').length === 0 || $('#title').length === 0 || $('#post_ID').length === 0) {
			return;
		}

		/*
		*	Start work by show the loading interface
		*/

		mpl.msg(mpl.__.processing, 'loading');

		/*
		*	Change browser title 
		*/
		document.raw_title = document.title;
		document.title = 'Saving...';

		/*
		*	Apply & close all open popups
		*/
		var list = $('.mpl-params-popup .sl-check.sl-func, .mpl-params-popup .save-post-settings');
		if (list.length > 0) {
			for (var i = list.length - 1; i >= 0; i--)
				list.eq(i).trigger('click');
		}

		/*
		*	Export content from the builder
		*/
		var content = '',
			id = $('#post_ID').val(),
			title = $('#title').val();
		/*
		*	Export each row level 1
		*/
		$('#mpl-container > #mpl-rows > .mpl-row').each(function () {
			var exp = mpl.backbone.export($(this).data('model'));
			content += exp.begin + exp.content + exp.end;
		});
		/*
		*	Start posting the datas to server
		*/
		var meta = mpl.tools.reIndexForm($("input[name^='mpl_post_meta']").serializeArray(), []);
		$.post(

			mpl_ajax_url,
			{
				'action': 'mpl_instant_save',
				'security': mpl_ajax_nonce,
				'title': title,
				'id': parseInt(id, 10),
				'content': content,
				'meta': meta.mpl_post_meta
			},
			function (result) {

				/*
				*	Revert browser title
				*/
				document.title = document.raw_title;

				if (result == '-1')
					mpl.msg('Error: secure session is invalid. Reload and try again', 'error', 'sl-close');
				else if (result == '-2')
					mpl.msg('Error: Post not exist', 'error', 'sl-close');
				else if (result == '-3')
					mpl.msg('Error: You do not have permission to edit this post', 'error', 'sl-close');
				else mpl.msg('Successful', 'success', 'sl-check');

				if ($('#content').length > 0) {
					$('#content-html').trigger('click');
					$('#content').val(content);
				}
				/*
				*	Disable unsaved warning
				*/
				mpl.confirm(false);

			}
		).complete(function (data) {
			document.title = document.raw_title;
			if (data.status !== 200) {
				mpl.msg('Your content has been saved, but there seems to be an error occurs. <br />Please check all of your code and make sure there are no errors. ', 'error', 'sl-close');
			}
		});
	},

	msgbox: function(mes, callback, p1) {
		var wrp = $('#mpl-preload');
		if (wrp.length === 0) {
			wrp = $('<div id="mpl-preload" style="opacity:0"></div>');
			$('body').append(wrp);
		} else wrp.html('');

		var content = '<div class="mpl-msgbox-body">' + mes + '<ul class="mpl-actions">';
			content += '<li><button class="button save button-large"><i class="sl-check"></i>Yes</button></li>';
			content += '<li><button class="button cancel button-large"><i class="sl-close"></i>No</button></li></ul></div>';
		wrp.append(content).animate({ opacity: 1 });
		$('body').addClass('mpl-ui-blur');
		wrp.find('.button.save').on('click', function() {
			$('#mpl-preload').remove();
			$('body').removeClass('mpl-ui-blur');
			if (callback !== undefined)
				callback(p1);
		});

		wrp.find('.button.cancel').on('click', function() {
			$('#mpl-preload').remove();
			$('body').removeClass('mpl-ui-blur');
		});

		wrp.on('click', function (e) {
			if (e.target.id == 'mpl-preload') {
				$('#mpl-preload').remove();
				$('body').removeClass('mpl-ui-blur');
			}
		});
	},

	msg: function (mes, stt, icon, delay) {

		var wrp = $('#mpl-preload');
		if (wrp.length === 0) {
			wrp = $('<div id="mpl-preload" style="opacity:0"></div>');
			$('body').append(wrp);
		} else wrp.html('');

		if (icon === undefined || icon === '')
			icon = 'et-lightbulb';

		if (stt === undefined)
			stt = '';

		if (stt == 'loading') {

			$('#mpl-preload')
				.stop()
				.append('<h3 class="mesg ' + stt + '"><span class="mpl-loader"></span><br />' + mes + '</h3>')
				.animate({ opacity: 1 }, 150);

		} else if (stt == 'popup') {

			wrp.append('<div class="mpl-preload-body">' + mes + '</div>').animate({ opacity: 1 });

			var btn = $('<a href="#" class="enter close"></a>');

			wrp.find('.mpl-preload-body').append(btn);

			$('body').addClass('mpl-ui-blur');

			btn.on('click', function () {
				$('#mpl-preload').remove();
				$('body').removeClass('mpl-ui-blur');
			});

			wrp.on('click', function (e) {
				if (e.target.id == 'mpl-preload') {
					$('#mpl-preload').remove();
					$('body').removeClass('mpl-ui-blur');
				}
			});

		} else {

			if (delay === undefined) {

				delay = 1500;
				if (stt == 'error')
					delay = 10000;

			}

			$('#mpl-preload')
				.stop()
				.append('<h3 class="mesg ' + stt + '"><i class="' + icon + '"></i><br />' + mes + '</h3>')
				.animate({ opacity: 1 }, 150)
				.delay(delay)
				.animate({ opacity: 0 }, function () { $(this).remove(); });

		}
	},

	std: function (ob, key, std) {

		if (typeof (ob) !== 'object')
			return std;
		if (ob[key] !== undefined && ob[key] !== '')
			return ob[key];

		return std;

	},

	confirm: function (stt) {

		if (stt === true) {
			window.onbeforeunload = function () { return mpl.__.i01; };
		} else {
			window.onbeforeunload = null;
			$(window).off('beforeunload');
		}
	},

	id: function (id) {
		return document.getElementById(id);
	},

}, window.mpl);

$(document).ready(function () {

	if (mpl.ui.verify_tmpl() === true)
		mpl.init();

	/*** 3-rd party compatible ***/
	/* YOAST SEO*/
	if (window.YoastShortcodePlugin !== undefined &&
		wpseoShortcodePluginL10n !== undefined &&
		wpseoShortcodePluginL10n.wpseo_filter_shortcodes_nonce !== undefined
	) {
		window.YoastShortcodePlugin.prototype.parseShortcodes = function (a, b) {

			var content = $('#content').val();
			var txt = '';	

			a = [];
			if (tinymce.activeEditor !== null) {
				txt += tinymce.activeEditor.getContent();
			}

			mpl.params.process_shortcodes(content, function (args) {
				if (args.args.content.indexOf('[') === -1)
					txt += args.args.content;
			}, 'mpl_column_text');

			mpl.params.process_shortcodes(content, function (args) {
				if (args.args.image !== undefined)
					txt += '';
			}, 'mpl_single_image');

			a.push(txt);

			return jQuery.post(ajaxurl, {
				action: "wpseo_filter_shortcodes",
				_wpnonce: wpseoShortcodePluginL10n.wpseo_filter_shortcodes_nonce,
				data: a
			}, function (a) {
				this.saveParsedShortcodes(a, b);
			}.bind(this));
		};
		window.YoastShortcodePlugin.prototype.replaceShortcodes = function (a) {

			var content = '';
			mpl.params.process_shortcodes(a, function (args) {
				if (args.args.content.indexOf('[') === -1)
					content += args.args.content + "\n";
			}, 'mpl_column_text');

			return content;
		};
	}

});

if ($.fn.shake === undefined) {
	$.fn.shake = function () {
		return this.focus()
			.animate({ marginLeft: -30 }, 100)
			.animate({ marginLeft: 20 }, 100)
			.animate({ marginLeft: -10 }, 100)
			.animate({ marginLeft: 5 }, 100)
			.animate({ marginLeft: 0 }, 100);
	};
}
})(jQuery);

