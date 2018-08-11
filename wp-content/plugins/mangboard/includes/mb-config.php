<?php
$mb_board_upload_files			= array("jpg","jpeg","png","gif","bmp","zip","ppt","xls","doc","pptx","xlsx","docx","pdf","hwp","psd","ai","mp3","txt","gz","dwg","wav","wmv","mpg","mpeg","svg");
$mb_image_upload_files			= array("jpg","jpeg","png","gif","bmp");
$mb_words								= array();
$mb_languages						= array();

$mb_table_prefix						= "mb_";


$mb_table_board_suffix				= "_board";
$mb_table_comment_suffix		= "_comment";
$mb_board_name					= "";
$mb_check_set_param				= false;
$mb_check_set_board_param		= false;

$mb_board_table_name				= "";
$mb_comment_table_name		= "";
$mb_error_message					= array();

$mb_admin_tables		= array(
	"board_options"		=> $mb_table_prefix."boards",
	"users"					=> $mb_table_prefix."users",
	"files"						=> $mb_table_prefix."files",
	"options"				=> $mb_table_prefix."options",
	"meta"					=> $mb_table_prefix."meta",
	"cookies"				=> $mb_table_prefix."cookies",
	"analytics"				=> $mb_table_prefix."analytics",
	"h_editors"				=> $mb_table_prefix."h_editors",
	"referers"				=> $mb_table_prefix."referers",
	"access_ip"				=> $mb_table_prefix."access_ip",
	"logs"					=> $mb_table_prefix."logs"
);

$mb_api_urls			= array(
	'board_api'			=> "mb_board",
	'comment_api'		=> "mb_comment",
	'user_api'			=> "mb_user",
	'heditor_api'		=> "mb_heditor",
	'template_api'		=> "mb_template",
	'custom_api'		=> "mb_custom",
	'commerce_api'	=> "mb_commerce"
);

$mb_editors							= array();
$mb_editors["N"]						= array("type"=>"N","name"=>"TextArea","script"=>"sendBoardWriteData();");
$mb_vars								= array();
$mb_tags								= array();
$mb_scripts							= array();
$mb_styles								= array();
$mb_post_url							= array();
$mb_trace								= array("start");
$mb_vars["device_type"]			= "desktop";
$mb_vars["user_agent"]				= "";
$mb_vars["pagination_type"]		= "large";
$mb_form_names					= array("board_name","category1","category2","category3","editor_type","parent_pid","parent_user_pid","board_pid","board_gid","board_reply","reply_depth","calendar_date","is_notice","is_secret","content","data_type","image_path");
$mb_send_names						= array();
$mb_user_level						= 0;
$mb_request_mode					= "Frontend";

$mb_basic_params			= array("board_name"=>"","skin_name"=>"","mode"=>"","board_action"=>"","page"=>"","board_pid"=>"","parent_pid"=>"","parent_user_pid"=>"","comment_pid"=>"","search_field"=>"fn_title","search_text"=>"","search_add_field1"=>"","search_add_text1"=>"","search_add_field2"=>"","search_add_text2"=>"","search_add_field3"=>"","search_add_text3"=>"","order_by"=>"fn_pid","order_type"=>"desc","category1"=>"","category2"=>"","category3"=>"","board_gid"=>"","board_page"=>1,"page_size"=>"","access"=>"","page_id"=>"","search_name"=>"","search_date"=>"","start_date"=>"","end_date"=>"","search_year"=>"","search_month"=>"","search_day"=>"","date_field"=>"","list_type"=>"","view_type"=>"","write_type"=>"","comment_type"=>"","calendar_date"=>"","template"=>"","mb_locale"=>"","lang"=>"","idx"=>"","step"=>"");
?>