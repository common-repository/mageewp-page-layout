<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$categories = mpl_post_categories('category', true);
$mpl->add_map(
	array(
		'mpl_section_post' => array(
			'name' => __('Recent Post', 'mageewp-page-layout'),
			'description' => '',
			'icon' => 'mpl-icon-post',
			'category' => '',
			'params' => array(
				'general' => array(
					array(
						'name' => 'section_title',
						'label' => __( 'Section Title', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => 'Blog',
						'description' => __('Insert the section title.', 'mageewp-page-layout')
					),
					array(
						'name' => 'section_subtitle',
						'label' => __( 'Section Subtitle', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => '',
						'description' => __('Insert the section subtitle.', 'mageewp-page-layout')
					),
					array(
						'type'			=> 'dropdown',
						'label'			=> __( 'Order by', 'mageewp-page-layout' ),
						'name'			=> 'order_by',
						'description'   => __('Select how to sort blog posts.', 'mageewp-page-layout'),
						'admin_label'	=> true,
						'options' 		=> array(
						    ''          => __('Default','mageewp-page-layout'),
							'ID'		=> __('Post ID', 'mageewp-page-layout'),
							'author'	=> __('Author', 'mageewp-page-layout'),
							'title'		=> __('Title', 'mageewp-page-layout'),
							'name'		=> __('Post name (post slug)', 'mageewp-page-layout'),
							'type'		=> __('Post type (available since Version 4.0)', 'mageewp-page-layout'),
							'date'		=> __('Date', 'mageewp-page-layout'),
							'modified'	=> __('Last modified date', 'mageewp-page-layout'),
							'rand'		=> __('Random order', 'mageewp-page-layout'),
							'comment_count'	=> __('Number of comments', 'mageewp-page-layout')
						)
					),
					array(
						'type'			=> 'dropdown',
						'label'			=> __( 'Order post', 'mageewp-page-layout' ),
						'name'			=> 'order_list',
						'description' => __('Designates the ascending or descending order.', 'mageewp-page-layout'),
						'admin_label'	=> true,
						'options' 		=> array(
						    ''          => __('Default','mageewp-page-layout'),
							'ASC'		=> __('ASC', 'mageewp-page-layout'),
							'DESC'		=> __('DESC', 'mageewp-page-layout'),
						)
					),
					array(
						'type'			=> 'number_slider',
						'label'			=> __( 'Number of posts displayed', 'mageewp-page-layout' ),
						'name'			=> 'number_post',
						'description'	=> __( 'The number of posts you want to show.', 'mageewp-page-layout' ),
						'value'			=> '5',
						'admin_label'	=> true,
						'options' => array(
							'min' => 1,
							'max' => 20
						)
					),
					array(
						'type'			=> 'dropdown',
						'label'			=> __( 'Category', 'mageewp-page-layout' ),
						'name'			=> 'category',
						'description' => '',
						'admin_label'	=> true,
						'options' 		=> $categories
					),
					
					array(
						'type'			=> 'toggle',
						'label'			=> __( 'Show thumbnail', 'mageewp-page-layout' ),
						'name'			=> 'thumbnail',
						'description'	=> __( 'Choose to display the post thumbnail.', 'mageewp-page-layout' ),
						'value'			=> 'yes',
					),
					array(
						'type'			=> 'select',
						'label'			=> __( 'Image size', 'mageewp-page-layout' ),
						'name'			=> 'image_size',
						'description'	=> __( 'Set the image size : thumbnail, medium, large or full.', 'mageewp-page-layout' ),
						'value'			=> 'large',
						'options'       => array(
							'thumbnail' => __( 'Thumbnail', 'mageewp-page-layout' ),
							'medium' => __( 'Medium', 'mageewp-page-layout' ),
							'large' => __( 'Large', 'mageewp-page-layout' ),
							'full' => __( 'Full', 'mageewp-page-layout' ),
						),
						'relation' 	=> array(
							'parent'	=> 'thumbnail',
							'show_when'		=> 'yes'
						)
					),
					array(
						'type'			=> 'toggle',
						'label'			=> __( 'Show date', 'mageewp-page-layout' ),
						'name'			=> 'show_date',
						'description'	=> __( 'Choose to display post date', 'mageewp-page-layout' ),
						'value'			=> 'yes',
					),
					array(
						'name' => 'columns',
						'label' => __('Columns', 'mageewp-page-layout'),
						'type' => 'select',
						'value' => '3',
						'description' => __('The number of items displayed per row (not apply for auto-height).', 'mageewp-page-layout'),
						'options' => array(
						  '1' => '1',
						  '2' => '2',
						  '3' => '3',
						  '4' => '4',
						  '5' => '5',
						  '6' => '6',
						)
					),
				),
				'styling' => array(
					array(
						'name'    => 'css_custom',
						'type'    => 'css',
						'options' => array(
							array(
								"screens" => "any",
								'Title' => array(
									array('property' => 'color', 'label' => 'Color', 'selector' => 'h2.mpl-section-title'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => 'h2.mpl-section-title'),
									array('property' => 'font-size', 'label' => 'Text Size', 'value'=> '32px', 'selector' => 'h2.mpl-section-title'),
									array('property' => 'line-height', 'label' => 'Line Height', 'selector' => 'h2.mpl-section-title'),
									array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => 'h2.mpl-section-title'),
								),
								'Subtittle' => array(
									array('property' => 'color', 'label' => __( 'Color','mageewp-page-layout'),'value'=>'#333333', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-size', 'label' => __( 'Font Size','mageewp-page-layout'), 'value'=> '14px','selector' => '.mpl-section-subtitle'),
									array('property' => 'line-height', 'label' => __( 'Line Height','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
									array('property' => 'font-weight', 'label' => __( 'Font Weight','mageewp-page-layout'), 'selector' => '.mpl-section-subtitle'),
								),
								'Post Meta' => array(
									array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.entry-meta,.entry-meta a'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.entry-meta,.entry-meta a'),
									array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.entry-meta,.entry-meta a'),
									array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.entry-meta,.entry-meta a'),
									array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.entry-meta,.entry-meta a'),
									array('property' => 'color', 'label' => 'Color', 'selector' => '.entry-meta,.entry-meta a'),
								),
								'Post Title' => array(
									array('property' => 'color', 'label' => 'Color', 'selector' => 'h3.entry-title a'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => 'h3.entry-title a'),
									array('property' => 'font-size', 'label' => 'Text Size', 'selector' => 'h3.entry-title a'),
									array('property' => 'line-height', 'label' => 'Line Height', 'selector' => 'h3.entry-title a'),
									array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => 'h3.entry-title a'),
								),

								'Post Content' => array(
									array('property' => 'color', 'label' => 'Color', 'selector' => '.entry-summary'),
									array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.entry-summary'),
									array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.entry-summary'),
									array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.entry-summary'),
									array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.entry-summary'),
									array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.entry-summary'),
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
					)
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
	$mpl->add_map_param('mpl_section_post', $carousel_params[$i], null, 'general');
}