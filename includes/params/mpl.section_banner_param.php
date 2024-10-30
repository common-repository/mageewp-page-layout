<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mpl->add_map(
	array(
		'mpl_section_banner' => array(

			'name' => __('Banner', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-banner',
			'category' => 'Banner',
			'pop_width' => 400,
			'params' => array(
				'general' => array(
								   
					array(
						'name' => 'section_title',
						'label' => __('Section Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'Welcome to Our Website',
						'description' => __('Insert the section title.', 'mageewp-page-layout')
					),
					array(
						'name' => 'section_subtitle',
						'label' => __('Section Subtitle', 'mageewp-page-layout'),
						'type' => 'textarea',
						'value' => base64_encode('Integer ultrices condimentum ultricies.'),
						'description' => __('Insert the section subtitle.', 'mageewp-page-layout')
					),
					array(
						'name' => 'fullheight',
						'label' => __('Full height', 'mageewp-page-layout'),
						'type' => 'toggle',
						'value' => 'yes',
						'description' => __('Choose to display banner in fullheight of the browser.', 'mageewp-page-layout')
					),
					array(
						'type' => 'radio_image',
						'label' => __( 'Title Style', 'mageewp-page-layout' ),
						'name' => 'title_style',
						'description' => __( 'Select decoration style for the section title.', 'mageewp-page-layout' ),
						'options' => array(
							'' => MPL_URL.'/assets/images/banner_titlestyle_1.png',
							'style1' => MPL_URL.'/assets/images/banner_titlestyle_2.png',
						),
						'admin_label' => true,
					),
					array(
						'name' => 'content_align',
						'label' => __('Content Align', 'mageewp-page-layout'),
						'type' => 'select',
						'description' => __('Choose how the content should be displayed.', 'mageewp-page-layout'),
						'value' => 'center',
						'admin_label' => true,
						'options' => array( 
							'left' => __('Left','mageewp-page-layout'),
							'center' => __('Center','mageewp-page-layout'), 
							'right' => __('Right','mageewp-page-layout')
						)
					),		
					array(
						'type' => 'text',
						'label' => __('Button Text 1','mageewp-page-layout'),
						'name' => 'btn_text_1',
						'value' => 'Button 1',
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
						'value' => 'Button 2',
						'description' => __('Insert the text that will display in the 2nd button.','mageewp-page-layout')
					),
					array(
						'type' => 'link',
						'label' => __('Button Link 2','mageewp-page-layout'),
						'name' => 'btn_link_2',
						'description' => __('The url the 2nd button will link to.','mageewp-page-layout')
					),
					array(
						'type'			=> 'group',
						'label'			=> __('Social Icons', 'mageewp-page-layout'),
						'name'			=> 'social_icons',
						'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
						'options'		=> array('add_text' => __('Add new icon', 'mageewp-page-layout')),
						'value' => base64_encode( json_encode(array(
							"1" => array(
								"icon_name" => 'fa-facebook',
								"icon_link" => '#325272',
							),
							"2" => array(
								"icon_name" => 'fa-skype',
								"icon_link" => '#325272',
							),
							"3" => array(
								"icon_name" => 'fa-twitter',
								"icon_link" => '#325272',
							),
							"4" => array(
								"icon_name" => 'fa-linkedin',
								"icon_link" => '#325272',
							),
							"5" => array(
								"icon_name" => 'fa-google-plus',
								"icon_link" => '#325272',
							),
							"6" => array(
								"icon_name" => 'fa-rss',
								"icon_link" => '#325272',
							),

						) ) ),
						'params' => array(
							array(
								'type' => 'icon_picker',
								'label' => __('Soical Icon','mageewp-page-layout'),
								'name' => 'icon_name',
								'value' => '',
								'description' => __('Select an icon.','mageewp-page-layout')
							),
							array(
								'type' => 'link',
								'label' => __('Icon Link','mageewp-page-layout'),
								'name' => 'icon_link',
								'description' => __('The url the icon will link to.','mageewp-page-layout')
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
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#ffffff', 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '70px','selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
								),
								'Subtittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#ffffff', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '28px','selector' => '.mpl-section-subtitle'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
								),
								'Social' => array(
									array('property' => 'color', 'label' => __( 'Icon Color','mageewp-page-layout'),'value'=>'#ffffff', 'selector' => '.mpl-social-icons i'),
									array('property' => 'font-size', 'label' => __( 'Icon Size','mageewp-page-layout'), 'value'=> '36px','selector' => '.mpl-social-icons i'),
								),
								'Button1' => array(
									array('property' => 'background-color', 'label' => __( 'Primary Color','mageewp-page-layout'),'value'=>'#8bc03c', 'selector' => '.mpl-button-group .mpl-btn-normal'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-button-group .mpl-btn-normal'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '16px','selector' => '.mpl-button-group .mpl-btn-normal'),
								),
								'Button2' => array(
									array('property' => 'color', 'label' => __( 'Primary Color','mageewp-page-layout'),'value'=>'#ffffff', 'selector' => '.mpl-button-group .mpl-btn-normal.light'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-button-group .mpl-btn-normal.light'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '16px','selector' => '.mpl-button-group .mpl-btn-normal.light'),
								),
								//Background group
								'Background' => array(
									array('property' => 'background','value' => base64_encode(json_encode(array('color' => '#333','advanced' => '1','image' => MPL_URL .'/assets/images/params/banner_1920_1080.jpg','size'=>'cover')))),
								),

								//Video Background group
								'Video Background' => array(
									array('property' => 'video-background','value' => base64_encode(json_encode(array('video_type' => 'youtube', 'video_url' => 'XDLmLYXuIDM', 'start_time' => '','stop_time'  => '','video_mute' => '1','video_loop' => '1','video_autoplay' => '1','enable_video_bg' => '1')))),
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
