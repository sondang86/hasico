<?php
/**
 * @Copyright Copyright (C) 2009-2014
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:          Ahmad Bilal
 * Company:     Buruj Solutions
  + Contact:        www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:  Jan 11, 2009
  ^
  + Project:        JS Jobs
 * File Name:   models/jsjobs.php
  ^
 * Description: Model class for jsjobs data
  ^
 * History:     NONE
  ^
 */

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('_JEXEC') or die('Restricted access');

//header("Content-type: text/css; charset: UTF-8");
$color1 = "#4f4f4f";
$color2 = "#188fd4";
$color3 = "#ffffff";
$color4 = "#cccccc";
$color5 = "#FAFAFA";
$color6 = "#4f4f4f";
$color7 = "#e3e3e3";
$color8 = "#0a0a0a";

$css_string = "
div#js_menu_wrapper{border-top:7px solid  $color1 ;background: $color2 ;}
div#js_menu_wrapper a.js_menu_link{color: $color3 ;}
div#js_menu_wrapper a.js_menu_link:hover{background: $color3 ;color: $color2 ;}
div#js_main_wrapper a.chosen-single{color:#000;}
div#js_main_wrapper a,
div#jsjobs_module a,div#jsjobs_modulelist_databar a,
div.js_apply_loginform a{color: $color2 ;}
div#js_main_wrapper a:hover,
div#jsjobs_module a:hover,div#jsjobs_modulelist_databar a:hover,
div.js_apply_loginform a:hover{text-decoration:none;}
div#js_main_wrapper span.js_controlpanel_section_title,
div#tp_heading,
div#jsjobs_modulelist_titlebar{border-bottom:2px solid  $color2 ;color: $color2; }
div#js_main_wrapper a.js_controlpanel_link{border:1px solid  $color4 ;background: $color5 ;}
div#js_main_wrapper a.js_controlpanel_link:hover{border:1px solid  $color2 ;background: $color3 ;box-shadow:0px 0px 8px #abaeae;}
div#js_main_wrapper a.js_controlpanel_link div.js_controlpanel_link_text_wrapper span.js_controlpanel_link_title{color: $color6 }
div#js_main_wrapper a.js_controlpanel_link:hover div.js_controlpanel_link_text_wrapper span.js_controlpanel_link_title{color: $color2 }
div#js_main_wrapper a.js_controlpanel_link div.js_controlpanel_link_text_wrapper span.js_controlpanel_link_description{color: $color6 }
div#js_main_wrapper span.js_column_layout{border:1px solid $color4 ;background: $color5 }
div#js_main_wrapper span.js_column_layout:hover{background: $color2 ;box-shadow:0px 0px 8px #abaeae;}
div#js_main_wrapper span.js_column_layout a{color: $color6 ;}
div#js_main_wrapper span.js_column_layout a:hover{color: $color3 ;}
div#js_main_wrapper div.js_listing_wrapper,
div#jsjobs_module{border:1px solid  $color4 ;background: $color5 ;}
div#js_main_wrapper div.js_listing_wrapper span.js_coverletter_title{color: $color6 }
div#js_main_wrapper div.js_listing_wrapper div.js_coverletter_button_area span.js_coverletter_created{background: $color7 ;border:1px solid  $color4 ;}
div#js_main_wrapper div.js_listing_wrapper div.js_coverletter_button_area a.js_listing_icon{background: $color7 ;border:1px solid  $color4 ;}
div#js_main_wrapper div.js_listing_wrapper div.js_coverletter_button_area a.js_listing_icon:hover{background: $color2 ;}
div#js_main_wrapper span.js_job_title{background: $color1 ;color: $color3 ;}
div#js_main_wrapper div.js_job_company_logo{border:1px solid  $color4 ;}
div#js_main_wrapper div.js_job_data_wrapper span.js_job_data_title{border:1px solid  $color4 ;background: $color5 ;color: $color6 ;}
div#js_main_wrapper div.js_job_data_wrapper span.js_job_data_value{border:1px solid  $color4 ;color: $color6 ;}
div#js_main_wrapper a.js_job_button{border:1px solid  $color4 ;background: $color7 ;color: $color8 ;}
div#js_main_wrapper a.js_job_button:hover{color: $color3 ;background: $color2 ;}
div#js_main_wrapper div.js_job_share_pannel{background: $color5 ;border: 1px solid  $color4 ;}
div#js_main_wrapper span#js_job_fb_commentheading{color: $color3 ;background: $color1 ;}
div#js_main_wrapper div.js_message_button_area span.js_message_created{border-left:1px solid  $color4 ;border-right: 1px solid  $color4 ;}
div#js_main_wrapper div.js_message_button_area a.js_button_message{border:1px solid  $color4 ;background: $color7 ;color: $color8 ;}
div#js_main_wrapper div.js_message_button_area a.js_button_message:hover{color: $color3 ;background: $color2 ;}
div#js_main_wrapper div.js_listing_wrapper span.stats_data_title{border-bottom:1px solid  $color4 ;}
div#js_main_wrapper div.js_listing_wrapper span.stats_data_value{border-bottom:1px solid  $color4 ;}
div#js_main_wrapper div.js_listing_wrapper span.stats_data_title.last-child{border-bottom:0px;}
div#js_main_wrapper div.js_listing_wrapper span.stats_data_value.last-child{border-bottom:0px;}
div#js_main_wrapper div.js_job_main_wrapper{border:1px solid  $color4 ;background: $color5 ;}
div#js_main_wrapper div.js_job_filter_wrapper{border-bottom:2px solid  $color2 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_image_area div.js_job_image_wrapper{border-left:4px solid  $color2 ;background: $color7 ;}

