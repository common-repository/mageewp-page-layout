<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mpl->add_map(
	array(
		'mpl_section_skills' => array(

			'name' => __('Skills', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-skills',
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
						'value' => '',
						'description' => __('Insert the section subtitle.', 'mageewp-page-layout')
					),
					array(
						'name' => 'columns',
						'label' => __('Columns', 'mageewp-page-layout'),
						'type' => 'select',
						'value' => '4',
						'description' => __('Set columns for skills section', 'mageewp-page-layout'),
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
						'name'			=> 'items',
						'description'	=> '',
						'options'		=> '',

						'value' => base64_encode( json_encode(array(
							"1" => array(
								"percent" => '73',
								"title" => "Design",
								"desc" => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
								"barcolor" => '#f33b3d',
							),
							"2" => array(
								"percent" => '93',
								"title" => "Html",
								"desc" =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
								"barcolor" => '#8bc03c',
							),
							"3" => array(
								"percent" => '63',
								"title" => "WordPress",
								"desc" =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
								"barcolor" => '#33c2ca',
							),
							"4" => array(
								"percent" => '78',
								"title" => "UI/UX",
								"desc" =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
								"barcolor" => '#fec957',
							)
						) ) ),
						'params' => array(
							
							array(
								'type' => 'text',
								'label' => __( 'Title', 'mageewp-page-layout' ),
								'name' => 'title',
								'description' => __('Insert the item title.', 'mageewp-page-layout')
							),
							array(
								'type' => 'text',
								'label' => __( 'Percent', 'mageewp-page-layout' ),
								'name' => 'percent',
								'description' => __('Insert the item percent.', 'mageewp-page-layout')
							),
							array(
								'type' => 'textarea',
								'label' => __( 'Description', 'mageewp-page-layout' ),
								'name' => 'desc',
								'description' => __('Insert the item description.', 'mageewp-page-layout')
							),
							array(
								'type' => 'color_picker',
								'label' => __( 'BarColor', 'mageewp-page-layout' ),
								'name' => 'barcolor',
								'description' => __('Select color for the item bar.', 'mageewp-page-layout')
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
									array('property' => 'font-size', 'label' => 'Font Size','value'=>'32px', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),									                                    array('property' => 'line-height', 'label' => 'Line Height', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-weight', 'label' => 'Font Weight','selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
								),
								'Subtittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.mpl-section-subtitle'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
								),
								'Items Percent' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.percent'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.percent'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '20px','selector' => '.percent'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.percent'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.percent'),
								),
								'Items Tittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.title'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.title'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '20px','selector' => '.title'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.title'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.title'),
								),
								'Items Description' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.desc'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.desc'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.desc'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.desc'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.desc'),
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

$carousel_params[0]['value'] = 'no';
$carousel_count = count($carousel_params);
for( $i = 0; $i < $carousel_count; $i++ )
{
	$mpl->add_map_param('mpl_section_skills', $carousel_params[$i], null, 'general');
}