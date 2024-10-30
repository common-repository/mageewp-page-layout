<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mpl->add_map(
	array(
		'mpl_section_promo' => array(

			'name' => __('Promo', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-promo',
			'category' => '',
			'params' => array(
				'general' => array(
					
					array(
						'name' => 'section_title',
						'label' => __('Section Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'About Me',
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
						'type' => 'attach_image_url',
						'label' => __( 'Image', 'mageewp-page-layout' ),
						'name' => 'image',
						'description' => __('Choose to upload image.', 'mageewp-page-layout'),
						'value' => MPL_URL .'/assets/images/params/promo_800_600.jpg'
					),
					array(
						'type' => 'select',
						'label' => __( 'Content Position', 'mageewp-page-layout' ),
						'name' => 'content_position',
						'description' => __('Choose position for text content.', 'mageewp-page-layout'),
						'value' => 'right',
						'options' => array(
							'left' => __('Left', 'mageewp-page-layout'  ),
							'right' => __('Right', 'mageewp-page-layout'  ),
						)
					),
					array(
						'type' => 'select',
						'label' => __( 'Image Align', 'mageewp-page-layout' ),
						'name' => 'image_align',
						'description' => __('Set align way for image.', 'mageewp-page-layout'),
						'value' => 'left',
						'options' => array(
							'left' => __('Left', 'mageewp-page-layout'  ),
							'center' => __('Center', 'mageewp-page-layout'  ),
							'right' => __('Right', 'mageewp-page-layout'  ),
						)
					),
					array(
						'type'			=> 'textarea',
						'name'			=> 'desc',
						'label'			=> __( 'Description', 'mageewp-page-layout' ),
						'value'			=> base64_encode('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pretium, ante id semper congue, metus turpis ullamcorper libero, at fringilla augue leo sed neque. Suspendisse elementum et enim in cursus. Vestibulum eget nibh dapibus, commodo magna quis, posuere risus. Sed sit amet arcu neque. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis tempus finibus risus, bibendum rhoncus augue aliquam quis. Nulla urna turpis, porta eget tristique aliquam, suscipit fringilla sem. Duis volutpat metus non elit tempor sagittis.'),
						'description' => __('Insert the description for promo. Html code is allowed', 'mageewp-page-layout')
					),
					array(
						'name' => 'button_text',
						'label' => __( 'Button Text', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'More',
						'description' => __('Insert the text that will display in the button.','mageewp-page-layout')
					),
					
					array(
						'name'     => 'button_link',
						'label'    => __('Button Link', 'mageewp-page-layout'),
						'type'     => 'link',
						'description' => __('The url the button will link to.','mageewp-page-layout')
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
								'Content' => array(
									array('property' => 'color', 'label' => 'Color','value'=>'#333333', 'selector' => '.mpl-promo-content'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-promo-content'),
									array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.mpl-promo-content'),
									array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.mpl-promo-content'),
									array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.mpl-promo-content'),
								),
								'Button' => array(
									array('property' => 'background-color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#8bc03c', 'selector' => '.mpl-promo .mpl-btn-normal'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-promo .mpl-btn-normal'),
									array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.mpl-promo .mpl-btn-normal'),
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
	),
	'core'
);

