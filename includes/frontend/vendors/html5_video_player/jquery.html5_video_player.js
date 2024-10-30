
( function( $ ) {
	jQuery.html5_video_player = {
		name: "jquery.mb.html5_video_player",
		author: "mageewp.com",
		version: "1.0.8",
		build: "392",
		defaults: {
			containment: "body",
			ratio: "16/9", // "16/9" or "4/3"
			mp4URL: null,
			ogvURL: null,
			webmURL: null,
			startAt: 0,
			stopAt: 0,
			autoPlay: true,
			fadeTime: 1000,
			vol: 50, // 1 to 100
			addRaster: false,
			opacity: 1,
			mute: true,
			loop: true,
			showControls: true,
			show_vimeo_logo: true,
			stopMovieOnBlur: true,
			realfullscreen: true,
			mobileFallbackImage: null,
			gaTrack: false,
			optimizeDisplay: true,
			mask: false,
			align: "center,center", // top,bottom,left,right
			onReady: function( player ) {}
		},
		/**
		 *  @fontface icons
		 *  */
		controls: {
			play: "P",
			pause: "p",
			mute: "M",
			unmute: "A",
			fullscreen: "O",
			showSite: "R",
			logo: "V"
		},
		buildPlayer: function( options ) {

			var isIframe = function() {
				var isIfr = false;
				try {
					if( self.location.href != top.location.href ) isIfr = true;
				} catch( e ) {
					isIfr = true;
				}
				return isIfr;
			};

			return this.each( function() {

				var html5_video_player = this;
				var $html5_video_player = jQuery( html5_video_player );
				html5_video_player.loop = 0;
				html5_video_player.opt = {};
				html5_video_player.state = {};
				html5_video_player.id = html5_video_player.id || "YTP_" + new Date().getTime();
				$html5_video_player.addClass( "html5_video_player" );

				var property = $html5_video_player.data( "property" ) && typeof $html5_video_player.data( "property" ) == "string" ? eval( '(' + $html5_video_player.data( "property" ) + ')' ) : $html5_video_player.data( "property" );

				jQuery.extend( html5_video_player.opt, jQuery.html5_video_player.defaults, options, property );

				html5_video_player.opt.ratio = html5_video_player.opt.ratio == "auto" ? "16/9" : html5_video_player.opt.ratio;

				html5_video_player.isRetina = ( window.retina || window.devicePixelRatio > 1 );

				html5_video_player.canGoFullScreen = !( jQuery.browser.msie || jQuery.browser.opera || isIframe() );
				if( !html5_video_player.canGoFullScreen ) html5_video_player.opt.realfullscreen = false;

				html5_video_player.isAlone = false;
				html5_video_player.hasFocus = true;

				html5_video_player.mp4URL = this.opt.mp4URL ? this.opt.mp4URL : '#';
				html5_video_player.ogvURL = this.opt.ogvURL ? this.opt.ogvURL : '#';
				html5_video_player.webmURL = this.opt.webmURL ? this.opt.webmURL : '#';

				html5_video_player.isSelf = html5_video_player.opt.containment == "self";
				html5_video_player.opt.containment = html5_video_player.opt.containment == "self" ? jQuery( this ) : jQuery( html5_video_player.opt.containment );
				html5_video_player.isBackground = html5_video_player.opt.containment.is( "body" );

				if( html5_video_player.isBackground && html5_video_player.backgroundIsInited )
					return;

				html5_video_player.canPlayOnMobile = html5_video_player.isSelf && jQuery( this ).children().length === 0;

				if( !html5_video_player.isSelf ) {
					$html5_video_player.hide();
				}

				var overlay = jQuery( "<div/>" ).css( {
					position: "absolute",
					top: 0,
					left: 0,
					width: "100%",
					height: "100%"
				} ).addClass( "html5_video_player_overlay" );

				if( html5_video_player.isSelf ) {
					overlay.on( "click", function() {
						$html5_video_player.togglePlay();
					} )
				}

				var playerID = "html5_video_player_" + html5_video_player.id;

				var wrapper = jQuery( "<div/>" ).addClass( "html5_video_player_wrapper" ).attr( "id", "html5_video_player_wrapper_" + playerID );
				wrapper.css( {
					position: "absolute",
					zIndex: 0,
					minWidth: "100%",
					minHeight: "100%",
					left: 0,
					top: 0,
					overflow: "hidden",
					opacity: 1
				} );
				html5_video_player.playerBox = jQuery( "<video />" ).attr( "id", playerID ).addClass( "playerBox" );
				html5_video_player.playerBox.css( {
					position: "absolute",
					zIndex: 0,
					minWidth: "100%",
					minHeight: "100%",
					width: "auto",
					height: "auto",
					top: -10,
					frameBorder: 0,
					overflow: "hidden",
					left: 0
				} );
				var t = '';
				if (html5_video_player.opt.startAt > 0)
					t = '#t=' + html5_video_player.opt.startAt;
				if (html5_video_player.opt.stopAt > 0)
					t += t === '' ? '#t=,' + html5_video_player.opt.stopAt : ',' + html5_video_player.opt.stopAt;
				var sources = jQuery(
				'<source src="' + html5_video_player.mp4URL + t + '" type="video/mp4">' +
				'<source src="' + html5_video_player.ogvURL + t + '" type="video/ogv">' + 
				'<source src="' + html5_video_player.webmURL + t + '" type="video/webm">');
				html5_video_player.playerBox.append(sources);

				if( !jQuery.browser.mobile || html5_video_player.canPlayOnMobile )
					wrapper.append( html5_video_player.playerBox );
				else {
					if( html5_video_player.opt.mobileFallbackImage ) {
						wrapper.css( {
							backgroundImage: "url(" + html5_video_player.opt.mobileFallbackImage + ")",
							backgroundPosition: "center center",
							backgroundSize: "cover",
							backgroundRepeat: "no-repeat",
							opacity: 1
						} )
					};

					$html5_video_player.remove();
					return;
				}

				html5_video_player.opt.containment.children().not( "script, style" ).each( function() {
					if( jQuery( this ).css( "position" ) == "static" ) jQuery( this ).css( "position", "relative" );
				} );

				if( html5_video_player.isBackground ) {
					jQuery( "body" ).css( {
						boxSizing: "border-box"
					} );

					wrapper.css( {
						position: "fixed",
						top: 0,
						left: 0,
						zIndex: 0
					} );

				} else if( html5_video_player.opt.containment.css( "position" ) == "static" )
					html5_video_player.opt.containment.css( {
						position: "relative"
					} );

				html5_video_player.opt.containment.prepend( wrapper );
				html5_video_player.wrapper = wrapper;

				html5_video_player.playerBox.css( {
					opacity: 1
				} );

				if( !jQuery.browser.mobile ) {
					html5_video_player.playerBox.after( overlay );
					html5_video_player.overlay = overlay;
				}

				if( !html5_video_player.isBackground ) {
					overlay.on( "mouseenter", function() {
						if( html5_video_player.controlBar && html5_video_player.controlBar.length )
							html5_video_player.controlBar.addClass( "visible" );
					} ).on( "mouseleave", function() {
						if( html5_video_player.controlBar && html5_video_player.controlBar.length )
							html5_video_player.controlBar.removeClass( "visible" );
					} );
				}

				html5_video_player.playerBox.on('canplaythrough', function(){

					var HVEvent;

					this.muted = html5_video_player.opt.mute;
					this.loop  = html5_video_player.opt.loop;
					this.controls = true;
					if( html5_video_player.opt.autoPlay ) {
						this.play();
					}
					else {
						jQuery.html5_video_player.buildControls(html5_video_player);
					}
					HVEvent = jQuery.Event( 'HVPReady' );
					$html5_video_player.trigger( HVEvent );
				} );

			} );
		},

		formatTime: function( s ) {
			var min = Math.floor( s / 60 );
			var sec = Math.floor( s - ( 60 * min ) );
			return( min <= 9 ? "0" + min : min ) + " : " + ( sec <= 9 ? "0" + sec : sec );
		},

		play: function() {
			var html5_video_player = this.get( 0 );
			if( !html5_video_player.isReady )
				return this;

			html5_video_player.playerBox.play();
			setTimeout( function() {
				html5_video_player.wrapper.fadeTo( html5_video_player.opt.fadeTime, html5_video_player.opt.opacity );
			}, 1000 );

			var controls = jQuery( "#controlBar_" + html5_video_player.id );

			if( controls.length ) {
				var playBtn = controls.find( ".mb_YTPPhtml5_video_player_playpause" );
				playBtn.html( jQuery.html5_video_player.controls.pause );
			}
			html5_video_player.state = 1;

			jQuery( html5_video_player ).css( "background-image", "none" );
			return this;
		},

		togglePlay: function( callback ) {
			var html5_video_player = this.get( 0 );
			if( html5_video_player.state == 1 )
				this.v_pause();
			else
				this.v_play();

			if( typeof callback == "function" )
				callback( html5_video_player.state );

			return this;
		},

		pause: function() {
			var html5_video_player = this.get( 0 );
			html5_video_player.playerBox.pause();
			html5_video_player.state = 2;
			return this;
		},

		seekTo: function( val, callback ) {
			var html5_video_player = this.get( 0 );

			var seekTo = html5_video_player.opt.stopAt && ( val >= html5_video_player.opt.stopAt ) ? html5_video_player.opt.stopAt - 0.5 : val;

			//html5_video_player.player.setCurrentTime( seekTo ).then( function( data ) {
			//	if( typeof callback == "function" )
			//		callback( data );
			//} );
			return this;
		},

		setVolume: function( val ) {

			var html5_video_player = this.get( 0 );

			/*
						console.debug( "setVolume:: ", val );
						console.debug( "volume:: ", html5_video_player.opt.vol );
			*/

			if( !val && !html5_video_player.opt.vol && html5_video_player.isMute )
				jQuery( html5_video_player ).v_unmute();
			else if( ( !val && !html5_video_player.isMute ) || ( val && html5_video_player.opt.vol == val ) ) {
				if( !html5_video_player.isMute )
					jQuery( html5_video_player ).v_unmute();
				else
					jQuery( html5_video_player ).v_mute();
			} else {

				html5_video_player.opt.vol = val;
				//html5_video_player.player.setVolume( html5_video_player.opt.vol );
				if( html5_video_player.volumeBar && html5_video_player.volumeBar.length )
					html5_video_player.volumeBar.updateSliderVal( val * 100 )
			}
			return this;
		},

		toggleVolume: function() {
			var html5_video_player = this.get( 0 );
			if( !html5_video_player ) return;

			//if( html5_video_player.isMute ) {
			//	jQuery( html5_video_player ).v_unmute();
			//	return true;
			//} else {
			//	jQuery( html5_video_player ).v_mute();
			//	return false;
			//}
		},

		mute: function() {
			var html5_video_player = this.get( 0 );
			if( html5_video_player.isMute )
				return;
			html5_video_player.isMute = true;
			//html5_video_player.player.setVolume( 0 );
			if( html5_video_player.volumeBar && html5_video_player.volumeBar.length && html5_video_player.volumeBar.width() > 10 ) {
				html5_video_player.volumeBar.updateSliderVal( 0 );
			}
			var controls = jQuery( "#controlBar_" + html5_video_player.id );
			var muteBtn = controls.find( ".html5_video_player_muteUnmute" );
			muteBtn.html( jQuery.html5_video_player.controls.unmute );

			jQuery( html5_video_player ).addClass( "isMuted" );

			if( html5_video_player.volumeBar && html5_video_player.volumeBar.length )
				html5_video_player.volumeBar.addClass( "muted" );

			return this;
		},

		unmute: function() {
			var html5_video_player = this.get( 0 );

			if( !html5_video_player.isMute )
				return;
			html5_video_player.isMute = false;

			jQuery( html5_video_player ).v_set_volume( html5_video_player.opt.vol );

			if( html5_video_player.volumeBar && html5_video_player.volumeBar.length ) html5_video_player.volumeBar.updateSliderVal( html5_video_player.opt.vol > .1 ? html5_video_player.opt.vol : .1 );
			var controls = jQuery( "#controlBar_" + html5_video_player.id );
			var muteBtn = controls.find( ".html5_video_player_muteUnmute" );
			muteBtn.html( jQuery.html5_video_player.controls.mute );
			jQuery( html5_video_player ).removeClass( "isMuted" );
			if( html5_video_player.volumeBar && html5_video_player.volumeBar.length )
				html5_video_player.volumeBar.removeClass( "muted" );

			return this;
		},

		changeMovie: function( obj ) {

			var html5_video_player = this.get( 0 );
			//html5_video_player.player.loadVideo( obj.url ).then( function( id ) {
			//	jQuery( html5_video_player ).v_setState();
			//} )
		},


		buildControls: function( html5_video_player ) {
			var data = html5_video_player.opt;

			if( jQuery( "#controlBar_" + html5_video_player.id ).length )
				return;

			html5_video_player.controlBar = jQuery( "<span/>" ).attr( "id", "controlBar_" + html5_video_player.id ).addClass( "html5_video_player_bar" ).css( {
				whiteSpace: "noWrap",
				position: html5_video_player.isBackground ? "fixed" : "absolute",
				zIndex: html5_video_player.isBackground ? 10000 : 1000
			} );
			var buttonBar = jQuery( "<div/>" ).addClass( "buttonBar" );
			/* play/pause button*/
			var playpause = jQuery( "<span>" + jQuery.html5_video_player.controls.play + "</span>" ).addClass( "html5_video_player_pause vimeo_icon" ).click( function() {
				if( html5_video_player.state == 1 ) jQuery( html5_video_player ).v_pause();
				else jQuery( html5_video_player ).v_play();
			} );
			/* mute/unmute button*/
			var MuteUnmute = jQuery( "<span>" + jQuery.html5_video_player.controls.mute + "</span>" ).addClass( "html5_video_player_muteUnmute vimeo_icon" ).click( function() {

				if( html5_video_player.isMute ) {
					jQuery( html5_video_player ).v_unmute();
				} else {
					jQuery( html5_video_player ).v_mute();
				}
			} );
			/* volume bar*/
			var volumeBar = jQuery( "<div/>" ).addClass( "html5_video_player_volume_bar" ).css( {
				display: "inline-block"
			} );
			html5_video_player.volumeBar = volumeBar;
			/* time elapsed */
			var idx = jQuery( "<span/>" ).addClass( "html5_video_player_time" );
			var vURL = "https://vimeo.com/" + html5_video_player.videoID;

			var movieUrl = jQuery( "<span/>" ).html( jQuery.html5_video_player.controls.logo ).addClass( "vimeo_url vimeo_icon" ).attr( "title", "view on Vimeo" ).on( "click", function() {

				//				console.debug( vURL );

				window.open( vURL, "viewOnVimeo" )
			} );

			var fullscreen = jQuery( "<span/>" ).html( jQuery.html5_video_player.controls.fullscreen ).addClass( "vimeo_fullscreen vimeo_icon" ).on( "click", function() {
				jQuery( html5_video_player ).v_fullscreen( data.realfullscreen );
			} );
			var progressBar = jQuery( "<div/>" ).addClass( "html5_video_player_pogress" ).css( "position", "absolute" ).click( function( e ) {
				timeBar.css( {
					width: ( e.clientX - timeBar.offset().left )
				} );
				html5_video_player.timeW = e.clientX - timeBar.offset().left;
				html5_video_player.controlBar.find( ".html5_video_player_loaded" ).css( {
					width: 0
				} );
				var totalTime = Math.floor( html5_video_player.duration );
				html5_video_player.goto = ( timeBar.outerWidth() * totalTime ) / progressBar.outerWidth();

				//				console.debug( html5_video_player.goto );

				jQuery( html5_video_player ).v_seekTo( parseFloat( html5_video_player.goto ) );
				html5_video_player.controlBar.find( ".html5_video_player_loaded" ).css( {
					width: 0
				} );
			} );
			var loadedBar = jQuery( "<div/>" ).addClass( "html5_video_player_loaded" ).css( "position", "absolute" );
			var timeBar = jQuery( "<div/>" ).addClass( "html5_video_player_seek_bar" ).css( "position", "absolute" );
			progressBar.append( loadedBar ).append( timeBar );
			buttonBar.append( playpause ).append( MuteUnmute ).append( volumeBar ).append( idx );
			if( data.show_vimeo_logo ) {
				buttonBar.append( movieUrl );
			}
			if( html5_video_player.isBackground || ( eval( html5_video_player.opt.realfullscreen ) && !html5_video_player.isBackground ) ) buttonBar.append( fullscreen );
			html5_video_player.controlBar.append( buttonBar ).append( progressBar );
			if( !html5_video_player.isBackground ) {
				//html5_video_player.controlBar.addClass( "inline_html5_video_player" );
				html5_video_player.wrapper.before( html5_video_player.controlBar );
			} else {
				jQuery( "body" ).after( html5_video_player.controlBar );
			}

			volumeBar.simpleSlider( {
				initialval: html5_video_player.opt.vol,
				scale: 100,
				orientation: "h",
				callback: function( el ) {
					if( el.value == 0 ) {
						jQuery( html5_video_player ).v_mute();
					} else {
						jQuery( html5_video_player ).v_unmute();
					}
					//html5_video_player.player.setVolume( el.value / 100 );

					if( !html5_video_player.isMute )
						html5_video_player.opt.vol = el.value;
				}
			} );
		},

		optimizeVimeoDisplay: function( align ) {

			var html5_video_player = this.get( 0 );
			var vid = {};

			html5_video_player.opt.align = align || html5_video_player.opt.align;

			html5_video_player.opt.align = typeof html5_video_player.opt.align != "undefined " ? html5_video_player.opt.align : "center,center";
			var YTPAlign = html5_video_player.opt.align.split( "," );

			if( html5_video_player.opt.optimizeDisplay ) {
				var abundance = html5_video_player.isPlayer ? 0 : 80;
				var win = {};
				var el = html5_video_player.wrapper;

				win.width = el.outerWidth();
				win.height = el.outerHeight() + abundance;

				vid.width = win.width;

				html5_video_player.opt.ratio = eval( html5_video_player.opt.ratio )

				//vid.height = html5_video_player.opt.ratio == "16/9" ? Math.ceil( vid.width * ( 9 / 16 ) ) : Math.ceil( vid.width * ( 3 / 4 ) );
				vid.height = Math.ceil( vid.width / html5_video_player.opt.ratio );

				vid.marginTop = -( ( vid.height - win.height ) / 2 );
				vid.marginLeft = 0;

				var lowest = vid.height < win.height;

				if( lowest ) {

					vid.height = win.height + abundance;
					//vid.width = html5_video_player.opt.ratio == "16/9" ? Math.floor( vid.height * ( 16 / 9 ) ) : Math.floor( vid.height * ( 4 / 3 ) );
					vid.width = Math.ceil( vid.height * html5_video_player.opt.ratio );

					vid.marginTop = 0;
					vid.marginLeft = -( ( vid.width - win.width ) / 2 );

				}

				for( var a in YTPAlign ) {

					if( YTPAlign.hasOwnProperty( a ) ) {

						var al = YTPAlign[ a ].replace( / /g, "" );

						switch( al ) {

							case "top":
								vid.marginTop = lowest ? -( ( vid.height - win.height ) / 2 ) : 0;
								break;

							case "bottom":
								vid.marginTop = lowest ? 0 : -( vid.height - win.height );
								break;

							case "left":
								vid.marginLeft = 0;
								break;

							case "right":
								vid.marginLeft = lowest ? -( vid.width - win.width ) : 0;
								break;

							default:
								if( vid.width > win.width )
									vid.marginLeft = -( ( vid.width - win.width ) / 2 );
								break;

						}
					}
				}

			} else {

				vid.width = "100%";
				vid.height = "100%";
				vid.marginTop = 0;
				vid.marginLeft = 0;

			}

			html5_video_player.playerBox.css( {

				width: vid.width,
				height: vid.height,
				marginTop: vid.marginTop,
				marginLeft: vid.marginLeft,
				maxWidth: "initial"

			} );

		},

		/**
		 *
		 * @param align
		 */
		setAlign: function( align ) {
			var $html5_video_player = this;

			$html5_video_player.v_optimize_display( align );
		},
		/**
		 *
		 * @param align
		 */
		getAlign: function() {
			var html5_video_player = this.get( 0 );
			return html5_video_player.opt.align;
		},


		fullscreen: function( real ) {
			var html5_video_player = this.get( 0 );
			var $html5_video_player = jQuery( html5_video_player );
			var VEvent;

			if( typeof real == "undefined" ) real = html5_video_player.opt.realfullscreen;
			real = eval( real );
			var controls = jQuery( "#controlBar_" + html5_video_player.id );
			var fullScreenBtn = controls.find( ".vimeo_fullscreen" );
			var videoWrapper = html5_video_player.isSelf ? html5_video_player.opt.containment : html5_video_player.wrapper;

			if( real ) {
				var fullscreenchange = jQuery.browser.mozilla ? "mozfullscreenchange" : jQuery.browser.webkit ? "webkitfullscreenchange" : "fullscreenchange";
				jQuery( document ).off( fullscreenchange ).on( fullscreenchange, function() {
					var isFullScreen = RunPrefixMethod( document, "IsFullScreen" ) || RunPrefixMethod( document, "FullScreen" );
					if( !isFullScreen ) {
						html5_video_player.isAlone = false;
						fullScreenBtn.html( jQuery.html5_video_player.controls.fullscreen );
						videoWrapper.removeClass( "html5_video_player_Fullscreen" );

						videoWrapper.fadeTo( html5_video_player.opt.fadeTime, html5_video_player.opt.opacity );

						videoWrapper.css( {
							zIndex: 0
						} );

						if( html5_video_player.isBackground ) {
							jQuery( "body" ).after( controls );
						} else {
							html5_video_player.wrapper.before( controls );
						}
						jQuery( window ).resize();
						// Trigger state events
						VEvent = jQuery.Event( 'VPFullScreenEnd' );
						$html5_video_player.trigger( VEvent );

					} else {
						// Trigger state events
						VEvent = jQuery.Event( 'VPFullScreenStart' );
						$html5_video_player.trigger( VEvent );
					}
				} );
			}
			if( !html5_video_player.isAlone ) {
				function hideMouse() {
					html5_video_player.overlay.css( {
						cursor: "none"
					} );
				}

				jQuery( document ).on( "mousemove.html5_video_player", function( e ) {
					html5_video_player.overlay.css( {
						cursor: "auto"
					} );
					clearTimeout( html5_video_player.hideCursor );
					if( !jQuery( e.target ).parents().is( ".html5_video_player_bar" ) )
						html5_video_player.hideCursor = setTimeout( hideMouse, 3000 );
				} );

				hideMouse();

				if( real ) {
					videoWrapper.css( {
						opacity: 0
					} );
					videoWrapper.addClass( "html5_video_player_Fullscreen" );
					launchFullscreen( videoWrapper.get( 0 ) );
					setTimeout( function() {
						videoWrapper.fadeTo( html5_video_player.opt.fadeTime, 1 );
						html5_video_player.wrapper.append( controls );
						jQuery( html5_video_player ).v_optimize_display();

					}, 500 )
				} else videoWrapper.css( {
					zIndex: 10000
				} ).fadeTo( html5_video_player.opt.fadeTime, 1 );
				fullScreenBtn.html( jQuery.html5_video_player.controls.showSite );
				html5_video_player.isAlone = true;
			} else {
				jQuery( document ).off( "mousemove.html5_video_player" );
				clearTimeout( html5_video_player.hideCursor );
				html5_video_player.overlay.css( {
					cursor: "auto"
				} );
				if( real ) {
					cancelFullscreen();
				} else {
					videoWrapper.fadeTo( html5_video_player.opt.fadeTime, html5_video_player.opt.opacity ).css( {
						zIndex: 0
					} );
				}
				fullScreenBtn.html( jQuery.html5_video_player.controls.fullscreen );
				html5_video_player.isAlone = false;
			}

			function RunPrefixMethod( obj, method ) {
				var pfx = [ "webkit", "moz", "ms", "o", "" ];
				var p = 0,
					m, t;
				while( p < pfx.length && !obj[ m ] ) {
					m = method;
					if( pfx[ p ] == "" ) {
						m = m.substr( 0, 1 ).toLowerCase() + m.substr( 1 );
					}
					m = pfx[ p ] + m;
					t = typeof obj[ m ];
					if( t != "undefined" ) {
						pfx = [ pfx[ p ] ];
						return( t == "function" ? obj[ m ]() : obj[ m ] );
					}
					p++;
				}
			}

			function launchFullscreen( element ) {
				RunPrefixMethod( element, "RequestFullScreen" );
			}

			function cancelFullscreen() {
				if( RunPrefixMethod( document, "FullScreen" ) || RunPrefixMethod( document, "IsFullScreen" ) ) {
					RunPrefixMethod( document, "CancelFullScreen" );
				}
			}

			return this;
		}

	};

	jQuery.fn.html5_video_player = jQuery.html5_video_player.buildPlayer;
	jQuery.fn.v_play = jQuery.html5_video_player.play;
	jQuery.fn.v_toggle_play = jQuery.html5_video_player.togglePlay;
	jQuery.fn.v_change_movie = jQuery.html5_video_player.changeMovie;
	jQuery.fn.v_pause = jQuery.html5_video_player.pause;
	jQuery.fn.v_seekTo = jQuery.html5_video_player.seekTo;
	jQuery.fn.v_optimize_display = jQuery.html5_video_player.optimizeVimeoDisplay;
	jQuery.fn.v_set_align = jQuery.html5_video_player.setAlign;
	jQuery.fn.v_get_align = jQuery.html5_video_player.getAlign;
	jQuery.fn.v_fullscreen = jQuery.html5_video_player.fullscreen;
	jQuery.fn.v_mute = jQuery.html5_video_player.mute;
	jQuery.fn.v_unmute = jQuery.html5_video_player.unmute;
	jQuery.fn.v_set_volume = jQuery.html5_video_player.setVolume;
	jQuery.fn.v_toggle_volume = jQuery.html5_video_player.toggleVolume;

} )( jQuery );
;/*___________________________________________________________________________________________________________________________________________________
 _ jquery.mb.components                                                                                                                             _
 _                                                                                                                                                  _
 _ file: jquery.mb.browser.min.js                                                                                                                   _
 _ last modified: 07/06/16 22.34                                                                                                                    _
 _                                                                                                                                                  _
 _ Open Lab s.r.l., Florence - Italy                                                                                                                _
 _                                                                                                                                                  _
 _ email: matteo@open-lab.com                                                                                                                       _
 _ site: http://pupunzi.com                                                                                                                         _
 _       http://open-lab.com                                                                                                                        _
 _ blog: http://pupunzi.open-lab.com                                                                                                                _
 _ Q&A:  http://jquery.pupunzi.com                                                                                                                  _
 _                                                                                                                                                  _
 _ Licences: MIT, GPL                                                                                                                               _
 _    http://www.opensource.org/licenses/mit-license.php                                                                                            _
 _    http://www.gnu.org/licenses/gpl.html                                                                                                          _
 _                                                                                                                                                  _
 _ Copyright (c) 2001-2016. Matteo Bicocchi (Pupunzi);                                                                                              _
 ___________________________________________________________________________________________________________________________________________________*/

