<?php

if(!defined('MPL_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}



add_action( 'widgets_init', 'mpl_register_widgets' );
function mpl_register_widgets() {
	register_widget( 'mpl_widget_content' );
}
class mpl_widget_content extends WP_Widget {

	function __construct() {
		$widget = array( 'classname' => 'mpl_widget_content', 'description' => __('Display content is built by Page Builder', 'mageewp-page-layout') );
		$control= array( 'width' => 250, 'height' => 350, 'id_base' => 'mpl_widget_content' );
		parent::__construct('mpl_widget_content','MPL Content', $widget, $control);
	}
	
	function widget( $args, $instance ) {
		
		global $mpl, $post, $mpl_prevent_infinity_loop;
		
		if (!isset($mpl_prevent_infinity_loop))
			$mpl_prevent_infinity_loop = array();
			
		extract( $args );

		$title = empty( $instance['title'] ) ? '' : $instance['title'];
		$title_as = empty( $instance['title_as'] ) ? '' : $instance['title_as'];
		
		$id 	= empty( $instance['id'] ) ? '' : $instance['id'];
		$class 	= empty( $instance['class'] ) ? '' : $instance['class'];

		if (strpos ($id, '#') !== false)
		{
			$id = explode('#', $id);
			$id = trim ($id[1]);
				
			if (isset($post) && (is_object($post) && $id == $post->ID) || (isset($mpl_prevent_infinity_loop[$id]) && $mpl_prevent_infinity_loop[$id] === true))
			{
				echo '<div class="mpl-content-widget">Error: Infinite loop, do not include widget into itself.</div>';
				return false;
			}
			
			$mpl_prevent_infinity_loop[$id] = true;
			
			if($title_as == 'yes')
				$title = get_the_title($id);
			
		}else{
			echo '<div class="mpl-content-widget">Error: Please select a widget content to display</div>';
			return false;
		}
		
		if( !empty( $instance['class'] ) ){
			$before_widget = str_replace( 'class="', 'class="'.$class.' ', $before_widget );
		}

		echo $before_widget;
		
		if (!empty($title))
		{
			echo $before_title;
			echo $title;
			echo $after_title;
		}
			
		echo '<div class="mpl-content-widget">';
		echo $mpl->do_shortcode( mpl_raw_content($id) );
		echo '</div>';
		
		unset ($mpl_prevent_infinity_loop[$id]);
		
		echo $after_widget;
		
	}

	function update( $new, $old ) {
		
		$inst = $old;
		
		$inst['title'] = strip_tags( $new['title'] );
		$inst['title_as'] = strip_tags( $new['title_as'] );
		$inst['id'] = strip_tags( $new['id'] );
		$inst['class'] = strip_tags( $new['class'] );
		
		return $inst;
		
	}

	function form( $instance ) {
		
		$defaults = array( 
			'title' => __('MPL Widget Content', 'mageewp-page-layout'), 
			'title_as' => '', 
			'id' => '',
			'class' => '' 
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<!--label class="notice" style="color:red">Notice: Not work on localhost</label-->
		
		<p>
			
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php _e('Title', 'mageewp-page-layout'); ?>: 
			</label>
			
			<input id="<?php 
				echo esc_attr( $this->get_field_id( 'title' ) ); 
			?>" name="<?php
				echo esc_attr( $this->get_field_name( 'title' ) ); 
			?>" value="<?php 
				echo esc_attr( $instance['title'] ); 
			?>" class="widefat" type="text" />
			
		</p>
		<p>
			
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_as' ) ); ?>">
				<?php _e('Use post title', 'mageewp-page-layout'); ?>?: 
			</label>
			<input id="<?php 
				echo esc_attr( $this->get_field_id( 'title_as' ) ); 
			?>" name="<?php
				echo esc_attr( $this->get_field_name( 'title_as' ) ); 
			?>" value="yes"<?php 
				if (esc_attr( $instance['title_as'] ) == 'yes')
				{
					echo ' checked="checked"';
				}
			?>" class="checkbox" type="checkbox" />
		</p>
		
		<p class="mpl-widget-content-pid">
		
			<label for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>">
				<?php _e('Content Filters', 'mageewp-page-layout'); ?>: 
			</label>
			
			<input class="widefat" type="text" onkeyup="<?php
				ob_start();
				?>
				 if (this.value.length < 2)
				 	return;
				 	
				_$ = jQuery;
				
				rst = _$(this.parentNode.parentNode).find('select#<?php echo esc_attr( $this->get_field_id( 'select' ) );?>');
				rid = _$(this.parentNode.parentNode).find('input#<?php echo esc_attr( $this->get_field_id( 'id' ) );?>');
	
				rst.show().html('<option>Loading...</option>').off('change').on('change', function(){
					rid.attr('value', this.value);
				});
				 
				_$.post(
					
					ajaxurl,
				
					{
						'action': 'mpl_suggestion',
						'security': '<?php echo wp_create_nonce( "mpl-nonce" ); ?>',
						's': this.value,
						'field_name': 'widget_content'
					},
					
					function( result ){
						rst.html('');
						for( n in result )
						{
							if (rst.html() === '')
							{
								rid.attr('value', result[n]+' #'+n);
							}
							rst.append('<option value="'+result[n]+' #'+n+'">'+result[n]+'</option>');
						}
					}
				);
				 
				<?php	
				$content = ob_get_contents();
				ob_end_clean();
				
				echo esc_attr (str_replace (array("	", "  ", "\n"), array('', ' ', ''), $content));
				
			?>" placeholder="<?php _e('Type least 2 characters', 'mageewp-page-layout'); ?>" />
			<select style="display:none;width: 100%;max-width: 100%;margin-top: -1px;" id="<?php 
				echo esc_attr( $this->get_field_id( 'select' ) ); 
			?>" class="widefat"></select>
			
		</p>
		
		<p>
		
			<input id="<?php 
				echo esc_attr( $this->get_field_id( 'id' ) ); 
			?>" name="<?php 
				echo esc_attr( $this->get_field_name( 'id' ) ); 
			?>" value="<?php 
				echo esc_attr( $instance['id'] );
			?>" class="widefat" type="text" readonly />
			<?php 
				$id = explode( ':', esc_attr( $instance['id'] ) );
			?>
			<a class="button" onclick="var id=this.parentNode.getElementsByTagName('input')[0].value.split('#')[1];if(id!=='')window.open(this.href+id);return false;" href="<?php echo admin_url('/post.php?action=edit&post='); ?>" style="margin-top:8px;">
				<?php _e('Edit widget', 'mageewp-page-layout'); ?>
			</a>
			
		</p>
		
		<p>
		
			<label for="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>">
				<?php _e('Widget Class', 'mageewp-page-layout'); ?>: 
			</label>
			
			<input id="<?php 
				echo esc_attr( $this->get_field_id( 'class' ) ); 
			?>" name="<?php 
				echo esc_attr( $this->get_field_name( 'class' ) ); 
			?>" value="<?php 
				echo esc_attr( $instance['class'] );
			?>" class="widefat" type="text" />
			
		</p>
	<?php
	}
	
}

