<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mpl->add_map(
	array(
		'mpl_section_counter' => array(

			'name' => __('Counter', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-counter',
			'category' => '',
			'params' => array(
				'general' => array(
					
					array(
						'name' => 'section_title',
						'label' => __('Section Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => '',
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
						'description' => __('Set columns for counter section', 'mageewp-page-layout'),
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
						'label'			=> __('Counter List', 'mageewp-page-layout'),
						'name'			=> 'counter',
						'description'	=> '',
						'options'		=> '',

						'value' => base64_encode( json_encode(array(
							"1" => array(
								"title"  => 'STANDARD',
								"number" => '200',		 			
							),
							"2" => array(
								"title"  => 'Supporters',
								"number" => '98',							
							),
							"3" => array(
								"title"  => 'Projects',
								"number" => '1360',						
							),
							"4" => array(
								"title"  => 'Customers',
								"number" => '8000',						
							),
						) ) ),
						'params' => array(
						    array(
							    'type' => 'text',
								'label' => __( 'Counter Title', 'mageewp-page-layout' ),
								'name' => 'title',
								'description' => __('Insert the counter title.', 'mageewp-page-layout')
							),
							array(
								'type' => 'text',
								'label' => __( 'Counter Number', 'mageewp-page-layout' ),
								'name' => 'number',
								'description' => __('Insert the counter number.', 'mageewp-page-layout')
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
									array('property' => 'color', 'label' => 'Color', 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-size', 'label' => 'Font Size', 'value'=> '32px', 'selector' => 'h2.mpl-section-title,.mpl-section-title'),									                                    array('property' => 'line-height', 'label' => 'Line Height', 'selector' => 'h2.mpl-section-title,.mpl-section-title'),
									array('property' => 'font-weight', 'label' => 'Font Weight','selector' => 'h2.mpl-section-title,.mpl-section-title'),
								),
								'Subtittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.mpl-section-subtitle'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
								),								
								'Counter Title' => array(
									array('property' => 'color', 'label' => 'Color','selector' => '.mpl-counter-box .mpl-counter-title'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-counter-box .mpl-counter-title'),
									array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.mpl-counter-box .mpl-counter-title'),									                                    array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.mpl-counter-box .mpl-counter-title'),
									array('property' => 'font-weight', 'label' => 'Font Weight','selector' => '.mpl-counter-box .mpl-counter-title'),
								),	
								'Counter Number' => array(
									array('property' => 'color', 'label' => 'Color', 'selector' => '.mpl-counter-box .mpl-counter-num'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-counter-box .mpl-counter-num'),
									array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.mpl-counter-box .mpl-counter-num'),									                                    array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.mpl-counter-box .mpl-counter-num'),
									array('property' => 'font-weight', 'label' => 'Font Weight','selector' => '.mpl-counter-box .mpl-counter-num'),
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

$carousel_params[0]['value'] = 'no';
$carousel_count = count($carousel_params);
for( $i = 0; $i < $carousel_count; $i++ )
{
	$mpl->add_map_param('mpl_section_counter', $carousel_params[$i], null, 'general');
}
