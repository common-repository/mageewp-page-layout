<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mpl->add_map(
	array(
		'mpl_section_slider' => array(

			'name' => __('Slider', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-slider',
			'category' => 'Banner',
			'pop_width' => 400,
			'params' => array(
				'general' => array(
					array(
						'name' => 'fullheight',
						'label' => __('Full height', 'mageewp-page-layout'),
						'type' => 'toggle',
						'value' => 'yes',
						'description' => __('Choose to display banner in fullheight of the browser.', 'mageewp-page-layout'),
						'options' => array(
							'yes' => __('Yes','mageewp-page-layout'),
							'no' => __('No','mageewp-page-layout'),
						)
					),
					array(
						'name' => 'section_height',
						'label' => __( 'Slider Height', 'mageewp-page-layout' ),
						'type' => 'number_slider',
						'value' => '500',
						'description' => __( 'Set slider height, in px.', 'mageewp-page-layout' ),
						'relation' => array(
							'parent' => 'fullheight',
							'hide_when' => 'yes'
						),
						'options' => array(
						    'min' => '1',
							'max' => '1080',
							'input_value' => true
						)
					),
					array(
						'type'			=> 'group',
						'label'			=> __('Slides', 'mageewp-page-layout'),
						'name'			=> 'slides',
						'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
						'options'		=> array('add_text' => __('Add new slide', 'mageewp-page-layout')),

						'value' => base64_encode( json_encode(array(
							"1" => array(
								"title" => "Welcome to Our Website",
								"subtitle" => "Integer ultrices condimentum ultricies.",
								"title_style" => "none", 
								"caption_align" => 'center',
								"caption" => "Integer ultrices condimentum ultricies.",
								"image" => MPL_URL .'/assets/images/params/banner_1920_1080.jpg',
								"btn_text_1" => 'Button 1',
								"btn_link_1" => '#',
								"btn_text_2" => 'Button 2',
								"btn_link_2" => '#',
							),
							"2" => array(
								"title" => "Welcome to Our Website",
								"subtitle" => "Integer ultrices condimentum ultricies.",
								"title_style" => "none", 
								"caption_align" => 'center',
								"caption" => "Integer ultrices condimentum ultricies.",
								"image" => MPL_URL .'/assets/images/params/banner_1920_1080.jpg',
								"btn_text_1" => 'Button 1',
								"btn_link_1" => '#',
								"btn_text_2" => 'Button 2',
								"btn_link_2" => '#',
							)
						) ) ),
						'params' => array(
						
						    array(
								'type' => 'text',
								'label' => __( 'Title', 'mageewp-page-layout' ),
								'name' => 'title',
								'value' => 'Welcome to Our Website',
								'description' => __('Insert slide title.', 'mageewp-page-layout')
							),
						    array(
								'type' => 'attach_image_url',
								'label' => __( 'Image', 'mageewp-page-layout' ),
								'name' => 'image',
								'value' => MPL_URL .'/assets/images/params/banner_1920_1080.jpg',
								'description' => __('Choose to upload image.', 'mageewp-page-layout')
							),
							array(
								'name' => 'content_align',
								'label' => __('Content Align', 'mageewp-page-layout'),
								'type' => 'select',
								'description' => __('Choose how the content should be displayed.', 'mageewp-page-layout'),
								'value' => 'center',
								'options' => array( 
								  'left' => __('Left','mageewp-page-layout'),
								  'center' => __('Center','mageewp-page-layout'), 
								  'right' => __('Right','mageewp-page-layout')
								)
							),
						    array(
								'type' => 'radio_image',
								'label' => __( 'Title Style', 'mageewp-page-layout' ),
								'name' => 'title_style',
								'description' => __( 'Select decoration style for the section title.', 'mageewp-page-layout' ),
								'options' => array(
								   '' => MPL_URL.'/assets/images/slider_titlestyle_1.png',
								   'style1' => MPL_URL.'/assets/images/slider_titlestyle_2.png',
								),
							),	
							array(
								'type' => 'textarea',
								'label' => __( 'subtitle', 'mageewp-page-layout' ),
								'name' => 'subtitle',
								'value' => base64_encode('Integer ultrices condimentum ultricies.'),
								'description' => __('Insert the section subtitle.', 'mageewp-page-layout')
							),

							array(
							    'type' => 'text',
								'label' => __('Button Text 1','mageewp-page-layout'),
								'name' => 'btn_text_1',
							    'description' => __('Insert the text that will display in the 1st button.','mageewp-page-layout')
							),
							array(
							    'type' => 'link',
								'label' => __('Button Link 1','mageewp-page-layout'),
								'name' => 'btn_link_1',
							    'description' => __('The url the 1st button will link to.','mageewp-page-layout')
							),
							array(
							    'type' => 'text',
								'label' => __('Button Text 2','mageewp-page-layout'),
								'name' => 'btn_text_2',
							    'description' => __('Insert the text that will display in the 2nd button.','mageewp-page-layout')
							),
							array(
							    'type' => 'link',
								'label' => __('Button Link 2','mageewp-page-layout'),
								'name' => 'btn_link_2',
							    'description' => __('The url the 2nd button will link to.','mageewp-page-layout')
							),
							
						),
					),

					array(
						'type' 			=> 'number_slider',
						'label' 		=> __( 'Carousel auto play speed', 'mageewp-page-layout' ),
						'name' 			=> 'owl_speed',
						'description' 	=> __( 'Set the speed at which autoplaying sliders will transition in second.', 'mageewp-page-layout' ),
						'value'			=> 500,
						'options' => array(
							'min' => 100,
							'max' => 1500,
							'show_input' => true
						),
						'relation' 	=> array(
							'parent'	=> 'owl_auto_play',
							'show_when'		=> 'yes'
						)
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
								'Slides Title' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#ffffff', 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '70px','selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
								),
								'Slides Subtitle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#ffffff', 'selector' => '.slide .mpl-section-subtitle'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.slide .mpl-section-subtitle'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '2em','selector' => '.slide .mpl-section-subtitle'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.slide .mpl-section-subtitle'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.slide .mpl-section-subtitle'),
								),
								'Slides Button 1' => array(
									array('property' => 'background-color', 'label' => __( 'Color','mageewp-page-layout'), 'value'=>'#8bc03c', 'selector' => '.slide .mpl-btn-normal'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.slide .mpl-btn-normal'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.slide .mpl-btn-normal'),
								),
								'Slides Button 2' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'), 'value'=>'#ffffff', 'selector' => '.slide .mpl-btn-normal.light'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.slide .mpl-btn-normal.light'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.slide .mpl-btn-normal.light'),
								),
								
								//Box group
								'Box' => array(
									array('property' => 'margin', 'label' => __( 'Margin','mageewp-page-layout')),
									array('property' => 'padding', 'value'=> '0px 0px 0px 0px','label' => __( 'Padding','mageewp-page-layout'),'selector' => ''),
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
