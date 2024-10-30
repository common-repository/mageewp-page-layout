<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mapper = get_option('mpl_shortcodes_mapper', true);
$live_tmpl = MPL_PATH.MDS.'shortcodes'.MDS.'live_editor'.MDS;
$carousel_params = array(
	array(
		'name' => 'carousel',
		'label' => __('Enable Carousel Style', 'mageewp-page-layout'),
		'type' => 'toggle',
		'value' => 'yes',
		'description' => __('Choose to enable Carousel', 'mageewp-page-layout')
	),
/*	
	array(
		'type'			=> 'toggle',
		'label'			=> __( 'Carousel Navigation', 'mageewp-page-layout' ),
		'name'			=> 'owl_navigation',
		'description'	=> __( 'Display the "Next" and "Prev" buttons.', 'mageewp-page-layout' ),
		'relation'  	=> array(
			'parent'	=> 'carousel',
			'show_when' => 'yes'
		)
	),
	array(
		'type'        	=> 'dropdown',
		'label'     	=> __( 'Carousel Navigation Style', 'mageewp-page-layout' ),
		'name'  		=> 'owl_nav_style',
		'description' 	=> __( 'Select how navigation buttons display on slide.', 'mageewp-page-layout' ),
		'options'       	=> array(
			'arrow' => __( 'Arrow', 'mageewp-page-layout' ),
			'round' => __( 'Rounded Arrow', 'mageewp-page-layout' )
		),
		'relation'  	=> array(
			'parent'	=> 'owl_navigation',
			'show_when' => 'yes'
		)
	),
	array(
		'type'			=> 'toggle',
		'label'			=> __( 'Carousel Pagination', 'mageewp-page-layout' ),
		'name'			=> 'owl_pagination',
		'description'	=> __( 'Show the pagination.', 'mageewp-page-layout' ),
		'value'			=> 'yes',
		'relation'  	=> array(
			'parent'	=> 'carousel',
			'show_when' => 'yes'
		)
	),
	array(
		'type'			=> 'toggle',
		'label'			=> __( 'Carousel Auto height', 'mageewp-page-layout' ),
		'name'			=> 'owl_auto_height',
		'description'	=> __( 'Add height to owl-wrapper-outer so you can use diffrent heights on slides. Use it only for one item per page setting.', 'mageewp-page-layout' ),
		'relation'  	=> array(
			'parent'	=> 'carousel',
			'show_when' => 'yes'
		)
	),
*/
);

require_once MPL_PATH.MDS.'includes/params/mpl.section_slider_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_banner_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_service_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_team_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_gallery_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_post_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_testimonials_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_promo_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_promo_2_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_call_to_action_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_clients_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_counter_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_skills_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_contact_1_param.php';
require_once MPL_PATH.MDS.'includes/params/mpl.section_contact_4_param.php';

