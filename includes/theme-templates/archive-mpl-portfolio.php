<?php
	get_header('mpl');
            
	$html = '<ul class="mpl-portfolio-list-wrap mpl-portfolio-grid mpl-list-sm-2 mpl-list-md-3 mpl-list-lg-4" style="padding-top:50px;padding-bottom:50px;">';
	if(have_posts()): 
		while ( have_posts() ) : the_post(); 
			$postid = get_the_ID();
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'large');
			$featured_image = $image[0];
		
			  if ( !$featured_image):
				
				   $portfolio_gallery  = get_post_meta( $postid, 'mpl_perm_metadata', true );
											 
				  if( $portfolio_gallery ):
					 $attachment_id_arr = explode(",",$portfolio_gallery);
					 if($attachment_id_arr && is_array($attachment_id_arr)){
					  $attachment_id = $attachment_id_arr[0];
			
						 $image_attributes = wp_get_attachment_image_src( $attachment_id, 'large' );
						 $featured_image   = $image_attributes[0];
					
						  } 
	  
					 endif;
			  endif;
			  
			  if ( $featured_image !='' ):
									   
                             $html .= '<li id="'.$postid.'" class="mpl-portfolio-box-wrap">
                                        <article class="mpl-portfolio-box">
                                            <div class="mpl-portfolio-image">
                                                <div class="img-box figcaption-middle text-center fade-in">
                                                    <img src="'.esc_url($featured_image).'" alt="">
                                                    <div class="img-overlay">
                                                        <div class="img-overlay-container">
                                                            <div class="img-overlay-content">
                                                                <h2 class="entry-title">'.esc_attr(get_the_title()).'</h2>
                                                                <div class="img-overlay-icons">
                                                                    <a href="'.esc_url(get_permalink()).'"><i class="fa fa-link"></i></a>
                                                                    <a href="'.esc_url($featured_image).'" rel="prettyPhoto"><i class="fa fa-search"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </li>';  
									endif;

					endwhile;
				endif;
				
	$html .= '</ul>';
	echo $html;
	the_posts_pagination();
	get_footer('mpl');
