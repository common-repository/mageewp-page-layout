<?php
/*TMODJS:{"version":"1.0.0"}*/
/*v:1*/
function mpl_tpl_contact_style_1($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$contact_address = $data->contact_address;
$contact_email = $data->contact_email;
$contact_phone = $data->contact_phone;
$i18n_s1 = $data->i18n_s1;
$i18n_s2 = $data->i18n_s2;
$i18n_s3 = $data->i18n_s3;
$i18n_s4 = $data->i18n_s4;
$i18n_s5 = $data->i18n_s5;
$button_text = $data->button_text;
$contact_receiver = $data->contact_receiver;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-contact-1 ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-contact style1"> <div class="mpl-contact-inner"> <ul class="mpl-contact-info"> ';
if ($contact_address !== "") {
$out .= ' <li> <i class="fa fa-map-marker"></i> <address>';
$out .= $contact_address;
$out .= '</address> </li> ';
}
$out .= ' ';
if ($contact_email !== "") {
$out .= ' <li> <i class="fa fa-envelope-o"></i> <a href="mailto:';
$out .= $contact_email;
$out .= '">';
$out .= $contact_email;
$out .= '</a> </li> ';
}
$out .= ' ';
if ($contact_phone !== "") {
$out .= ' <li> <i class="fa fa-mobile"></i> ';
$out .= $contact_phone;
$out .= ' </li> ';
}
$out .= ' </ul> <form action="" class="mpl-contact-form"> <div class="mpl-form-group"> <label for="name" class="mpl-control-label">';
$out .= $i18n_s1;
$out .= '</label> <input type="text" class="mpl-form-control" id="name" placeholder="';
$out .= $i18n_s1;
$out .= ' *"> </div> <div class="mpl-form-group"> <label for="email" class="mpl-control-label sr-only">';
$out .= $i18n_s2;
$out .= '</label> <input type="email" class="mpl-form-control" id="email" placeholder="';
$out .= $i18n_s2;
$out .= ' *"> </div> <div class="mpl-form-group"> <label for="subject" class="mpl-control-label sr-only">';
$out .= $i18n_s3;
$out .= '</label> <input type="text" class="mpl-form-control" id="subject" placeholder="';
$out .= $i18n_s3;
$out .= '"> </div> <div class="mpl-form-group"> <label class="mpl-control-label" for="message">';
$out .= $i18n_s3;
$out .= '</label> <textarea name="message" id="message" required aria-required="true" rows="3" placeholder="';
$out .= $i18n_s4;
$out .= ' *" class="mpl-form-control" style="resize:none;"></textarea> </div> <div class="mpl-form-group"> <div class="mpl-contact-failed" style="float:left;"></div> <label class="mpl-control-label" for="submit">';
$out .= $i18n_s5;
$out .= '</label> <input type="submit" value="';
$out .= $button_text;
$out .= '" id="submit"> <input type="hidden" name="receiver" id="receiver" value="';
$out .= $contact_receiver;
$out .= '"> </div> </form> </div> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_contact_style_4($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$contact_address = $data->contact_address;
$contact_email = $data->contact_email;
$contact_phone = $data->contact_phone;
$i18n_s1 = $data->i18n_s1;
$i18n_s2 = $data->i18n_s2;
$i18n_s3 = $data->i18n_s3;
$i18n_s4 = $data->i18n_s4;
$i18n_s5 = $data->i18n_s5;
$button_text = $data->button_text;
$contact_receiver = $data->contact_receiver;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-contact-4 ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-contact style4"> <ul class="mpl-list-md-3"> <li> <ul class="mpl-contact-info"> ';
if ($contact_address !== "") {
$out .= ' <li> <i class="fa fa-map-marker"></i> <address >';
$out .= $contact_address;
$out .= '</address> </li> ';
}
$out .= ' ';
if ($contact_email !== "") {
$out .= ' <li> <i class="fa fa-envelope-o"></i> <a href="mailto:';
$out .= $contact_email;
$out .= '" >';
$out .= $contact_email;
$out .= '</a> </li> ';
}
$out .= ' ';
if ($contact_phone !== "") {
$out .= ' <li> <i class="fa fa-mobile"></i> ';
$out .= $contact_phone;
$out .= ' </li> ';
}
$out .= ' </ul> </li> <li class="mpl-2x"> <form action="" class="mpl-contact-form"> <ul class="mpl-list-md-2"> <li> <div class="mpl-form-group"> <label for="name" class="mpl-control-label">';
$out .= $i18n_s1;
$out .= '</label> <input type="text" class="mpl-form-control" id="name" placeholder="';
$out .= $i18n_s1;
$out .= ' *"> </div> <div class="mpl-form-group"> <label for="email" class="mpl-control-label sr-only">';
$out .= $i18n_s2;
$out .= '</label> <input type="email" class="mpl-form-control" id="email" placeholder="';
$out .= $i18n_s2;
$out .= ' *"> </div> <div class="mpl-form-group"> <label for="subject" class="mpl-control-label sr-only">';
$out .= $i18n_s3;
$out .= '</label> <input type="text" class="mpl-form-control" id="subject" placeholder="';
$out .= $i18n_s3;
$out .= '"> </div> </li> <li> <div class="mpl-form-group"> <label class="mpl-control-label" for="message">';
$out .= $i18n_s3;
$out .= '</label> <textarea name="message" id="message" required aria-required="true" rows="4" placeholder="';
$out .= $i18n_s4;
$out .= ' *" class="mpl-form-control" style="resize:none;"></textarea> </div> <div class="mpl-form-group"> <div class="mpl-contact-failed" style="padding-bottom:15px;"></div> <label class="mpl-control-label" for="submit">';
$out .= $i18n_s5;
$out .= '</label> <input type="submit" value="';
$out .= $button_text;
$out .= '" id="submit"> <input type="hidden" name="receiver" id="receiver" value="';
$out .= $contact_receiver;
$out .= '"> </div> </li> </ul> </form> </li> </ul> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_contact_style_5($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$contact_name = $data->contact_name;
$contact_address = $data->contact_address;
$contact_email = $data->contact_email;
$contact_phone = $data->contact_phone;
$i18n_s6 = $data->i18n_s6;
$i18n_s1 = $data->i18n_s1;
$i18n_s2 = $data->i18n_s2;
$i18n_s3 = $data->i18n_s3;
$i18n_s4 = $data->i18n_s4;
$i18n_s5 = $data->i18n_s5;
$button_text = $data->button_text;
$contact_receiver = $data->contact_receiver;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-contact-5 ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-contact style5"> <ul class="mpl-list-md-3 full"> <li> <ul class="mpl-contact-info"> ';
if ($contact_name !== "") {
$out .= ' <h3 class="title">';
$out .= $contact_name;
$out .= '</h3> ';
}
$out .= ' ';
if ($contact_address !== "") {
$out .= ' <li> <i class="fa fa-map-marker"></i> <address>';
$out .= $contact_address;
$out .= '</address> </li> ';
}
$out .= ' ';
if ($contact_email !== "") {
$out .= ' <li> <i class="fa fa-envelope-o"></i> <a href="mailto:';
$out .= $contact_email;
$out .= '">';
$out .= $contact_email;
$out .= '</a> </li> ';
}
$out .= ' ';
if ($contact_phone !== "") {
$out .= ' <li > <i class="fa fa-mobile"></i> ';
$out .= $contact_phone;
$out .= ' </li> ';
}
$out .= ' </ul> </li> <li class="mpl-2x"> <form action="" class="mpl-contact-form"> <h3 class="title">';
$out .= $i18n_s6;
$out .= '</h3> <ul class="mpl-list-md-2"> <li> <div class="mpl-form-group"> <label for="name" class="mpl-control-label sr-only">';
$out .= $i18n_s1;
$out .= '</label> <input type="text" class="mpl-form-control" id="name" placeholder="';
$out .= $i18n_s1;
$out .= ' *"> </div> </li> <li> <div class="mpl-form-group"> <label for="email" class="mpl-control-label sr-only">';
$out .= $i18n_s2;
$out .= '</label> <input type="email" class="mpl-form-control" id="email" placeholder="';
$out .= $i18n_s2;
$out .= ' *"> </div> </li> <li class="mpl-2x"> <div class="mpl-form-group"> <label for="subject" class="mpl-control-label sr-only">';
$out .= $i18n_s3;
$out .= '</label> <input type="text" class="mpl-form-control" id="subject" placeholder="';
$out .= $i18n_s3;
$out .= '"> </div> </li> <li class="mpl-2x"> <div class="mpl-form-group"> <label class="mpl-control-label sr-only" for="message">';
$out .= $i18n_s3;
$out .= '</label> <textarea name="message" id="message" required aria-required="true" rows="3" placeholder="';
$out .= $i18n_s4;
$out .= ' *" class="mpl-form-control" style="resize:none;"></textarea> </div> </li> <li class="mpl-2x text-right"> <div class="mpl-form-group"> <div class="mpl-contact-failed" style="padding-bottom:15px;"></div> <label class="mpl-control-label sr-only" for="submit">';
$out .= $i18n_s5;
$out .= '</label> <input type="submit" value="';
$out .= $button_text;
$out .= '" id="submit"> <input type="hidden" name="receiver" id="receiver" value="';
$out .= $contact_receiver;
$out .= '"> </div> </li> </ul> </form> </li> </ul> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_banner($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$fullheight = $data->fullheight;
$section_id = $data->section_id;
$content_align = $data->content_align;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$title_style = $data->title_style;
$btn_text_1 = $data->btn_text_1;
$btn_text_2 = $data->btn_text_2;
$link_url_1 = $data->link_url_1;
$link_target_1 = $data->link_target_1;
$link_url_2 = $data->link_url_2;
$link_target_2 = $data->link_target_2;
$enable_social_icon = $data->enable_social_icon;
$social_icons = $data->social_icons;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-banner ';
$out .= $section_class;
$out .= ' ';
$out .= $fullheight;
$out .= ' mpl-verticalmiddle mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content ';
$out .= $content_align;
$out .= '"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap ';
$out .= $content_align;
$out .= '"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title ';
$out .= $title_style;
$out .= '"><span>';
$out .= $section_title;
$out .= '</span></h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle ';
$out .= $content_align;
$out .= '">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
if ($btn_text_1 !== "" || $btn_text_2 !== "") {
$out .= ' <div class="mpl-button-group"> ';
if ($btn_text_1 !== "") {
$out .= ' <a href="';
$out .= $link_url_1;
$out .= '" target="';
$out .= $link_target_1;
$out .= '"><span class="mpl-btn-normal btn-lg">';
$out .= $btn_text_1;
$out .= '</span></a> ';
}
$out .= ' ';
if ($btn_text_2 !== "") {
$out .= ' <a href="';
$out .= $link_url_2;
$out .= '" target="';
$out .= $link_target_2;
$out .= '"><span class="mpl-btn-normal light btn-lg">';
$out .= $btn_text_2;
$out .= '</span></a> ';
}
$out .= ' </div> ';
}
$out .= ' ';
if ($enable_social_icon !== "") {
$out .= ' <ul class="mpl-social-icons"> ';
foreach ( $social_icons as $value ) {
$out .= ' <li><a href="';
$out .= $value->link_url;
$out .= '" target="';
$out .= $value->link_target;
$out .= '" title="';
$out .= $value->link_title;
$out .= '"> <i class="fa ';
$out .= $value->icon;
$out .= '"></i></a> </li> ';
}
$out .= ' </ul> ';
}
$out .= ' </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_call_to_action_style1($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$text_align = $data->text_align;
$btn_text = $data->btn_text;
$btn_link_url = $data->btn_link_url;
$btn_link_target = $data->btn_link_target;
$title = $data->title;
$content = $data->content;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-call-to-action ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> <div class="mpl-section-content-wrap"> <div class="mpl-action-box text-';
$out .= $text_align;
$out .= ' mpl-btn-right"> <div class="mpl-action-box-inner"> ';
if ($btn_text !== "") {
$out .= ' <div class="mpl-action-button"><a href="';
$out .= $btn_link_url;
$out .= '" title="" target="';
$out .= $btn_link_target;
$out .= '"><span class="mpl-btn-normal">';
$out .= $btn_text;
$out .= '</span></a></div> ';
}
$out .= ' <div class="mpl-action-content"> ';
if ($title !== "") {
$out .= ' <div class="mpl-section-title-wrap"> <h2 class="mpl-section-title">';
$out .= $title;
$out .= '</h2> </div> ';
}
$out .= ' ';
if ($content !== "") {
$out .= ' <div class="mpl-action-desc">';
$out .= $content;
$out .= '</div> ';
}
$out .= ' </div> </div> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section> ';
echo $out;
}/*v:1*/
function mpl_tpl_section_call_to_action_style2($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$text_align = $data->text_align;
$title = $data->title;
$content = $data->content;
$btn_text = $data->btn_text;
$btn_link_url = $data->btn_link_url;
$btn_link_target = $data->btn_link_target;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-call-to-action ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> <div class="mpl-section-content-wrap"> <div class="mpl-action-box text-';
$out .= $text_align;
$out .= ' mpl-btn-left"> <div class="mpl-action-box-inner"> <div class="mpl-action-content"> ';
if ($title !== "") {
$out .= ' <div class="mpl-section-title-wrap"> <h2 class="mpl-section-title">';
$out .= $title;
$out .= '</h2> </div> ';
}
$out .= ' ';
if ($content !== "") {
$out .= ' <div class="mpl-action-desc">';
$out .= $content;
$out .= '</div> ';
}
$out .= ' </div> ';
if ($btn_text !== "") {
$out .= ' <div class="mpl-action-button"><a href="';
$out .= $btn_link_url;
$out .= '" title="" target="';
$out .= $btn_link_target;
$out .= '"><span class="mpl-btn-normal">';
$out .= $btn_text;
$out .= '</span></a></div> ';
}
$out .= ' </div> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section> ';
echo $out;
}/*v:1*/
function mpl_tpl_section_call_to_action_style3($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$text_align = $data->text_align;
$btn_text = $data->btn_text;
$btn_link_url = $data->btn_link_url;
$btn_link_target = $data->btn_link_target;
$title = $data->title;
$content = $data->content;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-call-to-action ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> <div class="mpl-section-content-wrap"> <div class="mpl-action-box text-';
$out .= $text_align;
$out .= ' mpl-btn-top"> <div class="mpl-action-box-inner"> ';
if ($btn_text !== "") {
$out .= ' <div class="mpl-action-button"><a href="';
$out .= $btn_link_url;
$out .= '" title="" target="';
$out .= $btn_link_target;
$out .= '"><span class="mpl-btn-normal">';
$out .= $btn_text;
$out .= '</span></a></div> ';
}
$out .= ' <div class="mpl-action-content"> ';
if ($title !== "") {
$out .= ' <div class="mpl-section-title-wrap"> <h2 class="mpl-section-title">';
$out .= $title;
$out .= '</h2> </div> ';
}
$out .= ' ';
if ($content !== "") {
$out .= ' <div class="mpl-action-desc">';
$out .= $content;
$out .= '</div> ';
}
$out .= ' </div> </div> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section> ';
echo $out;
}/*v:1*/
function mpl_tpl_section_call_to_action_style4($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$text_align = $data->text_align;
$title = $data->title;
$content = $data->content;
$btn_text = $data->btn_text;
$btn_link_url = $data->btn_link_url;
$btn_link_target = $data->btn_link_target;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-call-to-action ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> <div class="mpl-section-content-wrap"> <div class="mpl-action-box text-';
$out .= $text_align;
$out .= ' mpl-btn-bottom"> <div class="mpl-action-box-inner"> <div class="mpl-action-content"> ';
if ($title !== "") {
$out .= ' <div class="mpl-section-title-wrap"> <h2 class="mpl-section-title">';
$out .= $title;
$out .= '</h2> </div> ';
}
$out .= ' ';
if ($content !== "") {
$out .= ' <div class="mpl-action-desc">';
$out .= $content;
$out .= '</div> ';
}
$out .= ' </div> ';
if ($btn_text !== "") {
$out .= ' <div class="mpl-action-button"><a href="';
$out .= $btn_link_url;
$out .= '" title="" target="';
$out .= $btn_link_target;
$out .= '"><span class="mpl-btn-normal">';
$out .= $btn_text;
$out .= '</span></a></div> ';
}
$out .= ' </div> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section> ';
echo $out;
}/*v:1*/
function mpl_tpl_section_clients($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$carousel = $data->carousel;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$client = $data->client;
$columns = $data->columns;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-clients ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
if ($carousel !== "") {
$out .= ' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
foreach ( $client as $value ) {
$out .= ' ';
if ($value->image !== "") {
$out .= ' <div class="mpl-client text-center"> <a href="';
$out .= $value->link;
$out .= '" target="';
$out .= $value->target;
$out .= '"><img src="';
$out .= $value->image;
$out .= '" alt=""></a> </div> ';
}
$out .= ' ';
}
$out .= ' </div> </div> ';
} else {
$out .= ' <div class="mpl-clients-list"> <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-sm-2 mpl-clients-normal text-center"> ';
foreach ( $client as $value ) {
$out .= ' ';
if ($value->image !== "") {
$out .= ' <li> <a href="';
$out .= $value->link;
$out .= '" target="';
$out .= $value->target;
$out .= '"><img src="';
$out .= $value->image;
$out .= '" alt=""></a> </li> ';
}
$out .= ' ';
}
$out .= ' </ul> </div> ';
}
$out .= ' </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section> ';
echo $out;
}/*v:1*/
function mpl_tpl_section_counter($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$carousel = $data->carousel;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$counter = $data->counter;
$columns = $data->columns;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-counter ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="section_id"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
if ($carousel !== "") {
$out .= ' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel text-center ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
foreach ( $counter as $value ) {
$out .= ' ';
if ($value->number !== "") {
$out .= ' <div class="mpl-counter-box"> <div class="mpl-counter"><span class="mpl-counter-num" >';
$out .= $value->number;
$out .= '</span></div> <h3 class="mpl-counter-title text-center">';
$out .= $value->title;
$out .= '</h3> </div> ';
}
$out .= ' ';
}
$out .= ' </div> </div> ';
} else {
$out .= ' <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-counter"> ';
foreach ( $counter as $value ) {
$out .= ' ';
if ($value->number !== "") {
$out .= ' <li> <div class="mpl-counter-box"> <div class="mpl-counter"><span class="mpl-counter-num" >';
$out .= $value->number;
$out .= '</span></div> <h3 class="mpl-counter-title text-center">';
$out .= $value->title;
$out .= '</h3> </div> </li> ';
}
$out .= ' ';
}
$out .= ' </ul> ';
}
$out .= ' </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section> ';
echo $out;
}/*v:1*/
function mpl_tpl_section_custom($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$content = $data->content;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-custom ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container" data-mpl_name="content"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
$out .= $content;
$out .= ' </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_facebook_feed($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$error = $data->error;
$error_data = $data->error_data;
$carousel = $data->carousel;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$columns = $data->columns;
$fb_data = $data->fb_data;
$i18n_s1 = $data->i18n_s1;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-facebook-feed ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
if ($error !== "") {
$out .= ' <div class="mpl-fb-error-message"> ';
foreach ( $error_data as $val ) {
$out .= ' ';
if ($val->message !== "") {
$out .= ' Error: ';
$out .= $val->message;
$out .= ' ';
}
$out .= ' ';
if ($val->type !== "") {
$out .= ' <br />Type: ';
$out .= $val->type;
$out .= ' ';
}
$out .= ' ';
if ($val->code !== "") {
$out .= ' <br />Code: ';
$out .= $val->code;
$out .= ' ';
}
$out .= ' ';
if ($val->error_subcode !== "") {
$out .= ' <br />Subcode: ';
$out .= $val->error_subcode;
$out .= ' ';
}
$out .= ' ';
if ($val->error_msg !== "") {
$out .= ' Error: ';
$out .= $val->error_msg;
$out .= ' ';
}
$out .= ' ';
if ($val->error_code !== "") {
$out .= ' <br />Code: ';
$out .= $val->error_code;
$out .= ' ';
}
$out .= ' ';
if ($val->configuration !== "") {
$out .= ' ';
$out .= $val->configuration;
$out .= ' ';
}
$out .= ' ';
if ($val->no_post !== "") {
$out .= ' ';
$out .= $val->no_post;
$out .= ' ';
}
$out .= ' ';
}
$out .= ' </div> ';
} else {
$out .= ' ';
if ($carousel !== "") {
$out .= ' <div class="owl-carousel mpl-carousel mpl-fb-feed mpl-fb-carousel ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
} else {
$out .= ' <div class="mpl-fb-feed"> <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-sm-2 mpl-isotope"> ';
}
$out .= ' ';
foreach ( $fb_data as $value ) {
$out .= ' ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' <li class="mpl-isotope-item"> ';
}
$out .= ' <div class="mpl-fb-item ';
$out .= $value->post_type_class;
$out .= ' author-';
$out .= $value->author_id;
$out .= '" id="mpl_mff_';
$out .= $value->post_id;
$out .= '">  <div class="mpl-fb-author"> <a href="https://facebook.com/';
$out .= $value->author_form_id;
$out .= '" target="_blank" title="';
$out .= $value->author_form_name;
$out .= '"> <div class="mpl-fb-author-text"> <p class="mpl-fb-page-name">';
$out .= $value->author_form_name;
$out .= '</p> ';
if ($value->updated_time !== "") {
$out .= ' <p class="mpl-fb-date">';
$out .= $value->author_date;
$out .= '</p> ';
}
$out .= ' </div> ';
if ($value->author_image_url !== "") {
$out .= ' <div class="mpl-fb-author-img"> <img src="';
$out .= $value->author_image_url;
$out .= '" title="';
$out .= $value->author_form_name;
$out .= '" alt="';
$out .= $value->author_form_name;
$out .= '" width=40 height=40> </div> ';
}
$out .= ' </a> </div>  <div class="mpl-fb-post-text"> <span class="mpl-fb-text">';
$out .= $value->post_text;
$out .= '</span> </div>  ';
$out .= $value->description;
$out .= '  ';
$out .= $value->shared_link;
$out .= '  ';
$out .= $value->event;
$out .= '  ';
$out .= $value->media_link;
$out .= '  <div class="mpl-fb-post-links"> <a class="" href="';
$out .= $value->share_link;
$out .= '" title="';
$out .= $value->share_link_text;
$out .= '" target="_blank">';
$out .= $value->share_link_text;
$out .= '</a> <div class="mpl-fb-share-container"> <span class="mpl-fb-dot">&nbsp;&middot;&nbsp;</span> <a class="mpl-fb-share-link" href="javascript:void(0);" title="Share">';
$out .= $i18n_s1;
$out .= '</a> <p class=\'mpl-fb-share-tooltip\'> <a href=\'';
$out .= $value->share_facebook;
$out .= '\' target=\'_blank\' class=\'cff-facebook-icon\'><i class=\'fa fa-facebook-square\'></i></a> <a href=\'';
$out .= $value->share_twitter;
$out .= '\' target=\'_blank\' class=\'cff-twitter-icon\'><i class=\'fa fa-twitter\'></i></a> <a href=\'';
$out .= $value->share_google;
$out .= '\' target=\'_blank\' class=\'cff-google-icon\'><i class=\'fa fa-google-plus\'></i></a> <a href=\'';
$out .= $value->share_linkedin;
$out .= '\' target=\'_blank\' class=\'cff-linkedin-icon\'><i class=\'fa fa-linkedin\'></i></a> <a href=\'';
$out .= $value->share_email;
$out .= '\' target=\'_blank\' class=\'cff-email-icon\'><i class=\'fa fa-envelope\'></i></a> <i class=\'fa fa-play fa-rotate-90\'></i> </p> </div> </div> </div> ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' </li> ';
}
$out .= ' ';
}
$out .= ' ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' </ul> ';
}
$out .= ' </div> ';
}
$out .= ' </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section> ';
echo $out;
}/*v:1*/
function mpl_tpl_section_features($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$features_left = $data->features_left;
$icon_shape = $data->icon_shape;
$feature_image = $data->feature_image;
$features_right = $data->features_right;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-features ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <ul class="mpl-list-md-3"> <li> <div class="mpl-services style2 text-right"> <ul class="mpl-list-md-1"> ';
foreach ( $features_left as $left_val ) {
$out .= ' <li> <div class="mpl-feature-box"> ';
if ($icon_shape !== "") {
$out .= ' <i class="fa ';
$out .= $left_val->icon;
$out .= ' ';
$out .= $icon_shape;
$out .= '" style="background-color:';
$out .= $left_val->icon_color;
$out .= ';"></i> ';
} else {
$out .= ' <i class="fa ';
$out .= $left_val->icon;
$out .= '" style="color:';
$out .= $left_val->icon_color;
$out .= ';"></i> ';
}
$out .= ' <h3 class="title"> ';
if ($left_val->link_url !== "") {
$out .= ' <a href="';
$out .= $left_val->link_url;
$out .= '" class="mpl_title_link" target="';
$out .= $left_val->link_target;
$out .= '">';
$out .= $left_val->title;
$out .= '</a> ';
} else {
$out .= ' ';
$out .= $left_val->title;
$out .= ' ';
}
$out .= ' </h3> <p class="desc">';
$out .= $left_val->description;
$out .= '</p> </div> </li> ';
}
$out .= ' </ul> </div> </li> <li> <img src="';
$out .= $feature_image;
$out .= '" alt=""> </li> <li> <div class="mpl-services style2 text-left"> <ul class="mpl-list-md-1"> ';
foreach ( $features_right as $right_val ) {
$out .= ' <li> <div class="mpl-feature-box"> ';
if ($icon_shape !== "") {
$out .= ' <i class="fa ';
$out .= $right_val->icon;
$out .= ' ';
$out .= $icon_shape;
$out .= '" style="background-color:';
$out .= $right_val->icon_color;
$out .= ';"></i> ';
} else {
$out .= ' <i class="fa ';
$out .= $right_val->icon;
$out .= '" style="color:';
$out .= $right_val->icon_color;
$out .= ';"></i> ';
}
$out .= ' <h3 class="title"> ';
if ($right_val->link_url !== "") {
$out .= ' <a href="';
$out .= $right_val->link_url;
$out .= '" class="mpl_title_link" target="';
$out .= $right_val->link_target;
$out .= '">';
$out .= $right_val->title;
$out .= '</a> ';
} else {
$out .= ' ';
$out .= $right_val->title;
$out .= ' ';
}
$out .= ' </h3> <p class="desc">';
$out .= $right_val->description;
$out .= '</p> </div> </li> ';
}
$out .= ' </ul> </div> </li> </ul> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_gallery($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$container = $data->container;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$carousel = $data->carousel;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$items = $data->items;
$lightbox = $data->lightbox;
$columns = $data->columns;
$out = '';$out .= '<section class="mpl-section-gallery ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="';
$out .= $container;
$out .= '"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
if ($carousel !== "") {
$out .= ' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel text-center ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
foreach ( $items as $value ) {
$out .= ' ';
if ($value->image !== "") {
$out .= ' <div class="portoflio-box"> <div class="portfolio-img-box"> <div class="img-box figcaption-middle text-center fade-in"> <img src="';
$out .= $value->image;
$out .= '" class="feature-img"> ';
if ($lightbox !== "" || $value->link !== "") {
$out .= ' <div class="img-overlay"> <div class="img-overlay-container"> <div class="img-overlay-content"> <div class="img-overlay-icons"> ';
if ($value->link !== "") {
$out .= ' <a href="';
$out .= $value->link;
$out .= '"><i class="fa fa-link"></i></a> ';
} else {
$out .= ' <a href="';
$out .= $value->image;
$out .= '" rel="prettyPhoto[pp_gal]"><i class="fa fa-arrows-alt"></i></a> ';
}
$out .= ' </div> </div> </div> </div> ';
}
$out .= ' </div> </div> </div> ';
}
$out .= ' ';
}
$out .= ' </div> </div> ';
} else {
$out .= ' <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' full"> ';
foreach ( $items as $value ) {
$out .= ' ';
if ($value->image !== "") {
$out .= ' <li> <div class="portoflio-box"> <div class="portfolio-img-box"> <div class="img-box figcaption-middle text-center fade-in"> <img src="';
$out .= $value->image;
$out .= '" class="feature-img"> ';
if ($lightbox !== "" || $value->link !== "") {
$out .= ' <div class="img-overlay"> <div class="img-overlay-container"> <div class="img-overlay-content"> <div class="img-overlay-icons"> ';
if ($value->link !== "") {
$out .= ' <a href="';
$out .= $value->link;
$out .= '"><i class="fa fa-link"></i></a> ';
} else {
$out .= ' <a href="';
$out .= $value->image;
$out .= '" rel="prettyPhoto[pp_gal]"><i class="fa fa-arrows-alt"></i></a> ';
}
$out .= ' </div> </div> </div> </div> ';
}
$out .= ' </div> </div> </div> </li> ';
}
$out .= ' ';
}
$out .= ' </ul> ';
}
$out .= ' </div> </div> </div> </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_google_map($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$container = $data->container;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$embed_map = $data->embed_map;
$out = '';$out .= '<section class="mpl-google-map ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="';
$out .= $container;
$out .= '"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class=\'mpl-google-maps\'> ';
$out .= $embed_map;
$out .= ' </div> </div> </div> </div> </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_html($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$content = $data->content;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-html ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container" data-mpl_name="content"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
$out .= $content;
$out .= ' </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_portfolio($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$container = $data->container;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$carousel = $data->carousel;
$filter = $data->filter;
$i18n_s1 = $data->i18n_s1;
$categories = $data->categories;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$columns = $data->columns;
$full = $data->full;
$posts = $data->posts;
$pagination = $data->pagination;
$out = '';$out .= '<section class="mpl-section-portfolio ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="';
$out .= $container;
$out .= '"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' ';
if ($filter !== "") {
$out .= ' <nav class="mpl-portfolio-list-filter text-center"> <ul> <li class="active"> <span class="mpl-filter" data-filter="iso-filter-all"><a href="javascript:;">';
$out .= $i18n_s1;
$out .= '</a></span> </li> ';
foreach ( $categories as $value ) {
$out .= ' ';
if ($value->name !== "") {
$out .= ' <li> <span class="mpl-filter" data-filter="';
$out .= $value->slug;
$out .= '"><a href="javascript:;">';
$out .= $value->name;
$out .= '</a></span> </li> ';
}
$out .= ' ';
}
$out .= ' </ul> </nav> ';
}
$out .= ' ';
}
$out .= ' ';
if ($carousel !== "") {
$out .= ' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-owl-post-carousel mpl-blog-carousel mpl-blog-grid style1 list-mpl-portfolio-category ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
} else {
$out .= ' <ul class="mpl-portfolio-list-wrap mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-sm-2 mpl-post-carousel-normal ';
$out .= $full;
$out .= '"> ';
}
$out .= ' ';
foreach ( $posts as $value ) {
$out .= ' ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' <li class="mpl-portfolio-box-wrap iso-filter-all ';
$out .= $value->cat_slugs;
$out .= '"> ';
}
$out .= ' <article class="mpl-portfolio-box"> ';
if ($value->thumbnail !== "") {
$out .= ' <div class="mpl-portfolio-image"> <div class="img-box figcaption-middle text-center fade-in"> ';
$out .= $value->thumbnail;
$out .= ' <div class="img-overlay"> <div class="img-overlay-container"> <div class="img-overlay-content"> <h2 class="entry-title">';
$out .= $value->title;
$out .= '</h2> <div class="img-overlay-icons"> <a href="';
$out .= $value->link;
$out .= '"><i class="fa fa-link"></i></a> <a href="';
$out .= $value->featured_image;
$out .= '" rel="prettyPhoto"><i class="fa fa-search"></i></a> </div> </div> </div> </div> </div> </div> ';
}
$out .= ' </article> ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' </li> ';
}
$out .= ' ';
}
$out .= ' ';
if ($carousel !== "") {
$out .= ' </div> </div> ';
} else {
$out .= ' </ul> ';
}
$out .= ' ';
$out .= $pagination;
$out .= ' </div> </div> </div> </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_post($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$carousel = $data->carousel;
$post_type = $data->post_type;
$wrap_class = $data->wrap_class;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$columns = $data->columns;
$posts = $data->posts;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-post ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
if ($carousel !== "") {
$out .= ' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-owl-post-carousel mpl-blog-carousel mpl-blog-grid style1 list-';
$out .= $post_type;
$out .= ' ';
$out .= $wrap_class;
$out .= ' ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
} else {
$out .= ' <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-sm-2 mpl-post-carousel-normal mpl-isotope"> ';
}
$out .= ' ';
foreach ( $posts as $value ) {
$out .= ' ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' <li class="mpl-isotope-item"> ';
}
$out .= ' <article class="item entry-box post-';
$out .= $value->id;
$out .= '"> ';
if ($value->thumbnail !== "") {
$out .= ' <div class="feature-img-box"> <div class="img-box figcaption-middle text-center fade-in"> ';
$out .= $value->thumbnail;
$out .= ' <div class="img-overlay"> <div class="img-overlay-container"> <div class="img-overlay-content"> <div class="img-overlay-icons"> <a href="';
$out .= $value->link;
$out .= '"><i class="fa fa-link"></i></a> <a href="';
$out .= $value->featured_image;
$out .= '" rel="prettyPhoto"><i class="fa fa-search"></i></a> </div> </div> </div> </div> </div> </div> ';
}
$out .= ' <div class="entry-main"> <div class="entry-header"> ';
if ($value->date !== "") {
$out .= ' <div class="entry-meta entry-date"> <span class="date"> <time class="entry-date" datetime="';
$out .= $value->time;
$out .= '">';
$out .= $value->date;
$out .= '</time> </span> </div> ';
}
$out .= ' <h3 class="entry-title"><a href="';
$out .= $value->title_link;
$out .= '">';
$out .= $value->title;
$out .= '</a></h3> </div> <div class="entry-summary">';
$out .= $value->excerpt;
$out .= '</div> </div> <div class="entry-footer"> <ul class="entry-meta"> <li class="entry-author"><i class="fa fa-user"></i>';
$out .= $value->author_link;
$out .= '</li> <li class="entry-catagory"><i class="fa fa-file-o"></i>';
$out .= $value->categories;
$out .= '</li> <li class="entry-comments"><i class="fa fa-comment-o"></i>';
$out .= $value->comments;
$out .= '</li> </ul> </div> </article> ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' </li> ';
}
$out .= ' ';
}
$out .= ' ';
if ($carousel !== "") {
$out .= ' </div> </div> ';
} else {
$out .= ' </ul> ';
}
$out .= ' </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_post_2($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$posts = $data->posts;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-post-2 ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-carousel-wrap full"> <div class="owl-carousel mpl-carousel mpl-blog-carousel mpl-blog-grid style4 ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
foreach ( $posts as $value ) {
$out .= ' <article class="entry-box"> <ul class="mpl-list-md-2 full"> ';
if ($value->thumbnail !== "") {
$out .= ' <li> <div class="feature-img-box"> <img src="';
$out .= $value->featured_image;
$out .= '" class="feature-img"> </div> </li> ';
}
$out .= ' <li> <div class="entry-main"> <div class="entry-header"> <span class="entry-meta entry-date"><i class="fa fa-clock-o"></i> <a href="#">';
$out .= $value->date;
$out .= '</a></span> <span class="entry-meta entry-author"><i class="fa fa-user"></i> <a href="#">';
$out .= $value->author_link;
$out .= '</a></span> </div> <h3 class="entry-title"><a href="#">';
$out .= $value->title;
$out .= '</a></h3> <div class="entry-summary">';
$out .= $value->excerpt;
$out .= '</div> <div class="entry-footer"> <span class="entry-meta entry-catagory"><i class="fa fa-file-o"></i><a href="#">value.categories</a></span> <span class="entry-meta entry-comments"><i class="fa fa-comment-o"></i> <a href="#">value.comments</a></span> </div> </div> </li> </ul> </article> ';
}
$out .= ' </div> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_pricing($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$carousel = $data->carousel;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$items = $data->items;
$columns = $data->columns;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-pricing ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-pricing-table style1"> ';
if ($carousel !== "") {
$out .= ' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-pricing-carousel ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
foreach ( $items as $val ) {
$out .= ' <div class="mpl-pricing-box text-center mpl-box-shadow ';
$out .= $val->featured;
$out .= '"> <div class="mpl-pricing-title">';
$out .= $val->title;
$out .= '</div> <div class="mpl-pricing-tag"> <span class="currency">';
$out .= $val->currency;
$out .= '</span><span class="price">';
$out .= $val->price;
$out .= '</span><span class="unit">';
$out .= $val->unit;
$out .= '</span> </div> <ul class="mpl-pricing-list"> ';
$out .= $val->list;
$out .= ' </ul> <div class="mpl-pricing-action"> ';
if ($val->btn_text !== "") {
$out .= ' <a href="';
$out .= $val->btn_link;
$out .= '" target="';
$out .= $val->btn_target;
$out .= '"><span class="mpl-btn-normal ';
$out .= $val->dark;
$out .= '">';
$out .= $val->btn_text;
$out .= '</span></a> ';
}
$out .= ' </div> </div> ';
}
$out .= ' </div> </div> ';
} else {
$out .= ' <ul class="mpl-list-md-';
$out .= $columns;
$out .= '"> ';
foreach ( $items as $val ) {
$out .= ' <li> <div class="mpl-pricing-box text-center mpl-box-shadow ';
$out .= $val->featured;
$out .= '"> <div class="mpl-pricing-title">';
$out .= $val->title;
$out .= '</div> <div class="mpl-pricing-tag"> <span class="currency">';
$out .= $val->currency;
$out .= '</span><span class="price">';
$out .= $val->price;
$out .= '</span><span class="unit">';
$out .= $val->unit;
$out .= '</span> </div> <ul class="mpl-pricing-list"> ';
$out .= $val->list;
$out .= ' </ul> <div class="mpl-pricing-action"> ';
if ($val->btn_text !== "") {
$out .= ' <a href="';
$out .= $val->btn_link;
$out .= '" target="';
$out .= $val->btn_target;
$out .= '"><span class="mpl-btn-normal ';
$out .= $val->dark;
$out .= '">';
$out .= $val->btn_text;
$out .= '</span></a> ';
}
$out .= ' </div> </div> </li> ';
}
$out .= ' </ul> ';
}
$out .= ' </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_pricing_2($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$carousel = $data->carousel;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$items = $data->items;
$columns = $data->columns;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-pricing-2 ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-pricing-table style2"> ';
if ($carousel !== "") {
$out .= ' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-pricing-carousel ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
foreach ( $items as $val ) {
$out .= ' <div class="mpl-pricing-box text-center mpl-box-shadow ';
$out .= $val->featured;
$out .= '"> <div class="mpl-pricing-title"> <div class="mpl-pricing-top-icon"> <i class="fa ';
$out .= $val->icon;
$out .= '"></i> </div> ';
$out .= $val->title;
$out .= ' </div> <div class="mpl-pricing-tag"> <span class="currency">';
$out .= $val->currency;
$out .= '</span><span class="price">';
$out .= $val->price;
$out .= '</span><span class="unit">';
$out .= $val->unit;
$out .= '</span> </div> <ul class="mpl-pricing-list"> ';
$out .= $val->list;
$out .= ' </ul> <div class="mpl-pricing-action"> ';
if ($val->btn_text !== "") {
$out .= ' <a href="';
$out .= $val->btn_link;
$out .= '" target="';
$out .= $val->btn_target;
$out .= '" ';
$out .= $val->dark;
$out .= '"><span class="mpl-btn-normal>';
$out .= $val->btn_text;
$out .= '</span></a> ';
}
$out .= ' </div> </div> ';
}
$out .= ' </div> </div> ';
} else {
$out .= ' <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' full"> ';
foreach ( $items as $val ) {
$out .= ' <li> <div class="mpl-pricing-box text-center mpl-box-shadow ';
$out .= $val->featured;
$out .= '"> <div class="mpl-pricing-title"> <div class="mpl-pricing-top-icon"> <i class="fa ';
$out .= $val->icon;
$out .= '"></i> </div> ';
$out .= $val->title;
$out .= ' </div> <div class="mpl-pricing-tag"> <span class="currency">';
$out .= $val->currency;
$out .= '</span> <span class="price">';
$out .= $val->price;
$out .= '</span> <span class="unit">';
$out .= $val->unit;
$out .= '</span> </div> <ul class="mpl-pricing-list"> ';
$out .= $val->list;
$out .= ' </ul> <div class="mpl-pricing-action"> ';
if ($val->btn_text !== "") {
$out .= ' <a href="';
$out .= $val->btn_link;
$out .= '" target="';
$out .= $val->btn_target;
$out .= '"><span class="mpl-btn-normal ';
$out .= $val->dark;
$out .= '">';
$out .= $val->btn_text;
$out .= '</span></a> ';
}
$out .= ' </div> </div> </li> ';
}
$out .= ' </ul> ';
}
$out .= ' </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section> ';
echo $out;
}/*v:1*/
function mpl_tpl_section_promo($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$content_position = $data->content_position;
$image_align = $data->image_align;
$image = $data->image;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$desc = $data->desc;
$button_text = $data->button_text;
$link_url = $data->link_url;
$link_target = $data->link_target;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-promo ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> <div class="mpl-promofull ';
$out .= $content_position;
$out .= '"> <div class="mpl-promofull-img ';
$out .= $image_align;
$out .= '"> ';
if ($image !== "") {
$out .= ' <img src="';
$out .= $image;
$out .= '" alt=""> ';
}
$out .= ' </div> <div class="mpl-promofull-content"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-promo"> <div class="mpl-promo-content"> ';
$out .= $desc;
$out .= ' </div> ';
if ($button_text !== "") {
$out .= ' <a href="';
$out .= $link_url;
$out .= '" target="';
$out .= $link_target;
$out .= '"><span class="mpl-btn-normal"><span>';
$out .= $button_text;
$out .= '</span></span></a> ';
}
$out .= ' </div> </div> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_promo2_style1($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$desc = $data->desc;
$button_text = $data->button_text;
$link_url = $data->link_url;
$link_target = $data->link_target;
$image_align = $data->image_align;
$image = $data->image;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-promo-2 ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> <ul class="mpl-list-md-2"> <li> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-promo" > <div class="mpl-promo-content"> ';
$out .= $desc;
$out .= ' </div> ';
if ($button_text !== "") {
$out .= ' <a href="';
$out .= $link_url;
$out .= '" target="';
$out .= $link_target;
$out .= '"><span class="mpl-btn-normal">';
$out .= $button_text;
$out .= '</span></a> ';
}
$out .= ' </div> </div> </li> <li class="text-';
$out .= $image_align;
$out .= '"> ';
if ($image !== "") {
$out .= ' <img src="';
$out .= $image;
$out .= '" alt=""> ';
}
$out .= ' </li> </ul> </div> </div> ';
$out .= $video_background;
$out .= ' </section> ';
echo $out;
}/*v:1*/
function mpl_tpl_section_promo2_style2($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$image_align = $data->image_align;
$image = $data->image;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$desc = $data->desc;
$button_text = $data->button_text;
$link_url = $data->link_url;
$link_target = $data->link_target;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-promo-2 ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> <ul class="mpl-list-md-2"> <li class="text-';
$out .= $image_align;
$out .= '"> ';
if ($image !== "") {
$out .= ' <img src="';
$out .= $image;
$out .= '" alt=""> ';
}
$out .= ' </li> <li> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-promo" > <div class="mpl-promo-content"> ';
$out .= $desc;
$out .= ' </div> ';
if ($button_text !== "") {
$out .= ' <a href="';
$out .= $link_url;
$out .= '" target="';
$out .= $link_target;
$out .= '"><span class="mpl-btn-normal">';
$out .= $button_text;
$out .= '</span></a> ';
}
$out .= ' </div> </div> </li> </ul> </div> </div> ';
$out .= $video_background;
$out .= ' </section> ';
echo $out;
}/*v:1*/
function mpl_tpl_section_promo2_style3($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$desc = $data->desc;
$button_text = $data->button_text;
$link_url = $data->link_url;
$link_target = $data->link_target;
$image_align = $data->image_align;
$image = $data->image;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-promo-2 ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-promo text-center"> <div class="mpl-promo-content"> ';
$out .= $desc;
$out .= ' </div> ';
if ($button_text !== "") {
$out .= ' <a href="';
$out .= $link_url;
$out .= '" target="';
$out .= $link_target;
$out .= '"><span class="mpl-btn-normal">';
$out .= $button_text;
$out .= '</span></a> ';
}
$out .= ' </div> <div class="mpl-promo-image text-';
$out .= $image_align;
$out .= '"> ';
if ($image !== "") {
$out .= ' <img src="';
$out .= $image;
$out .= '" alt=""> ';
}
$out .= ' </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section> ';
echo $out;
}/*v:1*/
function mpl_tpl_section_promo2_style4($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$image_align = $data->image_align;
$image = $data->image;
$desc = $data->desc;
$button_text = $data->button_text;
$link_url = $data->link_url;
$link_target = $data->link_target;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-promo-2 ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-promo-image text-';
$out .= $image_align;
$out .= '"> ';
if ($image !== "") {
$out .= ' <img src="';
$out .= $image;
$out .= '" alt=""> ';
}
$out .= ' </div> <div class="mpl-promo text-center"> <div class="mpl-promo-content"> ';
$out .= $desc;
$out .= ' </div> ';
if ($button_text !== "") {
$out .= ' <a href="';
$out .= $link_url;
$out .= '" target="';
$out .= $link_target;
$out .= '"><span class="mpl-btn-normal">';
$out .= $button_text;
$out .= '</span></a> ';
}
$out .= ' </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section> ';
echo $out;
}/*v:1*/
function mpl_tpl_section_service_1($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$columns = $data->columns;
$services = $data->services;
$image_margin_left = $data->image_margin_left;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-service ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-services style2 text-left"> <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-sm-2"> ';
foreach ( $services as $val ) {
$out .= ' <li> <div class="mpl-feature-box"> ';
$out .= $val->icon_html;
$out .= ' <h3 class="title" ';
$out .= $image_margin_left;
$out .= '> ';
if ($val->link_url !== "") {
$out .= ' <a href="';
$out .= $val->link_url;
$out .= '" class="mpl_title_link" target="';
$out .= $val->link_target;
$out .= '">';
$out .= $val->title;
$out .= '</a> ';
} else {
$out .= ' ';
$out .= $val->title;
$out .= ' ';
}
$out .= ' </h3> <p class="desc" ';
$out .= $image_margin_left;
$out .= '>';
$out .= $val->description;
$out .= '</p> </div> </li> ';
}
$out .= ' </ul> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_service_2($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$columns = $data->columns;
$services = $data->services;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-service ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-services style1 text-center"> <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-sm-2"> ';
foreach ( $services as $val ) {
$out .= ' <li> <div class="mpl-feature-box"> ';
$out .= $val->icon_html;
$out .= ' <h3 class="title"> ';
if ($val->link_url !== "") {
$out .= ' <a href="';
$out .= $val->link_url;
$out .= '" class="mpl_title_link" target="';
$out .= $val->link_target;
$out .= '">';
$out .= $val->title;
$out .= '</a> ';
} else {
$out .= ' ';
$out .= $val->title;
$out .= ' ';
}
$out .= ' </h3> <p class="desc">';
$out .= $val->description;
$out .= '</p> </div> </li> ';
}
$out .= ' </ul> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_service_3($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$columns = $data->columns;
$services = $data->services;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-service ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-services style5 text-left"> <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-sm-2"> ';
foreach ( $services as $val ) {
$out .= ' <li> <div class="mpl-feature-box"> ';
$out .= $val->icon_html;
$out .= ' <h3 class="title"> ';
if ($val->link_url !== "") {
$out .= ' <a href="';
$out .= $val->link_url;
$out .= '" class="mpl_title_link" target="';
$out .= $val->link_target;
$out .= '">';
$out .= $val->title;
$out .= '</a> ';
} else {
$out .= ' ';
$out .= $val->title;
$out .= ' ';
}
$out .= ' </h3> <p class="desc">';
$out .= $val->description;
$out .= '</p> </div> </li> ';
}
$out .= ' </ul> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_service_4($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$columns = $data->columns;
$services = $data->services;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-service-4 ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-services style7 text-center"> <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-sm-2"> ';
foreach ( $services as $val ) {
$out .= ' <li> <div class="mpl-feature-box"> ';
$out .= $val->icon_html;
$out .= ' <h3 class="title"> ';
if ($val->link_url !== "") {
$out .= ' <a href="';
$out .= $val->link_url;
$out .= '" class="mpl_title_link" target="';
$out .= $val->link_target;
$out .= '">';
$out .= $val->title;
$out .= '</a> ';
} else {
$out .= ' ';
$out .= $val->title;
$out .= ' ';
}
$out .= ' </h3> <p class="desc">';
$out .= $val->description;
$out .= '</p> </div> </li> ';
}
$out .= ' </ul> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_service_5($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$columns = $data->columns;
$services = $data->services;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-service-5 ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-services style3 text-center"> <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-sm-2"> ';
foreach ( $services as $val ) {
$out .= ' <li> <div class="mpl-feature-box" style="border-color:';
$out .= $val->icon_color;
$out .= ';"> ';
$out .= $val->icon_html;
$out .= ' <h3 class="title"> ';
if ($val->link_url !== "") {
$out .= ' <a href="';
$out .= $val->link_url;
$out .= '" class="mpl_title_link" target="';
$out .= $val->link_target;
$out .= '">';
$out .= $val->title;
$out .= '</a> ';
} else {
$out .= ' ';
$out .= $val->title;
$out .= ' ';
}
$out .= ' </h3> <p class="desc">';
$out .= $val->description;
$out .= '</p> </div> </li> ';
}
$out .= ' </ul> </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_showcase($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$desc = $data->desc;
$button_text = $data->button_text;
$button_link = $data->button_link;
$button_target = $data->button_target;
$gallery = $data->gallery;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-showcase ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-container-fullwidth"> <div class="mpl-carousel-wrap full"> <div class="owl-carousel mpl-carousel ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> <div class="mpl-gallery-item mpl-gallery-main"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-gallery-content"> ';
$out .= $desc;
$out .= ' </div> ';
if ($button_text !== "") {
$out .= ' <a href="';
$out .= $button_link;
$out .= '" target="';
$out .= $button_target;
$out .= '"><span class="mpl-btn-normal">';
$out .= $button_text;
$out .= '</span></a> ';
}
$out .= ' </div> </div> ';
foreach ( $gallery as $val ) {
$out .= ' <div class="mpl-gallery-item" style="background-image: url(';
$out .= $val->image;
$out .= ')"> <div class="mpl-gallery-item-overlay"> <h3 class="title">';
$out .= $val->title;
$out .= '</h3> <div>';
$out .= $val->description;
$out .= '</div> </div> </div> ';
}
$out .= ' </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_skills($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$carousel = $data->carousel;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$columns = $data->columns;
$items = $data->items;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-skills ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner " id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-skill-circle-list"> ';
if ($carousel !== "") {
$out .= ' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-skills-carousel ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
} else {
$out .= ' <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-sm-2 mpl-skills-normal"> ';
}
$out .= ' ';
foreach ( $items as $val ) {
$out .= ' ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' <li> ';
}
$out .= ' <div class="mpl-skill"> <div class="skill-wrap"> <div class="skill-circle mpl-skill-circle" id="circle';
$out .= $val->i;
$out .= '" data-percent="';
$out .= $val->percent;
$out .= '" data-barcolor="';
$out .= $val->barcolor;
$out .= '"> </div> <div class="percent">';
$out .= $val->percent;
$out .= '</div> </div> <h3 class="title">';
$out .= $val->title;
$out .= '</h3> <p class="desc">';
$out .= $val->desc;
$out .= '</p> </div> ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' </li> ';
}
$out .= ' ';
}
$out .= ' ';
if ($carousel !== "") {
$out .= ' </div> </div> ';
} else {
$out .= ' </ul> ';
}
$out .= ' </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_skills_2($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$left_promo = $data->left_promo;
$btn_link = $data->btn_link;
$btn_target = $data->btn_target;
$btn_text = $data->btn_text;
$items = $data->items;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-skills-2 ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner " id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <ul class="mpl-list-md-2"> <li> <div class="mpl-promo text-right"> <div> ';
$out .= $left_promo;
$out .= ' </div> <a href="';
$out .= $btn_link;
$out .= '" target="';
$out .= $btn_target;
$out .= '" title=""><span class="mpl-btn-normal text-center">';
$out .= $btn_text;
$out .= '</span></a> </div> </li> <li> ';
foreach ( $items as $val ) {
$out .= ' <div class="mpl-skill-list"> <div class="mpl-skill"> <h3 class="mpl-progress-title text-left">';
$out .= $val->title;
$out .= '</h3> <div class="progress"> <div class="progress-bar pull-left none-striped" role="progressbar" aria-valuenow="None Striped" aria-valuemin="0" aria-valuemax="100" style="width: ';
$out .= $val->percent;
$out .= '%;"> <div class="mpl-progress-num" >';
$out .= $val->percent;
$out .= '</div> </div> </div> </div> ';
}
$out .= ' </li> </ul> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_slider($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$mpl_slider = $data->mpl_slider;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$sliders = $data->sliders;
$section_height = $data->section_height;
$fullheight = $data->fullheight;
$out = '';$out .= '<section class="mpl-section-slider ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-carousel-wrap full"> <div class="owl-carousel mpl-carousel ';
$out .= $mpl_slider;
$out .= ' ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
foreach ( $sliders as $value ) {
$out .= ' ';
if ($value->image !== "") {
$out .= ' <div class="mpl-slider-item slide text-center" ';
$out .= $section_height;
$out .= '> <div class="text-center ';
$out .= $fullheight;
$out .= ' mpl-verticalmiddle mpl-banner-bgimage" style="background-image: url(';
$out .= $value->image;
$out .= ');"> <div class="mpl-section-content ';
$out .= $value->content_align;
$out .= '"> <div class="mpl-container"> ';
if ($value->title !== "" || $value->subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap ';
$out .= $value->content_align;
$out .= '"> ';
if ($value->title !== "") {
$out .= ' <h2 class="mpl-section-title ';
$out .= $value->title_style;
$out .= '"><span>';
$out .= $value->title;
$out .= '</span></h2> ';
}
$out .= ' ';
if ($value->subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle ">';
$out .= $value->subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
if ($value->btn_text_1 !== "" || $value->btn_text_2 !== "") {
$out .= ' <div class="mpl-button-group"> ';
if ($value->btn_text_1 !== "") {
$out .= ' <a href="';
$out .= $value->link_url_1;
$out .= '" target="';
$out .= $value->link_target_1;
$out .= '"><span class="mpl-btn-normal btn-lg">';
$out .= $value->btn_text_1;
$out .= '</span></a> ';
}
$out .= ' ';
if ($value->btn_text_2 !== "") {
$out .= ' <a href="';
$out .= $value->link_url_2;
$out .= '" target="';
$out .= $value->link_target_2;
$out .= '"><span class="mpl-btn-normal light btn-lg">';
$out .= $value->btn_text_2;
$out .= '</span></a> ';
}
$out .= ' </div> ';
}
$out .= ' </div> </div> </div> </div> </div> ';
}
$out .= ' ';
}
$out .= ' </div> </div> </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_team($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$carousel = $data->carousel;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$columns = $data->columns;
$persons = $data->persons;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-team ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> <div class="mpl-team"> ';
if ($carousel !== "") {
$out .= ' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-team-carousel ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
} else {
$out .= ' <ul class="mpl-list-md-';
$out .= $columns;
$out .= '"> ';
}
$out .= ' ';
foreach ( $persons as $value ) {
$out .= ' ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' <li> ';
}
$out .= ' <div class="mpl-person text-center"> <div class="img-box figcaption-middle text-center fade-in"> ';
if ($value->image !== "") {
$out .= ' <img src="';
$out .= $value->image;
$out .= '" alt="';
$out .= $value->name;
$out .= '"> ';
}
$out .= ' ';
if ($value->link !== "") {
$out .= ' <div class="img-overlay"> <div class="img-overlay-container"> <div class="img-overlay-content"> <div class="img-overlay-icons"> <a href="';
$out .= $value->link;
$out .= '"><i class="fa fa-link"></i></a> </div> </div> </div> </div> ';
}
$out .= ' </div> <div class="person-vcard"> ';
if ($value->name !== "") {
$out .= ' <h3 class="person-name">';
$out .= $value->name;
$out .= '</h3> ';
}
$out .= ' ';
if ($value->title !== "") {
$out .= ' <h4 class="person-title">';
$out .= $value->title;
$out .= '</h4> ';
}
$out .= ' ';
if ($value->desc !== "") {
$out .= ' <p class="person-desc">';
$out .= $value->desc;
$out .= '</p> ';
}
$out .= ' <ul class="person-social"> ';
if ($value->social_1 !== "") {
$out .= ' <li><a href="';
$out .= $value->social_1_link;
$out .= '"><i class="fa ';
$out .= $value->social_1;
$out .= '"></i></a></li> ';
}
$out .= ' ';
if ($value->social_2 !== "") {
$out .= ' <li><a href="';
$out .= $value->social_2_link;
$out .= '"><i class="fa ';
$out .= $value->social_2;
$out .= '"></i></a></li> ';
}
$out .= ' ';
if ($value->social_3 !== "") {
$out .= ' <li><a href="';
$out .= $value->social_3_link;
$out .= '"><i class="fa ';
$out .= $value->social_3;
$out .= '"></i></a></li> ';
}
$out .= ' ';
if ($value->social_4 !== "") {
$out .= ' <li><a href="';
$out .= $value->social_4_link;
$out .= '"><i class="fa ';
$out .= $value->social_4;
$out .= '"></i></a></li> ';
}
$out .= ' </ul> </div> </div> ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' </li> ';
}
$out .= ' ';
}
$out .= ' ';
if ($carousel !== "") {
$out .= ' </div> </div> ';
} else {
$out .= ' </ul> ';
}
$out .= ' </div> </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_testimonials_1($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$carousel = $data->carousel;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$columns = $data->columns;
$testimonials = $data->testimonials;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-testimonials ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
if ($carousel !== "") {
$out .= ' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-carousel-testimonials text-center ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
} else {
$out .= ' <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-testimonials"> ';
}
$out .= ' ';
foreach ( $testimonials as $val ) {
$out .= ' ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' <li class="list-item"> ';
}
$out .= ' <div class="mpl-testimonial style1"> <div class="person-vcard"> ';
if ($val->image !== "") {
$out .= ' <div class="img-box"> <img src=';
$out .= $val->image;
$out .= ' alt="';
$out .= $val->name;
$out .= '"> </div> ';
}
$out .= ' <h3 class="person-name">';
$out .= $val->name;
$out .= '</h3> <h4 class="person-title">';
$out .= $val->title;
$out .= '</h4> </div> <p class="person-desc" >';
$out .= $val->desc;
$out .= '</p> </div> ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' </li> ';
}
$out .= ' ';
}
$out .= ' ';
if ($carousel !== "") {
$out .= ' </div> </div> ';
} else {
$out .= ' </ul> ';
}
$out .= ' </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_testimonials_2($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$carousel = $data->carousel;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$columns = $data->columns;
$testimonials = $data->testimonials;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-testimonials ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
if ($carousel !== "") {
$out .= ' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-carousel-testimonials text-center ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
} else {
$out .= ' <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-testimonials"> ';
}
$out .= ' ';
foreach ( $testimonials as $val ) {
$out .= ' ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' <li class="list-item"> ';
}
$out .= ' <div class="mpl-testimonial style2"> <p class="person-desc" >';
$out .= $val->desc;
$out .= '</p> <div class="person-vcard"> ';
if ($val->image !== "") {
$out .= ' <div class="img-box"> <img src=';
$out .= $val->image;
$out .= ' alt="';
$out .= $val->name;
$out .= '"> </div> ';
}
$out .= ' <h3 class="person-name">';
$out .= $val->name;
$out .= '</h3> <h4 class="person-title">';
$out .= $val->title;
$out .= '</h4> </div> </div> ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' </li> ';
}
$out .= ' ';
}
$out .= ' ';
if ($carousel !== "") {
$out .= ' </div> </div> ';
} else {
$out .= ' </ul> ';
}
$out .= ' </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_testimonials_3($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$carousel = $data->carousel;
$owl_nav_style = $data->owl_nav_style;
$owl_options = $data->owl_options;
$columns = $data->columns;
$testimonials = $data->testimonials;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-testimonials ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
if ($carousel !== "") {
$out .= ' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-carousel-testimonials text-center ';
$out .= $owl_nav_style;
$out .= '" ';
$out .= $owl_options;
$out .= '> ';
} else {
$out .= ' <ul class="mpl-list-md-';
$out .= $columns;
$out .= ' mpl-list-testimonials"> ';
}
$out .= ' ';
foreach ( $testimonials as $val ) {
$out .= ' ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' <li class="list-item"> ';
}
$out .= ' <div class="mpl-testimonial style3"> <div class="person-vcard"> ';
if ($val->image !== "") {
$out .= ' <div class="img-box"> <img src=';
$out .= $val->image;
$out .= ' alt="';
$out .= $val->name;
$out .= '"> </div> ';
}
$out .= ' <h3 class="person-name">';
$out .= $val->name;
$out .= '</h3> <h4 class="person-title">';
$out .= $val->title;
$out .= '</h4> </div> <p class="person-desc" >';
$out .= $val->desc;
$out .= '</p> </div> ';
if ($carousel !== "") {
$out .= ' ';
} else {
$out .= ' </li> ';
}
$out .= ' ';
}
$out .= ' ';
if ($carousel !== "") {
$out .= ' </div> </div> ';
} else {
$out .= ' </ul> ';
}
$out .= ' </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}/*v:1*/
function mpl_tpl_section_woocommerce($data) {
/*$utils=this,$helpers=$utils.$helpers,*/
$section_class = $data->section_class;
$section_id = $data->section_id;
$section_title = $data->section_title;
$section_subtitle = $data->section_subtitle;
$woocommerce = $data->woocommerce;
$video_background = $data->video_background;
$out = '';$out .= '<section class="mpl-section-woocommerce ';
$out .= $section_class;
$out .= ' mpl-section mpl-section-inner" id="';
$out .= $section_id;
$out .= '"> <div class="mpl-section-content"> <div class="mpl-container" data-mpl_name="content"> ';
if ($section_title !== "" || $section_subtitle !== "") {
$out .= ' <div class="mpl-section-title-wrap text-center"> ';
if ($section_title !== "") {
$out .= ' <h2 class="mpl-section-title">';
$out .= $section_title;
$out .= '</h2> ';
}
$out .= ' ';
if ($section_subtitle !== "") {
$out .= ' <p class="mpl-section-subtitle">';
$out .= $section_subtitle;
$out .= '</p> ';
}
$out .= ' </div> ';
}
$out .= ' <div class="mpl-section-content-wrap"> ';
$out .= $woocommerce;
$out .= ' </div> </div> </div> ';
$out .= $video_background;
$out .= ' </section>';
echo $out;
}
?>