$mpl->add_map(
	array(
		'_value' => array(
			'name' => __( 'MPL Section','mageewp-page-layout'),
			'description' => __( 'MPL Section','mageewp-page-layout'),
			'icon' => 'sl-info',	   /* Class name of icon show on "Add Sections" */
			'category' => '',	  /* Category to group elements when "Add Sections" */
			'is_container' => false, /* Container has begin + end [name]...[/name] -  Single has only [name param=""] */
			'pop_width' => 580,		/* width of the popup will be open when clicking on the edit  */
			'system_only' => true, /* Use for system only and dont show up to Add Sections */
			'params' => array()
		),
		
		'_styling' => array(
			'system_only' => true,
			'options' => array(
				array(
					'screens' => "any",
					'Typography' => array(
						array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout')),
						array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout')),
						array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout')),
						array('property' => 'font-style', 'label' => __( 'Font Style','mageewp-page-layout')),
						array('property' => 'text-align', 'label' => __( 'Text Align','mageewp-page-layout')),
						array('property' => 'text-shadow', 'label' => __( 'Text Shadow','mageewp-page-layout')),
						array('property' => 'text-transform', 'label' => __( 'Text Transform','mageewp-page-layout')),
						array('property' => 'text-decoration', 'label' => __( 'Text Decoration','mageewp-page-layout')),
						array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout')),
						array('property' => 'letter-spacing', 'label' => __( 'Letter Spacing','mageewp-page-layout')),
						array('property' => 'overflow', 'label' => __( 'Overflow','mageewp-page-layout')),
						array('property' => 'word-break', 'label' => __( 'Word Break','mageewp-page-layout')),					
					),

					//Background group
					'Background' => array(
						array('property' => 'background'),
					),	

					//Box group
					'Box' => array(
						array('property' => 'margin', 'label' => __( 'Margin','mageewp-page-layout')),
						array('property' => 'padding', 'label' => __( 'Padding','mageewp-page-layout')),
						array('property' => 'border', 'label' => __( 'Border','mageewp-page-layout')),
						array('property' => 'width', 'label' => __( 'Width','mageewp-page-layout')),
						array('property' => 'height', 'label' => __( 'Height','mageewp-page-layout')),
						array('property' => 'border-radius', 'label' => __( 'Border Radius','mageewp-page-layout')),
						array('property' => 'float', 'label' => __( 'Float','mageewp-page-layout')),
						array('property' => 'display', 'label' => __( 'Display','mageewp-page-layout')),
						array('property' => 'box-shadow', 'label' => __( 'Box Shadow','mageewp-page-layout')),
						array('property' => 'opacity', 'label' => __( 'Opacity','mageewp-page-layout')),
					),
					
					//Custom code css
					'Custom' => array(
						array('property' => 'custom', 'label' => __( 'Custom CSS','mageewp-page-layout') )
					)
				),
				array(
					"screens" => "1024,999,767,479",
					'Typography' => array(
						array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout')),
						array('property' => 'text-align', 'label' => __( 'Text Align','mageewp-page-layout')),
						array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout')),
						array('property' => 'word-break', 'label' => __( 'Word Break','mageewp-page-layout')),
						array('property' => 'custom', 'label' => __( 'Custom CSS','mageewp-page-layout') )
					),

					//Background group
					'Background' => array(
						array('property' => 'background'),
					),

					//Box group
					'Box' => array(
						array('property' => 'width', 'label' => __( 'Width','mageewp-page-layout')),
						array('property' => 'margin', 'label' => __( 'Margin','mageewp-page-layout')),
						array('property' => 'padding', 'label' => __( 'Padding','mageewp-page-layout')),
						array('property' => 'border', 'label' => __( 'Border','mageewp-page-layout')),
						array('property' => 'height', 'label' => __( 'Height','mageewp-page-layout')),
						array('property' => 'border-radius', 'label' => __( 'Border Radius','mageewp-page-layout')),
						array('property' => 'float', 'label' => __( 'Float','mageewp-page-layout')),
						array('property' => 'display', 'label' => __( 'Display','mageewp-page-layout')),
					),
					
					'Custom' => array(
						array('property' => 'custom', 'label' => __( 'Custom CSS', 'mageewp-page-layout') )
					)
				)
			),
		),

		'mpl_undefined' => array(
			'name' => __( 'Custom Section', 'mageewp-page-layout'),
			'icon' => 'sl-flag',
			'category' => '',
			'is_container' => true,
			'pop_width' => 750,
			'system_only' => true,
			'params' => array(
				array(
					'name' => 'content',
					'label' => __( 'Content', 'mageewp-page-layout'),
					'type' => 'textarea_html',
					'value' => 'Sample Text',
					'admin_label' => true,
				)
			)
		),
					
		'mpl_row' => array(
			'name' => 'Section',
			'description' => __( 'Place content elements inside the row', 'mageewp-page-layout' ),
			'category' => '',
			'title' => __( 'Section Settings', 'mageewp-page-layout'),
			'is_container' => true,
			'system_only' => true,
			'live_editor' => $live_tmpl.'mpl_row.php',
			'params' => array(
				
					
					array(
						'name' => 'row_id',
						'label' => __( 'Section ID', 'mageewp-page-layout'),
						'type' => 'text',
						'description' => __('The unique identifier of the section.', 'mageewp-page-layout'),
					),
					array(
						'name' => 'row_class',
						'label' => __( 'Section extra classes name', 'mageewp-page-layout' ),
						'type' => 'text',
						'description' => __( 'Add additional custom classes to the Row.', 'mageewp-page-layout' ),
					), 

			)
		),
		
		'mpl_column' => array(
			'name' => 'Column',
			'category' => '',
			'title' => 'Column Settings',
			'is_container' => true,
			'system_only' => true,
			'live_editor' => $live_tmpl.'mpl_column.php',
			'params' => array(
				'general' => array(
					array(
						'name' => 'col_container_class',
						'label' => __( 'Container class name', 'mageewp-page-layout' ),
						'type' => 'text',
						'description' => __( 'Add additional classes name to the container in a column.', 'mageewp-page-layout' )
					),
					array(
						'name' => 'col_class',
						'label' => __( 'Column class name', 'mageewp-page-layout' ),
						'type' => 'text',
						'description' => __( 'Add additional classes name to ther outer layer of a column.', 'mageewp-page-layout' )
					),
					array(
						'name' => 'col_id',
						'label' => __( 'Column ID', 'mageewp-page-layout' ),
						'type' => 'text',
						'description' => __( 'Add ID attribute to ther outer layer of a column.', 'mageewp-page-layout' )
					),
					array(
						'name' => 'video_bg',
						'label' => __( 'Use video background?', 'mageewp-page-layout' ),
						'type' => 'toggle',
						'description' => __( 'Background video will be applied to the column.', 'mageewp-page-layout' )
					),
					array(
						'name' => 'video_bg_url',
						'label' => __( 'YouTube link', 'mageewp-page-layout' ),
						'type' => 'text',
						'value' => '',
						'description' => __( 'Add YouTube link.', 'mageewp-page-layout' ),
						'relation' => array(
							'parent' => 'video_bg',
							'show_when' => 'yes'
						),
					),
				),
				'styling' => array(
					array(
						'name'    => 'css_custom',
						'type'    => 'css',
					)
				),
				
			)
		),

		'mpl_section_html' => array(

			'name' => __('Html', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-custom',
			'category' => '',
			'is_container' => true,
			'params' => array(
				'general' => array(
					array(
						'name' => 'section_title',
						'label' => __('Section Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'Custom Html',
						'description' => __('Insert the section title.', 'mageewp-page-layout')
					),
					array(
						'name' => 'section_subtitle',
						'label' => __('Section Subtitle', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => '',
						'description' => __('Insert the section subtitle.', 'mageewp-page-layout')
					),					
					array(
						'name' => 'content',
						'label' => __( 'Content', 'mageewp-page-layout'),
						'type' => 'textarea_html',
						'value' => '<p>This is Custom Section, support ritch html,no support shortcode.</p>',
						'description' => ''
					)
				),
				'styling' => array(
					array(
						'type'			=> 'css',
						'label'			=> __( 'css', 'mageewp-page-layout' ),
						'name'			=> 'css_custom',
						'options'		=> array(
							array(
								'screens' => 'any',
								'Section Title' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'), 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=>'32px', 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
								),
								'Section Subtittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#666666', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.mpl-section-subtitle'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
								),								
								'Content' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'', 'selector' => '.mpl-section-content-wrap,.mpl-section-content-wrap p'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=>'14px', 'selector' => '.mpl-section-content-wrap,.mpl-section-content-wrap p'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.mpl-section-content-wrap,.mpl-section-content-wrap p'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.mpl-section-content-wrap,.mpl-section-content-wrap p'),
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
									array('property' => 'margin', 'label' => __( 'Margin','mageewp-page-layout')),
									array('property' => 'padding', 'value'=> '60px 0px 60px 0px', 'label' => __( 'Padding','mageewp-page-layout')),
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
				
			)

		),

		'mpl_section_features' => array(

			'name' => __('Features', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-features',
			'category' => '',
			'support' => 'pro',
			'rule' => 'pro',
			'params' => array()
		),

		'mpl_google_map' => array(

			'name' => __('Google Map', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-google-map',
			'category' => '',
			'params' => array(
				'general' => array(
					
					array(
						'name' => 'section_title',
						'label' => __('Section Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'Google Map',
						'description' => __('Insert the section title.', 'mageewp-page-layout')
					),
					array(
						'name' => 'section_subtitle',
						'label' => __('Section Subtitle', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => '',
						'description' => __('Insert the section subtitle.', 'mageewp-page-layout')
					),
					array(
						'name' => 'map_height',
						'label' => __( 'Map Height', 'mageewp-page-layout' ),
						'type' => 'number_slider',
						'value' => '400',
						'description' => __( 'Set Content Slider Height if without fullheight', 'mageewp-page-layout' ),
						'options' => array(
						    'min' => '1',
							'max' => '1080',
							'input_value' => true
						)
					),					
					array(
						'type' => 'toggle',
						'label' => __( 'Enable Fullwidth', 'mageewp-page-layout'),
						'value' => '',
						'name' => 'fullwidth',
						'description' => __('Choose to display google map in fullhwidth of the browser.', 'mageewp-page-layout')
					),
					array(
						'name' => 'embed_map',
						'label' => __( 'Google Embed Maps', 'mageewp-page-layout'),
						'type' => 'textarea',
						'value' => base64_encode('<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d104659.84181232643!2d-95.4324908963846!3d29.716831896438116!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8640b8b4488d8501%3A0xca0d02def365053b!2sHouston%2C+TX!5e0!3m2!1sen!2sus!4v1494990969791" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>'),
						'description' => __('Go to <a href="https://www.google.com/maps/" target="_blank">Google Maps</a> and searh your Location. Click on menu near search text =&gt; Share or embed map =&gt; Embed map. Next copy iframe to this field.', 'mageewp-page-layout')
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
								'Section Title' => array(
									array('property' => 'color', 'label' => 'Color', 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'font-size', 'label' => 'Font Size', 'value'=>'32px', 'selector' => 'h2.mpl-section-title,.mpl-section-title'),									                                    array('property' => 'line-height', 'label' => 'Line Height', 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'font-weight', 'label' => 'Font Weight','selector' => 'h2.mpl-section-title,.mpl-section-title'),
								),
								'Section Subtittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.mpl-section-subtitle'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
								),								
								//Background group
								'Background' => array(
									array('property' => 'background'),
								),		

								//Box group
								'Box' => array(
									array('property' => 'margin', 'label' => 'Margin'),
									array('property' => 'padding','value'=> '60px 0px 60px 0px', 'label' => 'Padding'),
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
		
		'mpl_section_service_4' => array(
			'name' => __('Service 4', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-service-4',
			'category' => '',
			'support' => 'pro',
			'rule' => 'pro',
			'params' => array()
		),
		
		'mpl_section_service_5' => array(
			'name' => __('Service 5', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-service-5',
			'category' => '',
			'support' => 'pro',
			'rule' => 'pro',
			'params' => array()
		),

		'mpl_section_post_2' => array(
			'name' => __('Recent Post 2', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-post-2',
			'category' => '',
			'support' => 'pro',
			'rule' => 'pro',
			'params' => array()
		),
		
		'mpl_section_portfolio' => array(
			'name' => __('Portfolio', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-portfolio',
			'category' => '',
			'support' => 'pro',
			'rule' => 'pro',
			'params' => array()
		),

		'mpl_woocommerce' => array(
			'name' => __('Recent Products', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-woocommerce',
			'category' => '',
			'support' => 'pro',
			'rule' => 'pro',
			'params' => array()
		),

		'mpl_section_pricing' => array(

			'name' => __('Pricing', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-pricing',
			'category' => '',
			'support' => 'pro',
			'rule' => 'pro',
			'params' => array()
		),
	
		'mpl_section_pricing_2' => array(

			'name' => __('Pricing', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-pricing-2',
			'category' => '',
			'support' => 'pro',
			'rule' => 'pro',
			'params' => array()
		),
	
		'mpl_section_showcase' => array(

			'name' => __('Showcase', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-showcase',
			'category' => '',
			'support' => 'pro',
			'rule' => 'pro',
			'params' => array()
		),
		
		'mpl_section_skills_2' => array(

			'name' => __('Skills 2', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-skills-2',
			'category' => '',
			'support' => 'pro',
			'rule' => 'pro',
			'params' => array()
		),
		'mpl_section_contact_5' => array(

			'name' => __('Contact 5', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-contact-5',
			'category' => '',
			'support' => 'pro',
			'rule' => 'pro',
			'params' => array()
		),
	),
	'core'
);


if ($mapper && is_array($mapper)) {
	$mpl->add_map ($mapper);
}

