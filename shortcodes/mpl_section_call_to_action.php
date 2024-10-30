<?php

$output = $wrap_class  = $css = $btn_link_url = $btn_link_title = $btn_link_target = '';

$section_subtitle = '';
$section_title    = '';
$content      = '';
$text_align       = '';
$btn_text     = '';
$btn_link     = '';
$btn_position = '';
$action_content = '';
$action_button  = '';

extract($atts);

$element_attributes = array();

$el_classes = apply_filters( 'mpl-el-class', $atts );
$video_background = apply_filters('mpl-video-background', $atts);

$btn_position = $btn_position !== "" ? $btn_position : 'right' ; 

if ( !empty( $btn_link ) ) {
	$link_arr = explode( "|", $btn_link );

	if ( !empty( $link_arr[0] ) )
		$btn_link_url = $link_arr[0];

	if ( !empty( $link_arr[1] ) )
		$btn_link_title = $link_arr[1];

	if ( !empty( $link_arr[2] ) )
		$btn_link_target = $link_arr[2];
	
}
					
/*function data*/
$data = (object)array(
	'section_class'    => implode(' ', $el_classes),
	'section_id'       =>  esc_attr( $atts['section_id'] ),
	'title'            => $title,
	'text_align'	   => $text_align,
	'btn_text' 		   => $btn_text,
	'btn_link_url' 	   => $btn_link_url,
	'btn_link_target'  => $btn_link_target,
	'content' 	       => $content,
	'video_background' => $video_background, 
);
			
switch($btn_position){
case 'top' :
	mpl_tpl_section_call_to_action_style3($data);
	break;
case 'bottom' :
	mpl_tpl_section_call_to_action_style4($data);
	break;
case 'left' :
	mpl_tpl_section_call_to_action_style1($data);
	break;
case 'right' :
	mpl_tpl_section_call_to_action_style2($data);
	break;
default :
	mpl_tpl_section_call_to_action_style1($data);										                    
	break;
}							
