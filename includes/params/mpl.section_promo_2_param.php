<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mpl->add_map(
	array(
		'mpl_section_promo_2' => array(
			'name' => __('Promo 2', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-promo-2',
			'category' => '',
			'params' => array(
				'general' => array(
					array(
						'name' => 'section_title',
						'label' => __('Section Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'WHY CHOOSE US',
						'description' => __('Insert the section title.', 'mageewp-page-layout')
					),
					array(
						'name' => 'section_subtitle',
						'label' => __('Section Subtitle', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'Aliquam fringilla odio a velit facilisis in eleifend',
						'description' => __('Insert the section subtitle.', 'mageewp-page-layout')
					),
					array(
						'label' => __( 'Layout', 'mageewp-page-layout' ),
						'name' => 'layout',
						'description' => __('Select the way the promo displays.', 'mageewp-page-layout'),
						'type' => 'radio_image',
						'value' => 'left',
						'options'		=> array(
							'left' => MPL_URL. '/assets/images/promo_layout_left.png',
							'right' => MPL_URL. '/assets/images/promo_layout_right.png',
							'top' => MPL_URL. '/assets/images/promo_layout_top.png',
							'bottom' => MPL_URL. '/assets/images/promo_layout_bottom.png',
						)
					),
					array(
						'type' => 'attach_image_url',
						'label' => __( 'Image', 'mageewp-page-layout' ),
						'name' => 'image',
						'value' => MPL_URL .'/assets/images/params/promo_550_290.jpg',
						'description' => __('Choose to upload image.', 'mageewp-page-layout')
					),
					array(
						'name' => 'image_align',
						'label' => __( 'Image Align', 'mageewp-page-layout' ),
						'type' => 'select',
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
						'value'			=> base64_encode('Praesent vulputate eleifend metus, sed interdum leo venenatis interdum. Curabitur mollis vestibulum nulla, sit amet ultricies ipsum semper eu. Pellentesque tempor id mi non sodales. Curabitur id ipsum in sapien pretium ultrices nec eu dui.Fusce cursus, arcu ut pulvinar aliquet, neque odio feugiat ex, eu lobortis justo mauris sit amet nisl. Nunc eget neque hendrerit ante aliquet tempus a sed nisl. Maecenas condimentum gravida neque, sit amet imperdiet diam lacinia quis. Nulla vestibulum dignissim ex, sit amet commodo risus sollicitudin eget.'),
						'description' => __('Insert the description for promo. Html code is allowed', 'mageewp-page-layout')
					),
					array(
						'name' => 'button_text',
						'label' => __( 'Button Text', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'READ MORE',
						'description' => __('Insert the text that will display in the button.','mageewp-page-layout')
					),
					array(
						'name'     => 'button_link',
						'label'    => __('Button Link', 'mageewp-page-layout'),
						'type'     => 'link',
						'value'    => '#',
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
									array('property' => 'color', 'label' => 'Color','selector' => '.mpl-promo-content'),
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
		)
	),
	'core'
);

