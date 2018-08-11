<?php
$mb_fields								= array();
//회원 필드 설정
$mb_fields["users"]					= array("fn_pid"=>"pid",
											"fn_wp_user_pid"=>"wp_user_pid",
											"fn_user_id"=>"user_id",
											"fn_passwd"=>"passwd",
											"fn_user_name"=>"user_name", 
											"fn_user_state"=>"user_state",
											"fn_user_level"=>"user_level",
											"fn_user_group"=>"user_group",
											"fn_user_platform"=>"user_platform",
											"fn_user_email"=>"user_email",
											"fn_user_point"=>"user_point",
											"fn_user_money"=>"user_money",
											"fn_payment_count"=>"payment_count",
											"fn_payment_total"=>"payment_total",
											"fn_user_birthday"=>"user_birthday",
											"fn_user_phone"=>"user_phone",
											"fn_user_picture"=>"user_picture",
											"fn_user_icon"=>"user_icon",
											"fn_user_messenger"=>"user_messenger",
											"fn_user_homepage"=>"user_homepage",
											"fn_user_blog"=>"user_blog",
											"fn_user_sex"=>"user_sex",
											"fn_home_postcode"=>"home_postcode",
											"fn_home_address1"=>"home_address1",
											"fn_home_address2"=>"home_address2",
											"fn_home_tel"=>"home_tel",											
											"fn_office_postcode"=>"office_postcode",
											"fn_office_address1"=>"office_address1",
											"fn_office_address2"=>"office_address2",
											"fn_office_tel"=>"office_tel",
											"fn_office_fax"=>"office_fax",
											"fn_company_name"=>"company_name",
											"fn_job_title"=>"job_title",
											"fn_gps_latitude"=>"gps_latitude",
											"fn_gps_longitude"=>"gps_longitude",
											"fn_allow_mailing"=>"allow_mailing",
											"fn_allow_message"=>"allow_message",
											"fn_allow_sms"=>"allow_sms",
											"fn_allow_push"=>"allow_push",
											"fn_followers"=>"followers",
											"fn_following"=>"following",											
											"fn_review_count"=>"review_count",
											"fn_review_star_sum"=>"review_star_sum",
											"fn_new_memo"=>"new_memo",
											"fn_login_count"=>"login_count",
											"fn_write_count"=>"write_count",
											"fn_reply_count"=>"reply_count",
											"fn_comment_count"=>"comment_count",
											"fn_reg_mail"=>"reg_mail",
											"fn_reg_phone"=>"reg_phone",
											"fn_reg_date"=>"reg_date",
											"fn_last_login"=>"last_login",
											"fn_user_memo"=>"user_memo",
											"fn_admin_memo"=>"admin_memo",
											"fn_user_auth_key"=>"user_auth_key",
											"fn_user_access_token"=>"user_access_token",
											"fn_push_pid"=>"push_pid",
											"fn_ext1"=>"ext1",
											"fn_ext2"=>"ext2",
											"fn_ext3"=>"ext3",
											"fn_ext4"=>"ext4",
											"fn_ext5"=>"ext5",
											"fn_ext6"=>"ext6",
											"fn_ext7"=>"ext7",
											"fn_ext8"=>"ext8",
											"fn_ext9"=>"ext9",
											"fn_ext10"=>"ext10");


//파일 관리 필드
$mb_fields["files"]					= array("fn_pid"=>"pid",
											"fn_user_pid"=>"user_pid",
											"fn_user_name"=>"user_name",
											"fn_board_name"=>"board_name",
											"fn_table_name"=>"table_name",
											"fn_file_name"=>"file_name",
											"fn_file_path"=>"file_path",
											"fn_file_type"=>"file_type",
											"fn_file_caption"=>"file_caption",
											"fn_file_alt"=>"file_alt",
											"fn_file_sequence"=>"file_sequence",											
											"fn_file_description"=>"file_description",
											"fn_file_size"=>"file_size",
											"fn_reg_date"=>"reg_date",
											"fn_ip"=>"ip",
											"fn_agent"=>"agent",
											"fn_board_pid"=>"board_pid",
											"fn_is_download"=>"is_download",
											"fn_link_count"=>"link_count",
											"fn_download_count"=>"download_count");