var nAgt=navigator.userAgent;
if(!jQuery.browser){var isTouchSupported=function(){var a=nAgt.msMaxTouchPoints,b="ontouchstart"in document.createElement("div");return a||b?!0:!1};jQuery.browser={};jQuery.browser.mozilla=!1;jQuery.browser.webkit=!1;jQuery.browser.opera=!1;jQuery.browser.safari=!1;jQuery.browser.chrome=!1;jQuery.browser.androidStock=!1;jQuery.browser.msie=!1;jQuery.browser.edge=!1;jQuery.browser.hasTouch=isTouchSupported();jQuery.browser.ua=nAgt;jQuery.browser.name=navigator.appName;jQuery.browser.fullVersion=""+
		parseFloat(navigator.appVersion);jQuery.browser.majorVersion=parseInt(navigator.appVersion,10);var nameOffset,verOffset,ix;if(-1!=(verOffset=nAgt.indexOf("Opera")))jQuery.browser.opera=!0,jQuery.browser.name="Opera",jQuery.browser.fullVersion=nAgt.substring(verOffset+6),-1!=(verOffset=nAgt.indexOf("Version"))&&(jQuery.browser.fullVersion=nAgt.substring(verOffset+8));else if(-1!=(verOffset=nAgt.indexOf("OPR")))jQuery.browser.opera=!0,jQuery.browser.name="Opera",jQuery.browser.fullVersion=nAgt.substring(verOffset+
		4);else if(-1!=(verOffset=nAgt.indexOf("MSIE")))jQuery.browser.msie=!0,jQuery.browser.name="Microsoft Internet Explorer",jQuery.browser.fullVersion=nAgt.substring(verOffset+5);else if(-1!=nAgt.indexOf("Trident")){jQuery.browser.msie=!0;jQuery.browser.name="Microsoft Internet Explorer";var start=nAgt.indexOf("rv:")+3,end=start+4;jQuery.browser.fullVersion=nAgt.substring(start,end)}else-1!=(verOffset=nAgt.indexOf("Edge"))?(jQuery.browser.edge=!0,jQuery.browser.name="Microsoft Edge",jQuery.browser.fullVersion=
		nAgt.substring(verOffset+5)):-1!=(verOffset=nAgt.indexOf("Chrome"))?(jQuery.browser.webkit=!0,jQuery.browser.chrome=!0,jQuery.browser.name="Chrome",jQuery.browser.fullVersion=nAgt.substring(verOffset+7)):-1<nAgt.indexOf("mozilla/5.0")&&-1<nAgt.indexOf("android ")&&-1<nAgt.indexOf("applewebkit")&&!(-1<nAgt.indexOf("chrome"))?(verOffset=nAgt.indexOf("Chrome"),jQuery.browser.webkit=!0,jQuery.browser.androidStock=!0,jQuery.browser.name="androidStock",jQuery.browser.fullVersion=nAgt.substring(verOffset+
		7)):-1!=(verOffset=nAgt.indexOf("Safari"))?(jQuery.browser.webkit=!0,jQuery.browser.safari=!0,jQuery.browser.name="Safari",jQuery.browser.fullVersion=nAgt.substring(verOffset+7),-1!=(verOffset=nAgt.indexOf("Version"))&&(jQuery.browser.fullVersion=nAgt.substring(verOffset+8))):-1!=(verOffset=nAgt.indexOf("AppleWebkit"))?(jQuery.browser.webkit=!0,jQuery.browser.safari=!0,jQuery.browser.name="Safari",jQuery.browser.fullVersion=nAgt.substring(verOffset+7),-1!=(verOffset=nAgt.indexOf("Version"))&&(jQuery.browser.fullVersion=
		nAgt.substring(verOffset+8))):-1!=(verOffset=nAgt.indexOf("Firefox"))?(jQuery.browser.mozilla=!0,jQuery.browser.name="Firefox",jQuery.browser.fullVersion=nAgt.substring(verOffset+8)):(nameOffset=nAgt.lastIndexOf(" ")+1)<(verOffset=nAgt.lastIndexOf("/"))&&(jQuery.browser.name=nAgt.substring(nameOffset,verOffset),jQuery.browser.fullVersion=nAgt.substring(verOffset+1),jQuery.browser.name.toLowerCase()==jQuery.browser.name.toUpperCase()&&(jQuery.browser.name=navigator.appName));-1!=(ix=jQuery.browser.fullVersion.indexOf(";"))&&
(jQuery.browser.fullVersion=jQuery.browser.fullVersion.substring(0,ix));-1!=(ix=jQuery.browser.fullVersion.indexOf(" "))&&(jQuery.browser.fullVersion=jQuery.browser.fullVersion.substring(0,ix));jQuery.browser.majorVersion=parseInt(""+jQuery.browser.fullVersion,10);isNaN(jQuery.browser.majorVersion)&&(jQuery.browser.fullVersion=""+parseFloat(navigator.appVersion),jQuery.browser.majorVersion=parseInt(navigator.appVersion,10));jQuery.browser.version=jQuery.browser.majorVersion}
jQuery.browser.android=/Android/i.test(nAgt);jQuery.browser.blackberry=/BlackBerry|BB|PlayBook/i.test(nAgt);jQuery.browser.ios=/iPhone|iPad|iPod|webOS/i.test(nAgt);jQuery.browser.operaMobile=/Opera Mini/i.test(nAgt);jQuery.browser.windowsMobile=/IEMobile|Windows Phone/i.test(nAgt);jQuery.browser.kindle=/Kindle|Silk/i.test(nAgt);jQuery.browser.mobile=jQuery.browser.android||jQuery.browser.blackberry||jQuery.browser.ios||jQuery.browser.windowsMobile||jQuery.browser.operaMobile||jQuery.browser.kindle;
jQuery.isMobile=jQuery.browser.mobile;jQuery.isTablet=jQuery.browser.mobile&&765<jQuery(window).width();jQuery.isAndroidDefault=jQuery.browser.android&&!/chrome/i.test(nAgt);
;/*___________________________________________________________________________________________________________________________________________________
 _ jquery.mb.components                                                                                                                             _
 _                                                                                                                                                  _
 _ file: jquery.mb.simpleSlider.min.js                                                                                                              _
 _ last modified: 16/05/15 23.45                                                                                                                    _
 _                                                                                                                                                  _
 _ Open Lab s.r.l., Florence - Italy                                                                                                                _
 _                                                                                                                                                  _
 _ email: matteo@open-lab.com                                                                                                                       _
 _ site: http://pupunzi.com                                                                                                                         _
 _       http://open-lab.com                                                                                                                        _
 _ blog: http://pupunzi.open-lab.com                                                                                                                _
 _ Q&A:  http://jquery.pupunzi.com                                                                                                                  _
 _                                                                                                                                                  _
 _ Licences: MIT, GPL                                                                                                                               _
 _    http://www.opensource.org/licenses/mit-license.php                                                                                            _
 _    http://www.gnu.org/licenses/gpl.html                                                                                                          _
 _                                                                                                                                                  _
 _ Copyright (c) 2001-2015. Matteo Bicocchi (Pupunzi);                                                                                              _
 ___________________________________________________________________________________________________________________________________________________*/

