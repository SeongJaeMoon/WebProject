<?php
register_activation_hook(MBW_PLUGIN_FILE, 'mbw_basic_install_plugin');
 
// 테이블 생성 - Plugin 활성화 시
function mbw_basic_install_plugin(){	
	mbw_basic_install();	
	if(!is_dir(MBW_UPLOAD_PATH)){
		@mkdir(MBW_UPLOAD_PATH, 0777, true);		
		@chmod(MBW_UPLOAD_PATH, 0777);
	}	
}


function mbw_install_add_board_options($options,$name="mb_board_options"){
	$insert_prefix		= "INSERT INTO `".$name."` (`board_name`, `description`, `skin_name`, `model_name`, `table_link`, `mobile_skin_name`, `board_header`, `board_footer`, `board_content_form`, `editor_type`, `api_type`, `page_size`, `comment_size`, `block_size`, `category_type`, `category_data`, `use_board_vote_good`, `use_board_vote_bad`, `use_comment`, `use_comment_vote_good`, `use_comment_vote_bad`, `use_secret`, `use_notice`, `use_list_title`, `use_list_search`, `list_level`, `view_level`, `write_level`, `reply_level`, `delete_level`, `modify_level`, `secret_level`, `manage_level`, `comment_level`, `point_board_read`, `point_board_write`, `point_board_reply`, `point_comment_write`, `board_type`, `reg_date`, `is_show`) VALUES ";
	mbw_install_insert_query($insert_prefix,$options,$name,"board_name");
}
function mbw_install_add_options($options,$name="mb_options"){
	$insert_prefix		= "INSERT INTO `".$name."` (`option_load`, `option_category`, `option_title`, `option_name`, `option_value`, `option_data`, `option_label`, `option_class`, `option_style`, `option_event`, `option_attribute`, `option_type`, `description`) VALUES ";
	mbw_install_insert_query($insert_prefix,$options,$name,"option_name");
}
function mbw_install_add_options2($options,$name="mb_options"){
	$insert_prefix		= "INSERT INTO `".$name."` (`option_load`, `option_category`, `option_title`, `option_name`, `option_value`, `option_data`, `option_label`, `option_class`, `option_style`, `option_event`, `option_attribute`, `option_type`, `description`, `is_show`) VALUES ";
	mbw_install_insert_query($insert_prefix,$options,$name,"option_name");
}
function mbw_install_insert_query($insert_prefix,$options,$name="",$filed=""){
	global $wpdb;
	if(!empty($name)){
		$rows		= $options;	
		foreach($rows as $key=>$value){
			$row_check			= 0;
			if(!empty($filed))
				$row_check		= intval($wpdb->get_var("SELECT count(*) from ".$name." where ".$filed."='".$key."'"));
			if($row_check==0){
				$query		= $insert_prefix.$value;
				@$wpdb->query($query);
			}
		}	
	}
}

