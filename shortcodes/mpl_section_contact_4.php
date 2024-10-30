<?php
$section_subtitle = '';
$section_title    = '';
$desc             = '';
$button_text      = '';

$i18n_s1          = __('Name', 'mageewp-page-layout');
$i18n_s2          = __('Email', 'mageewp-page-layout');
$i18n_s3          = __('Subject', 'mageewp-page-layout');
$i18n_s4          = __('Message', 'mageewp-page-layout');
$i18n_s5          = __('Submit', 'mageewp-page-layout');
$i18n_s6          = __('Send Us A Message', 'mageewp-page-layout');

extract($atts);
$el_classes = apply_filters( 'mpl-el-class', $atts );
$video_background = apply_filters('mpl-video-background', $atts);
if( $contact_receiver == '' )
	$contact_receiver = $contact_email;
/**/
$data = array(
	'section_class'    => implode(' ', $el_classes),
	'section_id'       =>  esc_attr( $atts['section_id'] ),
	'section_title'    => $section_title,
	'section_subtitle' => $section_subtitle,
	'contact_name'     => $contact_info_title,
	'contact_address'  => $contact_address,
	'contact_email'    => $contact_email,
	'contact_phone'    => $contact_phone,
	'contact_receiver' => $contact_receiver,
	'video_background' => $video_background,
	'button_text'      => $button_text,
	'i18n_s1'          => $i18n_s1,
	'i18n_s2'          => $i18n_s2,
	'i18n_s3'          => $i18n_s3,
	'i18n_s4'          => $i18n_s4,
	'i18n_s5'          => $i18n_s5,
);
$data = (object)$data;

/*Call Template Function*/
mpl_tpl_contact_style_4($data);

/*End Call Template*/

