<?php 

$output = $wrap_class  = $css_custom = $css =  '';

$section_subtitle = '';
$section_title    = '';
$page_id = '';
$num = '';
$feedData = '';
$date_format = '';
$columns = '';
$carousel = '';

$i18n_s1 = __('Share', 'mageewp-page-layout');

extract($atts);

$element_attributes = array();

$owl = apply_filters( 'mpl-owl-carousel', $atts );
$el_classes = apply_filters( 'mpl-el-class', $atts );

$video_background = apply_filters('mpl-video-background', $atts);
/*$section_subtitle = $section_subtitle == ""?"":'<p class="mpl-section-subtitle text-center" data-mpl_name="section_subtitle">'.$section_subtitle.'</p>';

$element_attributes[] = 'class="'. esc_attr( implode(' ', $el_classes ) ) .'"';
$element_attributes[] = 'id="'. esc_attr( $atts['section_id'] ) .'"';*/

$columns = $columns == ''? 1 : $columns;
$mff_data = mpl_facebook_feed_data($atts);
$error_data = array();
$fb_data = array();
$error = '';
if ( isset($mff_data['error']) )
{
	$error_data[] = (object)$mff_data['error'];
	$error = 'yes';
}

if ( isset($mff_data['data']) && !empty( $mff_data['data'] ) )
{
	foreach( $mff_data['data'] as $val )
	{
		$fb_data[] = (object)$val;
	}
}

/*function data*/
$data = (object)array(
	'section_class'    => implode(' ', $el_classes),
	'section_id'       => esc_attr( $atts['section_id'] ),
	'section_title'    => $section_title,
	'section_subtitle' => $section_subtitle,
	'error'            => $error,
	'error_data'       => $error_data,
	'fb_data'          => $fb_data,
	'columns'          => $columns,
	'carousel'         => $owl['carousel'],
	'owl_options' 	   => $owl['options'],
	'owl_nav_style'    => $owl['nav_style'],
	'video_background' => $video_background,
	'i18n_s1'          => $i18n_s1
);

