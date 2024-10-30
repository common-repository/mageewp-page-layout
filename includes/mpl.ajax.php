<?php

if(!defined('MPL_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

class mpl_ajax{

	public function __construct(){

		$ajax_events = array(
			'get_thumbn' 		=> true,
			'get_featured' 		=> true,
            'get_thumbn_size' 	=> true,
			'load_profile'		=> false,
			'download_profile'	=> false,
			'create_profile'	=> false,
			'rename_profile'	=> false,
			'delete_profile'	=> false,
			'delete_section'	=> false,
			'update_section'	=> false,
			'instant_save'		=> false,
			'suggestion'		=> false,
			'tmpl_storage'		=> false,
			'kcp_access'		=> false,
			'revoke_domain'		=> false,
			'download_pro'		=> false,
			'update_plugin'		=> false,
			'add_font'			=> false,
			'update_font'		=> false,
			'delete_font'		=> false,
			'load_sections'		=> array(false,'pro'),
			'load_section'		=> false,
			'push_section'		=> false,
			'update_option'		=> false,
			'update_mapper'		=> false,
			'enable_optimized'	=> false,
			'share_section'		=> false,
			'load_element_via_ajax'	=> false,
			'post_update'       => false,
			'post_meta_update'  => false,
			'front_section_data' => true,
			'get_recent_posts_data' => false,
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {

			add_action( 'wp_ajax_mpl_' . $ajax_event, array( $this, esc_attr( $ajax_event ) ) );
			
			if(is_array($nopriv) && $nopriv[1] == 'pro' && defined('MPL_PRO_FILE'))
			remove_action( 'wp_ajax_mpl_' . $ajax_event, array( $this, esc_attr( $ajax_event ) ) );

			if ( $nopriv && !is_array($nopriv) ) {
				add_action( 'wp_ajax_nopriv_mpl_' . $ajax_event, array( $this, esc_attr( $ajax_event ) ) );
			}
		}
	}


	public function get_thumbn(){
		
		$id = !empty( $_GET['id'] ) ? esc_attr($_GET['id']) : '';
		$size = !empty( $_GET['size'] ) ? esc_attr($_GET['size']) : 'medium';
		$type = !empty( $_GET['type'] ) ? esc_attr($_GET['type']) : '';
		
		
		  if (preg_match('/http|https:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$id))
		  {
		    header( 'location: '.$id);
			exit;
		  }
		  
			  
		if ($type == 'filter_url') {
			header( 'location: '.mpl_attach_url(MPL_SITE.urldecode($id)));
			exit;
		}
		
		if( $id == '' || $id == 'undefined' )
		{
			header( 'location: '.MPL_URL.'/assets/images/get_start.jpg' );
			exit;
		}

		if( $type == 'post_featured' )
		{
			
			
			$img = get_the_post_thumbnail_url( $id, $size );
			if (strpos($source, site_url()) !== false) {
				$meta = get_post_meta( $id, 'mpl_data', true );
				if (!empty($meta) && isset($meta['thumbnail']))
					$img = $meta['thumbnail'];
			}
			if( !empty( $img ) ){
				header( 'location: '.$img );
			}else{
				header( 'location: '.MPL_URL.'/assets/images/get_start_section.jpg' );
			}
			
			exit;
			
		}

		$img = wp_get_attachment_image_src( $id, $size );

		if( !empty( $img[0] ) )
		{
			header( 'location: '.$img[0] );
		}
		else
		{
			header( 'location: '.MPL_URL.'/assets/images/default.jpg' );
		}
	}

    public function get_thumbn_size( $abc ){

        $imid = !empty( $_GET['id'] ) ? esc_attr( $_GET['id'] ) : '';
        $size = !empty( $_GET['size'] ) ? esc_attr( $_GET['size'] ) : '';

        if( empty($imid) || $imid == 'undefined' )
        {
            header( 'location: '.MPL_URL.'/assets/images/get_start.jpg' );
            exit;
        }

        $img = wp_get_attachment_image_src( $imid, 'full' );

        if( !empty($img[0]) )
        {
	        if ( !empty($size) )
          		$re_img = mpl_tools::createImageSize( $img[0], $size);
          	if (!empty($re_img))	
          		header( 'location: '.$re_img );
          	else header( 'location: '.$img[0] );
        }
        else
        {
            header( 'location: '.MPL_URL.'/assets/images/default.jpg' );
        }
    }

	public function download_profile(){
		
		$name = isset( $_GET['name'] ) ? $_GET['name'] : '';
		
		if( empty( $name ) ){
			echo '[]';
			exit;
		}
		
		$name = sanitize_title( esc_attr( $name ) );
		
		if( get_option( 'mpl-profile-'.$name ) !== false ){
			
			$data = get_option( 'mpl-profile-'.$name, true );
			
			if( isset( $data[1] ) && !empty( $data[1] ) )
				echo base64_decode( $data[1] );
			else echo '[]';
			
		}else echo '[]';
		
		exit;
		
	}
		
	public function load_profile(){

		global $mpl;
		$profile_section_paths = $mpl->get_profile_sections();
		
		$name =  !empty( $_POST['name'] ) ? $_POST['name'] : '';
		$name = str_replace( array('..'), array( '' ), esc_attr( $name )  );
		
		$data = '';
		$slug = sanitize_title( $name );
		
		if( $name == '' ){
			
			$result = array(
				'message' =>  esc_html__('Error #623! The name must not be empty', 'mageewp-page-layout'),
				'status' => 'fail'
			);
			
		}
		else{
			
			if( isset( $profile_section_paths[ $name ] ) && is_file( untrailingslashit( ABSPATH ).$profile_section_paths[ $name ] ) ){
				
				$profile = $mpl->get_data_profile( $name );
			
				if( $profile !== false ){
					
					if( isset( $profile[0] ) && !empty( $profile[0] ) && $profile[0] !== null )
						$name = $profile[0];
					if( isset( $profile[1] ) && !empty( $profile[1] ) && $profile[1] !== null )
						$slug = $profile[1];
					if( isset( $profile[2] ) && !empty( $profile[2] ) && $profile[2] !== null )
						$data = $profile[2];
					
				}else{
					
					$message = esc_html__('Error #795! opening file Permission denied', 'mageewp-page-layout').': '.
								$profile_section_paths[ $name ];
					wp_send_json(
						array( 'message' => $message, 'status' => 'fail' )
					);
					
					return;
					
				}
				
			} 
			else if( get_option( 'mpl-profile-'.$name ) !== false ){
				
				$getDB =  get_option( 'mpl-profile-'.$name, true );
				
				$slug = $name;
				if( isset( $getDB[0] ) && !empty( $getDB[0] ) && $getDB[0] !== null )
					$name = $getDB[0];
				else $name = '';
				
				if( isset( $getDB[1] ) && !empty( $getDB[1] ) && $getDB[1] !== null )
					$data = $getDB[1];
				else $data = base64_encode('');
				
			}
			else{
				
				$message = esc_html__('Error #528! profile not found', 'mageewp-page-layout').': '.$name;
				wp_send_json(
					array( 'message' => $message, 'status' => 'fail' )
				);
				return;
			
			}

		}
		
		$result = array(

			'message' => '<div class="mgs-c-status"><i class="et-happy"></i></div><h1 class="mgs-t02">'.
						 esc_html__('Your sections profile has been downloaded successful', 'mageewp-page-layout').'</h1>'.
						 '<h2>'.esc_html__('Now you can use sections from new profile', 'mageewp-page-layout').'</h2>',
			'status' => 'success',
			'name' => $name,
			'slug' => $slug,
			'data' => $data

		);
			
		wp_send_json( $result );

		exit;

	}
	
	public function create_profile(){
		
		$name =  !empty( $_POST['name'] ) ? $_POST['name'] : '';
		
		if( $name == '' ){
			
			$result = array(
				'message' =>  esc_html__('Error #140! The name must not be empty', 'mageewp-page-layout'),
				'status' => 'fail'
			);
			
		}else{
		
			$slug =  !empty( $_POST['slug'] ) ? $_POST['slug'] : sanitize_title( $name );
			$data =  !empty( $_POST['data'] ) ? $_POST['data'] : '';
			
			if( get_option( 'mpl-profile-'.$slug ) === false ){
				
				add_option( 'mpl-profile-'.$slug, array( $name, $data ), null, 'no' );
				
				$result = array(
					'message' => __('Your sections profile has been created successful', 'mageewp-page-layout'),
					'status' => 'success',
					'name' => $name,
					'slug' => $slug
				);
				
			}else{
				
				$result = array(
					'message' =>  esc_html__('Error #101! The name must not be empty', 'mageewp-page-layout'),
					'status' => 'fail',
					'name' => $name,
					'slug' => $slug
				);
			}
		
		}
			
		wp_send_json( $result );

		exit;
		
	}
	
	public function rename_profile(){
		
		
		$name =  !empty( $_POST['name'] ) ? $_POST['name'] : '';
		
		if( $name == '' ){
			
			$result = array(
				'message' =>  esc_html__('Error #197! The name must not be empty', 'mageewp-page-layout'),
				'status' => 'fail'
			);
			
		}else{
		
			$slug =  !empty( $_POST['slug'] ) ? $_POST['slug'] : sanitize_title( $name );
			$data =  !empty( $_POST['data'] ) ? $_POST['data'] : '';
				
			if( get_option( 'mpl-profile-'.$slug ) === false ){
					
				$result = array(
					'message' => __('Error #501! could not find profile', 'mageewp-page-layout'),
					'status' => 'fail',
					'name' => $name,
					'slug' => $slug
				);
				
			}else{
				
				$data_db = get_option( 'mpl-profile-'.$slug, true );
				
				$data_db[0] = $name;
				
				update_option( 'mpl-profile-'.$slug, $data_db );
				
				
				$result = array(
					'message' =>  esc_html__('The profile has been changed', 'mageewp-page-layout'),
					'status' => 'success',
					'name' => $name,
					'slug' => $slug
				);
				
			}
		
		}
			
		wp_send_json( $result );

		exit;
		
	}
		
	public function delete_profile(){
		
		
		$slug =  !empty( $_POST['slug'] ) ? $_POST['slug'] : '';
		
		if( $slug == '' ){
			
			$result = array(
				'message' =>  esc_html__('Error #167! The slug must not be empty', 'mageewp-page-layout'),
				'status' => 'fail'
			);
			
		}else{
				
			if( get_option( 'mpl-profile-'.$slug ) === false ){
			
				$result = array(
					'message' => __('Error #723! could not find profile', 'mageewp-page-layout'),
					'status' => 'fail',
					'slug' => $slug
				);
			}else{
				
				delete_option( 'mpl-profile-'.$slug );
				
				$result = array(
					'message' =>  esc_html__('The profile has been deleted', 'mageewp-page-layout'),
					'status' => 'success',
					'slug' => $slug
				);
			}
			
		
		}
			
		wp_send_json( $result );

		exit;
		
	}
	
	public function update_section(){
		
		$slug =  !empty( $_POST['slug'] ) ? $_POST['slug'] : '';
		
		if( $slug == '' ){
			
			$result = array(
				'message' =>  esc_html__('Error #193! The slug must not be empty', 'mageewp-page-layout'),
				'status' => 'fail'
			);
			
		}else{
			
			$id =  !empty( $_POST['id'] ) ? $_POST['id'] : '';
			$name =  !empty( $_POST['name'] ) ? $_POST['name'] : '';
			$data =  !empty( $_POST['data'] ) ? $_POST['data'] : '';
			
			if( !empty( $data ) )
				$data = json_decode( base64_decode( $data ) );
				
			if( get_option( 'mpl-profile-'.$slug ) === false ){
				
				global $mpl;
				$profile = $mpl->get_data_profile( $slug );
				
				if( $profile !== false ){
					
					$profile_data = json_decode( base64_decode( $profile[2] ) );
					$found = false;
					
					foreach( $profile_data as $key => $value ){
						if( $value->id == $id ){
							$profile_data[ $key ] = $data;
							$found = true;
						}
					}
					
					if( $found === false )
						array_push( $profile_data, $data );
					
					$data = base64_encode( json_encode( $profile_data ) );
				
				}else{
				
					$data = base64_encode( json_encode( array( $data ) ) );
				
				}
				
				add_option( 'mpl-profile-'.$slug, array( $name, $data ) , null, 'no' );
				
				$result = array(
					'message' =>  esc_html__('The section has been updated', 'mageewp-page-layout'),
					'status' => 'success',
					'name' => $name,
					'data' => $data,
					'slug' => $slug
				);
				
				
			}
			else
			{
				
				$data_db = get_option( 'mpl-profile-'.$slug, true );
				
				$from_db = json_decode( base64_decode( $data_db[1] ) );
				
				if( is_array( $from_db ) ){
				
					$found = false;
					
					if( is_array( $from_db ) ){
						foreach( $from_db as $key => $val ){
							
							if( $val->id == $id ){
								$from_db[ $key ] = $data;
								$found = true;
							}
							
						}
					}
					
					if( !$found )
						array_push( $from_db, $data );
				
				}else{
					$from_db = array( $data );
				}
					
				$from_db = base64_encode( json_encode( $from_db ) );
				
				update_option( 'mpl-profile-'.$slug, array( $data_db[0], $from_db ) );
				
				
				$result = array(
					'message' =>  esc_html__('The section has been updated', 'mageewp-page-layout'),
					'status' => 'success',
					'name' => $data_db[0],
					'data' => $from_db,
					'slug' => $slug
				);
				
			}
		
		}
			
		wp_send_json( $result );

		exit;
		

	}
	
	public function delete_section(){ 
		
		$name =  isset( $_POST['name'] ) ? $_POST['name'] : '';
		$id =  isset( $_POST['id'] ) ? $_POST['id'] : '';
		$slug =  !empty( $_POST['slug'] ) ? $_POST['slug'] : sanitize_title( $name );
		$data =  !empty( $_POST['data'] ) ? $_POST['data'] : '';
			
		if( get_option( 'mpl-profile-'.$slug ) === false ){
			
			$sections = json_decode( base64_decode( $data ) );
			
			if( is_array( $sections ) ){
				
				$data = array();
				
				foreach( $sections as $key => $value ){
					
					if( !isset( $value->id ) )
						$value->id = rand( 100000, 1000000 );
					
					if( $value->id != $id )
						array_push( $data, $value );
				}
				
				$data = base64_encode( json_encode( $data ) );
				
				add_option( 'mpl-profile-'.$slug, array( $name, $data ) , null, 'no' );
			
				$result = array(
					'message' =>  esc_html__('The section has been removed', 'mageewp-page-layout'),
					'status' => 'success',
					'name' => $name,
					'data' => $data,
					'slug' => $slug
				);
				
			}else{
				
				$result = array(
					'message' =>  esc_html__('Error profile data structure #416', 'mageewp-page-layout'),
					'status' => 'fail',
					'name' => $name,
					'slug' => $slug
				);
				
			}
			
		}else{
			
			$data_db = get_option( 'mpl-profile-'.$slug, true );
			
			$sections = @json_decode( base64_decode( $data_db[1] ) );
			
			if( is_array( $sections ) ){
				
				$data = array();
				
				foreach( $sections as $key => $value ){
					
					if( !isset( $value->id ) )
						$value->id = rand( 100000, 1000000 );
					
					if( $value->id != $id )
						array_push( $data, $value );
						
				}
				
				$data_db[1] = base64_encode( json_encode( $data ) );
				
				update_option( 'mpl-profile-'.$slug, $data_db );
			
			
				$result = array(
					'message' =>  esc_html__('The section has been removed', 'mageewp-page-layout'),
					'status' => 'success',
					'name' => $data_db[0],
					'data' => $data_db[1],
					'slug' => $slug
				);
				
			}else{
				
				$result = array(
					'message' =>  esc_html__('Error profile data structure #426', 'mageewp-page-layout'),
					'status' => 'fail',
					'name' => $data_db[0],
					'slug' => $slug
				);
				
			}
			
		}
		
		wp_send_json( $result );

		exit;
	
	}
	
	public function update_option(){
	    
        check_ajax_referer( 'mpl-nonce', 'security' );
        
        $data = json_decode(base64_decode($_POST['options']), true);
        
        if( count( $data ) >0 ){
            foreach( $data as $k => $v ){
                echo $k;
                if( !empty( $k ))
                    update_option( $k, $v );
            }
        }
        
        $result = array(
            'message' =>  esc_html__('Update options successful', 'mageewp-page-layout'),
            'status' => 'success',
        );
        
        wp_send_json( $result );
    }
    	
	public function update_mapper(){
	    
        check_ajax_referer( 'mpl-mapper-nonce', 'security' );
        
        if (empty($_POST['tag']) || empty($_POST['task']) || (empty($_POST['data']) && $_POST['task'] == 'update'))
        {
	        wp_send_json(array(
	            'message' =>  esc_html__('Error: Missing data', 'mageewp-page-layout'),
	            'stt' => 0,
	        ));
	        exit;
        }
        
        $data = json_decode(base64_decode($_POST['data']), true);

        $tag = $_POST['tag'];
        $task = $_POST['task'];
        
        $data = apply_filters('mpl_update_mapper', $data, $tag, $task);
        
        $datas = get_option('mpl_shortcodes_mapper', true);
        
        if (!$datas)
	        add_option('mpl_shortcodes_mapper', array(), null, 'no');
        
        if (!is_array($datas))
	        $datas = array();
        
        if ($task == 'update' && is_array($data)) 
        {
	        $datas[$tag] = $data;
	        update_option('mpl_shortcodes_mapper', $datas);
	        wp_send_json(array(
	            'message' =>  esc_html__('Update maps successful', 'mageewp-page-layout'),
	            'stt' => 1,
	        ));
			exit;
        }
        
        if ($task == 'import' && is_array($data)) 
        {
	        update_option('mpl_shortcodes_mapper', $data);
	        wp_send_json(array(
	            'message' =>  esc_html__('Update maps successful', 'mageewp-page-layout'),
	            'stt' => 1,
	        ));
			exit;
        }
                
        if ($task == 'delete') {
	        
	        unset ($datas[$tag]);
	        
	        update_option('mpl_shortcodes_mapper', $datas);
	        wp_send_json(array(
	            'message' =>  esc_html__('Update maps successful', 'mageewp-page-layout'),
	            'stt' => 1,
	        ));
			exit;
        }
        
      	wp_send_json(array(
            'message' =>  esc_html__('Error: Incorrect data structure', 'mageewp-page-layout'),
            'stt' => 0,
        ));
		exit;
		
    }

	public function instant_save() {
		
		check_ajax_referer( 'mpl-nonce', 'security' );
        
        $addition_check = false;
        
		if (isset($_POST['header'])) {
			update_option('mpl_top_bar_header', stripslashes($_POST['header']));
		}
		
		if (!isset( $_POST['id'] ) || !isset( $_POST['title'] ) || !isset( $_POST['content']))
		{
			echo $this->msg( __('Error: Invalid Post ID', 'mageewp-page-layout'), 0 );
			exit;
		}
		
		$id = esc_attr( $_POST['id'] );
		
		if (get_post_status( $id ) === false)
		{
			echo $this->msg( __('Error: Post not exist', 'mageewp-page-layout'), 0 );
			exit;
		}
		
		global $wpdb, $mpl, $post;
			
		$get_post = get_post( $id );

        $addition_check = apply_filters('mpl_before_instant_save', $addition_check, $id );
        
		if (!isset( $get_post ) || $mpl->user_can_edit( $get_post ) === false || $addition_check == true)
		{
			echo $this->msg( __('Error: You do not have permission to edit this post', 'mageewp-page-layout'), 0 );
			exit;
		}
		
		if (isset( $_POST['live_editor'])
			&& $_POST['live_editor'] == 'yes'
			&& $mpl->check_pdk() === 3
			&& class_exists( 'mpl_pro' )
		)
		{
			echo -3;
			exit;
		}
		
		$args = sanitize_post (array(
			'ID'           => $_POST['id'],
			'post_title'   => $_POST['title'],
			'post_content' => stripslashes($_POST['content']),
		), 'db' );
		
		$data = array(
			'post_content_filtered' => $args['post_content']
		);
		
		//if (current_user_can ('publish_pages'))
		//	$data['post_status']  = 'publish';
		
		/*
		* Save the raw first
		*/
		$result = $wpdb->update( 
		    $wpdb->prefix.'posts', 
		    $data,
		    array( 'ID' => $id )
		);
		
		if ( false !== $result)
		{
            echo $this->msg( __('Your content has been saved Successful', 'mageewp-page-layout'), 1 );
            mpl_process_save_meta($id, $_POST['meta']);
        } else {	
        	echo $this->msg( __('Error: could not save the content.', 'mageewp-page-layout'), 0 );
		}

		$meta['mode'] = 'mpl';
		if ( get_post_meta( $id, 'mpl_data', FALSE ) ) {
			update_post_meta( $id, 'mpl_data', $meta );
		} else {
			add_post_meta( $id, 'mpl_data', $meta );
		}
        /*
	    *	after save the raw content, we'll process cache content
	    */
        
        /*=====================================================*/
        
		/*
		*	Process content before save
		*/
		
		require_once MPL_PATH.'/includes/mpl.front.php';
		
		$content_processed = '';
		if (!empty($args['post_content']))
		{
			//$ext = '<style type="text/css" id="mpl-basic-css">'.mpl_basic_layout_css().'</style>';
			//$ext .= '<p class="mpl-off-notice">'.__('Notice: You are using wrong way to display MPL Content', 'mageewp-page-layout').'</p>';
			$ext = '';
			$content_processed = $mpl->do_shortcode ($args['post_content']);

			/*
			* 	we don't have body class if the plugin was disabled
			*/
			if (!empty($content_processed))
			{
				$content_processed = $ext.$content_processed;
				$content_processed = str_replace( 
					array("\n", 'body.mpl-css-system'),
					array("", 'html body'), 
					$content_processed 
				);
				$content_processed = preg_replace('/(?<=\>)[\s]+(?=\<)/i', '', $content_processed);
			}
		}
		
		// reset data after save the raw
		$data = array('post_content' => $content_processed);
		
		// Save post from live editor
		
		if (isset( $_POST['task']  ) && $_POST['task'] == 'frontend')
		{
			$wpdb->update( 
			    $wpdb->prefix.'posts', 
			    $data,
			    array( 'ID' => $id )
			);
			
			exit;
		}
		
		// Save post from backend editor
		$data['post_title'] = $args['post_title'];
		$result = $wpdb->update( 
		    $wpdb->prefix.'posts', 
		    $data,
		    array( 'ID' => $id )
		);
		exit;
	}

	public function suggestion(){
		
		check_ajax_referer( 'mpl-nonce', 'security' );
		
		$field_name = isset($_POST['field_name']) ? esc_attr($_POST['field_name']) : 'mpl_std';
		
		if (has_filter('mpl_autocomplete_'.$field_name))
		{
			$data = apply_filters ('mpl_autocomplete_'.$field_name);
			$data['__session'] = isset($_POST['session']) ? $_POST['session'] : '';
			wp_send_json ($data);
			exit;
		}
		
		$data = array( '__session' => isset($_POST['session']) ? $_POST['session'] : '' );
		
		$args = array(
			's' => isset( $_POST['s'] ) ? $_POST['s'] : '', 
		    'post_type' => !empty( $_POST['post_type'] ) ? esc_attr( $_POST['post_type'] ) : 'any',
		    'category' => isset( $_POST['category'] ) ? esc_attr( $_POST['category'] ) : '',
		    'category_name' => isset( $_POST['category_name'] ) ? esc_attr( $_POST['category_name'] ) : '',
		    'numberposts' => !empty( $_POST['numberposts'] ) ? esc_attr( $_POST['numberposts'] ) : 120,
		);
				
		if( isset( $_POST['taxonomy'] ) && !empty( $_POST['taxonomy'] ) ){
				
			$taxonomyObj = get_taxonomy(esc_attr( $_POST['taxonomy'] ));
			
			if( isset( $taxonomyObj ) && isset( $taxonomyObj->object_type ) && isset( $taxonomyObj->object_type[0] ) )
				$args['post_type'] = $taxonomyObj->object_type[0];

			$terms = get_terms( array(
			    'taxonomy' => esc_attr($_POST['taxonomy']),
			    'hide_empty' => true,
			));
			$list_terms = array();
			foreach( $terms as $k => $term ){

				if( !isset( $data[ $_POST['taxonomy'] ] ) )
					$data[ $_POST['taxonomy'] ] = array();
				
				$data[ $_POST['taxonomy'] ][] = $term->slug.':'.esc_html(str_replace( array(':',','), array('',''), $term->name));
				
			}
	    }else{
	    
			if ( 0 === strlen( $args['s'] ) ) {
				unset( $args['s'] );
			}
			add_filter( 'posts_search', 'mpl_filter_search', 500, 2 );
			$posts = get_posts( $args );
	
			if ( is_array( $posts ) && ! empty( $posts ) ) {
				foreach ( $posts as $post ) {
					if( !isset( $data[ $post->post_type ] ) )
						$data[ $post->post_type ] = array();	
					$data[ $post->post_type ][] = $post->ID.':'.esc_html(str_replace( array(':',','), array('',''), $post->post_title));
				}
			}
		
		}
		
		wp_send_json( $data );
		exit;

	}
	
	public function tmpl_storage(){
		
		check_ajax_referer( 'mpl-nonce', 'security' );
		
		global $mpl;
		$mpl->convert_paramTypes_cache();
		
		require_once MPL_PATH.'/includes/mpl.templates.php';
		do_action('mpl_tmpl_storage');
		
		exit;
		
	}
	
	public function kcp_access(){
		
		check_ajax_referer( 'mpl-verify-nonce', 'security' );
		
		$license = isset( $_POST['license'] ) ? esc_html( $_POST['license'] ) : '';
		
		if( strlen( $license ) != 41 )
		{
			echo '-2';
			exit;
		}
		
		global $mpl;
		$data = $mpl->kcp_remote($license, 'kcp_access');

		if( $data === false )
		{
			echo '-2';
			exit;
		}
		
		wp_send_json( $data );
		
		exit;
		
	}
	
	public function revoke_domain(){

		check_ajax_referer( 'mpl-verify-nonce', 'security' );
		
		global $mpl;
		$pdk = $mpl->get_pdk();
		
		$license = $pdk['key'];
		
		if( strlen( $license ) != 41 )
		{
			$data = array('stt' => 0, 'message' => 'Error');
		}
		else
		{
			$data = $mpl->kcp_remote( $license, 'revoke_domain' );
		}
		
		wp_send_json( $data );
		
		exit;
		
	}
	
	
	public function update_plugin(){
		
		check_ajax_referer( 'mpl-nonce-update', 'security' );
		
		
		
		$slug = esc_attr ($_POST['slug']);
		$base = $slug.'/'.$slug.'.php';
		$update_plugin = get_site_transient( 'update_plugins' );

		if (!isset($update_plugin->response[$base]))
		{
			echo '-1';
			exit;
		}
			
		$package = $update_plugin->response[$base]->package;
		
		$skin_args = array(
			'type'   => 'web',
			'title'  => 'Install '.$slug,
			'url'    => $package,
			'nonce'  => 'install-plugin_'.$slug,
			'plugin' => '',
			'api'    => null,
			'extra'  => array('slug' => $slug),
		);
		
		if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}
		
		$skin = new Plugin_Installer_Skin( $skin_args );
		$upgrader = new Plugin_Upgrader();
		
		echo '<div class="mpl-pro-download-result">';
		
		if( $upgrader->upgrade($package) === true ){
			
			$result = activate_plugin($base);
			
			if ( is_wp_error( $result ) ) {
				echo '<p>'.$result->get_error_message().'</p>';
			}else{
				echo '<h3 class="active-success">Active plugin successfully, reloading the page...</h3>';
			}
		}
		
		echo '<br/><br /></div>';
		
		exit;
		
	}
	
	public function add_font(){
		
		check_ajax_referer( 'mpl-fonts-nonce', 'security' );
		
		$mpl_fonts = get_option('mpl-fonts');
	
		if( !is_array( $mpl_fonts ) ){
			$mpl_fonts = array();
			add_option('mpl-fonts', $mpl_fonts);
		}
		
		$family = esc_attr($_POST['family']);
		$subsets = esc_attr($_POST['subsets']);
		$variants = esc_attr($_POST['variants']);
		
		$data = array(
				'message' => '',
				'stt' => 0,
				'data' => $mpl_fonts
			);
			
		if( empty( $family ) ){
			
			$data['message'] = __('Error, missing font family', 'mageewp-page-layout');
			
		}else if( isset( $mpl_fonts[$family] ) ){
		
			$data['message'] = __('Error, font family already exists', 'mageewp-page-layout');
			
		}else if( count($mpl_fonts) >= 9 ){
		
			$data['message'] = __('Error, You have added too much fonts. Your page will load very slowly.', 'mageewp-page-layout');
			
		}else{
		
			$mpl_fonts[$family] = array( $subsets, $variants );
			update_option('mpl-fonts', $mpl_fonts);
		
			$data['message'] = __('Your font has been added successful', 'mageewp-page-layout');
			$data['stt'] = 1;
			$data['data'] = $mpl_fonts;
		
		}
		
		wp_send_json( $data );
		exit;
		
	}
	
	public function update_font(){
		
		check_ajax_referer( 'mpl-fonts-nonce', 'security' );
		
		if( get_option('mpl-fonts') === false ){
			add_option('mpl-fonts', $_POST['datas'], null, 'no');
		}else{
			update_option('mpl-fonts', $_POST['datas']);
		}
		
		$data = array(
				'message' => __('Your settings have been updated', 'mageewp-page-layout'),
				'stt' => 1,
				'data' => $_POST['datas']
			);

		wp_send_json( $data );
		exit;
		
	}
	
	public function delete_font(){
		
		check_ajax_referer( 'mpl-fonts-nonce', 'security' );
		
		$mpl_fonts = get_option('mpl-fonts');
	
		if( !is_array( $mpl_fonts ) ){
			$mpl_fonts = array();
			add_option('mpl-fonts', $mpl_fonts, null, 'no');
		}
		
		$family = esc_attr($_POST['family']);
		
		$data = array(
				'message' => '',
				'stt' => 0,
				'data' => $mpl_fonts
			);
			
		if( empty( $family ) ){
			
			$data['message'] = __('Error, missing font family', 'mageewp-page-layout');
			
		}else if( !isset( $mpl_fonts[$family] ) ){
		
			$data['message'] = __('Error, font family does not exists', 'mageewp-page-layout');
			
		}else{
		
			unset( $mpl_fonts[$family] );
			update_option('mpl-fonts', $mpl_fonts);
		
			$data['message'] = __('Your font has been deleted successful', 'mageewp-page-layout');
			$data['stt'] = 1;
			$data['data'] = $mpl_fonts;
		
		}
		
		wp_send_json( $data );
		exit;
		
	}
	
	
	
		
	public function load_sections(){
		
		global $mpl;
		
		check_ajax_referer( 'mpl-nonce', 'security' );
		
		$data = array(
			'message' => 'Error: Unknow',
			'stt' => 0,
			'data' => array(
				's' => isset($_POST['s']) ? esc_attr($_POST['s']) : '',
				'term' => isset($_POST['term']) ? esc_attr($_POST['term']) : '',
				'paged' => isset($_POST['paged']) ? esc_attr($_POST['paged']) : 1,
				'per_page' => isset($_POST['per_page']) ? esc_attr($_POST['per_page']) : 10,
				'type' => isset($_POST['type']) ? esc_attr($_POST['type']) : 'mpl-section',
				'cols' => isset($_POST['cols']) ? esc_attr($_POST['cols']) : 2,
				'items' => array(),
				'terms' => array(),
				'total' => 0,
				'count' => 0,
			)
		);
		
		$headers    = array('name'=>'','category'=>'','thumbnail'=>'','demo uri'=>'','order' =>0);
		$templates  = array();
		$has_custom = 0;
			   
		$categories = array(
							'homepage' => __('Homepage', 'mageewp-page-layout'),
							'about' => __('About', 'mageewp-page-layout'),
							'contact' => __('Contact', 'mageewp-page-layout'),
							'service' => __('Service', 'mageewp-page-layout'),
							'page-404' => __('Page 404', 'mageewp-page-layout'),
							);
							
		$categories = apply_filters('mpl_template_categories',$categories);
				
		$path_mpl      = array();
		$path_mpl[0]   = $mpl->get_templates_library_default_path() ;
		$path_theme    = $mpl->get_templates_library_path_dir() ;	
		$paths         = array_merge( (array)$path_mpl, (array)$path_theme );
		$cat_has_items = array();
		
			foreach( $paths as $path )
		{
			
			
			foreach( glob( trim($path)  . '*.php' ) as $filename ) {
			
				$info      = $mpl->get_file_config( $filename );
				$slug      = basename($filename, '.php');
				
				if ( isset($info['templates']) ){
					$template = array_merge($headers,$info['templates']);
										
					$name          = trim($template['name']);
					$thumbnail     = trim($template['thumbnail']);
					$category      = trim($template['category']);
					$order         = trim($template['order']);
					
					if( $category == '404' )
						$category = 'page-404';
					
					if ( strpos($path, 'wp-content/themes') )
						$url = get_template_directory_uri().'/templates/images/';
					else
						$url = MPL_URL.'/templates/images/';
					
					if ($name !='' ){
						
						if( $thumbnail == '')
							$thumbnail = MPL_URL. '/assets/images/template/template_default.jpg';
						else if( file_exists($path.'images/'.$thumbnail) )
							$thumbnail = $url.$thumbnail;
						else 
							$thumbnail = $thumbnail;
							
						if ( $category =='' || !array_key_exists($category,$categories) ){
								$category = 'custom';
								$categories['custom'] = __('Custom', 'mageewp-page-layout');
							}
							
								
						$cat_has_items[] = $category;
								
							
							
						$templates[$slug] = array(
												  'name' => $name,
												  'slug' => $slug,
												  'category' => $category,
												  'thumbnail' => $thumbnail,
												  'demo uri' => trim($template['demo uri']),
												  'order' => $order,
												  );
						
						}
				}	
				
			}
			
			
			
		}
		
			$templates = $mpl->array_sort_by($templates,'order','desc');
			
			$return = '<div class="mpl-templates">
			<ul class="mpl-templates-categories"><li data-category="all" class="all active">'.__('All', 'mageewp-page-layout').'</li>';
			
			foreach ( $categories as $k => $v ){
				
				if (in_array($k,$cat_has_items))
					$return .= '<li data-category="'.$k.'" class="'.$k.'">'.$v.'</li>';
				
				}
	
		    $return .= '</ul>';
			
			$return .= '<ul class="mpl-templates-list-main mpl-templates-list">';
			
			foreach( $templates as $n => $v ){
				
				$return .= '<li title="'.$v['name'].'" data-category="'.$v['category'].'" class="mpl-template-item">
								<div>
									<span class="cpdes">
									<img src="'.$v['thumbnail'].'" />
										<strong>'.$v['name'].'</strong>
									</span>
									<ul class="mpl-button-group">
									  <li><a href="'.$v['demo uri'].'" target="_blank">'. __('Preview', 'mageewp-page-layout').'</a></li><li class="mpl-template-import" data-name="'.$v['slug'].'"><a>'. __('Import', 'mageewp-page-layout').'</a></li>
									</ul>
								</div>
							</li>';	
				
				}
			
			$return .= '</ul></div>';
			
			$data['message'] = $return;
			wp_send_json( $data );
		exit;
		
	}
	
	public function load_section(){
		
		check_ajax_referer( 'mpl-nonce', 'security' );
		
		$data = array(
			'message' => 'Error: Unknow',
			'stt' => 0,
			'data' => ''
		);
		
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		
		if (isset($_POST['xml_pack']) && !empty($_POST['xml_pack'])) {
			
			global $mpl;
			$pack = esc_attr($_POST['xml_pack']);
			$registered_pack = $mpl->get_prebuilt_templates();
			
			if (!isset($registered_pack[$pack])) {
				$data = array(
					'message' => 'Error: The template pack does not exist or invalid name',
					'stt' => 0,
					'data' => ''
				);
			} else {
				
				$post = mpl_get_template_xml($registered_pack[$pack], $id);
				
				if ($post[0] === null) {
					$data = array(
						'message' => 'Error: The content returns null',
						'stt' => 0,
						'data' => ''
					);
				}else{
					$data = array(
						'message' => 'Successful',
						'stt' => 1,
						'data' => $post[0],
						'meta' => $post[1]
					);
				}
			}
			
		} else {
					
			$content = mpl_raw_content( $id );
			
			if ( FALSE === get_post_status( $id ) ){
				$data['message'] = __( 'Error: The section does not exist or has been removed', 'mageewp-page-layout' );
			}else if( empty($content) || empty($id) ){
				$data['message'] = __( 'Error: The section content is empty', 'mageewp-page-layout' );
			}else{
				$data['stt'] = 1;
				$data['message'] = 'Successful';
				$data['data'] = $content;
			}
		
		}
		wp_send_json( $data );
		exit;
		
	}
	
	public function push_section(){
		
		check_ajax_referer( 'mpl-nonce', 'security' );
		
		$data = array(
			'message' => 'Error: Unknow',
			'stt' => 0,
			'data' => ''
		);
		
		$id = isset($_POST['id']) ? esc_attr( $_POST['id'] ) : '';
		$content = isset($_POST['content']) ? $_POST['content'] : '';
		$overwrite = isset($_POST['overwrite']) ? $_POST['overwrite'] : false;
		
		if( $overwrite != 'true' ){
			$content = get_post_field('post_content', $id).$content;
		}
		
		if ( FALSE === get_post_status( $id ) ){
			$data['message'] = __( 'Error: The section does not exist or has been removed', 'mageewp-page-layout' );
		}else{
			
			$arg = sanitize_post( array( 'ID' => $id, 'post_content' => $content ), 'db' );
			$post_id = wp_update_post( $arg );
			
			if (is_wp_error($post_id)) {
				$data['message'] = '';
				$errors = $post_id->get_error_messages();
				foreach ($errors as $error) {
					$data['message'] .= $error;
				}
			}else{
				
				$data['stt'] = 1;
				$data['message'] = 'Successful';
				$data['data'] = '';
				
				$meta = get_post_meta( $id , 'mpl_data', true );
				if( !is_array( $data ) ){
					$meta = array( "mode" => "mpl", "classes" => "", "css" => "");
				}else $meta['mode'] = 'mpl';
				
				if( get_post_meta( $id, 'mpl_data' ) === false )
					add_post_meta( $id, 'mpl_data' , $meta );
				else update_post_meta( $id , 'mpl_data' , $meta );
				
			}
		}
		
		wp_send_json( $data );
		exit;
		
	}
	
	public function load_element_via_ajax(){
			
		check_ajax_referer( 'mpl-nonce', 'security' );
		
		if( !isset( $_POST['model'] ) || !isset( $_POST['code'] ) ){
			wp_send_json( array( 'status' => '-1' ) );
			exit;
		}
		
		require_once MPL_PATH.'/includes/mpl.front.php';
		
		global $mpl, $mpl_front, $post;
		
		if (isset( $_POST['ID'] ))
			$post->ID = $_POST['ID'];
		
		$code = isset( $_POST['code'] ) ? trim( base64_decode( esc_attr( $_POST['code'] ) ) ) : '';
		
		$model = isset( $_POST['model'] ) ? esc_attr( $_POST['model'] ) : '';
		
		$pattern_filter = get_shortcode_regex( array('mpl_row') );
		$atts = preg_replace( "/$pattern_filter/", '$3', $code );
		$atts = shortcode_parse_atts( $atts );
		
		if( is_array( $atts ) && isset( $atts['__section_link'] ) ){
			
			$sid = $atts['__section_link'];
			$code = mpl_raw_content( $sid );
			$title = get_post_field('post_title', $sid );
			
			if( !empty( $code ) ){
				
				wp_send_json( array( 
					'status' => '1',
					'model' => $model,
					'html' => $code,
					'__section_link' => $sid,
					'__section_title' => $title
				));
				
				exit;
				
			}else{
				wp_send_json( array( 
					'status' => '0',
					'model' => $model,
					'html' => '',
					'message' => __('The content is empty, please edit section to add content', 'mageewp-page-layout'),
					'__section_link' => $sid,
					'__section_title' => $title
				));
				exit;
			}
			
		}
		
		$code = $mpl_front->do_filter_shortcode($code);
		$code = trim( $code );
		
		$code = do_shortcode( $code );
		
		if( empty( $code ) ){
			$code = '<div class="mpl-infinite-loop">'.__('The content is empty', 'mageewp-page-layout').'</div>';	
		}
		
		wp_send_json( array( 
			'status' => '1',
			'model' => $model,
			'html' => '<!--mpl s '.$model.'-->'.$code.'<!--mpl e '.$model.'-->',
			'css' => $mpl_front->get_global_css(),
			'callback' => $mpl->live_js_callback
		));
		
		exit;
		
	}
		
	public function enable_optimized(){
		
		check_ajax_referer( 'mpl-nonce', 'security' );
		
		require_once MPL_PATH.'/includes/mpl.optimized.php';

		$settings = isset($_POST['settings']) ? $_POST['settings'] : array();
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		
		$settings = array_merge(array("enable" => "", "global" => "", "dvanced" => ""), (array)$settings);
		
		$optimized = new mpl_optimized();
		$data = array(
			'msg' => __('Error message', 'mageewp-page-layout'),
			'stt' => 0
		);
		
		if (isset($settings['clear_cache']) && $settings['clear_cache'] == 'on') {
			
			if (!is_dir(ABSPATH.'optimized') || $optimized->delete_cache()) {
				$data = array(
					'msg' => '<i class="fa-check-square"></i> '.__('All cache have been successfully deleted', 'mageewp-page-layout'),
					'stt' => 1
				);
			}else $data['msg'] = '<i class="fa-warning"></i> '.__('Your cache were cleaned or could not delete cache', 'mageewp-page-layout');
			
			wp_send_json( $data );
			exit;
			
		}
		
		if ($settings['enable'] == 'on') {
			// Enable optimized
			$data = $optimized->check_htaccess($settings['advanced']);
			if ($data['stt'] == 1) {
				
				if (get_option('mpl_optimized') === false)
					add_option('mpl_optimized', $settings, null, 'no');
				else update_option('mpl_optimized', $settings);
		
			}
		} else {
			if ($optimized->deactive()) {
				
				$data = array(
					'msg' => __('Deactive successful', 'mageewp-page-layout'),
					'stt' => 1
				);
				
				if (get_option('mpl_optimized') === false)
					add_option('mpl_optimized', $settings, null, 'no');
				else update_option('mpl_optimized', $settings);
				
			} else {
				$data = array(
					'msg' => __('Could not deactive, please check the writable permission', 'mageewp-page-layout'),
					'stt' => 0
				);
			}
		}
		
		wp_send_json( $data );
		exit;
		
	}
	

	
	public function msg( $s = '', $t = 1 ){
		if( $t == 1 )
			return '<h3 class="mesg success"><i class="et-happy"></i><br />'.$s.'</h3>';
		else return '<h3 class="mesg error"><i class="et-sad"></i><br />'.$s.'</h3>';
	}
	
	private function get_terms( $parent = 0, $spacing = '', $taxonomy, $data = array() ){
		
		$terms = get_terms( array(
		    'taxonomy' => $taxonomy,
		    'hide_empty' => false,
		    'parent' => $parent
		));
		
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		    foreach ( $terms as $term ){
			    $data[] = array( 'name' => $spacing.$term->name, 'id' => $term->term_id, 'taxonomy' => $term->taxonomy );
			    $data = $this->get_terms( $term->term_id, $spacing.' - ', $taxonomy, $data );
		    }
		}
		
		return $data;
		
	}
	/*
	** save inline post 
	*/ 	
	public function post_update() {
		if (isset($_POST['header'])) {
			update_option('mpl_top_bar_header', stripslashes($_POST['header']));
		}

		if (!isset( $_POST['id'] ) || !isset( $_POST['title'] ) || !isset( $_POST['content']))
		{
			echo $this->msg( __('Error: Invalid Post ID', 'mageewp-page-layout'), 0 );
			exit;
		}

		$id = esc_attr( $_POST['id'] );

		if (get_post_status( $id ) === false)
		{
			echo $this->msg( __('Error: Post not exist', 'mageewp-page-layout'), 0 );
			exit;
		}

		global $wpdb, $mpl, $post;
			
		$get_post = get_post( $id );

		if (!isset( $get_post ) || $mpl->user_can_edit( $get_post ) === false)
		{
			echo $this->msg( __('Error: You do not have permission to edit this post', 'mageewp-page-layout'), 0 );
			exit;
		}

		$args = sanitize_post (array(
			
			'ID'           => $_POST['id'],
			'post_title'   => $_POST['title'],
			'post_content' => stripslashes($_POST['content']),
			
		), 'db' );

		$data = array(
			'post_content_filtered' => $args['post_content']
		);

		if (current_user_can ('publish_pages'))
			$data['post_status']  = 'publish';

		/*
		* Save the raw first
		*/
		$result = $wpdb->update( 

			$wpdb->prefix.'posts', 
			
			$data,
			
			array( 'ID' => $id )
		);

		if ( false !== $result)
		{
			echo json_encode($data);
			
		}
		else
		{	
			echo $this->msg( __('Error: could not save the content.', 'mageewp-page-layout'), 0 );
		}
	}
  
  public function post_meta_update(){
	  if (!isset( $_POST['id'] ))
		{
			echo $this->msg( __('Error: Invalid Post ID', 'mageewp-page-layout'), 0 );
			exit;
		}
		
	  $id  = $_POST['id'] ;
	  $meta = isset($_POST['post_meta'])?$_POST['post_meta']:array();
	  
      global $wpdb, $mpl, $post;
	  $get_post = get_post( $id );
        
		if (!isset( $get_post ) || $mpl->user_can_edit( $get_post ) === false)
		{
			echo $this->msg( __('Error: You do not have permission to edit this post', 'mageewp-page-layout'), 0 );
			exit;
		}
	  
	  $param = (array)get_post_meta ($id, 'mpl_data', true);

	  if (!is_array($meta))
			$meta = array();
			
		foreach(
			array(  "mode" => "",'css' => '',  'classes' => '') 
			as $key => $value
		) {
			if (!isset($meta[$key]))
				$meta[$key] = '';
		}
		
	  if (!add_post_meta( $id, 'mpl_data', $meta, true)) {
		foreach ($meta as $key => $value) {
			$param[$key] = $value;
		}
		update_post_meta( $id, 'mpl_data', $param );
		echo $this->msg( __('Success: Saved Post Meta Success', 'mageewp-page-layout'), 0 );
		exit;
	  }
  }
  
	public function front_section_data() 
	{
		if (!isset( $_POST['shortcode'] ) || empty($_POST['shortcode'])) {
			echo $this->msg( __('Error: Invalid Section', 'mageewp-page-layout'), 0 );
			exit;
		}
		$shortcode = $_POST['shortcode'];
		$shortcode = str_replace('\\\'','\'',$shortcode);
		$shortcode = str_replace('\\"','"',$shortcode);
		$shortcode = str_replace('\\\\','\\',$shortcode);
		$shortcode = str_replace('\"','"',$shortcode);	
		
		require_once MPL_PATH.'/includes/mpl.front.php';
		global $mpl, $mpl_front, $post;

		$content = $mpl_front->do_shortcode($shortcode);
		if (!empty($content)) {
			echo $content;
			exit;
		} else {
			echo $this->msg( __('Error: Shortcode No Content', 'mageewp-page-layout'), 0 );
			exit;
		}
	}

	public function get_recent_posts_data() 
	{
		global $mpl, $mpl_front, $post;
		$atts = array();
		if (!isset( $_POST['request_json'] ) || empty($_POST['request_json'])) {
			echo $this->msg( __('Error: Invalid Section', 'mageewp-page-layout'), 0 );
			exit;
		}
		$request_json = $_POST['request_json'];
		$request_json = str_replace('\\\'','\'', $request_json);
		$request_json = str_replace('\\"','"', $request_json);
		$request_json = str_replace('\\\\','\\', $request_json);
		$request_json = str_replace('\"','"', $request_json);
		$atts = json_decode($request_json, TRUE);

		$data = mpl_recent_posts_data($atts);
		$response_json = json_encode($data);
		//wp_send_json($data);
		echo $response_json;
		exit;
	}
}

#Start mpl_Ajax
new mpl_ajax();
