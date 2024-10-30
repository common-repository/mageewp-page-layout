<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();
$microwidgets_params = array(
	"Search" => array(
		array(
			'name' => 'caption',
			'type' => 'text',
			'label' => __( 'Caption', 'mageewp-page-layout' ),
			'description' => '',
		),
		array(
			'name' => 'show_icon',
			'type' => 'toggle',
			'label' => __( 'Show graphic icon', 'mageewp-page-layout' ),
			'description' => '',
			'value' => 'yes',
			'options' => array(
				'yes'	=> __('YES', 'mageewp-page-layout'),
				'no'	=> __('NO', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'on_desktops',
			'type' => 'radio',
			'label' => __( 'On desktops', 'mageewp-page-layout' ),
			'description' => '',
			'value'	=> 'show',
			'options' => array(
				'show' => __('Show', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'tablet',
			'type' => 'radio',
			'label' => __( 'First header switch point (tablet)', 'mageewp-page-layout' ),
			'description' => '',
			'value'	=> 'leave',
			'options' => array(
				'leave' => __('Leave as is', 'mageewp-page-layout'),
				'show' => __('Show in the menu', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'phone',
			'type' => 'radio',
			'label' => __( 'Second header switch point (phone)', 'mageewp-page-layout' ),
			'description' => '',
			'value'	=> 'logo',
			'options' => array(
				'menu' => __('Show in the menu', 'mageewp-page-layout'),
				'logo' => __('Show near logo', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
	),
	"Text" => array(
		array(
			'name' => 'content',
			'type' => 'text',
			'label' => __( 'Content', 'mageewp-page-layout' ),
			'description' => '',
		),
		array(
			'name' => 'on_desktops',
			'type' => 'radio',
			'label' => __( 'On desktops', 'mageewp-page-layout' ),
			'description' => '',
			'value'	=> 'show',
			'options' => array(
				'show' => __('Show', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'tablet',
			'type' => 'radio',
			'label' => __( 'First header switch point (tablet)', 'mageewp-page-layout' ),
			'description' => '',
			'value'	=> 'leave',
			'options' => array(
				'leave' => __('Leave as is', 'mageewp-page-layout'),
				'show' => __('Show in the menu', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'phone',
			'type' => 'radio',
			'label' => __( 'Second header switch point (phone)', 'mageewp-page-layout' ),
			'description' => '',
			'value'	=> 'logo',
			'options' => array(
				'menu' => __('Show in the menu', 'mageewp-page-layout'),
				'logo' => __('Show near logo', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
	),
	"Login" => array(
		array(
			'name' => 'login_caption',
			'type' => 'text',
			'label' => __( 'Login Caption', 'mageewp-page-layout' ),
			'description' => '',
			'value' => 'Login',
		),
		array(
			'name' => 'logout_caption',
			'type' => 'text',
			'label' => __( 'Logout Caption', 'mageewp-page-layout' ),
			'description' => '',
			'value' => 'Logout',
		),
		array(
			'name' => 'show_icon',
			'type' => 'toggle',
			'label' => __( 'Show graphic icon', 'mageewp-page-layout' ),
			'description' => '',
			'value' => 'yes',
			'options' => array(
				'yes'	=> __('YES', 'mageewp-page-layout'),
				'no'	=> __('NO', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'on_desktops',
			'type' => 'radio',
			'label' => __( 'On desktops', 'mageewp-page-layout' ),
			'description' => '',
			'value' => 'show',
			'options' => array(
				'show' => __('Show', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'tablet',
			'type' => 'radio',
			'label' => __( 'First header switch point (tablet)', 'mageewp-page-layout' ),
			'description' => '',
			'value' => 'leave',
			'options' => array(
				'leave' => __('Leave as is', 'mageewp-page-layout'),
				'show' => __('Show in the menu', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'phone',
			'type' => 'radio',
			'label' => __( 'Second header switch point (phone)', 'mageewp-page-layout' ),
			'description' => '',
			'value' => 'logo',
			'options' => array(
				'menu' => __('Show in the menu', 'mageewp-page-layout'),
				'logo' => __('Show near logo', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'link',
			'type' => 'text',
			'label' => __( 'Link', 'mageewp-page-layout' ),
			'description' => '',
			'value' => 'https://www.mageewp.com/',
		),			
	),
	"Cart" => array(
		array(
			'name' => 'title',
			'type' => 'text',
			'label' => __( 'Title', 'mageewp-page-layout' ),
			'description' => '',
		),
		array(
			'name' => 'caption_align',
			'type' => 'select',
			'label' => __('Content Align', 'mageewp-page-layout'),
			'description' => '',
			'options' => array(
				'left' => __('Left','mageewp-page-layout'),
				'center' => __('Center','mageewp-page-layout'), 
				'right' => __('Right','mageewp-page-layout')
			)
		),
	),
	"Social" => array(
		array(
			'name' => 'on_desktops',
			'type' => 'radio',
			'label' => __( 'On desktops', 'mageewp-page-layout' ),
			'description' => '',
			'options' => array(
				'show' => __('Show', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'tablet',
			'type' => 'radio',
			'label' => __( 'First header switch point (tablet)', 'mageewp-page-layout' ),
			'description' => '',
			'options' => array(
				'leave' => __('Leave as is', 'mageewp-page-layout'),
				'show' => __('Show in the menu', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'phone',
			'type' => 'radio',
			'label' => __( 'Second header switch point (phone)', 'mageewp-page-layout' ),
			'description' => '',
			'options' => array(
				'menu' => __('Show in the menu', 'mageewp-page-layout'),
				'logo' => __('Show near logo', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
	),
	"Menu" => array(
		array(
			'name' => 'on_desktops',
			'type' => 'radio',
			'label' => __( 'On desktops', 'mageewp-page-layout' ),
			'description' => '',
			'options' => array(
				'show' => __('Show', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'tablet',
			'type' => 'radio',
			'label' => __( 'First header switch point (tablet)', 'mageewp-page-layout' ),
			'description' => '',
			'options' => array(
				'leave' => __('Leave as is', 'mageewp-page-layout'),
				'show' => __('Show in the menu', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'phone',
			'type' => 'radio',
			'label' => __( 'Second header switch point (phone)', 'mageewp-page-layout' ),
			'description' => '',
			'options' => array(
				'menu' => __('Show in the menu', 'mageewp-page-layout'),
				'logo' => __('Show near logo', 'mageewp-page-layout'),
				'hide' => __('Hide', 'mageewp-page-layout'),
			),
		),
		array(
			'name' => 'style',
			'type' => 'radio',
			'label' => __( 'Menu style', 'mageewp-page-layout' ),
			'description' => '',
			'options' => array(
				'dropdown' => __('Dropdown', 'mageewp-page-layout'),
				'list' => __('List', 'mageewp-page-layout')
			),
		),			
	),
);

$mpl->add_map(
	array(
		'mpl_header' => array(
			'system_only' => true,
			'name' => __('top_bar_header', 'mageewp-page-layout'),
			'title' => __('Top Bar & Header Settings', 'mageewp-page-layout'),
			'icon' => 'mpl-icon-promo',
			'description' => '',
			'pop_width' => 800,
			'pop_height' => 400,
			'category' => '',
			'params' => array(
				'Layout' => array(
					array(
						'name'			=> 'header_layout',
						'type'			=> 'radio_image',
						'label'			=> __('Header Layout', 'mageewp-page-layout'),
						'value' 		=> 'classic',
						'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
						'options'		=> array(
							'classic' => MPL_URL. '/assets/images/header/header_classic.png',
							'inline' => MPL_URL. '/assets/images/header/header_inline.png',
							'split' => MPL_URL. '/assets/images/header/header_split.png',
							'side' => MPL_URL. '/assets/images/header/header_side.png',
							'inline_three' => MPL_URL. '/assets/images/header/header_inline_three_line.png',
							//'side_three' => MPL_URL. '/assets/images/header/header_side_three_line.png',
						),
					),
					array(
						'name'			=> 'classic',
						'type'			=> 'panel',
						'relation' => array(
							'parent' => 'header_layout',
							'show_when' => 'classic',
						),
						'params' => array(
							array(
								'name' => 'microwidgets',
								'label' => __( 'Microwidgets', 'mageewp-page-layout' ),
								'description' => __( 'Background video will be applied to the column.', 'mageewp-page-layout' ),
								'type' => 'toggle',
								'value' => 'no',
							),
							array(
								'name'			=> 'top_bar_left',
								'type'			=> 'microwidgets',
								'label'			=> __('Top bar left', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'classic-microwidgets',
									'show_when' => 'yes',
								),
								'value' => base64_encode( json_encode(array(
									"Menu" => array(
										'on_desktops' => 'show',
										'tablet' => 'leave',
										'phone' => 'show',
										'style' => 'list',
									),
									"Cart" => array(
										'title' => '',
										'caption_align' => 'left',
									),
								) ) ),
								'params' => $microwidgets_params,
							),
							array(
								'type'			=> 'microwidgets',
								'label'			=> __('Top bar right', 'mageewp-page-layout'),
								'name'			=> 'top_bar_right',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'classic-microwidgets',
									'show_when' => 'yes',
								),
								'value' => base64_encode( json_encode(array(
									"Search" => array(
										'caption' => '__empty__',
										'show_icon' => 'yes',
										'on_desktops' => 'show',
										'tablet' => 'leave',
										'phone' => 'show',
									),
								) ) ),
								'params' => $microwidgets_params,
							),
							array(
								'type'			=> 'microwidgets',
								'label'			=> __('Near menu', 'mageewp-page-layout'),
								'name'			=> 'near_menu',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'classic-microwidgets',
									'show_when' => 'yes',
								),
								'value' => base64_encode( json_encode(array(
										"Social" => array(
											'on_desktops' => 'show',
											'tablet' => 'leave',
											'phone' => 'show',
										),
								) ) ),
								'params' => $microwidgets_params,
							),
							array(
								'type'			=> 'microwidgets',
								'label'			=> __('Near logo (left)', 'mageewp-page-layout'),
								'name'			=> 'near_logo_left',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'classic-microwidgets',
									'show_when' => 'yes',
								),
								'value' => '',
								'params' => $microwidgets_params,
							),
							array(
								'type'			=> 'microwidgets',
								'label'			=> __('Near logo (right)', 'mageewp-page-layout'),
								'name'			=> 'near_logo_right',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'classic-microwidgets',
									'show_when' => 'yes',
								),
								'value' => base64_encode( json_encode(array(
										"Text" => array(
											'content' => '__empty__',
											'show_icon' => 'yes',
											'on_desktops' => 'show',
											'tablet' => 'leave',
											'phone' => 'show',
										),
								) ) ),
								'params' => $microwidgets_params,
							),
							array(
								'type'			=> 'corners',
								'label'			=> __('Area near menu', 'mageewp-page-layout'),
								'name'			=> 'area_near_menu',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'relation' => array(
									'parent' => 'classic-microwidgets',
									'show_when' => 'yes',
								),
								'options'		=>	array(
									'top'		=>	'0px',
									'bottom'	=>	'0px',
									'left'		=>	'0px',
									'right'		=>	'0px',
								),
							),
							array(
								'type'			=> 'corners',
								'label'			=> __('Area near logo (left)', 'mageewp-page-layout'),
								'name'			=> 'area_near_logo_left',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'value' 		=> '0px 0px 0px 0px',
								'relation' => array(
									'parent' => 'classic-microwidgets',
									'show_when' => 'yes',
								),
								'options'		=>	array(
									'top'		=>	'0px',
									'bottom'	=>	'0px',
									'left'		=>	'0px',
									'right'		=>	'0px',
								),
							),
							array(
								'type'			=> 'corners',
								'label'			=> __('Area near logo (right)', 'mageewp-page-layout'),
								'name'			=> 'area_near_logo_right',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'value' 		=> '0px 0px 0px 0px',
								'relation' => array(
									'parent' => 'classic-microwidgets',
									'show_when' => 'yes',
								),
								'options'		=>	array(
									'top'		=>	'0px',
									'bottom'	=>	'0px',
									'left'		=>	'0px',
									'right'		=>	'0px',
								),
							),																
							array(
								'name' => 'logo_position',
								'label' => __('Logo position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'left',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/classic_logo position_left.png',
									'center' => MPL_URL.'/assets/images/header/classic_logo position_center.png',
								),
							),
							array(
								'name' => 'menu_position',
								'label' => __('Menu position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'left',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/classic_menu_ position_left.png',
									'center' => MPL_URL.'/assets/images/header/classic_menu_position_center.png',
									'justify' => MPL_URL.'/assets/images/header/classic_menu_position_justified.png',
								),
							),
							array(
								'name' => 'margin_above_menu',
								'label' => __( 'Margin above menu (px)', 'mageewp-page-layout' ),
								'type' => 'text',
								'value' => 0,
								'description' => __( 'Add additional classes name to the container in a column.', 'mageewp-page-layout' ),
							),
							array(
								'name' => 'margin_below_menu',
								'label' => __( 'Margin below menu (px)', 'mageewp-page-layout' ),
								'type' => 'text',
								'value' => 0,
								'description' => __( 'Add additional classes name to the container in a column.', 'mageewp-page-layout' ),
							),
							array(
								'name' => 'header_height',
								'label' => __( 'Header height (px)', 'mageewp-page-layout' ),
								'type' => 'text',
								'description' => __( 'Add additional classes name to the container in a column.', 'mageewp-page-layout' ),
							),
							array(
								'name' => 'full_width_header',
								'label' => __('Full-width header', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'disaled',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'enabled' => MPL_URL.'/assets/images/header/classic_full_width_enabled.png',
									'disaled' => MPL_URL.'/assets/images/header/classic_full_width_disabled.png',
								),
							),
						),
					),
					array(
						'name'			=> 'inline',
						'type'			=> 'panel',
						'relation' => array(
							'parent' => 'header_layout',
							'show_when' => 'inline',
						),						
						'params'		=> array(
							array(
								'name' => 'microwidgets',
								'type' => 'toggle',
								'label' => __( 'Microwidgets', 'mageewp-page-layout' ),
								'description' => __( 'Background video will be applied to the column.', 'mageewp-page-layout' ),
								'value' => 'no',
							),
							array(
								'name'			=> 'top_bar_left',
								'type'			=> 'microwidgets',
								'label'			=> __('Top bar left', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'inline-microwidgets',
									'show_when' => 'yes',
								),
								'value' => base64_encode( json_encode(array(
									"Text" => array(
										'content' => 'This is test',
										'show_icon' => 'yes',
										'on_desktops' => 'show',
										'tablet' => 'leave',
										'phone' => 'show',
									),
								) ) ),
								'params' => $microwidgets_params,
							),
							array(
								'name'			=> 'top_bar_right',
								'type'			=> 'microwidgets',
								'label'			=> __('Top bar right', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'inline-microwidgets',
									'show_when' => 'yes',
								),
								'value' => base64_encode( json_encode(array(
									"Social" => array(
										'on_desktops' => 'show',
										'tablet' => 'leave',
										'phone' => 'show',
									),
								) ) ),
								'params' => $microwidgets_params,
							),
							array(
								'name'			=> 'near_menu',
								'type'			=> 'microwidgets',
								'label'			=> __('Near menu', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'inline-microwidgets',
									'show_when' => 'yes',
								),
								'value' => base64_encode( json_encode(array(
										"Cart" => array(
											'title' => '',
											'caption_align' => 'left',
										),
										"Search" => array(
											'caption' => '',
											'show_icon' => 'yes',
											'on_desktops' => 'show',
											'tablet' => 'leave',
											'phone' => 'show',
										),
								) ) ),
								
								'params' => $microwidgets_params,
							),
							array(
								'type'			=> 'corners',
								'label'			=> __('Area near menu', 'mageewp-page-layout'),
								'name'			=> 'area_near_menu',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'relation' => array(
									'parent' => 'inline-microwidgets',
									'show_when' => 'yes',
								),
								'options'		=>	array(
									'top'		=>	'0px',
									'bottom'	=>	'0px',
									'left'		=>	'27px',
									'right'		=>	'0px',
								),
							),
							array(
								'name' => 'menu_position',
								'label' => __('Menu position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'right',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/inline_menu position_left.png',
									'right' => MPL_URL.'/assets/images/header/inline_menu_position_right.png',
									'center' => MPL_URL.'/assets/images/header/inline_menu_position_center.png',
									'justify' => MPL_URL.'/assets/images/header/inline_menu_position_justified.png',
								),
							),
							array(
								'name' => 'header_height',
								'label' => __( 'Header height (px)', 'mageewp-page-layout' ),
								'type' => 'text',
								'description' => __( 'Add additional classes name to the container in a column.', 'mageewp-page-layout' ),
								'value' => '100',
								'relation' => array(
									'parent' => 'Layout',
									'show_when' => 'Classic,Inline,Split',
								),
							),
							array(
								'name' => 'full_width_header',
								'label' => __('Full-width header', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'disaled',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'enabled' => MPL_URL.'/assets/images/header/inline_full_width_enabled.png',
									'disaled' => MPL_URL.'/assets/images/header/inline_full_width_disabled.png',
								),
							),
						)
					),
					array(
						'name'			=> 'split',
						'type'			=> 'panel',
						'relation' => array(
							'parent' => 'header_layout',
							'show_when' => 'split',
						),							
						'params'		=>array(
							array(
								'name' => 'microwidgets',
								'type' => 'toggle',
								'label' => __( 'Microwidgets', 'mageewp-page-layout' ),
								'description' => __( 'Background video will be applied to the column.', 'mageewp-page-layout' ),
								'value' => 'no',
							),
							array(
								'name'			=> 'top_bar_left',
								'type'			=> 'microwidgets',
								'label'			=> __('Top bar left', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'split-microwidgets',
									'show_when' => 'yes',
								),
								'value' => '',
								'params' => $microwidgets_params,
							),
							array(
								'name'			=> 'top_bar_right',
								'type'			=> 'microwidgets',
								'label'			=> __('Top bar right', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'split-microwidgets',
									'show_when' => 'yes',
								),
								'value' => '',
								'params' => $microwidgets_params,
							),
							array(
								'name'			=> 'near_menu_left',
								'type'			=> 'microwidgets',
								'label'			=> __('Near menu (left)', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'split-microwidgets',
									'show_when' => 'yes',
								),
								'value' => base64_encode( json_encode(array(
										"Search" => array(
											'caption' => '',
											'show_icon' => 'yes',
											'on_desktops' => 'show',
											'tablet' => 'leave',
											'phone' => 'show',
										),
								) ) ),
								'params' => $microwidgets_params,
							),
							array(
								'name'			=> 'near_menu_right',
								'type'			=> 'microwidgets',
								'label'			=> __('Near menu (right)', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'split-microwidgets',
									'show_when' => 'yes',
								),
								'value' => base64_encode( json_encode(array(
									"Cart" => array(
										'title' => '',
										'caption_align' => 'left',
									),
								) ) ),
								'params' => $microwidgets_params,
							),
							array(
								'type'			=> 'corners',
								'label'			=> __('Area near menu(left)', 'mageewp-page-layout'),
								'name'			=> 'area_near_menu_left',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'relation' => array(
									'parent' => 'split-microwidgets',
									'show_when' => 'yes',
								),
								'options'		=>	array(
									'top'		=>	'0px',
									'bottom'	=>	'0px',
									'left'		=>	'20px',
									'right'		=>	'20px',
								),
							),
							array(
								'type'			=> 'corners',
								'label'			=> __('Area near menu(right)', 'mageewp-page-layout'),
								'name'			=> 'area_near_menu_right',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'relation' => array(
									'parent' => 'split-microwidgets',
									'show_when' => 'yes',
								),
								'options'		=>	array(
									'top'		=>	'0px',
									'bottom'	=>	'0px',
									'left'		=>	'20px',
									'right'		=>	'20px',
								),
							),
							array(
								'name' => 'menu_position',
								'label' => __('Menu position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'justify',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'justify' => MPL_URL.'/assets/images/header/split_menu_position_justified.png',
									'inside' => MPL_URL.'/assets/images/header/split_menu_position_menu_inside_widgets_outside.png',
									'allinside' => MPL_URL.'/assets/images/header/split_menu_position_menu_inside_widget_inside.png',
									'outside' => MPL_URL.'/assets/images/header/split_menu_position_menu_outside_widgets_outside.png',
								),
							),
							array(
								'name' => 'header_height',
								'type' => 'text',
								'label' => __( 'Header height (px)', 'mageewp-page-layout' ),
								'value' => '100',
								'description' => __( 'Add additional classes name to the container in a column.', 'mageewp-page-layout' ),
							),
							array(
								'name' => 'full_width_header',
								'label' => __('Full-width header', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'disabled',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'enabled' => MPL_URL.'/assets/images/header/split_full_width_enabled.png',
									'disabled' => MPL_URL.'/assets/images/header/split_full_width_disabled.png',
								),
							),
						)
					),
					array(
						'name'			=> 'side',
						'type'			=> 'panel',
						'relation' => array(
							'parent' => 'header_layout',
							'show_when' => 'side',
						),							
						'params'		=>array(
							array(
								'name' => 'microwidgets',
								'type' => 'toggle',
								'label' => __( 'Microwidgets', 'mageewp-page-layout' ),
								'description' => __( 'Background video will be applied to the column.', 'mageewp-page-layout' ),
								'value' => 'no',
							),
							array(
								'name'			=> 'below_menu',
								'type'			=> 'microwidgets',
								'label'			=> __('Below menu', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'side-microwidgets',
									'show_when' => 'yes',
								),
								'value' => base64_encode( json_encode(array(
										"Social" => array(
											'on_desktops' => 'show',
											'tablet' => 'leave',
											'phone' => 'show',
										),
										"Text" => array(
											'content' => '',
											'show_icon' => 'yes',
											'on_desktops' => 'show',
											'tablet' => 'leave',
											'phone' => 'show',
										),
								) ) ),
								
								'params' => $microwidgets_params,
							),
							array(
								'type'			=> 'corners',
								'label'			=> __('Area below menu', 'mageewp-page-layout'),
								'name'			=> 'area_below_menu',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'relation' => array(
									'parent' => 'side-microwidgets',
									'show_when' => 'yes',
								),
								'options'		=>	array(
									'top'		=>	'0px',
									'bottom'	=>	'0px',
									'left'		=>	'35px',
									'right'		=>	'35px',
								),
							),
							array(
								'name' => 'header_position',
								'label' => __('Header position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'right',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/side_header_position_left.png',
									'right' => MPL_URL.'/assets/images/header/side_header_position_right.png',
								),
							),
							array(
								'name' => 'header_width',
								'label' => __( 'Header width (px or %)', 'mageewp-page-layout' ),
								'type' => 'text',
								'value' => '300px',
								'description' => __( 'Add additional classes name to the container in a column.', 'mageewp-page-layout' ),
							),
							array(
								'name' => 'width_of_header_content',
								'label' => __( 'Width of header content (px or %)', 'mageewp-page-layout' ),
								'type' => 'text',
								'value' => '300px',
								'description' => __( 'Add additional classes name to the container in a column.', 'mageewp-page-layout' ),
							),
							array(
								'name' => 'position_of_header_content',
								'label' => __('Position of header content', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'center',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/side_position_of_header_content_left.png',
									'center' => MPL_URL.'/assets/images/header/side_position_of_header_content_center.png',
									'right' => MPL_URL.'/assets/images/header/side_position_of_header_content_right.png',
								),
							),
							array(
								'name'			=> 'header_content_paddings',
								'type'			=> 'corners',
								'label'			=> __('Header content paddings', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=>	array(
									'top'		=>	'50px',
									'bottom'	=>	'40px',
									'left'		=>	'0px',
									'right'		=>	'0px',
								),
							),
							array(
								'name' => 'menu_position',
								'label' => __('Menu position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'top',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'top' => MPL_URL.'/assets/images/header/side_menu_position_top.png',
									'center' => MPL_URL.'/assets/images/header/side_menu_position_center.png',
									'bottom' => MPL_URL.'/assets/images/header/side_menu_position_bottom.png',
								),
							),
							array(
								'name' => 'logo_info_position',
								'label' => __('Logo and additional info position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'edges_of_entire_content',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'edges_of_menu' => MPL_URL.'/assets/images/header/side_logo_info_position_of_menu.png',
									'edges_of_entire_content' => MPL_URL.'/assets/images/header/side_logo_info_position_of_content.png',
								),
							),
							array(
								'type'			=> 'text',
								'label'			=> __('Menu paddings top', 'mageewp-page-layout'),
								'name'			=> 'menu_paddings_top',
								'value'			=>	'50px',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
							),
							array(
								'type'			=> 'text',
								'label'			=> __('Menu paddings bottom', 'mageewp-page-layout'),
								'name'			=> 'menu_paddings_bottom',
								'value'			=>	'50px',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
							),
							array(
								'name' => 'menu_items_alignment',
								'label' => __('Menu items alignment', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'center',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/side_menu_items_left.png',
									'center' => MPL_URL.'/assets/images/header/side_menu_items_center.png',
								),
							),
							array(
								'name' => 'menu_itmes_link_area',
								'label' => __('Menu items link area', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'full_width',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'full_width' => MPL_URL.'/assets/images/header/side_menu_links_area_full_width.png',
									'text_width' => MPL_URL.'/assets/images/header/side_menu_links_area_text_width.png',
								),
							),
						)
					),
					array(
						'name'			=> 'inline_three',
						'type'			=> 'panel',
						'relation' => array(
							'parent' => 'header_layout',
							'show_when' => 'inline_three',
						),							
						'params'		=>array(
							array(
								'name' => 'microwidgets',
								'type' => 'toggle',
								'label' => __( 'Microwidgets', 'mageewp-page-layout' ),
								'description' => __( 'Background video will be applied to the column.', 'mageewp-page-layout' ),
								'type' => 'toggle',
								'value' => 'no',
							),
							array(
								'name'			=> 'top_line',
								'type'			=> 'microwidgets',
								'label'			=> __('Top line', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'inline_three-microwidgets',
									'show_when' => 'yes',
								),
								'value' => base64_encode( json_encode(array(
										"Text" => array(
											'content' => '',
											'show_icon' => 'yes',
											'on_desktops' => 'show',
											'tablet' => 'leave',
											'phone' => 'show',
										),
								) ) ),
								'params' => $microwidgets_params,
							),	
							array(
								'name'			=> 'below_menu',
								'type'			=> 'microwidgets',
								'label'			=> __('Below menu', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'inline_three-microwidgets',
									'show_when' => 'yes',
								),
								'value' => '',
								'params' => $microwidgets_params,
							),
							array(
								'name'			=> 'area_in_top_line',
								'type'			=> 'corners',
								'label'			=> __('Area in top line', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'relation' => array(
									'parent' => 'inline_three-microwidgets',
									'show_when' => 'yes',
								),
								'options'		=>	array(
									'top'		=>	'0px',
									'bottom'	=>	'0px',
									'left'		=>	'40px',
									'right'		=>	'40px',
								),
							),
							array(
								'name'			=> 'area_below_menu',
								'type'			=> 'corners',
								'label'			=> __('Area below menu', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'relation' => array(
									'parent' => 'inline_three-microwidgets',
									'show_when' => 'yes',
								),
								'options'		=>	array(
									'top'		=>	'0px',
									'bottom'	=>	'0px',
									'left'		=>	'0px',
									'right'		=>	'0px',
								),
							),
							array(
								'name' => 'logo_position',
								'label' => __('Logo position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'left',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/side_three_logo_position_left.png',
									'center' => MPL_URL.'/assets/images/header/side_three_logo_position_center.png',
								),
							),
							array(
								'name' => 'height',
								'label' => __('Height (px)', 'mageewp-page-layout'),
								'type' => 'text',
								'value'	=> '90',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
							),
							array(
								'name' => 'full_width_header',
								'label' => __('Full-Width Header', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'enabled',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'enabled' => MPL_URL.'/assets/images/header/side_three_full width_enabled.png',
									'disabled' => MPL_URL.'/assets/images/header/side_three_full width_disabled.png',
								),
							),								
							array(
								'name' => 'sliding_menu_position',
								'label' => __('Sliding Menu Position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'left',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/sliding_menu_left.png',
									'right' => MPL_URL.'/assets/images/header/sliding_menu_right.png',
									'full' => MPL_URL.'/assets/images/header/sliding_menu_full.png',
								),
							),
							/*array(
								'name' => 'animation',
								'label' => __('Animation', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'fade',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'fade' => MPL_URL.'/assets/images/header/sliding_menu_animation_fade.png',
									'slide' => MPL_URL.'/assets/images/header/sliding_menu_animation_slide.png',
									'move' => MPL_URL.'/assets/images/header/sliding_menu_animation_move.png',
								),
								'relation' => array(
									'parent' => 'inline_three-sliding_menu_position',
									'show_when' => 'left,right',
								),
							),*/
							array(
								'name' => 'floating_logo',
								'label' => __('Floating logo', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'enabled',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'enabled' => MPL_URL.'/assets/images/header/floating_logo_enabled.png',
									'disabled' => MPL_URL.'/assets/images/header/floating_logo_disabled.png',
								),
								'relation' => array(
									'parent' => 'side_navigation-navigation_layout',
									'show_when' => 'menu_icon_only',
								),
							),
							array(
								'name' => 'header_width',
								'label' => __( 'Header width (px or %)', 'mageewp-page-layout' ),
								'type' => 'text',
								'value' => '300px',
								'description' => __( 'Add additional classes name to the container in a column.', 'mageewp-page-layout' ),
								'relation' => array(
									'parent' => 'inline_three-sliding_menu_position',
									'show_when' => 'left,right',
								),
							),
							array(
								'name' => 'width_of_header_content',
								'label' => __( 'Width of header content (px or %)', 'mageewp-page-layout' ),
								'type' => 'text',
								'value' => '300px',
								'description' => __( 'Add additional classes name to the container in a column.', 'mageewp-page-layout' ),
							),
							array(
								'name' => 'position_of_header_content',
								'label' => __('Position of header content', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'center',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/side_position_of_header_content_left.png',
									'center' => MPL_URL.'/assets/images/header/side_position_of_header_content_center.png',
									'right' => MPL_URL.'/assets/images/header/side_position_of_header_content_right.png',
								),
							),
							array(
								'name'			=> 'header_content_paddings',
								'type'			=> 'corners',
								'label'			=> __('Header content paddings', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=>	array(
									'top'		=>	'50px',
									'bottom'	=>	'40px',
									'left'		=>	'0px',
									'right'		=>	'0px',
								),
							),
							array(
								'name' => 'menu_position',
								'label' => __('Menu position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'top',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'top' => MPL_URL.'/assets/images/header/side_menu_position_top.png',
									'center' => MPL_URL.'/assets/images/header/side_menu_position_center.png',
									'bottom' => MPL_URL.'/assets/images/header/side_menu_position_bottom.png',
								),
							),
							array(
								'name' => 'logo_info_position',
								'label' => __('Logo and additional info position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'edges_of_entire_content',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'edges_of_menu' => MPL_URL.'/assets/images/header/side_logo_info_position_of_menu.png',
									'edges_of_entire_content' => MPL_URL.'/assets/images/header/side_logo_info_position_of_content.png',
								),
							),
							array(
								'type'			=> 'text',
								'label'			=> __('Menu paddings top', 'mageewp-page-layout'),
								'name'			=> 'menu_paddings_top',
								'value'			=>	'50px',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
							),
							array(
								'type'			=> 'text',
								'label'			=> __('Menu paddings bottom', 'mageewp-page-layout'),
								'name'			=> 'menu_paddings_bottom',
								'value'			=>	'50px',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
							),
							array(
								'name' => 'menu_items_alignment',
								'label' => __('Menu items alignment', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'center',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/side_menu_items_left.png',
									'center' => MPL_URL.'/assets/images/header/side_menu_items_center.png',
								),
							),
							array(
								'name' => 'menu_itmes_link_area',
								'label' => __('Menu items link area', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'full_width',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'full_width' => MPL_URL.'/assets/images/header/side_menu_links_area_full_width.png',
									'text_width' => MPL_URL.'/assets/images/header/side_menu_links_area_text_width.png',
								),
							),
						)
					),
					/*array(
						'name'			=> 'side_three',
						'type'			=> 'panel',
						'relation' => array(
							'parent' => 'header_layout',
							'show_when' => 'side_three',
						),							
						'params'		=>array(
							array(
								'name' => 'microwidgets',
								'type' => 'toggle',
								'label' => __( 'Microwidgets', 'mageewp-page-layout' ),
								'description' => __( 'Background video will be applied to the column.', 'mageewp-page-layout' ),
								'value' => 'no',
							),
							array(
								'type'			=> 'microwidgets',
								'label'			=> __('Top line', 'mageewp-page-layout'),
								'name'			=> 'top_line',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'side_three-microwidgets',
									'show_when' => 'yes',
								),
								'value' => base64_encode( json_encode(array(
										"Social" => array(
											'on_desktops' => 'show',
											'tablet' => 'leave',
											'phone' => 'show',
										),
								) ) ),
								
								'params' => $microwidgets_params,
							),            
							array(
								'type'			=> 'microwidgets',
								'label'			=> __('Below menu', 'mageewp-page-layout'),
								'name'			=> 'below_menu',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=> array('add_text' => __('Add MicroWidgets', 'mageewp-page-layout')),
								'relation' => array(
									'parent' => 'side_three-microwidgets',
									'show_when' => 'yes',
								),
								'value' => base64_encode( json_encode(array(
										"Search" => array(
											'caption' => '',
											'show_icon' => 'yes',
											'on_desktops' => 'show',
											'tablet' => 'leave',
											'phone' => 'show',
										),
										"Cart" => array(
											'title' => '',
											'caption_align' => 'left',
										),
								) ) ),
								
								'params' => $microwidgets_params,
							),
							array(
								'name'			=> 'area_in_top_line',
								'type'			=> 'corners',
								'label'			=> __('Area in top line', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'relation' => array(
									'parent' => 'side_three-microwidgets',
									'show_when' => 'yes',
								),
								'options'		=>	array(
									'top'		=>	'0px',
									'bottom'	=>	'0px',
									'left'		=>	'40px',
									'right'		=>	'40px',
								),
							),
							array(
								'name'			=> 'area_below_menu',
								'type'			=> 'corners',
								'label'			=> __('Area below menu', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'relation' => array(
									'parent' => 'side_three-microwidgets',
									'show_when' => 'yes',
								),
								'options'		=>	array(
									'top'		=>	'0px',
									'bottom'	=>	'0px',
									'left'		=>	'0px',
									'right'		=>	'0px',
								),
							),
							array(
								'name' => 'header_position',
								'label' => __('Header position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'right',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/side_header_position_left.png',
									'right' => MPL_URL.'/assets/images/header/side_header_position_right.png',
								),
							),
							array(
								'name' => 'width',
								'label' => __('Width (px)', 'mageewp-page-layout'),
								'type' => 'text',
								'value' => '60px',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
							),								
							array(
								'name' => 'sliding_menu_position',
								'label' => __('Sliding Menu Position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'left',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/sliding_menu_left.png',
									'right' => MPL_URL.'/assets/images/header/sliding_menu_right.png',
									'full' => MPL_URL.'/assets/images/header/sliding_menu_full.png',
								),
							),
							array(
								'name' => 'animation',
								'label' => __('Animation', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'fade',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'fade' => MPL_URL.'/assets/images/header/sliding_menu_animation_fade.png',
									'slide' => MPL_URL.'/assets/images/header/sliding_menu_animation_slide.png',
									'move' => MPL_URL.'/assets/images/header/sliding_menu_animation_move.png',
								),
								'relation' => array(
									'parent' => 'side_three-sliding_menu_position',
									'show_when' => 'left,right',
								),
							),
							array(
								'name' => 'show_header',
								'label' => __('Show header', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'above',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'above' => MPL_URL.'/assets/images/header/show_header_above_the_line.png',
									'under' => MPL_URL.'/assets/images/header/show_header_under_the_line.png',
								),
								'relation' => array(
									'parent' => 'side_three-sliding_menu_position',
									'show_when' => 'left,right',
								),
							),								
							array(
								'name' => 'header_width',
								'label' => __( 'Header width (px or %)', 'mageewp-page-layout' ),
								'type' => 'text',
								'value' => '300px',
								'description' => __( 'Add additional classes name to the container in a column.', 'mageewp-page-layout' ),
								'relation' => array(
									'parent' => 'side_three-sliding_menu_position',
									'show_when' => 'left,right',
								),
							),
							array(
								'name' => 'width_of_header_content',
								'label' => __( 'Width of header content (px or %)', 'mageewp-page-layout' ),
								'type' => 'text',
								'value' => '300px',
								'description' => __( 'Add additional classes name to the container in a column.', 'mageewp-page-layout' ),
							),
							array(
								'name' => 'position_of_header_content',
								'label' => __('Position of header content', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'center',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/side_position_of_header_content_left.png',
									'center' => MPL_URL.'/assets/images/header/side_position_of_header_content_center.png',
									'right' => MPL_URL.'/assets/images/header/side_position_of_header_content_right.png',
								),
							),
							array(
								'name'			=> 'header_content_paddings',
								'type'			=> 'corners',
								'label'			=> __('Header content paddings', 'mageewp-page-layout'),
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
								'options'		=>	array(
									'top'		=>	'50px',
									'bottom'	=>	'40px',
									'left'		=>	'0px',
									'right'		=>	'0px',
								),
							),
							array(
								'name' => 'menu_position',
								'label' => __('Menu position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'top',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'top' => MPL_URL.'/assets/images/header/side_menu_position_top.png',
									'center' => MPL_URL.'/assets/images/header/side_menu_position_center.png',
									'bottom' => MPL_URL.'/assets/images/header/side_menu_position_bottom.png',
								),
							),
							array(
								'name' => 'logo_info_position',
								'label' => __('Logo and additional info position', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'edges_of_entire_content',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'edges_of_menu' => MPL_URL.'/assets/images/header/side_logo_info_position_of_menu.png',
									'edges_of_entire_content' => MPL_URL.'/assets/images/header/side_logo_info_position_of_content.png',
								),
							),
							array(
								'type'			=> 'text',
								'label'			=> __('Menu paddings top', 'mageewp-page-layout'),
								'name'			=> 'menu_paddings_top',
								'value'			=>	'50px',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
							),
							array(
								'type'			=> 'text',
								'label'			=> __('Menu paddings bottom', 'mageewp-page-layout'),
								'name'			=> 'menu_paddings_bottom',
								'value'			=>	'50px',
								'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
							),
							array(
								'name' => 'menu_items_alignment',
								'label' => __('Menu items alignment', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'center',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'left' => MPL_URL.'/assets/images/header/side_menu_items_left.png',
									'center' => MPL_URL.'/assets/images/header/side_menu_items_center.png',
								),
							),
							array(
								'name' => 'menu_itmes_link_area',
								'label' => __('Menu items link area', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'full_width',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'full_width' => MPL_URL.'/assets/images/header/side_menu_links_area_full_width.png',
									'text_width' => MPL_URL.'/assets/images/header/side_menu_links_area_text_width.png',
								),
							),
						)
					),		*/																		
				),
				'Top bar' => array(
					array(
						'name' => 'top_bar_font_size',
						'label' => __('Top bar font size', 'mageewp-page-layout'),
						'type' => 'number_slider',
						'value' => '32',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
					),
					array(
						'name' => 'capitalize',
						'label' => __('Capitalize', 'mageewp-page-layout'),
						'type' => 'toggle',
						'value' => '',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
					),
					array(
						'name' => 'top_bar_font_color',
						'label' => __('Top bar font color', 'mageewp-page-layout'),
						'type' => 'color_picker',
						'value' => '',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
					),
					array(
						'name' => 'top_padding',
						'label' => __('Top padding (px)', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => '8',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
					),
					array(
						'name' => 'bottom_padding',
						'label' => __('Bottom padding (px)', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => '8',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
					),
					array(
						'name' => 'side_paddings',
						'label' => __('Side paddings (px)', 'mageewp-page-layout'),
						'type' => 'text',
						'value' => '',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
					),
					array(
						'name' => 'background_or_line',
						'label' => __('Top bar background / line', 'mageewp-page-layout'),
						'type' => 'radio_image',
						'value' => 'content_width_line',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
						'options' => array(
							'disabled' => MPL_URL.'/assets/images/header/top_bar_line_disabled.png',
							'bottom_line' => MPL_URL.'/assets/images/header/top_bar_content_width_line.png',
							'bottom_line_full' => MPL_URL.'/assets/images/header/top_bar_line_full_width_line.png',
							'solid_bg' => MPL_URL.'/assets/images/header/top_bar_background.png',
						)
					),
					array(
						'name' => 'background_line_color',
						'label' => __('Background (line) color', 'mageewp-page-layout'),
						'type' => 'color_picker',
						'value' => '',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
						'relation' => array(
							'parent' => 'background_or_line',
							'show_when' => 'content_width_line,full_width_line,background',
						),						
					),
					array(
						'name' => 'background_line_opacity',
						'label' => __('Background (line) opacity', 'mageewp-page-layout'),
						'type' => 'number_slider',
						'value' => '32',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
						'relation' => array(
							'parent' => 'background_or_line',
							'show_when' => 'content_width_line,full_width_line,background',
						),						
					),			
					array(
						'name' => 'background_image',
						'label' => __('Add background image', 'mageewp-page-layout'),
						'type' => 'attach_image_url',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
						'relation' => array(
							'parent' => 'background_or_line',
							'show_when' => 'background',
						),						
					),																																													
				),
				'Header' => array(
					array(
						'name'			=> 'header_settings',
						'type'			=> 'mytabs',
						'label'			=> __('Header Settings', 'mageewp-page-layout'),
						'options' => array(
							'background'	=> __('Header background', 'mageewp-page-layout'),
							'menu'	=> __('Menu icon (hamburger)', 'mageewp-page-layout'),
							'classic'	=> __('Classic header', 'mageewp-page-layout'),
							'sliding'	=> __('Sliding Menu Background', 'mageewp-page-layout'),
						),
						'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
						'params' => array(
							"background" => array(
								array(
									'name' => 'background_color',
									'label' => __('Background color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'background_opacity',
									'label' => __('Background opacity', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '42',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'background_image',
									'label' => __('Add background image', 'mageewp-page-layout'),
									'type' => 'attach_image_url',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'fullscreen',
									'label' => __('Fullscreen', 'mageewp-page-layout'),
									'type' => 'toggle',
									'value' => 'yes',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'fixed_background',
									'label' => __('Fixed background', 'mageewp-page-layout'),
									'type' => 'toggle',
									'value' => 'yes',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								
								array(
									'name' => 'header_decoration',
									'label' => __('Header decoration', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'line',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'disabled' => MPL_URL.'/assets/images/header/header_decoration_disabled.png',
										'shadow' => MPL_URL.'/assets/images/header/header_decoration_shadow.png',
										'line' => MPL_URL.'/assets/images/header/header_decoration_line.png',
									)
								),
								array(
									'name' => 'line_color',
									'label' => __('Line color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'relation' => array(
										'parent' => 'header_settings-background-header_decoration',
										'show_when' => 'line',
									),									
								),
								array(
									'name' => 'line_opacity',
									'label' => __('Line opacity', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '0',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'relation' => array(
										'parent' => 'header_settings-background-header_decoration',
										'show_when' => 'line',
									),
								),
							),
							"menu" => array(
								array(
									'name' => 'open_menu_icon_color',
									'label' => __('"Open menu" icon color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'open_menu_background',
									'label' => __('"Open menu" background', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'open_menu_background_opacity',
									'label' => __('"Open menu" background opacity', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '75',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'close_menu_icon_color',
									'label' => __('"Close menu" icon color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'close_menu_background',
									'label' => __('"Close menu" background', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'close_menu_background_opacity',
									'label' => __('"Close menu" background opacity', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '75',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'menu_icon_margin',
									'label' => __('Menu icon margin', 'mageewp-page-layout'),
									'type' => 'corners',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options'		=>	array(
										'top'		=>	'0px',
										'bottom'	=>	'0px',
										'left'		=>	'0px',
										'right'		=>	'0px',
									),						
								),
								array(
									'name' => 'background_border_radius',
									'label' => __('Background border radius (px)', 'mageewp-page-layout'),
									'type' => 'text',
									'value' => '0',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
							),
							"classic" => array(
								array(
									'name' => 'menu_background_line',
									'label' => __('Menu background / line', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'backgrond',
									'options' => array(
										'disabled' => MPL_URL.'/assets/images/header/classic_header_disabled.png',
										'content_width_line' => MPL_URL.'/assets/images/header/classic_header_content_width_line.png',
										'full_width_line' => MPL_URL.'/assets/images/header/classic_header_full_line.png',
										'backgrond' => MPL_URL.'/assets/images/header/classic_header_background.png',
									),									
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'background_color',
									'label' => __('Background color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'header_settings-classic-menu_background_line',
										'hide_when' => 'disabled',
									),									
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'background_opacity',
									'label' => __('Background opacity', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '42',
									'relation' => array(
										'parent' => 'header_settings-classic-menu_background_line',
										'hide_when' => 'disabled',
									),									
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),								
							),
							"sliding" => array(
								array(
									'name' => 'background_color',
									'label' => __('Background color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'background_opacity',
									'label' => __('Background opacity', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '42',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'background_image',
									'label' => __('Add background image', 'mageewp-page-layout'),
									'type' => 'attach_image_url',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'fullscreen',
									'label' => __('Fullscreen', 'mageewp-page-layout'),
									'type' => 'toggle',
									'value' => 'yes',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								
							),
						)
					),
				),
				'Menu' => array(
					array(
						'name'			=> 'menu_settings',
						'type'			=> 'mytabs',
						'label'			=> __('Menu Settings', 'mageewp-page-layout'),
						'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
						'options' => array(
							'font'	=> __('items font', 'mageewp-page-layout'),
							'margins'	=> __('items margins & paddings', 'mageewp-page-layout'),
							'dividers'	=> __('Dividers', 'mageewp-page-layout'),
							'decoration'	=> __('Decoration styles for horizontal headers', 'mageewp-page-layout'),
						),
						'params' => array(
							"font" => array(
								array(
									'name' => 'font_size',
									'label' => __('Font size', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '16',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'capitalize',
									'label' => __('Capitalize', 'mageewp-page-layout'),
									'type' => 'toggle',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								
								array(
									'name' => 'normal_font_color',
									'label' => __('Normal font color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'hover_font_color',
									'label' => __('Hover font color', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'accent',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'accent' => MPL_URL.'/assets/images/header/color_accent.png',
										'color' => MPL_URL.'/assets/images/header/color_custom.png',
										'gradient' => MPL_URL.'/assets/images/header/color_gradient.png',
									)
								),
								array(
									'name' => 'hover_custom_color',
									'label' => __('Color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'menu_settings-font-hover_font_color',
										'show_when' => 'color',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'hover_gradient1',
									'label' => __('Gradient Color 1', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'menu_settings-font-hover_font_color',
										'show_when' => 'gradient',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'hover_gradient2',
									'label' => __('Gradient Color 2', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'menu_settings-font-hover_font_color',
										'show_when' => 'gradient',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'active_item_font_color',
									'label' => __('Active item font color', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'accent',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'accent' => MPL_URL.'/assets/images/header/color_accent.png',
										'color' => MPL_URL.'/assets/images/header/color_custom.png',
										'gradient' => MPL_URL.'/assets/images/header/color_gradient.png',
									)
								),
								array(
									'name' => 'active_custom_color',
									'label' => __('Color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'menu_settings-font-active_item_font_color',
										'show_when' => 'color',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'active_gradient1',
									'label' => __('Gradient Color 1', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'menu_settings-font-active_item_font_color',
										'show_when' => 'gradient',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'active_gradient2',
									'label' => __('Gradient Color 2', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'menu_settings-font-active_item_font_color',
										'show_when' => 'gradient',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),								
								array(
									'name' => 'menu_icon_size',
									'label' => __('Menu icon size', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '0',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'next_level',
									'label' => __('Show next level indicator icons', 'mageewp-page-layout'),
									'type' => 'toggle',
									'value' => 'yes',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
							),
							"margins" => array(
								array(
									'name'			=> 'paddings',
									'type'			=> 'corners',
									'label'			=> __('Paddings', 'mageewp-page-layout'),
									'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
									'options'		=>	array(
										'top'		=>	'0px',
										'bottom'	=>	'0px',
										'left'		=>	'0px',
										'right'		=>	'0px',
									),
								),
								array(
									'name'			=> 'margin',
									'type'			=> 'corners',
									'label'			=> __('Margin', 'mageewp-page-layout'),
									'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
									'options'		=>	array(
										'top'		=>	'0px',
										'bottom'	=>	'0px',
										'left'		=>	'0px',
										'right'		=>	'0px',
									),
								),
							
			
							),
							"dividers" => array(
								array(
									'name' => 'dividers',
									'label' => __('Dividers', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'enabled',
									'options' => array(
										'enabled' => MPL_URL.'/assets/images/header/menu_dividers_enabled.png',
										'disabled' => MPL_URL.'/assets/images/header/menu_dividers_disabled.png',
									),									
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'divider_height',
									'label' => __('Divider height (width)', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => '100',
									'options' => array(
										'100' => MPL_URL.'/assets/images/header/menu_dividers_height_100.png',
										'custom' => MPL_URL.'/assets/images/header/menu_dividers_height_custom.png',
									),									
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'height',
									'label' => __('Height (px)', 'mageewp-page-layout'),
									'type' => 'text',
									'value' => '42',
									'relation' => array(
										'parent' => 'menu_settings-dividers-divider_height',
										'show_when' => 'custom',
									),
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),									
								array(
									'name' => 'first_last_dividers',
									'label' => __('First & last dividers', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'enabled',
									'options' => array(
										'enabled' => MPL_URL.'/assets/images/header/menu_dividers_enabled.png',
										'disabled' => MPL_URL.'/assets/images/header/menu_dividers_first_disabled.png',
									),									
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),																
								array(
									'name' => 'dividers_color',
									'label' => __('Dividers color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'dividers_opacity',
									'label' => __('Dividers opacity', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '42',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),								
							),
							"decoration" => array(
								array(
									'name' => 'decoration',
									'label' => __('Decoration', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'none',
									'options' => array(
										'none' => MPL_URL.'/assets/images/header/menu_decoration_none.png',
										'underline' => MPL_URL.'/assets/images/header/menu_decoration_underline.png',
										'outline' => MPL_URL.'/assets/images/header/menu_decoration_outline.png',
									),									
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'direction',
									'label' => __('Direction', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'enabled',
									'relation' => array(
										'parent' => 'menu_settings-decoration-decoration',
										'show_when' => 'underline',
									),
									'options' => array(
										'left_right' => MPL_URL.'/assets/images/header/menu_item_direction_left_right.png',
										'from_center' => MPL_URL.'/assets/images/header/menu_item_direction_from_center.png',
										'upwards' => MPL_URL.'/assets/images/header/menu_item_direction_upwards.png',
										'downwards' => MPL_URL.'/assets/images/header/menu_item_direction_downwards.png',
									),									
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								
								array(
									'name' => 'hover_style',
									'label' => __('Hover style', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'outline',
									'relation' => array(
										'parent' => 'menu_settings-decoration-decoration',
										'show_when' => 'outline',
									),
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'outline' => MPL_URL.'/assets/images/header/menu_hover_outline.png',
										'background' => MPL_URL.'/assets/images/header/menu_hover_background.png',
									),
								),	
								
								
								array(
									'name' => 'underline_custom_color',
									'label' => __('Color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
																	
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
															
							),
						),
					)
				),
				'Sub Menu' => array(
					array(
						'name'			=> 'sub_menu_settings',
						'type'			=> 'mytabs',
						'label'			=> __('Sub Menu Settings', 'mageewp-page-layout'),
						'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
						'options' => array(
							'font'	=> __('Items font', 'mageewp-page-layout'),
							'margins'	=> __('Items margins & paddings', 'mageewp-page-layout'),
							'background'	=> __('Background', 'mageewp-page-layout'),
							'side'	=> __('Side & overlay navigation', 'mageewp-page-layout'),
						),
						'params' => array(
							'font' => array(
								array(
									'name' => 'font_size',
									'label' => __('Font size', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '16',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'capitalize',
									'label' => __('Capitalize', 'mageewp-page-layout'),
									'type' => 'toggle',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
							
								array(
									'name' => 'normal_font_color',
									'label' => __('Normal font color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'hover_font_color',
									'label' => __('Hover font color', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'accent',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'accent' => MPL_URL.'/assets/images/header/color_accent.png',
										'color' => MPL_URL.'/assets/images/header/color_custom.png',
										'gradient' => MPL_URL.'/assets/images/header/color_gradient.png',
									)
								),
								array(
									'name' => 'hover_custom_color',
									'label' => __('Color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'sub_menu_settings-font-hover_font_color',
										'show_when' => 'color',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'hover_gradient1',
									'label' => __('Gradient Color 1', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'sub_menu_settings-font-hover_font_color',
										'show_when' => 'gradient',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'hover_gradient2',
									'label' => __('Gradient Color 2', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'sub_menu_settings-font-hover_font_color',
										'show_when' => 'gradient',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'active_item_font_color',
									'label' => __('Active item font color', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'accent',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'accent' => MPL_URL.'/assets/images/header/color_accent.png',
										'color' => MPL_URL.'/assets/images/header/color_custom.png',
										'gradient' => MPL_URL.'/assets/images/header/color_gradient.png',
									)
								),
								array(
									'name' => 'active_custom_color',
									'label' => __('Color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'sub_menu_settings-font-active_item_font_color',
										'show_when' => 'color',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'active_gradient1',
									'label' => __('Gradient Color 1', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'sub_menu_settings-font-active_item_font_color',
										'show_when' => 'gradient',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'active_gradient2',
									'label' => __('Gradient Color 2', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'sub_menu_settings-font-active_item_font_color',
										'show_when' => 'gradient',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),								
								array(
									'name' => 'menu_icon_size',
									'label' => __('Menu icon size', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '0',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'next_level',
									'label' => __('Show next level indicator icons', 'mageewp-page-layout'),
									'type' => 'toggle',
									'value' => 'yes',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
																
							),
							'margins' => array(
								array(
									'name'			=> 'paddings',
									'type'			=> 'corners',
									'label'			=> __('Paddings', 'mageewp-page-layout'),
									'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
									'options'		=>	array(
										'top'		=>	'0px',
										'bottom'	=>	'0px',
										'left'		=>	'0px',
										'right'		=>	'0px',
									),
								),
								array(
									'name'			=> 'margin',
									'type'			=> 'corners',
									'label'			=> __('Margin', 'mageewp-page-layout'),
									'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
									'options'		=>	array(
										'top'		=>	'8px',
										'bottom'	=>	'8px',
										'left'		=>	'10px',
										'right'		=>	'10px',
									),
								),
							),
							'background' => array(
								array(
									'name' => 'color',
									'label' => __('Color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'opacity',
									'label' => __('Opacity', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '0',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'width',
									'label' => __('Width', 'mageewp-page-layout'),
									'type' => 'text',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								/*array(
									'name' => 'hover_background',
									'label' => __('Hover background', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'disabled',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'disabled' => MPL_URL.'/assets/images/header/submenu_hover_background_disabled.png',
										'plain' => MPL_URL.'/assets/images/header/menu_hover_background.png',
										'animation' => MPL_URL.'/assets/images/header/submenu_hover_background_animation.png',
									),
								),	*/																							
							),
							'side' => array(
								array(
									'name' => 'show',
									'label' => __('show', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'sideways',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'sideways' => MPL_URL.'/assets/images/header/submenu_side_sideways.png',
										'downwards' => MPL_URL.'/assets/images/header/submenu_side_downwards.png',
									),
								),
							)
						),
					)
				),
				'Microwidgets' => array(
					array(
						'name' => 'near_menu_font_size',
						'label' => __('Near menu font size', 'mageewp-page-layout'),
						'type' => 'number_slider',
						'value' => '13',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
					),
					array(
						'name' => 'near_menu_font_color',
						'label' => __('Near menu font color', 'mageewp-page-layout'),
						'type' => 'color_picker',
						'value' => '#333333',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
					),
					array(
						'name' => 'near_logo_font_size',
						'label' => __('Near logo font size', 'mageewp-page-layout'),
						'type' => 'number_slider',
						'value' => '13',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
					),
					array(
						'name' => 'near_logo_font_color',
						'label' => __('Near logo font color', 'mageewp-page-layout'),
						'type' => 'color_picker',
						'value' => '#333333',
						'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
					),
				),				
				'Float Header' => array(
					array(
						'name'			=> 'navigation_panel',
						'type'			=> 'panel',
						'relation' => array(
							'parent' => 'layout:header_layout',
							'show_when' => 'classic,inline,split,inline_three',
						),
						'params' => array(
							array(
								'name' => 'floating_navigation',
								'label' => __('Floating navigation', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'enabled',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'enabled' => MPL_URL.'/assets/images/header/floating_navigation_enabled.png',
									'disabled' => MPL_URL.'/assets/images/header/floating_navigation_disabled.png',
								),
							),
							array(
								'name' => 'effect',
								'label' => __('Effect', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'sticky',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'fade' => MPL_URL.'/assets/images/header/floating_effect_fade.png',
									'slide' => MPL_URL.'/assets/images/header/floating_effect_slide.png',
									'sticky' => MPL_URL.'/assets/images/header/floating_effect_sticky.png',
								),
								'relation' => array(
										'parent' => 'navigation_panel-floating_navigation',
										'show_when' => 'enabled',
									),	
							),
							array(
								'name' => 'scrolling',
								'label' => __('Show after scrolling (px)', 'mageewp-page-layout'),
								'type' => 'text',
								'value' => '',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'relation' => array(
										'parent' => 'navigation_panel-floating_navigation',
										'show_when' => 'enabled',
									),
							),
							array(
								'name' => 'height',
								'label' => __('Height (px)', 'mageewp-page-layout'),
								'type' => 'text',
								'value' => '',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'relation' => array(
										'parent' => 'navigation_panel-floating_navigation',
										'show_when' => 'enabled',
									),
							),
							array(
								'name' => 'background_color',
								'label' => __('Background color', 'mageewp-page-layout'),
								'type' => 'color_picker',
								'value' => '',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'relation' => array(
										'parent' => 'navigation_panel-floating_navigation',
										'show_when' => 'enabled',
									),
							),
							array(
								'name' => 'background_opacity',
								'label' => __('Background opacity', 'mageewp-page-layout'),
								'type' => 'number_slider',
								'value' => '100',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'relation' => array(
										'parent' => 'navigation_panel-floating_navigation',
										'show_when' => 'enabled',
									),
							),
							array(
								'name' => 'decoration',
								'label' => __('Decoration', 'mageewp-page-layout'),
								'type' => 'radio_image',
								'value' => 'disabled',
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								'options' => array(
									'disabled' => MPL_URL.'/assets/images/header/floating_navigation_decoration_disabled.png',
									'shadow' => MPL_URL.'/assets/images/header/floating_navigation_decoration_shadow.png',
									'line' => MPL_URL.'/assets/images/header/floating_navigation_decoration_line.png',
								),
								'relation' => array(
										'parent' => 'navigation_panel-floating_navigation',
										'show_when' => 'enabled',
									),
							),																														
							array(
								'name' => 'line_color',
								'label' => __('Line color', 'mageewp-page-layout'),
								'type' => 'color_picker',
								'value' => '',
								'relation' => array(
									'parent' => 'navigation_panel-decoration',
									'show_when' => 'line',
								),								
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
							),
							array(
								'name' => 'line_opacity',
								'label' => __('Line opacity', 'mageewp-page-layout'),
								'type' => 'number_slider',
								'value' => '',
								'relation' => array(
									'parent' => 'navigation_panel-decoration',
									'show_when' => 'line',
								),									
								'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
							),														
						),
					),
				),	
				'Mobile Header' => array(
					array(
						'name'			=> 'mobile_settings',
						'type'			=> 'mytabs',
						'label'			=> __('Mobile Settings', 'mageewp-page-layout'),
						'description'	=> __( 'Repeat this fields with each item created, Each item corresponding slide element.', 'mageewp-page-layout' ),
						'options' => array(
							'tablet'	=> __('Tablet', 'mageewp-page-layout'),
							'phone'	=> __('Phone', 'mageewp-page-layout'),
							'navigation'	=> __('Floating mobile navigation', 'mageewp-page-layout'),
							'font'	=> __('Menu font', 'mageewp-page-layout'),
							'background'	=> __('Menu background', 'mageewp-page-layout'),
						),
						'params' => array(
							'tablet' => array(
								array(
									'name' => 'switch',
									'label' => __('Switch after (px)', 'mageewp-page-layout'),
									'type' => 'text',
									'value' => '1040',					
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'layout',
									'label' => __('Layout', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'left_center',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'left_right' => MPL_URL.'/assets/images/header/tablet_layout_left_right.png',
										'left_centered' => MPL_URL.'/assets/images/header/tablet_layout_left_centered.png',
										'right_left' => MPL_URL.'/assets/images/header/tablet_layout_right_left.png',
										'right_centered' => MPL_URL.'/assets/images/header/tablet_layout_right_centered.png',
									)
								),
								array(
									'name' => 'height',
									'label' => __('Header height (px)', 'mageewp-page-layout'),
									'type' => 'text',
									'value' => '60',						
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),								
							),
							'phone' => array(
								array(
									'name' => 'switch',
									'label' => __('Switch after (px)', 'mageewp-page-layout'),
									'type' => 'text',
									'value' => '800',					
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'layout',
									'label' => __('Layout', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'left_center',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'left_right' => MPL_URL.'/assets/images/header/phone_layout_left_right.png',
										'left_centered' => MPL_URL.'/assets/images/header/phone_layout_left_centered.png',
										'right_left' => MPL_URL.'/assets/images/header/phone_layout_right_left.png',
										'right_centered' => MPL_URL.'/assets/images/header/phone_layout_right_centered.png',
									)
								),
								array(
									'name' => 'height',
									'label' => __('Header height (px)', 'mageewp-page-layout'),
									'type' => 'text',
									'value' => '60',						
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),								
							),
							'navigation' => array(
								array(
									'name' => 'floating',
									'label' => __('Floating mobile navigation', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'disabled',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'disabled' => MPL_URL.'/assets/images/header/mobile_floating_disabled.png',
										'sticky' => MPL_URL.'/assets/images/header/mobile_floating_sticky.png',
										'menu_icon' => MPL_URL.'/assets/images/header/mobile_floating_menu_icon.png',
									)
								),
							),
							'font' => array(
								array(
									'name' => 'font_size',
									'label' => __('Font size', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '16',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'capitalize',
									'label' => __('Capitalize', 'mageewp-page-layout'),
									'type' => 'toggle',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								
								array(
									'name' => 'normal_font_color',
									'label' => __('Normal font color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								
								array(
									'name' => 'hover_font_color',
									'label' => __('Hover font color', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'accent',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'accent' => MPL_URL.'/assets/images/header/color_accent.png',
										'color' => MPL_URL.'/assets/images/header/color_custom.png',
										'gradient' => MPL_URL.'/assets/images/header/color_gradient.png',
									)
								),
								array(
									'name' => 'hover_gradient1',
									'label' => __('Gradient Color 1', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'mobile_settings-font-hover_font_color',
										'show_when' => 'gradient',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'hover_gradient2',
									'label' => __('Gradient Color 2', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'mobile_settings-font-hover_font_color',
										'show_when' => 'gradient',
									),
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'active_item_font_color',
									'label' => __('Active item font color', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'accent',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'accent' => MPL_URL.'/assets/images/header/color_accent.png',
										'color' => MPL_URL.'/assets/images/header/color_custom.png',
										'gradient' => MPL_URL.'/assets/images/header/color_gradient.png',
									)
								),
								array(
									'name' => 'active_custom_color',
									'label' => __('Color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'mobile_settings-font-active_item_font_color',
										'show_when' => 'color',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'active_gradient1',
									'label' => __('Gradient Color 1', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'mobile_settings-font-active_item_font_color',
										'show_when' => 'gradient',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'active_gradient2',
									'label' => __('Gradient Color 2', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'relation' => array(
										'parent' => 'mobile_settings-font-active_item_font_color',
										'show_when' => 'gradient',
									),										
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),								
							),
							'background' => array(
								array(
									'name' => 'color',
									'label' => __('Background color', 'mageewp-page-layout'),
									'type' => 'color_picker',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'opacity',
									'label' => __('Background opacity', 'mageewp-page-layout'),
									'type' => 'number_slider',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'maximum_width',
									'label' => __('Maximum background width (px)', 'mageewp-page-layout'),
									'type' => 'text',
									'value' => '',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
								),
								array(
									'name' => 'slides_from',
									'label' => __('Mobile menu slides from', 'mageewp-page-layout'),
									'type' => 'radio_image',
									'value' => 'left',
									'description' => __('Styles with pro tag are available in <a href="https://www.mageewp.com/wordpress-themes/" target="_blank">pro version</a>.','mageewp-page-layout'),
									'options' => array(
										'left' => MPL_URL.'/assets/images/header/mobile_menu_background_slides_from_left.png',
										'right' => MPL_URL.'/assets/images/header/mobile_menu_background_slides_from_right.png',
									)
								),																																
							),							
						)
					)
				),
			)
		)
    ),
    'core'
);