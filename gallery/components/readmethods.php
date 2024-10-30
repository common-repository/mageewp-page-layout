<?php

function get_mpl_post_gallery_ids($id,$max_images=-1,$method="array") {

	if (is_preview($id)) {

		$galleryString = get_post_meta( $id, 'mpl_temp_metadata', 1);

	}

	else {

		$galleryString = get_post_meta( $id, 'mpl_perm_metadata', 1);

	}

	if ($method == "string" || $max_images == "string") {

		return $galleryString;

	}

	else {

		if ($max_images == -1) {

			return explode(',', $galleryString);

		}

		else {

			return array_slice(explode(',', $galleryString), 0, $max_images);

		}

	}

}

function mpl_get_related_posts($post_id, $number_posts = -1,$post_type = 'post',$taxonomies='category') {
	//$query = new WP_Query();
	
	$categories = array();

	$terms = wp_get_object_terms( $post_id,  $taxonomies );
	  if ( ! empty( $terms ) ) {
		  if ( ! is_wp_error( $terms ) ) {
				  foreach( $terms as $term ) {
					  $categories[] = $term->term_id; 
				  }
		  }
	  }
   if( $post_type == 'post' )
    $args = array('category__in' => $categories);
	else
	$args = array('tax_query' => array(
        array(
            'taxonomy' => $taxonomies,
            'field'    => 'term_id',
            'terms'    => $categories,
        ),
    ),);
	
	if($number_posts == 0) {
		$query = new WP_Query();
		return $query;
	}

	$args = wp_parse_args($args, array(
		'posts_per_page' => $number_posts,
		'post__not_in' => array($post_id),
		'ignore_sticky_posts' => 0,
        'meta_key' => '_thumbnail_id',
		'post_type' =>$post_type,
		'operator'  => 'IN'
	));

	$query = new WP_Query($args);
    wp_reset_postdata(); 
  	return $query;
}