//옵션 필드 설정
$mb_fields["options"]				= array("fn_pid"=>"pid",
											"fn_option_load"=>"option_load",
											"fn_option_category"=>"option_category",
											"fn_option_name"=>"option_name",
											"fn_option_value"=>"option_value",
											"fn_option_label"=>"option_label",
											"fn_option_title"=>"option_title",
											"fn_option_style"=>"option_style",
											"fn_option_class"=>"option_class",
											"fn_option_event"=>"option_event",
											"fn_option_attribute"=>"option_attribute",
											"fn_option_data"=>"option_data",
											"fn_option_sequence"=>"option_sequence",
											"fn_is_show"=>"is_show",
											"fn_description"=>"description",
											"fn_option_type"=>"option_type");

//옵션 필드 설정
$mb_fields["meta"]				= array("fn_pid"=>"pid",								
											"fn_meta_table"=>"meta_table",
											"fn_meta_pid"=>"meta_pid",											
											"fn_meta_key"=>"meta_key",
											"fn_meta_value"=>"meta_value");



//게시판 관리 필드
$mb_fields["board_options"]		= array("fn_pid"=>"pid",
											"fn_board_name2"=>"board_name",
											"fn_description"=>"description",
											"fn_skin_name"=>"skin_name",
											"fn_model_name"=>"model_name",
											"fn_table_link"=>"table_link",
											"fn_mobile_skin_name"=>"mobile_skin_name",
											"fn_post_id"=>"post_id",
											"fn_board_header"=>"board_header",
											"fn_board_footer"=>"board_footer",
											"fn_board_content_form"=>"board_content_form",
											"fn_editor_type"=>"editor_type",
											"fn_api_type"=>"api_type",							
											"fn_page_size"=>"page_size",
											"fn_comment_size"=>"comment_size",
											"fn_block_size"=>"block_size",
											"fn_category_type"=>"category_type",
											"fn_category_data"=>"category_data",
											"fn_use_comment"=>"use_comment",
											"fn_use_board_vote_good"=>"use_board_vote_good",
											"fn_use_board_vote_bad"=>"use_board_vote_bad",
											"fn_use_comment_vote_good"=>"use_comment_vote_good",
											"fn_use_comment_vote_bad"=>"use_comment_vote_bad",
											"fn_use_secret"=>"use_secret",
											"fn_use_notice"=>"use_notice",											
											"fn_use_list_title"=>"use_list_title",
											"fn_use_list_search"=>"use_list_search",
											"fn_list_level"=>"list_level",
											"fn_view_level"=>"view_level",											
											"fn_write_level"=>"write_level",
											"fn_reply_level"=>"reply_level",
											"fn_modify_level"=>"modify_level",
											"fn_secret_level"=>"secret_level",
											"fn_delete_level"=>"delete_level",												
											"fn_manage_level"=>"manage_level",												
											"fn_comment_level"=>"comment_level",
											"fn_point_board_read"=>"point_board_read",
											"fn_point_board_write"=>"point_board_write",
											"fn_point_board_reply"=>"point_board_reply",												
											"fn_point_comment_write"=>"point_comment_write",		
											"fn_board_type"=>"board_type",
											"fn_is_show"=>"is_show",
											"fn_reg_date"=>"reg_date",
											"fn_ext1"=>"ext1",
											"fn_ext2"=>"ext2",
											"fn_ext3"=>"ext3",
											"fn_ext4"=>"ext4",
											"fn_ext5"=>"ext5");


