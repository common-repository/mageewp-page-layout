<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mpl->add_map(
	array(
		'mpl_section_contact_4' => array(

			'name' => __('Contact 4', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-contact-4',
			'category' => '',
			'params' => array(
				'general' => array(
					
					array(
						'name' => 'section_title',
						'label' => __('Section Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'Contact',
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
						'name' => 'contact_info_title',
						'label' => __('Contact Info Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'Let\'s Keep in Touch',
						'description' => __('Insert the contact info title.', 'mageewp-page-layout')
					),
					
					array(
						'name' => 'contact_address',
						'label' => __('Address', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => '49 Costa Street, New Yoark City, USA',
						'description' => __('Insert the contact address.', 'mageewp-page-layout')
					),
					
					array(
						'name' => 'contact_email',
						'label' => __('Email', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => get_option( 'admin_email' ),
						'description' => __('Insert the contact email address.', 'mageewp-page-layout')
					),
					
					array(
						'name' => 'contact_phone',
						'label' => __('Phone', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => '595 12 34 567',
						'description' => __('Insert the contact phone number.', 'mageewp-page-layout')
					),
										
										
					array(
						'name' => 'button_text',
						'label' => __('Button Text', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => __('SEND YOUR MESSAGE', 'mageewp-page-layout'),
						'description' => __('Insert the text that will display in the button.','mageewp-page-layout')
					),
					
					array(
						'name' => 'contact_receiver',
						'label' => __('Contact Form Receiver', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => '',
						'description' => __('Insert the email receiver of this form.','mageewp-page-layout')
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
									array('property' => 'color', 'label' => 'Color','value'=>'#333333', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-size', 'label' => 'Font Size','value'=>'32px', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),									array('property' => 'line-height', 'label' => 'Line Height', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
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
									array('property' => 'color', 'label' => 'Color','value'=>'', 'selector' => '.title,.text,.mpl-contact'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.title,.text,.mpl-contact'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.title,.text,.mpl-contact'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.title,.text,.mpl-contact'),
									array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.title,.text,.mpl-contact'),
								),
								'Button' => array(
									array('property' => 'background-color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#8bc03c', 'selector' => '.mpl-contact-form #submit'),
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

