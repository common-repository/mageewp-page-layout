<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mpl->add_map(
	array(
		'mpl_section_call_to_action' => array(
			'name' => __('Call To Action', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-call-to-action',
			'category' => '',
			'pop_width' => 400,
			'params' => array(
				'general' => array(
					
					array(
						'name' => 'title',
						'label' => __('Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => __('Lorem ipsum dolor sit amet', 'mageewp-page-layout'),
						'description' => __('Insert the title for Call to Action.', 'mageewp-page-layout')
					),
					array(
						'name' => 'content',
						'label' => __('Content', 'mageewp-page-layout'),
						'type' => 'textarea',
						'value' => base64_encode('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi egestas, libero non faucibus tempor, nunc augue posuere tortor, quis tempus ex eros quis augue. Praesent bibendum feugiat lectus, at commodo dolor faucibus vitae. Proin ullamcorper ornare orci ac interdum. Sed elementum pretium tellus et dictum.'),
						'description' => __('Insert the description for Call to Action.', 'mageewp-page-layout')
					),
					
					array(
						'name' => 'text_align',
						'label' => __('Title/Content Align', 'mageewp-page-layout'),
						'type' => 'select',
						'value' => 'left',
						'description' => __('Choose how the content should be displayed.', 'mageewp-page-layout'),
						'options' => array(
						   'left' => __( 'Left','mageewp-page-layout'),
						   'center' => __( 'Center','mageewp-page-layout'),
						   'right' => __( 'Right','mageewp-page-layout'),
						)
					),
					
					array(
						'name' => 'btn_text',
						'label' => __('Button Text', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'Action',
						'description' => __('Insert the text that will display in the button.','mageewp-page-layout')
					),
					array(
						'name' => 'btn_position',
						'label' => __('Button Position', 'mageewp-page-layout'),
						'type' => 'select',
						'value' => 'right',
						'description' => __('Select position of the action button.','mageewp-page-layout'),
						'options' => array(
						   'hidden' => __( 'Hidden','mageewp-page-layout'), 
						   'left' => __( 'Left','mageewp-page-layout'), 
						   'right' => __( 'Right','mageewp-page-layout'),
						   'top' => __( 'Top','mageewp-page-layout'),
						   'bottom' => __( 'Bottom','mageewp-page-layout'),
						)
					),
					array(
						'name' => 'btn_link',
						'label' => __('Button Link', 'mageewp-page-layout'),
						'type' => 'link',
						'value' => '#',
						'description' => __('The url the button will link to.','mageewp-page-layout')
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
									array('property' => 'color', 'label' => 'Color', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-size', 'label' => 'Font Size', 'value'=> '32px','selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'line-height', 'label' => 'Line Height', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
								),
								'Content' => array(
									array('property' => 'color', 'label' => 'Color', 'selector' => '.mpl-action-desc'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-action-desc'),
									array('property' => 'font-size', 'label' => 'Font Size', 'value'=> '14px','selector' => '.mpl-action-desc'),
									array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.mpl-action-desc'),
									array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.mpl-action-desc'),
								),
								'Button' => array(
									array('property' => 'background-color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#8bc03c', 'selector' => '.mpl-btn-normal'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-btn-normal'),
									array('property' => 'font-size', 'label' => 'Font Size', 'value'=> '14px','selector' => '.mpl-btn-normal'),
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

