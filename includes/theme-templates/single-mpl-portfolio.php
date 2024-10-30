<?php
get_header('mpl');
if(have_posts()): 
	 the_post(); ?>

<div id="mpl-portfolio-<?php the_ID(); ?>" <?php post_class("clear"); ?>>
<div class="post-wrap">
            <div class="container">
                <div class="post-inner row">
                        <section class="post-main" role="main" id="content">
                         
                            <article class="type-portfolio">
                            
								<?php    
										  $galleryArray = get_mpl_post_gallery_ids( get_the_ID() ); 
										  
										  if( count( $galleryArray ) >0 && $galleryArray[0] != "" ):
									?>
      
                                <div class="mpl-carousel-wrap full mpl-portfolio-slider-wrap">
                                    <div class="mpl-carousel owl-carousel mpl-slider mpl-portfolio-slider" data-owl-options="{}">
        
                                        <?php
										    $i = 0 ;
											foreach ( $galleryArray as $id ) { 
                                        ?>
                                            
                                                <img src="<?php echo wp_get_attachment_url( $id ); ?>" alt="" />
                                                
                                            <?php 
                                                $i++;
											}
											?>
                                        
                                    </div>
                                    <!--slider end-->
                                </div>
                                <?php endif ; ?>
                                <div class="entry-main">
                                    <div class="entry-header">                                            
                                        <h1 class="entry-title"><?php the_title();?></h1>
                                        
                                    </div>
                                    <div class="entry-content">
                                        <?php the_content();?>
                                    </div>
                                    
                                    <dl class="mpl-portfolio-entry-info">
                                        <dt><?php _e( 'Client', 'mageewp-page-layout' )?>:</dt>
                                        <dd><?php echo get_the_author_link();?></dd>
                                        <?php
										$taxonomy = 'mpl-portfolio-category';
										$tax_terms = wp_get_post_terms($post->ID,$taxonomy);
										
										if( $tax_terms ){?>
                                        <dt><?php _e( 'Category', 'mageewp-page-layout' );?>:<dd>
                                        <?php 
										foreach ( $tax_terms as $tax_term ) {
										echo '<a href="' . esc_attr( get_term_link( $tax_term, $taxonomy ) ) . '" title="' . sprintf( __( "View all posts in %s", 'mageewp-page-layout' ), $tax_term->name ) . '" ' . '>' . $tax_term->name.',</a>';
										} ?>
										</dd>
										</dt>
										<?php 
										}
										?>
                                        <?php
										$taxonomy = 'mpl-portfolio-tag';
										$tax_terms = wp_get_post_terms($post->ID,$taxonomy);
										
										if( $tax_terms ){?>
                                        <dt>
										<?php _e( 'Tags', 'mageewp-page-layout' );?>: 
                                        <dd>
                                        <?php 
										foreach ($tax_terms as $tax_term) {
										echo '<a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) . '" title="' . sprintf( __( "View all posts in %s" ,'mageewp-page-layout'), $tax_term->name ) . '" ' . '>' . $tax_term->name.',</a>';
										} ?>
										</dd>
										</dt>
										<?php 
										}
										?>
                                    </dl>
                                    <ul class="mpl-entry-share">
                                    <?php  $link = htmlspecialchars( get_permalink() ) ;

									$mpl_share_facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($link);
									$mpl_share_twitter = 'https://twitter.com/intent/tweet?text=' . urlencode($link);
									$mpl_share_google = 'https://plus.google.com/share?url=' . urlencode($link);
									$mpl_share_linkedin = 'https://www.linkedin.com/shareArticle?mini=true&amp;url=' . urlencode($link);
									$mpl_share_pinterest = 'https://pinterest.com/pin/create/button/?url='.urlencode($link);
									$mpl_share_reddit = 'https://reddit.com/submit?url='.urlencode($link);
									$mpl_share_vk = 'http://vk.com/share.php?url='.urlencode($link);
									
									?>
                                        <li><a href="<?php echo $mpl_share_twitter;?>" target="_blank"><i class="fa fa-twitter fa-fw"></i></a></li>
                                        <li><a href="<?php echo $mpl_share_facebook;?>" target="_blank"><i class="fa fa-facebook fa-fw"></i></a></li>
                                        <li><a href="<?php echo $mpl_share_google;?>" target="_blank"><i class="fa fa-google-plus fa-fw"></i></a></li>
                                        <li><a href="<?php echo $mpl_share_pinterest;?>" target="_blank"><i class="fa fa-pinterest fa-fw"></i></a></li>
                                        <li><a href="<?php echo $mpl_share_linkedin;?>" target="_blank"><i class="fa fa-linkedin fa-fw"></i></a></li>
                                        <li><a href="<?php echo $mpl_share_reddit;?>" target="_blank"><i class="fa fa-reddit fa-fw"></i></a></li>
                                        <li><a href="<?php echo $mpl_share_vk;?>" target="_blank"><i class="fa fa-vk fa-fw"></i></a></li>
                                    </ul>
                                </div>
                            </article>
                          
                            <div class="post-attributes">
                                
                          <?php 
								
								$related = mpl_get_related_posts($post->ID, 4 ,'mpl-portfolio','mpl-portfolio-category'); 
											  
									?>
			                        <?php if($related->have_posts()):?>
            
                                    <div class="related-posts">
                                        <h3><?php _e( 'Related Portfolios', 'mageewp-page-layout' );?></h3>
                                        <div class="mpl-carousel-wrap">
                                           <div class="mpl-portfolio-related-posts mpl-portfolio-carousel mpl-carousel owl-carousel" data-owl-options="{'items':3}">
                                        
                            <?php while($related->have_posts()): $related->the_post(); ?>
                            
							<?php if(has_post_thumbnail()): ?>
                            <?php  $full_image  = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); 
							        $thumb_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'related-post');
							?>
											<article class="portfolio-box"> 
                                                                <div class="mpl-portfolio-image">
                                                                    <div class="img-box figcaption-middle text-center fade-in">
                                                                        <img src="<?php echo $thumb_image[0];?>" class="feature-img"/>
                                                                        <div class="img-overlay">
                                                                            <div class="img-overlay-container">
                                                                                <div class="img-overlay-content">
                                                                                    <div class="img-overlay-icons">
                                                                                       <a href="<?php the_permalink(); ?>"><i class="fa fa-link"></i></a>
                                                                                       <a rel="portfolio-image" href="<?php echo $full_image[0];?>"><i class="fa fa-search"></i></a>                                                                                    </div>         
                                                                                </div>
                                                                            </div>                                        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            </article>
                                            
                                              
                                                            
                                            <?php endif; endwhile; ?>
                                        </div>
                                       </div> 
                                    </div>
                                    <?php wp_reset_postdata(); endif; ?>
                                <!--Related Posts End-->
                                <!--Comments Area-->                                
                                <div class="comments-area text-left"> 
                                     <?php
											// If comments are open or we have at least one comment, load up the comment template
											if ( comments_open()  ) :
												comments_template();
											endif;
										?>
                                     </div>
                                <!--Comments End-->

                            </div>
                            
                        </section>
                </div>
            </div>  
        </div>
</div>
<?php
endif;

get_footer('mpl');