function mbw_basic_install(){
	require(MBW_PLUGIN_PATH."includes/mb-config.php");	
	require(MBW_PLUGIN_PATH."includes/mb-version.php");	
	require(MBW_PLUGIN_PATH."includes/install/schema/mb-schema.php");

	
	foreach($mb_admin_tables as $key=>$value){
		if(!empty($mb_schema[$key])) mbw_create_query($mb_admin_tables[$key],$mb_schema[$key]);
	}

	$board_options_rows							= array();
	$board_options_rows['board_options']		= "('board_options', '', 'bbs_admin', 'admin/board_options', '', '', '', '', '', 'N', 'mb', 15, 50, 10, 'TAB_AJAX', 'admin,board', 0, 0, 0, 0, 0, 0, 0, 1, 1, 8, 8, 10, 99, 10, 10, 10, 8, 0, 0, 0, 0, 0, 'admin', '2015-02-24 18:49:59', 0)";
	$board_options_rows['users']					= "('users', '', 'bbs_admin', 'admin/users', '', '', '', '', '', 'N', 'mb', 15, 50, 10, 'NONE', '', 0, 0, 0, 0, 0, 0, 0, 1, 1, 8, 8, 10, 99, 10, 10, 10, 8, 8, 0, 0, 0, 0, 'admin', '2015-02-24 18:49:59', 0)";
	$board_options_rows['files']					= "('files', '', 'bbs_admin', 'admin/files', '', '', '', '', '', 'N', 'mb', 15, 50, 10, 'NONE', '', 0, 0, 0, 0, 0, 0, 0, 1, 1, 8, 8, 99, 99, 10, 10, 10, 8, 8, 0, 0, 0, 0, 'admin', '2015-02-24 18:49:59', 0)";
	$board_options_rows['options']				= "('options', '', 'bbs_admin', 'admin/options', '', '', '', '', '', 'N', 'mb', 50, 50, 10, 'TAB_RELOAD', '', 0, 0, 0, 0, 0, 0, 0, 1, 1, 8, 8, 10, 99, 10, 10, 10, 8, 8, 0, 0, 0, 0, 'admin', '2015-02-24 18:49:59', 0)";
	$board_options_rows['h_editors']				= "('h_editors', '', 'bbs_admin', 'admin/heditors', '', '', '', '', '', 'N', 'mb', 10, 50, 10, 'NONE', '', 0, 0, 0, 0, 0, 0, 0, 1, 1, 8, 8, 99, 99, 10, 10, 10, 8, 8, 0, 0, 0, 0, 'admin', '2015-02-24 18:49:59', 0)";
	$board_options_rows['cookies']				= "('cookies', '', 'bbs_admin', 'admin/cookies', '', '', '', '', '', 'N', 'mb', 15, 50, 10, 'NONE', '', 0, 0, 0, 0, 0, 0, 0, 1, 1, 8, 8, 99, 99, 10, 10, 10, 8, 8, 0, 0, 0, 0, 'admin', '2015-02-24 18:49:59', 0)";
	$board_options_rows['logs']					= "('logs', '', 'bbs_admin', 'admin/logs', '', '', '', '', '', 'N', 'mb', 15, 50, 10, 'NONE', '', 0, 0, 0, 0, 0, 0, 0, 1, 1, 8, 8, 99, 99, 10, 10, 10, 8, 8, 0, 0, 0, 0, 'admin', '2015-02-24 18:49:59', 0)";
	$board_options_rows['analytics']				= "('analytics', '', 'bbs_admin', 'admin/analytics', '', '', '', '', '', 'N', 'mb', 15, 50, 10, 'NONE', '', 0, 0, 0, 0, 0, 0, 0, 1, 1, 8, 8, 99, 99, 10, 10, 10, 8, 8, 0, 0, 0, 0, 'admin', '2015-02-24 18:49:59', 0)";
	$board_options_rows['referers']				= "('referers', '', 'bbs_admin', 'admin/referers', '', '', '', '', '', 'N', 'mb', 15, 50, 10, 'NONE', '', 0, 0, 0, 0, 0, 0, 0, 1, 1, 8, 8, 99, 99, 10, 10, 10, 8, 8, 0, 0, 0, 0, 'admin', '2015-02-24 18:49:59', 0)";
	$board_options_rows['access_ip']			= "('access_ip', '', 'bbs_admin', 'admin/access_ip', '', '', '', '', '', 'N', 'mb', 15, 50, 10, 'NONE', '', 0, 0, 0, 0, 0, 0, 0, 1, 1, 8, 8, 10, 99, 10, 10, 10, 8, 8, 0, 0, 0, 0, 'admin', '2015-02-24 18:49:59', 0)";
	mbw_install_add_board_options($board_options_rows,$mb_admin_tables["board_options"]);

	$options_rows										= array();	
	$options_rows['mb_version']					= "('setup', 'board', 'W_MANGBOARD_VERSION', 'mb_version', '".$mb_version."', '', '', '', 'width:300px;', '', '', 'text_static', '')";
	$options_rows['db_version']					= "('setup', 'board', 'W_DB_VERSION', 'db_version', '".$mb_db_version."', '', '', '', 'width:300px;', '', '', 'text_static', '')";
	$options_rows['admin_email']					= "('setup', 'board', 'W_ADMIN_EMAIL', 'admin_email', '', '', '', '', 'width:300px;', '', '', 'text', '')";	
	$options_rows['google_analytics_id']		= "('setup', 'board', 'W_GOOGLE_ANALYTICS_ID', 'google_analytics_id', '', '', '', '', 'width:300px;', '', '', 'text', '')";
	$options_rows['naver_analytics_id']			= "('setup', 'board', 'W_NAVER_ANALYTICS_ID', 'naver_analytics_id', '', '', '', '', 'width:300px;', '', '', 'text', '')";
	$options_rows['prevent_content_copy']	= "('setup', 'board', 'W_COPY_PREVENTION', 'prevent_content_copy', '0', '1,0', 'W_ON_OFF', '', '', '', '', 'radio', '<br>MSG_COPY_MOUSE_PREVENT')";
	$options_rows['kcaptcha_mode']				= "('setup', 'board', 'W_KCAPTCHA', 'kcaptcha_mode', '2', '0,1,2', 'W_CAPTCHA_ON_OFF', '', '', '', '', 'radio', '')";
	$options_rows['admin_level']					= "('setup', 'user', 'W_ADMIN_LEVEL', 'admin_level', '10', '', '', '', 'width:100px;', 'onkeydown=\"return inputOnlyNumber(event)\"', 'maxlength=\"3\"', 'text', '<br>MSG_ADMIN_LEVEL_SET')";
	$options_rows['show_user_level']				= "('setup', 'user', 'W_USER_LEVEL_DISPLAY', 'show_user_level', '1', '1,0', 'W_ON_OFF', '', '', '', '', 'radio', '<br>MSG_USER_NAME_LEVEL_SET')";
	$options_rows['show_user_picture']			= "('setup', 'user', 'W_USER_THUMBNAILS', 'show_user_picture', '1', '1,0', 'W_ON_OFF', '', '', '', '', 'radio', '<br>MSG_USER_NAME_PHOTO_SET')";
	$options_rows['show_name_popup']		= "('setup', 'user', 'W_SHOW_USER_POP', 'show_name_popup', '1', '1,0', 'W_ON_OFF', '', '', '', '', 'radio', '<br>MSG_USER_NAME_POPUP_SET')";
	$options_rows['user_login_point']			= "('setup', 'user', 'W_LOGIN_POINT', 'user_login_point', '0', '', '', '', 'width:100px;', 'onkeydown=\"return inputOnlyNumber(event)\"', 'maxlength=\"5\"', 'text', '<br>MSG_LOGIN_POINT_SET')";
	$options_rows['user_join_point']				= "('setup', 'user', 'W_SING_UP_POINT', 'user_join_point', '0', '', '', '', 'width:100px;', 'onkeydown=\"return inputOnlyNumber(event)\"', 'maxlength=\"5\"', 'text', '<br>MSG_SING_UP_POINT_SET')";
	$options_rows['ssl_port']						= "('setup', 'board', 'W_SSL_PORT_NUM', 'ssl_port', '443', '', '', '', 'width:200px;', 'onkeydown=\"return inputOnlyNumber(event)\"', 'maxlength=\"6\"', 'text', '<br>MSG_ENTER_SSL_PORT_NUM')";
	$options_rows['ssl_domain']					= "('setup', 'board', 'W_SSL_DOMAIN', 'ssl_domain', '', '', '', '', '', '', '', 'text', '<br>MSG_ENTER_SSL_DOMAIN')";
	$options_rows['ssl_mode']						= "('setup', 'board', 'W_SSL_CERTIFICATE', 'ssl_mode', '0', '1,0', 'W_ON_OFF', '', '', '', '', 'radio', '<br>MSG_ADDRESS_CERTIFICATE')";
	$options_rows['use_seo']						= "('setup', 'board', 'W_SEO', 'use_seo', '1', '1,0', 'W_ON_OFF', '', '', '', '', 'radio', '')";

	$options_rows['upload_file_size']				= "('setup', 'file', 'W_UPLOAD_SIZE', 'upload_file_size', '2', '', '', '', 'width:100px;', '', 'maxlength=\"5\"', 'text', '<br>MSG_FILE_UPLOAD_SIZE')";
	$options_rows['make_img_small_size']		= "('setup', 'file', 'W_IMAGE_SIZE_SMALL', 'make_img_small_size', '480', '', '', '', 'width:100px;', 'onkeydown=\"return inputOnlyNumber(event)\"', 'maxlength=\"5\"', 'text', '<br>MSG_MAKE_IMAGE_SMALL_DESC')";
	$options_rows['make_img_middle_size']	= "('setup', 'file', 'W_IMAGE_SIZE_MIDDLE', 'make_img_middle_size', '0', '', '', '', 'width:100px;', 'onkeydown=\"return inputOnlyNumber(event)\"', 'maxlength=\"5\"', 'text', '<br>MSG_MAKE_IMAGE_MIDDLE_DESC')";
	$options_rows['login_log']						= "('setup', 'log', 'W_LOGIN_LOG', 'login_log', '1', '1,0', 'W_ON_OFF', '', '', '', '', 'radio', '<br>MSG_LOG_SAVE_SHOW')";
	$options_rows['point_log']						= "('setup', 'log', 'W_POINT_LOG', 'point_log', '1', '1,0', 'W_ON_OFF', '', '', '', '', 'radio', '<br>MSG_POINT_LOG_SAVE_SHOW')";
	$options_rows['error_log']						= "('setup', 'log', 'W_ERROR_LOG', 'error_log', '0', '1,0', 'W_ON_OFF', '', '', '', '', 'radio', '<br>MSG_ERROR_LOG_SHOW')";
	$options_rows['referer_log']					= "('setup', 'board', 'W_MENU_REFERER', 'referer_log', '1', '1,0', 'W_ON_OFF', '', '', '', '', 'radio', '')";
	mbw_install_add_options($options_rows,$mb_admin_tables["options"]);
}


?>