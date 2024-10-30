<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mpl->add_map(
	array(
		'mpl_facebook_feed' => array(

			'name' => __('Facebook Feed', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-facebook-feed',
			'category' => '',
			'params' => array(
				'general' => array(
					
					array(
						'name' => 'section_title',
						'label' => __('Section Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'Facebook Feed',
						'description' => ''
					),
					array(
						'name' => 'section_subtitle',
						'label' => __('Section Subtitle', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => '',
						'description' => ''
					),
					array(
						'name' => 'columns',
						'label' => __('Columns', 'mageewp-page-layout'),
						'type' => 'select',
						'value' => '1',
						'description' => __('Set columns for skills section', 'mageewp-page-layout'),
						'options' => array(
						  '1' => '1',
						  '2' => '2',
						  '3' => '3',
						  '4' => '4',
						  '5' => '5',
						  '6' => '6',
						)
					),
					array(
						'name' => 'page_id',
						'label' => __('Facebook Page ID', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'MageewpSupport',
						'description' => __( 'ID of your Facebook Page or Group','mageewp-page-layout'),
					),
					array(
						'name' => 'num',
						'label' => __('Number of posts to display', 'mageewp-page-layout'),
						'type'	=> 'number_slider',
						'value' => '5',
						'description' => '',
						'options' => array(
						 'min' => '1',
						 'max' => '20'
						) 
					),
					array(
					    'name' => 'date_format',
						'label' => __('Select date format. For eg February 27, 2017', 'mageewp-page-layout'),
						'type'	=> 'select',
						'value' => 'default',
						'description' => '',
						'options' => array(
						   'default' =>  'day/time ago',
					       'F j, Y'  => 'February 27, 2017',
						   'd-m, Y'  => '27-01,2017',
						   'M d, Y'  => 'Feb 27,2017',
						   'j/M/Y'   => '27/Feb/2017'
						 )
					),
					array(
						'type' => 'toggle',
						'label' => __( 'Enter my own Access Token ', 'mageewp-page-layout' ),
						'name' => 'access_token',
						'value' =>''
					),
					array(
						'type' => 'text',
						'label' => __( 'Facebook Access Token', 'mageewp-page-layout' ),
						'name' => 'access_keys',
						'value' => '',
						'relation'  	=> array(
							'parent'	=> 'access_token',
							'show_when' => 'yes'
						)
					),
				),
				'styling' => array(
					array(
						'type'			=> 'css',
						'label'			=> __( 'CSS', 'mageewp-page-layout' ),
						'name'			=> 'css_custom',
						'options'		=> array(
							array(
								'screens' => 'any',
								'Title' => array(
									array('property' => 'color', 'label' => 'Color', 'selector' => 'h2.mpl-section-title,.mpl-section-title,.mpl-section-subtitle'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => 'h2.mpl-section-title,.mpl-section-title,.mpl-section-subtitle'),
									array('property' => 'font-size', 'label' => 'Font Size', 'value'=> '32px', 'selector' => 'h2.mpl-section-title,.mpl-section-title'),									                                    array('property' => 'line-height', 'label' => 'Line Height', 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'font-weight', 'label' => 'Font Weight','selector' => 'h2.mpl-section-title,.mpl-section-title'),
								),
								'Subtittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#ffffff', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.mpl-section-subtitle'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
								),
								//Background group
								'Background' => array(
									array('property' => 'background'),
								),
								
								//Background group must no selector
								'Video background' => array(
								    array('property' => 'video-background'),
								),            
			
								//Box group
								'Box' => array(
									array('property' => 'margin', 'label' => 'Margin'),
									array('property' => 'padding', 'value'=> '60px 0px 60px 0px','label' => 'Padding'),
								),
								
							)
						)
					),
				),
				
				'Extras'=> array(
					array(
						'name' => 'section_id',
						'label' => __( 'Section Slug', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => '',
						'description' => __('The unique identifier of the section.', 'mageewp-page-layout'),
					),
					
					array(
						'name' => 'section_class',
						'label' => __( 'Section extra classes name', 'mageewp-page-layout' ),
						'type' => 'text',
						'description' => __( 'Add additional custom classes to the Section.', 'mageewp-page-layout' ),
					),

										
                ),
				
				'Animate' => array(
					array(
						'name'    => 'animate',
						'type'    => 'animate'
					),
				),
	    	)
		),
	),
	'core'
);

$carousel_params[0]['value'] = 'no';
$carousel_count = count($carousel_params);
for( $i = 0; $i < $carousel_count; $i++ )
{
	$mpl->add_map_param('mpl_facebook_feed', $carousel_params[$i], null, 'general');
}