var nAgt=navigator.userAgent;if(!jQuery.browser){jQuery.browser={},jQuery.browser.mozilla=!1,jQuery.browser.webkit=!1,jQuery.browser.opera=!1,jQuery.browser.safari=!1,jQuery.browser.chrome=!1,jQuery.browser.androidStock=!1,jQuery.browser.msie=!1,jQuery.browser.ua=nAgt,jQuery.browser.name=navigator.appName,jQuery.browser.fullVersion=""+parseFloat(navigator.appVersion),jQuery.browser.majorVersion=parseInt(navigator.appVersion,10);var nameOffset,verOffset,ix;if(-1!=(verOffset=nAgt.indexOf("Opera")))jQuery.browser.opera=!0,jQuery.browser.name="Opera",jQuery.browser.fullVersion=nAgt.substring(verOffset+6),-1!=(verOffset=nAgt.indexOf("Version"))&&(jQuery.browser.fullVersion=nAgt.substring(verOffset+8));else if(-1!=(verOffset=nAgt.indexOf("OPR")))jQuery.browser.opera=!0,jQuery.browser.name="Opera",jQuery.browser.fullVersion=nAgt.substring(verOffset+4);else if(-1!=(verOffset=nAgt.indexOf("MSIE")))jQuery.browser.msie=!0,jQuery.browser.name="Microsoft Internet Explorer",jQuery.browser.fullVersion=nAgt.substring(verOffset+5);else if(-1!=nAgt.indexOf("Trident")||-1!=nAgt.indexOf("Edge")){jQuery.browser.msie=!0,jQuery.browser.name="Microsoft Internet Explorer";var start=nAgt.indexOf("rv:")+3,end=start+4;jQuery.browser.fullVersion=nAgt.substring(start,end)}else-1!=(verOffset=nAgt.indexOf("Chrome"))?(jQuery.browser.webkit=!0,jQuery.browser.chrome=!0,jQuery.browser.name="Chrome",jQuery.browser.fullVersion=nAgt.substring(verOffset+7)):nAgt.indexOf("mozilla/5.0")>-1&&nAgt.indexOf("android ")>-1&&nAgt.indexOf("applewebkit")>-1&&!(nAgt.indexOf("chrome")>-1)?(verOffset=nAgt.indexOf("Chrome"),jQuery.browser.webkit=!0,jQuery.browser.androidStock=!0,jQuery.browser.name="androidStock",jQuery.browser.fullVersion=nAgt.substring(verOffset+7)):-1!=(verOffset=nAgt.indexOf("Safari"))?(jQuery.browser.webkit=!0,jQuery.browser.safari=!0,jQuery.browser.name="Safari",jQuery.browser.fullVersion=nAgt.substring(verOffset+7),-1!=(verOffset=nAgt.indexOf("Version"))&&(jQuery.browser.fullVersion=nAgt.substring(verOffset+8))):-1!=(verOffset=nAgt.indexOf("AppleWebkit"))?(jQuery.browser.webkit=!0,jQuery.browser.safari=!0,jQuery.browser.name="Safari",jQuery.browser.fullVersion=nAgt.substring(verOffset+7),-1!=(verOffset=nAgt.indexOf("Version"))&&(jQuery.browser.fullVersion=nAgt.substring(verOffset+8))):-1!=(verOffset=nAgt.indexOf("Firefox"))?(jQuery.browser.mozilla=!0,jQuery.browser.name="Firefox",jQuery.browser.fullVersion=nAgt.substring(verOffset+8)):(nameOffset=nAgt.lastIndexOf(" ")+1)<(verOffset=nAgt.lastIndexOf("/"))&&(jQuery.browser.name=nAgt.substring(nameOffset,verOffset),jQuery.browser.fullVersion=nAgt.substring(verOffset+1),jQuery.browser.name.toLowerCase()==jQuery.browser.name.toUpperCase()&&(jQuery.browser.name=navigator.appName));-1!=(ix=jQuery.browser.fullVersion.indexOf(";"))&&(jQuery.browser.fullVersion=jQuery.browser.fullVersion.substring(0,ix)),-1!=(ix=jQuery.browser.fullVersion.indexOf(" "))&&(jQuery.browser.fullVersion=jQuery.browser.fullVersion.substring(0,ix)),jQuery.browser.majorVersion=parseInt(""+jQuery.browser.fullVersion,10),isNaN(jQuery.browser.majorVersion)&&(jQuery.browser.fullVersion=""+parseFloat(navigator.appVersion),jQuery.browser.majorVersion=parseInt(navigator.appVersion,10)),jQuery.browser.version=jQuery.browser.majorVersion}jQuery.browser.android=/Android/i.test(nAgt),jQuery.browser.blackberry=/BlackBerry|BB|PlayBook/i.test(nAgt),jQuery.browser.ios=/iPhone|iPad|iPod|webOS/i.test(nAgt),jQuery.browser.operaMobile=/Opera Mini/i.test(nAgt),jQuery.browser.windowsMobile=/IEMobile|Windows Phone/i.test(nAgt),jQuery.browser.kindle=/Kindle|Silk/i.test(nAgt),jQuery.browser.mobile=jQuery.browser.android||jQuery.browser.blackberry||jQuery.browser.ios||jQuery.browser.windowsMobile||jQuery.browser.operaMobile||jQuery.browser.kindle,jQuery.isMobile=jQuery.browser.mobile,jQuery.isTablet=jQuery.browser.mobile&&jQuery(window).width()>765,jQuery.isAndroidDefault=jQuery.browser.android&&!/chrome/i.test(nAgt);

