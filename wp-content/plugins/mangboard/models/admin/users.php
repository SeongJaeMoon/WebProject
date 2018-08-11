<?php
$desktop_model				= array();
$tablet_model				= array();
$mobile_model			= array();
$desktop_model['version']	= "1.0.0";

$desktop_model['list']		= '
{"type":"list_check","width":"50px","level":"10","class":"list_check"},
{"field":"fn_pid","name":"W_PID","width":"50px","class":"num","type":"pid","class":"pid","responsive":"mb-hide-mobile mb-hide-tablet"},
{"field":"fn_user_id","name":"W_ID","width":"","width":"100px","mobile_width":"70px","link":"view"},
{"field":"fn_user_name","name":"W_NAME","width":"100px","type":"text","mobile_width":"70px"},
{"field":"fn_user_level","name":"W_LEVEL","width":"50px","type":"select","data":"1,2,3,4,5,6,7,8,9,10","default":"1","description":""},
{"field":"fn_user_group","name":"W_GROUP","width":"70px","type":"text","responsive":"mb-hide-mobile mb-hide-tablet"},
{"field":"fn_user_email","name":"W_EMAIL","width":"170px","type":"text","responsive":"mb-show-desktop-large"},
{"field":"fn_login_count","name":"W_LOGIN","width":"40px","responsive":"mb-hide-mobile"},
{"field":"fn_write_count","name":"W_WRITE","width":"40px","responsive":"mb-hide-mobile"},
{"field":"fn_reply_count","name":"W_REPLY","width":"40px","responsive":"mb-hide-mobile"},
{"field":"fn_comment_count","name":"W_COMMENT","width":"40px","responsive":"mb-hide-mobile"},
{"field":"fn_user_point","name":"W_POINT","width":"70px","responsive":"mb-hide-mobile mb-hide-tablet"},
{"field":"fn_last_login","name":"W_JOIN_LAST_DATE","width":"130px","type":"admin_reg_date_last_login","responsive":"mb-hide-mobile mb-hide-tablet","search":"false"},
{"field":"fn_user_phone","name":"W_MOBILE","type":"search"},
{"field":"admin_btn","name":"","name_btn":"W_MODIFICATION","width":"60px","type":"admin_option_modify"}
';


$desktop_model['view']		= '
{"tpl":"tag","tag_name":"table","type":"start","name":"W_VIEW_MSG","width":"15%,*","mobile_width":"90px,*","class":"table table-view"},
{"field":"fn_user_id","name":"W_ID","width":"300px"},
{"field":"fn_user_name","name":"W_NAME","width":"300px","type":"view"},
{"field":"fn_user_state","name":"W_STATUS_MESSAGE","width":"300px"},
{"field":"fn_user_level","name":"W_LEVEL","width":"300px"},
{"field":"fn_user_group","name":"W_GROUP","width":"300px"},
{"field":"fn_user_email","name":"W_EMAIL","width":"300px"},
{"field":"fn_user_point","name":"W_POINT","width":"300px"},
{"field":"fn_user_money","name":"W_COIN","width":"300px"},
{"field":"fn_user_birthday","name":"W_DATE_OF_BIRTH","width":"300px"},
{"field":"fn_user_phone","name":"W_MOBILE","width":"300px"},
{"field":"fn_user_picture","name":"W_PHOTO","width":"60px","type":"img"},
{"field":"fn_user_messenger","name":"W_MESSENGER","width":"300px"},
{"field":"fn_user_homepage","name":"W_HOMEPAGE","width":"300px"},
{"field":"fn_user_blog","name":"W_BLOG","width":"300px"},
{"type":"user_home_address","name":"W_HOME_ADDRESS","width":"300px"},
{"field":"fn_home_tel","name":"W_HOME_NUMBER","width":"300px"},

{"field":"fn_allow_mailing","name":"W_ACCEPT_EMAIL","width":"300px"},
{"field":"fn_allow_message","name":"W_ACCEPT_MESSAGE","width":"300px"},
{"field":"fn_login_count","name":"W_LOGIN_COUNT","width":"300px"},
{"field":"fn_write_count","name":"W_WRITE_COUNT","width":"300px"},
{"field":"fn_reply_count","name":"W_REPLY_COUNT","width":"300px"},
{"field":"fn_comment_count","name":"W_COMMENT_COUNT","width":"300px"},
{"field":"fn_reg_mail","name":"W_MAIL_AUTHENTICATION","width":"300px"},
{"field":"fn_reg_date","name":"W_SING_TIME","width":"300px"},
{"field":"fn_last_login","name":"W_LAST_ACCESS_DATE","width":"300px"},
{"field":"fn_user_memo","name":"W_USER_MEMO","width":"300px"},
{"field":"fn_admin_memo","name":"W_ADMIN_MEMO","level":"10","width":"300px"},
{"tpl":"tag","tag_name":"table","type":"end"}
';


