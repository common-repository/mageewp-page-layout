/*TMODJS:{"version":"1.0.0"}*/
!function (String) {

    function template (filename, content) {
        return (
            /string|function/.test(typeof content)
            ? compile : renderFile
        )(filename, content);
    };


    var cache = template.cache = {};
    var String = this.String;

    function toString (value, type) {

        if (typeof value !== 'string') {

            type = typeof value;
            if (type === 'number') {
                value += '';
            } else if (type === 'function') {
                value = toString(value.call(value));
            } else {
                value = '';
            }
        }

        return value;

    };


    var escapeMap = {
        "<": "&#60;",
        ">": "&#62;",
        '"': "&#34;",
        "'": "&#39;",
        "&": "&#38;"
    };


    function escapeFn (s) {
        return escapeMap[s];
    }


    function escapeHTML (content) {
        return toString(content)
        .replace(/&(?![\w#]+;)|[<>"']/g, escapeFn);
    };


    var isArray = Array.isArray || function(obj) {
        return ({}).toString.call(obj) === '[object Array]';
    };


    function each (data, callback) {
        if (isArray(data)) {
            for (var i = 0, len = data.length; i < len; i++) {
                callback.call(data, data[i], i, data);
            }
        } else {
            for (i in data) {
                callback.call(data, data[i], i);
            }
        }
    };


    function resolve (from, to) {
        var DOUBLE_DOT_RE = /(\/)[^/]+\1\.\.\1/;
        //var dirname = from.replace(/^([^.])/, './$1').replace(/[^/]+$/, "");
        var dirname = ('./' + from).replace(/[^/]+$/, "");
        var filename = dirname + to;
        filename = filename.replace(/\/\.\//g, "/");
        while (filename.match(DOUBLE_DOT_RE)) {
            filename = filename.replace(DOUBLE_DOT_RE, "/");
        }
        return filename;
    };


    var utils = template.utils = {

        $helpers: {},

        $include: function (filename, data, from) {
            filename = resolve(from, filename);
            return renderFile(filename, data);
        },

        $string: toString,

        $escape: escapeHTML,

        $each: each
        
    };


    var helpers = template.helpers = utils.$helpers;


    function renderFile (filename, data) {
        var fn = template.get(filename) || showDebugInfo({
            filename: filename,
            name: 'Render Error',
            message: 'Template not found'
        });
        return data ? fn(data) : fn; 
    };


    function compile (filename, fn) {

        if (typeof fn === 'string') {
            var string = fn;
            fn = function () {
                return new String(string);
            };
        }

        var render = cache[filename] = function (data) {
            try {
                return new fn(data, filename) + '';
            } catch (e) {
                return showDebugInfo(e)();
            }
        };

        render.prototype = fn.prototype = utils;
        render.toString = function () {
            return fn + '';
        };

        return render;
    };


    function showDebugInfo (e) {

        var type = "{Template Error}";
        var message = e.stack || '';

        if (message) {
            // 利用报错堆栈信息
            message = message.split('\n').slice(0,2).join('\n');
        } else {
            // 调试版本，直接给出模板语句行
            for (var name in e) {
                message += "<" + name + ">\n" + e[name] + "\n\n";
            }  
        }

        return function () {
            if (typeof console === "object") {
                console.error(type + "\n\n" + message);
            }
            return type;
        };
    };


    template.get = function (filename) {
        return cache[filename.replace(/^\.\//, '')];
    };


    template.helper = function (name, helper) {
        helpers[name] = helper;
    };


    // RequireJS && SeaJS
    if (typeof define === 'function') {
        define(function() {
            return template;
        });

    // NodeJS
    } else if (typeof exports !== 'undefined') {
        module.exports = template;
    } else {
        this.template = template;
    }

    
    /*v:1*/
template('contact_style_1',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,contact_address=$data.contact_address,contact_email=$data.contact_email,contact_phone=$data.contact_phone,i18n_s1=$data.i18n_s1,i18n_s2=$data.i18n_s2,i18n_s3=$data.i18n_s3,i18n_s4=$data.i18n_s4,i18n_s5=$data.i18n_s5,button_text=$data.button_text,contact_receiver=$data.contact_receiver,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-contact-1 ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-contact style1"> <div class="mpl-contact-inner"> <ul class="mpl-contact-info"> ';
if(contact_address){
$out+=' <li> <i class="fa fa-map-marker"></i> <address>';
$out+=$string(contact_address);
$out+='</address> </li> ';
}
$out+=' ';
if(contact_email){
$out+=' <li> <i class="fa fa-envelope-o"></i> <a href="mailto:';
$out+=$string(contact_email);
$out+='">';
$out+=$string(contact_email);
$out+='</a> </li> ';
}
$out+=' ';
if(contact_phone){
$out+=' <li> <i class="fa fa-mobile"></i> ';
$out+=$string(contact_phone);
$out+=' </li> ';
}
$out+=' </ul> <form action="" class="mpl-contact-form"> <div class="mpl-form-group"> <label for="name" class="mpl-control-label">';
$out+=$string(i18n_s1);
$out+='</label> <input type="text" class="mpl-form-control" id="name" placeholder="';
$out+=$string(i18n_s1);
$out+=' *"> </div> <div class="mpl-form-group"> <label for="email" class="mpl-control-label sr-only">';
$out+=$string(i18n_s2);
$out+='</label> <input type="email" class="mpl-form-control" id="email" placeholder="';
$out+=$string(i18n_s2);
$out+=' *"> </div> <div class="mpl-form-group"> <label for="subject" class="mpl-control-label sr-only">';
$out+=$string(i18n_s3);
$out+='</label> <input type="text" class="mpl-form-control" id="subject" placeholder="';
$out+=$string(i18n_s3);
$out+='"> </div> <div class="mpl-form-group"> <label class="mpl-control-label" for="message">';
$out+=$string(i18n_s3);
$out+='</label> <textarea name="message" id="message" required aria-required="true" rows="3" placeholder="';
$out+=$string(i18n_s4);
$out+=' *" class="mpl-form-control" style="resize:none;"></textarea> </div> <div class="mpl-form-group"> <div class="mpl-contact-failed" style="float:left;"></div> <label class="mpl-control-label" for="submit">';
$out+=$string(i18n_s5);
$out+='</label> <input type="submit" value="';
$out+=$string(button_text);
$out+='" id="submit"> <input type="hidden" name="receiver" id="receiver" value="';
$out+=$string(contact_receiver);
$out+='"> </div> </form> </div> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('contact_style_4',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,contact_address=$data.contact_address,contact_email=$data.contact_email,contact_phone=$data.contact_phone,i18n_s1=$data.i18n_s1,i18n_s2=$data.i18n_s2,i18n_s3=$data.i18n_s3,i18n_s4=$data.i18n_s4,i18n_s5=$data.i18n_s5,button_text=$data.button_text,contact_receiver=$data.contact_receiver,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-contact-4 ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-contact style4"> <ul class="mpl-list-md-3"> <li> <ul class="mpl-contact-info"> ';
if(contact_address){
$out+=' <li> <i class="fa fa-map-marker"></i> <address >';
$out+=$string(contact_address);
$out+='</address> </li> ';
}
$out+=' ';
if(contact_email){
$out+=' <li> <i class="fa fa-envelope-o"></i> <a href="mailto:';
$out+=$string(contact_email);
$out+='" >';
$out+=$string(contact_email);
$out+='</a> </li> ';
}
$out+=' ';
if(contact_phone){
$out+=' <li> <i class="fa fa-mobile"></i> ';
$out+=$string(contact_phone);
$out+=' </li> ';
}
$out+=' </ul> </li> <li class="mpl-2x"> <form action="" class="mpl-contact-form"> <ul class="mpl-list-md-2"> <li> <div class="mpl-form-group"> <label for="name" class="mpl-control-label">';
$out+=$string(i18n_s1);
$out+='</label> <input type="text" class="mpl-form-control" id="name" placeholder="';
$out+=$string(i18n_s1);
$out+=' *"> </div> <div class="mpl-form-group"> <label for="email" class="mpl-control-label sr-only">';
$out+=$string(i18n_s2);
$out+='</label> <input type="email" class="mpl-form-control" id="email" placeholder="';
$out+=$string(i18n_s2);
$out+=' *"> </div> <div class="mpl-form-group"> <label for="subject" class="mpl-control-label sr-only">';
$out+=$string(i18n_s3);
$out+='</label> <input type="text" class="mpl-form-control" id="subject" placeholder="';
$out+=$string(i18n_s3);
$out+='"> </div> </li> <li> <div class="mpl-form-group"> <label class="mpl-control-label" for="message">';
$out+=$string(i18n_s3);
$out+='</label> <textarea name="message" id="message" required aria-required="true" rows="4" placeholder="';
$out+=$string(i18n_s4);
$out+=' *" class="mpl-form-control" style="resize:none;"></textarea> </div> <div class="mpl-form-group"> <div class="mpl-contact-failed" style="padding-bottom:15px;"></div> <label class="mpl-control-label" for="submit">';
$out+=$string(i18n_s5);
$out+='</label> <input type="submit" value="';
$out+=$string(button_text);
$out+='" id="submit"> <input type="hidden" name="receiver" id="receiver" value="';
$out+=$string(contact_receiver);
$out+='"> </div> </li> </ul> </form> </li> </ul> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('contact_style_5',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,contact_name=$data.contact_name,contact_address=$data.contact_address,contact_email=$data.contact_email,contact_phone=$data.contact_phone,i18n_s6=$data.i18n_s6,i18n_s1=$data.i18n_s1,i18n_s2=$data.i18n_s2,i18n_s3=$data.i18n_s3,i18n_s4=$data.i18n_s4,i18n_s5=$data.i18n_s5,button_text=$data.button_text,contact_receiver=$data.contact_receiver,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-contact-5 ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-contact style5"> <ul class="mpl-list-md-3 full"> <li> <ul class="mpl-contact-info"> ';
if(contact_name){
$out+=' <h3 class="title">';
$out+=$string(contact_name);
$out+='</h3> ';
}
$out+=' ';
if(contact_address){
$out+=' <li> <i class="fa fa-map-marker"></i> <address>';
$out+=$string(contact_address);
$out+='</address> </li> ';
}
$out+=' ';
if(contact_email){
$out+=' <li> <i class="fa fa-envelope-o"></i> <a href="mailto:';
$out+=$string(contact_email);
$out+='">';
$out+=$string(contact_email);
$out+='</a> </li> ';
}
$out+=' ';
if(contact_phone){
$out+=' <li > <i class="fa fa-mobile"></i> ';
$out+=$string(contact_phone);
$out+=' </li> ';
}
$out+=' </ul> </li> <li class="mpl-2x"> <form action="" class="mpl-contact-form"> <h3 class="title">';
$out+=$string(i18n_s6);
$out+='</h3> <ul class="mpl-list-md-2"> <li> <div class="mpl-form-group"> <label for="name" class="mpl-control-label sr-only">';
$out+=$string(i18n_s1);
$out+='</label> <input type="text" class="mpl-form-control" id="name" placeholder="';
$out+=$string(i18n_s1);
$out+=' *"> </div> </li> <li> <div class="mpl-form-group"> <label for="email" class="mpl-control-label sr-only">';
$out+=$string(i18n_s2);
$out+='</label> <input type="email" class="mpl-form-control" id="email" placeholder="';
$out+=$string(i18n_s2);
$out+=' *"> </div> </li> <li class="mpl-2x"> <div class="mpl-form-group"> <label for="subject" class="mpl-control-label sr-only">';
$out+=$string(i18n_s3);
$out+='</label> <input type="text" class="mpl-form-control" id="subject" placeholder="';
$out+=$string(i18n_s3);
$out+='"> </div> </li> <li class="mpl-2x"> <div class="mpl-form-group"> <label class="mpl-control-label sr-only" for="message">';
$out+=$string(i18n_s3);
$out+='</label> <textarea name="message" id="message" required aria-required="true" rows="3" placeholder="';
$out+=$string(i18n_s4);
$out+=' *" class="mpl-form-control" style="resize:none;"></textarea> </div> </li> <li class="mpl-2x text-right"> <div class="mpl-form-group"> <div class="mpl-contact-failed" style="padding-bottom:15px;"></div> <label class="mpl-control-label sr-only" for="submit">';
$out+=$string(i18n_s5);
$out+='</label> <input type="submit" value="';
$out+=$string(button_text);
$out+='" id="submit"> <input type="hidden" name="receiver" id="receiver" value="';
$out+=$string(contact_receiver);
$out+='"> </div> </li> </ul> </form> </li> </ul> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_banner',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,fullheight=$data.fullheight,section_id=$data.section_id,content_align=$data.content_align,section_title=$data.section_title,section_subtitle=$data.section_subtitle,title_style=$data.title_style,btn_text_1=$data.btn_text_1,btn_text_2=$data.btn_text_2,link_url_1=$data.link_url_1,link_target_1=$data.link_target_1,link_url_2=$data.link_url_2,link_target_2=$data.link_target_2,enable_social_icon=$data.enable_social_icon,$each=$utils.$each,social_icons=$data.social_icons,value=$data.value,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-banner ';
$out+=$string(section_class);
$out+=' ';
$out+=$string(fullheight);
$out+=' mpl-verticalmiddle mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content ';
$out+=$string(content_align);
$out+='"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap ';
$out+=$string(content_align);
$out+='"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title ';
$out+=$string(title_style);
$out+='"><span>';
$out+=$string(section_title);
$out+='</span></h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle ';
$out+=$string(content_align);
$out+='">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
if(btn_text_1 || btn_text_2){
$out+=' <div class="mpl-button-group"> ';
if(btn_text_1){
$out+=' <a href="';
$out+=$string(link_url_1);
$out+='" target="';
$out+=$string(link_target_1);
$out+='"><span class="mpl-btn-normal btn-lg">';
$out+=$string(btn_text_1);
$out+='</span></a> ';
}
$out+=' ';
if(btn_text_2){
$out+=' <a href="';
$out+=$string(link_url_2);
$out+='" target="';
$out+=$string(link_target_2);
$out+='"><span class="mpl-btn-normal light btn-lg">';
$out+=$string(btn_text_2);
$out+='</span></a> ';
}
$out+=' </div> ';
}
$out+=' ';
if(enable_social_icon){
$out+=' <ul class="mpl-social-icons"> ';
$each(social_icons,function(value,i){
$out+=' <li><a href="';
$out+=$string(value.link_url);
$out+='" target="';
$out+=$string(value.link_target);
$out+='" title="';
$out+=$string(value.link_title);
$out+='"> <i class="fa ';
$out+=$string(value.icon);
$out+='"></i></a> </li> ';
});
$out+=' </ul> ';
}
$out+=' </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_call_to_action_style1',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,text_align=$data.text_align,btn_text=$data.btn_text,btn_link_url=$data.btn_link_url,btn_link_target=$data.btn_link_target,title=$data.title,content=$data.content,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-call-to-action ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> <div class="mpl-section-content-wrap"> <div class="mpl-action-box text-';
$out+=$string(text_align);
$out+=' mpl-btn-right"> <div class="mpl-action-box-inner"> ';
if(btn_text){
$out+=' <div class="mpl-action-button"><a href="';
$out+=$string(btn_link_url);
$out+='" title="" target="';
$out+=$string(btn_link_target);
$out+='"><span class="mpl-btn-normal">';
$out+=$string(btn_text);
$out+='</span></a></div> ';
}
$out+=' <div class="mpl-action-content"> ';
if(title){
$out+=' <div class="mpl-section-title-wrap"> <h2 class="mpl-section-title">';
$out+=$string(title);
$out+='</h2> </div> ';
}
$out+=' ';
if(content){
$out+=' <div class="mpl-action-desc">';
$out+=$string(content);
$out+='</div> ';
}
$out+=' </div> </div> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section> ';
return new String($out);
});/*v:1*/
template('section_call_to_action_style2',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,text_align=$data.text_align,title=$data.title,content=$data.content,btn_text=$data.btn_text,btn_link_url=$data.btn_link_url,btn_link_target=$data.btn_link_target,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-call-to-action ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> <div class="mpl-section-content-wrap"> <div class="mpl-action-box text-';
$out+=$string(text_align);
$out+=' mpl-btn-left"> <div class="mpl-action-box-inner"> <div class="mpl-action-content"> ';
if(title){
$out+=' <div class="mpl-section-title-wrap"> <h2 class="mpl-section-title">';
$out+=$string(title);
$out+='</h2> </div> ';
}
$out+=' ';
if(content){
$out+=' <div class="mpl-action-desc">';
$out+=$string(content);
$out+='</div> ';
}
$out+=' </div> ';
if(btn_text){
$out+=' <div class="mpl-action-button"><a href="';
$out+=$string(btn_link_url);
$out+='" title="" target="';
$out+=$string(btn_link_target);
$out+='"><span class="mpl-btn-normal">';
$out+=$string(btn_text);
$out+='</span></a></div> ';
}
$out+=' </div> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section> ';
return new String($out);
});/*v:1*/
template('section_call_to_action_style3',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,text_align=$data.text_align,btn_text=$data.btn_text,btn_link_url=$data.btn_link_url,btn_link_target=$data.btn_link_target,title=$data.title,content=$data.content,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-call-to-action ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> <div class="mpl-section-content-wrap"> <div class="mpl-action-box text-';
$out+=$string(text_align);
$out+=' mpl-btn-top"> <div class="mpl-action-box-inner"> ';
if(btn_text){
$out+=' <div class="mpl-action-button"><a href="';
$out+=$string(btn_link_url);
$out+='" title="" target="';
$out+=$string(btn_link_target);
$out+='"><span class="mpl-btn-normal">';
$out+=$string(btn_text);
$out+='</span></a></div> ';
}
$out+=' <div class="mpl-action-content"> ';
if(title){
$out+=' <div class="mpl-section-title-wrap"> <h2 class="mpl-section-title">';
$out+=$string(title);
$out+='</h2> </div> ';
}
$out+=' ';
if(content){
$out+=' <div class="mpl-action-desc">';
$out+=$string(content);
$out+='</div> ';
}
$out+=' </div> </div> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section> ';
return new String($out);
});/*v:1*/
template('section_call_to_action_style4',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,text_align=$data.text_align,title=$data.title,content=$data.content,btn_text=$data.btn_text,btn_link_url=$data.btn_link_url,btn_link_target=$data.btn_link_target,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-call-to-action ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> <div class="mpl-section-content-wrap"> <div class="mpl-action-box text-';
$out+=$string(text_align);
$out+=' mpl-btn-bottom"> <div class="mpl-action-box-inner"> <div class="mpl-action-content"> ';
if(title){
$out+=' <div class="mpl-section-title-wrap"> <h2 class="mpl-section-title">';
$out+=$string(title);
$out+='</h2> </div> ';
}
$out+=' ';
if(content){
$out+=' <div class="mpl-action-desc">';
$out+=$string(content);
$out+='</div> ';
}
$out+=' </div> ';
if(btn_text){
$out+=' <div class="mpl-action-button"><a href="';
$out+=$string(btn_link_url);
$out+='" title="" target="';
$out+=$string(btn_link_target);
$out+='"><span class="mpl-btn-normal">';
$out+=$string(btn_text);
$out+='</span></a></div> ';
}
$out+=' </div> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section> ';
return new String($out);
});/*v:1*/
template('section_clients',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,carousel=$data.carousel,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,$each=$utils.$each,client=$data.client,value=$data.value,i=$data.i,columns=$data.columns,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-clients ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
if(carousel){
$out+=' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
$each(client,function(value,i){
$out+=' ';
if(value.image){
$out+=' <div class="mpl-client text-center"> <a href="';
$out+=$string(value.link);
$out+='" target="';
$out+=$string(value.target);
$out+='"><img src="';
$out+=$string(value.image);
$out+='" alt=""></a> </div> ';
}
$out+=' ';
});
$out+=' </div> </div> ';
}else{
$out+=' <div class="mpl-clients-list"> <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-sm-2 mpl-clients-normal text-center"> ';
$each(client,function(value,i){
$out+=' ';
if(value.image){
$out+=' <li> <a href="';
$out+=$string(value.link);
$out+='" target="';
$out+=$string(value.target);
$out+='"><img src="';
$out+=$string(value.image);
$out+='" alt=""></a> </li> ';
}
$out+=' ';
});
$out+=' </ul> </div> ';
}
$out+=' </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section> ';
return new String($out);
});/*v:1*/
template('section_counter',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_title=$data.section_title,section_subtitle=$data.section_subtitle,carousel=$data.carousel,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,$each=$utils.$each,counter=$data.counter,value=$data.value,i=$data.i,columns=$data.columns,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-counter ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="section_id"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
if(carousel){
$out+=' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel text-center ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
$each(counter,function(value,i){
$out+=' ';
if(value.number){
$out+=' <div class="mpl-counter-box"> <div class="mpl-counter"><span class="mpl-counter-num" >';
$out+=$string(value.number);
$out+='</span></div> <h3 class="mpl-counter-title text-center">';
$out+=$string(value.title);
$out+='</h3> </div> ';
}
$out+=' ';
});
$out+=' </div> </div> ';
}else{
$out+=' <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-counter"> ';
$each(counter,function(value,i){
$out+=' ';
if(value.number){
$out+=' <li> <div class="mpl-counter-box"> <div class="mpl-counter"><span class="mpl-counter-num" >';
$out+=$string(value.number);
$out+='</span></div> <h3 class="mpl-counter-title text-center">';
$out+=$string(value.title);
$out+='</h3> </div> </li> ';
}
$out+=' ';
});
$out+=' </ul> ';
}
$out+=' </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section> ';
return new String($out);
});/*v:1*/
template('section_custom',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,content=$data.content,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-custom ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container" data-mpl_name="content"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
$out+=$string(content);
$out+=' </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_facebook_feed',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,error=$data.error,$each=$utils.$each,error_data=$data.error_data,val=$data.val,i=$data.i,carousel=$data.carousel,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,columns=$data.columns,fb_data=$data.fb_data,value=$data.value,i18n_s1=$data.i18n_s1,video_background=$data.video_background,$out='';$out+='<section class="mpl-facebook-feed ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
if(error){
$out+=' <div class="mpl-fb-error-message"> ';
$each(error_data,function(val,i){
$out+=' ';
if(val.message){
$out+=' Error: ';
$out+=$string(val.message);
$out+=' ';
}
$out+=' ';
if(val.type){
$out+=' <br />Type: ';
$out+=$string(val.type);
$out+=' ';
}
$out+=' ';
if(val.code){
$out+=' <br />Code: ';
$out+=$string(val.code);
$out+=' ';
}
$out+=' ';
if(val.error_subcode){
$out+=' <br />Subcode: ';
$out+=$string(val.error_subcode);
$out+=' ';
}
$out+=' ';
if(val.error_msg){
$out+=' Error: ';
$out+=$string(val.error_msg);
$out+=' ';
}
$out+=' ';
if(val.error_code){
$out+=' <br />Code: ';
$out+=$string(val.error_code);
$out+=' ';
}
$out+=' ';
if(val.configuration){
$out+=' ';
$out+=$string(val.configuration);
$out+=' ';
}
$out+=' ';
if(val.no_post){
$out+=' ';
$out+=$string(val.no_post);
$out+=' ';
}
$out+=' ';
});
$out+=' </div> ';
}else{
$out+=' ';
if(carousel){
$out+=' <div class="owl-carousel mpl-carousel mpl-fb-feed mpl-fb-carousel ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
}else{
$out+=' <div class="mpl-fb-feed"> <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-sm-2 mpl-isotope"> ';
}
$out+=' ';
$each(fb_data,function(value,i){
$out+=' ';
if(carousel){
$out+=' ';
}else{
$out+=' <li class="mpl-isotope-item"> ';
}
$out+=' <div class="mpl-fb-item ';
$out+=$string(value.post_type_class);
$out+=' author-';
$out+=$string(value.author_id);
$out+='" id="mpl_mff_';
$out+=$string(value.post_id);
$out+='">  <div class="mpl-fb-author"> <a href="https://facebook.com/';
$out+=$string(value.author_form_id);
$out+='" target="_blank" title="';
$out+=$string(value.author_form_name);
$out+='"> <div class="mpl-fb-author-text"> <p class="mpl-fb-page-name">';
$out+=$string(value.author_form_name);
$out+='</p> ';
if(value.updated_time){
$out+=' <p class="mpl-fb-date">';
$out+=$string(value.author_date);
$out+='</p> ';
}
$out+=' </div> ';
if(value.author_image_url){
$out+=' <div class="mpl-fb-author-img"> <img src="';
$out+=$string(value.author_image_url);
$out+='" title="';
$out+=$string(value.author_form_name);
$out+='" alt="';
$out+=$string(value.author_form_name);
$out+='" width=40 height=40> </div> ';
}
$out+=' </a> </div>  <div class="mpl-fb-post-text"> <span class="mpl-fb-text">';
$out+=$string(value.post_text);
$out+='</span> </div>  ';
$out+=$string(value.description);
$out+='  ';
$out+=$string(value.shared_link);
$out+='  ';
$out+=$string(value.event);
$out+='  ';
$out+=$string(value.media_link);
$out+='  <div class="mpl-fb-post-links"> <a class="" href="';
$out+=$string(value.share_link);
$out+='" title="';
$out+=$string(value.share_link_text);
$out+='" target="_blank">';
$out+=$string(value.share_link_text);
$out+='</a> <div class="mpl-fb-share-container"> <span class="mpl-fb-dot">&nbsp;&middot;&nbsp;</span> <a class="mpl-fb-share-link" href="javascript:void(0);" title="Share">';
$out+=$string(i18n_s1);
$out+='</a> <p class=\'mpl-fb-share-tooltip\'> <a href=\'';
$out+=$string(value.share_facebook);
$out+='\' target=\'_blank\' class=\'cff-facebook-icon\'><i class=\'fa fa-facebook-square\'></i></a> <a href=\'';
$out+=$string(value.share_twitter);
$out+='\' target=\'_blank\' class=\'cff-twitter-icon\'><i class=\'fa fa-twitter\'></i></a> <a href=\'';
$out+=$string(value.share_google);
$out+='\' target=\'_blank\' class=\'cff-google-icon\'><i class=\'fa fa-google-plus\'></i></a> <a href=\'';
$out+=$string(value.share_linkedin);
$out+='\' target=\'_blank\' class=\'cff-linkedin-icon\'><i class=\'fa fa-linkedin\'></i></a> <a href=\'';
$out+=$string(value.share_email);
$out+='\' target=\'_blank\' class=\'cff-email-icon\'><i class=\'fa fa-envelope\'></i></a> <i class=\'fa fa-play fa-rotate-90\'></i> </p> </div> </div> </div> ';
if(carousel){
$out+=' ';
}else{
$out+=' </li> ';
}
$out+=' ';
});
$out+=' ';
if(carousel){
$out+=' ';
}else{
$out+=' </ul> ';
}
$out+=' </div> ';
}
$out+=' </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section> ';
return new String($out);
});/*v:1*/
template('section_features',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,$each=$utils.$each,features_left=$data.features_left,left_val=$data.left_val,i=$data.i,icon_shape=$data.icon_shape,feature_image=$data.feature_image,features_right=$data.features_right,right_val=$data.right_val,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-features ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <ul class="mpl-list-md-3"> <li> <div class="mpl-services style2 text-right"> <ul class="mpl-list-md-1"> ';
$each(features_left,function(left_val,i){
$out+=' <li> <div class="mpl-feature-box"> ';
if(icon_shape){
$out+=' <i class="fa ';
$out+=$string(left_val.icon);
$out+=' ';
$out+=$string(icon_shape);
$out+='" style="background-color:';
$out+=$string(left_val.icon_color);
$out+=';"></i> ';
}else{
$out+=' <i class="fa ';
$out+=$string(left_val.icon);
$out+='" style="color:';
$out+=$string(left_val.icon_color);
$out+=';"></i> ';
}
$out+=' <h3 class="title"> ';
if(left_val.link_url){
$out+=' <a href="';
$out+=$string(left_val.link_url);
$out+='" class="mpl_title_link" target="';
$out+=$string(left_val.link_target);
$out+='">';
$out+=$string(left_val.title);
$out+='</a> ';
}else{
$out+=' ';
$out+=$string(left_val.title);
$out+=' ';
}
$out+=' </h3> <p class="desc">';
$out+=$string(left_val.description);
$out+='</p> </div> </li> ';
});
$out+=' </ul> </div> </li> <li> <img src="';
$out+=$string(feature_image);
$out+='" alt=""> </li> <li> <div class="mpl-services style2 text-left"> <ul class="mpl-list-md-1"> ';
$each(features_right,function(right_val,i){
$out+=' <li> <div class="mpl-feature-box"> ';
if(icon_shape){
$out+=' <i class="fa ';
$out+=$string(right_val.icon);
$out+=' ';
$out+=$string(icon_shape);
$out+='" style="background-color:';
$out+=$string(right_val.icon_color);
$out+=';"></i> ';
}else{
$out+=' <i class="fa ';
$out+=$string(right_val.icon);
$out+='" style="color:';
$out+=$string(right_val.icon_color);
$out+=';"></i> ';
}
$out+=' <h3 class="title"> ';
if(right_val.link_url){
$out+=' <a href="';
$out+=$string(right_val.link_url);
$out+='" class="mpl_title_link" target="';
$out+=$string(right_val.link_target);
$out+='">';
$out+=$string(right_val.title);
$out+='</a> ';
}else{
$out+=' ';
$out+=$string(right_val.title);
$out+=' ';
}
$out+=' </h3> <p class="desc">';
$out+=$string(right_val.description);
$out+='</p> </div> </li> ';
});
$out+=' </ul> </div> </li> </ul> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_gallery',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,container=$data.container,section_title=$data.section_title,section_subtitle=$data.section_subtitle,carousel=$data.carousel,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,$each=$utils.$each,items=$data.items,value=$data.value,i=$data.i,lightbox=$data.lightbox,columns=$data.columns,$out='';$out+='<section class="mpl-section-gallery ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="';
$out+=$string(container);
$out+='"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
if(carousel){
$out+=' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel text-center ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
$each(items,function(value,i){
$out+=' ';
if(value.image){
$out+=' <div class="portoflio-box"> <div class="portfolio-img-box"> <div class="img-box figcaption-middle text-center fade-in"> <img src="';
$out+=$string(value.image);
$out+='" class="feature-img"> ';
if(lightbox || value.link){
$out+=' <div class="img-overlay"> <div class="img-overlay-container"> <div class="img-overlay-content"> <div class="img-overlay-icons"> ';
if(value.link){
$out+=' <a href="';
$out+=$string(value.link);
$out+='"><i class="fa fa-link"></i></a> ';
}else{
$out+=' <a href="';
$out+=$string(value.image);
$out+='" rel="prettyPhoto[pp_gal]"><i class="fa fa-arrows-alt"></i></a> ';
}
$out+=' </div> </div> </div> </div> ';
}
$out+=' </div> </div> </div> ';
}
$out+=' ';
});
$out+=' </div> </div> ';
}else{
$out+=' <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' full"> ';
$each(items,function(value,i){
$out+=' ';
if(value.image){
$out+=' <li> <div class="portoflio-box"> <div class="portfolio-img-box"> <div class="img-box figcaption-middle text-center fade-in"> <img src="';
$out+=$string(value.image);
$out+='" class="feature-img"> ';
if(lightbox || value.link){
$out+=' <div class="img-overlay"> <div class="img-overlay-container"> <div class="img-overlay-content"> <div class="img-overlay-icons"> ';
if(value.link){
$out+=' <a href="';
$out+=$string(value.link);
$out+='"><i class="fa fa-link"></i></a> ';
}else{
$out+=' <a href="';
$out+=$string(value.image);
$out+='" rel="prettyPhoto[pp_gal]"><i class="fa fa-arrows-alt"></i></a> ';
}
$out+=' </div> </div> </div> </div> ';
}
$out+=' </div> </div> </div> </li> ';
}
$out+=' ';
});
$out+=' </ul> ';
}
$out+=' </div> </div> </div> </section>';
return new String($out);
});/*v:1*/
template('section_google_map',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,container=$data.container,section_title=$data.section_title,section_subtitle=$data.section_subtitle,embed_map=$data.embed_map,$out='';$out+='<section class="mpl-google-map ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="';
$out+=$string(container);
$out+='"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class=\'mpl-google-maps\'> ';
$out+=$string(embed_map);
$out+=' </div> </div> </div> </div> </section>';
return new String($out);
});/*v:1*/
template('section_html',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,content=$data.content,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-html ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container" data-mpl_name="content"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
$out+=$string(content);
$out+=' </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_portfolio',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,container=$data.container,section_title=$data.section_title,section_subtitle=$data.section_subtitle,carousel=$data.carousel,filter=$data.filter,i18n_s1=$data.i18n_s1,$each=$utils.$each,categories=$data.categories,value=$data.value,i=$data.i,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,columns=$data.columns,full=$data.full,posts=$data.posts,pagination=$data.pagination,$out='';$out+='<section class="mpl-section-portfolio ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="';
$out+=$string(container);
$out+='"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
if(carousel){
$out+=' ';
}else{
$out+=' ';
if(filter){
$out+=' <nav class="mpl-portfolio-list-filter text-center"> <ul> <li class="active"> <span class="mpl-filter" data-filter="iso-filter-all"><a href="javascript:;">';
$out+=$string(i18n_s1);
$out+='</a></span> </li> ';
$each(categories,function(value,i){
$out+=' ';
if(value.name){
$out+=' <li> <span class="mpl-filter" data-filter="';
$out+=$string(value.slug);
$out+='"><a href="javascript:;">';
$out+=$string(value.name);
$out+='</a></span> </li> ';
}
$out+=' ';
});
$out+=' </ul> </nav> ';
}
$out+=' ';
}
$out+=' ';
if(carousel){
$out+=' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-owl-post-carousel mpl-blog-carousel mpl-blog-grid style1 list-mpl-portfolio-category ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
}else{
$out+=' <ul class="mpl-portfolio-list-wrap mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-sm-2 mpl-post-carousel-normal ';
$out+=$string(full);
$out+='"> ';
}
$out+=' ';
$each(posts,function(value,i){
$out+=' ';
if(carousel){
$out+=' ';
}else{
$out+=' <li class="mpl-portfolio-box-wrap iso-filter-all ';
$out+=$string(value.cat_slugs);
$out+='"> ';
}
$out+=' <article class="mpl-portfolio-box"> ';
if(value.thumbnail){
$out+=' <div class="mpl-portfolio-image"> <div class="img-box figcaption-middle text-center fade-in"> ';
$out+=$string(value.thumbnail);
$out+=' <div class="img-overlay"> <div class="img-overlay-container"> <div class="img-overlay-content"> <h2 class="entry-title">';
$out+=$string(value.title);
$out+='</h2> <div class="img-overlay-icons"> <a href="';
$out+=$string(value.link);
$out+='"><i class="fa fa-link"></i></a> <a href="';
$out+=$string(value.featured_image);
$out+='" rel="prettyPhoto"><i class="fa fa-search"></i></a> </div> </div> </div> </div> </div> </div> ';
}
$out+=' </article> ';
if(carousel){
$out+=' ';
}else{
$out+=' </li> ';
}
$out+=' ';
});
$out+=' ';
if(carousel){
$out+=' </div> </div> ';
}else{
$out+=' </ul> ';
}
$out+=' ';
$out+=$string(pagination);
$out+=' </div> </div> </div> </section>';
return new String($out);
});/*v:1*/
template('section_post',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,carousel=$data.carousel,post_type=$data.post_type,wrap_class=$data.wrap_class,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,columns=$data.columns,$each=$utils.$each,posts=$data.posts,value=$data.value,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-post ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
if(carousel){
$out+=' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-owl-post-carousel mpl-blog-carousel mpl-blog-grid style1 list-';
$out+=$string(post_type);
$out+=' ';
$out+=$string(wrap_class);
$out+=' ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
}else{
$out+=' <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-sm-2 mpl-post-carousel-normal mpl-isotope"> ';
}
$out+=' ';
$each(posts,function(value,i){
$out+=' ';
if(carousel){
$out+=' ';
}else{
$out+=' <li class="mpl-isotope-item"> ';
}
$out+=' <article class="item entry-box post-';
$out+=$string(value.id);
$out+='"> ';
if(value.thumbnail){
$out+=' <div class="feature-img-box"> <div class="img-box figcaption-middle text-center fade-in"> ';
$out+=$string(value.thumbnail);
$out+=' <div class="img-overlay"> <div class="img-overlay-container"> <div class="img-overlay-content"> <div class="img-overlay-icons"> <a href="';
$out+=$string(value.link);
$out+='"><i class="fa fa-link"></i></a> <a href="';
$out+=$string(value.featured_image);
$out+='" rel="prettyPhoto"><i class="fa fa-search"></i></a> </div> </div> </div> </div> </div> </div> ';
}
$out+=' <div class="entry-main"> <div class="entry-header"> ';
if(value.date){
$out+=' <div class="entry-meta entry-date"> <span class="date"> <time class="entry-date" datetime="';
$out+=$string(value.time);
$out+='">';
$out+=$string(value.date);
$out+='</time> </span> </div> ';
}
$out+=' <h3 class="entry-title"><a href="';
$out+=$string(value.title_link);
$out+='">';
$out+=$string(value.title);
$out+='</a></h3> </div> <div class="entry-summary">';
$out+=$string(value.excerpt);
$out+='</div> </div> <div class="entry-footer"> <ul class="entry-meta"> <li class="entry-author"><i class="fa fa-user"></i>';
$out+=$string(value.author_link);
$out+='</li> <li class="entry-catagory"><i class="fa fa-file-o"></i>';
$out+=$string(value.categories);
$out+='</li> <li class="entry-comments"><i class="fa fa-comment-o"></i>';
$out+=$string(value.comments);
$out+='</li> </ul> </div> </article> ';
if(carousel){
$out+=' ';
}else{
$out+=' </li> ';
}
$out+=' ';
});
$out+=' ';
if(carousel){
$out+=' </div> </div> ';
}else{
$out+=' </ul> ';
}
$out+=' </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_post_2',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,$each=$utils.$each,posts=$data.posts,value=$data.value,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-post-2 ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-carousel-wrap full"> <div class="owl-carousel mpl-carousel mpl-blog-carousel mpl-blog-grid style4 ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
$each(posts,function(value,i){
$out+=' <article class="entry-box"> <ul class="mpl-list-md-2 full"> ';
if(value.thumbnail){
$out+=' <li> <div class="feature-img-box"> <img src="';
$out+=$string(value.featured_image);
$out+='" class="feature-img"> </div> </li> ';
}
$out+=' <li> <div class="entry-main"> <div class="entry-header"> <span class="entry-meta entry-date"><i class="fa fa-clock-o"></i> <a href="#">';
$out+=$string(value.date);
$out+='</a></span> <span class="entry-meta entry-author"><i class="fa fa-user"></i> <a href="#">';
$out+=$string(value.author_link);
$out+='</a></span> </div> <h3 class="entry-title"><a href="#">';
$out+=$string(value.title);
$out+='</a></h3> <div class="entry-summary">';
$out+=$string(value.excerpt);
$out+='</div> <div class="entry-footer"> <span class="entry-meta entry-catagory"><i class="fa fa-file-o"></i><a href="#">value.categories</a></span> <span class="entry-meta entry-comments"><i class="fa fa-comment-o"></i> <a href="#">value.comments</a></span> </div> </div> </li> </ul> </article> ';
});
$out+=' </div> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_pricing',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,carousel=$data.carousel,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,$each=$utils.$each,items=$data.items,val=$data.val,i=$data.i,columns=$data.columns,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-pricing ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-pricing-table style1"> ';
if(carousel){
$out+=' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-pricing-carousel ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
$each(items,function(val,i){
$out+=' <div class="mpl-pricing-box text-center mpl-box-shadow ';
$out+=$string(val.featured);
$out+='"> <div class="mpl-pricing-title">';
$out+=$string(val.title);
$out+='</div> <div class="mpl-pricing-tag"> <span class="currency">';
$out+=$string(val.currency);
$out+='</span><span class="price">';
$out+=$string(val.price);
$out+='</span><span class="unit">';
$out+=$string(val.unit);
$out+='</span> </div> <ul class="mpl-pricing-list"> ';
$out+=$string(val.list);
$out+=' </ul> <div class="mpl-pricing-action"> ';
if(val.btn_text){
$out+=' <a href="';
$out+=$string(val.btn_link);
$out+='" target="';
$out+=$string(val.btn_target);
$out+='"><span class="mpl-btn-normal ';
$out+=$string(val.dark);
$out+='">';
$out+=$string(val.btn_text);
$out+='</span></a> ';
}
$out+=' </div> </div> ';
});
$out+=' </div> </div> ';
}else{
$out+=' <ul class="mpl-list-md-';
$out+=$string(columns);
$out+='"> ';
$each(items,function(val,i){
$out+=' <li> <div class="mpl-pricing-box text-center mpl-box-shadow ';
$out+=$string(val.featured);
$out+='"> <div class="mpl-pricing-title">';
$out+=$string(val.title);
$out+='</div> <div class="mpl-pricing-tag"> <span class="currency">';
$out+=$string(val.currency);
$out+='</span><span class="price">';
$out+=$string(val.price);
$out+='</span><span class="unit">';
$out+=$string(val.unit);
$out+='</span> </div> <ul class="mpl-pricing-list"> ';
$out+=$string(val.list);
$out+=' </ul> <div class="mpl-pricing-action"> ';
if(val.btn_text){
$out+=' <a href="';
$out+=$string(val.btn_link);
$out+='" target="';
$out+=$string(val.btn_target);
$out+='"><span class="mpl-btn-normal ';
$out+=$string(val.dark);
$out+='">';
$out+=$string(val.btn_text);
$out+='</span></a> ';
}
$out+=' </div> </div> </li> ';
});
$out+=' </ul> ';
}
$out+=' </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_pricing_2',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,carousel=$data.carousel,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,$each=$utils.$each,items=$data.items,val=$data.val,i=$data.i,columns=$data.columns,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-pricing-2 ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-pricing-table style2"> ';
if(carousel){
$out+=' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-pricing-carousel ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
$each(items,function(val,i){
$out+=' <div class="mpl-pricing-box text-center mpl-box-shadow ';
$out+=$string(val.featured);
$out+='"> <div class="mpl-pricing-title"> <div class="mpl-pricing-top-icon"> <i class="fa ';
$out+=$string(val.icon);
$out+='"></i> </div> ';
$out+=$string(val.title);
$out+=' </div> <div class="mpl-pricing-tag"> <span class="currency">';
$out+=$string(val.currency);
$out+='</span><span class="price">';
$out+=$string(val.price);
$out+='</span><span class="unit">';
$out+=$string(val.unit);
$out+='</span> </div> <ul class="mpl-pricing-list"> ';
$out+=$string(val.list);
$out+=' </ul> <div class="mpl-pricing-action"> ';
if(val.btn_text){
$out+=' <a href="';
$out+=$string(val.btn_link);
$out+='" target="';
$out+=$string(val.btn_target);
$out+='" ';
$out+=$string(val.dark);
$out+='"><span class="mpl-btn-normal>';
$out+=$string(val.btn_text);
$out+='</span></a> ';
}
$out+=' </div> </div> ';
});
$out+=' </div> </div> ';
}else{
$out+=' <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' full"> ';
$each(items,function(val,i){
$out+=' <li> <div class="mpl-pricing-box text-center mpl-box-shadow ';
$out+=$string(val.featured);
$out+='"> <div class="mpl-pricing-title"> <div class="mpl-pricing-top-icon"> <i class="fa ';
$out+=$string(val.icon);
$out+='"></i> </div> ';
$out+=$string(val.title);
$out+=' </div> <div class="mpl-pricing-tag"> <span class="currency">';
$out+=$string(val.currency);
$out+='</span> <span class="price">';
$out+=$string(val.price);
$out+='</span> <span class="unit">';
$out+=$string(val.unit);
$out+='</span> </div> <ul class="mpl-pricing-list"> ';
$out+=$string(val.list);
$out+=' </ul> <div class="mpl-pricing-action"> ';
if(val.btn_text){
$out+=' <a href="';
$out+=$string(val.btn_link);
$out+='" target="';
$out+=$string(val.btn_target);
$out+='"><span class="mpl-btn-normal ';
$out+=$string(val.dark);
$out+='">';
$out+=$string(val.btn_text);
$out+='</span></a> ';
}
$out+=' </div> </div> </li> ';
});
$out+=' </ul> ';
}
$out+=' </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section> ';
return new String($out);
});/*v:1*/
template('section_promo',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,content_position=$data.content_position,image_align=$data.image_align,image=$data.image,section_title=$data.section_title,section_subtitle=$data.section_subtitle,desc=$data.desc,button_text=$data.button_text,link_url=$data.link_url,link_target=$data.link_target,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-promo ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> <div class="mpl-promofull ';
$out+=$string(content_position);
$out+='"> <div class="mpl-promofull-img ';
$out+=$string(image_align);
$out+='"> ';
if(image){
$out+=' <img src="';
$out+=$string(image);
$out+='" alt=""> ';
}
$out+=' </div> <div class="mpl-promofull-content"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-promo"> <div class="mpl-promo-content"> ';
$out+=$string(desc);
$out+=' </div> ';
if(button_text){
$out+=' <a href="';
$out+=$string(link_url);
$out+='" target="';
$out+=$string(link_target);
$out+='"><span class="mpl-btn-normal"><span>';
$out+=$string(button_text);
$out+='</span></span></a> ';
}
$out+=' </div> </div> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_promo2_style1',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,desc=$data.desc,button_text=$data.button_text,link_url=$data.link_url,link_target=$data.link_target,image_align=$data.image_align,image=$data.image,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-promo-2 ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> <ul class="mpl-list-md-2"> <li> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-promo" > <div class="mpl-promo-content"> ';
$out+=$string(desc);
$out+=' </div> ';
if(button_text){
$out+=' <a href="';
$out+=$string(link_url);
$out+='" target="';
$out+=$string(link_target);
$out+='"><span class="mpl-btn-normal">';
$out+=$string(button_text);
$out+='</span></a> ';
}
$out+=' </div> </div> </li> <li class="text-';
$out+=$string(image_align);
$out+='"> ';
if(image){
$out+=' <img src="';
$out+=$string(image);
$out+='" alt=""> ';
}
$out+=' </li> </ul> </div> </div> ';
$out+=$string(video_background);
$out+=' </section> ';
return new String($out);
});/*v:1*/
template('section_promo2_style2',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,image_align=$data.image_align,image=$data.image,section_title=$data.section_title,section_subtitle=$data.section_subtitle,desc=$data.desc,button_text=$data.button_text,link_url=$data.link_url,link_target=$data.link_target,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-promo-2 ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> <ul class="mpl-list-md-2"> <li class="text-';
$out+=$string(image_align);
$out+='"> ';
if(image){
$out+=' <img src="';
$out+=$string(image);
$out+='" alt=""> ';
}
$out+=' </li> <li> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-promo" > <div class="mpl-promo-content"> ';
$out+=$string(desc);
$out+=' </div> ';
if(button_text){
$out+=' <a href="';
$out+=$string(link_url);
$out+='" target="';
$out+=$string(link_target);
$out+='"><span class="mpl-btn-normal">';
$out+=$string(button_text);
$out+='</span></a> ';
}
$out+=' </div> </div> </li> </ul> </div> </div> ';
$out+=$string(video_background);
$out+=' </section> ';
return new String($out);
});/*v:1*/
template('section_promo2_style3',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,desc=$data.desc,button_text=$data.button_text,link_url=$data.link_url,link_target=$data.link_target,image_align=$data.image_align,image=$data.image,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-promo-2 ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-promo text-center"> <div class="mpl-promo-content"> ';
$out+=$string(desc);
$out+=' </div> ';
if(button_text){
$out+=' <a href="';
$out+=$string(link_url);
$out+='" target="';
$out+=$string(link_target);
$out+='"><span class="mpl-btn-normal">';
$out+=$string(button_text);
$out+='</span></a> ';
}
$out+=' </div> <div class="mpl-promo-image text-';
$out+=$string(image_align);
$out+='"> ';
if(image){
$out+=' <img src="';
$out+=$string(image);
$out+='" alt=""> ';
}
$out+=' </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section> ';
return new String($out);
});/*v:1*/
template('section_promo2_style4',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,image_align=$data.image_align,image=$data.image,desc=$data.desc,button_text=$data.button_text,link_url=$data.link_url,link_target=$data.link_target,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-promo-2 ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-promo-image text-';
$out+=$string(image_align);
$out+='"> ';
if(image){
$out+=' <img src="';
$out+=$string(image);
$out+='" alt=""> ';
}
$out+=' </div> <div class="mpl-promo text-center"> <div class="mpl-promo-content"> ';
$out+=$string(desc);
$out+=' </div> ';
if(button_text){
$out+=' <a href="';
$out+=$string(link_url);
$out+='" target="';
$out+=$string(link_target);
$out+='"><span class="mpl-btn-normal">';
$out+=$string(button_text);
$out+='</span></a> ';
}
$out+=' </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section> ';
return new String($out);
});/*v:1*/
template('section_service_1',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,columns=$data.columns,$each=$utils.$each,services=$data.services,val=$data.val,i=$data.i,image_margin_left=$data.image_margin_left,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-service ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-services style2 text-left"> <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-sm-2"> ';
$each(services,function(val,i){
$out+=' <li> <div class="mpl-feature-box"> ';
$out+=$string(val.icon_html);
$out+=' <h3 class="title" ';
$out+=$string(image_margin_left);
$out+='> ';
if(val.link_url){
$out+=' <a href="';
$out+=$string(val.link_url);
$out+='" class="mpl_title_link" target="';
$out+=$string(val.link_target);
$out+='">';
$out+=$string(val.title);
$out+='</a> ';
}else{
$out+=' ';
$out+=$string(val.title);
$out+=' ';
}
$out+=' </h3> <p class="desc" ';
$out+=$string(image_margin_left);
$out+='>';
$out+=$string(val.description);
$out+='</p> </div> </li> ';
});
$out+=' </ul> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_service_2',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,columns=$data.columns,$each=$utils.$each,services=$data.services,val=$data.val,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-service ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-services style1 text-center"> <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-sm-2"> ';
$each(services,function(val,i){
$out+=' <li> <div class="mpl-feature-box"> ';
$out+=$string(val.icon_html);
$out+=' <h3 class="title"> ';
if(val.link_url){
$out+=' <a href="';
$out+=$string(val.link_url);
$out+='" class="mpl_title_link" target="';
$out+=$string(val.link_target);
$out+='">';
$out+=$string(val.title);
$out+='</a> ';
}else{
$out+=' ';
$out+=$string(val.title);
$out+=' ';
}
$out+=' </h3> <p class="desc">';
$out+=$string(val.description);
$out+='</p> </div> </li> ';
});
$out+=' </ul> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_service_3',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,columns=$data.columns,$each=$utils.$each,services=$data.services,val=$data.val,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-service ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-services style5 text-left"> <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-sm-2"> ';
$each(services,function(val,i){
$out+=' <li> <div class="mpl-feature-box"> ';
$out+=$string(val.icon_html);
$out+=' <h3 class="title"> ';
if(val.link_url){
$out+=' <a href="';
$out+=$string(val.link_url);
$out+='" class="mpl_title_link" target="';
$out+=$string(val.link_target);
$out+='">';
$out+=$string(val.title);
$out+='</a> ';
}else{
$out+=' ';
$out+=$string(val.title);
$out+=' ';
}
$out+=' </h3> <p class="desc">';
$out+=$string(val.description);
$out+='</p> </div> </li> ';
});
$out+=' </ul> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_service_4',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,columns=$data.columns,$each=$utils.$each,services=$data.services,val=$data.val,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-service-4 ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-services style7 text-center"> <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-sm-2"> ';
$each(services,function(val,i){
$out+=' <li> <div class="mpl-feature-box"> ';
$out+=$string(val.icon_html);
$out+=' <h3 class="title"> ';
if(val.link_url){
$out+=' <a href="';
$out+=$string(val.link_url);
$out+='" class="mpl_title_link" target="';
$out+=$string(val.link_target);
$out+='">';
$out+=$string(val.title);
$out+='</a> ';
}else{
$out+=' ';
$out+=$string(val.title);
$out+=' ';
}
$out+=' </h3> <p class="desc">';
$out+=$string(val.description);
$out+='</p> </div> </li> ';
});
$out+=' </ul> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_service_5',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,columns=$data.columns,$each=$utils.$each,services=$data.services,val=$data.val,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-service-5 ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-services style3 text-center"> <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-sm-2"> ';
$each(services,function(val,i){
$out+=' <li> <div class="mpl-feature-box" style="border-color:';
$out+=$string(val.icon_color);
$out+=';"> ';
$out+=$string(val.icon_html);
$out+=' <h3 class="title"> ';
if(val.link_url){
$out+=' <a href="';
$out+=$string(val.link_url);
$out+='" class="mpl_title_link" target="';
$out+=$string(val.link_target);
$out+='">';
$out+=$string(val.title);
$out+='</a> ';
}else{
$out+=' ';
$out+=$string(val.title);
$out+=' ';
}
$out+=' </h3> <p class="desc">';
$out+=$string(val.description);
$out+='</p> </div> </li> ';
});
$out+=' </ul> </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_showcase',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,section_title=$data.section_title,section_subtitle=$data.section_subtitle,desc=$data.desc,button_text=$data.button_text,button_link=$data.button_link,button_target=$data.button_target,$each=$utils.$each,gallery=$data.gallery,val=$data.val,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-showcase ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-container-fullwidth"> <div class="mpl-carousel-wrap full"> <div class="owl-carousel mpl-carousel ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> <div class="mpl-gallery-item mpl-gallery-main"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-gallery-content"> ';
$out+=$string(desc);
$out+=' </div> ';
if(button_text){
$out+=' <a href="';
$out+=$string(button_link);
$out+='" target="';
$out+=$string(button_target);
$out+='"><span class="mpl-btn-normal">';
$out+=$string(button_text);
$out+='</span></a> ';
}
$out+=' </div> </div> ';
$each(gallery,function(val,i){
$out+=' <div class="mpl-gallery-item" style="background-image: url(';
$out+=$string(val.image);
$out+=')"> <div class="mpl-gallery-item-overlay"> <h3 class="title">';
$out+=$string(val.title);
$out+='</h3> <div>';
$out+=$string(val.description);
$out+='</div> </div> </div> ';
});
$out+=' </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_skills',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,carousel=$data.carousel,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,columns=$data.columns,$each=$utils.$each,items=$data.items,val=$data.val,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-skills ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner " id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-skill-circle-list"> ';
if(carousel){
$out+=' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-skills-carousel ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
}else{
$out+=' <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-sm-2 mpl-skills-normal"> ';
}
$out+=' ';
$each(items,function(val,i){
$out+=' ';
if(carousel){
$out+=' ';
}else{
$out+=' <li> ';
}
$out+=' <div class="mpl-skill"> <div class="skill-wrap"> <div class="skill-circle mpl-skill-circle" id="circle';
$out+=$string(val.i);
$out+='" data-percent="';
$out+=$string(val.percent);
$out+='" data-barcolor="';
$out+=$string(val.barcolor);
$out+='"> </div> <div class="percent">';
$out+=$string(val.percent);
$out+='</div> </div> <h3 class="title">';
$out+=$string(val.title);
$out+='</h3> <p class="desc">';
$out+=$string(val.desc);
$out+='</p> </div> ';
if(carousel){
$out+=' ';
}else{
$out+=' </li> ';
}
$out+=' ';
});
$out+=' ';
if(carousel){
$out+=' </div> </div> ';
}else{
$out+=' </ul> ';
}
$out+=' </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_skills_2',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,left_promo=$data.left_promo,btn_link=$data.btn_link,btn_target=$data.btn_target,btn_text=$data.btn_text,$each=$utils.$each,items=$data.items,val=$data.val,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-skills-2 ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner " id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <ul class="mpl-list-md-2"> <li> <div class="mpl-promo text-right"> <div> ';
$out+=$string(left_promo);
$out+=' </div> <a href="';
$out+=$string(btn_link);
$out+='" target="';
$out+=$string(btn_target);
$out+='" title=""><span class="mpl-btn-normal text-center">';
$out+=$string(btn_text);
$out+='</span></a> </div> </li> <li> ';
$each(items,function(val,i){
$out+=' <div class="mpl-skill-list"> <div class="mpl-skill"> <h3 class="mpl-progress-title text-left">';
$out+=$string(val.title);
$out+='</h3> <div class="progress"> <div class="progress-bar pull-left none-striped" role="progressbar" aria-valuenow="None Striped" aria-valuemin="0" aria-valuemax="100" style="width: ';
$out+=$string(val.percent);
$out+='%;"> <div class="mpl-progress-num" >';
$out+=$string(val.percent);
$out+='</div> </div> </div> </div> ';
});
$out+=' </li> </ul> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_slider',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,mpl_slider=$data.mpl_slider,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,$each=$utils.$each,sliders=$data.sliders,value=$data.value,i=$data.i,section_height=$data.section_height,fullheight=$data.fullheight,$out='';$out+='<section class="mpl-section-slider ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-carousel-wrap full"> <div class="owl-carousel mpl-carousel ';
$out+=$string(mpl_slider);
$out+=' ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
$each(sliders,function(value,i){
$out+=' ';
if(value.image){
$out+=' <div class="mpl-slider-item slide text-center" ';
$out+=$string(section_height);
$out+='> <div class="text-center ';
$out+=$string(fullheight);
$out+=' mpl-verticalmiddle mpl-banner-bgimage" style="background-image: url(';
$out+=$string(value.image);
$out+=');"> <div class="mpl-section-content ';
$out+=$string(value.content_align);
$out+='"> <div class="mpl-container"> ';
if(value.title || value.subtitle){
$out+=' <div class="mpl-section-title-wrap ';
$out+=$string(value.content_align);
$out+='"> ';
if(value.title){
$out+=' <h2 class="mpl-section-title ';
$out+=$string(value.title_style);
$out+='"><span>';
$out+=$string(value.title);
$out+='</span></h2> ';
}
$out+=' ';
if(value.subtitle){
$out+=' <p class="mpl-section-subtitle ">';
$out+=$string(value.subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
if(value.btn_text_1 || value.btn_text_2){
$out+=' <div class="mpl-button-group"> ';
if(value.btn_text_1){
$out+=' <a href="';
$out+=$string(value.link_url_1);
$out+='" target="';
$out+=$string(value.link_target_1);
$out+='"><span class="mpl-btn-normal btn-lg">';
$out+=$string(value.btn_text_1);
$out+='</span></a> ';
}
$out+=' ';
if(value.btn_text_2){
$out+=' <a href="';
$out+=$string(value.link_url_2);
$out+='" target="';
$out+=$string(value.link_target_2);
$out+='"><span class="mpl-btn-normal light btn-lg">';
$out+=$string(value.btn_text_2);
$out+='</span></a> ';
}
$out+=' </div> ';
}
$out+=' </div> </div> </div> </div> </div> ';
}
$out+=' ';
});
$out+=' </div> </div> </section>';
return new String($out);
});/*v:1*/
template('section_team',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,carousel=$data.carousel,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,columns=$data.columns,$each=$utils.$each,persons=$data.persons,value=$data.value,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-team ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> <div class="mpl-team"> ';
if(carousel){
$out+=' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-team-carousel ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
}else{
$out+=' <ul class="mpl-list-md-';
$out+=$string(columns);
$out+='"> ';
}
$out+=' ';
$each(persons,function(value,i){
$out+=' ';
if(carousel){
$out+=' ';
}else{
$out+=' <li> ';
}
$out+=' <div class="mpl-person text-center"> <div class="img-box figcaption-middle text-center fade-in"> ';
if(value.image){
$out+=' <img src="';
$out+=$string(value.image);
$out+='" alt="';
$out+=$string(value.name);
$out+='"> ';
}
$out+=' ';
if(value.link){
$out+=' <div class="img-overlay"> <div class="img-overlay-container"> <div class="img-overlay-content"> <div class="img-overlay-icons"> <a href="';
$out+=$string(value.link);
$out+='"><i class="fa fa-link"></i></a> </div> </div> </div> </div> ';
}
$out+=' </div> <div class="person-vcard"> ';
if(value.name){
$out+=' <h3 class="person-name">';
$out+=$string(value.name);
$out+='</h3> ';
}
$out+=' ';
if(value.title){
$out+=' <h4 class="person-title">';
$out+=$string(value.title);
$out+='</h4> ';
}
$out+=' ';
if(value.desc){
$out+=' <p class="person-desc">';
$out+=$string(value.desc);
$out+='</p> ';
}
$out+=' <ul class="person-social"> ';
if(value.social_1){
$out+=' <li><a href="';
$out+=$string(value.social_1_link);
$out+='"><i class="fa ';
$out+=$string(value.social_1);
$out+='"></i></a></li> ';
}
$out+=' ';
if(value.social_2){
$out+=' <li><a href="';
$out+=$string(value.social_2_link);
$out+='"><i class="fa ';
$out+=$string(value.social_2);
$out+='"></i></a></li> ';
}
$out+=' ';
if(value.social_3){
$out+=' <li><a href="';
$out+=$string(value.social_3_link);
$out+='"><i class="fa ';
$out+=$string(value.social_3);
$out+='"></i></a></li> ';
}
$out+=' ';
if(value.social_4){
$out+=' <li><a href="';
$out+=$string(value.social_4_link);
$out+='"><i class="fa ';
$out+=$string(value.social_4);
$out+='"></i></a></li> ';
}
$out+=' </ul> </div> </div> ';
if(carousel){
$out+=' ';
}else{
$out+=' </li> ';
}
$out+=' ';
});
$out+=' ';
if(carousel){
$out+=' </div> </div> ';
}else{
$out+=' </ul> ';
}
$out+=' </div> </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_testimonials_1',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,carousel=$data.carousel,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,columns=$data.columns,$each=$utils.$each,testimonials=$data.testimonials,val=$data.val,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-testimonials ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
if(carousel){
$out+=' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-carousel-testimonials text-center ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
}else{
$out+=' <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-testimonials"> ';
}
$out+=' ';
$each(testimonials,function(val,i){
$out+=' ';
if(carousel){
$out+=' ';
}else{
$out+=' <li class="list-item"> ';
}
$out+=' <div class="mpl-testimonial style1"> <div class="person-vcard"> ';
if(val.image){
$out+=' <div class="img-box"> <img src=';
$out+=$string(val.image);
$out+=' alt="';
$out+=$string(val.name);
$out+='"> </div> ';
}
$out+=' <h3 class="person-name">';
$out+=$string(val.name);
$out+='</h3> <h4 class="person-title">';
$out+=$string(val.title);
$out+='</h4> </div> <p class="person-desc" >';
$out+=$string(val.desc);
$out+='</p> </div> ';
if(carousel){
$out+=' ';
}else{
$out+=' </li> ';
}
$out+=' ';
});
$out+=' ';
if(carousel){
$out+=' </div> </div> ';
}else{
$out+=' </ul> ';
}
$out+=' </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_testimonials_2',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,carousel=$data.carousel,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,columns=$data.columns,$each=$utils.$each,testimonials=$data.testimonials,val=$data.val,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-testimonials ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
if(carousel){
$out+=' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-carousel-testimonials text-center ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
}else{
$out+=' <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-testimonials"> ';
}
$out+=' ';
$each(testimonials,function(val,i){
$out+=' ';
if(carousel){
$out+=' ';
}else{
$out+=' <li class="list-item"> ';
}
$out+=' <div class="mpl-testimonial style2"> <p class="person-desc" >';
$out+=$string(val.desc);
$out+='</p> <div class="person-vcard"> ';
if(val.image){
$out+=' <div class="img-box"> <img src=';
$out+=$string(val.image);
$out+=' alt="';
$out+=$string(val.name);
$out+='"> </div> ';
}
$out+=' <h3 class="person-name">';
$out+=$string(val.name);
$out+='</h3> <h4 class="person-title">';
$out+=$string(val.title);
$out+='</h4> </div> </div> ';
if(carousel){
$out+=' ';
}else{
$out+=' </li> ';
}
$out+=' ';
});
$out+=' ';
if(carousel){
$out+=' </div> </div> ';
}else{
$out+=' </ul> ';
}
$out+=' </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_testimonials_3',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,carousel=$data.carousel,owl_nav_style=$data.owl_nav_style,owl_options=$data.owl_options,columns=$data.columns,$each=$utils.$each,testimonials=$data.testimonials,val=$data.val,i=$data.i,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-testimonials ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
if(carousel){
$out+=' <div class="mpl-carousel-wrap"> <div class="owl-carousel mpl-carousel mpl-carousel-testimonials text-center ';
$out+=$string(owl_nav_style);
$out+='" ';
$out+=$string(owl_options);
$out+='> ';
}else{
$out+=' <ul class="mpl-list-md-';
$out+=$string(columns);
$out+=' mpl-list-testimonials"> ';
}
$out+=' ';
$each(testimonials,function(val,i){
$out+=' ';
if(carousel){
$out+=' ';
}else{
$out+=' <li class="list-item"> ';
}
$out+=' <div class="mpl-testimonial style3"> <div class="person-vcard"> ';
if(val.image){
$out+=' <div class="img-box"> <img src=';
$out+=$string(val.image);
$out+=' alt="';
$out+=$string(val.name);
$out+='"> </div> ';
}
$out+=' <h3 class="person-name">';
$out+=$string(val.name);
$out+='</h3> <h4 class="person-title">';
$out+=$string(val.title);
$out+='</h4> </div> <p class="person-desc" >';
$out+=$string(val.desc);
$out+='</p> </div> ';
if(carousel){
$out+=' ';
}else{
$out+=' </li> ';
}
$out+=' ';
});
$out+=' ';
if(carousel){
$out+=' </div> </div> ';
}else{
$out+=' </ul> ';
}
$out+=' </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});/*v:1*/
template('section_woocommerce',function($data,$filename
/*``*/) {
'use strict';var $utils=this,$helpers=$utils.$helpers,$string=$utils.$string,section_class=$data.section_class,section_id=$data.section_id,section_title=$data.section_title,section_subtitle=$data.section_subtitle,woocommerce=$data.woocommerce,video_background=$data.video_background,$out='';$out+='<section class="mpl-section-woocommerce ';
$out+=$string(section_class);
$out+=' mpl-section mpl-section-inner" id="';
$out+=$string(section_id);
$out+='"> <div class="mpl-section-content"> <div class="mpl-container" data-mpl_name="content"> ';
if(section_title || section_subtitle){
$out+=' <div class="mpl-section-title-wrap text-center"> ';
if(section_title){
$out+=' <h2 class="mpl-section-title">';
$out+=$string(section_title);
$out+='</h2> ';
}
$out+=' ';
if(section_subtitle){
$out+=' <p class="mpl-section-subtitle">';
$out+=$string(section_subtitle);
$out+='</p> ';
}
$out+=' </div> ';
}
$out+=' <div class="mpl-section-content-wrap"> ';
$out+=$string(woocommerce);
$out+=' </div> </div> </div> ';
$out+=$string(video_background);
$out+=' </section>';
return new String($out);
});

}()