//게시판 필드 설정
$mb_fields["board"]				= array("fn_pid"=>"pid",
											"fn_gid"=>"gid",
											"fn_reply"=>"reply",
											"fn_reply_depth"=>"depth",
											"fn_parent_pid"=>"parent_pid",
											"fn_parent_user_pid"=>"parent_user_pid",
											"fn_level"=>"level",
											"fn_user_pid"=>"user_pid",											
											"fn_user_id"=>"user_id",
											"fn_user_name"=>"user_name",
											"fn_passwd"=>"passwd",
											"fn_email"=>"email",
											"fn_homepage"=>"homepage",
											"fn_address"=>"address",
											"fn_phone"=>"phone",
											"fn_title"=>"title",
											"fn_content"=>"content",
											"fn_text"=>"text",
											"fn_content_type"=>"content_type",
											"fn_editor_type"=>"editor_type",
											"fn_data_type"=>"data_type",

											"fn_tag"=>"tag",
											"fn_hit"=>"hit",
											"fn_category1"=>"category1",
											"fn_category2"=>"category2",
											"fn_category3"=>"category3",

											"fn_file_count"=>"file_count",											
											"fn_comment_count"=>"comment_count",											
											"fn_vote_good_count"=>"vote_good_count",
											"fn_vote_bad_count"=>"vote_bad_count",
											"fn_vote_type"=>"vote_type",											

											"fn_image_path"=>"image_path",
											"fn_is_notice"=>"is_notice",
											"fn_is_secret"=>"is_secret",		
											"fn_status"=>"status",		
											"fn_is_show"=>"is_show",
											
											"fn_ext1"=>"ext1",
											"fn_ext2"=>"ext2",
											"fn_ext3"=>"ext3",
											"fn_ext4"=>"ext4",
											"fn_ext5"=>"ext5",
											"fn_ext6"=>"ext6",
											"fn_ext7"=>"ext7",
											"fn_ext8"=>"ext8",
											"fn_ext9"=>"ext9",
											"fn_ext10"=>"ext10",

											"fn_gps_latitude"=>"gps_latitude",
											"fn_gps_longitude"=>"gps_longitude",
											"fn_site_link1"=>"site_link1",
											"fn_site_link2"=>"site_link2",
											"fn_agent"=>"agent",
											"fn_ip"=>"ip",
											"fn_modify_date"=>"modify_date",
											"fn_calendar_date"=>"calendar_date",
											"fn_reg_date"=>"reg_date");

//댓글 필드 설정
$mb_fields["comment"]			= array("fn_pid"=>"pid",
											"fn_gid"=>"gid",																		
											"fn_reply"=>"reply",
											"fn_parent_pid"=>"parent_pid",
											"fn_parent_user_pid"=>"parent_user_pid",
											"fn_user_pid"=>"user_pid",
											"fn_user_name"=>"user_name",
											"fn_is_secret"=>"is_secret",
											"fn_is_show"=>"is_show",
											"fn_passwd"=>"passwd",
											"fn_content"=>"content",
											"fn_vote_good_count"=>"vote_good_count",
											"fn_vote_bad_count"=>"vote_bad_count",
											"fn_vote_type"=>"vote_type",
											"fn_ext1"=>"ext1",
											"fn_ext2"=>"ext2",
											"fn_ext3"=>"ext3",
											"fn_ext4"=>"ext4",
											"fn_ext5"=>"ext5",
											"fn_agent"=>"agent",
											"fn_ip"=>"ip",												
											"fn_reg_date"=>"reg_date");

//에디터 필드 설정
$mb_fields["h_editors"]				= array("fn_pid"=>"pid",
											"fn_content"=>"content",																		
											"fn_color"=>"color",
											"fn_width"=>"width",
											"fn_point_x"=>"point_x",
											"fn_point_y"=>"point_y",
											"fn_alpha"=>"alpha",
											"fn_user_pid"=>"user_pid",
											"fn_user_name"=>"user_name",
											"fn_image_path"=>"image_path",
											"fn_agent"=>"agent",
											"fn_ip"=>"ip",												
											"fn_reg_date"=>"reg_date");



//cookie 필드 설정
$mb_fields["cookies"]				= array("fn_pid"=>"pid",
											"fn_board_name"=>"board_name",
											"fn_cookie_type"=>"cookie_type",
											"fn_cookie_name"=>"cookie_name",
											"fn_cookie_value"=>"cookie_value",
											"fn_user_pid"=>"user_pid",					
											"fn_user_name"=>"user_name",											
											"fn_agent"=>"agent",
											"fn_ip"=>"ip",												
											"fn_reg_date"=>"reg_date");