$desktop_model['write']		= '
{"tpl":"tag","tag_name":"table","type":"start","name":"W_ADIT_USER_INFO","width":"15%,*","mobile_width":"90px,*","class":"table table-write"},
{"field":"fn_user_id","name":"W_ID","width":"300px","required":"(*)","required_action":"write","unique":"","modify":"static","maxlength":"20","pattern":"pattern_en_num_4ge","pattern_error":"MSG_ID_INPUT_CHECK"},
{"field":"fn_user_name","name":"W_NAME","width":"300px","required":"(*)","maxlength":"30","pattern":"pattern_2ge","pattern_error":"MSG_NAME_INPUT_2MORE"},
{"field":"fn_passwd","name":"W_PASSWORD","width":"300px","type":"password","required":"(*)","maxlength":"16","pattern":"pattern_4ge","pattern_error":"MSG_PASSWORD_INPUT_4MORE"},
{"field":"fn_user_group","name":"W_GROUP","width":"300px","maxlength":"50"},
{"field":"fn_user_level","name":"W_LEVEL","width":"100px","type":"select","data":"1,2,3,4,5,6,7,8,9,10","default":"1","description":""},
{"field":"fn_user_email","name":"W_EMAIL","width":"300px","maxlength":"100"},
{"field":"fn_user_phone","name":"W_MOBILE","width":"300px"},
{"field":"fn_user_birthday","name":"W_DATE_OF_BIRTH","width":"300px"},
{"field":"fn_user_picture","name":"W_PHOTO","width":"200px","type":"user_picture_upload"},
{"field":"fn_user_messenger","name":"W_MESSENGER","width":"300px"},
{"field":"fn_user_homepage","name":"W_HOMEPAGE","width":"600px"},
{"field":"fn_user_blog","name":"W_BLOG","width":"600px"},
{"field":"fn_home_tel","name":"W_HOME_NUMBER","width":"300px"},
{"type":"user_address_info","name":"W_ADDRESS","width":"100%"},
{"field":"fn_user_state","name":"W_STATUS_MESSAGE","width":"600px","maxlength":"100"},
{"field":"fn_user_memo","name":"W_USER_MEMO","width":"600px","type":"textarea"},
{"field":"fn_admin_memo","name":"W_ADMIN_MEMO","level":"10","width":"600px","type":"textarea"},
{"tpl":"tag","tag_name":"table","type":"end"}
';


$tablet_model									= $desktop_model;
$mobile_model								= $desktop_model;
mbw_set_fields("select_board",$mb_fields["users"]);

mbw_set_pattern("pattern_en_num_4ge","/^[a-z]+[a-z0-9_]{3,19}$/i");
mbw_set_pattern("pattern_2ge","/^.{2,}$/");
mbw_set_pattern("pattern_4ge","/^.{4,}$/");

$mb_words["Write"]		= "W_USER_INSERT";

function mbw_user_synchronize(){	
	global $mstore;
	if(mbw_is_admin() && mbw_get_param("board_action")=="user_wp_synchronize"){
		$synchronize_count		= mbw_synchronize_wp_user_data();
		if($synchronize_count>0){
			$mstore->set_result_data(array("message"=>$synchronize_count.__MM("MSG_USER_SYNCED")));
		}else{
			$mstore->set_result_data(array("message"=>__MM("MSG_SYNC_NO_USERS")));
		}
	}
}
add_action('mbw_board_api_body', 'mbw_user_synchronize',5);

function mbw_get_synchronize_template(){
	echo '<div class="border-bottom-ccc-1" style="margin-bottom:10px !important;padding:10px 0 !important;text-align:right;">';
	echo mbw_get_btn_template(array("name"=>"W_WP_USER_SYNC","onclick"=>"sendBoardListData({'board_action':'user_wp_synchronize'})","class"=>"btn btn-default btn-search margin-left-5"));
	echo '<span class="description"><br>('.__MM('MSG_NOT_REGIST_USER_LOAD').')</span>';	
	echo '</div>';
}

if(mbw_is_admin_page()){		//어드민 페이지에서만 실행
	if(mbw_get_request_mode()=="Frontend"){		// 게시판 모드일 경우에만
		if(strtoupper(mbw_get_option("user_mode"))=="WP"){			
			add_action('mbw_board_skin_search', 'mbw_get_synchronize_template');
		}
	}
}

?>