mpl_tpl_section_facebook_feed($data);
/*if($date_format == '') $date_format = 'default';

$output .= '<section '. implode(' ', $element_attributes) .' data-mpl_name="section_id||section_class||animate">
               <div class="mpl-section-content">
                   <div class="mpl-container">';
$output .= '<div class="mpl-section-title-wrap">          
                                    <h2 class="mpl-section-title text-center" data-mpl_name="section_title"> '.$section_title.' </h2>
									'.$section_subtitle.'
                                </div>';
$mpl_app_token = array(
                       '1377619605888926|LxwTNNAeRtn9nYhYS0VDkVDs0mI',
					   '393872077427061|ghfVBzNUFnMdFLAGlJbWAOVOelI',
					   '1505917499687703|2133Lp1cLt6Zk0N2por8X8QJf9k'
                       );
$access_token = $mpl_app_token[rand(0,2)];

$mpl_posts_json_url = 'https://graph.facebook.com/' . $page_id . '/posts?access_token=' . $access_token . '&limit=' . $num;

//Use cURL
$feedData = mpl_mff_fetchUrl($mpl_posts_json_url);

$FBdata = json_decode($feedData) ;

//If there's no data then show a pretty error message
if( empty($FBdata->data) ) {
	$mpl_content = '';
	        if( isset($FBdata->error->message) ) $mpl_content .= 'Error: ' . $FBdata->error->message;
            if( isset($FBdata->error->type) ) $mpl_content .= '<br />Type: ' . $FBdata->error->type;
            if( isset($FBdata->error->code) ) $mpl_content .= '<br />Code: ' . $FBdata->error->code;
            if( isset($FBdata->error->error_subcode) ) $mpl_content .= '<br />Subcode: ' . $FBdata->error->error_subcode;

            if( isset($FBdata->error_msg) ) $mpl_content .= 'Error: ' . $FBdata->error_msg;
            if( isset($FBdata->error_code) ) $mpl_content .= '<br />Code: ' . $FBdata->error_code;
            
            if($FBdata == null) $mpl_content .= 'Error: Server configuration issue';

            if( empty($FBdata->error) && empty($FBdata->error_msg) && $FBdata !== null ) $mpl_content .= 'Error: No posts available for this Facebook ID';
	$output .= '<div class="mpl-fb-error-message">'.$mpl_content.'</div>';
}
	
// Start Building HTML
$mpl_final_post_text = ''; 
$mpl_final_post_text_item_wrapper = '';
$mpl_final_post_text_item_wrapper_complete = '';		
$mpl_post_item = '';
if( !empty($FBdata->data) ) {
foreach($FBdata->data as $post){
	            $mpl_post_type = $post->type;
				isset($post->link) ? $link = htmlspecialchars($post->link) : $link = '';
				$PostID = '';
                $mpl_post_id = '';
				if( isset($post->id) ){
                $mpl_post_id = $post->id;
                $PostID = explode("_", $mpl_post_id);
                }   
				//POST AUTHOR
				$mpl_author = '<div class="mpl-fb-author">';
				//Author text
                $mpl_author .= '<a href="https://facebook.com/' . $post->from->id . '" target="_blank" title="'.$post->from->name.'">';
				$mpl_author .= '<div class="mpl-fb-author-text">';
                $mpl_author .= '<p class="mpl-fb-page-name">'.$post->from->name.'</p>';
				if(isset($post->updated_time) && $post->updated_time !=='' ){
					$time = strtotime($post->updated_time);
					if($date_format == 'default'){
						$mpl_author .= '<p class="mpl-fb-date">'.mpl_facebook_default_time($time).' ago</p>';
						}else{	
						$mpl_author .= '<p class="mpl-fb-date">'.date_i18n($date_format,$time).'</p>';
							}
					
					}
					
                $mpl_author .= '</div>';
				//Author image
                //Set the author image as a variable. If it already exists then don't query the api for it again.
				$author_image_url  = 'https://graph.facebook.com/' . $post->from->id . '/picture?type=small';
				if($author_image_url !== '')
				$mpl_author .= '<div class="mpl-fb-author-img"><img src="'.$author_image_url.'" title="'.$post->from->name.'" alt="'.$post->from->name.'" width=40 height=40></div>';
				
                $mpl_author .= '</a></div>'; 
				//POST TEXT
				$mpl_post_text = '<div class="mpl-fb-post-text">';
				
				$mpl_post_text .= '<span class="mpl-fb-text">';

                $mpl_post_text_type = '';
                $post_text = '';
                if (!empty($post->story)) {
                    $post_text = htmlspecialchars($post->story);
                    $mpl_post_text_type = 'story';
                }
                if (!empty($post->message)) {
                    $post_text = htmlspecialchars($post->message);
                    $mpl_post_text_type = 'message';
                }
                if (!empty($post->name) && empty($post->story) && empty($post->message)) {
                    $post_text = htmlspecialchars($post->name);
                    $mpl_post_text_type = 'name';
                }
                //Add message and story tags if there are any and the post text is the message or the story
                if(( isset($post->message_tags) || isset($post->story_tags) ) && ($mpl_post_text_type == 'message' || $mpl_post_text_type == 'story')){
                    
                    ( isset($post->message_tags) )? $text_tags = $post->message_tags : $text_tags = $post->story_tags;
                    if( ( $mpl_post_text_type == 'message' && isset($post->message_tags) ) || ( $mpl_post_text_type == 'story' && !isset($post->message_tags) ) ) {
                        $mpl_html_check_array = array('&lt;', '’', '“', '&quot;', '&amp;', '&gt;&gt;', '&gt;');
                        if( mpl_stripos_arr($post_text, $mpl_html_check_array) !== false ) {
							
                            foreach($text_tags as $message_tag ) {

                                ( isset($message_tag->id) ) ? $message_tag = $message_tag : $message_tag = $message_tag[0];

                                $tag_name = $message_tag->name;
                                $tag_link = '<a href="http://facebook.com/' . $message_tag->id . '" style="color: #'.$mpl_posttext_link_color.';" target="_blank">' . $message_tag->name . '</a>';

                                $post_text = str_replace($tag_name, $tag_link, $post_text);
                            }

                        } else {
                        //If it doesn't contain HTMl tags then use the offset to replace message tags
                            $message_tags_arr = array();

                            $i = 0;
                            foreach($text_tags as $message_tag ) {
                                $i++;

                                ( isset($message_tag->id) ) ? $message_tag = $message_tag : $message_tag = $message_tag[0];

                                $message_tags_arr[$i] = array(
                                        'id' => $message_tag->id,
                                        'name' => $message_tag->name,
                                        'type' => isset($message_tag->type) ? $message_tag->type : '',
                                        'offset' => $message_tag->offset,
                                        'length' => $message_tag->length
                                    );
                            }

                            for($i = count($message_tags_arr); $i >= 1; $i--) {

                                //If the name is blank (aka the story tag doesn't work properly) then don't use it
                                if( $message_tags_arr[$i]['name'] !== '' ) {
                               
                                    if( $mpl_post_text_type == 'story' && $message_tags_arr[$i]['type'] == 'event' ){
                                        //Don't use the story tag in this case otherwise it changes '__ created an event' to '__ created an Name Of Event'
                                    } else {
                                        $b = '<a href="http://facebook.com/' . $message_tags_arr[$i]['id'] . '">' . $message_tags_arr[$i]['name'] . '</a>';
                                        $c = $message_tags_arr[$i]['offset'];
                                        $d = $message_tags_arr[$i]['length'];

                                        $post_text = mpl_mff_substr_replace( $post_text, $b, $c, $d);
                                    }

                                }

                            } 

                        } 

                    } 

                } 

                //Replace line breaks in text (needed for IE8)
                $post_text = preg_replace("/\r\n|\r|\n/",'<br/>', $post_text);
                
                $mpl_post_text .= $post_text;
				$mpl_post_text .= '</span>';
				$mpl_post_text .= '</div>';
                //DESCRIPTION
				$mpl_description = '';
				$description_text = '';
				if ( !empty($post->description)  || !empty($post->caption) ) {

                    $description_text = '';
                    if ( !empty($post->description) ) {
                        $description_text = $post->description;
                    } else {
                        $description_text = $post->caption;
                    }
					
                    $mpl_description .= '<p class="mpl-fb-post-desc"><span>' .  htmlspecialchars($description_text). ' </span></p>';

                    //If the post text and description/caption are the same then don't show the description
                    if($post_text == $description_text) $mpl_description = '';

                    if( $mpl_post_type == 'event' ) $mpl_description = '';
                }
				
			  //Link Type Html
			  $mpl_shared_link = '';
                //Display shared link
                if ($mpl_post_type == 'link') {
                    $mpl_shared_link .= '<div class="mpl-fb-shared-link">';
                    if (!empty($post->description)) {
                        $mpl_shared_link .= '<div class="mpl-fb-text-link">';
                        //The link title:
                        $mpl_shared_link .= '<p class="mpl-fb-link-title"><a href="'.$link.'" target="_blank" >'. $post->name . '</a></p>';
                        //The link source:
                        (!empty($post->caption)) ? $mpl_link_caption = $post->caption : $mpl_link_caption = '';
                        if(!empty($mpl_link_caption)) $mpl_shared_link .= '<p class="mpl-fb-link-caption">'.$mpl_link_caption.'</p>';
                        if( $description_text != $mpl_link_caption ) $mpl_shared_link .= $mpl_description;
                        $mpl_shared_link .= '</div>';
                    }

                    $mpl_shared_link .= '</div>';
                }	
			//EVENT	Type Html
                $mpl_event = '';
                    //Check for media
                    if ($mpl_post_type == 'event') {
						$mpl_event_date = '';
                        $event_url = parse_url($link);
                        $url_parts = explode('/', $event_url['path']);
                        $eventID = $url_parts[count($url_parts)-2];

                        //Facebook changed the event link from absolute to relative, and so if the link isn't absolute then add facebook.com to front
                        ( stripos($link, 'facebook.com') ) ? $link = $link : $link = 'https://facebook.com' . $link;
                        
                        //Get the contents of the event using the WP HTTP API
                        $event_json_url = 'https://graph.facebook.com/'.$eventID.'?access_token=' . $access_token;
                        $event_json = mpl_mff_fetchUrl($event_json_url);
                        $event_object = json_decode($event_json);

                        //Event date
                        $event_time = $event_object->start_time;
						$event_end_time = '';
                        if(isset($event_object->end_time)){
							$end_time = strtotime($event_object->end_time);
							$event_end_time = ' - '.mpl_mff_eventdate($endtime);
									
						}
                        //If timezone migration is enabled then remove last 5 characters
                        if ( strlen($event_time) == 24 ) $event_time = substr($event_time, 0, -5);
                        if (!empty($event_time)) $mpl_event_date = '<p class="mpl-fb-date">' . mpl_mff_eventdate(strtotime($event_time), $date_format) .$event_end_time.'</p>';
						
                        //Display the event details
                        $mpl_event .= '<div class="mpl-fb-details">';
                        $mpl_event .= $mpl_event_date;
                        if (!empty($event_object->name)) {
                            $mpl_event .= '<a href="'.$link.'" target="_blank">';
                            $mpl_event .= '<p>' . $event_object->name . '</p>';
                            $mpl_event .= '</a>';
                        }                      
                        //Show event details
                        if (!empty($event_object->location)) $mpl_event .= '<p class="mpl-fb-location">' . $event_object->location . '</p>';
                            //Description
                            if (!empty($event_object->description)){
                                $description = $event_object->description;
                                $mpl_event .= '<p class="mpl-fb-info">' . $description . '</p>';
                            }
                        $mpl_event .= '</div>';
                        
                    }
                // Video Type Html

                //Check to see whether it's an embedded video so that we can show the name above the post text if necessary
                $mpl_is_video_embed = false;
                if ($post->type == 'video'){
                    $url = $post->source;
                    $youtube = 'youtube';
                    $youtu = 'youtu';
                    $vimeo = 'vimeo';
                    $youtubeembed = 'youtube.com/embed';
                    $youtube = stripos($url, $youtube);
                    $youtu = stripos($url, $youtu);
                    $youtubeembed = stripos($url, $youtubeembed);
                    if($youtube || $youtu || $youtubeembed || (stripos($url, $vimeo) !== false)) {
                        $mpl_is_video_embed = true;
                    }
                }
                $mpl_media = '';
                if ($post->type == 'video') {
                    if($mpl_is_video_embed) {
                        isset($post->name) ? $video_name = $post->name : $video_name = $link;
                        isset($post->description) ? $description_text = $post->description : $description_text = '';
                        //Add the 'cff-shared-link' class so that embedded videos display in a box
                        $mpl_description = '<div class="mpl-fb-desc-wrap mpl-fb-shared-link">';

                        if( isset($post->name) ) $mpl_description .= '<p class="mpl-fb-link-title"><a href="'.$link.'" target="_blank">'. $post->name . '</a></p>';
                        $mpl_description .= '<p class="mpl-fb-post-desc" ><span>' . htmlspecialchars($description_text) . '</span></p></div>';
                    } else {
                        isset($post->name) ? $video_name = $post->name : $video_name = $link;
                        if( isset($post->name) ) $mpl_description .= '<p class="mpl-fb-link-title"><a href="'.$link.'" target="_blank">'. $post->name . '</a></p>';
                    }
                }


                //Display the link to the Facebook post or external link
                $mpl_link = '';
                
                $link_text = 'View on Facebook';

                //Link to the Facebook post if it's a link or a video
                if($mpl_post_type == 'link' || $mpl_post_type == 'video') $link = "https://www.facebook.com/" . $page_id . "/posts/" . $PostID[1];

                //Social media sharing URLs
                $mpl_share_facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($link);
                $mpl_share_twitter = 'https://twitter.com/intent/tweet?text=' . urlencode($link);
                $mpl_share_google = 'https://plus.google.com/share?url=' . urlencode($link);
                $mpl_share_linkedin = 'https://www.linkedin.com/shareArticle?mini=true&amp;url=' . urlencode($link) . '&amp;title=' . rawurlencode( strip_tags($mpl_post_text) );
                $mpl_share_email = 'mailto:?subject=Facebook&amp;body=' . urlencode($link) . '%20-%20' . rawurlencode( strip_tags($mpl_post_text) );

                //If it's a shared post then change the link to use the Post ID so that it links to the shared post and not the original post that's being shared
                if( isset($post->status_type) ){
                    if( $post->status_type == 'shared_story') $link = "https://www.facebook.com/" . $mpl_post_id;
                }

                //If it's an offer post then change the text
                if ($mpl_post_type == 'offer') $link_text = 'View Offer';

                //Create post action links HTML
                $mpl_link = '';
				$mpl_show_facebook_link = true;
				$mpl_show_facebook_share = true;
                if($mpl_show_facebook_link || $mpl_show_facebook_share){
                    $mpl_link .= '<div class="mpl-fb-post-links">';
                    //View on Facebook link
                    if($mpl_show_facebook_link) $mpl_link .= '<a class="" href="' . $link . '" title="' . $link_text . '" target="_blank">' . $link_text . '</a>';

                    //Share link
                    if($mpl_show_facebook_share){
                        $mpl_link .= '<div class="mpl-fb-share-container">';
                        //Only show separating dot if both links are enabled
                        if($mpl_show_facebook_link) $mpl_link .= '<span class="mpl-fb-dot">&nbsp;&middot;&nbsp;</span>';
                        $mpl_link .= '<a class="mpl-fb-share-link" href="javascript:void(0);" title="Share">Share</a>';
                        $mpl_link .= "<p class='mpl-fb-share-tooltip'><a href='".$mpl_share_facebook."' target='_blank' class='cff-facebook-icon'><i class='fa fa-facebook-square'></i></a><a href='".$mpl_share_twitter."' target='_blank' class='cff-twitter-icon'><i class='fa fa-twitter'></i></a><a href='".$mpl_share_google."' target='_blank' class='cff-google-icon'><i class='fa fa-google-plus'></i></a><a href='".$mpl_share_linkedin."' target='_blank' class='cff-linkedin-icon'><i class='fa fa-linkedin'></i></a><a href='".$mpl_share_email."' target='_blank' class='cff-email-icon'><i class='fa fa-envelope'></i></a><i class='fa fa-play fa-rotate-90'></i></p></div>";
                    }
                    
                    $mpl_link .= '</div>'; 
                }


                /* MEDIA LINK */
				
                /*if (!isset($mpl_translate_photo_text) || empty($mpl_translate_photo_text)) $mpl_translate_photo_text = 'Photo';
                if (!isset($mpl_translate_video_text) || empty($mpl_translate_video_text)) $mpl_translate_video_text = 'Video';

                $mpl_media_link = '';
                if($mpl_post_type == 'photo' || $mpl_post_type == 'video' ){
                    $mpl_media_link .= '<p class="mpl-fb-media-link"><a href="'.$link.'" target="_blank"><i style="padding-right: 5px;" class="fa fa-';
                    if($mpl_post_type == 'photo') $mpl_media_link .=  'picture-o"></i>'. $mpl_translate_photo_text;
                    // if($mpl_post_type == 'video') $mpl_media_link .=  'file-video-o';
                    if($mpl_post_type == 'video') $mpl_media_link .=  'video-camera"></i>'. $mpl_translate_video_text;
                    $mpl_media_link .= '</a></p>';
                }*/


                //**************************//
                //***CREATE THE POST HTML***//
                //**************************//
                //Start the container
				/*if($style == "no") $mpl_post_item .= '<li class="mpl-fb-isotope-list">';
				$mpl_post_item .= '<div class="mpl-fb-item ';
                if ($mpl_post_type == 'link') $mpl_post_item .= 'mpl-fb-link-item';
                if ($mpl_post_type == 'event') $mpl_post_item .= 'mpl-fb-timeline-event';
                if ($mpl_post_type == 'photo') $mpl_post_item .= 'mpl-fb-photo-post';
                if ($mpl_post_type == 'video') $mpl_post_item .= 'mpl-fb-video-post';
                if ($mpl_post_type == 'swf') $mpl_post_item .= 'mpl-fb-swf-post';
                if ($mpl_post_type == 'status') $mpl_post_item .= 'mpl-fb-status-post';
                if ($mpl_post_type == 'offer') $mpl_post_item .= 'mpl-fb-offer-post';          
                $mpl_post_item .=  ' author-'. strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-',$post->from->name))) .'" id="mpl_mff_'. $mpl_post_id .'">';
                
                    //POST AUTHOR
                    $mpl_post_item .= $mpl_author;
                    //POST TEXT
                    $mpl_post_item .= $mpl_post_text;
                    //DESCRIPTION
                    if($mpl_post_type != 'offer' && $mpl_post_type != 'link') $mpl_post_item .= $mpl_description;
                    //LINK
                    $mpl_post_item .= $mpl_shared_link;
                    //DATE BELOW
                    //$mpl_post_item .= $mpl_date;
                    //EVENT
                    $mpl_post_item .= $mpl_event;
                    //DATE BELOW (only for Event posts)   
                    if($mpl_post_type == 'event') $mpl_post_item .= $mpl_date;

                    //MEDIA LINK
                    $mpl_post_item .= $mpl_media_link;
                    //VIEW ON FACEBOOK LINK
                    $mpl_post_item .= $mpl_link;
                
                //End the post item
                $mpl_post_item .= '</div>';
				if($style == "no") $mpl_post_item .= '</li>';
	
	}
if($style == "no"):
$output .= '<div class="mpl-fb-feed">
                <ul class="mpl-list-md-'.$columns.' mpl-list-sm-2 mpl-fb-isotope">'.$mpl_post_item.'</ul>
			</div>';
else:
$output .= '<div class="mpl-fb-feed mpl-fb-carousel owl-carousel" data-items="'.$columns.'">
                '.$mpl_post_item.'
			</div>';
endif;	

}
$output .= '</div>
   </div>';
$output .= $video_background;   
$output .= '</section>';
echo $output;*/