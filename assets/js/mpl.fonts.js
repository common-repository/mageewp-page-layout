(function($){
	window.kcfonts = {
		
		items_tmpl : null,
		
		items : null,
		
		uri : '//fonts.googleapis.com/css?family=',
		
		api : 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCrsTDigL61TFHYPHTZduQP1cGi8CLfp90&callback=kcfonts.load',
		
		resources : $('#mpl-fonts-manager-resource'),
		
		load : function( json ){

			if( typeof json != 'object' || typeof json.items != 'object'  ){
				alert('Had an error occurs: '+json.error.message);
				return;
			}
			
			this.items_tmpl = json.items;
			
			this.apply_filter();
			this.render( 0 );
			this.pagination();
			
		},
		
		render : function( index ){

			var html = '';
			this.resources.html('');
			
			if( this.items.length > 0 ){
				
				for( var i = index; i< index+60; i++ ){
					
					if( i > this.items.length )
						break;
					
					if( this.items[i] === undefined )
						continue;
					
					html += this.item( this.items[i], i );
					
				}
				
			}else html = '<div class="mpl-ggf-notfount"><div class="error-emoji">\\(^Д^)/</div><div class="error-text">No fonts found!</div></div>'; 
			
			$('#mpl-ggf-render').html( html );
			
		},
		
		item : function( it, index ){
			
			var txt = it.family.replace(/ /g, '+')+':'+it.variants.join(',')/*+'&subset='+it.subsets.join(',')*/;
			
			this.resources.append( '<link onload="kcfonts.done('+index+');" rel="stylesheet" href="'+(this.uri+txt)+'" type="text/css" media="all" />' );
				
			txt = '<div class="mpl-ggf-item unload '+(it.family.replace(/ /g, '-'));
			if( mpl_my_fonts[encodeURIComponent(it.family)] !== undefined )
				txt += ' added';
			txt += '" data-index="'+index+'">';
			txt += '<h3 style="font-family:\''+it.family+'\'" contenteditable>'+it.family+'</h3>';
			txt += '<span class="cat" style="font-family:\''+it.family+'\'">'+it.category+'</span> ';
			txt += '<span class="variants"><select onchange="kcfonts.variants(this)"><option value="">Style & Weight</option>';
			for( var i=0; i<it.variants.length; i++ )
				txt += '<option value="'+it.variants[i]+'">'+it.variants[i]+'</option>';
			txt += '</select></span>';
			
			txt += '<i class="sl-check" data-action="added" title="You have added this font"></i>';
			txt += '<i class="sl-plus" data-action="add" title="Add this font to your site"></i>';
			
			txt += '</div>';
			
			return txt;
			
		},
		
		done : function( index ){
			$('.mpl-ggf-item[data-index='+index+']').removeClass('unload');
		},
		
		render_my : function(){
			
			var html = '',	
	    		el = $('#mpl-ggf-mf-body'),
	    		item;
	    		
			el.html('');
			
			if( Object.keys(mpl_my_fonts).length > 0 ){
				
				for( var i in mpl_my_fonts ){
					
					item = {
						family: decodeURIComponent(i),
						variants: decodeURIComponent(mpl_my_fonts[i][1]).split(','),
						subsets: decodeURIComponent(mpl_my_fonts[i][0]).split(','),
						subsets_val: (mpl_my_fonts[i][2]!==undefined) ? decodeURIComponent(mpl_my_fonts[i][2]).split(',') : [decodeURIComponent(mpl_my_fonts[i][0]).split(',')[0] ],
						variants_val: (mpl_my_fonts[i][3]!==undefined) ? decodeURIComponent(mpl_my_fonts[i][3]).split(',') : decodeURIComponent(mpl_my_fonts[i][1]).split(',')
					}
					
					html += kcfonts.my_item( item, i );
					
				}
				
			}else html = '<div class="error-text">No fonts found!</div>';
	    	
	    	el.html(html);
	    	$('#mpl-ggf-my-fonts').css({display: 'inline-block'});
	    	$('body').addClass('mpl-show-my-fonts');
	    	
	    	if( typeof top.window.mpl_fonts_update == 'function' )
	    		top.window.mpl_fonts_update( mpl_my_fonts );
				
		},
		
		my_item : function( it, index ){
			
			//var txt = it.family.replace(/ /g, '+')+':'+it.variants.join(',')/*+'&subset='+it.subsets.join(',')*/;
				
			var txt = '<div class="mpl-ggf-item" data-index="'+index+'">';
			txt += '<h3 style="font-family:\''+it.family+'\'" contenteditable>'+it.family+'</h3>';
			txt += '<div class="mpl-ggf-item-row"><div class="mpl-ggf-col"><strong>Style & Weight:</strong><br />';
			for( var i=0; i<it.variants.length; i++ ){
				txt += '<input ';
				if( it.variants_val.indexOf( it.variants[i] ) > -1 )
					txt += 'checked ';
				txt += 'type="checkbox" id="'+(it.family.replace(/ /g, '-')+it.variants[i])+'" value="'+it.variants[i]+'" /> <label for="'+(it.family.replace(/ /g, '-')+it.variants[i])+'">'+it.variants[i]+'</label><br />';
			}
			txt += '</div><div class="mpl-ggf-col"><strong>Languages:</strong><br />';
			for( i=0; i<it.subsets.length; i++ ){
				txt += '<input ';
				if( it.subsets_val.indexOf( it.subsets[i] ) > -1 )
					txt += 'checked ';
				txt += 'type="checkbox" id="'+(it.family.replace(/ /g, '-')+it.subsets[i])+'" value="'+it.subsets[i]+'" /> <label for="'+(it.family.replace(/ /g, '-')+it.subsets[i])+'">'+it.subsets[i]+'</label><br />';
			}
			txt += '</div><button data-action="update"><i class="sl-check"></i> Save Changes</button></div>';
			txt += '<i class="sl-close" data-action="delete" title="Delete this font"></i>';
			txt += '<i class="icon-content-setting" data-action="settings" title="Font Settings"></i>';
			txt += '<link rel="stylesheet" href="'+(this.uri+it.family.replace(/ /g, '+')+':'+it.variants.join(','))+'" type="text/css" media="all" />';
			txt += '</div>';
			
			return txt;
			
		},
		
		pagination : function(){
			
			if( this.pages <= 1 ){
				$('.mpl-ggf-pagination').html('');
				return;
			}
				
			var txt = '<ul><li data-action="prev">Previous</li>',
				items = $('#mpl-ggf-render .mpl-ggf-item');
			for( var i=1; i<= this.pages; i++ ){
				if( i === 1 )
					txt += '<li class="active page-1" data-action="page">'+i+'</li>';
				else txt += '<li class="page-'+i+'" data-action="page">'+i+'</li>';
			}
			txt += '<li data-action="next">Next</li>';
			txt += '<li class="inf">Display '+(items.first().data('index')+1)+' to '+(items.last().data('index')+1)+' of '+this.items.length+'</li>';
			txt += '</ul>';
			
			$('.mpl-ggf-pagination').html( txt );
			
		},
		
		filter_values : function(){
			
			this.language = $('#mpl-ggf-language').val();
			this.category = $('#mpl-ggf-category').val();
			this.search = $('#mpl-ggf-search').val();
			
		},
		
		apply_filter : function(){
			
			this.filter_values();
			
			delete this.items;
			this.items = [];
			
			for(var i=0; i < this.items_tmpl.length; i++){
				
				if(this.language !== '' && this.items_tmpl[i].subsets.indexOf(this.language) === -1)
					continue;
				if(this.category !== '' && this.items_tmpl[i].category != this.category)
					continue;
				if(this.search !== '' && this.items_tmpl[i].family.toLowerCase().indexOf(this.search.toLowerCase()) === -1)
					continue;
				
				this.items.push(this.items_tmpl[i]);
				
			}
			
			this.pages = Math.round(this.items.length / 60);
			if( this.pages*60 < this.items.length )
				this.pages++;
			
			$('#mpl-ggf-header h3 small').html('( Total '+this.items_tmpl.length+' fonts )');

		},
		
		variants : function( inp ){
			
			var tit = $(inp).closest('.mpl-ggf-item').find('h3').get(0);
			
			if( inp.value === '' ){
				tit.style.fontWeight = '';
				tit.style.fontStyle = '';
				return;
			}
			
			if( inp.value.indexOf('italic') > -1 )
				tit.style.fontStyle = 'italic';
			else tit.style.fontStyle = '';
			
			tit.style.fontWeight = inp.value.replace('italic','');
			
		},
		
		ajax_response : function(json){
									
	    	var mes = $('<div id="mpl-ggf-message"></div>');
	    	
	    	mes.css({opacity: 0});
	    	
	    	if( json === -1 || json == '-1' ){
	    		mes.addClass('error');
	    		mes.html( 'Error, invalid security nonce, reload and try again' );
	    	}else if( json.stt === 0 ){
		    	mes.addClass('error');
		    	mes.html( json.message );
		    }else if( json.stt === 1 ){
		    	mes.addClass('success');
		    	mes.html( json.message );
		    }
		    	
		    $('body').append(mes);
		    
		    mes.animate({opacity: 1}).delay(3000).animate({opacity: 0}, function(){mes.remove();});
	    	
	    	if( json === -1 || json == '-1' )
	    		return 0;
	    	
	    	var count = Object.keys(json.data).length, 
	    		lt = $('#mpl-ggf-header .mpl-ggf-load-time span');
	    		
	    	$('#mpl-ggf-header .mpl-ggf-added span').html(count);
	    	
	    	if( count < 4 )
	    		lt.html('Fast').attr({class:''});
	    	else if( count < 6 )
	    		lt.html('Medium').attr({class:'medium'});
	    	else if( count < 9 )
	    		lt.html('Slow').attr({class:'slow'});
	    	else lt.html('Very Slow').attr({class:'slow'});
	    	
	    	/*
		    *	Render my fonts 
		    */
		    
		    mpl_my_fonts = json.data;
		    
		    return json.stt;
		    
		}
		
	}
	
	$('#mpl-fonts-manager').on('click', function(e){
		
		var el = $(e.target);
		switch( el.data('action') ){
			
			case 'page': 
				
				kcfonts.render( (parseInt(el.html(), 10) - 1) * 60 );
				var items = $('#mpl-ggf-render .mpl-ggf-item');
				
				$('.mpl-ggf-pagination li.active').removeClass('active');
				$('.mpl-ggf-pagination li.page-'+el.html()).addClass('active');
				
				$('.mpl-ggf-pagination li.inf').html('Display '+(items.first().data('index')+1)+' to '+(items.last().data('index')+1)+' of '+kcfonts.items.length);
				
			break;	
			
			case 'next': 
				
				var nx = el.parent().find('.active').next();
				if( nx.html() == 'Next' )
					return;
					
				kcfonts.render( (parseInt(nx.html(), 10) - 1) * 60 );
				
				$('.mpl-ggf-pagination li.active').removeClass('active');
				$('.mpl-ggf-pagination li.page-'+nx.html()).addClass('active');
				
			break;	
			
			case 'prev': 
				
				var pv = el.parent().find('.active').prev();
				if( pv.html() == 'Previous' )
					return;
					
				kcfonts.render( (parseInt(pv.html(), 10) - 1) * 60 );
				
				$('.mpl-ggf-pagination li.active').removeClass('active');
				$('.mpl-ggf-pagination li.page-'+pv.html()).addClass('active');
				
			break;
			
			case 'add':
			
				if( el.hasClass('fa-spin') )
					return;
					
				el.attr({class:'fa fa-spinner fa-spin fa-2x'}).css({opacity:1});
				
				var item = kcfonts.items[ el.closest('.mpl-ggf-item').data('index') ];
				
				$.ajax({
				    url: ajaxurl,
				    data: {
					    security: mpl_fonts_nonce,
					    action: 'mpl_add_font',
					    family:  encodeURIComponent(item.family),
					    subsets: encodeURIComponent(item.subsets.join(',')),
					    variants: encodeURIComponent(item.variants.join(','))
				    },
				    el: el,
				    family: item.family,
				    method: 'POST',
					dataType: 'json',
				    success: function( json ){
						
						this.el.attr({class:'sl-plus'}).css({opacity:''});
						
						if( kcfonts.ajax_response(json) === 1 ){
				    		$('#mpl-ggf-render .mpl-ggf-item.'+this.family.replace(/ /g, '-')).addClass('added');
							kcfonts.render_my();
							$('html,body').animate({scrollTop: 0}, 500);
						}
				    }
				});
				
			break;
			
			case 'my-fonts' : 
				
				kcfonts.render_my();
				
			break;
			
			case 'close-my-fonts' : 
				
				$('#mpl-ggf-my-fonts').hide();
				$('body').removeClass('mpl-show-my-fonts');
				
			break;
			
			case 'delete' : 
				
				if( !confirm('Are you sure?') )
					return;
				
				if( el.hasClass('fa-spin') )
					return;
					
				el.attr({class:'fa fa-spinner fa-spin fa-2x'}).css({opacity:1});
					
				var family = el.closest('.mpl-ggf-item').data('index');
				
				$.ajax({
				    url: ajaxurl,
				    data: {
					    security: mpl_fonts_nonce,
					    action: 'mpl_delete_font',
					    family:  el.closest('.mpl-ggf-item').data('index')
				    },
				    el: el,
				    family: decodeURIComponent(family),
				    method: 'POST',
					dataType: 'json',
				    success: function( json ){
						
						if( kcfonts.ajax_response(json) === 1 )
				    		$('#mpl-ggf-render .mpl-ggf-item.'+this.family.replace(/ /g, '-')).removeClass('added');
				    		
				    	kcfonts.render_my();
				    	
				    }
				});
				
				
			break;
			
			case 'settings' : 
				
				el.parent().find('.mpl-ggf-item-row').toggle();
				
			break;
			
			case 'update' : 
				
				if( el.find('.fa-spinner').length > 0 )
					return;
				
				var cols = el.closest('.mpl-ggf-item-row').find('.mpl-ggf-col'),
					variants = [], subsets = [], family = el.closest('.mpl-ggf-item').data('index');
				
				cols.eq(0).find('input:checked').each(function(){
					variants.push(this.value);
				});
				
				cols.eq(1).find('input:checked').each(function(){
					subsets.push(this.value);
				});
				
				if( mpl_my_fonts[family] !== undefined ){
					mpl_my_fonts[family][3] = encodeURIComponent(variants.join(','));
					mpl_my_fonts[family][2] = encodeURIComponent(subsets.join(','));
				}
				
				el.html('<i class="fa-spinner fa-spin"></i> saving...').css({background:'#aaa'});
				
				$.ajax({
				    url: ajaxurl,
				    data: {
					    security: mpl_fonts_nonce,
					    action: 'mpl_update_font',
					    datas: mpl_my_fonts
				    },
				    el: el,
				    method: 'POST',
					dataType: 'json',
				    success: function( json ){
						
						kcfonts.ajax_response(json);
				    	
				    	this.el.html('<i class="sl-check"></i> Save Changes').css({background:''});
				    	
				    }
				});
				
			break;
			
		}
		
	});
	
	$('#mpl-ggf-filter').on('change', function(){
		
		$('#mpl-ggf-render').html('<span class="mpl-ggf-loading"><i class="fa-spinner fa-spin fa-2x fa-fw"></i></span>');
		$('#mpl-ggf-body .mpl-ggf-pagination').html('');
		
		var url = kcfonts.api;

		if( $(this).val() !== '' )
			url += '&sort='+$(this).val();
		else url += '&sort=popularity';
		
		$('#mpl-fonts-manager-api').html('<script type="text/javascript" src="'+url+'"><'+'/script>');
		
	}).change();
	
	$('#mpl-ggf-language,#mpl-ggf-category,#mpl-ggf-search').on('change keyup', function(){
		
		kcfonts.apply_filter();
		kcfonts.render( 0 );
		kcfonts.pagination();
		
	});
	
	/*
	*	Open my fonts 
	*/
	kcfonts.render_my();
	
})(jQuery);