(function(b){b.simpleSlider={defaults:{initialval:0,scale:100,orientation:"h",readonly:!1,callback:!1},events:{start:b.browser.mobile?"touchstart":"mousedown",end:b.browser.mobile?"touchend":"mouseup",move:b.browser.mobile?"touchmove":"mousemove"},init:function(c){return this.each(function(){var a=this,d=b(a);d.addClass("simpleSlider");a.opt={};b.extend(a.opt,b.simpleSlider.defaults,c);b.extend(a.opt,d.data());var e="h"==a.opt.orientation?"horizontal":"vertical",e=b("<div/>").addClass("level").addClass(e);
	d.prepend(e);a.level=e;d.css({cursor:"default"});"auto"==a.opt.scale&&(a.opt.scale=b(a).outerWidth());d.updateSliderVal();a.opt.readonly||(d.on(b.simpleSlider.events.start,function(c){b.browser.mobile&&(c=c.changedTouches[0]);a.canSlide=!0;d.updateSliderVal(c);"h"==a.opt.orientation?d.css({cursor:"col-resize"}):d.css({cursor:"row-resize"});c.preventDefault();c.stopPropagation()}),b(document).on(b.simpleSlider.events.move,function(c){b.browser.mobile&&(c=c.changedTouches[0]);a.canSlide&&(b(document).css({cursor:"default"}),
			d.updateSliderVal(c),c.preventDefault(),c.stopPropagation())}).on(b.simpleSlider.events.end,function(){b(document).css({cursor:"auto"});a.canSlide=!1;d.css({cursor:"auto"})}))})},updateSliderVal:function(c){var a=this.get(0);if(a.opt){a.opt.initialval="number"==typeof a.opt.initialval?a.opt.initialval:a.opt.initialval(a);var d=b(a).outerWidth(),e=b(a).outerHeight();a.x="object"==typeof c?c.clientX+document.body.scrollLeft-this.offset().left:"number"==typeof c?c*d/a.opt.scale:a.opt.initialval*d/a.opt.scale;
	a.y="object"==typeof c?c.clientY+document.body.scrollTop-this.offset().top:"number"==typeof c?(a.opt.scale-a.opt.initialval-c)*e/a.opt.scale:a.opt.initialval*e/a.opt.scale;a.y=this.outerHeight()-a.y;a.scaleX=a.x*a.opt.scale/d;a.scaleY=a.y*a.opt.scale/e;a.outOfRangeX=a.scaleX>a.opt.scale?a.scaleX-a.opt.scale:0>a.scaleX?a.scaleX:0;a.outOfRangeY=a.scaleY>a.opt.scale?a.scaleY-a.opt.scale:0>a.scaleY?a.scaleY:0;a.outOfRange="h"==a.opt.orientation?a.outOfRangeX:a.outOfRangeY;a.value="undefined"!=typeof c?
					"h"==a.opt.orientation?a.x>=this.outerWidth()?a.opt.scale:0>=a.x?0:a.scaleX:a.y>=this.outerHeight()?a.opt.scale:0>=a.y?0:a.scaleY:"h"==a.opt.orientation?a.scaleX:a.scaleY;"h"==a.opt.orientation?a.level.width(Math.floor(100*a.x/d)+"%"):a.level.height(Math.floor(100*a.y/e));"function"==typeof a.opt.callback&&a.opt.callback(a)}}};b.fn.simpleSlider=b.simpleSlider.init;b.fn.updateSliderVal=b.simpleSlider.updateSliderVal})(jQuery);
