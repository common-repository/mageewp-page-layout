<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mpl->add_map(
	array(
		'mpl_section_service' => array(

			'name' => __('Service', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-service',
			'category' => 'Service',
			'params' => array(
				'general' => array(
					array(
						'name' => 'section_title',
						'label' => __( 'Section Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'Services',
						'description' => __('Insert the section title.', 'mageewp-page-layout')
					),
					array(
						'name' => 'section_subtitle',
						'label' => __( 'Section Subtitle', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => '',
						'description' => __('Insert the section subtitle.', 'mageewp-page-layout')
					),
					array(
						'name' => 'layout',
						'label' => __('Layout', 'mageewp-page-layout'),
						'type' => 'radio_image',
						'value' => '1',
						'description' => __( 'Select style for the service items.', 'mageewp-page-layout' ),
						'options' => array(
							'1' => MPL_URL.'/assets/images/sections/section_service.png', 
							'2' => MPL_URL.'/assets/images/sections/section_service_2.png',
							'3' => MPL_URL.'/assets/images/sections/section_service_3.png',
						),
					),
					array(
						'name' => 'columns',
						'label' => __( 'Columns', 'mageewp-page-layout'),
						'type' => 'select',
						'value' => '3',
						'description' => __( 'Select columns for services', 'mageewp-page-layout' ),
						'options'=>array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6)
					),
					array(
						'name' => 'icon_type',
						'label' => __('Icon type for items','mageewp-page-layout'),
						'type' => 'radio',
						'value' => 'icon',
						'options' => array(
							'icon' => __( 'Font Awesome','mageewp-page-layout'),
							'image' => __( 'Image','mageewp-page-layout')
						)
					),
					array(
						'name' => 'icon_shape',
						'label' => __('Icon shape for items','mageewp-page-layout'),
						'type' => 'select',
						'value' => 'circle',
						'relation' => array(
							'parent' => 'icon_type',
							'show_when' => 'icon'
						),
						'description' => __('Select shape for icons', 'mageewp-page-layout'),
						'options' => array(
							'none' => __( 'No shape','mageewp-page-layout'),
							'square' => __( 'Square','mageewp-page-layout'),
							'circle' => __( 'Circle','mageewp-page-layout')
							)
					),
					array(
						'name' => 'image_width',
						'label' => 'Image width',
						'type' => 'text',
						'value' => '100',
						'relation' => array(
							'parent' => 'icon_type',
							'show_when' => 'image'
						),
						'description' => __('Insert width for image icon, in px.', 'mageewp-page-layout')
					),
					array(
						'type'			=> 'group',
						'label'			=> __('Items', 'mageewp-page-layout'),
						'name'			=> 'services',
						'description'	=> '',
						'options'		=> '',
						'value' => base64_encode( json_encode(array(
							"1" => array(
								"icon" => 'fa-coffee',
								"icon_image" => '',
								"icon_color" => '#595959',
								"title" => "Consequat",
								"title_link" => "",
								"description" => 'Praesent et metus non enim pretium vehicula. Aenean tincidunt eros quis condimentum vulputate.',
							),
							"2" => array(
								"icon" => 'fa-cog',
								"icon_image" => '',
								"icon_color" => '#595959',
								"title" => "Vivamus",
								"title_link" => "",
								"description" =>  'Praesent et metus non enim pretium vehicula. Aenean tincidunt eros quis condimentum vulputate.',	
							),
							"3" => array(
								"icon" => 'fa-cube',
								"icon_image" => '',
								"icon_color" => '#595959',
								"title" => "Paresent",
								"title_link" => "",
								"description" =>  'Praesent et metus non enim pretium vehicula. Aenean tincidunt eros quis condimentum vulputate.',
								
							),
							"4" => array(
								"icon" => 'fa-heart-o',
								"icon_image" => '',
								"icon_color" => '#595959',
								"title" => "Aenean",
								"title_link" => "",
								"description" =>  'Praesent et metus non enim pretium vehicula. Aenean tincidunt eros quis condimentum vulputate.',
								
							),
							"5" => array(
								"icon" => 'fa-paper-plane-o',
								"icon_image" => '',
								"icon_color" => '#595959',
								"title" => "Cosmtma",
								"title_link" => "",
								"description" =>  'Praesent et metus non enim pretium vehicula. Aenean tincidunt eros quis condimentum vulputate.',
								
							),
							"6" => array(
								"icon" => 'fa-smile-o',
								"icon_image" => '',
								"icon_color" => '#595959',
								"title" => "Tayend",
								"title_link" => "",
								"description" =>  'Praesent et metus non enim pretium vehicula. Aenean tincidunt eros quis condimentum vulputate.',
								
							)
						) ) ),
						'params' => array(
							array(
								'type' => 'text',
								'label' => __( 'Title', 'mageewp-page-layout' ),
								'name' => 'title',
								'description' => __('Insert item title.', 'mageewp-page-layout')
							),	
							array(
								'name' => 'icon',
								'label' => 'Icon',
								'type' => 'icon_picker',
								'value' => '',
								'description' => __('Select an icon.', 'mageewp-page-layout'),
								'relation' => array(
									'parent' => 'general:icon_type',
									'show_when' => 'icon'
								),
							),
							array(
								'name' => 'icon_color',
								'label' => 'Icon Color',
								'type' => 'color_picker',
								'value' => '#595959',
								'description' => __('Set primary color for the icon.', 'mageewp-page-layout'),
								'relation' => array(
									'parent' => 'general:icon_type',
									'show_when' => 'icon'
								),
							),
							array(
								'name' => 'image',
								'label' => 'Image',
								'type' => 'attach_image_url',
								'value' => MPL_URL .'/assets/images/params/service_200_200.jpg',
								'description' => __('Choose to upload image.', 'mageewp-page-layout'),
								'relation' => array(
									'parent' => 'general:icon_type',
									'show_when' => 'image'
								),
							),
							array(
								'name'     => 'title_link',
								'label'    => __('Title Link', 'mageewp-page-layout'),
								'type'     => 'link',
								'description' => __('Insert link for item title', 'mageewp-page-layout')
						    ),
							array(
								'type' => 'textarea',
								'label' => __( 'Description', 'mageewp-page-layout' ),
								'name' => 'description',
								'description' => __('Insert description for item.', 'mageewp-page-layout')
							),
						),
					),
				),
				'styling' => array(
					array(
						'type'			=> 'css',
						'label'			=> __( 'css', 'mageewp-page-layout' ),
						'name'			=> 'css_custom',
						'options'		=> array(
							array(
								'screens' => 'any',
								'Title' => array(
									array('property' => 'color', 'label' => 'Color','value'=>'#333333', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-size', 'label' => 'Font Size','value'=>'32px', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'line-height', 'label' => 'Line Height', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
								),
								'Subtittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.mpl-section-subtitle'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
								),								
								'Items Tittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.title'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.title'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '20px','selector' => '.title'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.title'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.title'),
								),
								'Items Description' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.desc'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.desc'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.desc'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.desc'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.desc'),
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