//log 필드 설정
$mb_fields["logs"]					= array("fn_pid"=>"pid",
											"fn_board_name"=>"board_name",
											"fn_mode"=>"mode",
											"fn_action"=>"action",
											"fn_type"=>"type",
											"fn_content"=>"content",
											"fn_user_pid"=>"user_pid",
											"fn_user_name"=>"user_name",
											"fn_agent"=>"agent",
											"fn_ip"=>"ip",												
											"fn_reg_date"=>"reg_date");



//analytics 필드 설정
$mb_fields["analytics"]				= array("fn_pid"=>"pid",
											"fn_date"=>"date",
											"fn_today_visit"=>"today_visit",
											"fn_today_join"=>"today_join",
											"fn_today_write"=>"today_write",
											"fn_today_reply"=>"today_reply",
											"fn_today_comment"=>"today_comment",
											"fn_today_upload"=>"today_upload",
											"fn_total_visit"=>"total_visit",
											"fn_today_page_view"=>"today_page_view",
											"fn_today_sales"=>"today_sales",
											"fn_today_payment_count"=>"today_payment_count",
											"fn_ext1"=>"ext1",
											"fn_ext2"=>"ext2",
											"fn_ext3"=>"ext3");


//referer 필드 설정
$mb_fields["referers"]				= array("fn_pid"=>"pid",	
											"fn_date"=>"date",
											"fn_referer_host"=>"referer_host",
											"fn_referer_url"=>"referer_url",
											"fn_agent"=>"agent",
											"fn_ip"=>"ip",												
											"fn_reg_date"=>"reg_date");

//referer 필드 설정
$mb_fields["access_ip"]				= array("fn_pid"=>"pid",	
											"fn_type"=>"type",
											"fn_ip"=>"ip",
											"fn_description"=>"description",
											"fn_reg_date"=>"reg_date");



$mb_fields["users_not_allow"]		= array("fn_pid"=>"pid",
											"fn_wp_user_pid"=>"wp_user_pid",
											"fn_user_level"=>"user_level",
											"fn_user_platform"=>"user_platform",
											"fn_user_point"=>"user_point",
											"fn_user_money"=>"user_money",
											"fn_payment_count"=>"payment_count",
											"fn_payment_total"=>"payment_total",
											"fn_new_memo"=>"new_memo",
											"fn_login_count"=>"login_count",
											"fn_write_count"=>"write_count",
											"fn_reply_count"=>"reply_count",
											"fn_comment_count"=>"comment_count",
											"fn_followers"=>"followers",
											"fn_following"=>"following",											
											"fn_review_count"=>"review_count",
											"fn_review_star_sum"=>"review_star_sum",
											"fn_reg_mail"=>"reg_mail",
											"fn_reg_phone"=>"reg_phone",
											"fn_reg_date"=>"reg_date",
											"fn_last_login"=>"last_login",											
											"fn_admin_memo"=>"admin_memo",
											"fn_user_auth_key"=>"user_auth_key",
											"fn_user_access_token"=>"user_access_token");										


//게시판 필드 설정
$mb_fields["board_not_allow"]	= array("fn_pid"=>"pid",
											"fn_hit"=>"hit",
											"fn_level"=>"level",
											"fn_file_count"=>"file_count",											
											"fn_comment_count"=>"comment_count",											
											"fn_vote_good_count"=>"vote_good_count",
											"fn_vote_bad_count"=>"vote_bad_count",
											"fn_vote_type"=>"vote_type",	
											"fn_status"=>"status",		
											"fn_agent"=>"agent",
											"fn_ip"=>"ip",
											"fn_modify_date"=>"modify_date",
											"fn_reg_date"=>"reg_date");

//댓글 필드 설정
$mb_fields["comment_not_allow"]			= array("fn_pid"=>"pid",
											"fn_vote_good_count"=>"vote_good_count",
											"fn_vote_bad_count"=>"vote_bad_count",
											"fn_vote_type"=>"vote_type",
											"fn_agent"=>"agent",
											"fn_ip"=>"ip",												
											"fn_reg_date"=>"reg_date");

?>