div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_1{border-bottom:1px solid  $color4 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_1{border-bottom:1px solid  $color4 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_5{border-top:1px solid  $color4 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_1 span.js_job_title{background:none;color: $color6 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_1 span.js_job_title{background:none;color: $color6 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_3{border-top:1px solid  $color4 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_3{border-top:1px solid  $color4 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_4 a.js_job_data_button{border:1px solid  $color4 ;background: $color7 ;color: $color8 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_4 a.js_job_data_button:hover{color: $color3 ;background: $color2 ;}

div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_4 a.company_icon{border:1px solid  $color4 ;background: $color7 ;color: $color8 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_4 a.company_icon:hover{border:1px solid  $color4 ;background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.js_job_main_wrapper div.js_job_gold{background:#FFAB03;color: $color3 ;/* gold job background color */}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_featured{background:#00A0F6;color: $color3 ;/* featured job background color */}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_new{background:#7BBF00;color: $color3 ;/* new job background color */}
div#js_main_wrapper span.js_controlpanel_section_title div.js_job_new{background:#7BBF00;color: $color3 ;/* new job background color */}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_number{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.js_job_main_wrapper div.js_job_publish.publish{background:#45BD01;color: $color3 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_publish.notpublish{background:#444442;color: $color3 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_publish.expired{background:#A30903;color: $color3 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_publish.rejected{background:#E22F27;color: $color3 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_publish.pending{background:#DF9500;color: $color3 ;}

div#tellafriend.tellafriend{background:#FFFFFF;border:1px solid  $color4 ;}
div#tellafriend.tellafriend div#tellafriend_headline{background: $color1 ;color: $color3 ;border-bottom:4px solid  $color2 ;}

div#tellafriend.tellafriend div.fieldwrapper.fullwidth input[type=\"button\"].js_job_tellafreind_button{background: $color7 ;border:1px solid  $color4 ;color: $color8 ;}
div#tellafriend.tellafriend div.fieldwrapper.fullwidth input[type=\"button\"].js_job_tellafreind_button:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.js_listing_wrapper span.stats_data_value.description{background:#ffffff;border:1px solid  $color4 ;}
div#js_main_wrapper div.js_listing_wrapper.paymentmethod span.payment_method_button input.js_job_button{background: $color7 ;border:1px solid  $color4 ;color: $color8 ;}
div#js_main_wrapper div.js_listing_wrapper.paymentmethod span.payment_method_button input.js_job_button:hover{background: $color2 ;;color: $color3 ;}

div#js_main_wrapper span.js_job_title span.js_job_message_subtitle.jobseeker{border:1px solid  $color4 ;}
div#js_main_wrapper span.js_job_title span.js_job_message_subtitle.resume{border:1px solid  $color4 ;}
div#js_main_wrapper span.js_job_title span.js_job_message_subtitle.message{border:1px solid  $color4 ;}

div#js_main_wrapper div.js_job_message_subtitle span.js_job_message_jobseeker{border:1px solid  $color4 ;background: $color7 ;}
div#js_main_wrapper div.js_job_message_subtitle span.js_job_message_resume{border:1px solid  $color4 ;}
div#js_main_wrapper div.js_job_message_subtitle span.js_job_message_message{border:1px solid  $color4 ;}

div#js_main_wrapper div.js_job_message_subtitle span.js_job_message_message a.js_job_message_button{border:1px solid  $color4 ;background: $color7 ;color: $color8 ;}
div#js_main_wrapper div.js_job_message_subtitle span.js_job_message_message a.js_job_message_button:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.js_job_data_wrapper.button input.js_send_message_button{border:1px solid  $color4 ;background: $color7 ;color: $color8 ;}
div#js_main_wrapper div.js_job_data_wrapper.button input.js_send_message_button:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.js_job_message_history_wrapper.yousend{border:1px solid  $color4 ;}
div#js_main_wrapper div.js_job_message_history_wrapper.yousend div.js_job_message_right_top{background: $color5 ;border:1px solid  $color4 ;color: $color6 ;}
div#js_main_wrapper div.js_job_message_history_wrapper.yousend div.js_job_message_left_top{background: $color5 ;border:1px solid  $color4 ;color: $color6 ;}

div#js_main_wrapper div.js_job_message_history_wrapper.othersend{border:1px solid  $color2 ;}
div#js_main_wrapper div.js_job_message_history_wrapper.othersend div.js_job_message_right_top{background: $color2 ;color: $color3 ;border:1px solid  $color4 ;}
div#js_main_wrapper div.js_job_message_history_wrapper.othersend div.js_job_message_left_top{background: $color5 ;color: $color6 ;border:1px solid  $color2 ;}
div#js_main_wrapper div.js_job_full_width_data{background:#ffffff;border:1px solid  $color2 ;}

div#js_main_wrapper div#sortbylinks span a{background: $color1 ;color: $color3 ;}
div#js_main_wrapper div#sortbylinks span a.selected,
div#js_main_wrapper div#sortbylinks span a:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area a.applied_resume_button{border:1px solid  $color4 ;background: $color7 ;color: $color8 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area a.applied_resume_button:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a{background: $color7 ;color: $color8 ;border:1px solid  $color4 ;border-bottom:0px;}
div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a.selected,
div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a:hover{background: $color3 ;color: $color2 ;border:1px solid  $color2 ;border-bottom:0px;}

div#js_main_wrapper div.fieldwrapper.view div.fieldtitle{background: $color5 ;color: $color6 ;border:1px solid  $color4 ;}
div#js_main_wrapper div.fieldwrapper.view div.fieldvalue{background: $color3 ;color: $color6 ;border:1px solid  $color4 ;}

div#js_main_wrapper div.idTabs span a{background: $color7 ;color: $color8 ;border:1px solid  $color4 ;border-bottom:0px;}
div#js_main_wrapper div.idTabs span a.selected,
div#js_main_wrapper div.idTabs span a:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.js_job_main_wrapper.folderresume{border-left:4px solid  $color2 ;}

div#js_main_wrapper span.js_controlpanel_section_title span a{background: $color7 ;border:1px solid  $color4 ;color: $color8 ;}
div#js_main_wrapper span.js_controlpanel_section_title span a:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.fieldwrapper input#button.button{background: $color7 ;border:1px solid  $color4 ;color: $color8 ;}
div#js_main_wrapper div.fieldwrapper input#button.button:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_2.myresume.first-child{border-right:1px solid  $color4 ;}

div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_2.myresume div.js_job_data_2_wrapper a{border:1px solid  $color4 ;background: $color7 ;color: $color8 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_2.myresume div.js_job_data_2_wrapper a:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.js_job_main_wrapper div.js_job_image_area a.view_resume_button{background: $color7 ;border:1px solid  $color4 ;color: $color8 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_image_area a.view_resume_button:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.js_job_form_wrapper div.js_job_form_value input[type=\"text\"]{color: $color2 ;border:1px solid  $color4 ;}

div#js_main_wrapper div.js_job_form_wrapper.button input.js_job_form_button{background: $color7 ;border:1px solid  $color4 ;color: $color8 ;}
div#js_main_wrapper div.js_job_form_wrapper.button input.js_job_form_button:hover{background: $color2 ;color: $color3 ;}

div#js_jobapply_main_wrapper{border:1px solid  $color4 ;background:#FFFFFF;}
div#js_jobapply_main_wrapper span.js_job_applynow_heading{background: $color1 ;border-bottom:5px solid  $color2 ;color: $color3 ;}
div#js_main_wrapper span.js_job_applynow_heading{background: $color1 ;border-bottom:5px solid  $color2 ;color: $color3 ;}

div#js_jobapply_main_wrapper div.js_job_form_field_wrapper div.js_job_form_button input.js_job_form_button{border:1px solid  $color4 ;background: $color7 ;color: $color8 ;}
div#js_jobapply_main_wrapper div.js_job_form_field_wrapper div.js_job_form_button input.js_job_form_button:hover{background: $color2 ;color: $color3 ;}
div#js_jobapply_main_wrapper div.js_job_form_field_wrapper div.js_job_form_button a.js_job_data_button{border:1px solid  $color4 ;background: $color7 ;color: $color8 ;}
div#js_jobapply_main_wrapper div.js_job_form_field_wrapper div.js_job_form_button a.js_job_data_button:hover{background: $color2 ;color: $color3 ;}

div.js_job_error_messages_wrapper{border:1px solid #B8B8B8;background:#FDFDFD;}
div.js_job_error_messages_wrapper div.js_job_messages_data_wrapper span.js_job_messages_main_text{color:#D30907;}
div.js_job_error_messages_wrapper div.js_job_messages_data_wrapper span.js_job_messages_block_text{background:#252429;color:#ffffff;}
div.js_job_error_messages_wrapper div.js_job_messages_data_wrapper div.js_job_messages_button_wrapper a.js_job_message_button{background: $color7 ;color: $color8 ;border:1px solid  $color4 ;}
div.js_job_error_messages_wrapper div.js_job_messages_data_wrapper div.js_job_messages_button_wrapper a.js_job_message_button:hover{background: $color2 ;color: $color3 ;}

div#tp_filter_in div.js_job_filter_button_wrapper button.tp_filter_button{border:1px solid  $color4 ;background: $color7 ;color: $color8 ;}
div#tp_filter_in div.js_job_filter_button_wrapper button.tp_filter_button:hover{background: $color2 ;color: $color3 ;}

div#savesearch_form div.js_button_field input{background: $color7 ;border:1px solid  $color4 ;color: $color8 ;}
div#savesearch_form div.js_button_field input:hover{background: $color2 ;color: $color3 ;}

div#jsjobs_appliedresume_tab_search_data span.jsjobs_appliedresume_tab_search_data_text div.field input.button{background: $color7 ;border:1px solid  $color4 ;color: $color8 ;}
div#jsjobs_appliedresume_tab_search_data span.jsjobs_appliedresume_tab_search_data_text div.field input.button:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.js_job_main_wrapper div.js_job_image_area div.js_job_quick_view_wrapper a{background: $color7 ;color: $color8 ;border:1px solid  $color4 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_image_area div.js_job_quick_view_wrapper a:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_3.myjob div.js_job_data_4.myjob a{background: $color7 ;color: $color8 ;border:1px solid  $color4 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_3.myjob div.js_job_data_4.myjob a:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_3.myjob div.js_job_data_3_myjob_no a.applied_resume_button{background: $color7 ;border:1px solid  $color4 ;color: $color8 ;}
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_3.myjob div.js_job_data_3_myjob_no a.applied_resume_button:hover{background: $color2 ;color: $color3 ;}

div#js_main_wrapper span.js_controlpanel_section_title span.js_apply_view_job{border:1px solid  $color2 ;color: $color6 ;}

div#map{background:#FFFFFF;border:1px solid  $color4 ;}
div#closetag a{background: $color7 ;border:1px solid  $color4 ;color: $color8 ;}
div#closetag a:hover{background: $color2 ;color: $color3 ;}

div#jl_pagination{border:1px solid  $color4 ;background: $color5 ;}

span#jsjobs_module_heading{border-bottom:1px solid  $color4 ;}
div#jsjobs_modulelist_databar{background: $color5 ;border:1px solid  $color4 ;}
div.js_listing_wrapper.paymentmethod.text-center input.jsjobs_button{background: $color7 ;color: $color8 ;border:1px solid  $color4 ;}
div.js_listing_wrapper.paymentmethod.text-center input.jsjobs_button:hover{background: $color2 ;color: $color3 ;}
div#js_main_wrapper div.js_listing_wrapper div.js_message_title.job_message{border-right:1px solid  $color4 ;}

div#js_main_wrapper div.fieldwrapper div.fieldtitle,
div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area,
div#js_main_wrapper div.js_job_full_width_data,
div#js_main_wrapper div.js_listing_wrapper,div#jsjobs_module,div#jsjobs_modulelist_databar{color: $color6 ;}

div#personal_info_data div.resume_photo{background: $color5 ;border:1px solid  $color4 ;}
div#jsjobs_apply_visitor{border:1px solid  $color4 ;}
div#jsjobs_apply_visitor div.js_apply_loginform div.js_apply_login_30 input.js_apply_button{background: $color7 ;color: $color8 ;border:1px solid  $color4 ;}
div#jsjobs_apply_visitor div.js_apply_loginform div.js_apply_login_30 input.js_apply_button:hover{background: $color2 ;color: $color3 ;}
@media all and (max-width: 481px) {
    div#js_menu_wrapper a.js_menu_link{border-bottom:2px solid  $color3 ;}
    div#js_main_wrapper div.js_listing_wrapper span.js_coverletter_title{border-bottom:1px solid  $color4 ;}
    div#js_main_wrapper div.js_listing_wrapper div.js_coverletter_button_area span.js_coverletter_created{border:none;border-bottom:1px solid  $color4 ;}
    div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_2.myresume.first-child{border-right:0px;}
    div#js_main_wrapper div.js_listing_wrapper span.js_job_message_title{border-bottom:1px solid  $color4 ;}
    div#js_main_wrapper div.js_message_button_area span.js_message_created{border:0px;border-bottom:1px solid  $color4 ;}
    div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_4.mycompany{border-top:1px solid  $color4 ;}
    div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_3 div.js_job_data_4{border-top:1px solid  $color4 ;}
}    
";
//$document = JFactory::getDocument();
$document->addStyleDeclaration($css_string);