(function ($) {


mpl.front = $.extend({

content: {
	onchanges: {},
	change_callback: function (el, pop, e) {
		mpl.front.content.render_section_template(pop, false);
		mpl.confirm(true);
	},
	css_change_callback: function (el, pop, e) {
		
		var atts = {};
		var data_name = $(el).closest('.field-css_video_background').data('name');
		
		if (data_name && data_name.indexOf('video-background') != -1) {
			mpl.front.content.render_section_template(pop, false);
		} else {
			var model = pop.data('model');
			if (mpl.front.cancel_value === true) {
				atts = mpl.front.stack.init_atts;
			}
			else {
				//var atts = mpl.front.tools.getFormData(pop);
				atts = mpl.tools.getFormData(pop, false);
			}

			var css_custom = atts['css_custom'];
			var id = mpl.storage[model][0].args['_id'];
			var pattern1 = new RegExp( "(((?![\,\{\}]).)*)" + id + "(((?!body).)*)", "g");

			var element_css = mpl.front.content.render_element_css(css_custom, id);

			var css_render = mpl._$('#mpl-css-render').html().replace(pattern1, '');
			mpl._$('#mpl-css-render').html(css_render + element_css);
			
		}
		
		mpl.confirm(true);
	},
	render_section_template: function(pop, refresh) {
				
		var atts = {};
		var model = pop.data('model');
		if (mpl.front.cancel_value === true) {
			atts = mpl.front.stack.init_atts;
		}
		else {
			//atts = mpl.front.tools.getFormData(pop);
			atts = mpl.tools.getFormData(pop, false);
		}			
		if (mpl.storage[model][0] !== undefined && mpl.storage[model][0].args !== undefined) {
			for (var n in mpl.storage[model][0].args) {
				if (atts[n] === undefined)
					atts[n] = mpl.storage[model][0].args[n];
			}
		}
		pop.find('form.fields-edit-form .mpl-param-row.relation-hidden .mpl-param').each(function () {
			delete atts[this.name];
			$(this).closest('.mpl-param-row').find('input,textarea,select').val('');
		});

		if (atts._id === undefined || atts._id === '')
			atts._id = Math.round(Math.random() * 10000000);

		for (var att in atts) {
			if (typeof atts[att] === 'object') {
				if (typeof atts[att]['0'] !== 'object')
					delete atts[att]['0'];
				var arr = [];
				for (var subAtt in atts[att]) {
					arr.push(atts[att][subAtt]);
				}
				atts[att] = arr;
			}
		}
		atts['refresh_data'] = refresh;
		var section_elm = mpl._$('.mpl-content-wrap section[data-front-model="' + model + '"]');
		var cls_arr = mpl._$(section_elm).attr('class').split(' '),
			section_name_arr = cls_arr[mpl.front.section_name_pos].split('-');
		var template_name = '';
		for (var i = 1; i < section_name_arr.length; i++)
			template_name += template_name === '' ? section_name_arr[i] : '_' + section_name_arr[i];
		//eval('mpl.front.content.tpl_' + template_name + '(atts, model)');
		switch (template_name) {
				case "section_video":
				case 'section_banner':
				mpl.front.content.tpl_section_banner(atts, model);
				break;
			case 'section_call_to_action':
				mpl.front.content.tpl_section_call_to_action(atts, model);
				break;
			case 'section_clients':
				mpl.front.content.tpl_section_clients(atts, model);
				break;
			case 'section_contact_1':
				mpl.front.content.tpl_section_contact_1(atts, model);
				break;
			case 'section_contact_4':
				mpl.front.content.tpl_section_contact_4(atts, model);
				break;
			case 'section_contact_5':
				mpl.front.content.tpl_section_contact_5(atts, model);
				break;
			case 'section_counter':
				mpl.front.content.tpl_section_counter(atts, model);
				break;
			case 'section_custom':
				mpl.front.content.tpl_section_custom(atts, model);
				break;
			case 'section_events':
				mpl.front.content.tpl_section_events(atts, model);
				break;
			case 'section_features':
				mpl.front.content.tpl_section_features(atts, model);
				break;
			case 'section_facebook':
				mpl.front.content.tpl_section_facebook(atts, model);
				break;
			case 'section_gallery':
				mpl.front.content.tpl_section_gallery(atts, model);
				break;
			case 'section_html':
				mpl.front.content.tpl_section_html(atts, model);
				break;
			case 'google_map':
				mpl.front.content.tpl_section_google_map(atts, model);
				break;
			case 'section_post':
				mpl.front.content.tpl_section_post(atts, model);
				break;
			case 'section_post_2':
				mpl.front.content.tpl_section_post_2(atts, model);
				break;
			case 'section_portfolio':
				mpl.front.content.tpl_section_portfolio(atts, model);
				break;
			case 'section_promo':
				mpl.front.content.tpl_section_promo(atts, model);
				break;
			case 'section_promo_2':
				mpl.front.content.tpl_section_promo2(atts, model);
				break;
			case 'section_pricing':
				mpl.front.content.tpl_section_pricing(atts, model);
				break;
			case 'section_pricing_2':
				mpl.front.content.tpl_section_pricing_2(atts, model);
				break;
			case 'section_service':
				mpl.front.content.tpl_section_service(atts, model);
				break;
			case 'section_service_4':
				mpl.front.content.tpl_section_service_4(atts, model);
				break;
			case 'section_service_5':
				mpl.front.content.tpl_section_service_5(atts, model);
				break;
			case 'section_showcase':
				mpl.front.content.tpl_section_showcase(atts, model);
				break;
			case 'section_skills':
				mpl.front.content.tpl_section_skills(atts, model);
				break;
			case 'section_skills_2':
				mpl.front.content.tpl_section_skills_2(atts, model);
				break;
			case 'section_slider':
				mpl.front.content.tpl_section_slider(atts, model);
				break;
			case 'section_team':
				mpl.front.content.tpl_section_team(atts, model);
				break;
			case 'section_testimonials':
				mpl.front.content.tpl_section_testimonials(atts, model);
				break;
			case 'section_woocommerce':
				mpl.front.content.tpl_section_woocommerce(atts, model);
				break;
			default:
				break;
		}
	},	
	render_video_background: function(code, id) {
		var output = '';
		var css = '';
		var video_type = '';

		if (code === '')
			return output;

		screens = JSON.parse(code.replace(/`/g, '"'));
		if (!screens['mpl-css'])
			return output;

		Object.keys(screens['mpl-css']).sort(function(a,b)
		{ 
			return a < b; 
		});
		for (var screen in screens['mpl-css']) {
			var groups = screens['mpl-css'][screen];

			for (var group in groups) {
				var properties = groups[group];
				for (var propertie in properties) {
					css = properties[propertie];
					var sel = propertie.split('|');

					if (sel[0] != 'video-background')
						continue;
					
					var decode_css = mpl.tools.base64.decode(css);
					var bgatts = JSON.parse(decode_css);

					if (bgatts['enable_video_bg'] != 'yes' && bgatts['enable_video_bg'] != '1')
						return output;

					output = 'data-property="{';
					var containment = '.mpl-css-' + id;
					//var containment = 'self';

					if (bgatts['video_type'] == 'youtube') {
						output += "videoURL:\'" + bgatts['video_url'] + "\',";
						video_type = 'mpl-youtube-video';
					}
					else if (bgatts['video_type'] == 'vimeo') {
						output += "videoURL:\'" + bgatts['video_url'] + "\',";
						video_type = 'mpl-vimeo-video';
					}
					else if (bgatts['video_type'] == 'html5') {
						output += "mp4URL:\'" + bgatts['mp4_url'] + "\',";
						output += "ogvURL:\'" + bgatts['ogv_url'] + "\',";
						output += "webmURL:\'" + bgatts['webm_url'] + "\',";
						video_type = 'mpl-html5-video';
					}					
					else
						output += '';
					output += 'containment:\'' + containment + '\',showControls:false';

					output += ',autoPlay:true';

					if (bgatts['video_loop'] == '1' || bgatts['video_loop'] == 'yes')
						output += ',loop:true';

					if (bgatts['video_mute'] !== '1' && bgatts['video_mute'] !== 'yes')
						output += ',mute:false';

					if (bgatts['start_time'] !== undefined && bgatts['start_time'] !== '')
						output += ',startAt:' + bgatts['start_time'];
					
					if (bgatts['stop_time'] !== undefined && bgatts['stop_time'] !== '') 
						output += ',stopAt:' + bgatts['stop_time'];
					
					output += ',opacity:1,addRaster:true,quality:\'default\'}"';						
					output = '<div id="bgndVideo" class="player ' + video_type +'" ' + output + '></div>';
				}
			}
		}
		return output;
	},
	render_element_css: function(code, id) {
		var css_code = '';
		var css_any_code = '';
		var css_desktop_code = '';
		var css = '';
		var corners_maps = {
			'margin'		: ['margin-top','margin-right','margin-bottom','margin-left'],
			'padding'		: ['padding-top','padding-right','padding-bottom','padding-left'],
			'border-radius' : ['border-top-left-radius','border-top-right-radius','border-bottom-right-radius','border-bottom-left-radius']
		};

		/*
		*	Decode JSON object
		*/		
		screens = JSON.parse(code.replace(/`/g, '"'));
		/*
		*	Sort screens
		*/
		if (screens['mpl-css'])
		{
			Object.keys(screens['mpl-css']).sort(function(a,b)
			{ 
				return a < b; 
			});
			for (var screen in screens['mpl-css']) {
				var groups = screens['mpl-css'][screen];
				var css_array = [];
				var css_code_itm = '';

				for (var group in groups) {
					var properties = groups[group];
					for (var propertie in properties) {
						css = properties[propertie];
						var sel = propertie.split('|');
						var prefix;
						var selector = [];
						
						if (sel[0] == 'gap')
							prefix = '';
						else
							prefix = 'body.mpl-css-system ';
						
						if (sel[1] !== '') {
							var _sels = sel[1].split(',');
							
							for (var _sel in _sels) {
								/*
								*	add spacing for selector which is not :hover
								*/
								_sel = mpl.tools.unesc(_sels[_sel]);
								if (_sel.trim().indexOf('+') === 0)
									_sel = _sel.trim().substr(1);
								else if (_sel.trim().indexOf(':') !== 0)
									_sel = ' ' + _sel.trim();
								selector.push(prefix + '.mpl-css-' + id + _sel);
							}
							selector = selector.join(',');
						}
						else if (sel[0] == 'gap') {
							// set low piorit for gap padding
							selector = '#page .mpl-css-' + id;
						}
						else {
							selector = prefix + '.mpl-css-' + id;
						}
						gap_selector = prefix + '.mpl-css-' + id + '>.mpl-wrap-columns';
						
						// group properties with same selector into one
						if (css_array[selector] === undefined)
							css_array[selector] = [];
						
						if (css_array[gap_selector] === undefined)
							css_array[gap_selector] = [];
						
						if (corners_maps[sel[0]] && css.indexOf('inherit')) {
							css = css.split(' ');
							for (var m = 0; m < 4; m++) {
								if (css[m] && css[m].trim() != 'inherit')
								{
									if (css[4])
										css[m] += ' ' + css[4];
									css_array[selector].push(corners_maps[sel[0]][m] + ': ' + css[m]);
								}
							}
						}
						else {
							if (sel[0] == 'gap') {
								if (parseInt(css, 10) < 0)
									css = '0px';
								css_array[selector].push('padding-left: ' + css + ';padding-right: ' + css);
								css_array[gap_selector].push('margin-left: -' + css + ';margin-right: -' + css + ';width: calc(100% + ' + (parseInt(css, 10) * 2) + 'px)');
							}
							else if(sel[0] == 'border') {
								if (css.indexOf('|') !== -1) {
									var css_line = '';
									css = css.split('|');
									bmap = ['top', 'right', 'bottom', 'left'];
									
									for (var cj = 0; cj < 4; cj++) {
										if (css[cj] && css[cj] !== '')
											css_line += 'border-' + bmap[cj] + ': ' + css[$cj] + ';';
									}
									css_array[selector].push(css_line);
								}
								else { 
									css_array[selector].push(sel[0] + ': ' + css);
								}
							}
							else if(sel[0] == 'custom') {
								css = css
											.replace(/[\"\'\[\]]/g, '')
											.trim() + '{{{end}}}';
								css = css
										.replace(/;{{{end}}}/g, '')
										.replace(/{{{end}}}/g, '');
								css_array[selector].push(css);
							}
							else if(sel[0] == 'background') {
								var css_obj = {
									'color': 'transparent', 
									'linearGradient' : ['',''],
									'image' : 'none', 
									'position' : '0% 0%', 
									'size' : 'auto', 
									'repeat' : 'repeat', 
									'attachment' : 'scroll', 
									'advanced' : 0,
									'parallax_scrolling' : 'no'
								}; 
								var val = '';
								var decode_css = mpl.tools.base64.decode(css);
								var json = JSON.parse(decode_css);
								
								if (json) {
									css_obj = Object.assign(css_obj, json);
									
									if (css_obj['parallax_scrolling'] == 'yes'){
										mpl._$(selector).addClass('mpl-parallax-scrolling');
									} else {
										mpl._$(selector).removeClass('mpl-parallax-scrolling');
									}

									if (css_obj['linearGradient'][0] !== '') {
										if (css_obj['linearGradient'][0].indexOf('deg') !== -1) {
											if (css_obj['linearGradient'][1] && css_obj['linearGradient'][1] !== '') {
												if (!css_obj['linearGradient'][2] || css_obj['linearGradient'][2] === '')
												{
													css_obj['linearGradient'][2] = css_obj['linearGradient'][1];
												}
											}
										}
										else if (!css_obj['linearGradient'][1] || css_obj['linearGradient'][1] === '')
											css_obj['linearGradient'][1] = css_obj['linearGradient'][0];
										
										css_obj['linearGradient'] = css_obj['linearGradient'].join(', ');
										css_obj['linearGradient'] = css_obj['linearGradient'].replace(/\, \,/g, ', ');
										val += 'linear-gradient(' + css_obj['linearGradient'] + ')';
									}
									
									if (css_obj['color'] != 'transparent' && css_obj['color'] !== '')
									{
										if( val === '' )
											val += css_obj['color'];
										else
											val += ', ' + css_obj['color'];
									}
									
									if (css_obj['image'] != 'none' && css_obj['image'] !== '')
									{
										if( val === '' )
											val += css_obj['color'];
										else if (css_obj['color'] == 'transparent' || css_obj['color'] === '')
											val += ', transparent';
										val += ' url(' + css_obj['image'] + ') ' + css_obj['position'] + '/' + css_obj['size'] + ' ' + css_obj['repeat'] + ' ' + css_obj['attachment'];
									}
									if (val !== '')
										css_array[selector].push(sel[0] + ': ' + val);
								}
								else if(css !== '') {
									css_array[selector].push(sel[0] + ': ' + css);
								}
							}
							else {
								css_array[selector].push(sel[0] + ': ' + css);
							}
						}
					}
				}
				
				for (var sel in css_array) {
					var pros = css_array[sel];
					if (pros !== '') {
						css_code_itm += sel + '{' + pros.join(';').replace(/[\{\}]/g,'') + ';}';
					}
				}
				if (screen != 'any')
				{
					if (screen.indexOf('-') === -1) {
						css_code += '@media only screen and (max-width: ' + screen.trim() + 'px){' + css_code_itm + '}';
					}
					else {
						screenx = screen.split('-');
						css_code += '@media only screen and (min-width: ' + screenx[0].trim() + 'px) and (max-width: ' + screenx[1].trim() + 'px){' + css_code_itm + '}';
					}
				}
				else {
					css_any_code += css_code_itm;
				}
				css_any_code += css_code_itm;
			}
		}
		//css_code = css_any_code.replace(/\%SITE_URL\%/g, mpl_site_url);
		css_code = mpl.tools.filter_images(css_any_code);

		return css_code;
	},
	update_section_to_body: function (html, model) {
		if (html) {
			//console.log(html);
			var section_elm = mpl._$('.mpl-content-wrap section[data-front-model="' + model + '"]');
			var new_html = mpl._$(html).attr('data-front-model', model);
			mpl._$(section_elm).replaceWith(new_html);
			$('#mpl-live-frame').get(0).contentWindow.mpl_front.refresh('.mpl-content-wrap section[data-front-model="' + model + '"]');
			mpl.front.addToolsListener();
		}
	},
	tpl_common_params: function ( data, atts ) {
		var el_class = [];
		var video_background = '';

		data['refresh_data'] = atts['refresh_data'];
		if (atts['css_custom'] && atts['css_custom'] !== '') {
			video_background = mpl.front.content.render_video_background(atts['css_custom'], atts._id);
		}

		data['video_background'] = video_background;

		el_class.push('mpl-elm');
		
		if (atts['_id']) {
			el_class.push('mpl-css-' + atts['_id']);
		}
		if (atts['css'])
			el_class.push(atts['css']);
		
		if (atts['section_class'])
			el_class.push(atts['section_class']);

		/*
		if (atts['animate'] && (atts['animate'] != '')) {
			ani = atts['animate'].split('|');
			if (ani[0])
				el_class.push('mpl-animated mpl-animate-eff-' + ani[0]);
			if (ani[1])
				el_class.push('mpl-animate-delay-' + ani[1]);
			if (ani[2])
				el_class.push('mpl-animate-speed-' + ani[2]);
		}
		*/
		data['section_class'] = el_class.join(' ');
		data['section_id'] = !atts['section_id'] ? "" : atts['section_id'];
		data['section_title'] = !atts['section_title'] ? "" : atts['section_title'];
		data['section_subtitle'] = !atts['section_subtitle'] ? "" : atts['section_subtitle'];
		if (atts['fullheight'] == 'yes') {
			data['fullheight'] = 'mpl-fullheight';
		}
		else {
			if (atts['slider_css'])
				data['section_height'] = 'style="height:' + atts['slider_css'] + 'px;"';
			else if (atts['section_height'])
				data['section_height'] = 'style="height:' + atts['section_height'] + 'px;"';
		}

		data['carousel'] = '';
		data['owl_options'] = '';
		data['owl_nav_style'] = '';
		if (atts['carousel'] && atts['carousel'] == 'yes') {
			var owl_options = {};
			owl_options['items'] = !atts['columns'] ? "1" : atts['columns'];
			owl_options['speed'] = !atts['owl_speed'] ? "" : atts['owl_speed'];
			owl_options['navigation'] = !atts['owl_navigation'] ? "" : atts['owl_navigation'];
			owl_options['pagination'] = !atts['owl_pagination'] ? "" : atts['owl_pagination'];
			owl_options['auto_height'] = !atts['owl_auto_height'] ? "" : atts['owl_auto_height'];
			owl_options['auto_play'] = !atts['owl_auto_play'] ? "" : atts['owl_auto_play'];

			data['carousel'] = "yes";
			data['owl_options'] = "data-owl-options='" + JSON.stringify(owl_options) + "'";
			data['owl_nav_style'] = '';
			if (atts['navigation'] && atts['navigation'] === 'yes') {
				data['owl_nav_style'] = 'owl-nav-' + atts['owl_nav_style'];
			}
		}
	},
	tpl_section_banner: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['content_align'] = !atts['content_align'] ? "" : 'text-' + atts['content_align'];
		data['title_style'] = !atts['title_style'] ? "" : atts['title_style'];
		data['btn_text_1'] = !atts['btn_text_1'] ? "" : atts['btn_text_1'];
		data['btn_text_2'] = !atts['btn_text_2'] ? "" : atts['btn_text_2'];
		if (atts['btn_link_1'] && atts['btn_link_1'] !== '') {
			data['link_url_1'] = !atts['btn_link_1'].split('||')[0] ? "#" : atts['btn_link_1'].split('||')[0];
			data['link_target_1'] = !atts['btn_link_1'].split('||')[1] ? "" : atts['btn_link_1'].split('||')[1];
		} else {
			data['link_url_1'] = '#';
			data['link_target_1'] = '';
		}
		if (atts['btn_link_2'] && atts['btn_link_2'] !== '') {
			data['link_url_2'] = !atts['btn_link_2'].split('||')[0] ? "#" : atts['btn_link_2'].split('||')[0];
			data['link_target_2'] = !atts['btn_link_2'].split('||')[1] ? "" : atts['btn_link_2'].split('||')[1];
		} else {
			data['link_url_2'] = '#';
			data['link_target_2'] = '';
		}
		//data['enable_social_icon'] = !atts['enable_social_icon'] ? "" : atts['enable_social_icon'];
		if (atts['social_icons'].length > 0)
			data['enable_social_icon'] = 'yes';
		else
			data['enable_social_icon'] = '';

		data['social_icons'] = [];
		for (var i = 0, count = atts['social_icons'].length; i < count; i++) {
			var obj = {};
			obj['icon'] = atts['social_icons'][i].icon_name;
			if (atts['social_icons'][i].icon_link) {
				var link_arr = atts['social_icons'][i].icon_link.split('|');

				if (link_arr[0])
					obj['link_url'] = link_arr[0];
			
				if (link_arr[1])
					obj['link_title'] = link_arr[1];
			
				if (link_arr[2])
					obj['link_target'] = link_arr[2];
			} else {
				obj['link_url'] = '#';
				obj['link_title'] = '';
				obj['link_target'] = '#';
			}
			data['social_icons'].push(obj);
		}		

		html = template('section_banner', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_call_to_action: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		
		data['title'] = !atts['title'] ? "" : atts['title'];
		data['content'] = !atts['content'] ? "" : atts['content'];
		data['text_align'] = !atts['text_align'] ? "" : atts['text_align'];
		data['btn_text'] = !atts['btn_text'] ? "" : atts['btn_text'];
		if (atts['btn_link'] && atts['btn_link'] !== '') {
			data['link_url'] = !atts['btn_link'].split('||')[0] ? "" : atts['btn_link'].split('||')[0];
			data['link_target'] = !atts['btn_link'].split('||')[1] ? "" : atts['btn_link'].split('||')[1];
		} else {
			data['link_url'] = '';
			data['link_target'] = '';
		}

		if (atts['btn_position'] == 'left') {
			html = template('section_call_to_action_style1', data);
		} else if (atts['btn_position'] == 'right') {
			html = template('section_call_to_action_style2', data);
		} else if (atts['btn_position'] == 'top') {
			html = template('section_call_to_action_style3', data);
		} else if (atts['btn_position'] == 'bottom') {
			html = template('section_call_to_action_style4', data);
		}

		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_clients: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['columns'] = !atts['columns'] ? "" : atts['columns'];
		data['client'] = [];
		for (var i = 0; i < atts['client'].length; i++) {
			var obj = {};
			obj['image'] = !atts['client'][i]['image'] ? "" : atts['client'][i]['image'];
			obj['link'] = !atts['client'][i]['link'] ? "" : atts['client'][i]['link'];
			obj['target'] = !atts['client'][i]['target'] ? "" : atts['client'][i]['target'];
			data['client'].push(obj);
		}			
		html = template('section_clients', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_contact_1: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['contact_name'] = !atts['contact_info_title'] ? "" : atts['contact_info_title'];
		data['contact_address'] = !atts['contact_address'] ? "" : atts['contact_address'];
		data['contact_email'] = !atts['contact_email'] ? "" : atts['contact_email'];
		data['contact_phone'] = !atts['contact_phone'] ? "" : atts['contact_phone'];
		data['contact_receiver'] = !atts['contact_receiver'] ? "" : atts['contact_receiver'];
		data['button_text'] = !atts['button_text'] ? "" : atts['button_text'];

		html = template('contact_style_1', data);

		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_contact_4: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['contact_name'] = !atts['contact_info_title'] ? "" : atts['contact_info_title'];
		data['contact_address'] = !atts['contact_address'] ? "" : atts['contact_address'];
		data['contact_email'] = !atts['contact_email'] ? "" : atts['contact_email'];
		data['contact_phone'] = !atts['contact_phone'] ? "" : atts['contact_phone'];
		data['contact_receiver'] = !atts['contact_receiver'] ? "" : atts['contact_receiver'];
		data['button_text'] = !atts['button_text'] ? "" : atts['button_text'];

		html = template('contact_style_4', data);

		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_contact_5: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['contact_name'] = !atts['contact_info_title'] ? "" : atts['contact_info_title'];
		data['contact_address'] = !atts['contact_address'] ? "" : atts['contact_address'];
		data['contact_email'] = !atts['contact_email'] ? "" : atts['contact_email'];
		data['contact_phone'] = !atts['contact_phone'] ? "" : atts['contact_phone'];
		data['contact_receiver'] = !atts['contact_receiver'] ? "" : atts['contact_receiver'];
		data['button_text'] = !atts['button_text'] ? "" : atts['button_text'];

		html = template('contact_style_5', data);

		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_counter: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['columns'] = !atts['columns'] ? "" : atts['columns'];
		data['counter'] = [];
		for (var i = 0; i < atts['counter'].length; i++) {
			var obj = {};
			obj['number'] = !atts['counter'][i]['number'] ? "" : atts['counter'][i]['number'];
			obj['title'] = !atts['counter'][i]['title'] ? "" : atts['counter'][i]['title'];
			data['counter'].push(obj);
		}
		html = template('section_counter', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_custom: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['content'] = atts['content'];
		html = template('section_custom', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_features: function (atts, model) {
		var data = {};
		var html = '';
		var obj = {};
		var i;

		mpl.front.content.tpl_common_params(data, atts);
		data['feature_image'] = !atts['feature_image'] ? "" : atts['feature_image'];
		if (!atts['icon_shape'] || atts['icon_shape'] == 'none') {
			data['icon_shape'] = '';
		} else {
			data['icon_shape'] = !atts['icon_shape'] ? "square" : atts['icon_shape'];
		}
		data['features_left'] = [];
		var left_count = Math.ceil(atts['feature'].length / 2);
		var right_count = atts['feature'].length;
		for (i = 0; i < left_count; i++) {
			obj = {};
			obj['icon'] = !atts['feature'][i]['icon'] ? "fa-coffee" : atts['feature'][i]['icon'];
			obj['icon_color'] = !atts['feature'][i]['icon_color'] ? "#595959" : atts['feature'][i]['icon_color'];
			obj['link_url'] = !atts['feature'][i]['title_link'].split('||')[0] ? "" : atts['feature'][i]['title_link'].split('||')[0];
			obj['link_target'] = !atts['feature'][i]['title_link'].split('||')[1] ? "" : atts['feature'][i]['title_link'].split('||')[1];
			obj['title'] = !atts['feature'][i]['title'] ? "" : atts['feature'][i]['title'];
			obj['description'] = !atts['feature'][i]['description'] ? "" : atts['feature'][i]['description'];
			data['features_left'].push(obj);
		}
		data['features_right'] = [];
		for (i = left_count; i < right_count; i++) {
			obj = {};
			obj['icon'] = !atts['feature'][i]['icon'] ? "fa-coffee" : atts['feature'][i]['icon'];
			obj['icon_color'] = !atts['feature'][i]['icon_color'] ? "#595959" : atts['feature'][i]['icon_color'];
			obj['link_url'] = !atts['feature'][i]['title_link'].split('||')[0] ? "" : atts['feature'][i]['title_link'].split('||')[0];
			obj['link_target'] = !atts['feature'][i]['title_link'].split('||')[1] ? "" : atts['feature'][i]['title_link'].split('||')[1];
			obj['title'] = !atts['feature'][i]['title'] ? "" : atts['feature'][i]['title'];
			obj['description'] = !atts['feature'][i]['description'] ? "" : atts['feature'][i]['description'];
			data['features_right'].push(obj);
		}
		html = template('section_features', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_gallery: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['columns'] = !atts['columns'] ? "" : atts['columns'];
		if (atts['section_lightbox'] && atts['section_lightbox'] == 'yes') {
			data['lightbox'] = 'yes';
		}
		else {
			data['lightbox'] = '';
		}
		if (atts['fullwidth'] && atts['fullwidth'] == 'yes') {
			data['container'] = 'mpl-container-fullwidth';
		}
		else {
			data['container'] = 'mpl-container';
		}
		data['items'] = [];
		for (var i = 0; i < atts['items'].length; i++) {
			var obj = {};
			obj['image'] = !atts['items'][i]['image'] ? "" : atts['items'][i]['image'];
			obj['link'] = !atts['items'][i]['link'] ? "" : atts['items'][i]['link'];
			data['items'].push(obj);
		}			
		html = template('section_gallery', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_html: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['content'] = atts['content'];
		html = template('section_html', data);
		$.ajax({
			url: mpl_ajax_url,
			method: 'POST',
			dataType: 'html',
			data: {action:'mpl_do_shortcode', content:html,echo:true},
			success: function(response_html) {
				mpl.front.content.update_section_to_body(response_html, model);
			},
			error: function(){
				mpl.front.content.update_section_to_body(html, model);
				}
		});

		
	},
   
	tpl_section_google_map: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		atts['slider_css'] = '';
		if (atts['map_height'] && atts['map_height'] !== '' && parseInt(atts['map_height'], 10) > 0 ) {
			atts['slider_css'] = 'style="height:' + parseInt(atts['map_height'], 10) + 'px;"';
		}
		if (atts['fullwidth'] && atts['fullwidth'] == 'yes') {
			data['container'] = 'mpl-container-fullwidth';
		}
		else {
			data['container'] = 'mpl-container';
		}
		if (atts['animation'] && atts['animation'] == 'yes')
			data['animation'] = 'true';
		else
			data['animation'] = 'false';

		data['embed_map'] = atts['embed_map'].replace(/width="\d+"/i, 'width="100%"').replace(/height="\d+"/i, 'height="' + parseInt(atts['map_height'], 10) + '"');
		html = template('section_google_map', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_portfolio: function (atts, model) {
		var data = {};
		var html = '';
		var owl_options = {};
		var request_data = {};

		mpl.front.content.tpl_common_params(data, atts);
		data['columns'] = !atts['columns'] ? "" : atts['columns'];
		data['filter'] = !atts['filter'] ? "" : atts['filter'];
		if (atts['fullwidth'] && atts['fullwidth'] == 'yes') {
			data['container'] = 'mpl-container-fullwidth';
		}
		else {
			data['container'] = 'mpl-container';
		}
		if (atts['no_padding'] && atts['no_padding'] == 'yes') {
			data['full'] = 'full';
		} else {
			data['full'] = '';
		}
		data['i18n_all'] = 'All';
		request_data['post_taxonomy'] = 'mpl-portfolio-category';
		request_data['order_by'] = !atts['order_by'] ? "" : atts['order_by'];
		request_data['order_list'] = !atts['order_list'] ? "" : atts['order_list'];
		request_data['number_post'] = !atts['number_post'] ? "" : atts['number_post'];
		request_data['thumbnail'] = 'yes';
		request_data['image_size'] = 'full';
		request_data['show_date'] = '';
		request_data['wrap_class'] = '';
		request_data['post_type'] = 'mpl-portfolio';
		request_data['pagination'] = '';
		var request_json = JSON.stringify(request_data);
		$.ajax({
			url: mpl_ajax_url,
			method: 'POST',
			dataType: 'html',
			data: {action:'mpl_get_recent_posts_data', request_json: request_json},
			success: function(response_json) {
				response_data = JSON.parse(response_json);
				data['posts'] = response_data['data'];
				data['categories'] = response_data['categories'];
				html = template('section_portfolio', data);
				mpl.front.content.update_section_to_body(html, model);
			}
		});
	},
	tpl_section_post: function (atts, model) {
		var data = {};
		var html = '';
		var owl_options = {};
		var request_data = {};
		
		mpl.front.content.tpl_common_params(data, atts);
		data['columns'] = !atts['columns'] ? "" : atts['columns'];
		request_data['post_taxonomy'] = 'post';
		request_data['order_by'] = !atts['order_by'] ? "" : atts['order_by'];
		request_data['order_list'] = !atts['order_list'] ? "" : atts['order_list'];
		request_data['number_post'] = !atts['number_post'] ? "" : atts['number_post'];
		request_data['thumbnail'] = !atts['thumbnail'] ? "" : atts['thumbnail'];	//yes
		request_data['image_size'] = !atts['image_size'] ? "" : atts['image_size'];
		request_data['show_date'] = !atts['show_date'] ? "" : atts['show_date'];
		var request_json = JSON.stringify(request_data);
		$.ajax({
			url: mpl_ajax_url,
			method: 'POST',
			dataType: 'html',
			data: {action:'mpl_get_recent_posts_data', request_json: request_json},
			success: function(response_json) {
				response_data = JSON.parse(response_json);
				data['posts'] = response_data['data'];
				html = template('section_post', data);
				mpl.front.content.update_section_to_body(html, model);
			}
		});
	},
	tpl_section_post_2: function (atts, model) {
		var data = {};
		var html = '';
		var owl_options = {};
		var request_data = {};
		
		atts['carousel'] = 'yes';
		mpl.front.content.tpl_common_params(data, atts);
		request_data['post_taxonomy'] = 'post';
		request_data['order_by'] = !atts['order_by'] ? "" : atts['order_by'];
		request_data['order_list'] = !atts['order_list'] ? "" : atts['order_list'];
		request_data['number_post'] = !atts['number_post'] ? "" : atts['number_post'];
		request_data['thumbnail'] = !atts['thumbnail'] ? "" : atts['thumbnail'];	//yes
		request_data['image_size'] = !atts['image_size'] ? "" : atts['image_size'];
		request_data['show_date'] = !atts['show_date'] ? "" : atts['show_date'];
		var request_json = JSON.stringify(request_data);
		$.ajax({
			url: mpl_ajax_url,
			method: 'POST',
			dataType: 'html',
			data: {action:'mpl_get_recent_posts_data', request_json: request_json},
			success: function(response_json) {
				response_data = JSON.parse(response_json);
				data['posts'] = response_data['data'];
				html = template('section_post_2', data);
				mpl.front.content.update_section_to_body(html, model);
			}
		})
	},	
	tpl_section_pricing: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['columns'] = !atts['columns'] ? "" : atts['columns'];
		data['items'] = [];
		for (var i = 0; i < atts['items'].length; i++) {
			var obj = {};
			if (atts['items'][i]['featured'] && atts['items'][i]['featured'] === 'yes') {
				obj['featured'] = 'mpl-featured';
				obj['dark'] = 'dark';
			} else {
				obj['featured'] = '';
				obj['dark'] = '';
			}
			obj['title'] = !atts['items'][i]['title'] ? "" : atts['items'][i]['title'];
			obj['currency'] = !atts['items'][i]['currency'] ? "" : atts['items'][i]['currency'];
			obj['price'] = !atts['items'][i]['price'] ? "" : atts['items'][i]['price'];
			obj['unit'] = !atts['items'][i]['unit'] ? "" : atts['items'][i]['unit'];
			obj['list'] = '';
			if (atts['items'][i]['list'] && atts['items'][i]['list'] !== '') {
				var list = atts['items'][i]['list'].split('\n');
				for (var j = 0, count = list.length; j < count; j++) {
					obj['list'] += '<li>' + list[j] + '</li>';
				}
			}
			obj['btn_text'] = !atts['items'][i]['btn_text'] ? "" : atts['items'][i]['btn_text'];
			if (atts['items'][i]['btn_link'] && atts['items'][i]['btn_link'] !== '') {
				obj['btn_link'] = !atts['items'][i]['btn_link'].split('||')[0] ? "" : atts['items'][i]['btn_link'].split('||')[0];
				obj['btn_target'] = !atts['items'][i]['btn_link'].split('||')[1] ? "" : atts['items'][i]['btn_link'].split('||')[1];
			} else {
				obj['btn_link'] = '';
				obj['link_target'] = '';
			}
			data['items'].push(obj);
		}
		html = template('section_pricing', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_pricing_2: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['columns'] = !atts['columns'] ? "" : atts['columns'];
		data['items'] = [];
		for (var i = 0; i < atts['items'].length; i++) {
			var obj = {};
			if (atts['items'][i]['featured'] && atts['items'][i]['featured'] === 'yes') {
				obj['featured'] = 'mpl-featured';
				obj['dark'] = 'dark';
			} else {
				obj['featured'] = '';
				obj['dark'] = '';
			}
			obj['title'] = !atts['items'][i]['title'] ? "" : atts['items'][i]['title'];
			obj['icon'] = !atts['items'][i]['icon'] ? "fa-diamond" : atts['items'][i]['icon'];
			obj['currency'] = !atts['items'][i]['currency'] ? "" : atts['items'][i]['currency'];
			obj['price'] = !atts['items'][i]['price'] ? "" : atts['items'][i]['price'];
			obj['unit'] = !atts['items'][i]['unit'] ? "" : atts['items'][i]['unit'];
			obj['list'] = '';
			if (atts['items'][i]['list'] && atts['items'][i]['list'] !== '') {
				var list = atts['items'][i]['list'].split('\n');
				for (var j = 0, count = list.length; j < count; j++) {
					obj['list'] += '<li>' + list[j] + '</li>';
				}
			}
			obj['btn_text'] = !atts['items'][i]['btn_text'] ? "" : atts['items'][i]['btn_text'];
			if (atts['items'][i]['btn_link'] && atts['items'][i]['btn_link'] !== '') {
				obj['btn_link'] = !atts['items'][i]['btn_link'].split('||')[0] ? "" : atts['items'][i]['btn_link'].split('||')[0];
				obj['btn_target'] = !atts['items'][i]['btn_link'].split('||')[1] ? "" : atts['items'][i]['btn_link'].split('||')[1];
			} else {
				obj['btn_link'] = '';
				obj['link_target'] = '';
			}
			data['items'].push(obj);
		}
		html = template('section_pricing_2', data);
		mpl.front.content.update_section_to_body(html, model);
	},	
	tpl_section_promo: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);

		data['content_position'] = !atts['content_position'] ? "" : atts['content_position'];
		data['image_align'] = !atts['image_align'] ? "" : 'text-' + atts['image_align'];
		data['image'] = !atts['image'] ? "" : atts['image'];
		data['desc'] = !atts['desc'] ? "" : atts['desc'];
		data['button_text'] = !atts['button_text'] ? "" : atts['button_text'];
		data['link_url'] = !atts['link_url'] ? "" : atts['link_url'];
		data['link_target'] = !atts['link_target'] ? "" : atts['link_target'];

		html = template('section_promo', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_promo2: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		
		data['image'] = !atts['image'] ? "" : atts['image'];
		data['image_align'] = !atts['image_align'] ? "" : atts['image_align'];
		data['desc'] = !atts['desc'] ? "" : atts['desc'];
		data['button_text'] = !atts['button_text'] ? "" : atts['button_text'];
		data['link_url'] = !atts['button_link'].split('||')[0] ? "" : atts['button_link'].split('||')[0];
		data['link_target'] = !atts['button_link'].split('||')[1] ? "" : atts['button_link'].split('||')[1];
		var layout = (!atts['layout'] || atts['layout'] === '') ? 'left' : atts['layout'];
		if (layout == 'left') {
			html = template('section_promo2_style1', data);
		} else if (layout == 'right') {
			html = template('section_promo2_style2', data);
		} else if (layout == 'top') {
			html = template('section_promo2_style3', data);
		} else if (layout == 'bottom') {
			html = template('section_promo2_style4', data);
		}

		mpl.front.content.update_section_to_body(html, model);
	},
	
	tpl_section_service: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['columns'] = !atts['columns'] ? "" : atts['columns'];
		data['services'] = [];
		var icon_type = !atts['icon_type'] ? 'icon' : atts['icon_type'];
		var image_width = !atts['image_width'] ? '100' : atts['image_width'];
		data['image_margin_left'] = icon_type == 'icon' ? '' : 'style="margin-left:' + (Number(image_width) + 20) + 'px;"';
		for (var i = 0; i < atts['services'].length; i++) {
			var obj = {};
			var icon = !atts['services'][i]['icon'] ? "fa-coffee" : atts['services'][i]['icon'];
			//obj['shape'] = !atts['icon_shape'] ? "square" : atts['icon_shape'];
			var shape = '';
			var icon_style = '';
			var icon_color = !atts['services'][i]['icon_color'] ? "#595959" : atts['services'][i]['icon_color'];
			var image = !atts['services'][i]['image'] ? "#" : atts['services'][i]['image'];

			if (icon_type == 'icon') {
				if (atts['icon_shape'] && atts['icon_shape'] == 'none') {
					icon_style = 'color';
					shape = '';
				} else  {
					icon_style = 'background-color';
					shape = atts['icon_shape'];
				}
				obj['icon_html'] = '<i class="fa ' + icon + ' ' + shape + '" style="' + icon_style + ':' + icon_color + ';"></i>';
			}
			else {
				obj['icon_html'] = '<image style="width:' + image_width + 'px;" src="' + image + '">';
			}
			obj['icon_color'] = icon_color;
			obj['link_url'] = !atts['services'][i]['title_link'].split('||')[0] ? "" : atts['services'][i]['title_link'].split('||')[0];
			obj['link_target'] = !atts['services'][i]['title_link'].split('||')[1] ? "" : atts['services'][i]['title_link'].split('||')[1];
			obj['title'] = !atts['services'][i]['title'] ? "" : atts['services'][i]['title'];
			obj['description'] = !atts['services'][i]['description'] ? "" : atts['services'][i]['description'];
			data['services'].push(obj);
		}
		if (atts['layout'] == '1') {
			html = template('section_service_1', data);
		}
		else if (atts['layout'] == '2') {
			html = template('section_service_2', data);
		}
		else if (atts['layout'] == '3') {
			html = template('section_service_3', data);
		}

		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_service_4: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['columns'] = !atts['columns'] ? "" : atts['columns'];
		data['services'] = [];
		for (var i = 0; i < atts['services'].length; i++) {
			var obj = {};
			var icon = !atts['services'][i]['icon'] ? "fa-coffee" : atts['services'][i]['icon'];
			var icon_color = !atts['services'][i]['icon_color'] ? "#595959" : atts['services'][i]['icon_color'];
			obj['icon_html'] = '<i class="fa ' + icon + ' circle" style="background-color:' + icon_color + ';"></i>';

			obj['icon_color'] = icon_color;
			obj['link_url'] = !atts['services'][i]['title_link'].split('||')[0] ? "" : atts['services'][i]['title_link'].split('||')[0];
			obj['link_target'] = !atts['services'][i]['title_link'].split('||')[1] ? "" : atts['services'][i]['title_link'].split('||')[1];
			obj['title'] = !atts['services'][i]['title'] ? "" : atts['services'][i]['title'];
			obj['description'] = !atts['services'][i]['description'] ? "" : atts['services'][i]['description'];
			data['services'].push(obj);
		}
		html = template('section_service_4', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_service_5: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['columns'] = !atts['columns'] ? "" : atts['columns'];
		data['services'] = [];
		for (var i = 0; i < atts['services'].length; i++) {
			var obj = {};
			var icon = !atts['services'][i]['icon'] ? "fa-coffee" : atts['services'][i]['icon'];
			var icon_color = !atts['services'][i]['icon_color'] ? "#595959" : atts['services'][i]['icon_color'];
			obj['icon_html'] = '<i class="fa ' + icon + '" style="color:' + icon_color + ';"></i>';

			obj['icon_color'] = icon_color;
			obj['link_url'] = !atts['services'][i]['title_link'].split('||')[0] ? "" : atts['services'][i]['title_link'].split('||')[0];
			obj['link_target'] = !atts['services'][i]['title_link'].split('||')[1] ? "" : atts['services'][i]['title_link'].split('||')[1];
			obj['title'] = !atts['services'][i]['title'] ? "" : atts['services'][i]['title'];
			obj['description'] = !atts['services'][i]['description'] ? "" : atts['services'][i]['description'];
			data['services'].push(obj);
		}
		html = template('section_service_5', data);
		mpl.front.content.update_section_to_body(html, model);
	},	 
	tpl_section_showcase: function (atts, model) {
		var data = {};
		var html = '';

		atts['carousel'] = 'yes';
		atts['columns'] = 4;
		atts['owl_speed'] = 500;
		atts['owl_navigation'] = false;
		atts['owl_pagination'] = true;
		atts['owl_auto_height'] = true;
		atts['owl_auto_play'] = true;
		mpl.front.content.tpl_common_params(data, atts);
		data['desc'] = !atts['desc'] ? "" : atts['desc'];
		data['button_text'] = !atts['button_text'] ? "" : atts['button_text'];
		if (atts['title_link']) {
			data['button_link'] = !atts['title_link'].split('||')[0] ? "" : atts['title_link'].split('||')[0];
			data['button_target'] = !atts['title_link'].split('||')[1] ? "" : atts['title_link'].split('||')[1];
		} else {
			data['button_link'] = '';
			data['button_target'] = '';
		}
		data['gallery'] = [];
		for (var i = 0; i < atts['gallery'].length; i++) {
			var obj = {};
			obj['image'] = !atts['gallery'][i]['image'] ? "" : atts['gallery'][i]['image'];
			obj['title'] = !atts['gallery'][i]['title'] ? "" : atts['gallery'][i]['title'];
			obj['description'] = !atts['gallery'][i]['description'] ? "" : atts['gallery'][i]['description'];
			data['gallery'].push(obj);
		}
		html = template('section_showcase', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_skills: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['columns'] = !atts['columns'] ? "" : atts['columns'];
		data['items'] = [];
		for (var i = 0; i < atts['items'].length; i++) {
			var obj = {};
			obj['i'] = i;
			obj['percent'] = !atts['items'][i]['percent'] ? "0" : atts['items'][i]['percent'];
			obj['barcolor'] = !atts['items'][i]['barcolor'] ? "#f33b3d" : atts['items'][i]['barcolor'];
			obj['title'] = !atts['items'][i]['title'] ? "" : atts['items'][i]['title'];
			obj['desc'] = !atts['items'][i]['desc'] ? "" : atts['items'][i]['desc'];
			data['items'].push(obj);
		}
		html = template('section_skills', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_skills_2: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['left_promo'] = !atts['left_promo'] ? "" : atts['left_promo'];
		data['btn_text'] = !atts['btn_text'] ? "" : atts['btn_text'];
		if (atts['btn_link'] && atts['btn_link'] !== '') {
			data['btn_link'] = !atts['btn_link'].split('||')[0] ? "" : atts['btn_link'].split('||')[0];
			data['btn_target'] = !atts['btn_link'].split('||')[1] ? "" : atts['btn_link'].split('||')[1];
		} else {
			data['btn_link'] = '';
			data['btn_target'] = '';
		}
		data['items'] = [];
		for (var i = 0; i < atts['items'].length; i++) {
			var obj = {};
			obj['title'] = !atts['items'][i]['title'] ? "" : atts['items'][i]['title'];
			obj['percent'] = !atts['items'][i]['percent'] ? "0" : atts['items'][i]['percent'];
			data['items'].push(obj);
		}
		html = template('section_skills_2', data);
		mpl.front.content.update_section_to_body(html, model);
	},		
	tpl_section_slider: function (atts, model) {
		var data = {};
		var html = '';

		atts['carousel'] = 'yes';
		atts['owl_navigation'] = 'yes';
		atts['owl_nav_style'] = 'arrow';

		mpl.front.content.tpl_common_params(data, atts);
		data['mpl_slider'] = atts['slides'].length > 1 ? 'mpl-slider' : '';
		data['sliders'] = [];
		for (var i = 0; i < atts['slides'].length; i++) {
			var obj = {};
			obj['image'] = !atts['slides'][i]['image'] ? "" : atts['slides'][i]['image'];
			obj['title'] = !atts['slides'][i]['title'] ? "" : atts['slides'][i]['title'];
			obj['title_style'] = !atts['slides'][i]['title_style'] ? "" : atts['slides'][i]['title_style'];
			obj['subtitle'] = !atts['slides'][i]['subtitle'] ? "" : atts['slides'][i]['subtitle'];
			obj['content_align'] = !atts['slides'][i]['content_align'] ? "" : atts['slides'][i]['content_align'];
			obj['btn_text_1'] = !atts['slides'][i]['btn_text_1'] ? "" : atts['slides'][i]['btn_text_1'];
			obj['btn_text_2'] = !atts['slides'][i]['btn_text_2'] ? "" : atts['slides'][i]['btn_text_2'];
			if (atts['slides'][i]['btn_link_1'] && atts['slides'][i]['btn_link_1'] !== '') {
				obj['link_url_1'] = !atts['slides'][i]['btn_link_1'].split('||')[0] ? "#" : atts['slides'][i]['btn_link_1'].split('||')[0];
				obj['link_target_1'] = !atts['slides'][i]['btn_link_1'].split('||')[1] ? "" : atts['slides'][i]['btn_link_1'].split('||')[1];
			} else {
				obj['link_url_1'] = '#';
				obj['link_target_1'] = '';
			}
			if (atts['slides'][i]['btn_link_2'] && atts['slides'][i]['btn_link_2'] !== '') {
				obj['link_url_2'] = !atts['slides'][i]['btn_link_2'].split('||')[0] ? "#" : atts['slides'][i]['btn_link_2'].split('||')[0];
				obj['link_target_2'] = !atts['slides'][i]['btn_link_2'].split('||')[1] ? "" : atts['slides'][i]['btn_link_2'].split('||')[1];
			} else {
				obj['link_url_2'] = '#';
				obj['link_target_2'] = '';
			}			
			data['sliders'].push(obj);
		}
		html = template('section_slider', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_team: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['columns'] = !atts['columns'] ? "" : atts['columns'];
		data['persons'] = [];
		for (var i = 0; i < atts['persons'].length; i++) {
			var obj = {};
			obj['image'] = !atts['persons'][i]['image'] ? "" : atts['persons'][i]['image'];
			obj['name'] = !atts['persons'][i]['name'] ? "" : atts['persons'][i]['name'];
			obj['title'] = !atts['persons'][i]['title'] ? "" : atts['persons'][i]['title'];
			obj['desc'] = !atts['persons'][i]['desc'] ? "" : atts['persons'][i]['desc'];
			obj['social_1'] = !atts['persons'][i]['social_1'] ? "" : atts['persons'][i]['social_1'];
			obj['social_2'] = !atts['persons'][i]['social_2'] ? "" : atts['persons'][i]['social_2'];
			obj['social_3'] = !atts['persons'][i]['social_3'] ? "" : atts['persons'][i]['social_3'];
			obj['social_4'] = !atts['persons'][i]['social_4'] ? "" : atts['persons'][i]['social_4'];
			obj['social_1_link'] = !atts['persons'][i]['social_1_link'].split('||')[0] ? "" : atts['persons'][i]['social_1_link'].split('||')[0];
			obj['social_2_link'] = !atts['persons'][i]['social_2_link'].split('||')[0] ? "" : atts['persons'][i]['social_2_link'].split('||')[0];
			obj['social_3_link'] = !atts['persons'][i]['social_3_link'].split('||')[0] ? "" : atts['persons'][i]['social_3_link'].split('||')[0];
			obj['social_4_link'] = !atts['persons'][i]['social_4_link'].split('||')[0] ? "" : atts['persons'][i]['social_4_link'].split('||')[0];
			data['persons'].push(obj);
		}
		html = template('section_team', data);
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_testimonials: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);
		data['columns'] = !atts['columns'] ? "" : atts['columns'];
		data['testimonials'] = [];
		for (var i = 0; i < atts['testimonials'].length; i++) {
			var obj = {};
			obj['image'] = !atts['testimonials'][i]['image'] ? "" : atts['testimonials'][i]['image'];
			obj['name'] = !atts['testimonials'][i]['name'] ? "" : atts['testimonials'][i]['name'];
			obj['title'] = !atts['testimonials'][i]['title'] ? "" : atts['testimonials'][i]['title'];
			obj['desc'] = !atts['testimonials'][i]['desc'] ? "" : atts['testimonials'][i]['desc'];
			data['testimonials'].push(obj);
		}
		if (atts['layout'] == '1')
			html = template('section_testimonials_1', data);
		else if (atts['layout'] == '2')
			html = template('section_testimonials_2', data);
		else if (atts['layout'] == '3')
			html = template('section_testimonials_3', data);
		else
			html = '';
		mpl.front.content.update_section_to_body(html, model);
	},
	tpl_section_woocommerce: function (atts, model) {
		var data = {};
		var html = '';

		mpl.front.content.tpl_common_params(data, atts);

		var shortcode = '[recent_products';
		if (atts['per_page'] && atts['per_page'] !== '') 
			shortcode += " per_page=" + atts['per_page'];
		
		if (atts['columns'] && atts['columns'] !== '') 
			shortcode += " columns=" + atts['columns'];

		if (atts['orderby'] && atts['orderby'] !== '') 
			shortcode += " orderby=" + atts['orderby'];

		if (atts['order'] && atts['order'] !== '') 
			shortcode += " order=" + atts['order'];
		shortcode += ']';

		$.ajax({
			url: mpl_ajax_url,
			method: 'POST',
			dataType: 'html',
			data: { action: 'mpl_front_section_data', shortcode: shortcode },
			success: function (woocommerce) {
				data['woocommerce'] = woocommerce;
				html = template('section_woocommerce', data);
				mpl.front.content.update_section_to_body(html, model);
			}
		});
	},
},

}, mpl.front);

mpl.front = $.extend({

model: 1,
id: null,
cancel_value: false,
save_value: false,
section_name_pos: 0,
section_css_pos: 2,
frame: null,

init: function () {

	if (typeof (mpl_maps) == 'undefined')
		return;

	mpl.frontend = 'yes';
	mpl.tags = shortcode_tags;
	mpl.maps = mpl_maps;

	$('#wpadminbar,#wpfooter,#adminmenuwrap,#adminmenuback,#adminmenumain,#screen-meta,.notice').remove();

	mpl._$ = $('#mpl-live-frame').get(0).contentWindow.jQuery;

	mpl._$('.mpl-content-wrap .mpl-elm').each(function (index) {
		$(this).attr('data-front-model', ++index);
	});

	var new_content = mpl.tools.base64.decode(mpl_post_content);

	if (new_content.indexOf('[mpl_row') > 0) {
		new_content = new_content.substring(new_content.indexOf('[mpl_row'));
		// reverse string to check ending
		new_content = mpl.tools.reverse(new_content);
		if (new_content.indexOf(']wor_lpm/[') > 0) {
			new_content = new_content.substring(new_content.indexOf(']wor_lpm/['));
		}
		// reverse back
		new_content = mpl.tools.reverse(new_content);
	}
	/*end*/

	if (new_content && new_content !== '')
		mpl.params.process_rows(new_content);

	mpl.front.addToolsListener();

	mpl.trigger({
		el: $('#mpladminbar .mpl-bar-right'),
		events: {
			'.desktop:click': 'desktop_szie',
			'.tablet:click': 'tablet_szie',
			'.mobile:click': 'mobile_szie',
			'.page_options:click': 'page_options',
			'.remove:click': 'remove',
			'.import:click': mpl.views.builder.sections,
			'.add:click': mpl.backbone.add,
			'.save:click': 'save',
			'.exit:click': 'exit',
		},
		desktop_szie: function() {
			$('#mpl-live-frame').css("left", 0).width($(window).width()).show(); 
		},
		tablet_szie: function() {
			$('#mpl-live-frame').css("left", $(window).width() / 2 - (800 / 2)).width(800).show(); 
		},
		mobile_szie: function() {
			$('#mpl-live-frame').css("left", $(window).width() / 2 - (480 / 2)).width(480).show(); 
		},
		remove: function () {
			mpl.msgbox('Are you sure you want to remove all sections?', function() {
				mpl._$('#mpl-css-render').html('');
				mpl._$('.mpl-content-wrap').children().each(function () {
					mpl._$(this).remove();
					mpl.front.model = 1;
					mpl.front.id = null;
				});
			});
		},

		exit: function (e) {
			window.location = mpl_post_url;
		},

		save: function () {
			mpl.front.submit();
		},

		page_options: function (e) {
			mpl.views.builder.post_settings(e);
		},		
	});
},

backbone: {
	double: function (e, exp) {
		if (e === undefined)
			return false;

		var el = (typeof (e.tagName) != 'undefined') ? e : this;
		var id = mpl.front.get.front_model(el),
			data = mpl.storage[id][2],
			cdata = $().extend(true, {}, data),
			cel, func, is_col = (['mpl_column', 'mpl_column_inner'].indexOf(data.name) > -1);

		cdata.args._id = Math.round(Math.random() * 1000000);

		if (exp === undefined)
			var exp = mpl.front.export(id);

		if (data.name != 'mpl_column_text')
			cdata.args.content = mpl.params.process_alter(exp.content, data.name);

		cdata.model = mpl.model++;

		if (data.name == 'mpl_row') {
			cel = mpl.views.row.render(cdata, true);
		}
		else if (data.name == 'mpl_column') {
			cel = mpl.views.column.render(cdata, true);
		}
		else if (mpl.tags.indexOf(cdata.name)) {
			try {
				func = mpl.maps[cdata.name].views.type;
			} catch (ex) {
				func = cdata.name;
			}
			if (typeof mpl.views[func] == 'object')
				cel = mpl.views[func].render(cdata);
			else cel = mpl.views.mpl_element.render(cdata);

		}
		else {
			cel = mpl.views.
				mpl_undefined
				.render({
					args: { content: cdata.content },
					name: 'mpl_undefined',
					end: '[/mpl_undefined]',
					full: cdata.content
				});
		}

		if (is_col)
			mpl.views.column.reset_view(el.parent());

		mpl.ui.sortInit();

		return cdata.args._id;
	}
},

ui: {
	elements: {
		edit: function (e) {
			var pop = mpl.backbone.settings(e);
			setTimeout(function () {
				//mpl.front.stack.init_atts = mpl.front.tools.getFormData(pop);
				mpl.front.stack.init_atts = mpl.tools.getFormData(pop, false);
			}, 1000);

			if (!pop) {
				alert(mpl.__.i43);
				return;
			}

			$(this).closest('.mpl-element').addClass('editting');
			pop.data({
				cancel: function (pop) {
					$(pop.data('button')).closest('.mpl-element').removeClass('editting');
				},
				after_callback: function (pop) {
					var id = pop.data('model'),
						params = mpl.storage[id][0],
						map = $().extend({}, mpl.maps._std),
						el = $('#model-' + id);

					map = $().extend(map, mpl.maps[params.name]);
					el.find('>.admin-view').remove();
					el.append(mpl.params.admin_label.render({ map: map, params: params, el: el }));
					mpl.front.content.render_section_template(pop, true);
					//magee
				},
			});

			mpl.tools.popup.callback(pop, {
				change: mpl.front.content.change_callback,
				css_change: mpl.front.content.css_change_callback
			});
		}
	}
},

get: {
	front_model: function (el) {
		return mpl._$(el).closest('.mpl-elm').attr('data-front-model');
	}
},

stack: {
	init_atts: null,
	init_css: {},
},

submit: function () {

	$('#mpl-page-cfg-mode').val(mpl.cfg.mode);
	$('#mpl-container').find('form,input,select,textarea').remove();
	var content = '';

	mpl.msg(mpl.__.processing, 'loading');

	document.raw_title = document.title;
	document.title = 'Saving...';

	mpl._$('.mpl-elm').each(function () {
		var id = mpl._$(this).attr('data-front-model');
		var exp = mpl.front.export(id);
		content += exp.begin + exp.content + exp.end;
	});
	
	content = content.replace('<p>[' , '[');
	content = content.replace(']</p>' ,']');
	content = content.replace(']<br />',']');
	content = content.replace(']<br>', ']');
	content = content.replace(']\r\n', ']');
	content = content.replace(']\n', ']');
	content = content.replace(']\r', ']');
	content = content.replace('\r\n[', '[');

	$('#content').val(content);
	try {
		tinyMCE.get('content').setContent(content);
	} catch (ex) { }
	
	$.post(
		mpl_ajax_url,
		{
			'action': 'mpl_instant_save',
			'security': mpl_ajax_nonce,
			'task': 'frontend',
			'title': mpl_post_title,
			'id': parseInt(mpl_post_id, 10),
			'content': content,
			//'meta': meta.mpl_post_meta
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
			else mpl.msg('Successful', 'success', 'sl-check', 100);

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

export: function (id, ignored, order) {
	// magee
	var num;
	if (!order && order !== 0) {
		num = 2;
	}
	else {
		num = order;
	}
	var storage = mpl.storage[id][num];
	if (_.isUndefined(storage))
		return null;

	if (_.isUndefined(storage.name))
		return storage.full;

	if (_.isUndefined(ignored))
		ignored = [];

	if (mpl.maps[name] !== undefined)
		return storage.full;

	var name = storage.name;

	var number = num;
	if (name == 'mpl_undefined')
		return { begin: '', content: mpl.storage[id][number].args.content, end: '' };

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
		
	if (name == 'mpl_section_html')
		return { begin: _begin, content: mpl.storage[id][number].args.content, end: '[/mpl_section_html]' };

	if (mpl.maps[name] !== undefined && mpl.maps[name].is_container === true) {
		/* shortcode container */
		ignored[ignored.length] = storage.name;

		if (mpl.storage[id]) {
			_content = '';
			if (num > 0) {
				num--;
				if (!_.isUndefined(id)) {
					var _exp = mpl.front.export(id, $().extend([], ignored), num);
					_content += _exp.begin + _exp.content + _exp.end;
				}
			}
			mpl.storage[id][number].args.content = _content;
		}

		_end = '[/' + storage.name + ']';
		mpl.storage[id][number].content = _content;
		mpl.storage[id][number].end = '[/' + name + ']';

	}
	mpl.storage[id][number].name = name;

	return { begin: _begin, content: _content, end: _end };
},

tools_group: function (index, sectionName) {
	var html = mpl._$('<div class="section-tools"><div class="section-name">' + index + '.Section ' + sectionName + '</div><div class="tool-group"><ul><li class="tool-double"><i class="icon-double"><span>|</span></i></li><li class="tool-prev"><i class="icon-expand2"><span>|</span></i></li><li class="tool-next"><i  class="icon-expand1"><span>|</span></i></li><li class="tool-delete"><i  class="sl-close"><span>|</span></i></li><li class="tool-setting"><i  class="icon-content-setting"></i></li></ul></div></div>');
	return html;
},

addToolsListener: function () {
	mpl.trigger({
		el: mpl._$('body'),
		events: {
			'.mpl-elm:mouseenter': 'load_tool',
			'.mpl-elm:mouseleave': 'unload_tool'
		},
		load_tool: function (e) {
			var _$ = mpl._$;
			var index = _$(this).closest('.mpl-elm').data('front-model'),
				aim = _$(e.currentTarget),
				classArr = aim.attr('class').split(' '),
				strArr = classArr[mpl.front.section_name_pos].split('-');
			var sectionName;
			if (strArr.length > 2) {
				sectionName = '';
				for (var i = 2; i < strArr.length; i++) {
					sectionName += strArr[i].slice(0, 1).toUpperCase() + strArr[i].slice(1) + ' ';
				}
			}

			var html = mpl.front.tools_group(index, sectionName);
			aim.append(html);
			_$(aim).css({border: '2px dashed #86c724;'});
			if (_$(aim).offset().top < 100) {
				_$(aim).find('.section-tools').css({ 'top': '80px' });
			} else {
				_$(aim).find('.section-tools').css({ 'top': '20px' });
			}

			mpl.trigger({
				el: mpl._$('.section-tools'),
				events: {
					'.tool-double:click': 'double',
					'.tool-setting:click': 'setting',
					'.tool-delete:click': 'delete',
					'.tool-prev:click': 'prev',
					'.tool-next:click': 'next'
				},
				double: function (e) {
					var _$ = mpl._$;
					var clone_elm = _$(_$(e.currentTarget).closest('.mpl-elm')).clone(true);
					var classArr = _$(clone_elm).attr('class').split(' ');
					var id = classArr[mpl.front.section_css_pos].replace(/mpl-css-/, '');
					_$(clone_elm).attr('data-front-model', mpl.front.id + 1);
					if (_$(clone_elm).find('.section-tools')) {
						_$(clone_elm).find('.section-tools').remove();
					}
					_$(_$(e.currentTarget).closest('.mpl-elm')).after(clone_elm);

					var clone_id = mpl.front.backbone.double(this);
					classArr[mpl.front.section_css_pos] = 'mpl-css-' + clone_id;
					_$(clone_elm).attr('class', classArr.join(' '));

					/*Clone Style*/
					var pattern1 = new RegExp( "(((?![\,\{\}]).)*)" + id + "(((?!body).)*)", "g"); 
					var mpl_css_render = _$('#mpl-css-render').html();
					var clone_style = _$('#mpl-css-render').html().match(pattern1, '');
					for (var i = 0; i < clone_style.length; i++) {
						var pattern2 = new RegExp(id, "g");
						clone_style[i] = clone_style[i].replace(pattern2, clone_id);
					}
					_$('#mpl-css-render').html(mpl_css_render + clone_style.join(''));
				},

				setting: function (e) {
					var section = mpl._$(e.currentTarget).closest('.mpl-elm');
					var classArr = mpl._$(section).attr('class').split(' ');
					mpl.section_name = classArr[mpl.front.section_name_pos].replace(/-/g, '_');

					mpl.front.ui.elements.edit(this);

				},

				delete: function (e) {
					var _$ = mpl._$;
					var section = _$(e.currentTarget).closest('.mpl-elm');
					var classArr = _$(section).attr('class').split(' ');
					var id = classArr[mpl.front.section_css_pos].replace(/mpl-css-/, '');
					var section = _$(e.currentTarget).closest('.mpl-elm');

					mpl.msgbox('Are you sure you want to delete it?', function(params) {
						var pattern1 = new RegExp( "(((?![\,\{\}]).)*)" + params.id + "(((?!body).)*)", "g"); 
						var mpl_css_render = _$('#mpl-css-render').html().replace(pattern1, '');
						_$('#mpl-css-render').html(mpl_css_render);
						_$(params.section).remove();
					}, {id: id, section: section});
				},

				prev: function (e) {
					var _$ = mpl._$;
					var prev_elm = _$(_$(e.currentTarget).closest('.mpl-elm')).prev(),
						current_elm = _$(_$(e.currentTarget).closest('.mpl-elm'));

					_$(prev_elm).before(current_elm);
				},
				next: function (e) {
					var _$ = mpl._$;
					var next_elm = _$(_$(e.currentTarget).closest('.mpl-elm')).next(),
						current_elm = _$(_$(e.currentTarget).closest('.mpl-elm'));

					_$(next_elm).after(current_elm);
				}
			});
		},
		unload_tool: function (e) {
			mpl._$(e.currentTarget).find('.section-tools').remove();
			mpl._$(e.currentTarget).css({border: ''});
		}
	});
}

}, mpl.front);


//$(document).ready(function () {
//    mpl.front.init();
//});
})(jQuery);

