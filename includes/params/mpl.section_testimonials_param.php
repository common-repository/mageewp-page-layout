<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mpl->add_map(
	array(
		'mpl_section_testimonials' => array(

			'name' => __('Testimonials', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-testimonials',
			'category' => '',
			'params' => array(
				'general' => array(
					
					array(
						'name' => 'section_title',
						'label' => __('Section Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'TESTIMONIALS',
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
						'name' => 'layout',
						'label' => __('Testimonial Type', 'mageewp-page-layout'),
						'type' => 'radio_image',
						'value' => '3',
						'description' => __('Select style for the Testimonial item.', 'mageewp-page-layout'),
						'options' => array(
						   'pro_1' => MPL_URL.'/assets/images/testimonials_layout_1.png',
						   '2' => MPL_URL.'/assets/images/testimonials_layout_2.png',
						   '3' => MPL_URL.'/assets/images/testimonials_layout_3.png',
						)
					),
					array(
						'name' => 'columns',
						'label' => __('Columns', 'mageewp-page-layout'),
						'type' => 'select',
						'value' => '2',
						'description' => __('Set columns for testimonials section.', 'mageewp-page-layout'),
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
						'label'			=> __('Items', 'mageewp-page-layout'),
						'name'			=> 'testimonials',
						'description'	=> '',
						'options'		=> '',

						'value' => base64_encode( json_encode(array(
							"1" => array(
								"image" => MPL_URL .'/assets/images/params/testimonial_80_80.png',
								"name"  => 'Client 1',
								"title" => 'CEO',
								"desc"  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam congue gravida ligula eget congue. Quisque nibh nunc, dapibus id pulvinar id, interdum quis enim.'
							),
							"2" => array(
								"image" => MPL_URL .'/assets/images/params/testimonial_80_80.png',
								"name"  => 'Client 1',
								"title" => 'CEO',
								"desc"  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam congue gravida ligula eget congue. Quisque nibh nunc, dapibus id pulvinar id, interdum quis enim.'
							),
							"3" => array(
								"image" => MPL_URL .'/assets/images/params/testimonial_80_80.png',
								"name"  => 'Client 1',
								"title" => 'CEO',
								"desc"  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam congue gravida ligula eget congue. Quisque nibh nunc, dapibus id pulvinar id, interdum quis enim.'
							),					
						) ) ),
						'params' => array(
						   array(
							    'type' => 'text',
								'label' => __( 'Name', 'mageewp-page-layout' ),
								'name' => 'name',
								'description' => __('Insert name for client.', 'mageewp-page-layout')
							),
							array(
								'type' => 'attach_image_url',
								'label' => __( 'Avatar', 'mageewp-page-layout' ),
								'name' => 'image',
								'value' => MPL_URL .'/assets/images/params/testimonial_80_80.png',
								'description' => __('Insert avatar for client.', 'mageewp-page-layout')
							),
							array(
							    'type' => 'text',
								'label' => __( 'Job Title', 'mageewp-page-layout' ),
								'name' => 'title',
								'description' => __('Insert job title for client.', 'mageewp-page-layout')
							),
							array(
								'name' => 'desc',
								'label' => __( 'Description', 'mageewp-page-layout' ),
							    'type' => 'textarea',
								'description' => __('Insert description for client.', 'mageewp-page-layout')
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
									array('property' => 'color', 'label' => 'Color','value'=>'', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-size', 'label' => 'Font Size','value'=>'32px', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'line-height', 'label' => 'Line Height', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-weight', 'label' => 'Font Weight','selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
								),
								'Subtittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.mpl-section-subtitle'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
								),
								'Items Name/Tittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.person-name,.person-title'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.person-name,.person-title'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '20px','selector' => '.person-name,.person-title'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.person-name,.person-title'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.person-name,.person-title'),
								),
								'Items Description' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.person-desc'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.person-desc'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.person-desc'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.person-desc'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.person-desc'),
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

$carousel_params[0]['value'] = 'yes';
$carousel_count = count($carousel_params);
for( $i = 0; $i < $carousel_count; $i++ )
{
	$mpl->add_map_param('mpl_section_testimonials', $carousel_params[$i], null, 'general');
}
