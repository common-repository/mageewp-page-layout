<?php
global $portfolio_post_data, $portfolio_post_atts;
$atts = array();
$image_size 	= 'full';
$atts['post_taxonomy'] = 'mpl-portfolio-category';
$atts['thumbnail'] = 'yes';
$atts['i18n_s1'] = __( 'All', 'mageewp-page-layout' );
$atts['image_size'] = 'full';
$atts['show_date'] = '';
$atts['wrap_class'] = '';
$atts['post_type'] = 'mpl-portfolio';
$atts['order_by'] = 'ID';
$atts['columns'] = '4';
$atts['section_id'] = '';
$atts['section_title'] = '';
$atts['section_subtitle'] = '';
$atts['filter'] = 'true';
$atts['pagination'] = '';

$portfolio_post_atts = $atts;

$portfolio_post_data = mpl_recent_posts_data($atts);

function mpl_portfolio_content_filter($content) {
	
ob_start();
global $portfolio_post_data, $portfolio_post_atts;
$post_data = $portfolio_post_data;
$atts      = $portfolio_post_atts;

$owl = apply_filters( 'mpl-owl-carousel', $atts );
$el_classes = apply_filters( 'mpl-el-class', $atts );

extract($atts);


$posts = array();
foreach ($post_data['data'] as $item) {
	$posts[] = (object)$item;
}
$categories = array();
foreach ($post_data['categories'] as $item) {
	$categories[] = (object)$item;
}

$columns = isset($items_number) ? $items_number : $columns;

if (isset($fullwidth) && $fullwidth == 'yes') {
	$container = 'mpl-container-fullwidth';
} else {
	$container = 'mpl-container';
}
if (isset($no_padding) && $no_padding == 'yes') {
	$full = 'full';
} else {
	$full = '';
}

/*
$categories   = array();
$taxonomy     = $post_taxonomy;
$tax_terms    = get_terms($taxonomy) ;
$i            = 0 ;
if( $tax_terms ){
	foreach ($tax_terms as $tax_term) {
		$obj = new StdClass();
		$obj->slug = $tax_term->slug ;
		$obj->name = $tax_term->name ;
		$categories[] = $obj;
		$i++;
	}
}
*/

/*function data*/
$data = (object)array(
	'section_class'    => implode(' ', $el_classes),
	'section_id'       => esc_attr( $atts['section_id'] ),
	'section_title'    => $section_title,
	'section_subtitle' => $section_subtitle,
	'wrap_class'       => $wrap_class,
	'i18n_s1'         => $i18n_s1,
	'categories'	   => $categories,
	'posts' 		   => $posts,
	'container'		   => $container,
	'full'			   => $full,
	'columns'          => $columns,
	'filter'		   => $filter,
	'carousel'         => $owl['carousel'],
	'owl_options' 	   => $owl['options'],
	'owl_nav_style'    => $owl['nav_style'],
	'pagination'       => isset($post_data['pagination']) ? $post_data['pagination'] : ''
);

mpl_tpl_section_portfolio($data);
return ob_get_clean();
	
}
add_filter( 'the_content', 'mpl_portfolio_content_filter' );
load_template( get_template_directory().'/page.php' );