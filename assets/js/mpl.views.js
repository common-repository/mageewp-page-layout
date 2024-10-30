( function($){

if( typeof( mpl ) == 'undefined' )
	window.mpl = {};

$().extend( mpl.views, {

	builder : new mpl.backbone.views('no-model').extend({
		
		render : function(){
			
			var el = $( mpl.template( 'container' ) );
			$('#mpl-container').remove();
			$('#postdivrich').hide().removeClass('first-load').after( el );
			this.el = el;
			
			return el;
		},
		
		events : {
			'.basic-add:click' : mpl.backbone.add,
			'.mpl-add-sections:click' : 'sections',
			'.post-settings:click' : 'post_settings',
			'.optimized-page:click' : 'optimized',
			'.save-page-content:click' : 'save_page',
			'.collapse:click' : 'collapse',
			'#mpl-footers li.quickadd:click' : 'footer',
			'.front-editor:click' :'jump'
		},

		sections : function(e, opt){
			e.preventDefault();
			var atts = { 
					title: mpl.__.i61, 
					width: 1024,
					float: true,
					class: 'no-footer bg-blur-style section-manager-popup',
				},
				pop = mpl.tools.popup.render( e.target, atts );
			
			if( typeof opt != 'object' )
				opt = {};
			
			/*
			*	save content from row to section
			*/
			if( opt.save_row !== undefined ){
				pop.data({ model: opt.save_row });
				pop.addClass('mpl-save-row-to-section');
			}
			
			/*
			*	select another section
			*/
			if( opt.current !== undefined && opt.model !== undefined ){
				pop.data({ model: opt.model, 'current_item': opt.current });
			}
			
			if (mpl.sections === undefined || mpl.sections.items.length === 0){
				
				pop.find('.m-p-body').append('<p class="align-center" style="height:100px;"></p>');
				
				mpl.ui.sections.reload( pop );
				
			}else mpl.ui.sections.render( pop );

			return pop;

		},
					
		online_sections : function(e){
			
			
			return '';

		},

		post_settings : function( e ){
			var atts = { title: 'Page Settings', width: 800, class: 'no-footer bg-blur-style' },
				pop = mpl.tools.popup.render( e.target, atts );

			var arg = mpl.tools.reIndexForm($("input[name^='mpl_post_meta']").serializeArray(), []).mpl_post_meta;
			var sections = $( mpl.template( 'post-settings', arg ) );
			pop.find('.m-p-body').append( sections );

			if( typeof arg.callback == 'function' )
				arg.callback( sections, $ );
			
			return false;
		},

		optimized : function( e ){
			
			var atts = { title: 'Optimize Settings', width: 800, class: 'no-footer bg-blur-style' },
				pop = mpl.tools.popup.render( e.target, atts );
				
			var arg = mpl.tools.reIndexForm($("input[name^='mpl_post_meta']").serializeArray(), []).mpl_post_meta;
				
			var sections = $( mpl.template( 'optimized-settings', arg ) );

			pop.find('.m-p-body').append( sections );
			
			if( typeof arg.callback == 'function' )
				arg.callback( sections, $ );
			
			return false;
				
		},
		
		collapse : function(e){
			
			var ctn = $(this).closest('#mpl-container');
			if (!ctn.hasClass('collapse'))
			{
				ctn.addClass('collapse');
				$('#mpl-page-cfg-collapsed').val('collapse');
			}
			else
			{
				ctn.removeClass('collapse');
				$('#mpl-page-cfg-collapsed').val('');
			}
			
			e.preventDefault();
			return false;
				
		},
		
		footer : function(){
			
			var content = $(this).data('content');
			
			if( content == 'custom' ){
				
				var atts = { 
					title: mpl.__.i36, 
					width: 750, 
					float: true,
					class: 'push-custom-content',
					save_text: 'Push to builder'
				},
				pop = mpl.tools.popup.render( this, atts );
				
				var copied = mpl.backbone.stack.get('MPL_RowClipboard');
				if( copied === undefined || copied == '' )
					copied = '';
				pop.find('.m-p-body').html( mpl.__.i37+'<p></p><textarea style="width: 100%;height: 300px;">'+copied+'</textarea>');
				
				pop.data({
					callback : function( pop ){
						
						var content = pop.find('textarea').val();
						if( content !== '' )
							mpl.backbone.push( content );
					}
				});
				
				return;
				
			}else if( content == 'paste' ){
				content = mpl.backbone.stack.get('MPL_RowClipboard');
				if( content === undefined || content == '' ){
					content = '[mpl_column_text]<p>'+mpl.__.i38+'</p>[/mpl_column_text]';
				}
			}
			
			if( content != '' )
				mpl.backbone.push( content );
			
		},
		
		save_page : function(e){
			
			mpl.views.builder.sections( e, {save_row: 'all'} );
			
			return false;
			
		},

		jump : function () {
			window.open(mpl_current_url);
			return false;
		}
		
	} ),

	views_sections : new mpl.backbone.views().extend({
		
		render : function( params ){
			
			var el = new $( mpl.template( 'views-sections', params ) );
			mpl.params.process_all( params.args.content, el.find('> .mpl-views-sections-wrap'), 'views_section' );
			
			this.el = el;
			
			return el;
			
		},
		
		events : {
			'>.mpl-views-sections-control .edit:click' : 'settings',
			'>.mpl-views-sections-control .delete:click' : 'remove',
			'>.mpl-views-sections-control .double:click' : 'double',
			'>.mpl-views-sections-wrap .add-section:click' : 'add_section',
			'>.mpl-views-sections-control .more:click' : 'more',
			'>.mpl-views-sections-control .copy:click' : 'copy',
			'>.mpl-views-sections-control .cut:click' : 'cut',
			'>.mpl-views-sections-control:click' : function( e ){
				var tar = $(e.target);
				if( tar.hasClass('more') || tar.parent().hasClass('more') )
					return;
				$(this).find('.active').removeClass('active');
			},
		},
		
		add_section : function(e) {

			e.data.do_add_section(this);
			
		},
		
		do_add_section : function(el) {

			var wrp = $(el).closest('.mpl-views-sections-wrap'),
				maps = mpl.get.maps(el),
				smaps = mpl.maps[maps.views.sections],
				content = '['+maps.views.sections+' title="New '+smaps.name+'"][/'+maps.views.sections+']';
			
			wrp.find('> .mpl-views-sections-label .sl-active').removeClass('sl-active');
			wrp.find('> .mpl-section-active').removeClass('mpl-section-active');
				
			mpl.params.process_all( content, wrp, 'views_section' );
			
		}
		
	} ),
	
	views_section : new mpl.backbone.views().extend({
		
		render : function( params ){

			var el = $( mpl.template( 'views-section', params ) );
			
			this.el = el;
			
			return el;
			
		},
		
		init : function( params, el ){
			
			var id = el.data('model'), 
				btn = params.parent_wrp.find('>.mpl-views-sections-label .add-section'), 
				title = mpl.tools.esc( params.args.title ),
				icon = '';
			if( params.args.icon != undefined )
				icon = '<i class="'+params.args.icon+'"></i> ';
				
			mpl.ui.sortInit();
			
			var label = '<div class="section-label';
			if( params.first == true )
				label += ' sl-active';
			label += '" id="mpl-pmodel-'+id+'" data-pmodel="'+id+'">'+icon+title+'</div>';
			
			btn.before( label );
			
			return btn;

		},
		
		events : {
			'>.mpl-vs-control .settings:click' : 'settings',
			'>.mpl-vs-control .double:click' : 'double',
			'>.mpl-vs-control .add:click' : 'add',
			'>.mpl-vs-control .delete:click' : 'remove',
			
		},
		
		settings : function(){

			var pop = mpl.backbone.settings( this );
			if( !pop ){
				alert( mpl.__.i39 );
				return;
			}
			pop.data({
				after_callback : function( pop ){
					
					var id = mpl.get.model( pop.data('button') ),
						storage = mpl.storage[ id ],
						el = $('#model-'+id),
						icon = '';
					if( storage.args.icon != undefined )
						icon = '<i class="'+storage.args.icon+'"></i> ';
						
					$('#mpl-pmodel-'+id).html( icon+mpl.tools.esc( storage.args.title ) );
					el.find('.mpl-vertical-label').html( icon+mpl.tools.esc( storage.args.title ) );
				}
			});
		},
		
		double : function(el){
			
			var id = mpl.get.model(this),
				exp = mpl.backbone.export( id ),
				wrp = $(this).closest('.mpl-views-sections-wrap');
			
			wrp.find('> .mpl-views-sections-label .sl-active').removeClass('sl-active');
			wrp.find('> .mpl-section-active').removeClass('mpl-section-active');
				
			mpl.params.process_all( exp.begin+exp.content+exp.end, wrp, 'views_section' );
			
		},
		
		remove : function(){

			var id = mpl.get.model( this ),
				lwrp = $('#mpl-pmodel-'+id).parent();
				
			if( confirm('Are you sure?') ){
				$('#mpl-pmodel-'+id).remove();
				lwrp.find('.section-label').first().trigger('click');
				delete mpl.storage[ id ];
				$('#model-'+id).remove();
			}
		}

		
	} ),
	
	row : new mpl.backbone.views().extend({
		
		render : function( params, _return ){
			
			params.name = 'mpl_row';
			params.end = '[/mpl_row]';
			
			var el = $( mpl.template( 'row', params.args ) ), 
				atts = ' width="12/12"';
			
			if( params.args !== undefined && params.args.__section_link !== undefined ){
				
				// do stuff
				
			}else{
				
				var content = (params.args.content !== undefined) ? params.args.content.toString().trim() : '';
				
				if( content.indexOf('[mpl_column') !== 0 ){
					
					content = content.replace(/mpl_column#/g,'mpl_column##');
					content = content.replace(/mpl_column /g,'mpl_column# ').replace(/mpl_column\]/g,'mpl_column#]');
					
					var params = mpl.params.merge( 'mpl_column' );
					
					for( var i in params ){
						if( typeof( params[i] ) != 'undefined' && typeof( params[i].value ) != 'undefined' )
							atts += ' '+params[i].name
									+'="'+mpl.tools.esc_attr( params[i].value )+'"';
					}
					
					content = '[mpl_column'+atts+']'+content+'[/mpl_column]';
					
					delete params;
					
				}
				
				mpl.params.process_columns( content, el.find('.mpl-row-wrap') );
			
			}
			
			if( _.isUndefined(_return) )
				$('#mpl-container>#mpl-rows').append( el );
			
			this.el = el;
			
			return el;
			
		},
		
		events : {
			'.row-container-control .close:click' : 'remove',
			'.row-container-control .settings:click' : 'edit',
			'.row-container-control .double:click' : 'double',
			'.row-container-control .copy:click' : 'copy',
			'.row-container-control .columns:click' : 'columns',
			'.row-container-control .collapse:click' : 'collapse',
			'.row-container-control .addToSections:click' : 'sections',
			'.row-container-control .rowStatus:click' : 'status',
			'.row-container-control .order-row input:mouseover' : 'get_order',
			'.row-container-control .order-row button:click' : 'order',
			'.row-container-control .order-row input:keydown' : 'order_enter',
			
			'.mpl-row-section-preview .select-another-section:click' : 'select_section',
			
		},
		
		columns : function(){
			
			var columns = $(this).closest('.mpl-row').find('>.mpl-row-wrap>.mpl-column.mpl-model');

			var pop = mpl.tools.popup.render( 
						this, 
						{ 
							title: 'Row Layout', 
							class: 'no-footer',
							width: 341,
							content: mpl.template( 'row-columns', {current:columns.length} ),
							help: '#' 
						}
					);
					
			pop.find('.button').on( 'click', 
				{ 
					model: mpl.get.model( this ),
					columns: columns,
					pop: pop
				}, 
				mpl.views.row.set_columns 
			);
			
			pop.find('input[type=checkbox]').on('change',function(){
				
				var name = $(this).data('name');
				if( name == undefined )
					return;
					
				if( this.checked == true )
					mpl.cfg[ name ] = 'checked';
				else mpl.cfg[ name ] = '';
				
				mpl.backbone.stack.set( 'MPL_Configs', mpl.cfg );
					
			});	

		},
		
		set_columns : function(e){
			
			var newcols = $(this).data('column'),
				columns = e.data.columns,
				wrow = $( '#model-'+e.data.model+' > .mpl-row-wrap' ),
				colWidths = [], i = 0;
				
			if( newcols == 'custom' ){
				
				newcols = $(this).parent().find('input').val();
				if( newcols === '' || ( newcols.indexOf('%') === -1 && newcols.indexOf('/') === -1 ) ){
					alert('Invalid value');
					return;
				}
				
				newcols = newcols.split('+');
				if( newcols.length > 10 ){
					alert('Maximum 10 columns, you entered '+newcols.length+' columns');
					return;
				}
				var totalcols = 0;
				for( i=0; i<newcols.length; i++ ){
					
					colWidths[i] = newcols[i].trim();
					
					if( colWidths[i].indexOf('/') > -1 ){
						colWidths[i] = colWidths[i].split('/');
						colWidths[i] = mpl.tools.nfloat( (parseFloat( colWidths[i][0] )/parseFloat( colWidths[i][1] ))*100 );
					}else if( colWidths[i].indexOf('%') > -1 ){
						colWidths[i] = parseFloat( colWidths[i] );
					}
					
					totalcols += parseFloat( colWidths[i] );
					
				}
				
				if( totalcols > 100 || totalcols < 99 ){
					alert("\nTotal is incorrect: "+totalcols+"%, it must be 100%\n");
					return;
				}
				
				newcols = newcols.length;
				
			}else{
				
				newcols = parseInt( newcols );
				
				for( i=0; i<newcols; i++ ){
					colWidths[i] = mpl.tools.nfloat( 100/newcols );
				}
				
			}
			
			if( columns.length < newcols ){
				
				/* Add new columns */
				var reInit = false;
				
				
				for( var i = 0; i < (newcols-columns.length) ; i++ ){
					
					var dobl = mpl.backbone.double( columns.last().get(0) );
					
					if( $('#m-r-c-double-content').attr('checked') == undefined || columns.length === 0 ){
						
						dobl.find('.mpl-model').each(function(){
							delete mpl.storage[$(this).data('model')];
							$(this).remove();
						});
						
					}
					
				}
				
				if( reInit == true )
					mpl.ui.sortInit();
					
			}else
			{
				/* Remove columns */
				var remove = [];
				
				for( var i = 0; i < (columns.length-newcols) ; i++ ){
				
					var found_empty = false;
				
					wrow.find('>.mpl-column.mpl-model,>.mpl-column-inner.mpl-model').each(function(){
						if( $(this).find('>.mpl-column-wrap>.mpl-model').length == 0 ){
							found_empty = this;
						}
					});
				
					if( found_empty != false ){
				
						$(found_empty).remove();
				
					}else{
				
						var last = wrow.find('>.mpl-column.mpl-model,>.mpl-column-inner.mpl-model').last(), 
							plast = last.prev();
							
						if( $('#m-r-c-keep-content').attr('checked') != undefined && plast.get(0) != undefined ){
							last.find('>.mpl-column-wrap>.mpl-model').each(function(){
								plast.find('>.mpl-column-wrap').append( this );
							});
						}else{
							last.find('>.mpl-column-wrap>.mpl-model').each(function(){
								delete mpl.storage[$(this).data('model')];
							});
						}
						
						
						last.remove();
						
					}		
				}
				
			}
			
			i = 0;
			columns.eq(0).parent().find('>.mpl-model').each(function(){
				mpl.storage[$(this).data('model')].args.width = colWidths[i]+'%';
				$(this).css({width: colWidths[i]+'%'}).find('>.mpl-cols-info').html(Math.round(colWidths[i])+'%');
				i++;
			});
			
			e.data.pop.remove();
			
		},
		
		collapse : function(){
			
			var elm = $(this).closest('.mpl-row'), model = mpl.get.model(this);
			
			if( !elm.hasClass('collapse') ){
				elm.addClass('collapse');
				mpl.storage[model].args._collapse = '1';
			}else{
				elm.removeClass('collapse');
				delete mpl.storage[model].args._collapse;
			}	
			
		},
		
		sections : function( e ){
			
			var model = mpl.get.model(e.target);
			mpl.cfg.sectionsType = 'mpl-section';
			mpl.sections = {'items': []};
			mpl.views.builder.sections( e, {save_row: model} );
			
		},
		
		copy : function( e ){
				
			if( $(this).hasClass('copied') )
				return;
								
			var model = mpl.get.model( this ),
				expo = mpl.backbone.export( model );
				
			mpl.backbone.stack.set( 'MPL_RowClipboard', expo.begin+expo.content+expo.end );
			
			mpl.tools.toClipboard( expo.begin+expo.content+expo.end );
			
			$(this).addClass('copied');
			
			setTimeout( function( el ){
				$(el).removeClass('copied');
			}, 600, this );
			
			return;

		},
		
		edit : function( e ){
			
			var pop = mpl.backbone.settings( this );
			if( !pop ){
				alert( mpl.__.i41 );
				return;
			}
			
			pop.data({ after_callback : function( pop ){
				
				var id = mpl.get.model( pop.data('button') ),
					params = mpl.storage[ id ].args,
					html = '',
					el = $('#model-'+id+'>.mpl-row-admin-view');

				if( params.row_id != undefined && params.row_id != '__empty__' )
					html += '#'+params.row_id+' ';
				
				el.html( html );
				
			}});
			
		},
		
		status : function( e ){
				
			var model = mpl.get.model( this ), stt = '';
			if( mpl.storage[ model ] !== undefined && mpl.storage[ model ].args !== undefined ){
				
				if( $(this).hasClass('disabled') ){
					
					$(this).removeClass('disabled').closest('.mpl-model').removeClass('collapse');
					delete mpl.storage[ model ].args.disabled;
					
				}else{
					
					$(this).addClass('disabled').closest('.mpl-model').addClass('collapse');
					mpl.storage[ model ].args.disabled = 'on';
					
				}
				
				mpl.confirm( true );
				
			}
			
		},
		
		get_order : function( e ){
			$(this).val( $('#mpl-rows>.mpl-row').index( $(this).closest('.mpl-row') )+1 );
		},
		
		order : function( e ){
			
			var row = $(this).closest('.mpl-row'), 
				rows = $('#mpl-rows>.mpl-row'), 
				index = $(this).parent().find('input').val();
				
			if( index === '' || index < 0 || index > rows.length ){
				
				$(this).prev().
					animate({marginLeft:-20}, 150).
					animate({marginLeft:15}, 150).
					animate({marginLeft:-10}, 150).
					animate({marginLeft:5}, 150).
					animate({marginLeft:0}, 150);
			
			}else if( index == 0 || index == 1 ){
				
				rows.first().before( row );
				mpl.ui.scrollAssistive( row.get(0), true );
				$(this).parent().find('input').val('');
			
			}else{
				
				if( rows.index(row) < index-1 )
					rows.eq(index-1).after( row );
				else rows.eq(index-1).before( row );
				
				mpl.ui.scrollAssistive( row.get(0), true );
				$(this).parent().find('input').val('');
			
			}
			
			e.preventDefault();
			return false;
			
		},
		
		order_enter : function( e ){
			
			if( e.keyCode == 13 ){
				$(this).next().trigger('click');
				e.preventDefault();
				return false;
			}
		},
		
		select_section : function( e ){
			
			var model = mpl.get.model(e.target),
				current = $(this).data('current');
			
			mpl.views.builder.sections( e, { current: current, model: model } );
			
			e.preventDefault();
			return false;
			
		}
		
	} ),
			
	column : new mpl.backbone.views().extend({
		
		render : function( params ){
			
			params.name = 'mpl_column'; params.end = '[/mpl_column]';
			
			var _w = params.args['width'];
			if( _w != undefined ){
				if( _w.toString().indexOf('/') > -1 ){
					_w = _w.split('/');
					_w = parseFloat((_w[0]/_w[1])*100).toFixed(4)+'%';
				}else if( _w.toString().indexOf('%') === -1 )
					_w += '%';
			}else{
				_w = '100%';
			}
			
			var el = $( mpl.template( 'column', { width: _w } ) );

			mpl.params.process_all( params.args.content, el.find('.mpl-column-wrap') );
			
			this.el = el;
			
			return el;
			
		},
		
		events : {
			'>.mpl-column-control .edit:click' : 'settings',
			'>.mpl-column-control .add:click' : 'add',
			'>.mpl-column-control .delete:click' : 'delete',
			'>.mpl-column-control .double:click' : 'double',
			'>.mpl-column-control .insert:click' : 'insert',
		},
		
		
		delete : function( e, id ){

			if( !confirm( mpl.__.sure ) )
				return;
			
			if( id == undefined )
				var id = mpl.get.model( this );
			
			var col = $( '#model-'+id ),
				pco = col.parent();
			
			col.find('.mpl-model').each(function(){
				delete mpl.storage[ mpl.get.model(this) ];
			});
				
			col.remove();
			delete mpl.storage[ id ];
			
			mpl.views.column.reset_view(pco);
			
		},
		
		insert : function( id ){
			
			if (typeof id === 'object')
				id = mpl.get.model(this);
				
			var el = $('#model-'+id),
				data = mpl.storage[id],
				cdata = $().extend( true, {}, data );
			
			if( el.parent().find('>.mpl-model').length >= 10 ){
				alert(mpl.__.i54);
				return;
			}
			
			cdata.args.content = '';
			
			var cel = mpl.views.column.render( cdata, true );
			el.after(cel);
			
			mpl.views.column.reset_view(el.parent());
			
			mpl.ui.sortInit();
				
		},
		
		reset_view : function( el ){
			
			var cols = el.find('>.mpl-model'), 
				model, 
				wid = mpl.tools.nfloat(100/cols.length);
			
			if(cols.length === 0){
				delete mpl.storage[ el.closest('.mpl-model').data('model') ];
				el.closest('.mpl-model').remove();
				return;
			}
				
			cols.each(function(){
				model = $(this).data('model');
				mpl.storage[model].args.width = wid+'%';
				$(this).css({width: wid+'%'});
				$(this).find('>.mpl-cols-info').html(wid+'%');
			});	
			
		},
		
		apply_all : function( el, arg ){
			
			var pop = mpl.get.popup(el), model = pop.data('model');
			pop.find('.sl-check.sl-func').trigger('click');
			
			try{
				var data = mpl.storage[ model ].args[ arg ];
				$('#model-'+model).parent().find('>div').each(function(){
					
					model = $(this).data('model');
					if( model !== undefined )
						mpl.storage[ model ].args[ arg ] = data;
					
				});
			}catch( ex ){}
			
			event.preventDefault();
			return false;
			
		}
		
	}),
	
	mpl_row_inner : new mpl.backbone.views().extend({
		
		render : function( params ){
			
			params.name = 'mpl_row_inner'; params.end = '[/mpl_row_inner]';
			
			var el = $( mpl.template( 'row-inner' ) );
			
			var content = params.args.content;
			if( content !== undefined )
				content = content.toString().trim();
			else content = '';
			
			if( content.indexOf('[mpl_column') !== 0 ){
				content = '[mpl_column_inner width="12/12"]'+
							content.replace(/mpl_column_inner/g,'mpl_column_inner#')+
							'[/mpl_column_inner]';
			}			   
				
			mpl.params.process_all( content, el.find('.mpl-row-wrap') );
			
			this.el = el;
			
			return el;
		
		},
		
		events : {
			'.mpl-row-inner-control > .settings:click' : 'settings',
			'.mpl-row-inner-control > .double:click' : 'double',
			'.mpl-row-inner-control > .delete:click' : 'remove',
			'.mpl-row-inner-control > .copyRowInner:click' : 'copy',
			'.mpl-row-inner-control > .columns:click' : 'columns',
			'.mpl-row-inner-control > .collapse:click' : 'collapse',
		},
		
		collapse : function(){
			var elm = $('#model-'+mpl.get.model(this));
			if( !elm.hasClass('collapse') ){
				elm.addClass('collapse');
			}else{
				elm.removeClass('collapse');
			}	
		},
		
		columns : function(){
			
			var columns = $(this).closest('.mpl-row-inner').find('>.mpl-row-wrap>.mpl-column-inner.mpl-model');

			var pop = mpl.tools.popup.render( 
						this, 
						{ 
							title: mpl.__.i42, 
							class: 'no-footer',
							width: 341,
							content: mpl.template( 'row-columns', {current:columns.length} ),
							help: '#' 
						}
					);
					
			pop.find('.button').on( 'click', 
				{ 
					model: mpl.get.model( this ),
					columns: columns,
					pop: pop
				}, 
				mpl.views.row.set_columns 
			);
			
			pop.find('input[type=checkbox]').on('change',function(){
				
				var name = $(this).data('name');
				if( name == undefined )
					return;
					
				if( this.checked == true )
					mpl.cfg[ name ] = 'checked';
				else mpl.cfg[ name ] = '';
				
				mpl.backbone.stack.set( 'MPL_Configs', mpl.cfg );
					
			});	
					
		},
		
		copy : function(){
			
			if( $(this).hasClass('copied') )
				return;
				
			$(this).addClass('copied');
			setTimeout( function( el ){ el.removeClass('copied'); }, 1000, $(this) );
			
			mpl.backbone.copy( this );
			
		}
		
	}),
	
	mpl_column_inner : new mpl.backbone.views().extend({
		
		render : function( params ){
			
			params.name = 'mpl_column_inner'; params.end = '[/mpl_column_inner]';
			
			var _w = params.args['width'];
			if( _w != undefined ){
				if( _w.toString().indexOf('/') > -1 ){
					_w = _w.split('/');
					_w = ((_w[0]/_w[1])*100)+'%';
				}else if( _w.toString().indexOf('%') === -1 )
					_w += '%';
			}else{
				_w = '100%';
			}
			
			var el = $( mpl.template( 'column-inner', { width: _w } ) );

			if( params.args.content !== undefined && params.args.content != '' )
				mpl.params.process_all( params.args.content, el.find('.mpl-column-wrap') );
			
			this.el = el;
				
			return el;
		
		},
		
		events : {
			'>.mpl-column-control .edit:click' : 'settings',
			'>.mpl-column-control .add:click' : 'add',
			'>.mpl-column-control .delete:click' : 'delete',
			'>.mpl-column-control .double:click' : 'double',
			'>.mpl-column-control .insert:click' : 'insert',
		},

		insert : function( e, id ){
			
			var id = mpl.get.model(this),
				el = $('#model-'+id),
				data = mpl.storage[id],
				cdata = $().extend( true, {}, data );
			
			if( el.parent().find('>.mpl-model').length >= 10 ){
				alert(mpl.__.i54);
				return;
			}
			
			cdata.args.content = '';
			
			var cel = mpl.views.mpl_column_inner.render( cdata, true );
			el.after(cel);
			
			mpl.views.column.reset_view(el.parent());
			
			mpl.ui.sortInit();
				
		},
					
		delete : function( e  ){
			
			mpl.views.column.delete( e, mpl.get.model( this ) );

		},
		
	}),
						
	mpl_element : new mpl.backbone.views().extend({
		
		render : function( params ){
			
			var map = $().extend( {}, mpl.maps._std );
			map = $().extend( map, mpl.maps[ params.name ] );
			
			var el = $( mpl.template( 'element', { map : map, params : params } ) );
			
			setTimeout( function( params, map, el ){
				el.append( mpl.params.admin_label.render({map: map, params: params, el: el }));
			}, parseInt(Math.random()*100)+100, params, map, el );
			
			if (map.nested === true)
				mpl.params.process_all( params.args.content, el.find('.mpl-column-wrap') );
			
			this.el = el;
				
			return el;
			
		},
		
		events : {
			'>.mpl-element-control .edit:click' : 'edit',
			'>.mpl-element-control .delete:click' : 'remove',
			'>.mpl-element-control .double:click' : 'double',
			'>.mpl-element-control .add:click' : 'add',
			'>.mpl-element-control .more:click' : 'more',
			'>.mpl-element-control .copy:click' : 'copy',
			'>.mpl-element-control .cut:click' : 'cut',
			'>.mpl-element-control:click' : function( e ){
				var tar = $(e.target);
				if( tar.hasClass('more') || tar.parent().hasClass('more') )
					return;
				$(this).find('.active').removeClass('active');
			},
		},
		
		edit : function( e ){
			var pop = mpl.backbone.settings( this );

			if( !pop ){
				alert( mpl.__.i43 );
				return;
			}	
			
			$(this).closest('.mpl-element').addClass('editting');
			pop.data({cancel: function(pop){
				$( pop.data('button') ).closest('.mpl-element').removeClass('editting');
			},
				after_callback : function( pop ){
				var id = mpl.get.model( pop.data('button') ),
					params = mpl.storage[ id ],
					map = $().extend( {}, mpl.maps._std ),
					el = $('#model-'+id);

				map = $().extend( map, mpl.maps[ params.name ] );
				el.find('>.admin-view').remove();
				el.append( mpl.params.admin_label.render({map: map, params: params, el: el }));
			}});
		},
	}),
						
	mpl_undefined : new mpl.backbone.views().extend({
		
		render : function( params ){
			
			var map = $().extend( {}, mpl.maps._std );
			map = $().extend( map, mpl.maps[ params.name ] );
			
			var el = $( mpl.template( 'undefined', { map : map, params : params } ) );
			
			this.el = el;
			
			return el;
		},
		
		events : {
			'>.mpl-element-control .edit:click' : 'edit',
			'>.mpl-element-control .delete:click' : 'remove',
			'>.mpl-element-control .double:click' : 'double'
		},
		
		edit : function( e ){

			var pop = mpl.backbone.settings( this );
			if( !pop ){
				alert( mpl.__.i45 );
				return;
			}	
			
			$(this).closest('.mpl-element').addClass('editting');
			pop.data({cancel: function(pop){
				
				$( pop.data('button') ).closest('.mpl-element').removeClass('editting');
				
			},after_callback : function( pop ){
				
				$( pop.data('button') ).closest('.mpl-element').removeClass('editting');
				
				var id = mpl.get.model( pop.data('button') ),
					params = mpl.storage[ id ], 
					map = $().extend( {}, mpl.maps._std ),
					el = $('#model-'+id);
				
				map = $().extend( map, mpl.maps[ params.name ] );
				el.find('>.admin-view').remove();
				el.append( mpl.params.admin_label.render({map: map, params: params, el: el }));

			}});
			
		},
		
		remove : function( e ){

			if( confirm( mpl.__.sure ) ){
				var elm = $(this).closest('div.mpl-element');
				var mid = elm.data('model');
				elm.remove();
				delete mpl.storage[mid];	
			}
		}
	}),

} );
	
} )( jQuery );