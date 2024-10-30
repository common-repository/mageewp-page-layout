<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$mpl->add_map(
	array(
		'mpl_section_team' => array(

			'name' => __('Team', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-team',
			'category' => '',
			'params' => array(
				'general' => array(
					
					array(
						'name' => 'section_title',
						'label' => __('Section Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'MEET OUR TEAM',
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
						'value' => '3',
						'description' => __('Set columns for team section', 'mageewp-page-layout'),
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
						'label'			=> __('Members', 'mageewp-page-layout'),
						'name'			=> 'persons',
						'description'	=> '',
						'options'		=> '',

						'value' => base64_encode( json_encode(array(
							"1" => array(
								"image" => MPL_URL .'/assets/images/params/team_370_370.jpg',
								"link"  => '',
								"name"  => 'Team 1',
								"title" => 'CEO',
								"desc"  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam congue gravida.',
								"social_1" => 'fa-instagram',
								"social_2" => 'fa-facebook',
								"social_3" => 'fa-google-plus',
								"social_4" => 'fa-envelope',
								"social_1_link" => '#',
								"social_2_link" => '#',
								"social_3_link" => '#',
								"social_4_link" => '#',
							),
							"2" => array(
								"image" => MPL_URL .'/assets/images/params/team_370_370.jpg',
								"link"  => '',
								"name"  => 'Team 2',
								"title" => 'CEO',
								"desc"  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam congue gravida.',
								"social_1" => 'fa-instagram',
								"social_2" => 'fa-facebook',
								"social_3" => 'fa-google-plus',
								"social_4" => 'fa-envelope',
								"social_1_link" => '#',
								"social_2_link" => '#',
								"social_3_link" => '#',
								"social_4_link" => '#',
							),
							"3" => array(
								"image" => MPL_URL .'/assets/images/params/team_370_370.jpg',
								"link"  => '',
								"name"  => 'Team 3',
								"title" => 'CEO',
								"desc"  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam congue gravida.',
								"social_1" => 'fa-instagram',
								"social_2" => 'fa-facebook',
								"social_3" => 'fa-google-plus',
								"social_4" => 'fa-envelope',
								"social_1_link" => '#',
								"social_2_link" => '#',
								"social_3_link" => '#',
								"social_4_link" => '#',
							),
							
						) ) ),
						'params' => array(
						    array(
								'type' => 'text',
								'label' => __( 'Name', 'mageewp-page-layout' ),
								'name' => 'name',
								'description' => __('Insert name for team member.', 'mageewp-page-layout')
							),
							array(
								'type' => 'attach_image_url',
								'label' => __( 'Image', 'mageewp-page-layout' ),
								'name' => 'image',
								'value' => MPL_URL .'/assets/images/params/team_370_370.jpg',
								'description' => __('Insert avatar for team member.', 'mageewp-page-layout')
							),
							array(
								'type' => 'text',
								'label' => __( 'Image Link', 'mageewp-page-layout' ),
								'name' => 'link',
								'description' => __('Insert link for member avatar.', 'mageewp-page-layout')
							),
							array(
								'type' => 'text',
								'label' => __( 'Title', 'mageewp-page-layout' ),
								'name' => 'title',
								'description' => __('Insert job title for team member.', 'mageewp-page-layout')
							),
							array(
								'type' => 'textarea',
								'label' => __( 'Description', 'mageewp-page-layout' ),
								'name' => 'desc',
								'description' => __('Insert description for team member.', 'mageewp-page-layout')
							),
							array(
								'type' => 'icon_picker',
								'label' => __( 'Social 1', 'mageewp-page-layout' ),
								'name' => 'social_1',
								'description' => __('Select an icon.', 'mageewp-page-layout')
							),
							array(
								'type' => 'text',
								'label' => __( 'Social 1 Link', 'mageewp-page-layout' ),
								'name' => 'social_1_link',
								'description' => __('The url the icon will link to.','mageewp-page-layout')
							),
							array(
								'type' => 'icon_picker',
								'label' => __( 'Social 2', 'mageewp-page-layout' ),
								'name' => 'social_2',
								'description' => __('Select an icon.', 'mageewp-page-layout')
							),
							array(
								'type' => 'text',
								'label' => __( 'Social 2 Link', 'mageewp-page-layout' ),
								'name' => 'social_2_link',
								'description' => __('The url the icon will link to.','mageewp-page-layout')
							),
							array(
								'type' => 'icon_picker',
								'label' => __( 'Social 3', 'mageewp-page-layout' ),
								'name' => 'social_3',
								'description' => __('Select an icon.', 'mageewp-page-layout')
							),
							array(
								'type' => 'text',
								'label' => __( 'Social 3 Link', 'mageewp-page-layout' ),
								'name' => 'social_3_link',
								'description' => __('The url the icon will link to.','mageewp-page-layout')
							),
							array(
								'type' => 'icon_picker',
								'label' => __( 'Social 4', 'mageewp-page-layout' ),
								'name' => 'social_4',
								'description' => __('Select an icon.', 'mageewp-page-layout')
							),
							array(
								'type' => 'text',
								'label' => __( 'Social 4 Link', 'mageewp-page-layout' ),
								'name' => 'social_4_link',
								'description' => __('The url the icon will link to.','mageewp-page-layout')
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
									array('property' => 'font-size', 'label' => 'Font Size', 'value'=>'32px', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),									                                    array('property' => 'line-height', 'label' => 'Line Height', 'selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
									array('property' => 'font-weight', 'label' => 'Font Weight','selector' => 'h1.mpl-section-title,h2.mpl-section-title'),
								),
								'Subtittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.mpl-section-subtitle'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
								),								
								'Persons Name/Tittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.person-name,.person-title'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.person-name,.person-title'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '20px','selector' => '.person-name,.person-title'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.person-name,.person-title'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.person-name,.person-title'),
								),
								'Persons Description' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.person-desc'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.person-desc'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.person-desc'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.person-desc'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.person-desc'),
								),
								'Persons Social' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.person-social li a'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.person-social li a'),
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
	$mpl->add_map_param('mpl_section_team', $carousel_params[$i], null, 'general');
}
