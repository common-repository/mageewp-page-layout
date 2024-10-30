<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mpl->add_map(
	array(
		'mpl_section_clients' => array(
			'name' => __('Clients', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-clients',
			'category' => '',
			'params' => array(
				'general' => array(
					
					array(
						'name' => 'section_title',
						'label' => __('Section Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'Clients',
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
						'name' => 'columns',
						'label' => __('Columns', 'mageewp-page-layout'),
						'type' => 'select',
						'value' => '4',
						'description' => __('Set columns for clients section', 'mageewp-page-layout'),
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
						'type'			=> 'group',
						'label'			=> __('Clients List', 'mageewp-page-layout'),
						'name'			=> 'client',
						'description'	=> '',
						'options'		=> '',

						'value' => base64_encode( json_encode(array(
							"1" => array(
								"image" => MPL_URL .'/assets/images/params/client_180_120.jpg',
								"link" => '#',
								"target" => '_blank' 
							),
							"2" => array(
								"image" => MPL_URL .'/assets/images/params/client_180_120.jpg',
								"link" => '#',
								"target" => '_blank'
							),
							"3" => array(
								"image" => MPL_URL .'/assets/images/params/client_180_120.jpg',
								"link" => '#',
								"target" => '_blank'
							),
							"4" => array(
								"image" => MPL_URL .'/assets/images/params/client_180_120.jpg',
								"link" => '#',
								"target" => '_blank'
							),
							"5" => array(
								"image" => MPL_URL .'/assets/images/params/client_180_120.jpg',
								"link" => '#',
								"target" => '_blank'
							)
						) ) ),
						'params' => array(
							
							array(
								'type' => 'attach_image_url',
								'label' => __( 'Client Image', 'mageewp-page-layout' ),
								'name' => 'image',
								'value' => MPL_URL .'/assets/images/params/client_180_120.jpg',
								'description' => __('Choose to upload image.', 'mageewp-page-layout'),
								'admin_label' => true,
							),
							array(
								'type' => 'text',
								'label' => __( 'Link', 'mageewp-page-layout' ),
								'name' => 'link',
								'description' => __('The url the image will link to.','mageewp-page-layout'),
								'admin_label' => true,
							),
							array(
								'type' => 'select',
								'label' => __( 'Target', 'mageewp-page-layout' ),
								'name' => 'target',
								'description' => '',
								'options' => array(
								   '_self' => __('Self','mageewp-page-layout'),
								   '_blank' => __('Blank','mageewp-page-layout'),
								),
								'admin_label' => true,
							),						
							
						),
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
									array('property' => 'font-size', 'label' => 'Font Size', 'value'=> '32px', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),									                                    array('property' => 'line-height', 'label' => 'Line Height', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-weight', 'label' => 'Font Weight','selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
								),
								'Subtittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.mpl-section-subtitle'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
								),								
								//Background group
								'Background' => array(
									array('property' => 'background', 'value' => base64_encode(json_encode(array('color' => '#f0f0f0')))),
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

$carousel_params[0]['value'] = 'yes';
$carousel_count = count($carousel_params);
for( $i = 0; $i < $carousel_count; $i++ )
{
	$mpl->add_map_param('mpl_section_clients', $carousel_params[$i], null, 'general');
}
